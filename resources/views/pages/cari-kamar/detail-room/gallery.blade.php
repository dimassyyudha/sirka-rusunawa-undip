{{-- CAROUSEL FOTO --}}
<div class="relative bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
    <div class="swiper room-detail-swiper h-[220px] sm:h-[300px] md:h-[360px]">
        <div class="swiper-wrapper">
            @foreach ($gallery as $i => $img)
                <div class="swiper-slide">
                    <img src="{{ $img }}" alt="Foto kamar {{ $room->kode_kamar }} {{ $i + 1 }}"
                        class="w-full h-full object-contain bg-slate-100" loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('assets-admin/images/hero-1.jpg') }}';">
                </div>
            @endforeach
        </div>

        <button class="swiper-button-prev !text-white !left-4"></button>
        <button class="swiper-button-next !text-white !right-4"></button>
        <div class="swiper-pagination !bottom-4"></div>
    </div>
</div>
