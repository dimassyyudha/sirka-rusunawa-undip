<section id="alur" class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50 py-24">
    {{-- background glow --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[700px] bg-[#1368f0]/5 blur-3xl rounded-full pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="max-w-3xl mx-auto text-center">
            <p class="text-sm md:text-base font-bold tracking-[0.35em] uppercase text-[#1368f0]">
                Cara Reservasi
            </p>

            <h2 class="mt-3 text-3xl md:text-5xl font-black text-slate-900 leading-tight">
                Reservasi kamar jadi
                <span class="text-[#1368f0]">lebih mudah</span>
            </h2>

            <p class="mt-4 text-slate-600 text-base md:text-lg leading-relaxed">
                Hanya tiga langkah sederhana untuk memilih kamar, mengajukan reservasi, dan menunggu verifikasi.
            </p>

            <div class="mt-6 flex justify-center">
                <div class="h-1.5 w-24 rounded-full bg-[#1368f0] shadow-[0_0_18px_rgba(19,104,240,0.35)]"></div>
            </div>
        </div>

        {{-- TIMELINE --}}
        <div class="mt-16 relative">
            {{-- garis penghubung desktop --}}
            <div class="hidden lg:block absolute top-1/2 left-[16%] right-[16%] h-[3px] -translate-y-1/2 bg-gradient-to-r from-[#1368f0]/20 via-[#1368f0]/50 to-[#1368f0]/20 rounded-full"></div>

            <div class="grid lg:grid-cols-3 gap-8">

                {{-- STEP 1 --}}
                <div class="group relative">
                    <div class="relative rounded-[32px] border border-slate-200 bg-white/90 backdrop-blur-sm p-8 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                        {{-- angka besar background --}}
                        <div class="absolute -right-2 -top-6 text-[110px] font-black text-[#1368f0]/10 leading-none select-none">
                            1
                        </div>

                        {{-- badge nomor --}}
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1368f0] text-white text-2xl font-black shadow-lg">
                            <i class="bi bi-house-door"></i>
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            Pilih Kamar
                        </h3>

                        <p class="mt-3 text-slate-600 leading-relaxed">
                            Lihat ketersediaan kamar secara langsung, bandingkan lokasi, fasilitas, dan harga, lalu pilih kamar yang paling sesuai.
                        </p>

                        <div class="mt-6 flex items-center gap-2 text-[#1368f0] font-bold">
                            <span class="w-8 h-8 rounded-full bg-[#1368f0]/10 flex items-center justify-center text-sm">01</span>
                            <span>Mulai dari pencarian kamar</span>
                        </div>

                        {{-- aksen bawah --}}
                        <div class="mt-6 h-1.5 w-12 rounded-full bg-[#1368f0]/30 transition-all duration-500 group-hover:w-28 group-hover:bg-[#1368f0]"></div>
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div class="group relative lg:mt-12">
                    <div class="relative rounded-[32px] border border-slate-200 bg-white/90 backdrop-blur-sm p-8 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                        <div class="absolute -right-2 -top-6 text-[110px] font-black text-[#1368f0]/10 leading-none select-none">
                            2
                        </div>

                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1368f0] text-white text-2xl font-black shadow-lg">
                            <i class="bi bi-pencil-square"></i>
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            Ajukan Reservasi
                        </h3>

                        <p class="mt-3 text-slate-600 leading-relaxed">
                            Isi data diri, lengkapi persyaratan, lalu kirim pengajuan reservasi kamar secara online melalui sistem.
                        </p>

                        <div class="mt-6 flex items-center gap-2 text-[#1368f0] font-bold">
                            <span class="w-8 h-8 rounded-full bg-[#1368f0]/10 flex items-center justify-center text-sm">02</span>
                            <span>Lengkapi data reservasi</span>
                        </div>

                        <div class="mt-6 h-1.5 w-12 rounded-full bg-[#1368f0]/30 transition-all duration-500 group-hover:w-28 group-hover:bg-[#1368f0]"></div>
                    </div>
                </div>

                {{-- STEP 3 --}}
                <div class="group relative">
                    <div class="relative rounded-[32px] border border-slate-200 bg-white/90 backdrop-blur-sm p-8 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                        <div class="absolute -right-2 -top-6 text-[110px] font-black text-[#1368f0]/10 leading-none select-none">
                            3
                        </div>

                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#1368f0] text-white text-2xl font-black shadow-lg">
                            <i class="bi bi-patch-check"></i>
                        </div>

                        <h3 class="mt-6 text-2xl font-black text-slate-900">
                            Verifikasi
                        </h3>

                        <p class="mt-3 text-slate-600 leading-relaxed">
                            Admin memverifikasi pengajuanmu. Setelah disetujui, kamu bisa melanjutkan proses menempati kamar pilihan.
                        </p>

                        <div class="mt-6 flex items-center gap-2 text-[#1368f0] font-bold">
                            <span class="w-8 h-8 rounded-full bg-[#1368f0]/10 flex items-center justify-center text-sm">03</span>
                            <span>Tunggu hasil verifikasi</span>
                        </div>

                        <div class="mt-6 h-1.5 w-12 rounded-full bg-[#1368f0]/30 transition-all duration-500 group-hover:w-28 group-hover:bg-[#1368f0]"></div>
                    </div>
                </div>

            </div>
        </div>

        {{-- CTA --}}
        <div class="mt-14 text-center">
            <a href="{{ route('cari-kamar.index') }}"
               class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-[#1368f0] text-white font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                Mulai Reservasi Sekarang
                <i class="bi bi-arrow-right-circle text-xl transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</section>