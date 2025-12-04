@extends('members.layouts.app')

@section('title', 'Home - Funventure Outdoor')

@section('content')

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

    {{-- Bagian Konten Utama Tetap Menggunakan Struktur Container --}}
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

                                <a href="{{route('products_detail', $product->id)}}" class="btn w-100 product-card-detail-btn text-white py-2 rounded-3 fw-bold">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('products_all') }}" class="btn btn-light bg-primary-custom text-white px-5 py-2 rounded-lg fw-bold">
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

@endsection

{{-- Tidak perlu lagi section scripts karena JS ada di layout utama dan tidak ada script baru di home --}}