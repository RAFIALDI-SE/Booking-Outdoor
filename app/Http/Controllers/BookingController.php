<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentLog;
use App\Models\Cart;

class BookingController extends Controller
{
    protected $response = [];

    public function __construct()
    {
        // Konfigurasi Midtrans hanya dilakukan di Controller yang memanggil Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    // METHOD UNTUK MEMPROSES CHECKOUT DARI KERANJANG
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkoutStore(Request $request)
    {
        /** @var \App\Models\User $user */ // Doc block untuk memastikan linter tahu User punya relasi
        $user = Auth::user();
        // Memastikan relasi product dimuat untuk cek stok dan harga
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong.'], 400);
        }

        $totalAmount = 0;

        try {
            DB::transaction(function() use ($request, $user, $cartItems, &$totalAmount) {

                // 1. Hitung total dan validasi stok saat ini
                foreach ($cartItems as $item) {
                    $itemTotal = $item->product->price_per_day * $item->quantity * $item->rent_days;
                    $totalAmount += $itemTotal;

                    // Cek stok: Jika ada item yang melebihi stok, throw error
                    if ($item->quantity > $item->product->stock) {
                        throw new \Exception("Stok {$item->product->name} tidak cukup.");
                    }
                }

                // 2. Buat record Transaksi Utama
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'code' => 'TRX-' . $user->id . '-' . rand(100000, 999999),
                    'total_amount' => $totalAmount,
                    'payment_status' => 'pending',
                    'booking_status' => 'booked',
                    'payment_gateway' => 'Midtrans',
                    'payment_expired_at' => now()->addDay(),
                ]);

                // 3. Pindahkan item dari cart ke transaction_items
                foreach ($cartItems as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'rent_days' => $item->rent_days,
                        'price_per_day' => $item->product->price_per_day,
                        'subtotal' => $item->product->price_per_day * $item->quantity * $item->rent_days,
                    ]);
                }

                // 4. Hapus Keranjang setelah berhasil dimasukkan ke transaksi
                $user->carts()->delete();

                // 5. Generate Snap Token Midtrans
                $payload = $this->buildMidtransPayload($transaction);

                $snapToken = Snap::getSnapToken($payload);
                $transaction->snap_token = $snapToken;
                $transaction->save();

                $this->response['snap_token'] = $snapToken;
                $this->response['transaction_code'] = $transaction->code;

            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json($this->response);
    }

    // HELPER UNTUK MEMBUAT PAYLOAD MIDTRANS
    protected function buildMidtransPayload(Transaction $transaction)
    {
        return [
            'transaction_details' => [
                'order_id'    => $transaction->code,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name'  => $transaction->user->name,
                'email'       => $transaction->user->email,
                'phone'       => $transaction->user->phone_number ?? '0800000000',
            ],
            'item_details' => $transaction->items->map(function ($item) {
                return [
                    'id'       => $item->product_id,

                    'price'    => $item->price_per_day * $item->rent_days,
                    'quantity' => $item->quantity,
                    'name'     => $item->product->name,
                ];
            })->toArray()
        ];
    }

    /**
     * Menampilkan detail pembayaran spesifik.
     *
     * @param string $code Kode transaksi (code)
     * @return \Illuminate\View\View
     */
    public function historyDetail($code)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        $transaction = $user->transactions()
                            ->where('code', $code)
                            ->with('items.product')
                            ->firstOrFail();

        $canRepay = $transaction->payment_status === 'pending' &&
                    ($transaction->payment_expired_at && now()->lessThan($transaction->payment_expired_at));

        return view('members.history_payment_detail', compact('transaction', 'canRepay'));
    }

}
