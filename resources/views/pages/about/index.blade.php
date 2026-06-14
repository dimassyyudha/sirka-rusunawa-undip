@extends('landing.landing')

@section('title', 'Tentang Kami')

@section('content')

<section class="bg-slate-50 py-16 min-h-screen">

    <div class="max-w-6xl mx-auto px-4">

        <div class="text-center">
            <p class="text-orange-500 font-black uppercase tracking-[0.2em]">
                Tentang Kami
            </p>

            <h1 class="mt-4 text-4xl font-black text-slate-900">
                Rusunawa Universitas Diponegoro
            </h1>

            <p class="mt-5 text-lg text-slate-500 max-w-3xl mx-auto leading-relaxed">
                Rusunawa Universitas Diponegoro merupakan fasilitas hunian mahasiswa
                yang menyediakan lingkungan tinggal nyaman, aman, modern,
                dan mendukung kehidupan akademik mahasiswa UNDIP.
            </p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-3">

            <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-black text-slate-900">
                    Hunian Nyaman
                </h3>

                <p class="mt-3 text-slate-500 leading-relaxed">
                    Kamar dirancang nyaman dengan fasilitas penunjang kehidupan mahasiswa.
                </p>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-black text-slate-900">
                    Lingkungan Aman
                </h3>

                <p class="mt-3 text-slate-500 leading-relaxed">
                    Sistem keamanan dan tata tertib mendukung kenyamanan seluruh penghuni.
                </p>
            </div>

            <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-black text-slate-900">
                    Mendukung Akademik
                </h3>

                <p class="mt-3 text-slate-500 leading-relaxed">
                    Lokasi strategis dekat area kampus untuk menunjang aktivitas perkuliahan.
                </p>
            </div>

        </div>

    </div>

</section>

@endsection