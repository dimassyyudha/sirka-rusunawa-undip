<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('assets-admin/images/logo/logo-baru.png') }}"
                            alt="Logo"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">

                {{-- KELOMPOK 1: MENU UTAMA --}}
                <li class="sidebar-title"><b>Menu Utama</b></li>

                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- KELOMPOK 2: INVENTARISASI (INTI) --}}
                <li class="sidebar-title"><b>Inventarisasi</b></li>

                <li class="sidebar-item {{ request()->routeIs('aset.*') ? 'active' : '' }}">
                    <a href="{{ route('aset.index') }}" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Data Aset</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('pemeliharaan.*') ? 'active' : '' }}">
                    <a href="{{ route('pemeliharaan.index') }}" class='sidebar-link'>
                        <i class="bi bi-tools"></i>
                        <span>Pemeliharaan</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('mutasi.*') ? 'active' : '' }}">
                    <a href="{{ route('mutasi.index') }}" class='sidebar-link'>
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Mutasi Aset</span>
                    </a>
                </li>

                {{-- KELOMPOK 3: MASTER DATA (REFERENSI) --}}
                <li class="sidebar-title"><b>Master Data</b></li>

                <li class="sidebar-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}" class='sidebar-link'>
                        <i class="bi bi-tags-fill"></i>
                        <span>Kategori Aset</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('lokasi-aset.*') ? 'active' : '' }}">
                    <a href="{{ route('lokasi-aset.index') }}" class='sidebar-link'>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Lokasi Aset</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                    <a href="{{ route('warga.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Daftar Warga</span>
                    </a>
                </li>

                {{-- KELOMPOK 4: PENGATURAN / ADMIN --}}
                <li class="sidebar-title"><b>Pengaturan</b></li>

                {{-- Menu User hanya muncul untuk Admin (Opsional: Tambahkan @if (Auth::user()->role == 'admin') jika perlu) --}}
                <li class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class='sidebar-link text-danger'
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

                <li class="sidebar-title"><b>Informasi</b></li>

                <li class="sidebar-item {{ request()->routeIs('developer.*') ? 'active' : '' }}">
                    <a href="{{ route('developer.index') }}" class='sidebar-link'>
                        <i class="bi bi-code-square"></i>
                        <span>Tentang Pengembang</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
