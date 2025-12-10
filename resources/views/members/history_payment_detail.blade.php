@extends('members.layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')

<div class="container py-5 min-vh-100">

    <div class="row justify-content-center">
        <div class="col-lg-8">


            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0" style="color:#016B61;">Detail Transaksi</h2>

                <a href="{{ route('history_payment') }}"
                   class="btn shadow-sm px-3 py-2 fw-bold"
                   style="border-radius:10px; color:#016B61; border:2px solid #016B61;">
                    ← Kembali
                </a>
            </div>


            <div class="card border-0 shadow-lg p-4 mb-4"
                 style="background:#E8F7F6; border-radius:18px;">

                <h4 class="fw-bold mb-4" style="color:#016B61;">
                    Kode Transaksi: #{{ $transaction->code }}
                </h4>

                <div class="row g-3">

                    <div class="col-md-6">

                        <p class="mb-2">
                            Status Pembayaran:
                            @php
                                $statusColor = [
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'expired' => 'danger',
                                    'failed' => 'secondary',
                                ][$transaction->payment_status] ?? 'info';
                            @endphp

                            <span class="badge bg-{{ $statusColor }} px-3 py-2 text-uppercase"
                                  style="border-radius: 8px;">
                                {{ $transaction->payment_status }}
                            </span>
                        </p>


                        <p class="mb-2 text-muted">
                            Tanggal Transaksi:
                            <span class="fw-bold text-dark">
                                {{ $transaction->created_at->format('d F Y H:i') }}
                            </span>
                        </p>


                        <p class="mb-2 text-muted">
                            Total Harga:
                            <span class="fw-bold" style="color:#D62828;">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        @if($transaction->payment_expired_at)
                            <p class="mb-2 text-muted">
                                Batas Pembayaran:
                                <span class="fw-bold text-dark">
                                    {{ $transaction->payment_expired_at->format('d F Y H:i') }}
                                </span>
                            </p>

                            @if($canRepay)
                                <p class="fw-bold text-danger mb-0">Segera selesaikan pembayaran!</p>
                            @elseif($transaction->payment_status === 'expired')
                                <p class="fw-bold text-secondary mb-0">Waktu pembayaran telah berakhir.</p>
                            @endif
                        @endif
                    </div>

                </div>


                @if($canRepay)
                    <hr class="my-4">
                    <button type="button"
                        onclick="repayTransaction('{{ $transaction->code }}')"
                        class="btn btn-lg fw-bold w-100 shadow-sm"
                        style="background:#FFC107; color:#111; border-radius:12px;">
                        Bayar Ulang Transaksi
                    </button>
                @endif

            </div>

            <h4 class="fw-bold mb-3" style="color:#016B61;">Daftar Item</h4>

            <div class="d-grid gap-3">

                @foreach($transaction->items as $item)

                <div class="card border-0 shadow-sm p-3"
                     style="background:white; border-radius:16px;">

                    <div class="row g-3 align-items-center">


                        <div class="col-4 col-md-3">
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 class="img-fluid shadow-sm"
                                 style="width:100%; height:110px; object-fit:cover; border-radius:12px;">
                        </div>


                        <div class="col-8 col-md-9">

                            <h5 class="fw-bold mb-1" style="color:#016B61;">
                                {{ $item->product->name }}
                            </h5>

                            <p class="mb-1 text-muted" style="font-size:0.9rem;">
                                Harga/hari:
                                <span class="fw-bold text-dark">
                                    Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                                </span>
                            </p>

                            <p class="mb-1 text-muted" style="font-size:0.9rem;">
                                Kuantitas: <span class="fw-bold">{{ $item->quantity }}</span>
                            </p>

                            <p class="mb-1 text-muted" style="font-size:0.9rem;">
                                Lama Sewa:
                                <span class="fw-bold">{{ $item->rent_days }} hari</span>
                            </p>

                            <h6 class="fw-bold mt-2 mb-0" style="color:#D62828;">
                                Subtotal:
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </h6>
                        </div>

                    </div>
                </div>

                @endforeach

            </div>

        </div>
    </div>

</div>

@endsection


@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}">
</script>

<script>
function repayTransaction(code) {
    // if (!confirm("Yakin ingin bayar ulang transaksi ini?")) return;

    fetch(`/repay/${code}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    })
    .then(async res => {
        const raw = await res.text();
        try {
            return JSON.parse(raw);
        } catch (e) {
            console.error("Non-JSON:", raw);
            throw new Error("Invalid response");
        }
    })
    .then(data => {
        if (!data.snap_token) {
            alert(data.error || "Gagal membuat ulang pembayaran.");
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: () => window.location.href = "{{ route('history_payment') }}",
            onPending: () => window.location.href = "{{ route('history_payment') }}",
            onError: () => alert("Pembayaran gagal.")
        });
    })
    .catch(err => {
        console.error(err);
        alert("Kesalahan jaringan!");
    });
}
</script>
@endsection
