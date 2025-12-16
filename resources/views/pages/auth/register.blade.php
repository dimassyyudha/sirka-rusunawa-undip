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

    <style>
        body, html { height: 100%; overflow: hidden; }
        #auth, #auth .row { height: 100vh !important; }
        #auth-left {
            padding: 2rem 4rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        @media (max-width: 767px) {
            #auth-left { padding: 2rem; overflow-y: auto; }
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="logo text-center mb-3">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('assets-admin/images/logo/lg_vertikal.png') }}"
                                 alt="Logo"
                                 style="height: 160px; width: auto; object-fit: contain;">
                        </a>
                    </div>

                    <h1 class="auth-title fs-3 mb-1">Sign Up</h1>
                    <p class="auth-subtitle fs-6 mb-3 text-muted">Daftar akun baru.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-1 fs-7 mb-2">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('auth.register') }}" method="POST">
                        @csrf
                        {{-- Input lebih rapat (mb-2) --}}
                        <div class="form-group position-relative has-icon-left mb-2">
                            <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-2">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-2">
                            <select name="role" class="form-select" style="padding-left: 2.5rem;" required>
                                <option value="" disabled selected>-- Pilih Role Pengguna --</option>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff Inventaris</option>
                                <option value="kades">Kepala Desa</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-2">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-3 text-sm">
                        <p class='text-gray-600 mb-0'>Sudah punya akun? <a href="{{ route('auth.login') }}" class="font-bold">Log in</a>.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block p-0">
                <div id="auth-right" style="
                    height: 100vh;
                    background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('assets-admin/images/bg/inventaris-bg.jpg') }}');
                    background-size: cover;
                    background-position: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
                    text-align: center;
                    color: white;
                ">
                   <h2 class="text-white">Bergabunglah Bersama Kami</h2>
                   <p class="text-white px-5">Daftarkan diri Anda untuk mulai mengelola aset desa secara digital.</p>
                   </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>