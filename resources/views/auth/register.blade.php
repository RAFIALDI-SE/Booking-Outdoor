<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Jawatimur Outdoor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* CSS ini dipertahankan dari halaman Login agar konsisten */
        body { background-color: #f0f0f0; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; font-family: Arial, sans-serif; }
        .register-container { background-color: #ffffff; padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; text-align: center; }
        .register-container h2 { font-size: 1.5rem; color: #333; margin-bottom: 2rem; }
        .form-control { border-color: #ced4da; padding: 0.75rem 1rem; height: auto; }
        .form-control:focus { border-color: #016B61; box-shadow: 0 0 0 0.25rem rgba(1, 107, 97, 0.25); }
        .input-group-text { background-color: #e9ecef; border-color: #ced4da; }
        .btn-primary-custom { background-color: #016B61; border-color: #016B61; padding: 0.75rem 1.5rem; font-size: 1.1rem; font-weight: bold; transition: background-color 0.3s ease; }
        .btn-primary-custom:hover { background-color: #00564e; border-color: #00564e; }
        .link-secondary-custom { color: #70B2B2; text-decoration: none; transition: color 0.3s ease; }
        .link-secondary-custom:hover { color: #016B61; text-decoration: underline; }
        .logo-img { max-width: 200px; margin-bottom: 2.5rem; }
        .register-text { margin-top: 1.5rem; font-size: 0.9rem; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { text-align: left; }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="{{ url('storage/jawatimuroutdoor-logo-colorful.png') }}" alt="Logo Jawatimur Outdoor" class="logo-img">
        <h2 class="mb-4">Buat Akun Baru</h2>

        {{-- Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3 small text-start">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('registerStore')}}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-3 text-start">
                <label for="name" class="form-label visually-hidden">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3 text-start">
                <label for="email" class="form-label visually-hidden">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kata Sandi --}}
            <div class="mb-3 text-start">
                <label for="password" class="form-label visually-hidden">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" placeholder="Kata Sandi" required>
                    <button class="btn btn-outline-secondary input-group-text toggle-password" type="button" data-target="password">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Konfirmasi Kata Sandi (Wajib name="password_confirmation") --}}
            <div class="mb-4 text-start">
                <label for="password_confirmation" class="form-label visually-hidden">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                    <button class="btn btn-outline-secondary input-group-text toggle-password" type="button" data-target="password_confirmation">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                    {{-- Error konfirmasi password akan ditampilkan melalui error('password') --}}
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 mb-4 text-white">Daftar</button>
        </form>

        <a href="{{route('onboarding')}}" class="link-secondary-custom d-block mb-3">Kembali</a>

        <p class="register-text">Sudah Punya Akun?
            <a href="#" class="link-secondary-custom fw-bold">Masuk Sini</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika untuk toggle password pada semua field
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetId);
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle ikon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>