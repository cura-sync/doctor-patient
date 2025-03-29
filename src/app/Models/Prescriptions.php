<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    const PRESCRIPTION_TRANSLATION_SUCCESS = 1;

    const PRESCRIPTION_TRANSLATION_FAILED = 0;

    const PRESCRIPTION_ALARM_ENABLED = 1;

    const PRESCRIPTION_ALARM_DISABLED = 0;

    protected $fillable = ['id', 'user_id', 'prescription_document_name', 'translation_success', 'prescription_alarm'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
