<?php

namespace Modules\AudioTranslation\Http\Requests;

use App\Models\AudioContent;
use App\Models\Documents;
use App\Models\Transactions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AudioHandler extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'audio_file' => 'required|string',
            'audio_filename' => 'required|string',
            'audio_type' => 'required|string',
        ];
    }

    public function processRequest(Request $request)
    {
        $audioData = $request->audio_file;
        
        $document = Documents::saveDocument(Documents::TYPE_AUDIO, $request->audio_filename, $audioData);

        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->document_id = $document->id;
        $transaction->resource_type = Transactions::RESOURCE_AUDIO_TRANSLATION;
        $transaction->success = Transactions::TRANSACTION_STATUS_FAILED;
        $transaction->created_at = time();
        $transaction->updated_at = time();
        if (! $transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to create transaction.'
            ], 500);
        }

        // Get audio summary
        $translation_response = $this->getAudioSummary($document->document_name);
        if ($translation_response == null) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to get audio summary.'
            ], 500);
        }

        // Update the audio contents
        $audioContent = new AudioContent();
        $audioContent->document_id = $document->id;
        $audioContent->original_transcription = $translation_response['original_text'];
        $audioContent->simplified_transcription = $translation_response['summary'];
        $audioContent->prescription_content = null;
        $audioContent->created_at = time();
        $audioContent->updated_at = time();
        if (!$audioContent->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save audio content.'
            ], 500);
        }
        
        $transaction->success = Transactions::TRANSACTION_STATUS_SUCCESS;
        $transaction->updated_at = time();
        if (!$transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save transaction.'
            ], 500);
        }
        
        // For testing purposes, hardcode translation response if API fails
        // $test_translation_response = [
        //     'original_text' => "How are you doing today? I have been having trouble breathing lately. Have you had any type of cold lately? No, I haven't had a cold, I just have a heavy feeling in my chest, when I try to breathe. Do you have any allergies that you know of? No, I don't have any allergies that I know of. Does this happen all the time, or mostly when you are active? It happens a lot when I work out. I am going to send you to a pulmonary specialist, who can run tests on you for asthma. Thank you for your help, doctor.\n",
        //     'summary' => "The patient mentioned having difficulty breathing with a heavy feeling in the chest, especially during physical activity. The doctor suspected asthma and referred the patient to a pulmonary specialist for further testing. No known allergies were reported by the patient. A friendly and reassuring interaction took place during which the doctor acknowledged the symptoms and recommended additional testing to get a clear diagnosis."
        // ];

        $data = [
            'file_name' => $request->audio_filename,
            'processed_date' => now()->format('Y-m-d H:i:s'),
            'original_text' => $translation_response['original_text'],
            'summary' => $translation_response['summary'],
        ];

        // Return success response with file path
        return response()->json([
            'success' => true,
            'message' => 'Audio file saved successfully',
            'data' => $data,
        ]);
    }

    public function getAudioSummary($audio_filename)
    {
        $translation_response = Http::timeout(180)->post('http://127.0.0.1:6000/audio-to-summary', [
            'audio_file' => $audio_filename,
        ]);

        return json_decode($translation_response->getBody(), true) ?? null;
    }
}
