<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIRKA Rusunawa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets-admin/images/logo/logo-undip-01.png') }}">
    <style>
        .iti {
            width: 100%;
        }

        .iti__country-list {
            z-index: 999999 !important;
            max-height: 280px !important;
            overflow-y: auto !important;
        }

        .iti__dropdown-content {
            z-index: 999999 !important;
        }

        .iti--container {
            z-index: 999999 !important;
        }
    </style>
</head>

<body>
    <section class="relative min-h-screen overflow-visible bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('assets-admin/images/hero-1.jpg') }}')">

        <div class="absolute inset-0 bg-black/55"></div>

        <div class="relative z-10 flex h-screen items-center justify-center px-4">
            <div class="w-full max-w-[450px] rounded-[24px] bg-white shadow-2xl">
                <div class="px-5 py-4">

                    <div class="flex flex-col items-center text-center">
                        <a href="{{ route('page.beranda') }}">
                            <img src="{{ asset('assets-admin/images/logo/Logo_UNDIP.png') }}" alt="Logo UNDIP"
                                class="h-14 md:h-16 w-auto object-contain">
                        </a>

                        <p class="mt-2 text-[9px] font-extrabold uppercase tracking-[0.15em] text-primary-600">
                            Sistem Informasi Reservasi Kamar <br> Rusunawa Universitas Diponegoro
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Buat akun untuk mengajukan reservasi kamar Rusunawa UNDIP.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-4 rounded-xl bg-red-100 px-4 py-2 text-sm text-red-700">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form class="mt-3 space-y-2" action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div>
                            <label for="nama" class="mb-1 block text-sm font-bold text-gray-700">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                placeholder="Nama Lengkap" required
                                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200">
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-bold text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="name@gmail.com" required
                                class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 outline-none transition focus:border-primary-500 focus:ring-4 focus:ring-primary-200">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-gray-700">
                                Jenis Kelamin
                            </label>

                            <div class="grid grid-cols-2 gap-3">
                                <label
                                    class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-primary-50">
                                    <input type="radio" name="gender" value="laki-laki" required
                                        {{ old('gender') === 'laki-laki' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500">
                                    Laki-Laki
                                </label>

                                <label
                                    class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-primary-50">
                                    <input type="radio" name="gender" value="perempuan" required
                                        {{ old('gender') === 'perempuan' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500">
                                    Perempuan
                                </label>
                            </div>
                        </div>

                        <div>

                            <label class="block mb-2 text-sm font-bold text-slate-800">
                                Nomor WhatsApp <span class="text-red-500">*</span>
                            </label>

                            <input type="tel" id="number_phone" name="number_phone" required
                                value="{{ old('number_phone') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm focus:border-orange-500 focus:ring-orange-500">
                            <p class="mt-2 text-xs text-slate-500">
                                Gunakan nomor WhatsApp aktif.
                            </p>
                            {{-- <input type="tel" name="number_phone" id="number_phone"
                                value="{{ old('number_phone') }}" placeholder="8xxxxxxxxxx" required
                                class="w-full rounded-2xl border border-slate-300 px-4 py-2 text-sm focus:border-orange-500 focus:ring-orange-500"> --}}
                        </div>

                        <div>
                            <label for="password" class="mb-1 block text-sm font-bold text-gray-700">
                                Password
                            </label>

                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="********"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12">

                                <button type="button" onclick="togglePassword('password','eyeOpen1','eyeClosed1')"
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-500">
                                    <svg id="eyeClosed1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class=" hidden h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>



                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-1 block text-sm font-bold text-gray-700">
                                Konfirmasi Password
                            </label>

                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="********"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-2 pr-12">

                                <button type="button"
                                    onclick="togglePassword('password_confirmation','eyeOpen2','eyeClosed2')"
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-500">
                                    <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class=" h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="hidden h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-primary-600 px-5 py-2 text-center text-sm font-bold text-white transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 active:scale-[0.98]">
                            Daftar Sekarang
                        </button>

                        <p class="text-center text-sm text-gray-500">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:underline">
                                Log in
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
