@extends('landing.landing')

@section('title', $syaratKetentuan['title'] ?? 'Syarat & Ketentuan')

@section('content')
    <section class="bg-white py-20">


        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- HERO --}}
            <div class="mx-auto max-w-3xl text-center">

                <span
                    class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-1 text-sm font-medium text-slate-600">

                    Rusunawa Universitas Diponegoro

                </span>

                <h1 class="mt-6 text-5xl font-bold tracking-tight text-slate-900">

                    {{ $syaratKetentuan['title'] ?? 'Syarat & Ketentuan' }}

                </h1>

                @if (!empty($syaratKetentuan['subtitle']))
                    <p class="mt-5 text-lg leading-8 text-slate-600">

                        {{ $syaratKetentuan['subtitle'] }}

                    </p>
                @endif

            </div>

            {{-- READING PROGRESS --}}
            <div class="mt-12 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                <div id="reading-progress" class="h-full w-0 rounded-full bg-indigo-600 transition-all duration-150">
                </div>
            </div>

            <div class="mt-16 grid gap-16 lg:grid-cols-[280px_1fr]">

                {{-- SIDEBAR --}}
                <aside class="hidden lg:block">

                    <div class="sticky top-28">

                        <h3 class="mb-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">

                            Daftar Isi

                        </h3>

                        <nav class="space-y-1">

                            @foreach ($syaratKetentuan['sections'] ?? [] as $index => $section)
                                <a href="#section-{{ $index }}" data-nav="section-{{ $index }}"
                                    class="toc-link group flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition-all duration-200">

                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-xs font-bold text-slate-500 transition-all duration-200">

                                        {{ $section['number'] ?? $loop->iteration }}

                                    </span>

                                    <span class="font-medium text-slate-600">

                                        {{ $section['title'] ?? '' }}

                                    </span>

                                </a>
                            @endforeach

                        </nav>

                    </div>

                </aside>

                {{-- CONTENT --}}
                <div>

                    @foreach ($syaratKetentuan['sections'] ?? [] as $index => $section)
                        <section id="section-{{ $index }}" class="content-section scroll-mt-32 pb-16">

                            <div class="mb-8 flex items-center gap-4 border-b border-slate-200 pb-5">

                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-600 font-bold text-white shadow-sm">

                                    {{ $section['number'] ?? $loop->iteration }}

                                </div>

                                <h2 class="text-3xl font-bold tracking-tight text-slate-900">

                                    {{ $section['title'] ?? '' }}

                                </h2>

                            </div>

                            @if (!empty($section['items']))
                                <div class="space-y-5">

                                    @foreach ($section['items'] as $item)
                                        <div class="flex gap-4 rounded-xl p-4 transition hover:bg-slate-50">

                                            <div
                                                class="mt-2 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-indigo-50">

                                                <div class="h-2 w-2 rounded-full bg-indigo-600">
                                                </div>

                                            </div>

                                            <p class="leading-8 text-slate-700">

                                                {{ $item }}

                                            </p>

                                        </div>
                                    @endforeach

                                </div>
                            @endif

                        </section>
                    @endforeach

                </div>

            </div>

        </div>


    </section>

    @push('head')
        <style>
            html {
                scroll-behavior: smooth;
            }

            .toc-link.active {
                background: #eef2ff;
            }

            .toc-link.active span:last-child {
                color: #4338ca;
                font-weight: 600;
            }

            .toc-link.active span:first-child {
                background: #4f46e5;
                color: white;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const sections = document.querySelectorAll('.content-section');
                const links = document.querySelectorAll('.toc-link');

                const observer = new IntersectionObserver((entries) => {

                    entries.forEach(entry => {

                        if (entry.isIntersecting) {

                            links.forEach(link => {
                                link.classList.remove('active');
                            });

                            const active = document.querySelector(
                                `[data-nav="${entry.target.id}"]`
                            );

                            if (active) {
                                active.classList.add('active');
                            }
                        }

                    });

                }, {
                    rootMargin: "-30% 0px -60% 0px"
                });

                sections.forEach(section => {
                    observer.observe(section);
                });

                const progress = document.getElementById('reading-progress');

                window.addEventListener('scroll', () => {

                    const scrollTop = window.scrollY;
                    const docHeight =
                        document.documentElement.scrollHeight -
                        window.innerHeight;

                    const percent = (scrollTop / docHeight) * 100;

                    progress.style.width = percent + '%';

                });

            });
        </script>
    @endpush


@endsection
