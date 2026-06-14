{{-- SKEMA HUNIAN --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm">
    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">Skema Hunian</h2>
        <p class="mt-1 text-sm text-slate-500">Durasi Reservation tetap 6 bulan / 1 semester.</p>
    </div>

    <div class="px-5 md:px-6 py-5 grid md:grid-cols-2 gap-4">
        <label
            class="rounded-3xl border p-5 transition {{ $canPrivate ? 'cursor-pointer hover:border-orange-400 hover:bg-orange-50/40' : 'opacity-50 cursor-not-allowed bg-slate-50' }}">
            <input type="radio" name="occupancy_type" value="private" class="text-orange-500 focus:ring-orange-500"
                data-price="{{ $privatePricePerMonth }}" {{ $selectedType === 'private' ? 'checked' : '' }}
                {{ !$canPrivate ? 'disabled' : '' }}>
            <div class="mt-3 font-black text-slate-900">Sekamar sendiri</div>
            <div class="mt-1 text-sm text-slate-500">Bayar full harga kamar. Slot kamar langsung
                penuh.
            </div>
            <div class="mt-3 text-lg font-black text-orange-600">
                Rp {{ number_format($privatePricePerMonth, 0, ',', '.') }} / bulan
            </div>
            @if (!$canPrivate)
                <div class="mt-2 text-xs font-bold text-red-500">
                    Tidak tersedia karena kamar sudah memiliki penghuni.
                </div>
            @endif
        </label>

        <label
            class="rounded-3xl border p-5 transition {{ $canShared ? 'cursor-pointer hover:border-orange-400 hover:bg-orange-50/40' : 'opacity-50 cursor-not-allowed bg-slate-50' }}">
            <input type="radio" name="occupancy_type" required value="shared"
                class="text-orange-500 focus:ring-orange-500" data-price="{{ $sharedPricePerMonth }}"
                {{ $selectedType === 'shared' ? 'checked' : '' }} {{ !$canShared ? 'disabled' : '' }}>
            <div class="mt-3 font-black text-slate-900">Sekamar berdua / join</div>
            <div class="mt-1 text-sm text-slate-500">Bayar sesuai pembagian kapasitas kamar.</div>
            <div class="mt-3 text-lg font-black text-orange-600">
                Rp {{ number_format($sharedPricePerMonth, 0, ',', '.') }} / bulan
            </div>
            @if (!$canShared)
                <div class="mt-2 text-xs font-bold text-red-500">
                    Tidak tersedia karena kamar penuh.
                </div>
            @endif
        </label>
    </div>
</div>
