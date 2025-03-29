<?php

namespace Modules\AudioTranslation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AudioTranslation\Http\Requests\AudioHandler;

class AudioTranslatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageHeader = [
            'title' => 'Audio Translation',
            'subtitle' => 'Upload your audio file and get an easy-to-understand translation in seconds.'
        ];

        return view('audiotranslation::audioTranslation.index', compact('pageHeader'));
    }

    public function processUploadedAudio(Request $request)
    {
        $model = new AudioHandler();
        return $model->processRequest($request);
    }
}
