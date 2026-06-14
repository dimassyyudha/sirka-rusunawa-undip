@extends('layouts.app')

@section('title', 'Pengajuan Registrasi')
@section('page_title', 'Pengajuan Registrasi')

@section('content')

    <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">

        <h1 class="text-2xl font-black text-slate-900">
            Belum Ada Registrasi Aktif
        </h1>

        <p class="mt-3 text-slate-500">
            Saat ini belum ada periode registrasi hunian yang sedang dibuka.
        </p>

        <a href="{{ route('admin.occupancy-periods.index') }}"
            class="mt-6 inline-flex rounded-2xl bg-orange-500 px-5 py-3 font-black text-white hover:bg-orange-600">
            Kelola Periode Registrasi
        </a>

    </div>

@endsection
