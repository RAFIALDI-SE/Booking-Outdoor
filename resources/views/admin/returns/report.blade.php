@extends('admin.layouts.dashboard')

@section('content')

<h2 class="mb-4 fw-bold" style="color: #016B61;">Struk Laporan Pengembalian</h2>

<div class="card border-0 shadow-lg mx-auto" style="max-width: 750px; border-radius: 18px;">
    <div class="card-body p-5">

        <h4 class="fw-bold mb-4">STRUK LAPORAN PENGEMBALIAN</h4>

        <p class="small mb-1">Tanggal Cetak: {{ now()->format('d F Y') }}</p>
        <p class="small mb-1">Dipinjam Oleh: {{ $transaction->user->name ?? 'N/A' }}</p>
        <p class="small mb-4">Tanggal Pinjam: {{ $transaction->created_at->format('d F Y') }}</p>

        <hr>

        <h5 class="fw-bold mb-3">DETAIL PEMINJAMAN</h5>

        <p class="fw-bold mb-1">DAFTAR BARANG</p>
        <p class="fw-bold mb-3 text-success">Status Laporan: SELESAI</p>

        <div class="d-grid gap-3 mb-5">
            @php $totalFine = 0; @endphp
            @foreach($finalResults as $result)
                @php $totalFine += $result['fine_amount']; @endphp
                <div class="card border-0 p-3" style="background-color: #80CEC7; border-radius: 1rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">

                            <img src="https://via.placeholder.com/30/FFFFFF/016B61?text=A" class="me-3" style="width: 30px; height: 30px;">
                            <div>
                                <p class="fw-bold mb-0 text-white">{{ $result['product_name'] }} (x{{ $result['quantity'] }})</p>
                                <p class="small mb-0 text-white">Kondisi: {{ ucfirst($result['condition']) }}</p>
                            </div>
                        </div>

                        <div>
                            @if($result['condition'] !== 'aman')
                                <span class="fw-bold text-danger">Rp {{ number_format($result['fine_amount'], 0, ',', '.') }}</span>
                            @else
                                <i class="fas fa-check-circle text-success fs-5"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h4 class="fw-bold mb-3" style="color: #333;">Total Ganti Rugi:</h4>
        <h3 class="fw-bold mb-3" style="color: #A33C3C;">Rp {{ number_format($totalFine, 0, ',', '.') }}</h3>

        <p class="fw-bold text-danger">Status Pembayaran: BELUM LUNAS</p>
        <p class="small text-muted">Terima kasih telah menyewa di jawatimuroutdoor. Harap segera melunasi biaya ganti rugi agar dapat melakukan peminjaman kembali.</p>

        <div class="mt-4 text-center">
            <a href="{{ route('returns_index') }}" class="btn btn-outline-secondary fw-bold">Selesai & Kembali</a>
        </div>
    </div>
</div>

@endsection