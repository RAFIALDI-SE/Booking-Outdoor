@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold"><i class="fas fa-plus me-2"></i> Tambah Konten</h2>

    <a href="{{ route('contents_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Daftar
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Formulir Konten
    </div>

    <div class="card-body">

        <form action="{{ route('contents_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Gambar</label>
                <input class="form-control" type="file" id="image" name="image" required>
                <small class="form-text text-muted">Pilih gambar utama untuk konten (rasio lebar, misalnya 16:9)</small>
            </div>

            <div class="mb-4">
                <label for="link" class="form-label fw-bold">Link</label>
                <input type="url" name="link" id="link" class="form-control" placeholder="Masukkan link ig" required>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background-color: #016B61;">
                    <i class="fas fa-save me-1"></i> Simpan Konten
                </button>

                <a href="{{ route('contents_index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection