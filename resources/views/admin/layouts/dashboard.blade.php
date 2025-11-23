<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Jawati Muroudor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #016B61;
            --color-secondary: #70B2B2;
            --color-light: #FFFFFF;
        }

        body{
            font-family: 'Poppins', sans-serif;
        }

        /* Struktur Utama */
        #wrapper {
            display: flex;
        }

        /* Sidebar Style */
        .sidebar-wrapper {
            width: 250px;
            background-color: var(--color-primary);
            min-height: 100vh;
            color: var(--color-light);
        }

        .sidebar-heading {
            padding: 1rem;
        }

        .list-group-item {
            border: none;
            background-color: var(--color-primary);
            color: var(--color-light);
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 400;
        }

        .list-group-item.active {
            background-color: var(--color-secondary);
            color: var(--color-light);
            font-weight: bold;
        }

        .list-group-item:hover:not(.active) {
            background-color: #038a7c;
        }

        /* Navbar Style */
        .navbar {
            background-color: var(--color-light);
            border-bottom: 1px solid #eee;
        }

        /* PERUBAHAN CSS: Tombol Logout */
        .logout-btn-trigger {
            background-color: #d9534f; /* Warna Merah */
            border-color: #d9534f;
            color: var(--color-light);
            /* Pastikan style modal button sama */
        }

        /* CSS Tambahan untuk Modal sesuai Gambar */
        .modal-body-custom {
            /* Padding vertikal dan horizontal seimbang */
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .modal-content {
             border-radius: 1rem;
        }

        /* Tombol Ya (Warna Primary) */
        .btn-modal-yes {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: var(--color-light);
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            border-radius: 0.5rem;
            min-width: 120px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Tombol Tidak (Warna Merah Bata) */
        .btn-modal-no {
            background-color: #8B4540;
            border-color: #8B4540;
            color: var(--color-light);
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            border-radius: 0.5rem;
            min-width: 120px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Mengganti ikon close Bootstrap */
        .modal-close-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1050;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #000;
            opacity: 1;
        }

        /* Card Style */
        .card-kelola {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
            cursor: pointer;
        }
        .card-kelola:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        .card-icon {
            color: var(--color-primary);
            font-size: 2rem;
            line-height: 1;
        }
        .text-primary-custom { color: var(--color-primary) !important; }
        .text-secondary-custom { color: var(--color-secondary) !important; }
        .btn-kelola {
            color: var(--color-secondary);
            text-decoration: none;
            font-weight: 500;
        }
        .btn-kelola:hover {
            color: var(--color-primary);
        }

    </style>
</head>
<body>

<div id="wrapper">

    {{-- Asumsi kamu menggunakan include ini --}}
    @include('admin.partials.sidebar')

    <div id="page-content-wrapper" class="flex-grow-1">

        <nav class="navbar navbar-expand-lg border-bottom shadow-sm">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    </div>

                <div class="d-flex align-items-center">
                    <span class="me-3">Halo, Admin Jawatimur Outdor</span>

                    {{-- 👇 KODE TOMBOL LOGOUT UNTUK MEMICU MODAL --}}
                    <button
                        type="button"
                        class="btn logout-btn-trigger d-flex align-items-center"
                        data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                    {{-- 👆 END TOMBOL LOGOUT --}}
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @yield('content')
        </div>

    </div>
</div>

{{-- ======================================================= --}}
{{-- 👇 STRUKTUR MODAL LOGOUT (OPTIMASI TATA LETAK) --}}
{{-- ======================================================= --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Tombol Close X (Diposisikan ABSOLUT) --}}
            <button type="button" class="modal-close-icon" data-bs-dismiss="modal" aria-label="Close">
                 <i class="fas fa-times-circle"></i>
            </button>

            {{-- Body Modal (Teks dan Tombol) --}}
            <div class="modal-body modal-body-custom">

                {{-- Teks Konfirmasi (text-center, mb-4, h5 agar lebih rapi) --}}
                <p class="h5 fw-normal mb-4" style="line-height: 1.5; font-size: 1.3rem;">
                    Apakah Anda yakin ingin keluar dari dashboard
                </p>

                {{-- Tombol Aksi (justify-content-center untuk menengahkan) --}}
                <div class="d-flex justify-content-center gap-4 mt-4">

                    {{-- Tombol YA (Logout Submit) --}}
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-modal-yes fw-bold">
                            Ya
                        </button>
                    </form>

                    {{-- Tombol TIDAK (Tutup Modal) --}}
                    <button type="button" class="btn btn-modal-no fw-bold" data-bs-dismiss="modal">
                        Tidak
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- ======================================================= --}}
{{-- 👆 END STRUKTUR MODAL LOGOUT --}}
{{-- ======================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>