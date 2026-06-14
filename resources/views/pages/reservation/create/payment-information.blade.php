{{-- SKEMA PEMBAYARAN --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm">

    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">
            Skema Pembayaran
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Pembayaran mengikuti ketentuan Rusunawa UNDIP.
        </p>
    </div>

    <div class="px-5 md:px-6 py-5 grid md:grid-cols-2 gap-4">

        {{-- FULL SEMESTER --}}
        <label class="rounded-3xl border p-5 cursor-pointer hover:border-orange-400 hover:bg-orange-50/40">

            <input type="radio" name="payment_term" id="payment_6" value="6" checked
                class="text-orange-500 focus:ring-orange-500">

            <div class="mt-3 font-black text-slate-900">
                Bayar Full Semester
            </div>

            <div class="mt-1 text-sm text-slate-500">
                Pembayaran dilakukan sekaligus untuk seluruh periode hunian yang tersisa.
            </div>

            <div class="mt-3 text-sm font-bold text-green-600">
                Tersedia untuk semua mahasiswa
            </div>

        </label>

        {{-- TERMIN --}}
        <label id="payment3Label" class="rounded-3xl border p-5 transition opacity-60 cursor-not-allowed bg-slate-50">

            <input type="radio" name="payment_term" id="payment_3" value="3" disabled
                class="text-orange-500 focus:ring-orange-500">

            <div class="mt-3 font-black text-slate-900">
                Termin 3 Bulan
            </div>

            <div class="mt-1 text-sm text-slate-500">
                Khusus mahasiswa KIP / Bidikmisi yang ingin melakukan pembayaran bertahap setiap 3
                bulan.
            </div>

            <div class="mt-3 text-sm font-bold text-red-500">
                Hanya tersedia untuk mahasiswa KIP / Bidikmisi
            </div>

        </label>

    </div>

</div>
