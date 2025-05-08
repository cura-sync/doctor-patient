<?php

namespace Modules\Prescriptions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleCalendarController;
use App\Models\MedicationAlerts;
use App\Models\MedicineAlert;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Prescriptions\Http\Requests\AlarmHandler;

class AlarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('playground.index')],
            ['label' => 'CuraTempus', 'url' => route('alarm.index')],
        ];

        return view('prescriptions::alarm.index', compact('breadcrumbs'));
    }

    public function fetchDosage(Request $request, AlarmHandler $model)
    {
        return $model->fetchDosage($request);
    }

    public function saveDosage(Request $request, AlarmHandler $model)
    {
        return $model->saveDosage($request);
    }

    public function getCalendarDosage(Request $request, AlarmHandler $model)
    {
        return $model->getCalendarDosage($request);
    }

    public function addDosageToGoogleCalendar(Request $request)
    {
        return GoogleCalendarController::addDosageEvent($request);
    }

    public function fetchData(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $data = DB::table('transactions as t')
            ->select('t.id as id', 't.created_at as created_at', 't.success as status', 'd.document_name as document_name')
            ->leftJoin('documents as d', 't.document_id', '=', 'd.id')
            ->where('t.user_id', Auth::user()->id)
            ->where('t.resource_type', Transactions::RESOURCE_DOSAGE_ALERTS)
            ->orderBy('t.created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'message' => 'Data fetched successfully',
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ]
        ]);
    }

    public function viewTransaction($id)
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('playground.index')],
            ['label' => 'CuraTempus', 'url' => route('alarm.index')],
            ['label' => 'View'],
        ];

        return view('prescriptions::alarm.view', compact('id', 'breadcrumbs',));
    }

    public function configureTransaction($id)
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('playground.index')],
            ['label' => 'CuraTempus', 'url' => route('alarm.index')],
            ['label' => 'Configure'],
        ];

        return view('prescriptions::alarm.configure', compact('id', 'breadcrumbs'));
    }

    public function fetchConfigureData(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $document_dosage = MedicationAlerts::where('transaction_id', $transaction_id)->first()->fetched_medication_data;
        return response()->json([
            'message' => 'Data fetched successfully',
            'document_dosage' => json_decode($document_dosage, true)
        ]);
    }
}
