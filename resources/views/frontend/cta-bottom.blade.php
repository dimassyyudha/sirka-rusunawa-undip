<section class="relative overflow-hidden bg-gradient-to-b from-white via-slate-50 to-white pt-16 pb-24 md:pt-24 md:pb-32">

    <div class="mx-auto max-w-5xl px-4">

        <div class="mx-auto max-w-3xl text-center">

            <span
                class="inline-flex items-center rounded-full border border-[#1368f0]/20 bg-[#1368f0]/5 px-4 py-2 text-sm font-semibold text-[#1368f0]">

                Sistem Informasi Reservasi Rusunawa Universitas Diponegoro

            </span>

            <h2 class="mt-6 text-3xl font-black leading-tight text-[#000352] md:text-5xl">

                Mulai Proses Reservasi Kamar Rusunawa Secara Online

            </h2>

            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-slate-600 md:text-lg">

                Akses informasi ketersediaan kamar, lakukan pengajuan reservasi,
                serta pantau status pengajuan hunian melalui sistem yang terintegrasi
                dan dapat diakses kapan saja.

            </p>

        </div>

        {{-- VIDEO PROFIL --}}
        <div class="mx-auto mt-12 max-w-4xl">

            <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-xl">

                <div class="aspect-video">

                    <iframe
                        class="h-full w-full"
                        src="https://www.youtube.com/embed/ANtY7ymn5T0"
                        title="Video Profil Rusunawa UNDIP"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>

                </div>

            </div>

        </div>

        <div class="mt-10 text-center">

            <a href="{{ route('cari-kamar.index') }}"
                class="group relative inline-flex items-center px-6 py-3 rounded-2xl
                border border-blue-700 text-blue-700 font-semibold
                transition hover:bg-blue-700 hover:text-white">

                Mulai Reservasi Kamar

                <span
                    class="absolute left-1/2 bottom-2 h-[2px] w-0 bg-[#070b54]
                    transition-all duration-300 -translate-x-1/2
                    group-hover:w-3/4 group-hover:bg-white">
                </span>

            </a>

        </div>

    </div>

</section>