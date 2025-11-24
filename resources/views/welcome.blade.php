<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawatimur Outdoor - Rental Alat Outdoor Terbaik</title>

    {{-- 👇 Tambahkan Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Definisi Warna Custom */
        :root {
            --primary: #016B61; /* Hijau Tua */
            --secondary: #70B2B2; /* Hijau Kebiruan */
            --product-card-bg: #80C8C8;
        }
        /* Custom classes (diubah dari Tailwind ke CSS murni) */
        .bg-primary-custom { background-color: var(--primary); }
        .text-primary-custom { color: var(--primary); }

        /* PERBAIKAN HEADER: Latar belakang full width */
        .header-bg-custom { background-color: var(--primary); }

        /* Pastikan link di navbar berwarna putih */
        .navbar-nav .nav-link { color: white !important; font-weight: 600; padding-left: 1rem; padding-right: 1rem; }
        .navbar-brand h1 { color: white !important; font-size: 1.25rem; }

        /* 👇 HOVER LOGIN/REGISTER */
        .btn-login-custom { transition: opacity 0.3s; }
        .btn-login-custom:hover { opacity: 0.8; color: white !important; }

        .btn-register-custom {
            background-color: white !important;
            color: var(--primary) !important;
            font-weight: 600;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .btn-register-custom:hover {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); /* Shadow tipis putih */
            transform: translateY(-1px); /* Efek angkat sangat tipis */
        }

        /* HEADER DAN FOOTER TETAP FULL WIDTH */
        .sticky-header {
            position: sticky; top: 0; left: 0; right: 0; z-index: 1050;
        }

        /* Navigasi mobile kustom */
        .navbar-collapse-custom { background-color: var(--primary); }

        /* Perbaikan Kartu Produk */
        .product-card-custom {
            background-color: var(--product-card-bg);
            transition: all 0.3s ease;
        }
        .product-card-custom:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        .product-card-detail-btn {
            background-color: #015049;
        }

        /* SLIDER OVERLAY */
        .carousel-item img {
            height: 550px;
            object-fit: cover;
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    {{-- 👇 HEADER DENGAN PERBAIKAN LEBAR --}}
    <header class="header-bg-custom shadow-md sticky-header">
        {{-- Hapus 'max-w-7xl mx-auto' dari nav, ganti dengan container --}}
        <nav class="navbar navbar-expand-md container px-4 py-3">
            {{-- Logo dan Judul --}}
            <a class="navbar-brand d-flex align-items-center" href="#hero">
                <img src="{{ url('storage/FunventureLogo.png') }}" class="rounded-circle me-2" alt="Logo" style="height: 2rem; width: 2rem;">
                <h1 class="font-weight-bold mb-0">FunventureOutdoor</h1>
            </a>

            {{-- Tombol Toggle Menu (Hanya muncul di Mobile) --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>

            {{-- Konten Navigasi --}}
            <div class="collapse navbar-collapse navbar-collapse-custom" id="navbarNav">

                {{-- Link Navigasi --}}
                <ul class="navbar-nav justify-content-center flex-grow-1 text-sm py-2 py-md-0">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#location">Lokasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contents">Video</a></li>
                </ul>

                {{-- Login/Register --}}
                <div class="d-flex flex-column flex-md-row ms-md-auto py-2 py-md-0 align-items-md-center gap-2">
                    {{-- Tombol Login dengan class hover baru --}}
                    <a href="#" class="btn btn-sm text-white btn-login-custom">Login</a>
                    {{-- Tombol Register dengan class hover baru --}}
                    <a href="#" class="btn btn-sm btn-register-custom rounded">Register</a>
                </div>
            </div>
        </nav>
    </header>

    {{-- SLIDER DENGAN STRUKTUR BOOTSTRAP CAROUSEL --}}
    <section id="hero" class="relative overflow-hidden w-100">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" onmouseenter="new bootstrap.Carousel(this).pause()" onmouseleave="new bootstrap.Carousel(this).cycle()">

            <div class="carousel-inner">
                @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$slider->image) }}" class="d-block w-100" alt="{{ $slider->title ?? 'Slider' }}">

                    <div class="carousel-caption d-block text-start" style="bottom: 10%; left: 5%; right: auto; padding: 0; text-align: left !important;">
                        <div class="slider-text-overlay p-4">
                            <h2 class="display-3 fw-bolder">{{ $slider->title ?? 'Promo Utama' }}</h2>
                            <p class="lead fw-normal">{{ $slider->subtitle ?? 'Cepat sebelum kehabisan!' }}</p>
                            @if ($slider->link ?? false)
                                <a href="{{ $slider->link }}" class="btn btn-primary bg-primary-custom mt-4 px-4 py-2 rounded-lg fw-bold">Lihat Selengkapnya</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Tombol Navigasi Bootstrap --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section id="products" class="py-5">
        <div class="container px-4">
            <h2 class="text-center display-4 fw-bold mb-5">Produk Outdoor Kami</h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @foreach($products->take(6) as $product)
                    <div class="col">
                        <div class="p-0 rounded-3 product-card-custom shadow-sm overflow-hidden">
                            <div class="position-relative w-100" style="height: 224px;">
                                <img src="{{ asset('storage/'.$product->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                            </div>
                            <div class="p-4 text-center text-white">
                                <h3 class="h4 fw-bold">{{ $product->name }}</h3>
                                <p class="lead fw-semibold mb-2">Stok {{ $product->stock ?? 0 }}</p>

                                <a href="#" class="btn w-100 product-card-detail-btn text-white py-2 rounded-3 fw-bold">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-light bg-primary-custom text-white px-5 py-2 rounded-lg fw-bold">
                    View All
                </a>
            </div>
        </div>
    </section>

    <section id="location" class="py-5 bg-light">
        <div class="container px-4">
            <h2 class="text-center display-5 fw-bold mb-4">Lokasi Kami</h2>
            <div class="bg-white p-3 rounded-3 shadow-lg border">
                <div class="w-100" style="height: 400px; overflow: hidden; border-radius: 0.5rem;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.746585734812!2d112.59478997482!3d-7.921516892102058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7881f5405daac1%3A0xb39e4847109109e4!2sUniversitas%20Muhammadiyah%20Malang%20(UMM%20III)!5e0!3m2!1sid!2sid!4v1762788579998!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Jawatimuroutdoor"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section id="contents" class="py-5">
        <div class="container px-4">
            <h2 class="text-center display-5 fw-bold mb-4">Jejak Kami di Media Sosial</h2>
            <div class="d-flex align-items-center mb-3">
                <img src="{{ url('storage/FunventureLogo.png') }}" class="rounded-circle me-3" alt="Logo IG" style="width: 3rem; height: 3rem;">
                <span class="h5 fw-bold mb-0">FunventureOutdoor</span>
            </div>
            <p class="text-muted mb-4">Pusat perlengkapan camping dan hiking Jawa Timur. Kami menyediakan semua yang kamu butuhkan untuk petualanganmu!</p>

            <div class="row row-cols-2 row-cols-sm-4 row-cols-lg-6 g-3">
                @foreach($contents->take(12) as $content)
                    <div class="col">
                        <a href="{{ $content->link }}" target="_blank" class="d-block position-relative">
                            <div class="content-image-wrapper rounded shadow" style="padding-top: 150%;">
                                <img src="{{ asset('storage/'.$content->image) }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rounded" alt="Content Image">
                            </div>
                            <div class="position-absolute inset-0 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition">
                                <i class="fas fa-play text-white fs-3 bg-black bg-opacity-50 p-3 rounded-circle"></i>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-primary-custom text-white py-4">
        {{-- Footer content juga di dalam container --}}
        <div class="container px-4">
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <div>
                    <h4 class="h5 fw-bold mb-3">Address:</h4>
                    <p class="small mb-1">Ruko Motor Sports Tani Asri Blok B, Jalan Perjuangan, Landungsari, Dau, Kabupaten Malang, Jawa Timur</p>
                    <p class="small">(089)-xxxx-xxxx</p>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <a href="https://instagram.com/jawatimuroutdoor" target="_blank" class="text-white fs-4 hover-text-gray-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>

                <div>
                    <h4 class="h5 fw-bold mb-3">About Us</h4>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white text-decoration-none hover-underline">About</a></li>
                        <li><a href="#" class="text-white text-decoration-none hover-underline">News & Events</a></li>
                        <li><a href="#" class="text-white text-decoration-none hover-underline">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-3 small border-top border-white border-opacity-25 pt-3">
                <p class="mb-0">Copyright Jawatimuroutdoor © 2025. All Right Reserved.</p>
            </div>
        </div>
    </footer>

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

            // 3. Optional: Header Scroll Class
            const header = document.querySelector(".sticky-header");
            if (header) {
                window.onscroll = () => {
                    if (window.scrollY > 50) {
                        // header.classList.add("scrolled");
                    } else {
                        // header.classList.remove("scrolled");
                    }
                };
            }
        });
    </script>
</body>
</html>