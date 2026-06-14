{{-- resources/views/frontend/sections/testimonials.blade.php --}}
<section id="testimoni" class="max-w-7xl mx-auto px-4 pb-16">
    <div class="bg-white rounded-3xl border shadow-sm p-8 md:p-10">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">Testimoni Penghuni</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Pengalaman singkat dari beberapa penghuni rusunawa.
                </p>
            </div>
        </div>

        <div class="mt-6 grid md:grid-cols-3 gap-4">
            @forelse(($testimonials ?? []) as $t)
                <div class="rounded-2xl border bg-slate-50 p-5 h-full flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                            {{ strtoupper(substr($t->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900 text-sm">{{ $t->name }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $t->study_program ?? 'Mahasiswa' }}
                                @if(!empty($t->year))
                                    • {{ $t->year }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center gap-1 text-yellow-400 text-xs">
                        @for($i = 0; $i < ($t->rating ?? 5); $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </div>

                    <p class="mt-3 text-sm text-slate-600 flex-1">
                        {{ $t->message }}
                    </p>
                </div>
            @empty
                {{-- fallback kalau belum ada data dari DB --}}
                @php
                    $dummy = [
                        [
                            'name' => 'Rizky, Teknik Informatika',
                            'rating' => 5,
                            'message' => 'Kamarnya nyaman, proses reservasi lewat sistem ini jauh lebih praktis dan jelas slotnya.'
                        ],
                        [
                            'name' => 'Ayu, Kedokteran',
                            'rating' => 5,
                            'message' => 'Nggak perlu bolak-balik ke rusun hanya untuk nanya ketersediaan, semua bisa dicek online.'
                        ],
                        [
                            'name' => 'Bima, Hukum',
                            'rating' => 4,
                            'message' => 'Adminnya responsif, dan info status reservasi jelas. Bantu banget buat mahasiswa luar kota.'
                        ],
                    ];
                @endphp

                @foreach($dummy as $d)
                    <div class="rounded-2xl border bg-slate-50 p-5 h-full flex flex-col">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                                {{ strtoupper(substr($d['name'], 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900 text-sm">{{ $d['name'] }}</div>
                                <div class="text-xs text-slate-500">Penghuni Rusunawa</div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-1 text-yellow-400 text-xs">
                            @for($i = 0; $i < $d['rating']; $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                        <p class="mt-3 text-sm text-slate-600 flex-1">
                            {{ $d['message'] }}
                        </p>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
