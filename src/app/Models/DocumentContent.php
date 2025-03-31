<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentContent extends Model
{
    protected $table = 'document_content';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'document_id',
        'original_text',
        'simplified_text',
        'document_medication',
    ];

    public $timestamps = true;
    
    protected $dateFormat = 'U';
    
    public static function saveDocumentContents($document_id, $original_text, $document_translation, $document_medicine = null)
    {
        $document_content = new DocumentContent();
        $document_content->document_id = $document_id;
        $document_content->original_text = $original_text;
        $document_content->simplified_text = $document_translation;
        $document_content->document_medication = $document_medicine;
        $document_content->created_at = time();
        $document_content->updated_at = time();
        
        if (!$document_content->save()) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to save document contents.'
            ], 500);
        }
        
        return $document_content;
    }
}
