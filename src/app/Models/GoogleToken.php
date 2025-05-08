<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'access_token', 'refresh_token', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = true;
    
    protected $dateFormat = 'U';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isUserGoogleCalendarConnected($userId)
    {
        $token = self::where('user_id', $userId)->first();
        if (!$token) {
            return false;
        }
        
        return true;
    }
}
