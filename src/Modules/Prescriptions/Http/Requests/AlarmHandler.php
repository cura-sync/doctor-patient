<?php

namespace Modules\Prescriptions\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\AlertScheduler;
use App\Models\DPContants;
use App\Models\MedicineAlert;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Prescriptions\Http\Requests\PrescriptionHandler;

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

        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_type = Transactions::TRANSACTION_TYPE_ALARMS;
        
        // Update document name to avoid duplicacy
        $document_name = pathinfo($request->document_name, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($request->document_name, PATHINFO_EXTENSION);
        $this->saveDocument(DPContants::DOCUMENT_TYPE_DOCUMENT, $document_name, $request->document);

        $dosage_details = $this->fetchDosageFromDocument($document_name);

        if (! $dosage_details) {
            return response()->json([
                'error' => true,
                'message' => 'Dosage details not found.'
            ], 400);
        }

        $original_text = $dosage_details['original_text'];
        $dosage = $dosage_details['dosage'];

        $alarm_details = new MedicineAlert();
        $alarm_details->user_id = Auth::user()->id;
        $alarm_details->document_name = $document_name;
        $alarm_details->alert_data = null;

        if (! $alarm_details->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save alarm details.'
            ], 500);
        }

        $transaction->dosage_alert_id = $alarm_details->id;

        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save transaction.'
            ], 500);
        }

        $this->saveDosageAlarms($transaction->id, $original_text, json_encode($dosage, true));

        return response()->json([
            'success' => true,
            'message' => 'Dosage details fetched successfully',
            'transaction_id' => $transaction->id,
            'dosage' => json_decode($dosage, true),
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
    * Save document contents to database
     */
    public function saveDosageAlarms($transaction_registered_id, $original_text, $dosage_details)
    {
        $document_contents = json_encode(
            [
                'document_translation' => $dosage_details ?? null
            ]
        );

        $document = DB::table('document_contents')->insert([
            'transaction_registered_id' => $transaction_registered_id,
            'original_text' => $original_text,
            'translated_text' => $document_contents
        ]);

        if (! $document) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save document contents.'
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Document contents saved successfully',
            ], 200);
        }
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

        $transaction = Transactions::find($transaction_id);
        if (!$transaction) {
            return response()->json([
                'error' => true,
                'message' => 'Transaction not found.'
            ], 404);
        }

        $alert_data = MedicineAlert::where('id', $transaction->dosage_alert_id)->update([
            'alert_data' => json_encode($document_dosage)
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
        $alerts = MedicineAlert::where('user_id', Auth::user()->id)
            ->whereNotNull('alert_data')
            ->get();

        $formatted_data = [];
        $daily_medicine_count = []; // Track medicines per day

        foreach ($alerts as $alert) {
            $alert_data = is_string($alert->alert_data) ? 
                json_decode($alert->alert_data, true) : 
                $alert->alert_data;

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