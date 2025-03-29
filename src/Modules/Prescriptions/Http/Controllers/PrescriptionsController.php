<?php

namespace Modules\Prescriptions\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Prescriptions\Http\Requests\PrescriptionHandler;

class PrescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Prescription',
            'subtitle' => 'Upload your medical document and get an easy-to-understand translation in seconds.'
        ];
        return view('prescriptions::prescription.index', compact('pageHeader'));
    }

    public function translate(Request $request, PrescriptionHandler $model)
    {
        return $model->processRequest($request);
    }
}
