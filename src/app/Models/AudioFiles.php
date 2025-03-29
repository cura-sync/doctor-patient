<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioFiles extends Model
{
    const TRANSLATION_SUCCESS_FAILED = 0;

    const TRANSLATION_SUCCESS_SUCCESS = 1;

    protected $table = 'audio_files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'file_name',
        'translation_success'
    ];

    public function audioContent()
    {
        return $this->hasMany(AudioContent::class);
    }
}
