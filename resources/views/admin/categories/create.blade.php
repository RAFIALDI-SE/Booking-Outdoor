@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold"><i class="fas fa-plus me-2"></i> Tambah Kategori</h2>

    <a href="{{ route('categories_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Daftar
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Formulir Kategori
    </div>

    <div class="card-body">

        <form action="{{ route('categories_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            {{-- Bagian Deskripsi dan Ikon (dihilangkan agar sesuai gambar, tapi bisa di-uncomment jika perlu) --}}
            {{--
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" class="form-control" rows="2"></textarea>
            </div>

            <div class="mb-4">
                <label for="icon" class="form-label fw-bold">Ikon (Opsional)</label>
                <input class="form-control" type="file" id="icon" name="icon">
                <small class="form-text text-muted">Pilih gambar ikon kategori.</small>
            </div>
            --}}

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background-color: #016B61;">
                    <i class="fas fa-save me-1"></i> Simpan Kategori
                </button>

                <a href="{{ route('categories_index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection