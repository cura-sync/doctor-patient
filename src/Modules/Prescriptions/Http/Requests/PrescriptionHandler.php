<?php

namespace Modules\Prescriptions\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\DocumentContent;
use App\Models\Documents;
use App\Models\Prescriptions;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PrescriptionHandler extends Controller
{
    public $flask_api_url;

    public function __construct()
    {
        $this->flask_api_url = env('FLASK_API_URL');
    }

    public function processRequest(Request $request)
    {
        $original_text = null;
        $document_medicine = null;
        $document_translation = null;
        
        if (!isset($request->document_name)) {
            return response()->json([
                'error' => true,
                'message' => 'Document name is required.'
            ], 400);
        }

        $document = Documents::saveDocument(Documents::TYPE_PRESCRIPTION, $request->document_name, $request->document);

        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->document_id = $document->id;
        $transaction->resource_type = Transactions::RESOURCE_PRESCRIPTION_TRANSLATION;
        $transaction->success = Transactions::TRANSACTION_STATUS_FAILED;
        $transaction->created_at = now();
        $transaction->updated_at = now();
        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to create transaction.'
            ], 500);
        }

        // Send API request to translate prescription
        if ($request->salt_analysis == true) {
            // Translation with salt analysis
            $translation_result = $this->translatePrescriptionWithMedicine($document->document_name);
            $original_text = $translation_result['original_text'];
            $document_translation = $translation_result['translated_prescription'];
            $document_medicine = $translation_result['translated_medicine'];
            if ($document_medicine == null || $document_translation == null) {
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to translate prescription.'
                ], 500);
            }
        } else {
            // Translation without salt analysis
            $document_translation = $this->translatePrescription($document->document_name);
            $original_text = $document_translation['original_text'];
            $document_translation = $document_translation['translated_prescription'];
            if ($document_translation == null) {
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to translate prescription.'
                ], 500);
            }
        }

        $transaction->success = Transactions::TRANSACTION_STATUS_SUCCESS;
        $transaction->updated_at = now();

        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to update transaction.'
            ], 500);
        }

        $document_content = DocumentContent::saveDocumentContents($document->id, $original_text, $document_translation, $document_medicine);
        $data = [
            'transaction_id' => $transaction->id,
            'document_name' => $request->document_name,
            'original_text' => $original_text,
            'document_translation' => $document_translation,
            'salt_analysis' => $document_medicine
        ];

        return response()->json([
            'success' => 'Document translated successfully',
            'data' => $data
        ]);
    }

    public function translatePrescription($document_name)
    {
        $translation_response = Http::timeout(180)->post($this->flask_api_url . '/translate-prescription', [
            'document_name' => $document_name,
        ]);

        return json_decode($translation_response->getBody(), true) ?? null;
    }

    public function translatePrescriptionWithMedicine($document_name)
    {
        $translation_response = Http::timeout(180)->post($this->flask_api_url . '/translate-prescription-with-medicine', [
            'document_name' => $document_name,
        ]);

        return json_decode($translation_response->getBody(), true) ?? null;
    }
}
