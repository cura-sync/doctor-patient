<?php

namespace Modules\User\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\AudioContent;
use App\Models\DocumentContent;
use App\Models\MedicationAlerts;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserHandler extends Controller
{
    public function getUserTransactions($request)
    {
        $filterData = $request->filter_data;
        $gridData = [];
        $totalData = [];

        $sql = "
            SELECT 
            t.id as transaction_id,
            t.user_id,
            t.resource_type,
            t.success,
            t.created_at as transaction_created_at,
            d.id as document_id,
            d.document_name,
            d.document_type,
            CASE 
                WHEN t.resource_type = " . Transactions::RESOURCE_PRESCRIPTION_TRANSLATION . " THEN 'Prescription Translation'
                WHEN t.resource_type = " . Transactions::RESOURCE_DOSAGE_ALERTS . " THEN 'Dosage Alerts'
                WHEN t.resource_type = " . Transactions::RESOURCE_BILL_ANALYSIS . " THEN 'Bill Analysis'
                WHEN t.resource_type = " . Transactions::RESOURCE_AUDIO_TRANSLATION . " THEN 'Audio Translation'
            END as resource_name,
            CASE 
                WHEN t.resource_type = " . Transactions::RESOURCE_PRESCRIPTION_TRANSLATION . " THEN dc.original_text
                WHEN t.resource_type = " . Transactions::RESOURCE_DOSAGE_ALERTS . " THEN ma.fetched_medication_data
                WHEN t.resource_type = " . Transactions::RESOURCE_BILL_ANALYSIS . " THEN dc.original_text
                WHEN t.resource_type = " . Transactions::RESOURCE_AUDIO_TRANSLATION . " THEN ac.original_transcription
            END as original_content,
            CASE 
                WHEN t.resource_type = " . Transactions::RESOURCE_PRESCRIPTION_TRANSLATION . " THEN dc.simplified_text
                WHEN t.resource_type = " . Transactions::RESOURCE_DOSAGE_ALERTS . " THEN ma.medication_data
                WHEN t.resource_type = " . Transactions::RESOURCE_BILL_ANALYSIS . " THEN dc.simplified_text
                WHEN t.resource_type = " . Transactions::RESOURCE_AUDIO_TRANSLATION . " THEN ac.simplified_transcription
            END as simplified_content,
            CASE 
                WHEN t.resource_type = " . Transactions::RESOURCE_PRESCRIPTION_TRANSLATION . " THEN dc.document_medication
            END as medication_content,
            CASE
                WHEN t.resource_type = " . Transactions::RESOURCE_AUDIO_TRANSLATION . " THEN ac.prescription_content
            END as prescription_content,
            CASE
                WHEN t.resource_type = " . Transactions::RESOURCE_DOSAGE_ALERTS . " THEN ma.google_calendar_synced
            END as google_calendar_synced
        FROM 
            transactions t
            INNER JOIN documents d ON t.document_id = d.id
            LEFT JOIN document_content dc ON d.id = dc.document_id
            LEFT JOIN audio_content ac ON d.id = ac.document_id
            LEFT JOIN medication_alerts ma ON t.id = ma.transaction_id
        WHERE 
            t.user_id = " . Auth::user()->id . "
        ";

        // Handle filteration
        if (isset($filterData['document_name'])) {
            $sql .= " AND d.document_name LIKE '%" . $filterData['document_name'] . "%'";
        }

        if (isset($filterData['transaction_type'])) {
            $sql .= " AND t.resource_type = " . $filterData['transaction_type'];
        }

        if (isset($filterData['status'])) {
            $sql .= " AND t.success = " . $filterData['status'];
        }

        if (isset($filterData['date_filters'])) {
            if (isset($filterData['date_filters']['transaction_date_from'])) {
                $sql .= " AND t.created_at >= '" . $filterData['date_filters']['transaction_date_from'] . "'";
            }
            else if (isset($filterData['date_filters']['transaction_date_to'])) {
                $sql .= " AND t.created_at <= '" . $filterData['date_filters']['transaction_date_to'] . "'";
            }
            else if (isset($filterData['date_filters']['transaction_date_from']) && isset($filterData['date_filters']['transaction_date_to'])) {
                $sql .= " AND t.created_at BETWEEN '" . $filterData['date_filters']['transaction_date_from'] . "' AND '" . $filterData['date_filters']['transaction_date_to'] . "'";
            }
        }

        $sql .= " ORDER BY t.created_at DESC";
        $gridData = DB::select($sql);
        
        // Paginate gridData
        $currentPage = $request->page ?: 1;
        $perPage = 5;
        $currentItems = array_slice($gridData, ($currentPage - 1) * $perPage, $perPage);

        return response()->json([
            'totalData' => $totalData,
            'gridData' => $currentItems,
            'current_page' => $currentPage,
            'last_page' => ceil(count($gridData) / $perPage),
            'total' => count($gridData),
        ]);
    }

    public function deleteTransaction($request)
    {
        $transation = Transactions::where('id', $request->transaction['transaction_id'])->first();
        
        // Delete document content
        if ($transation->resource_type == Transactions::RESOURCE_AUDIO_TRANSLATION) {
            $audio_content = AudioContent::where('document_id', $transation->document_id);
            if (!$audio_content->delete()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Audio content could not be deleted.',
                ]);
            }
        } else if ($transation->resource_type == Transactions::RESOURCE_DOSAGE_ALERTS) {
            $medication_alert = MedicationAlerts::where('transaction_id', $transation->id);
            if (!$medication_alert->delete()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Medication alert could not be deleted.',
                ]);
            }
        } else {
            $document_content = DocumentContent::where('document_id', $transation->document_id);
            if (!$document_content->delete()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Document content could not be deleted.',
                ]);
            }
        }

        // Delete supporting transaction
        if (!$transation->delete()) {
            return response()->json([
                'error' => true,
                'message' => 'Transaction could not be deleted.',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaction deleted successfully.',
        ]);
    }
}