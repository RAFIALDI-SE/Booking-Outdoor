@extends('members.layouts.app')

@section('title', $product->name . ' - Detail Produk')

@section('content')

{{-- Container Utama (BG Putih) --}}
<div class="container py-5 min-vh-100" style="background-color: #ffffff;">

    {{-- Tombol Kembali di luar card --}}
    <div class="row mb-3 justify-content-center">
        <div class="col-12" style="max-width: 900px;">
            {{-- Menggunakan route('products_all') untuk kembali ke daftar produk --}}
            <a href="{{ url()->previous() }}"
               class="btn btn-outline-secondary btn-sm fw-bold"
               style="color: #016B61; border-color: #016B61;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Card Detail Produk (Warna Teal kebiruan: #80CEC7) --}}
    <div class="card shadow-lg mx-auto border-0 p-4 p-md-5" style="max-width: 900px; background-color: #80CEC7; border-radius: 1rem;">

        <div class="row g-4 text-white align-items-center">

            {{-- Kolom Kiri: Gambar Produk --}}
            <div class="col-12 col-md-5">
                <div class="p-3 border rounded-lg shadow-sm" style="border-color: rgba(255, 255, 255, 0.4) !important;">
                    <img src="{{ asset('storage/'.$product->image) }}"
                        alt="{{ $product->name }}"
                        class="img-fluid rounded-lg"
                        style="height: 300px; width: 100%; object-fit: cover; border-radius: 0.5rem;">
                </div>
            </div>

            {{-- Kolom Kanan: Informasi Produk dan Aksi --}}
            <div class="col-12 col-md-7">

                {{-- Nama & Harga --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    {{-- Diperbaiki: Warna Nama Produk menjadi #016B61 --}}
                    <h2 class="h3 fw-bold mb-0" style="color: #fff;">{{ $product->name }}</h2>
                    <p class="h4 fw-bold mb-0" style="color: #fff;">Rp {{ number_format($product->price_per_day, 0, ',', '.') }}</p>
                </div>

                {{-- Stok --}}
                <p class="mb-3" style="font-size: 1.1rem; color: #fff;"> {{-- Warna Teks Stok diatur kontras --}}
                    Stok <span class="fw-bold">{{ $product->stock }}</span>
                </p>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <p class="fw-bold mb-2" style="color: #fff;">Deskripsi</p> {{-- Warna Teks Deskripsi diatur kontras --}}
                    {{-- Box Deskripsi Putih --}}
                    <div class="p-3 rounded-lg shadow-sm" style="background-color: #ffffff; color: #333; font-size: 0.95rem;">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Total Harga (Dipertahankan di sini agar sesuai layout) --}}
                <div class="mb-4 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.4) !important;">
                    <p class="mb-0 fw-bold" style="color: #fff;">Total Harga</p> {{-- Warna Teks Total Harga diatur kontras --}}
                    <p class="h4 fw-bold mb-0" style="color: #fff;">Rp {{ number_format($product->price_per_day, 0, ',', '.') }}</p>
                </div>

                {{-- Tombol Aksi (Hanya Add to Cart yang penting) --}}
                <div class="d-flex flex-column gap-3">

                    {{-- Tombol Add to Cart --}}
                    <form action="#" method="POST" class="d-inline-block w-100">
                        @csrf
                        <input type="hidden" name="quantity" value="1">

                        {{-- Warna Tombol Add to Cart: #016B61 --}}
                        <button type="submit" class="btn btn-lg fw-bold text-white w-100" style="background-color: #016B61;">
                            Add to Cart
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection