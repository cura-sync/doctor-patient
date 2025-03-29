<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplate extends Model
{
    protected $table = 'prescription_template';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'template',
        'type'
    ];

    CONST DEFAULT_PRESCRIPTION_TEMPLATE = 1;
    
    CONST CUSTOM_PRESCRIPTION_TEMPLATE = 2;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
