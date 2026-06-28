@extends('layouts.app')

@section('title', 'Pengaturan FAQ')

@section('content')

<div class="page-heading">

    <div class="page-title mb-4">

        <div class="row align-items-center">

            <div class="col-md-8">

                <h3 class="fw-bold mb-1">
                    Pengaturan FAQ
                </h3>

                <p class="text-muted mb-0">
                    Kelola daftar pertanyaan yang akan ditampilkan pada Landing Page dan halaman FAQ.
                </p>

            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">

                <a href="{{ route('admin.settings.faq.edit') }}"
                   class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-pencil-square me-2"></i>

                    Edit FAQ

                </a>

            </div>

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @php

        $total = count($items);

        $aktif = collect($items)->where('is_active', true)->count();

        $landing = collect($items)->where('is_featured', true)->count();

    @endphp


    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Total FAQ

                    </small>

                    <h2 class="fw-bold text-primary mt-2">

                        {{ $total }}

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        FAQ Aktif

                    </small>

                    <h2 class="fw-bold text-success mt-2">

                        {{ $aktif }}

                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <small class="text-muted">

                        Landing Page

                    </small>

                    <h2 class="fw-bold text-warning mt-2">

                        {{ $landing }}

                    </h2>

                </div>

            </div>

        </div>

    </div>



    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-primary text-white rounded-top-4 py-3">

            <h5 class="mb-1 text-white">

                FAQ Saat Ini

            </h5>

            <small>

                FAQ yang aktif akan tampil pada halaman FAQ.
                FAQ yang ditandai Landing Page juga tampil pada Beranda.

            </small>

        </div>


        <div class="card-body">


            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <div class="border rounded-4 p-3 h-100 bg-light">

                        <small class="text-muted">

                            Judul

                        </small>

                        <h5 class="fw-bold mt-2 mb-0">

                            {{ $data['title'] ?? '-' }}

                        </h5>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="border rounded-4 p-3 h-100 bg-light">

                        <small class="text-muted">

                            Subjudul

                        </small>

                        <div class="mt-2">

                            {{ $data['subtitle'] ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>



            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                    <tr>

                        <th width="70" class="text-center">

                            #

                        </th>

                        <th>

                            Pertanyaan

                        </th>

                        <th width="120" class="text-center">

                            Status

                        </th>

                        <th width="150" class="text-center">

                            Landing Page

                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($items as $index => $it)

                        <tr>

                            <td class="text-center fw-bold">

                                {{ $index + 1 }}

                            </td>

                            <td>

                                <div class="fw-semibold">

                                    {{ $it['question'] }}

                                </div>

                                <small class="text-muted">

                                    {{ Str::limit($it['answer'],90) }}

                                </small>

                            </td>

                            <td class="text-center">

                                @if(!empty($it['is_active']))

                                    <span class="badge bg-success px-3 py-2">

                                        Aktif

                                    </span>

                                @else

                                    <span class="badge bg-secondary px-3 py-2">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if(!empty($it['is_featured']))

                                    <span class="badge bg-primary px-3 py-2">

                                        Ya

                                    </span>

                                @else

                                    <span class="badge bg-light text-dark border px-3 py-2">

                                        Tidak

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center py-5">

                                <i class="bi bi-question-circle display-4 text-secondary"></i>

                                <div class="mt-3 text-muted">

                                    Belum ada data FAQ.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection