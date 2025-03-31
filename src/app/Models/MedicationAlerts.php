<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationAlerts extends Model
{
    protected $table = 'medication_alerts';

    protected $fillable = [
        'user_id',
        'document_id',
        'transaction_id',
        'fetched_medication_data',
        'medication_data',
        'google_calendar_synced',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    
    protected $dateFormat = 'U';
}
