<div class="xl:hidden mt-6">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-5 py-5 border-b border-slate-100">
            <div class="text-xs font-black text-slate-500 uppercase">
                Ringkasan Pembayaran
            </div>

            <div class="mt-2 text-xl font-black text-slate-900">
                {{ $room->kode_kamar }}
            </div>
        </div>

        <div class="px-5 py-5">

            <div class="flex justify-between">
                <span>Total</span>

                <span id="summaryTotalMobile" class="text-2xl font-black text-orange-600">
                    Rp {{ number_format($selectedTotal, 0, ',', '.') }}
                </span>
            </div>

        </div>

    </div>
</div>
<aside class="hidden lg:block space-y-4">

    <div class="sticky top-20 space-y-4">
        {{-- SUMMARY --}}

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- <div class="px-5 py-5 border-b border-slate-100"> --}}
            <div class="px-5 py-6 border-b border-slate-100 min-h-[120px] flex flex-col justify-center">
                <div class="text-xs font-black text-slate-500 uppercase">Kamar yang dipilih</div>
                <div class="mt-2 text-xl font-black text-slate-900">
                    {{ $room->kode_kamar ?? '-' }}
                </div>
                <div class="mt-1 text-sm text-slate-500">
                    Gedung {{ $buildingName }} • Lantai {{ $floorNumber }}
                </div>
            </div>

            <div class="px-5 py-5 space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Kapasitas</span>
                    <span class="font-black">{{ $capacity }} orang</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Terisi</span>
                    <span class="font-black">{{ $usedSlot ?? $occupied }} orang</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Harga kamar / bulan</span>
                    <span class="font-black">Rp {{ number_format($monthlyPrice, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Skema dipilih</span>
                    <span id="summaryType" class="font-black text-orange-600">
                        {{ $selectedType === 'private' ? 'Sekamar sendiri' : 'Sekamar berdua' }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Harga kamu / bulan</span>
                    <span id="summaryPrice" class="font-black text-orange-600">
                        Rp {{ number_format($selectedPrice, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-600">Durasi</span>
                    <span class="font-black">6 bulan</span>
                </div>

                <div class="border-t border-slate-100 pt-4 flex justify-between items-start">
                    <span class="text-slate-900 font-black">Total</span>
                    <span id="summaryTotal" class="text-2xl font-black text-orange-600">
                        Rp {{ number_format($selectedTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- <div class="rounded-3xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900 leading-relaxed">
                        Setelah data disimpan, kamu akan diarahkan ke pembayaran Midtrans Sandbox.
                    </div> --}}

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 space-y-3">

            <button type="submit" form="ReservationForm"
                class="w-full rounded-2xl bg-orange-500 py-4 text-white font-black hover:bg-orange-600">

                Lanjut ke Pembayaran

            </button>


            <a href="{{ url()->previous() }}"
                class="flex items-center justify-center w-full rounded-2xl border border-slate-300 py-4 font-black text-slate-700 hover:bg-slate-50">

                Kembali

            </a>

        </div>
    </div>

</aside>
