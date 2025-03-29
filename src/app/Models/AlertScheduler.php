<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertScheduler extends Model
{
    protected $fillable = ['id', 'next_alert', 'updated'];
}
