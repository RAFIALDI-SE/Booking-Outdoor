@extends('admin.layouts.dashboard')

@section('content')

<h2 class="mb-4">Dashboard Admin</h2>

<div class="row">

    <hr>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Slider</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('slider_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Konten</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('contents_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Produk</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('products_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Kategori Produk</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('categories_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Transaksi</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('admin_transation_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow-sm card-kelola h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-start mb-2">
                    <div class="card-icon me-3">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-primary-custom fw-bold">Pengembalian</h5>
                        <p class="card-text text-muted small">Kelola gambar, judul, dan deskripsi di halaman utama</p>
                    </div>
                </div>
                <a href="{{route('returns_index')}}" class="btn-kelola mt-auto">
                    Kelola <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection