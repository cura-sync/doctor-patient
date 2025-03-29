<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    const TRANSACTION_TYPE_PRESCRIPTIONS = 1;

    const TRANSACTION_TYPE_BILLS = 2;

    const TRANSACTION_TYPE_ALARMS = 3;

    const TRANSACTION_TYPE_AUDIO = 4;

    const TRANSACTION_STATUS_SUCCESS = 1;

    const TRANSACTION_STATUS_FAILED = 0;

    const TRANSACTION_STATUSES = [
        self::TRANSACTION_STATUS_SUCCESS => 'Success',
        self::TRANSACTION_STATUS_FAILED => 'Failed',
    ];

    const TRANSACTION_TYPES = [
        self::TRANSACTION_TYPE_PRESCRIPTIONS => self::TRANSACTION_TYPE_PRESCRIPTION_KEYWORD,
        self::TRANSACTION_TYPE_BILLS => self::TRANSACTION_TYPE_BILL_KEYWORD,
        self::TRANSACTION_TYPE_ALARMS => self::TRANSACTION_TYPE_ALARMS_KEYWORD,
        self::TRANSACTION_TYPE_AUDIO => self::TRANSACTION_TYPE_AUDIO_KEYWORD,
    ];

    const TRANSACTION_TYPE_PRESCRIPTION_KEYWORD = 'Prescription Translation';

    const TRANSACTION_TYPE_BILL_KEYWORD = 'Bill Analysis';

    const TRANSACTION_TYPE_ALARMS_KEYWORD = 'Dosage Alerts';

    const TRANSACTION_TYPE_AUDIO_KEYWORD = 'Audio Translation';

    protected $fillable = ['id', 'user_id', 'transaction_type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
