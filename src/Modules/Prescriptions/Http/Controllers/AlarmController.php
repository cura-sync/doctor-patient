<?php

namespace Modules\Prescriptions\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleCalendarController;
use App\Models\MedicineAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Prescriptions\Http\Requests\AlarmHandler;

class AlarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Medicine Alarm System',
            'subtitle' => 'Manage your medication schedules with ease using our smart alarm system.'
        ];
        return view('prescriptions::alarm.index', compact('pageHeader'));
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
}
