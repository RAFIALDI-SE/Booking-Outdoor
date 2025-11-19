<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'code', 'total_amount', 'payment_status',
        'booking_status', 'payment_gateway', 'snap_token', 'payment_expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function returnItem()
    {
        return $this->hasOne(ReturnItem::class, 'transaction_id');
    }

    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}
