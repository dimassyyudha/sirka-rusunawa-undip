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
                <li class="sidebar-title"><b>Menu</b></li>
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <a href="{{ route('kategori.index') }}" class='sidebar-link'>
                        <i class="bi bi-tags-fill"></i>
                        <span>Kategori Aset</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('aset.*') ? 'active' : '' }}">
                    <a href="{{ route('aset.index') }}" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Daftar Aset</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('lokasi-aset.*') ? 'active' : '' }}">
                    <a href="{{ route('lokasi-aset.index') }}" class='sidebar-link'>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Lokasi Aset</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('pemeliharaan.*') ? 'active' : '' }}">
                    <a href="{{ route('pemeliharaan.index') }}" class='sidebar-link'>
                        <i class="bi bi-tools"></i>
                        <span>Pemeliharaan Aset</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                    <a href="{{ route('warga.index') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Daftar Warga</span>
                    </a>
                </li>

                <li class="sidebar-title"><b>Akun</b></li>
                <li class="sidebar-item">
                    <a href="#" class='sidebar-link'
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class='sidebar-link'>
                        <i class="iconly-boldAdd-User"></i>
                        <span>Daftar User</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
