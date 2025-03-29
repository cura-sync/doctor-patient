<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $fillable = ['id', 'user_id', 'bill_document_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
