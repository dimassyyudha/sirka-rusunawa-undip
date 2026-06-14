<section id="alur" class="bg-slate-50 py-24 overflow-hidden">
    @php
        $steps = collect($alur['steps'] ?? [])
            ->filter(fn($item) => !empty($item['is_active']))
            ->sortBy('sort_order')
            ->values();
    @endphp

    <div class="max-w-6xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="max-w-3xl mx-auto text-center mb-16 reveal-up">
            <p class="text-sm md:text-base font-bold tracking-[0.35em] uppercase text-[#1368f0]">
                {{ $alur['badge'] ?? 'Cara Reservasi' }}
            </p>

            <h2 class="mt-3 text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                {{ $alur['title'] ?? 'Alur Reservasi Kamar' }}
            </h2>

            <p class="mt-4 text-slate-600 text-base md:text-lg leading-relaxed">
                {{ $alur['description'] ?? 'Ikuti langkah mudah untuk mendapatkan kamar di Rusunawa UNDIP.' }}
            </p>

            <div class="mt-6 flex justify-center">
                <div class="h-1.5 w-24 rounded-full bg-[#1368f0]"></div>
            </div>
        </div>

        {{-- DESKTOP --}}
        <div class="hidden md:block relative">
            <div class="absolute left-1/2 top-0 bottom-0 w-[2px] -translate-x-1/2 bg-[#1368f0]/20"></div>

            <div class="space-y-12">
                @forelse($steps as $i => $step)
                    @php
                        $isLeft = $i % 2 === 0;
                        $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                    @endphp

                    <div class="relative reveal-step">
                        <div class="grid grid-cols-2 gap-12 items-center">

                            {{-- LEFT --}}
                            <div class="{{ $isLeft ? '' : 'invisible' }}">
                                @if ($isLeft)
                                    <div class="alur-card ml-auto">
                                        <div class="alur-number">{{ $num }}</div>
                                        <h3 class="alur-title">{{ $step['title'] ?? '-' }}</h3>
                                        <p class="alur-desc">{{ $step['desc'] ?? '' }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- RIGHT --}}
                            <div class="{{ !$isLeft ? '' : 'invisible' }}">
                                @if (!$isLeft)
                                    <div class="alur-card mr-auto">
                                        <div class="alur-number">{{ $num }}</div>
                                        <h3 class="alur-title">{{ $step['title'] ?? '-' }}</h3>
                                        <p class="alur-desc">{{ $step['desc'] ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- TITIK TENGAH --}}
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                            <div class="w-5 h-5 rounded-full bg-[#1368f0] border-4 border-white shadow-md"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-slate-500">
                        Belum ada data alur reservasi.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- MOBILE --}}
        <div class="md:hidden relative">
            <div class="absolute left-4 top-0 bottom-0 w-[2px] bg-[#1368f0]/20"></div>

            <div class="space-y-6">
                @forelse($steps as $i => $step)
                    <div class="relative pl-12 reveal-step">
                        <div class="absolute left-[6px] top-8 z-10">
                            <div class="w-5 h-5 rounded-full bg-[#1368f0] border-4 border-white shadow-md"></div>
                        </div>

                        <div class="alur-card w-full">
                            <div class="alur-number">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3 class="alur-title">{{ $step['title'] ?? '-' }}</h3>
                            <p class="alur-desc">{{ $step['desc'] ?? '' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-slate-500">
                        Belum ada data alur reservasi.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-14 text-center reveal-up">


            <a href="{{ route('cari-kamar.index') }}"
                class="group relative inline-flex items-center px-6 py-3 rounded-2xl 
               border border-blue-700 text-blue-700 font-semibold 
               transition hover:bg-blue-700 hover:text-white">

                Mulai Reservasi Kamar Sekarang

                <span
                    class="absolute left-1/2 bottom-2 h-[2px] w-0 bg-[#070b54] 
                     transition-all duration-300 -translate-x-1/2 
                     group-hover:w-3/4 group-hover:bg-white">
                </span>
            </a>
        </div>
    </div>
</section>

<style>
    .alur-card {
        width: 100%;
        max-width: 420px;
        min-height: 220px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        transition: all 0.35s ease;
    }

    .alur-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 36px rgba(19, 104, 240, 0.12);
        border-color: rgba(19, 104, 240, 0.25);
    }

    .alur-number {
        font-size: 2rem;
        line-height: 1;
        font-weight: 900;
        color: #1368f0;
    }

    .alur-title {
        margin-top: 1rem;
        font-size: 1.5rem;
        line-height: 1.2;
        font-weight: 900;
        color: #0f172a;
    }

    .alur-desc {
        margin-top: 1rem;
        font-size: 1rem;
        line-height: 1.8;
        color: #64748b;
    }

    .reveal-up,
    .reveal-step {
        opacity: 0;
        transform: translateY(36px);
        transition: opacity 0.8s ease, transform 0.8s ease;
        will-change: opacity, transform;
    }

    .reveal-up.is-visible,
    .reveal-step.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .reveal-step:nth-child(1) {
        transition-delay: 0.04s;
    }

    .reveal-step:nth-child(2) {
        transition-delay: 0.10s;
    }

    .reveal-step:nth-child(3) {
        transition-delay: 0.16s;
    }

    .reveal-step:nth-child(4) {
        transition-delay: 0.22s;
    }

    .reveal-step:nth-child(5) {
        transition-delay: 0.28s;
    }

    .reveal-step:nth-child(6) {
        transition-delay: 0.34s;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const targets = document.querySelectorAll('.reveal-up, .reveal-step');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    entry.target.classList.remove('is-visible');
                }
            });
        }, {
            threshold: 0.15
        });

        targets.forEach((el) => observer.observe(el));
    });
</script>
