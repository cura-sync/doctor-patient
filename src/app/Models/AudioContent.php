<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioContent extends Model
{
    protected $table = 'audio_content';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'document_id',
        'original_transcription',
        'simplified_transcription',
        'prescription_content',
    ];

    public $timestamps = true;
    
    protected $dateFormat = 'U';
}
