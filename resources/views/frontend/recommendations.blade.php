{{-- resources/views/frontend/partials/recommendations.blade.php --}}

<section id="preview-kamar" class="bg-white py-20">
    @php
        $items = collect($recommendations ?? []);
        $fallbackImg = asset('assets-admin/images/hero-2.jpg');
    @endphp

    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-2xl">
            <p class="text-4xl font-bold tracking-[0.25em] uppercase text-[#1368f0]">
                Rekomendasi
            </p>

            <h2 class="mt-2 text-3xl md:text-4xl font-black text-slate-900 leading-tight">
                Intip kamar rekomendasi ini, yuk!
            </h2>

            <p class="mt-3 text-slate-600 text-base md:text-lg leading-relaxed">
                Beberapa kamar pilihan yang masih tersedia dan layak dipertimbangkan untuk hunianmu.
            </p>

            <div class="mt-4 flex justify-start">
                <div class="h-1 w-24 rounded-full bg-[#1368f0]"></div>
            </div>
        </div>

        <div class="mt-12 relative">
            <div
                class="pointer-events-none absolute left-0 top-0 z-10 h-full w-10 bg-gradient-to-r from-white to-transparent">
            </div>
            <div
                class="pointer-events-none absolute right-0 top-0 z-10 h-full w-10 bg-gradient-to-l from-white to-transparent">
            </div>

            <button onclick="scrollRecommendation(-1)"
                class="absolute -left-1 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-[#1368f0] hover:text-white transition">
                <i class="bi bi-chevron-left"></i>
            </button>

            <button onclick="scrollRecommendation(1)"
                class="absolute -right-1 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-[#1368f0] hover:text-white transition">
                <i class="bi bi-chevron-right"></i>
            </button>


            <div id="recommendationWrapper" class="overflow-x-auto overflow-y-hidden no-scrollbar scroll-smooth">
                <div id="recommendationTrack" class="flex gap-6 w-max pr-4">
                    @forelse ($items as $it)
                        @php
                            $room = $it->room;

                            if (!$room || !$room->floor || !$room->floor->building) {
                                continue;
                            }

                            $floor = $room->floor;
                            $building = $floor->building;

                            $capacity = (int) ($floor->room_capacity ?? 2);
                            $occupied = (int) ($room->occupied ?? 0);
                            $slot = max(0, $capacity - $occupied);

                            $code = $room->kode_kamar ?? '-';
                            $lantai = $floor->floor_number ?? '-';
                            $harga = (int) ($floor->monthly_price ?? 0);

                            $gedungRaw = trim((string) ($building->name ?? ''));
                            $gedungLabel = strtoupper(str_replace('Gedung ', '', $gedungRaw));

                            $gedungFolder = \Illuminate\Support\Str::of($gedungRaw)
                                ->lower()
                                ->replace('gedung ', '')
                                ->replace('tower ', '')
                                ->slug('-')
                                ->value();

                            if (!empty($room->foto)) {
                                if (\Illuminate\Support\Str::startsWith($room->foto, ['images/', '/images/'])) {
                                    $imgUrl = asset(ltrim($room->foto, '/'));
                                } elseif (\Illuminate\Support\Str::contains($room->foto, '/')) {
                                    $imgUrl = asset('images/' . ltrim($room->foto, '/'));
                                } else {
                                    $imgUrl = asset('images/' . $gedungFolder . '/' . $room->foto);
                                }
                            } else {
                                $imgUrl = $fallbackImg;
                            }
                        @endphp

                        <a href="{{ route('cari-kamar.show', ['room' => $room->id]) }}"
                            class="group block w-[290px] md:w-[310px] flex-shrink-0 rounded-[28px] overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                            <div class="h-48 bg-slate-100 relative overflow-hidden">
                                <img src="{{ $imgUrl }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                    class="w-full h-48 object-cover transition duration-500 group-hover:scale-105"
                                    alt="Kamar {{ $code }}">
                            </div>

                            <div class="p-5">
                                <p class="text-2xl font-black text-slate-900 leading-tight">
                                    {{ $code }}
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Gedung {{ $gedungLabel }} • Lantai {{ $lantai }}
                                </p>

                                <div class="mt-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 text-xs font-bold">
                                        Slot tersedia: {{ $slot }}
                                    </span>
                                </div>

                                <div class="mt-5">
                                    <p class="text-sm text-slate-500 font-semibold">
                                        Harga / bulan
                                    </p>

                                    <p class="text-2xl font-black text-slate-900 mt-1">
                                        Rp {{ number_format($harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="w-full text-center text-slate-500 py-10">
                            Belum ada rekomendasi untuk ditampilkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('cari-kamar.index') }}"
                class="group relative inline-flex items-center px-6 py-3 rounded-2xl bg-[#1368f0] text-white font-semibold transition hover:opacity-90">
                Lihat Semua Kamar
                <span
                    class="absolute left-1/2 bottom-2 h-[2px] w-0 bg-white transition-all duration-300 -translate-x-1/2 group-hover:w-3/4"></span>
            </a>
        </div>
    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const wrapper = document.getElementById('recommendationWrapper');
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');

        if (!wrapper || !btnPrev || !btnNext) return;

        function updateButtons() {
            const scrollLeft = wrapper.scrollLeft;
            const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;

            if (scrollLeft <= 10) {
                btnPrev.style.opacity = "0";
                btnPrev.style.pointerEvents = "none";
            } else {
                btnPrev.style.opacity = "1";
                btnPrev.style.pointerEvents = "auto";
            }

            if (scrollLeft >= maxScroll - 10) {
                btnNext.style.opacity = "0";
                btnNext.style.pointerEvents = "none";
            } else {
                btnNext.style.opacity = "1";
                btnNext.style.pointerEvents = "auto";
            }
        }

        window.scrollRecommendation = function(direction) {
            wrapper.scrollBy({
                left: direction * 340,
                behavior: 'smooth'
            });
        };

        wrapper.addEventListener('scroll', updateButtons);
        updateButtons();
        setTimeout(updateButtons, 200);
    });
</script>
