<section id="galeri" class="max-w-7xl mx-auto px-4 pt-12 pb-14">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900">Galeri Fasilitas</h2>
            <p class="mt-2 text-slate-600 text-sm md:text-base">
                Suasana kamar dan fasilitas umum di Rusunawa UNDIP.
            </p>
        </div>
    </div>

    <div class="mt-6 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        {{-- contoh, nanti bisa di-loop dari DB --}}
        <div class="rounded-2xl overflow-hidden bg-slate-200">
            <img src="{{ asset('assets-admin/images/bg/bg-rusunawa-undip.jpg') }}"
                 class="w-full h-52 object-cover" alt="Tampak depan rusunawa">
        </div>
        <div class="rounded-2xl overflow-hidden bg-slate-200">
            <img src="{{ asset('assets-admin/images/bg/inventaris-bg.jpg') }}"
                 class="w-full h-52 object-cover" alt="Contoh kamar">
        </div>
        <div class="rounded-2xl overflow-hidden bg-slate-200">
            <img src="{{ asset('assets-admin/images/bg/4853433.jpg') }}"
                 class="w-full h-52 object-cover" alt="Fasilitas umum">
        </div>
    </div>
</section>
