<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineAlert extends Model
{
    protected $fillable = ['id', 'user_id', 'document_name', 'alert_data'];

    protected $casts = [
        'alert_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
