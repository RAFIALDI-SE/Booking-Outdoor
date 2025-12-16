<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.transaction.index', compact('transactions'));
    }


    public function show($code)
    {
        $transaction = Transaction::where('code', $code)
            ->with(['user', 'items.product', 'paymentLogs'])
            ->firstOrFail();

        return view('admin.transaction.show', compact('transaction'));
    }
}