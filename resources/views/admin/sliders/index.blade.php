@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold">Kelola Slider Hero</h2>
    <a href="{{ route('admin_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Dahboard
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('slider_create') }}" class="btn btn-sm text-white" style="background-color: #016B61;">
        <i class="fas fa-plus-circle me-1"></i> Tambah Slider
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Daftar Gambar Slider Utama
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-2" style="width: 5%;">No</th>
                        <th class="py-2" style="width: 15%;">Judul</th>
                        <th class="py-2" style="width: 35%;">Deskripsi</th>
                        <th class="py-2" style="width: 20%;">Gambar</th>
                        <th class="py-2" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $slider->title }}</td>
                        <td class="align-middle">{{ Str::limit($slider->subtitle ?? 'Tidak ada deskripsi', 150) }}</td>
                        <td class="align-middle">
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" class="img-fluid rounded" style="max-height: 80px; width: auto; object-fit: cover;">
                        </td>
                        <td class="align-middle">
                            <div class="d-flex gap-2">
                                <a href="{{ route('slider_edit', $slider->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- 👇 PERUBAHAN DI SINI: Tombol Hapus memanggil modal --}}
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-id="{{ $slider->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                {{-- 👆 Akhir Perubahan --}}

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data slider yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    @if(method_exists($sliders, 'links'))
        {{ $sliders->links() }}
    @endif
</div>

{{-- ================================================================= --}}
{{-- (A) KODE MODAL HAPUS (Ditempatkan di akhir file sebelum @endsection) --}}
{{-- ================================================================= --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius: 0.75rem;">
            <div class="modal-body p-5">
                <h4 class="mb-4 fw-bold">Anda Yakin Ingin Menghapus?</h4>

                {{-- Form untuk mengirim request DELETE --}}
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="d-flex justify-content-center gap-3">
                        {{-- Tombol Ya (Warna Hijau Primary) --}}
                        <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #016B61; border: none;">
                            Ya
                        </button>

                        {{-- Tombol Tidak (Warna Merah Bata) --}}
                        <button type="button" class="btn text-white px-4 fw-bold" data-bs-dismiss="modal" style="background-color: #a94442; border: none;">
                            Tidak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================= --}}
{{-- (C) JAVASCRIPT UNTUK MODAL (Ditempatkan di bagian bawah sebelum @endsection) --}}
{{-- ================================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Dapatkan tombol yang mengaktifkan modal
            const button = event.relatedTarget;
            // Ambil ID dari data-id atribut
            const sliderId = button.getAttribute('data-id');

            // Tentukan URL aksi form
            // CATATAN: Ganti 'slider_destroy' dengan nama route hapus yang benar
            const actionUrl = "{{ route('slider_destroy', 'ID_PLACEHOLDER') }}";

            // Ganti placeholder dengan ID yang sebenarnya
            deleteForm.action = actionUrl.replace('ID_PLACEHOLDER', sliderId);
        });
    });
</script>

@endsection