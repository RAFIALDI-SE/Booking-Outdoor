@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 fw-bold">Konten</h2>

    <a href="{{ route('admin_index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali Ke Dashboard
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('contents_create') }}" class="btn btn-sm text-white" style="background-color: #016B61;">
        <i class="fas fa-plus-circle me-1"></i> Tambah Konten
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header" style="background-color: #70B2B2; color: #fff; font-weight: 600;">
        Daftar Konten
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-2" style="width: 5%;">No</th>
                        <th class="py-2" style="width: 50%;">Link</th>
                        <th class="py-2" style="width: 20%;">Gambar</th>
                        <th class="py-2" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $c)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ $c->link }}" target="_blank" style="word-break: break-all;">{{ $c->link }}</a>
                        </td>
                        <td class="align-middle">
                            <img src="{{ asset('storage/'.$c->image) }}" alt="Content Image" class="img-fluid rounded" style="max-height: 80px; width: auto; object-fit: cover;">
                        </td>

                        <td class="align-middle">
                            <div class="d-flex gap-2">
                                <a href="{{ route('contents_edit', $c->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-id="{{ $c->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data konten yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================================================================= --}}
{{-- MODAL HAPUS (Replikasi Modal yang Sama) --}}
{{-- ================================================================= --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius: 0.75rem;">
            <div class="modal-body p-5">
                <h4 class="mb-4 fw-bold">Anda Yakin Ingin Menghapus?</h4>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #016B61; border: none;">
                            Ya
                        </button>
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
{{-- JAVASCRIPT MODAL (Diperbarui untuk route contents_destroy) --}}
{{-- ================================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const contentId = button.getAttribute('data-id');

            // Ganti route: products_destroy menjadi contents_destroy
            const actionUrl = "{{ route('contents_destroy', 'ID_PLACEHOLDER') }}";

            deleteForm.action = actionUrl.replace('ID_PLACEHOLDER', contentId);
        });
    });
</script>

@endsection