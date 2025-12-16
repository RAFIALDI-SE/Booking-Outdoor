<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ReturnItem;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    // Halaman 1: List Transaksi yang siap diperiksa (Paid, Belum Returned)
    public function index(Request $request) // FIX: Terima Request object untuk query
    {
        // 1. Inisialisasi query dasar
        $query = Transaction::where('payment_status', 'paid')
            ->where('booking_status', 'booked')
            ->with('user');

        // 2. LOGIC PENCARIAN
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {

                $q->where('code', 'like', '%' . $search . '%')

                  ->orWhereHas('user', function ($qUser) use ($search) {
                      $qUser->where('name', 'like', '%' . $search . '%');
                  });
            });
        }


        $transactions = $query->orderBy('created_at', 'asc')->paginate(15)->appends($request->query()); // appends untuk pagination


        return view('admin.returns.index', compact('transactions'));
    }

    public function checkItems($transactionCode)
    {
        $transaction = Transaction::where('code', $transactionCode)
            ->where('booking_status', 'booked')
            ->with('items.product', 'user')
            ->firstOrFail();


        return view('admin.returns.check_items', compact('transaction'));
    }


    public function processCheck(Request $request, $transactionCode)
    {

        $request->validate([
            'condition.*' => 'required|in:aman,rusak,hilang',
        ]);

        $transaction = Transaction::where('code', $transactionCode)->firstOrFail();
        $items = $transaction->items()->get();

        $results = [];
        $hasDamageOrLost = false;

        foreach ($items as $index => $item) {
            $condition = $request->input('condition')[$index];
            $itemId = $request->input('item_id')[$index];


            $results[] = [
                'item_id' => $itemId,
                'condition' => $condition,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price_per_day' => $item->price_per_day,
                'subtotal' => $item->subtotal,

                'fine_amount' => ($condition === 'hilang' || $condition === 'rusak') ? $item->product->price_per_day * $item->rent_days * $item->quantity : 0,
            ];

            if ($condition !== 'aman') {
                $hasDamageOrLost = true;
            }
        }


        session(['return_check_results' => $results]);
        session(['transaction_code' => $transactionCode]);

        if ($hasDamageOrLost) {

            return redirect()->route('returns_input_fine');
        } else {

            return $this->finalizeReturn($transactionCode, $results);
        }
    }

    // Halaman 3: Input Ganti Rugi
    public function inputFine()
    {
        $results = session('return_check_results');
        $transactionCode = session('transaction_code');

        if (!$results || !$transactionCode) {
            return redirect()->route('admin.returns.index')->with('error', 'Sesi pemeriksaan hilang.');
        }

        $transaction = Transaction::where('code', $transactionCode)->firstOrFail();

        return view('admin.returns.input_fine', compact('transaction', 'results'));
    }


    public function finalizeFine(Request $request)
    {
        $results = session('return_check_results');
        $transactionCode = session('transaction_code');

        if (!$results || !$transactionCode) {
            return redirect()->route('returns_index')->with('error', 'Sesi pemeriksaan hilang.');
        }

        $finalResults = [];
        $totalFine = 0;

        foreach ($results as $index => $result) {
            $fine = $request->input('fine_amount')[$index] ?? 0;
            $result['fine_amount'] = max(0, $fine);
            $totalFine += $result['fine_amount'];
            $finalResults[] = $result;
        }

        return $this->finalizeReturn($transactionCode, $finalResults, $totalFine);
    }


    private function finalizeReturn($transactionCode, $finalResults, $totalFine = 0)
    {
        $transaction = Transaction::where('code', $transactionCode)
            ->with('items.product', 'user')
            ->firstOrFail();

        // 1. Kembalikan Stok & Catat Denda
        DB::transaction(function () use ($transaction, $finalResults, $totalFine) {

            foreach ($finalResults as $result) {
                $item = TransactionItem::find($result['item_id']);


                if ($result['condition'] == 'aman' || $result['condition'] == 'rusak') {

                    $product = $item->product;
                    $product->stock += $result['quantity'];
                    $product->save();
                }

            }

            // 2. Buat Record ReturnItem
            ReturnItem::create([
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'return_date' => now(),

                'status' => $totalFine > 0 ? 'rusak' : 'aman',
                'fine_amount' => $totalFine,
                'note' => 'Pengembalian barang dan denda (jika ada) telah diproses.',
            ]);


            $transaction->booking_status = 'returned';
            $transaction->save();
        });

        // Lanjut ke Halaman 4: Laporan
        return redirect()->route('returns_report', $transactionCode)
                        ->with(['final_results' => $finalResults, 'total_fine' => $totalFine]);
    }

    // Halaman 4: Laporan Hasil Pengembalian
    public function report($transactionCode)
    {
        $transaction = Transaction::where('code', $transactionCode)
            ->with('user', 'returnItem', 'items.product')
            ->firstOrFail();


        $finalResults = session('final_results') ?? [];
        $totalFine = session('total_fine') ?? ($transaction->returnItem->fine_amount ?? 0);

        return view('admin.returns.report', compact('transaction', 'finalResults', 'totalFine'));
    }
}