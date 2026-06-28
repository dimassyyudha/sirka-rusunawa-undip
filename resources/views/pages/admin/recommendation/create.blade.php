@extends('layouts.app')

@section('title', 'Tambah Rekomendasi Kamar')
@section('page_title', 'Tambah Rekomendasi Kamar')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-black text-slate-900">
                Tambah Rekomendasi Kamar
            </h1>

            <p class="mt-2 text-slate-500">
                Tambahkan kamar yang akan ditampilkan pada bagian rekomendasi di halaman beranda.
            </p>

        </div>

        <a href="{{ route('admin.settings.recommendation.index') }}"
            class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">

            Kembali

        </a>

    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

            <ul class="list-disc pl-5 space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>
    @endif

    <form action="{{ route('admin.settings.recommendation.store') }}"
        method="POST"
        class="rounded-[10px] border border-slate-200 bg-white p-6 shadow-sm">

        @csrf

        @include('pages.admin.recommendation._form', [
            'rooms' => $rooms,
            'nextOrder' => $nextOrder
        ])

        <div class="mt-8 flex gap-3">

            <button type="submit"
                class="rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white hover:bg-orange-600">

                Simpan Data

            </button>

            <a href="{{ route('admin.settings.recommendation.index') }}"
                class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-50">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection