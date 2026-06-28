<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIRKA Rusunawa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}">
</head>

<body style="font-family: 'Nunito', sans-serif;">
    <section class="relative min-h-screen overflow-hidden bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('assets-admin/images/hero-1.jpg') }}')">

        <div class="absolute inset-0 bg-black/55"></div>

        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8">
            <div class="w-full max-w-md rounded-[10px] bg-white shadow-2xl">
                <div class="px-8 py-7">

                    <div class="flex flex-col items-center text-center">
                        <a href="{{ route('page.beranda') }}">
                            <img src="{{ asset('assets-admin/images/logo/Logo_UNDIP.png') }}" alt="Logo UNDIP"
                                class="h-24 w-auto object-contain">
                        </a>

                        <p class="mt-4 text-[11px] font-extrabold uppercase tracking-[0.22em] text-primary-600">
                            Sistem Informasi Reservasi Kamar <br> Rusunawa Universitas Diponegoro
                        </p>

                        <p class="mt-3 max-w-[320px] text-[15px] leading-6 text-gray-500">
                            Masuk untuk mengakses sistem reservasi kamar Rusunawa UNDIP.
                        </p>
                    </div>
                    {{-- <div style="background:red;color:white;padding:10px;">
                        SUCCESS = {{ session('success') }}
                    </div> --}}
                    @if (session('success'))
                        <div class="mt-5 rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-5 rounded-2xl bg-red-100 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-5 rounded-2xl bg-red-100 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form class="mt-6 space-y-5" action="{{ route('login.store') }}" method="POST">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="name@gmail.com" required
                                class="block w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200">
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-gray-700">
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="********"
                                    class="block w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200">

                                <button type="button" onclick="togglePassword('password','eyeOpen','eyeClosed')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">

                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="hidden h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>

                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex cursor-pointer items-center gap-2">
                                <input id="remember" name="remember" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">

                                <span class="text-sm text-gray-600">
                                    Remember me
                                </span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full rounded-2xl bg-primary-600 px-5 py-3 text-sm font-bold text-white transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 active:scale-[0.98]">
                            Sign In
                        </button>

                        <p class="text-center text-sm text-gray-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-bold text-primary-600 hover:underline">
                                Daftar
                            </a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </section>
    @include('pages.auth.auth-scripts')
</body>

</html>
