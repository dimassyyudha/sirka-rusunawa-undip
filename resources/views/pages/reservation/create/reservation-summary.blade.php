{{-- MOBILE & TABLET --}}
<div class="lg:hidden mt-6">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-slate-100">

            <div class="text-xs font-black uppercase text-slate-500">
                Ringkasan Reservasi
            </div>

            <div class="mt-1 text-lg font-black text-slate-900">
                {{ $room->kode_kamar }}
            </div>

            <div class="text-sm text-slate-500">
                Gedung {{ $buildingName }} • Lantai {{ $floorNumber }}
            </div>

        </div>

        <div class="p-5 space-y-3">

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Skema</span>

                <span id="summaryTypeMobile" class="font-bold text-orange-600">
                    {{ $selectedType === 'private' ? 'Sekamar sendiri' : 'Sekamar berdua' }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Durasi</span>
                <span class="font-bold">6 Bulan</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-slate-500">Biaya / Bulan</span>

                <span id="summaryPriceMobile" class="font-bold">
                    Rp {{ number_format($selectedPrice, 0, ',', '.') }}
                </span>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-between">

                <span class="font-black">
                    Total
                </span>

                <span id="summaryTotalMobile" class="text-xl font-black text-orange-600">

                    Rp {{ number_format($selectedTotal, 0, ',', '.') }}

                </span>

            </div>

        </div>

        <div class="p-4 border-t border-slate-100 space-y-3">

            <button type="button" onclick="openTermsModal()"
                class="w-full rounded-2xl bg-orange-500 py-4 font-black text-white transition hover:bg-orange-600">

                Lanjut ke Pembayaran

            </button>

            <a href="{{ url()->previous() }}"
                class="flex w-full items-center justify-center rounded-2xl border border-slate-300 py-3 font-bold text-slate-700">

                Kembali

            </a>

        </div>
    </div>

</div>


{{-- DESKTOP --}}
<aside class="hidden lg:block w-full">

    <div class="sticky top-24 w-full space-y-4">

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="px-6 py-5 border-b border-slate-100">

                <div class="text-xs font-black uppercase text-slate-500">
                    Kamar yang Dipilih
                </div>

                <div class="mt-2 text-2xl font-black text-slate-900">
                    {{ $room->kode_kamar }}
                </div>

                <div class="text-sm text-slate-500">
                    Gedung {{ $buildingName }} • Lantai {{ $floorNumber }}
                </div>

            </div>

            <div class="p-6 space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-slate-500">Kapasitas</span>
                    <span class="font-bold">{{ $capacity }} Orang</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Terisi</span>
                    <span class="font-bold">{{ $usedSlot ?? $occupied }} Orang</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Skema</span>

                    <span id="summaryType" class="font-bold text-orange-600">

                        {{ $selectedType === 'private' ? 'Sekamar sendiri' : 'Sekamar berdua' }}

                    </span>

                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Harga / Bulan</span>

                    <span id="summaryPrice" class="font-bold text-orange-600">

                        Rp {{ number_format($selectedPrice, 0, ',', '.') }}

                    </span>

                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Durasi</span>
                    <span class="font-bold">6 Bulan</span>
                </div>

                <div class="flex justify-between border-t border-slate-100 pt-4">

                    <span class="font-black text-slate-900">
                        Total
                    </span>

                    <span id="summaryTotal" class="text-2xl font-black text-orange-600">

                        Rp {{ number_format($selectedTotal, 0, ',', '.') }}

                    </span>

                </div>

            </div>
            <div class="rounded-3xl bg-white p-4 ">

                <button type="button" onclick="openTermsModal()"
                    class="w-full rounded-2xl bg-orange-500 py-4 font-black text-white transition hover:bg-orange-600">

                    Lanjut ke Pembayaran

                </button>

                <a href="{{ url()->previous() }}"
                    class="mt-3 flex items-center justify-center rounded-2xl border border-slate-300 py-4 font-black text-slate-700 hover:bg-slate-50">

                    Kembali

                </a>

            </div>
        </div>



    </div>

</aside>

<div id="termsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">

    <div class="w-full max-w-4xl rounded-3xl bg-white shadow-xl">

        {{-- HEADER --}}
        <div class="border-b px-6 py-4">

            <h3 class="text-xl font-black">
                {{ $syaratKetentuan['title'] }}
            </h3>

        </div>

        {{-- CONTENT --}}
        <div id="termsContent" class="max-h-[450px] overflow-y-auto px-6 py-5 space-y-6">

            @foreach ($syaratKetentuan['sections'] ?? [] as $section)
                <div>

                    <h4 class="font-bold text-lg mb-3">

                        {{ $section['number'] }}.
                        {{ $section['title'] }}

                    </h4>

                    <ul class="space-y-2">

                        @foreach ($section['items'] as $item)
                            <li class="flex gap-3">

                                <span class="text-orange-500">•</span>

                                <span>{{ $item }}</span>

                            </li>
                        @endforeach

                    </ul>

                </div>
            @endforeach

        </div>

        {{-- FOOTER --}}
        <div class="border-t p-6">

            <label class="flex items-start gap-3">
                {{-- 
                <input id="agreeTerms" type="checkbox" disabled
                    class="mt-1 h-5 w-5 rounded border-slate-300 text-orange-500"> --}}
                <input id="agreeTerms" type="checkbox" disabled class="mt-1 h-5 w-5 rounded border-slate-300">

                <span class="text-sm text-slate-600">

                    Saya telah membaca dan menyetujui seluruh syarat dan ketentuan
                    reservasi Rusunawa UNDIP.

                </span>

            </label>

            <p class="mt-2 text-xs text-orange-600">

                Scroll hingga bagian paling bawah untuk mengaktifkan checkbox.

            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button id="continueReservation" type="button" disabled
                    class="cursor-not-allowed rounded-xl bg-orange-500 px-5 py-3 font-black text-white opacity-50">

                    Setuju & Lanjutkan

                </button>
                <button type="button" onclick="closeTermsModal()"
                    class="rounded-xl border border-slate-300 px-5 py-3 font-bold">

                    Batal

                </button>



            </div>

        </div>

    </div>

</div>
<script>
    function openTermsModal() {

        const modal = document.getElementById('termsModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    }

    function closeTermsModal() {

        const modal = document.getElementById('termsModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    }

    document.addEventListener('DOMContentLoaded', function() {

        const termsContent =
            document.getElementById('termsContent');

        const checkbox =
            document.getElementById('agreeTerms');

        const submitButton =
            document.getElementById('continueReservation');

        const reservationForm =
            document.getElementById('ReservationForm');

        if (
            !termsContent ||
            !checkbox ||
            !submitButton ||
            !reservationForm
        ) {
            return;
        }

        // Awal disable
        checkbox.disabled = true;
        submitButton.disabled = true;

        submitButton.classList.add(
            'opacity-50',
            'cursor-not-allowed'
        );

        termsContent.addEventListener('scroll', function() {

            const scrollPosition =
                this.scrollTop + this.clientHeight;

            const scrollHeight =
                this.scrollHeight;

            // Sudah sampai bawah
            if (scrollPosition >= scrollHeight - 5) {

                checkbox.disabled = false;

                document
                    .getElementById('scrollNotice')
                    ?.classList.add('hidden');
            }

        });

        checkbox.addEventListener('change', function() {

            submitButton.disabled = !this.checked;

            submitButton.classList.toggle(
                'opacity-50',
                !this.checked
            );

            submitButton.classList.toggle(
                'cursor-not-allowed',
                !this.checked
            );

        });

        submitButton.addEventListener('click', function() {

            reservationForm.submit();

        });

    });
</script>
