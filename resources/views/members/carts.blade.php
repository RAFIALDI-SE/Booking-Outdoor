@extends('members.layouts.app')

@section('title', 'Keranjang Saya')

@section('content')

<div class="container py-5 min-vh-100" style="background-color: #ffffff;">


    <div class="d-flex justify-content-between align-items-center mb-4 mx-auto" style="max-width: 700px;">
        <h2 class="h3 fw-bold text-center w-100" style="color: #016B61;">Keranjang</h2>
        {{-- Tombol Kembali --}}
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary" style="color: #016B61; border-color: #016B61;">
            Kembali
        </a>
    </div>


    @if(session('status'))
        <div class="alert alert-info text-center">{{ session('status') }}</div>
    @endif


    <div id="stock-error" class="alert alert-danger text-center" style="display:none;"></div>


    @if(isset($cartItems) && $cartItems->count() > 0)


        @php
            $calculatedTotalAmount = 0;
            foreach ($cartItems as $item) {

                $calculatedTotalAmount += $item->product->price_per_day * $item->quantity * ($item->rent_days ?? 1);
            }
            $rentDays = $cartItems->first()->rent_days ?? 1;
        @endphp

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-grid gap-4 mb-5">

                    @foreach($cartItems as $item)

                    <div class="card shadow-sm border-0 p-3" style="background-color: #80CEC7; border-radius: 1rem;">
                        <div class="row g-3 align-items-center text-dark">


                            <div class="col-4 col-md-3 d-flex justify-content-center">
                                <img
                                    src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}"
                                    class="img-fluid rounded-lg"
                                    style="width: 100%; height: 100px; object-fit: cover; border-radius: 0.5rem;">
                            </div>

                            <div class="col-8 col-md-3 text-white">
                                <h3 class="h5 fw-bold mb-0">{{ $item->product->name }}</h3>
                                <p class="mb-1" style="font-size: 0.9rem;">Rp {{ number_format($item->product->price_per_day, 0, ',', '.') }}</p>
                            </div>

                            <div class="col-12 col-md-6">
                                <form action="{{ route('cart_update', $item->id) }}" method="POST" class="d-flex align-items-center justify-content-end gap-2">
                                    @csrf

                                    <div class="input-group input-group-sm w-50">
                                        <span class="input-group-text border-0" id="qty-label" style="background: none; color: #fff; font-size: 0.8rem;">Qty:</span>
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="{{ $item->product->stock }}"
                                            class="form-control form-control-sm text-center"
                                            style="border-radius: 0.25rem; background-color: #fff;"
                                        >
                                    </div>

                                    <button type="submit" class="btn btn-sm text-white fw-bold" style="background-color: #016B61; border-color: #016B61;">
                                        Update
                                    </button>

                                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();"
                                        class="btn btn-sm btn-outline-danger" style="background-color: #8B4540; border-color: #8B4540; color: #fff;">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </form>

                                <form id="delete-form-{{ $item->id }}" action="{{ route('cart_delete', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>


                <div class="d-flex justify-content-end align-items-center mb-4 gap-3">
                    <h5 class="fw-bold mb-0 text-dark">Lama Hari Sewa</h5>
                    <form action="{{ route('cart_updateDays') }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="input-group" style="width: 120px;">

                            <input type="number" name="rent_days" value="{{ $rentDays }}"
                                min="1"
                                class="form-control text-center" style="border-radius: 0.25rem;">
                        </div>

                        <button type="submit" class="btn btn-md text-white fw-bold" style="background-color: #016B61;">
                            Update
                        </button>
                    </form>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end align-items-center gap-3">
                    <h4 class="fw-bold mb-0 text-dark">Total Harga:</h4>
                    <h4 class="fw-bold mb-0 me-3" style="color: #016B61;">

                        Rp {{ number_format($calculatedTotalAmount, 0, ',', '.') }}
                    </h4>

                    <button id="payButton" class="btn btn-lg text-white fw-bold" style="background-color: #016B61;">
                        Booking
                    </button>
                </div>

            </div>
        </div>

    @else
        <div class="text-center py-5">
            <p class="h5 text-secondary">Keranjang kamu masih kosong.</p>
            <a href="{{ route('products_all') }}" class="btn btn-outline-secondary mt-3" style="color: #016B61; border-color: #016B61;">
                Lihat Semua Produk
            </a>
        </div>
    @endif
</div>

@endsection

@section('scripts')

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.clientKey') }}">
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const payBtn = document.getElementById('payButton');
    if (!payBtn) return;

    payBtn.addEventListener("click", function () {

        fetch("{{ route('checkoutStore') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {

            if (!data.snap_token) {
                alert(data.error ?? "Gagal memproses pembayaran");
                return;
            }

            snap.pay(data.snap_token, {
                onSuccess: function() {
                    window.location.href = "{{ route('home') }}";
                },
                onPending: function() {
                    window.location.href = "{{ route('home') }}";
                },
                onError: function() {
                    alert('Pembayaran gagal!');
                }
            });

        });

    });
});
</script>

@endsection


