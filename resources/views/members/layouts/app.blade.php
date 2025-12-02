<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jawatimur Outdoor')</title>

    {{-- 👇 Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Definisi Warna Custom */
        :root {
            --primary: #016B61; /* Hijau Tua */
            --secondary: #70B2B2; /* Hijau Kebiruan */
            --product-card-bg: #80C8C8;
        }
        .bg-primary-custom { background-color: var(--primary); }
        .text-primary-custom { color: var(--primary); }
        .btn-register-custom { background-color: white !important; color: var(--primary) !important; font-weight: 600; }

        /* HEADER DAN FOOTER TETAP FULL WIDTH */
        .header-bg-custom { background-color: var(--primary); }
        .navbar-nav .nav-link { color: white !important; font-weight: 600; padding-left: 1rem; padding-right: 1rem; }
        .navbar-brand h1 { color: white !important; font-size: 1.25rem; }
        .sticky-header { position: sticky; top: 0; left: 0; right: 0; z-index: 1050; }

        /* Dropdown Profile */
        .profile-dropdown-toggle {
            cursor: pointer;
            padding: 0.5rem 0.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s;
        }
        .profile-dropdown-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Styling Dropdown Menu */
        .dropdown-menu {
            min-width: 12rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background-color: #f0f0f0; /* Latar belakang abu-abu terang */
            padding: 0;
            border: none;
        }
        .dropdown-item {
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #333;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }
        .dropdown-item:hover {
            background-color: #ddd;
        }


        /* Perbaikan Kartu Produk */
        .product-card-custom { background-color: var(--product-card-bg); transition: all 0.3s ease; }
        .product-card-custom:hover { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); transform: translateY(-5px); }
        .product-card-detail-btn { background-color: #015049; }
        /* SLIDER OVERLAY */
        .slider-text-overlay { text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); }
        .carousel-item img { height: 550px; object-fit: cover; }
        /* Konten IG */
        .content-image-wrapper { padding-top: 150%; position: relative; overflow: hidden; }
        .content-image-wrapper img { position: absolute; top: 0; start: 0; width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- 🧩 HEADER --}}
    @include('members.includes.header')

    {{-- 🧩 KONTEN UTAMA --}}
    <main>
        @yield('content')
    </main>

    {{-- 🧩 FOOTER --}}
    @include('members.includes.footer')

    {{-- 👇 Bootstrap JS dan JavaScript Kustom --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbarCollapse = document.getElementById('navbarNav');

            // 1. Inisialisasi Smooth Scroll & Menutup Menu Mobile
            document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener("click", function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href");
                    const targetElement = document.querySelector(targetId);

                    // Logic untuk menutup menu setelah link diklik (diperlukan untuk mobile)
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }

                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                        });
                    }
                });
            });

            // 2. Inisialisasi Carousel Bootstrap
            const heroCarousel = document.getElementById("heroCarousel");
            if (heroCarousel) {
                const carouselInstance = new bootstrap.Carousel(heroCarousel, {
                    interval: 5000,
                    wrap: true,
                });

                // Pause/Cycle saat hover
                heroCarousel.addEventListener('mouseenter', () => carouselInstance.pause());
                heroCarousel.addEventListener('mouseleave', () => carouselInstance.cycle());
            }

            const confirmLogoutButton = document.getElementById('confirmLogoutButton');
            if (confirmLogoutButton) {
                confirmLogoutButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.getElementById('logout-form').submit();
                });
            }


        });

    </script>
    @yield('scripts')


    {{-- START: Modal Konfirmasi Logout --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content p-3" style="border-radius: 1rem;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <h5 class="modal-title fs-4 fw-bold mb-4" id="logoutModalLabel">Anda Yakin Ingin Keluar Akun?</h5>

                    <div class="d-flex justify-content-center gap-3">

                        {{-- Tombol Ya (Akan menjalankan Logout Form) --}}
                        <a href="#" id="confirmLogoutButton" class="btn text-white fw-bold py-2 px-4" style="background-color: #016B61;">Ya</a>

                        {{-- Tombol Tidak (Menutup Modal) --}}
                        <button type="button" class="btn text-white fw-bold py-2 px-4" data-bs-dismiss="modal" style="background-color: #A33C3C;">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Konfirmasi Logout --}}

    {{-- Form Logout Tersembunyi untuk dipicu oleh Modal --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- END: Modal Konfirmasi Logout --}}
</body>
</html>