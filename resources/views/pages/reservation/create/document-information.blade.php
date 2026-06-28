{{-- DOKUMEN --}}
<div>
    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">Dokumen Pendukung</h2>
        <p class="mt-1 text-sm text-slate-500">Pas foto tersimpan ke user, KTM/STNK tersimpan ke profil mahasiswa.</p>
    </div>

    <div class="px-5 md:px-6 py-5 space-y-5">
        {{-- PAS FOTO --}}
        <div>

            <label class="block mb-2.5 text-sm font-semibold text-slate-800">

                Upload Pas Foto
                <span class="text-red-500">*</span>

            </label>

            <input id="profile_photo_file" name="profile_photo_file" type="file" accept=".jpg,.jpeg,.png"
                class="cursor-pointer w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-orange-600">

            {{-- PREVIEW --}}
            <div id="profilePhotoPreviewWrapper"
                class="hidden mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="bg-slate-50 p-6">

                    <img id="profilePhotoPreviewImage"
                        class="hidden mx-auto max-h-[500px] w-auto rounded-2xl border border-slate-200 object-contain bg-white">

                    <div id="profilePhotoPdfPreview" class="hidden flex flex-col items-center justify-center py-10">

                        <svg class="h-20 w-20 text-red-500" fill="currentColor" viewBox="0 0 24 24">

                            <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />

                        </svg>

                        <p class="mt-2 font-bold text-slate-700">
                            Dokumen PDF
                        </p>

                    </div>

                </div>

                <div class="border-t border-slate-200 p-4">

                    <div class="flex items-start justify-between">

                        <div>

                            <p id="profilePhotoPreviewName" class="font-bold text-slate-900">
                            </p>

                            <p id="profilePhotoPreviewSize" class="text-xs text-slate-500">
                            </p>

                        </div>

                        <button type="button" id="removeProfilePhotoFile"
                            class="rounded-xl p-2 transition hover:bg-red-50">

                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                </div>

            </div>

        </div>
        <div id="kipDocumentSection" class="opacity-60 transition">

            <div>

                <label class="block mb-2.5 text-sm font-semibold text-slate-800" for="kip_document">

                    Bukti KIP / Bidikmisi

                </label>

                <input id="kip_document" name="kip_document" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    class="cursor-pointer w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-orange-600">

            </div>

            {{-- PREVIEW FILE --}}
            <div id="kipPreviewWrapper"
                class="hidden mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="bg-slate-50 p-5 flex justify-center items-center">

                    <img id="kipPreviewImage"
                        class="hidden w-full h-auto rounded-2xl border border-slate-200 object-contain">

                    <div id="kipPreviewPdf" class="hidden flex flex-col items-center justify-center py-10">

                        <svg class="w-20 h-20 text-red-500" fill="currentColor" viewBox="0 0 24 24">

                            <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />

                        </svg>

                        <p class="mt-2 font-bold text-slate-700">
                            Dokumen PDF
                        </p>

                    </div>

                </div>

                <div class="border-t border-slate-200 p-4">

                    <div class="flex justify-between items-start">

                        <div>

                            <p id="kipPreviewName" class="font-bold text-slate-900">
                            </p>

                            <p id="kipPreviewSize" class="text-xs text-slate-500">
                            </p>

                        </div>

                        <button type="button" id="removeKipFile" class="rounded-xl p-2 hover:bg-red-50">

                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <div>

            <div>

                <label class="block mb-2.5 text-sm font-semibold text-slate-800" for="ktm_file">

                    Upload KTM
                    <span class="text-red-500">*</span>

                </label>

                <input id="ktm_file" name="ktm_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
                    class="cursor-pointer w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-orange-600">

            </div>

            {{-- PREVIEW FILE --}}
            <div id="ktmPreviewWrapper"
                class="hidden mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="bg-slate-50 p-5">

                    <img id="ktmPreviewImage"
                        class="hidden w-full h-auto rounded-2xl border border-slate-200 object-contain">

                    <div id="ktmPreviewPdf" class="hidden flex flex-col items-center justify-center py-10">

                        <svg class="w-20 h-20 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                        </svg>

                        <p class="mt-2 font-bold text-slate-700">
                            Dokumen PDF
                        </p>

                    </div>

                </div>

                <div class="border-t border-slate-200 p-4">

                    <div class="flex justify-between items-start">

                        <div>

                            <p id="ktmPreviewName" class="font-bold text-slate-900">
                            </p>

                            <p id="ktmPreviewSize" class="text-xs text-slate-500">
                            </p>

                        </div>

                        <button type="button" id="removeKtmFile" class="rounded-xl p-2 hover:bg-red-50">

                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <div>
            <label class="block mb-2 text-sm font-bold text-slate-800">
                Apakah membawa kendaraan? <span class="text-red-500">*</span>
            </label>

            <div class="grid sm:grid-cols-2 gap-3">
                <label
                    class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 cursor-pointer hover:border-orange-300 hover:bg-orange-50">
                    <input type="radio" name="has_motor" value="1"
                        {{ old('has_motor', $formData['has_motor'] ?? '') == '1' ? 'checked' : '' }}>
                    <span class="text-sm font-semibold text-slate-700">Ya, membawa kendaraan</span>
                </label>

                <label
                    class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 cursor-pointer hover:border-orange-300 hover:bg-orange-50">
                    <input type="radio" name="has_motor" value="0"
                        {{ old('has_motor', $formData['has_motor'] ?? '') == '0' ? 'checked' : '' }}>
                    <span class="text-sm font-semibold text-slate-700">Tidak membawa
                        kendaraan</span>
                </label>
            </div>
        </div>

        <div id="vehicleWrapper" class="space-y-5 opacity-50">
            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Plat Nomor Kendaraan
                </label>

                <input type="text" name="vehicle_plate_number" id="vehicle_plate_number" required
                    value="{{ old('vehicle_plate_number', $formData['vehicle_plate_number'] ?? '') }}"
                    placeholder="H 1234 ABC" disabled
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm uppercase focus:border-orange-500 focus:ring-orange-500">
            </div>

            {{-- STNK --}}
            <div>

                <div>

                    <label class="block mb-2.5 text-sm font-semibold text-slate-800" for="stnk_file">

                        Upload STNK

                    </label>

                    <input id="stnk_file" name="stnk_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
                        class="cursor-pointer w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-orange-600">

                </div>

                {{-- PREVIEW --}}
                <div id="stnkPreviewWrapper"
                    class="hidden mt-4 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    <div class="bg-slate-50 p-5 flex justify-center items-center">

                        <img id="stnkPreviewImage"
                            class="hidden w-full h-auto rounded-2xl border border-slate-200 object-contain">

                        <div id="stnkPreviewPdf" class="hidden flex flex-col items-center justify-center py-10">

                            <svg class="w-20 h-20 text-red-500" fill="currentColor" viewBox="0 0 24 24">

                                <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />

                            </svg>

                            <p class="mt-2 font-bold text-slate-700">
                                Dokumen PDF
                            </p>

                        </div>

                    </div>

                    <div class="border-t border-slate-200 p-4">

                        <div class="flex justify-between items-start">

                            <div>

                                <p id="stnkPreviewName" class="font-bold text-slate-900">
                                </p>

                                <p id="stnkPreviewSize" class="text-xs text-slate-500">
                                </p>

                            </div>

                            <button type="button" id="removeStnkFile" class="rounded-xl p-2 hover:bg-red-50">

                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />

                                </svg>

                            </button>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
