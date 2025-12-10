@extends('layouts.admin.app')

@section('title', 'Identitas Pengembang')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Identitas Pengembang</h3>
                <p class="text-subtitle text-muted">Profil pembuat sistem inventaris desa.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengembang</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            {{-- KOLOM KIRI: FOTO & SOSMED --}}
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            {{-- FOTO PROFIL --}}
                            <div class="avatar avatar-2xl mb-3">
                                <img src="{{ asset('assets-admin/images/faces/my-photo.png') }}" alt="Avatar"
                                     style="width: 150px; height: 150px; object-fit: cover;" class="rounded-circle shadow">
                            </div>

                            <h3 class="mt-3">M. Dzakwan Syafiq</h3>
                            <p class="text-small">Mahasiswa Sistem Informasi</p>

                            {{-- TOMBOL SOSMED --}}
                            <div class="d-flex gap-2 mt-2 flex-wrap justify-content-center">
                                <a href="https://github.com/dzakwan24si" target="_blank" class="btn btn-dark btn-sm">
                                    <i class="bi bi-github"></i> Github
                                </a>
                                <a href="https://linkedin.com/in/m-dzakwan-syafiq" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-linkedin"></i> LinkedIn
                                </a>
                                <a href="https://instagram.com/syafiqdzakwan" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="bi bi-instagram"></i> Instagram
                                </a>
                                <a href="https://dzakwan24si.github.io/dzakwan-portofolio/" target="_blank" class="btn btn-info btn-sm text-white">
                                    <i class="bi bi-globe"></i> Website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU QUOTE / MOTO --}}
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <i class="bi bi-quote fs-1 text-muted"></i>
                            <blockquote class="blockquote">
                                <p class="mb-0 fs-6 fst-italic">"Kode yang bersih adalah tanda dari pemikiran yang jernih. Teruslah belajar dan berkarya."</p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: BIODATA LENGKAP --}}
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tentang Saya</h4>
                    </div>
                    <div class="card-body">
                        <p>
                            Halo! Saya adalah pengembang di balik Sistem Informasi Inventaris Desa ini.
                            Saya merupakan mahasiswa aktif semester 3 yang memiliki ketertarikan tinggi dalam dunia
                            <i>Web Development</i>, khususnya menggunakan framework Laravel.
                        </p>

                        <h5 class="mt-4 mb-3 text-primary"><i class="bi bi-person-lines-fill me-2"></i> Biodata</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Lengkap</th>
                                    <td>: M. Dzakwan Syafiq</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>: 2457301077</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>: Sistem Informasi</td>
                                </tr>
                                <tr>
                                    <th>Kampus</th>
                                    <td>: Politeknik Caltex Riau</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: dzakwan24si@mahasiswa.pcr.ac.id</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: Pekanbaru, Riau, Indonesia</td>
                                </tr>
                            </table>
                        </div>

                        <hr>

                        <h5 class="mt-4 mb-3 text-primary"><i class="bi bi-code-slash me-2"></i> Tech Stack & Skills</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light-primary text-primary fs-6">Laravel 10</span>
                            <span class="badge bg-light-success text-success fs-6">PHP 8.2</span>
                            <span class="badge bg-light-warning text-warning fs-6">MySQL</span>
                            <span class="badge bg-light-info text-info fs-6">Bootstrap 5</span>
                            <span class="badge bg-light-secondary text-secondary fs-6">Git & GitHub</span>
                            <span class="badge bg-light-danger text-danger fs-6">Figma / UI Design</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection