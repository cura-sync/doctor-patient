<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    
    protected $fillable = ['id', 'user_id', 'resource_type', 'success'];

    public $timestamps = true;
    
    protected $dateFormat = 'U';

    // Transaction statuses
    const TRANSACTION_STATUS_SUCCESS = 1;

    const TRANSACTION_STATUS_FAILED = 0;

    const TRANSACTION_STATUS_PENDING = 2;

    // Resource types
    const RESOURCE_PRESCRIPTION_TRANSLATION = 1;

    const RESOURCE_BILL_ANALYSIS = 2;

    const RESOURCE_DOSAGE_ALERTS = 3;

    const RESOURCE_AUDIO_TRANSLATION = 4;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public static function getResourceType()
    {
        $types = [
            self::RESOURCE_PRESCRIPTION_TRANSLATION => 'Prescription Translation',
            self::RESOURCE_BILL_ANALYSIS => 'Bill Analysis',
            self::RESOURCE_DOSAGE_ALERTS => 'Dosage Alerts',
            self::RESOURCE_AUDIO_TRANSLATION => 'Audio Translation',
        ];
        
        $formattedTypes = [];
        foreach ($types as $key => $value) {
            $formattedTypes[] = ['key' => $key, 'value' => $value];
        }
        return $formattedTypes;
    }

    public static function getTransactionStatus()
    {
        $statuses = [
            self::TRANSACTION_STATUS_SUCCESS => 'Success',
            self::TRANSACTION_STATUS_FAILED => 'Failed',
            self::TRANSACTION_STATUS_PENDING => 'Pending',
        ];
        
        $formattedStatuses = [];
        foreach ($statuses as $key => $value) {
            $formattedStatuses[] = ['key' => $key, 'value' => $value];
        }
        return $formattedStatuses;
    }
}
