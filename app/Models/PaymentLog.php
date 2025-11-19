<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_id', 'response_json', 'status_code', 'status_message'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
