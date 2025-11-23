@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold"><i class="fas fa-edit me-2"></i> Edit Slider Hero</h2>

    <a href="{{ route('slider_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Daftar
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #016B61; font-weight: 600;">
        Formulir Edit Slider
    </div>

    <div class="card-body">

        <form action="{{ route('slider_update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Judul</label>
                <input type="text" name="title" id="title"
                       value="{{ old('title', $slider->title) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Deskripsi</label>
                {{-- Asumsi kamu menggunakan kolom 'description' di database --}}
                <textarea name="subtitle" id="subtitle" class="form-control" rows="3">{{ old('description', $slider->description ?? $slider->subtitle) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-bold">Gambar (kosongkan jika tidak diubah)</label>
                <input class="form-control" type="file" id="image" name="image">
                <small class="form-text text-muted">Pilih gambar baru, atau biarkan kosong untuk mempertahankan gambar lama.</small>

                @if ($slider->image)
                    <p class="mt-2 mb-1">Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" class="img-thumbnail rounded" style="max-height: 100px; width: auto; object-fit: cover;">
                @endif
            </div>

            {{-- <div class="mb-3">
                <label for="link" class="form-label fw-bold">Link (opsional)</label>
                <input type="url" name="link" id="link"
                       value="{{ old('link', $slider->link) }}"
                       class="form-control">
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan Slider ini</label>
            </div> --}}

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background-color: #016B61;">
                    <i class="fas fa-save me-1"></i> Update
                </button>

                <a href="{{ route('slider_index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection