<section id="beranda" class="relative overflow-hidden h-[calc(100vh-74px)] min-h-[520px]">
    @php
        $heroImageUrl = function ($path) {
            if (empty($path)) {
                return null;
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            if (str_starts_with($path, 'assets-admin/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        };

        $slides = collect($beranda['background_images'] ?? [])
            ->filter(fn($item) => !empty($item['image']) && (!isset($item['is_active']) || $item['is_active']))
            ->sortBy('sort_order')
            ->values();

        if ($slides->isEmpty()) {
            $slides = collect([
                ['image' => 'assets-admin/images/hero-1.jpg', 'sort_order' => 1, 'is_active' => true],
                ['image' => 'assets-admin/images/hero-2.jpg', 'sort_order' => 2, 'is_active' => true],
                ['image' => 'assets-admin/images/hero-3.jpg', 'sort_order' => 3, 'is_active' => true],
            ]);
        }
    @endphp

    <div class="swiper beranda-swiper relative h-full w-full">
        <div class="swiper-wrapper">
            @foreach ($slides as $i => $slide)
                @php
                    $imageUrl = $heroImageUrl($slide['image'] ?? null);
                @endphp

                <div class="swiper-slide h-full w-full">
                    <div class="relative h-full w-full">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" class="h-full w-full object-cover"
                                alt="Hero Background {{ $i + 1 }}">
                        @else
                            <div class="h-full w-full bg-slate-900"></div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent"></div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($slides->count() > 1)
            <button class="swiper-button-prev !left-5 !text-white"></button>
            <button class="swiper-button-next !right-5 !text-white"></button>
            <div class="swiper-pagination !bottom-6"></div>
        @endif
    </div>

    <div class="pointer-events-none absolute inset-0 z-20 flex items-center">
        <div class="mx-auto w-full max-w-7xl px-4">
            <div class="pointer-events-auto max-w-2xl text-white">
                <h1 class="mt-4 text-4xl font-black leading-tight md:text-6xl">
                    <span id="typed-headline" data-text="{{ $beranda['headline'] ?? 'Reservasi Rusunawa UNDIP' }}">
                    </span>
                    <span class="ml-1 inline-block h-[1em] w-[3px] animate-pulse bg-white"></span>
                </h1>

                <p class="mt-4 max-w-lg text-base leading-relaxed text-white/90 md:text-lg">
                    {{ $beranda['subheadline'] ?? 'Mudah, cepat, transparan.' }}
                </p>

                <div class="mt-7">
                    <a href="{{ route('cari-kamar.index') }}"
                        class="group relative inline-flex items-center justify-center gap-2 overflow-hidden rounded-lg bg-[#7E22CE] px-5 py-2.5 font-medium transition-all hover:bg-indigo-50">

                        <span
                            class="absolute inset-0 rounded-lg border-0 border-indigo-50 transition-all duration-100 ease-linear group-hover:border-[25px]"></span>

                        <span
                            class="relative z-10 flex items-center justify-center gap-2 text-base font-semibold text-white transition-colors duration-200 group-hover:text-[#7E22CE]">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M17 17L21 21" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                                <path
                                    d="M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
                                    stroke="currentColor" stroke-width="1.6" />
                            </svg>

                            {{ $beranda['cta_text'] ?? 'Reservasi Kamar' }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
