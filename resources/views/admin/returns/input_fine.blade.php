@extends('admin.layouts.dashboard')

@section('content')

<h2 class="mb-4">Input Ganti Rugi / Denda</h2>

<div class="card border-0 shadow-sm mb-4 mx-auto" style="max-width: 750px; border-radius: 1rem; background-color: #70B2B2;">
    <div class="card-body text-white">
        <p class="mb-1 fw-bold fs-5">Dipinjam Oleh: {{ $transaction->user->name ?? 'N/A' }}</p>
        <p class="mb-0 fw-bold fs-5">Tanggal Pinjam: {{ $transaction->created_at->format('d M Y') }}</p>
        <p class="mt-3">Mohon inputkan nominal ganti rugi untuk barang yang rusak atau hilang.</p>
    </div>
</div>

<form action="{{ route('returns_finalize_fine') }}" method="POST">
    @csrf

    <div class="d-grid gap-4 mx-auto" style="max-width: 750px;">

        @foreach($results as $index => $result)
            @if($result['condition'] !== 'aman')
            <div class="card border-0 shadow-sm p-3" style="background-color: #80CEC7; border-radius: 1rem;">
                <div class="row align-items-center">
                    <div class="col-12">
                        <p class="fw-bold mb-1 fs-5 text-dark">{{ $result['product_name'] }} (x{{ $result['quantity'] }})</p>
                        <p class="fw-bold mb-2 text-danger">Kondisi: {{ strtoupper($result['condition']) }}</p>

                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="number" name="fine_amount[{{ $index }}]"
                                   class="form-control" placeholder="Nominal Ganti Rugi"
                                   value="{{ $result['fine_amount'] }}" required>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <input type="hidden" name="fine_amount[{{ $index }}]" value="0">
            @endif
        @endforeach

        <div class="text-center mt-5">
            <button type="submit" class="btn text-white fw-bold px-5 py-3"
                    style="background-color:#016B61; border-radius: 12px;">
                Simpan Pengembalian
            </button>
        </div>

    </div>
</form>

@endsection