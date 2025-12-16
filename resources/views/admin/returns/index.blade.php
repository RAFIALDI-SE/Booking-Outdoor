@extends('admin.layouts.dashboard')

@section('content')

<h2 class="mb-4">Pengembalian Barang Pinjaman</h2>

<hr>


<form action="{{ route('returns_index') }}" method="GET" class="mb-5">
    <div class="input-group mx-auto" style="max-width: 500px;">
        <span class="input-group-text" style="background-color: #70B2B2; color: #fff;"><i class="fas fa-search"></i></span>

        <input type="text" name="search" class="form-control"
               placeholder="Cari nama atau ID transaksi"
               value="{{ request()->query('search') ?? '' }}"
               style="height: calc(3.5rem + 2px); border-color: #70B2B2;">
        <button class="btn text-white fw-bold" type="submit" style="background-color: #016B61;">Cari</button>
    </div>
</form>

@forelse($transactions as $transaction)
<div class="card border-0 shadow-sm mb-3 mx-auto" style="max-width: 750px; border-radius: 1rem;">
    <div class="card-body d-flex justify-content-between align-items-center">


        <div>
            <h4 class="fw-bold mb-1" style="color: #016B61;">
                {{ $transaction->user->name ?? 'User Dihapus' }}
            </h4>
            <p class="mb-0 small text-muted">ID Transaksi: {{ $transaction->code }}</p>
            <p class="mb-0 small text-muted">Tanggal Sewa: {{ $transaction->created_at->format('d M Y') }}</p>
            <p class="mb-0 small text-muted">Ringkasan: {{ $transaction->items->count() }} Item</p>
        </div>


        <a href="{{ route('returns_check_items', $transaction->code) }}"
           class="btn text-white fw-bold px-4 py-2"
           style="background-color:#016B61; border-radius: 12px;">
            Mulai Periksa
        </a>
    </div>
</div>
@empty
<div class="text-center py-5">
    <p class="h5 text-secondary">Tidak ada barang yang perlu dikembalikan saat ini.</p>
</div>
@endforelse

@endsection