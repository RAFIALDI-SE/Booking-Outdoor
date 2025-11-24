<header class="header-bg-custom shadow-md sticky-header">
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
        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Link Navigasi --}}
            @if (Route::currentRouteName() === 'home')
                <ul class="navbar-nav mx-auto justify-content-center flex-grow-1 text-sm py-2 py-md-0">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#location">Lokasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contents">Video</a></li>
                </ul>
            @endif

            {{-- 👇 KONTEN PROFILE DROPDOWN (DIPERBAIKI) --}}
            <div class="d-flex ms-md-auto py-2 py-md-0 align-items-center">
                @auth
                <div class="dropdown">
                    {{-- Dropdown Toggle: Ditambahkan class dropdown-toggle untuk fungsionalitas Bootstrap --}}
                    <div class="d-flex align-items-center profile-dropdown-toggle dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        {{-- Pengecekan Gambar Profile --}}
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle me-2 border border-white" style="width: 2rem; height: 2rem; object-fit: cover;">
                        @else
                            {{-- Default image jika tidak ada profile_picture --}}
                            <img src="{{ asset('storage/profile.jpg') }}" alt="Default Profile" class="rounded-circle me-2 border border-white" style="width: 2rem; height: 2rem; object-fit: cover;">
                        @endif

                        <span class="text-white me-2">Hi, {{ explode(' ', Auth::user()->name)[0] }}</span>
                        {{-- Bootstrap akan menangani chevron dengan class dropdown-toggle --}}
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">

                        {{-- Item Dropdown sesuai Group 31.png --}}
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2" style="width: 1rem;"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-basket me-2" style="width: 1rem;"></i> Keranjang</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2" style="width: 1rem;"></i> Riwayat</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            {{-- Logout menggunakan Form POST --}}
                            <li>
                                {{-- Tombol yang memicu modal konfirmasi --}}
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" id="triggerLogoutModal">
                                    <i class="fas fa-sign-out-alt me-2" style="width: 1rem;"></i> Keluar
                                </a>
                            </li>
                        </li>
                    </ul>
                </div>
                @else
                    {{-- Tombol Login/Register jika belum login --}}
                    <a href="#" class="btn btn-sm btn-register-custom px-3 py-1 rounded-pill me-2">Masuk</a>
                    <a href="#" class="btn btn-sm text-white px-3 py-1 rounded-pill">Daftar</a>
                @endauth
            </div>
            {{-- 👆 END KONTEN PROFILE --}}
        </div>
    </nav>
</header>