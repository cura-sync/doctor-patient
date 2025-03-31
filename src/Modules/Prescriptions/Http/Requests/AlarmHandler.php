<?php

namespace Modules\Prescriptions\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\Documents;
use App\Models\DPContants;
use App\Models\MedicationAlerts;
use App\Models\MedicineAlert;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AlarmHandler extends Controller
{
    /**
     * Call flask API to fetch dosage details from uploaded document
     */
    public function fetchDosage(Request $request)
    {
        $original_text = null;
        $dosage = null;

        if (!isset($request->document_name)) {
            return response()->json([
                'error' => true,
                'message' => 'Document name is required.'
            ], 400);
        }

        $document = Documents::saveDocument(Documents::TYPE_PRESCRIPTION, $request->document_name, $request->document);

        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->document_id = $document->id;
        $transaction->resource_type = Transactions::RESOURCE_DOSAGE_ALERTS;
        $transaction->created_at = now();
        $transaction->updated_at = now();
        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save transaction.'
            ], 500);
        }

        $dosage_details = $this->fetchDosageFromDocument($document->document_name);
        if (! $dosage_details) {
            return response()->json([
                'error' => true,
                'message' => 'Dosage details not found.'
            ], 400);
        }

        $original_text = $dosage_details['original_text'];
        $dosage = $dosage_details['dosage'];

        $medication_details = new MedicationAlerts();
        $medication_details->user_id = Auth::user()->id;
        $medication_details->document_id = $document->id;
        $medication_details->transaction_id = $transaction->id;
        $medication_details->fetched_medication_data = $dosage;
        $medication_details->created_at = now();
        $medication_details->updated_at = now();
        if (! $medication_details->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save alarm details.'
            ], 500);
        }

        $transaction->status = Transactions::TRANSACTION_STATUS_PENDING;
        $transaction->updated_at = now();
        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save transaction.'
            ], 500);
        }

        $data = [
            'transaction_id' => $transaction->id,
            'dosage' => json_decode($dosage, true),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dosage details fetched successfully',
            'data' => $data,
        ]);


        // Testing

        // $dummy_dosage = [
        //     'TAB. PANTOSEC-DSR' => [
        //         'days' => 3,
        //         'frequency' => 1,
        //         'notes' => 'Before breakfast'
        //     ],
        //     'CAP. A TO Z' => [
        //         'days' => 3,
        //         'frequency' => 1,
        //         'notes' => null
        //     ],
        //     'SYP. ALEX' => [
        //         'days' => 3,
        //         'frequency' => 3,
        //         'notes' => 'TDS'
        //     ],
        //     'TAB. ALLEGRA 120MG' => [
        //         'days' => 3,
        //         'frequency' => 3,
        //         'notes' => null
        //     ],
        //     'TAB. DOLO 650MG' => [
        //         'days' => 3,
        //         'frequency' => 3,
        //         'notes' => null
        //     ]
        // ];

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Dosage details fetched successfully',
        //     'dosage' => $dummy_dosage,
        // ]);
    }

    /**
     * Helper function to fetch dosage details from uploaded document
     */
    public function fetchDosageFromDocument($document_name)
    {
        $dosage_result = Http::timeout(180)->post('http://127.0.0.1:6000/extract-dosage', [
            'document_name' => $document_name,
        ]);

        return json_decode($dosage_result->getBody(), true) ?? null;
    }

    /**
    * Save dosage details to database
     */
    public function saveDosage(Request $request)
    {
        $transaction_id = $request->transaction_id; 
        $document_dosage = $request->document_dosage;

        // Generate schedule for each medicine
        foreach ($document_dosage as $medicine => &$details) {
            $days = $details['days'];
            $existingSchedule = $details['schedule'] ?? [];
            $newSchedule = [];
            
            // Extract unique times from existing schedule
            $timeSlots = [];
            if (!empty($existingSchedule)) {
                foreach ($existingSchedule as $datetime) {
                    $time = date('H:i', strtotime($datetime));
                    if (!in_array($time, $timeSlots)) {
                        $timeSlots[] = $time;
                    }
                }
            }
            
            // Generate schedule for each day using existing times
            $currentDate = now();
            for ($day = 0; $day < $days; $day++) {
                $date = $currentDate->copy()->addDays($day);
                
                foreach ($timeSlots as $time) {
                    list($hours, $minutes) = explode(':', $time);
                    $scheduleDateTime = $date->copy()->setTime($hours, $minutes);
                    $newSchedule[] = $scheduleDateTime->format('Y-m-d H:i:s');
                }
            }
            
            $details['schedule'] = $newSchedule;
        }

        $alert_data = MedicationAlerts::where('transaction_id', $transaction_id)->update([
            'medication_data' => json_encode($document_dosage, true),
        ]);
        if (!$alert_data) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save alert data.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dosage saved successfully',
        ], 200);
    }

    public function getCalendarDosage(Request $request)
    {
        $alerts = MedicationAlerts::where('user_id', Auth::user()->id)
            ->whereNotNull('medication_data')
            ->get();

        $formatted_data = [];
        $daily_medicine_count = []; // Track medicines per day

        foreach ($alerts as $alert) {
            $alert_data = is_string($alert->medication_data) ? 
                json_decode($alert->medication_data, true) : 
                $alert->medication_data;

            if ($alert_data) {
                foreach ($alert_data as $medicine => $details) {
                    if (!isset($formatted_data[$medicine])) {
                        $formatted_data[$medicine] = [
                            'schedule' => [],
                            'notes' => $details['notes'] ?? null
                        ];
                    }
                    
                    if (isset($details['schedule'])) {
                        foreach ($details['schedule'] as $datetime) {
                            if (!in_array($datetime, $formatted_data[$medicine]['schedule'])) {
                                $formatted_data[$medicine]['schedule'][] = $datetime;
                                
                                // Extract date from datetime for daily counting
                                $date = substr($datetime, 0, 10); // Get YYYY-MM-DD part
                                if (!isset($daily_medicine_count[$date])) {
                                    $daily_medicine_count[$date] = [
                                        'total_medicines' => 0
                                    ];
                                }
                                // Increment total_medicines for each schedule entry
                                $daily_medicine_count[$date]['total_medicines']++;
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'dosage' => $formatted_data,
            'daily_summary' => $daily_medicine_count
        ]);
    }
}