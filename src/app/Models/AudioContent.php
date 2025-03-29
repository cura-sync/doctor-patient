<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioContent extends Model
{
    protected $table = 'audio_content';
    protected $primaryKey = 'id';
    protected $fillable = [
        'audio_file_id',
        'transaction_registered_id',
        'original_transcript',
        'simplified_data',
        'prescription_data'
    ];

    public function audioFile()
    {
        return $this->belongsTo(AudioFiles::class);
    }

    public function transactionRegistered()
    {
        return $this->belongsTo(Transactions::class);
    }
}