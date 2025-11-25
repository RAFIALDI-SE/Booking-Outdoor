@extends('members.layouts.app')

@section('title', 'Profil Pengguna')

@section('content')

{{-- Latar Belakang Putih (#fff) --}}
{{-- Padding vertikal dikurangi (py-4) --}}
<div class="min-vh-100 py-4" style="background-color: #ffffff;">
    <div class="container d-flex justify-content-center pt-md-4">

        {{-- Kartu Profil (Warna: #016B61) --}}
        {{-- Max-width dikurangi menjadi 600px dan padding dikurangi (p-4) --}}
        <div class="card shadow-lg p-4 w-100 text-white" style="max-width: 600px; border-radius: 1rem; background-color: #016B61;">

            {{-- Bagian Atas: Foto & Info Statis --}}
            <div class="d-flex flex-column align-items-center mb-3">
                {{-- Foto Profil --}}
                {{-- Ukuran dikurangi (100px) --}}
                <img src="#"
                    alt="Foto Profil"
                    class="rounded-circle mb-2"
                    style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #70B2B2;"> {{-- Border dikurangi --}}

                <h2 class="h5 fw-bold mt-2" style="color: #ffffff;">Profil Pengguna</h2> {{-- Ukuran Judul dikurangi (h5) --}}
                <p class="text-light mb-1" style="font-size: 0.9rem;">alfan</p>

                {{-- Informasi Statis (Blok) --}}
                <div class="text-center text-light mt-3" style="max-width: 300px; font-size: 0.9rem;">
                    <p class="mb-1"><strong>Nama Lengkap :</strong> alfan mufti</p>
                    <p class="mb-1"><strong>Alamat Email :</strong> alfan@gmail.com </p>
                    <p class="mb-1"><strong>Role :</strong> Member</p>
                </div>
            </div>

            <hr class="mb-4" style="border-color: #70B2B2;">

            @if (session('success'))
                <div class="alert alert-info text-dark text-center mb-4 p-2" role="alert" style="font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Edit Profil --}}
            <form action="{{ route('profile_update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Row spacing dikurangi (g-3) --}}
                <div class="row g-3">

                    {{-- Semua form-label dikurangi ukurannya menjadi text-sm --}}
                    {{-- 1. Nama (Kiri) --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label text-light" style="font-size: 0.85rem;">Nama</label>
                        <input type="text"
                            name="name"
                            id="name"
                            value="#"
                            class="form-control form-control-sm" {{-- form-control-sm --}}
                            style="background-color: #068478; border-color: #70B2B2; color: #fff;"
                            required>
                    </div>

                    {{-- 2. No. Telepon (Kanan) --}}
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label text-light" style="font-size: 0.85rem;">No. Telepon</label>
                        <input type="text"
                            name="phone_number"
                            id="phone_number"
                            value="#"
                            class="form-control form-control-sm" {{-- form-control-sm --}}
                            style="background-color: #068478; border-color: #70B2B2; color: #fff;">
                    </div>

                    {{-- 3. Kata Sandi Baru (Kiri) --}}
                    <div class="col-md-6">
                        <label for="new_password" class="form-label text-light" style="font-size: 0.85rem;">Kata Sandi Baru</label>
                        <input type="password"
                            name="new_password"
                            id="new_password"
                            class="form-control form-control-sm" {{-- form-control-sm --}}
                            style="background-color: #068478; border-color: #70B2B2; color: #fff;">
                    </div>

                    {{-- 4. Konfirmasi Sandi (Kanan) --}}
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label text-light" style="font-size: 0.85rem;">Konfirmasi Sandi</label>
                        <input type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control form-control-sm" {{-- form-control-sm --}}
                            style="background-color: #068478; border-color: #70B2B2; color: #fff;">
                    </div>

                    {{-- 5. Foto Profil (Kiri) --}}
                    <div class="col-md-6">
                        <label for="profile_picture" class="form-label text-light" style="font-size: 0.85rem;">Foto Profil</label>
                        <input type="file"
                            name="profile_picture"
                            id="profile_picture"
                            class="form-control form-control-sm" {{-- form-control-sm --}}
                            style="background-color: #068478; border-color: #70B2B2; color: #fff;">
                    </div>

                    {{-- 6. Slot Kosong / bisa diisi elemen lain jika diperlukan, atau hilangkan col-md-6 ini --}}
                    <div class="col-md-6">
                        {{-- Kosong --}}
                    </div>

                    <input type="hidden" name="email" value="#">
                    <input type="hidden" name="gender" value="#">

                </div>

                {{-- Tombol Aksi --}}
                {{-- Margin atas dikurangi (mt-4) dan ukuran tombol dikurangi (btn-md) --}}
                <div class="mt-4 d-grid gap-3">
                    {{-- Tombol Simpan Perubahan (Warna #70B2B2) --}}
                    <button type="submit" class="btn btn-md text-dark shadow fw-bold" style="background-color: #70B2B2; border-color: #70B2B2;">
                        Simpan Perubahan
                    </button>

                    {{-- Tombol Kembali Ke Beranda (Outline) --}}
                    <a href="{{ route('home') }}" class="btn btn-md fw-bold" style="color: #70B2B2; border-color: #70B2B2; background-color: #fff;">
                        Kembali Ke Beranda
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection