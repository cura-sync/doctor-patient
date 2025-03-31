<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documents extends Model
{
    protected $table = 'documents';

    const TYPE_PRESCRIPTION = 1;
    
    const TYPE_BILL = 2;
    
    const TYPE_AUDIO = 3;

    public $timestamps = true;
    
    protected $dateFormat = 'U';

    public static function saveDocument($document_type, $document_name, $document)
    {
        // Save the document
        $document_name = pathinfo($document_name, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($document_name, PATHINFO_EXTENSION);
        $base_file_path = '';
        if ($document_type == self::TYPE_AUDIO) {
            $base_file_path = 'uploaded_audio/';
        } else {
            $base_file_path = 'uploaded_documents/';
        }
        $file_path = $base_file_path . $document_name;
        $file_contents = base64_decode($document);
        Storage::put($file_path, $file_contents);
        
        // Register document in database
        $document = new Documents();
        $document->document_name = $document_name;
        $document->document_type = $document_type;
        $document->created_at = time();
        $document->updated_at = time();
        
        if (!$document->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save document.'
            ], 500);
        }
        
        return $document;
    }
}