<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Aset</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/pages/auth.css') }}">

    {{-- CSS TAMBAHAN AGAR PAS 1 LAYAR (TIDAK SCROLL) --}}
    <style>
        body, html { height: 100%; overflow: hidden; }
        #auth, #auth .row { height: 100vh !important; }
        #auth-left {
            padding: 3rem 5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        @media (max-width: 767px) {
            #auth-left { padding: 2rem; overflow-y: auto; } /* Mobile tetap scroll jika perlu */
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

                    {{-- JUDUL LEBIH RAPAT --}}
                    <h1 class="auth-title fs-2 mb-2">Log in.</h1>
                    <p class="auth-subtitle fs-6 mb-3 text-muted">Masuk ke sistem inventaris.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 fs-6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('auth.login') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required value="{{ old('email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
                    </form>
                    <div class="text-center mt-3 text-sm">
                        <p class="text-gray-600 mb-0">Belum punya akun? <a href="{{ route('auth.register') }}" class="font-bold">Daftar</a>.</p>
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
                    <h2 class="text-white mb-2">Manajemen Aset Digital</h2>
                    <p class="text-white px-5">Sistem pengelolaan inventaris yang transparan dan akuntabel.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>