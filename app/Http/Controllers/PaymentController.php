<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function notification(Request $request)
    {
        // Menggunakan library Midtrans Notification
        $notif = new \Midtrans\Notification();

        DB::transaction(function() use($notif, $request) {

            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status;

            // WAJIB: Eager Load 'items.product' agar stock bisa dikurangi di setStatusPaid()
            $transaction = Transaction::where('code', $orderId)
                                      ->with('items.product') // BARIS INI WAJIB DITAMBAHKAN
                                      ->first();

            if (!$transaction) {
                Log::warning("Transaction not found for order_id: " . $orderId);
                return; // Exit if transaction not found
            }

            // 1. Simpan Log Pembayaran
            PaymentLog::create([
                'transaction_id' => $transaction->id,
                'response_json' => json_encode($request->all(), JSON_PRETTY_PRINT),
                'status_code' => $notif->status_code,
                'status_message' => $notif->status_message,
            ]);


            // 2. Update Status dan Kelola Stok (Logika yang Anda berikan)

            if ($transactionStatus == 'capture') {
                if ($notif->payment_type == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $transaction->setStatusPending();
                    } else {
                        // Success payment, reduce stock!
                        $transaction->setStatusPaid();
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                // Success payment, reduce stock!
                $transaction->setStatusPaid();

            } elseif($transactionStatus == 'pending'){
                $transaction->setStatusPending();

            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel') {
                // Payment Failed / Cancelled
                $transaction->setStatusFailedOrExpired('failed');

            } elseif ($transactionStatus == 'expire') {
                 // Payment Expired
                $transaction->setStatusFailedOrExpired('expired');
            }

        });
        // Midtrans perlu mendapatkan respons 200 OK
        return response()->json(['success' => true]);
    }
}