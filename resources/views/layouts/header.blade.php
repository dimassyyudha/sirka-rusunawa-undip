<header class="mb-3">
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            {{-- HAMBURGER UNTUK MOBILE --}}
            {{-- <a href="#" class="burger-btn d-block">
                <i class="bi bi-list fs-3"></i>
            </a> --}}

            {{-- default bootstrap toggler (kalau mau, boleh nanti di-hide) --}}
            {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> --}}

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- kalau mau isi menu kanan custom, taruh di sini --}}
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0"></ul>

                {{-- AREA PROFIL USER --}}
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex align-items-center">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">
                                    {{-- bisa diisi nama kalau mau --}}
                                </h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ auth()->user()?->role ?? 'Guest' }}
                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    @if (Auth::user()->profile_photo)
                                        <img src="{{ asset('uploads/profile_pictures/' . Auth::user()->profile_photo) }}"
                                            alt="Foto Profil" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets-admin/images/faces/1.jpg') }}" alt="Default">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ strtok(Auth::user()->name, ' ') }}!</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.user.edit', Auth::user()->id) }}">
                                <i class="icon-mid bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
