@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold"><i class="fas fa-edit me-2"></i> Edit Kategori Produk</h2>

    <a href="{{ route('categories_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Daftar
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #016B61; font-weight: 600;">
        Formulir Edit Kategori
    </div>

    <div class="card-body">

        <form action="{{ route('categories_update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nama Kategori</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $category->name) }}"
                       class="form-control" required>
            </div>

            {{-- <div class="mb-3">
                <label for="description" class="form-label fw-bold">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="icon" class="form-label fw-bold">Ikon (kosongkan jika tidak diubah)</label>
                <input class="form-control" type="file" id="icon" name="icon">
                <small class="form-text text-muted">Pilih ikon baru, atau biarkan kosong untuk mempertahankan yang lama.</small>

                @if($category->icon)
                    <p class="mt-2 mb-1">Ikon saat ini:</p>
                    <img src="{{ asset('storage/' . $category->icon) }}" alt="Category Icon" class="img-thumbnail rounded" style="max-height: 64px; width: auto; object-fit: cover;">
                @endif
            </div> --}}

            <hr>

            <div class="d-flex gap-2">
                <button type="submit" class="btn text-white" style="background-color: #016B61;">
                    <i class="fas fa-save me-1"></i> Update Kategori
                </button>

                <a href="{{ route('categories_index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection