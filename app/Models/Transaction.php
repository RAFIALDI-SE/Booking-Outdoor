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


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payment_expired_at' => 'datetime',
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


    public function setStatusPaid()
    {
        if ($this->payment_status === 'pending' || $this->payment_status === 'expired') {

            // Lakukan pengurangan stok untuk setiap item dalam transaksi
            $this->items->each(function ($item) {
                $item->product->reduceStock($item->quantity);
            });

            $this->payment_status = 'paid';
            $this->booking_status = 'booked';
            $this->save();
        }
    }

    /**
     * Dipanggil saat pembayaran gagal, kedaluwarsa, atau dibatalkan.
     * Tidak ada pengurangan stok yang dilakukan (asumsi stock tidak dikurangi di awal booking).
     */
    public function setStatusFailedOrExpired($status)
    {
        $this->payment_status = $status; // failed atau expired
        $this->save();
    }

    public function setStatusPending()
    {
        $this->payment_status = 'pending';
        $this->save();
    }

}