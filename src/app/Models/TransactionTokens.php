<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionTokens extends Model
{
    protected $table = 'transaction_token_usage';

    protected $fillable = [
        'transaction_id',
        'original_token_count',
        'tokens_used',
        'audio_content_length',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    
    protected $dateFormat = 'U';

    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }
}
