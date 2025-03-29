<?php

namespace Modules\User\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\Bills;
use App\Models\MedicineAlert;
use App\Models\Prescriptions;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class UserHandler extends Controller
{
    public function getUserTransactions($request)
    {
        $filterData = $request->filter_data;
        $gridData = [];
        $totalData = [];
        $prescriptions = Prescriptions::where('user_id', Auth::user()->id)->get(); // Fetch all prescriptions
        $bills = Bills::where('user_id', Auth::user()->id)->get(); // Fetch all bills
        $dosage_alerts = MedicineAlert::where('user_id', Auth::user()->id)->get(); // Fetch all dosage alerts

        // Update prescriptions data
        foreach ($prescriptions as $prescription) {
            $gridData[] = [
                'transaction_id' => $prescription->id,
                'document_name' => preg_replace('/_\d+\.png$/', '.png', $prescription->prescription_document_name),
                'transaction_date' => $prescription->created_at->format('d-m-Y'),
                'transaction_type' => Transactions::TRANSACTION_TYPE_PRESCRIPTION_KEYWORD,
                'status' => $prescription->translation_success == Transactions::TRANSACTION_STATUS_SUCCESS ? 'Success' : 'Failed',
            ];
        }

        // Update bills data
        foreach ($bills as $bill) {
            $gridData[] = [
                'transaction_id' => $bill->id,
                'document_name' => preg_replace('/_\d+\.png$/', '.png', $bill->bill_document_name),
                'transaction_date' => $bill->created_at->format('d-m-Y'),
                'transaction_type' => Transactions::TRANSACTION_TYPE_BILL_KEYWORD,
                'status' => 'Success', // Temporary status
            ];
        }

        // Update dosage alerts data
        foreach ($dosage_alerts as $dosage_alert) {
            $gridData[] = [
                'transaction_id' => $dosage_alert->id,
                'document_name' => preg_replace('/_\d+\.png$/', '.png', $dosage_alert->document_name),
                'transaction_date' => $dosage_alert->created_at->format('d-m-Y'),
                'transaction_type' => Transactions::TRANSACTION_TYPE_ALARMS_KEYWORD,
                'status' => 'Success'
            ];
        }

        $totalData = $gridData;

        // Filter gridData based on filterData
        if ($filterData != []) {
            if (isset($filterData['document_name'])) {
                $gridData = array_filter($gridData, function($item) use ($filterData) {
                    return strpos(strtolower($item['document_name']), strtolower($filterData['document_name'])) !== false;
                });
            }

            if (isset($filterData['date_filters'])) {
                $toDate = '';
                $fromDate = '';
                if (isset($filterData['date_filters']['transaction_date_from'])) {
                    $fromDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $filterData['date_filters']['transaction_date_from'])->getTimestamp();
                }
                if (isset($filterData['date_filters']['transaction_date_to'])) {
                    $toDate = \DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $filterData['date_filters']['transaction_date_to'])->getTimestamp();
                }

                if ($toDate && $fromDate) {
                    $gridData = array_filter($gridData, function($item) use ($fromDate, $toDate) {
                        $itemDate = \DateTime::createFromFormat('d-m-Y', $item['transaction_date'])->getTimestamp();
                        return $itemDate >= $fromDate && $itemDate <= $toDate;
                    });
                }
                if ($fromDate) {
                    $gridData = array_filter($gridData, function($item) use ($fromDate) {
                        $itemDate = \DateTime::createFromFormat('d-m-Y', $item['transaction_date'])->getTimestamp();
                        return $itemDate >= $fromDate;
                    });
                }
                if ($toDate) {
                    $gridData = array_filter($gridData, function($item) use ($toDate) {
                        $itemDate = \DateTime::createFromFormat('d-m-Y', $item['transaction_date'])->getTimestamp();
                        return $itemDate <= $toDate;
                    });
                }
            }

            if (!empty($filterData['transaction_date_from']) || !empty($filterData['transaction_date_to'])) {
                $fromDate = !empty($filterData['transaction_date_from']) ? 
                    \DateTime::createFromFormat('d-m-Y', $filterData['transaction_date_from'])->getTimestamp() : null;
                $toDate = !empty($filterData['transaction_date_to']) ? 
                    \DateTime::createFromFormat('d-m-Y', $filterData['transaction_date_to'])->getTimestamp() : null;
                
                $gridData = $this->filterByDateRange($gridData, $fromDate, $toDate);
            }
            if (isset($filterData['transaction_type'])) {
                $gridData = array_filter($gridData, function($item) use ($filterData) {
                    return $item['transaction_type'] == $filterData['transaction_type'];
                });
            }
            if (isset($filterData['status'])) {
                $gridData = array_filter($gridData, function($item) use ($filterData) {
                    return $item['status'] == $filterData['status'];
                });
            }
        }

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

        if ($transation->transaction_type == Transactions::TRANSACTION_TYPE_PRESCRIPTIONS) {
            if (!Prescriptions::where('id', $transation->prescription_transalation_id)->delete()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Prescription could not be deleted.',
                ]);
            }
        }

        if ($transation->transaction_type == Transactions::TRANSACTION_TYPE_BILLS) {
            if (!Bills::where('id', $transation->bill_analysis_id)->delete()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Bill could not be deleted.',
                ]);
            }
        }

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

    public function fetchTransactionDetails($request)
    {
        $transactionDetails = [];

        $document_contents = DB::table('document_contents')->where('transaction_registered_id', $request->transaction['transaction_id'])->first();
        
        if (!$document_contents) {
            return response()->json([
                'error' => true,
                'message' => 'Document contents not found.',
            ]);
        }

        $translated_text = json_decode($document_contents->translated_text);

        $transactionDetails['original_text'] = $document_contents->original_text;
        $transactionDetails['prescription_translation'] = $translated_text->document_translation ?? 'Data not available';
        $transactionDetails['medicine_translation'] = $translated_text->document_medicine ?? 'Data not available';

        return response()->json([
            'success' => true,
            'transactionDetails' => $transactionDetails,
        ]);
    }
}