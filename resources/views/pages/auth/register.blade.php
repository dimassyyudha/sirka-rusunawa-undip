<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Inventaris Aset</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/pages/auth.css') }}">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="logo" style="text-align: center; margin-bottom: 1rem;">
                        <a href="{{ route('dashboard') }}">
                            <img style="width: 350px; height: auto; max-width: 90%;"
                                 src="{{ asset('assets-admin/images/logo/logo-baru.png') }}" alt="Logo">
                        </a>
                    </div>
                    <h1 class="auth-title">Registrasi Akun</h1>
                    <p class="auth-subtitle mb-5">Daftar untuk mendapatkan akses sistem.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('auth.register') }}" method="POST">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap" name="nama" value="{{ old('nama') }}" required>
                            <div class="form-control-icon"><i class="bi bi-person-lines-fill"></i></div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" value="{{ old('email') }}" required>
                            <div class="form-control-icon"><i class="bi bi-envelope"></i></div>
                        </div>

                        {{-- PILIHAN ROLE (Baru Ditambahkan) --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="role" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="staff">Staff Inventaris</option>
                                <option value="kades">Kepala Desa (Monitoring)</option>
                                {{-- Admin sebaiknya tidak bisa dipilih sembarangan, tapi untuk demo bisa dibuka --}}
                                <option value="admin">Administrator</option>
                            </select>
                            <div class="form-control-icon"><i class="bi bi-person-badge"></i></div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" required>
                            <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Confirm Password" name="password_confirmation" required>
                            <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end mb-4">
                            <input class="form-check-input me-2" type="checkbox" id="agree_terms" name="agree_terms" required>
                            <label class="form-check-label text-gray-600" for="agree_terms">
                                Saya setuju dengan <a href="#">syarat & ketentuan</a>.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Sign Up</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Sudah punya akun? <a href="{{ route('auth.login') }}" class="font-bold">Log in</a>.</p>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan (Gambar Background) --}}
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"
                    style="
                        background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('assets-admin/images/bg/inventaris-bg.jpg') }}');
                        background-size: cover;
                        background-position: center;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-direction: column;
                        padding: 2rem;
                        text-align: center;
                        color: white;
                    ">
                    <h2 style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Bergabunglah Bersama Kami</h2>
                    <p style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7); font-size: 1.2rem;">
                        Daftarkan diri Anda untuk mulai mengelola aset desa secara digital.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>