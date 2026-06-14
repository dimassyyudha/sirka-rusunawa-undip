{{-- TABS --}}
<div class="mt-6 border-b border-slate-200 overflow-x-auto no-scrollbar">

    <div class="flex min-w-max">

        <button class="tablink border-b-2 border-[#070B55] text-[#070B55] px-5 py-4 text-sm font-bold whitespace-nowrap"
            data-tab="content-info">

            Informasi Umum

        </button>

        <button
            class="tablink border-b-2 border-transparent text-slate-500 px-5 py-4 text-sm font-bold whitespace-nowrap"
            data-tab="content-facility">

            Fasilitas

        </button>

        <button
            class="tablink border-b-2 border-transparent text-slate-500 px-5 py-4 text-sm font-bold whitespace-nowrap"
            data-tab="content-review">

            Ulasan

            @if ($totalReviews > 0)
                <span class="ml-2 rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-600">
                    {{ $totalReviews }}
                </span>
            @endif

        </button>

    </div>

</div>

{{-- TAB CONTENT: INFORMASI --}}
<div id="content-info" class="tabcontent pt-6">

    <div class="space-y-6">

        {{-- Tentang Kamar --}}
        <div class="bg-white rounded-3xl border border-slate-200 p-6">

            <h3 class="text-xl font-bold text-slate-900 mb-4">
                Tentang Kamar
            </h3>

            <p class="text-slate-600 leading-8">
                Kamar {{ $room->kode_kamar }}
                berada di Gedung {{ $gedungLabelUpper }}
                lantai {{ $lantai }}.

                Kamar ini memiliki kapasitas
                {{ $capacity }} penghuni
                dengan kondisi saat ini
                {{ $occupied }} penghuni aktif
                dan tersisa
                {{ $slots }} slot yang masih tersedia.
            </p>

        </div>

        {{-- Catatan --}}
        <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5">

            <div class="flex gap-3">

                <svg id='Info_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'
                    xmlns:xlink='http://www.w3.org/1999/xlink'>
                    <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                    <g transform="matrix(0.43 0 0 0.43 12 12)">
                        <path
                            style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;"
                            transform=" translate(-25, -25)"
                            d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 C 23.34314575050762 11 22 12.34314575050762 22 14 C 22 15.65685424949238 23.34314575050762 17 25 17 C 26.65685424949238 17 28 15.65685424949238 28 14 C 28 12.34314575050762 26.65685424949238 11 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z"
                            stroke-linecap="round" />
                    </g>
                </svg>

                <div>

                    <div class="font-bold text-blue-900">

                        Informasi Reservasi

                    </div>

                    <p class="mt-1 text-sm text-blue-800">

                        Pengajuan reservasi kamar akan
                        diverifikasi oleh pengelola Rusunawa.
                        Pastikan seluruh data diri dan
                        dokumen pendukung telah lengkap.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- TAB CONTENT: FASILITAS --}}
<div id="content-facility" class="tabcontent detail-content hidden pb-10 pt-4">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-4">
        <h2 class="text-lg md:text-xl font-bold text-slate-900">Fasilitas kamar</h2>

        @if (count($fasilitasList))
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-3 text-sm text-slate-700">
                @foreach ($fasilitasList as $item)
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4">

                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />

                        </svg>

                        <span class="text-slate-700 font-medium">

                            {{ $item }}

                        </span>

                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-500">
                Fasilitas detail belum diinput. Silakan hubungi admin Rusunawa untuk informasi lebih lanjut.
            </p>
        @endif

        <div class="mt-3 border-t border-slate-100 pt-3 text-xs text-slate-500 space-y-1">
            <p>Beberapa fasilitas dapat berbeda antar kamar dalam gedung yang sama.</p>
            <p>Foto yang ditampilkan bersifat ilustratif dan dapat berbeda dengan kondisi aktual.</p>
        </div>
    </div>
</div>

{{-- TAB CONTENT: ULASAN --}}
<div id="content-review" class="tabcontent detail-content hidden pb-10 pt-4">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg md:text-xl font-bold text-slate-900">Ulasan penghuni</h2>
                <p class="text-sm text-slate-500">Penilaian dari penghuni yang sudah memberi ulasan.</p>
            </div>

            <div class="text-left sm:text-right">
                <div class="text-3xl font-black text-slate-900">
                    {{ $averageRating ?: '-' }}
                    <span class="text-sm font-semibold text-slate-500">/ 5</span>
                </div>

                <div class="text-lg">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-slate-300' }}">★</span>
                    @endfor
                </div>

                <div class="text-xs text-slate-500">
                    {{ $totalReviews }} ulasan
                </div>
            </div>
        </div>

        @forelse ($visibleReviews as $review)
            <div class="border border-slate-200 rounded-3xl p-5 bg-white">

                <div class="flex justify-between items-start">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-11 h-11 rounded-full bg-[#070B55] text-white flex items-center justify-center font-bold">

                            {{ strtoupper(substr($review->user?->name ?? 'P', 0, 1)) }}

                        </div>

                        <div>

                            <div class="font-bold text-slate-900">

                                {{ $review->user?->name ?? 'Penghuni' }}

                            </div>

                            <div class="text-xs text-slate-500">

                                {{ $review->created_at?->format('d M Y') }}

                            </div>

                        </div>

                    </div>

                    <div class="rounded-xl bg-yellow-50 px-3 py-1 text-yellow-700 font-bold">

                        {{ $review->rating }}/5

                    </div>

                </div>

                <p class="mt-4 text-slate-600 leading-relaxed">

                    {{ $review->comment ?: 'Tidak ada komentar.' }}

                </p>

            </div>
        @empty
            <div class="text-sm text-slate-500 border-t border-slate-100 pt-4">
                Belum ada ulasan untuk kamar ini.
            </div>
        @endforelse
    </div>
</div>
