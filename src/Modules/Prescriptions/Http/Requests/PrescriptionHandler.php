<?php

namespace Modules\Prescriptions\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\DPContants;
use App\Models\Prescriptions;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Node\Block\Document;

class PrescriptionHandler extends Controller
{
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

        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_type = Transactions::TRANSACTION_TYPE_PRESCRIPTIONS;
                
        // Update document name to avoid duplicacy
        $document_name = pathinfo($request->document_name, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($request->document_name, PATHINFO_EXTENSION);

        $this->saveDocument(DPContants::DOCUMENT_TYPE_DOCUMENT, $document_name, $request->document);

        // Register prescription
        $prescription = new Prescriptions();
        $prescription->user_id = Auth::user()->id;
        $prescription->prescription_document_name = $document_name;
        $prescription->translation_success = Prescriptions::PRESCRIPTION_TRANSLATION_FAILED;
        
        if (! $prescription->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to register prescription.'
            ], 500);
        }

        // Send API request to translate prescription
        if ($request->salt_analysis == true) {
            // Translation with salt analysis
            $translation_result = $this->translatePrescriptionWithMedicine($document_name);
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
            $document_translation = $this->translatePrescription($document_name);
            $original_text = $document_translation['original_text'];
            $document_translation = $document_translation['translated_prescription'];
            if ($document_translation == null) {
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to translate prescription.'
                ], 500);
            }
        }

        // Update prescription translation to success
        $prescription->translation_success = Prescriptions::PRESCRIPTION_TRANSLATION_SUCCESS;
        if (! $prescription->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to update prescription.'
            ], 500);
        }

        $transaction->prescription_transalation_id = $prescription->id;

        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to create transaction.'
            ], 500);
        }

        $this->saveDocumentContents($transaction->id, $original_text, $document_translation, $document_medicine);

        return response()->json([
            'success' => 'Document translated successfully', 
            'document_name' => $request->document_name,
            'document_translation' => $document_translation,
            'document_medicine' => $document_medicine ? $document_medicine : null
        ]);
    }

    public function translatePrescription($document_name)
    {
        $translation_response = Http::timeout(180)->post('http://127.0.0.1:6000/translate-prescription', [
            'document_name' => $document_name,
        ]);

        return json_decode($translation_response->getBody(), true) ?? null;
    }

    public function translatePrescriptionWithMedicine($document_name)
    {
        $translation_response = Http::timeout(180)->post('http://127.0.0.1:6000/translate-prescription-with-medicine', [
            'document_name' => $document_name,
        ]);

        return json_decode($translation_response->getBody(), true) ?? null;
    }
}
