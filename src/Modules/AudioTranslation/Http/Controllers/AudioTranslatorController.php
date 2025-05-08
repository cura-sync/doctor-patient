<?php

namespace Modules\AudioTranslation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\AudioTranslation\Http\Requests\AudioHandler;

class AudioTranslatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('playground.index')],
            ['label' => 'CuraVox', 'url' => route('audioTranslation.index')],
        ];

        return view('audiotranslation::audioTranslation.index', compact('breadcrumbs'));
    }

    public function processUploadedAudio(Request $request)
    {
        $model = new AudioHandler();
        return $model->processRequest($request);
    }

    public function fetchData(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $data = DB::table('transactions as t')
            ->select('t.id as id', 't.created_at as created_at', 't.success as status', 'd.document_name as document_name')
            ->leftJoin('documents as d', 't.document_id', '=', 'd.id')
            ->where('t.user_id', Auth::user()->id)
            ->where('t.resource_type', Transactions::RESOURCE_AUDIO_TRANSLATION)
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
            ['label' => 'CuraVox', 'url' => route('audioTranslation.index')],
            ['label' => 'View Transaction'],
        ];

        $data = DB::table('transactions as t')
            ->select('t.id as id', 
                't.created_at as created_at', 
                't.success as status', 
                'd.document_name as document_name',
                'dc.original_text as original_text',
                'dc.simplified_text as simplified_text'
            )
            ->leftJoin('documents as d', 't.document_id', '=', 'd.id')
            ->leftJoin('document_content as dc', 'd.id', '=', 'dc.document_id')
            ->where('t.id', $id)
            ->first();

        return view('audiotranslation::audioTranslation.view.index', compact('data', 'breadcrumbs'));
    }
}
