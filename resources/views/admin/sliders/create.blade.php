@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold"><i class="fas fa-plus me-2"></i> Tambah Slider Hero</h2>

    <a href="{{ route('slider_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Daftar
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Formulir Slider Baru
    </div>

    <div class="card-body">

        <form action="{{ route('slider_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Judul</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label fw-bold">Deskripsi</label>
                <textarea name="subtitle" id="subtitle" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Gambar</label>
                <input class="form-control" type="file" id="image" name="image" required>
                <small class="form-text text-muted">Pilih gambar utama untuk slider (rasio lebar, misalnya 16:9)</small>
            </div>

            {{-- <div class="mb-3">
                <label for="link" class="form-label">Link (opsional)</label>
                <input type="url" name="link" id="link" class="form-control">
            </div> --}}

            {{-- <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Aktifkan Slider ini</label>
            </div> --}}

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background-color: #016B61;">
                    <i class="fas fa-save me-1"></i> Simpan Slider
                </button>

                <a href="{{ route('slider_index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection