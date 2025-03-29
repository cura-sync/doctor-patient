<?php

namespace Modules\AudioTranslation\Http\Requests;

use App\Http\Controllers\Controller;
use App\Models\AudioContent;
use App\Models\AudioFiles;
use App\Models\DPContants;
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
            
        // Initialize a new transaction
        $transaction = new Transactions();
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_type = Transactions::TRANSACTION_TYPE_AUDIO;

        // Generate unique filename to prevent overwrites
        $audio_filename = pathinfo($request->audio_filename, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($request->audio_filename, PATHINFO_EXTENSION);
        Controller::saveDocument(DPContants::DOCUMENT_TYPE_AUDIO, $audio_filename, $audioData);

        // Register the uploaded audio file
        $audioFile = new AudioFiles();
        $audioFile->file_name = $audio_filename;
        $audioFile->translation_success = AudioFiles::TRANSLATION_SUCCESS_FAILED;
        
        if (!$audioFile->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to register audio file.'
            ], 500);
        }

        // Get audio summary
        $translation_response = $this->getAudioSummary($audio_filename);
        if ($translation_response == null) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to get audio summary.'
            ], 500);
        } else {
            $audioFile->translation_success = AudioFiles::TRANSLATION_SUCCESS_SUCCESS;
            if (!$audioFile->save()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to save audio file.'
                ], 500);
            }
        }

        // Update the transaction with the audio file id
        $transaction->audio_conversion_id = $audioFile->id;
        if (!$transaction->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save transaction.'
            ], 500);
        }

        // Update the audio contents in db
        $audioContent = new AudioContent();
        $audioContent->audio_file_id = $audioFile->id;
        $audioContent->transaction_registered_id = $transaction->id;
        $audioContent->original_transcript = $translation_response['original_text'];
        $audioContent->simplified_data = $translation_response['summary'];
        if (!$audioContent->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save audio content.'
            ], 500);
        }
        
        // For testing purposes, hardcode translation response if API fails
        // $test_translation_response = [
        //     'original_text' => "How are you doing today? I have been having trouble breathing lately. Have you had any type of cold lately? No, I haven't had a cold, I just have a heavy feeling in my chest, when I try to breathe. Do you have any allergies that you know of? No, I don't have any allergies that I know of. Does this happen all the time, or mostly when you are active? It happens a lot when I work out. I am going to send you to a pulmonary specialist, who can run tests on you for asthma. Thank you for your help, doctor.\n",
        //     'summary' => "The patient mentioned having difficulty breathing with a heavy feeling in the chest, especially during physical activity. The doctor suspected asthma and referred the patient to a pulmonary specialist for further testing. No known allergies were reported by the patient. A friendly and reassuring interaction took place during which the doctor acknowledged the symptoms and recommended additional testing to get a clear diagnosis."
        // ];

        // Return success response with file path
        return response()->json([
            'success' => true,
            'message' => 'Audio file saved successfully',
            'file_name' => $request->audio_filename,
            'processed_date' => now()->format('Y-m-d H:i:s'),
            'translation_response' => $translation_response,
            // 'translation_response' => $test_translation_response,
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
