<?php

namespace Modules\AudioTranslation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrescriptionTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Manage Prescription Templates',
            'subtitle' => 'Create, edit, and delete your prescription templates.'
        ];
        return view('audiotranslation::prescriptionTemplate.index', compact('pageHeader'));
    }
}
