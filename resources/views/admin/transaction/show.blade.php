@extends('admin.layouts.dashboard')

@section('content')


@php
    $badgeClass = ['paid' => 'success', 'pending' => 'warning text-dark', 'expired' => 'danger', 'failed' => 'secondary'][$transaction->payment_status] ?? 'info';
@endphp

<h2 class="mb-4">Detail Transaksi #{{ $transaction->code }}</h2>

<div class="row">
    <div class="col-lg-8">

        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold" style="background-color: #70B2B2; color: #fff;">
                Informasi Transaksi
            </div>
            <div class="card-body">
                <p><strong>Kode:</strong> {{ $transaction->code }}</p>
                <p><strong>Customer:</strong> {{ $transaction->user->name ?? 'N/A' }} ({{ $transaction->user->email ?? 'N/A' }})</p>
                <p><strong>Tanggal Booking:</strong> {{ $transaction->created_at->format('d F Y H:i') }}</p>
                <p><strong>Total Bayar:</strong> <span class="fw-bold fs-5 text-success">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span></p>
                <p><strong>Metode Pembayaran:</strong> Midtrans</p>
                <p><strong>Status Pembayaran:</strong>

                    <span class="badge bg-{{ $badgeClass }} text-uppercase">{{ $transaction->payment_status }}</span>
                </p>
                <p><strong>Status Booking:</strong>
                    <span class="badge bg-primary text-uppercase">{{ $transaction->booking_status }}</span>
                </p>
            </div>
        </div>


    </div>

    <div class="col-lg-4">

        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold" style="background-color: #70B2B2; color: #fff;">
                Aksi Admin
            </div>
            <div class="card-body d-grid gap-2">
                @if($transaction->payment_status === 'pending')
                    <button class="btn btn-sm btn-warning fw-bold" disabled>Konfirmasi Manual (Dev)</button>
                @endif
                <a href="{{ route('admin_transation_index') }}" class="btn btn-sm btn-outline-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>


<div class="card shadow-sm mt-4">
    <div class="card-header fw-bold" style="background-color: #70B2B2; color: #fff;">
        Rincian Item Sewa
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga/Hari</th>
                    <th>Jumlah</th>
                    <th>Lama Sewa (Hari)</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                    <td>Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->rent_days }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection