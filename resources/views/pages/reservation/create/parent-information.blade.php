{{-- ORTU --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm">
    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">
            Data Orang Tua / Wali
        </h2>
    </div>

    <div class="px-5 md:px-6 py-5 space-y-4">

        <div class="grid md:grid-cols-2 gap-4 items-start">

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Nama Orang Tua/Wali <span class="text-red-500">*</span>
                </label>

                <input type="text" name="parent_name" required
                    value="{{ old('parent_name', $formData['parent_name'] ?? '') }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">


            </div>




            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    No HP Orang Tua/Wali <span class="text-red-500">*</span>
                </label>

                <input type="tel" id="parent_phone" name="parent_phone" required
                    value="{{ old('parent_phone', $formData['parent_phone'] ?? '') }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Pekerjaan Orang Tua/Wali <span class="text-red-500">*</span>
                </label>

                <input type="text" name="parent_job" required
                    value="{{ old('parent_job', $formData['parent_job'] ?? '') }}" placeholder="Contoh: Wiraswasta"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Alamat Orang Tua/Wali <span class="text-red-500">*</span>
                </label>

                <textarea name="parent_address" rows="4" required placeholder="Masukkan alamat orang tua/wali lengkap"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">{{ old('parent_address', $formData['parent_address'] ?? '') }}</textarea>
            </div>

        </div>
    </div>
</div>
