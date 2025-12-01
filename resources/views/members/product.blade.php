@extends('members.layouts.app')

@section('title', 'Semua Produk - Outdoor Rent')

@section('content')

{{-- Container Utama --}}
<div class="container py-5">

    {{-- Row 1: Tombol Kembali ke Beranda --}}
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home') }}"
               class="btn btn-outline-secondary btn-sm fw-bold"
               style="color: #016B61; border-color: #016B61;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    {{-- Row 2: Judul Utama (Sekarang di tengah secara penuh) --}}
    <div class="row mb-4">
        <div class="col-12">
            {{-- Judul Utama (Hanya Judul) --}}
            <h2 class="h3 fw-bold text-center mb-0" style="color: #016B61;">Semua Produk Outdoor</h2>
        </div>
    </div>

    <hr class="mb-4">

    {{-- Section: Filter dan Search --}}
    
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <form method="GET" action="{{ route('products_all') }}" class="row g-3 align-items-center">

                {{-- Search Input Group dengan Ikon sebagai Button --}}
                <div class="col-md-6 col-lg-7">
                    <div class="input-group input-group-lg">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk..."
                            class="form-control"
                        >
                        {{-- Tombol Search Ikon --}}
                        <button
                            type="submit"
                            class="btn text-white"
                            style="background-color: #016B61; border-color: #016B61;"
                        >
                            {{-- Asumsi Font Awesome dimuat di layout --}}
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div class="col-md-6 col-lg-5">
                    <select
                        name="category_id"
                        class="form-select form-select-lg"
                        onchange="this.form.submit()"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <hr class="mb-4">

    {{-- Daftar Produk --}}
    {{-- Card dibatasi menjadi 3 per baris (col-lg-4) --}}
    <div class="row g-4 justify-content-start">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-4">
                {{-- Card Produk (Warna: #70B2B2) --}}
                <div class="card h-100 shadow-sm border-0" style="background-color: #70B2B2; border-radius: 0.75rem;">
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 200px; object-fit: cover; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">

                    <div class="card-body text-white">
                        <h5 class="card-title fw-semibold">{{ $product->name }}</h5>
                        <p class="card-text mb-1">Stok: {{ $product->stock }}</p>
                        <p class="h6 fw-bold mt-2">Rp {{ number_format($product->price_per_day, 0, ',', '.') }}/hari</p>
                    </div>

                    <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                        {{-- Tombol Lihat Detail (Warna: #016B61) --}}
                        <a href="#"
                           class="btn btn-block btn-sm text-white fw-bold w-100"
                           style="background-color: #016B61;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-secondary">Tidak ada produk ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->withQueryString()->links() }}
    </div>

</div>

@endsection