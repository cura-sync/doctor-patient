<?php

namespace App\Http\Controllers;

use App\Models\DPContants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function __construct()
    {
        $isUserLoggedIn = Auth::check();
        view()->share('isUserLoggedIn', $isUserLoggedIn);
    }

    /**
     * Filter data by date range
     */
    public function filterByDateRange($gridData, $fromDate, $toDate)
    {
        return array_filter($gridData, function($item) use ($fromDate, $toDate) {
            $itemDate = \DateTime::createFromFormat('d-m-Y', $item['transaction_date'])->getTimestamp();
            
            if (!$itemDate) {
                return false;
            }
            
            if ($fromDate && $itemDate < $fromDate) {
                return false;
            }
            if ($toDate && $itemDate > $toDate) {
                return false;
            }
            return true;
        });
    }

    /**
     * Save document to public/documents folder
     */
    public static function saveDocument($document_type, $document_name, $document)
    {

        // TO BE IMPLEMENTED -> Safe storage mechanism for uploaded files

        // if ($document_type == DPContants::DOCUMENT_TYPE_AUDIO) {
        //     $baseFilePath = 'uploaded_audio/';
        // } else {
        //     $baseFilePath = 'uploaded_documents/';
        // }

        // $filePath = $baseFilePath . $document_name;
        // $fileContents = base64_decode($document);
        // Storage::put($filePath, $fileContents);

        $filePath = 'documents/'. $document_name;
        $fileContents = base64_decode($document);
        file_put_contents(public_path($filePath), $fileContents);        
    }

    /**
     * Save document contents to database
     */
    public function saveDocumentContents($transaction_registered_id, $original_text, $document_translation, $document_medicine)
    {
        $document_contents = json_encode(
            [
                'document_translation' => $document_translation ?? null,
                'document_medicine' => $document_medicine ?? null
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
}
