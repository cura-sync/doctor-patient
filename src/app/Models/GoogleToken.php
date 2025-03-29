<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'access_token', 'refresh_token', 'expires_in'
    ];

    protected $casts = [
        'expires_in' => 'datetime',
    ];    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
