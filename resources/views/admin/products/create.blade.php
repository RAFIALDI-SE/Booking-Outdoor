@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold">Tambah Data Produk</h2>

    <a href="{{ route('products_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Dahboard
    </a>
</div>

<form action="{{ route('products_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow-sm p-4">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label fw-bold">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label fw-bold">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="price_per_day" class="form-label fw-bold">Harga</label>
                <input type="number" name="price_per_day" id="price_per_day" class="form-control" value="{{ old('price_per_day') }}" required>
            </div>
            <div class="col-md-6">
                <label for="image" class="form-label fw-bold">Gambar</label>
                <input class="form-control" type="file" id="image" name="image" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="category_id" class="form-label fw-bold">Kategori</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="status" value="available">
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <label for="description" class="form-label fw-bold">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-lg btn-block w-100 text-white fw-bold"
                        style="background-color: #70B2B2; border: none;">
                    Tambah Data Produk
                </button>
            </div>
        </div>

    </div>
</form>

@endsection