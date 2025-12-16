@extends('members.layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')

<div class="container py-5 min-vh-100">


    <a href="{{ route('home') }}"
       class="btn mb-4 shadow-sm px-4 py-2 fw-bold"
       style="background-color:#016B61; color:white; border-radius:12px;">
        ← Kembali ke Home
    </a>

    <h2 class="h3 fw-bold text-center mb-5" style="color: #016B61;">
        Riwayat Pembayaran
    </h2>

    @forelse($transactions as $transaction)


    <div class="card border-0 shadow-lg mb-4 mx-auto"
         style="max-width: 750px; border-radius: 18px;">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start mb-3">

                <div>
                    <h5 class="fw-bold mb-1" style="color: #016B61;">
                        #{{ $transaction->code }}
                    </h5>
                    <small class="text-muted">
                        {{ $transaction->created_at->format('d F Y H:i') }}
                    </small>
                </div>

                @php
                    $statusColor = [
                        'paid' => 'bg-success',
                        'pending' => 'bg-warning text-dark',
                        'expired' => 'bg-danger',
                        'failed' => 'bg-secondary',
                    ][$transaction->payment_status] ?? 'bg-info';
                @endphp

                <span class="badge {{ $statusColor }} px-3 py-2 text-uppercase"
                      style="font-size: 0.75rem; border-radius: 10px;">
                    {{ $transaction->payment_status }}
                </span>

            </div>

            <div class="mb-3">
                <p class="mb-1 text-muted">Total Pembayaran</p>
                <h4 class="fw-bold" style="color:#016B61;">
                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                </h4>
            </div>


            <div class="d-flex justify-content-end">


                <a href="{{ route('history_payment_detail', $transaction->code) }}"
                   class="btn fw-bold px-4 py-2 me-2 text-white"
                   style="background:#016B61; border-radius:10px;">
                    Lihat Detail
                </a>


                @if($transaction->payment_status === 'pending'
                    && $transaction->payment_expired_at
                    && now()->lessThan($transaction->payment_expired_at))

                    <button type="button"
                        onclick="repayTransaction('{{ $transaction->code }}')"
                        class="btn fw-bold px-4 py-2"
                        style="background:#FFC107; color:#000; border-radius:10px;">
                        Bayar Ulang
                    </button>

                @endif

            </div>

        </div>
    </div>

    @empty


    <div class="text-center py-5 mx-auto" style="max-width: 700px;">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png"
             width="120" class="mb-3 opacity-75">

        <p class="h5 text-secondary">Belum ada riwayat pembayaran.</p>

        <a href="{{ route('products_all') }}"
           class="btn mt-3 fw-bold px-4 py-2"
           style="border-radius:12px; color:#016B61; border:2px solid #016B61;">
            Mulai Belanja
        </a>
    </div>

    @endforelse

</div>

@endsection



@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}">
</script>

<script>
function repayTransaction(transactionCode) {
    // if (!confirm('Apakah Anda yakin ingin melakukan pembayaran ulang?')) return;

    fetch(`/repay/${transactionCode}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    })
    .then(async res => {
        const text = await res.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error("NON JSON RESPONSE:", text);
            throw new Error("Server mengembalikan HTML, bukan JSON.");
        }
    })
    .then(data => {
        if (!data.snap_token) {
            alert(data.error ?? "Gagal memproses pembayaran ulang.");
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: () => window.location.reload(),
            onPending: () => window.location.reload(),
            onError: () => window.location.reload(),
            onClose: () => window.location.reload()
        });
    })
    .catch(error => {
        alert(error.message);
        console.error(error);
    });
}
</script>
@endsection