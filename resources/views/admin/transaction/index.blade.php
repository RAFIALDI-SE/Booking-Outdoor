@extends('admin.layouts.dashboard')

@section('content')

<h2 class="mb-4">Kelola Data Transaksi (Booking)</h2>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Daftar Semua Transaksi
    </div>
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-2" style="width: 5%;">No</th>
                        <th class="py-2">Kode Transaksi</th>
                        <th class="py-2">Customer</th>
                        <th class="py-2">Total Harga</th>
                        <th class="py-2">Status Pembayaran</th>
                        <th class="py-2">Tanggal</th>
                        <th class="py-2" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle fw-bold text-primary-custom">{{ $transaction->code }}</td>
                        <td class="align-middle">{{ $transaction->user->name ?? 'User Dihapus' }}</td>
                        <td class="align-middle">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td class="align-middle">
                            @php
                                $badgeClass = ['paid' => 'success', 'pending' => 'warning', 'expired' => 'danger', 'failed' => 'secondary'][$transaction->payment_status] ?? 'info';
                            @endphp
                            <span class="badge bg-{{ $badgeClass }} text-uppercase">{{ $transaction->payment_status }}</span>
                        </td>
                        <td class="align-middle">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td class="align-middle">
                            <a href="{{ route('admin_transation_show', $transaction->code) }}"
                               class="btn btn-sm btn-info text-white me-1"
                               title="Lihat Detail Transaksi">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection