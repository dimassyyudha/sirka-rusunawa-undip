<div>

    <div class="px-5 md:px-6 py-5 border-b border-slate-100">
        <h2 class="text-lg font-black text-slate-900">
            Data Mahasiswa / Penghuni
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Data ini akan tersimpan ke profil mahasiswa.
        </p>
    </div>

    <div class="px-5 md:px-6 py-5 space-y-5">

        {{-- NAMA --}}
        <div>
            <label class="block mb-2 text-sm font-bold text-slate-800">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>

            <input type="text" name="guest_name" required
                value="{{ old('guest_name', $formData['guest_name'] ?? (auth()->user()->name ?? '')) }}"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
        </div>

        {{-- NIM & ANGKATAN --}}
        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    NIM <span class="text-red-500">*</span>
                </label>

                <input type="text" name="guest_nim" required maxlength="14"
                    value="{{ old('guest_nim', $formData['guest_nim'] ?? '') }}" placeholder="240601xxxxxxxx"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Angkatan <span class="text-red-500">*</span>
                </label>

                <input type="text" name="guest_intake_year" required maxlength="4"
                    value="{{ old('guest_intake_year', $formData['guest_intake_year'] ?? '') }}" placeholder="2024"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

        </div>

        {{-- FAKULTAS & JURUSAN --}}
        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Fakultas <span class="text-red-500">*</span>
                </label>

                <input type="text" name="guest_faculty" required
                    value="{{ old('guest_faculty', $formData['guest_faculty'] ?? '') }}" placeholder="Teknik"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Jurusan / Prodi <span class="text-red-500">*</span>
                </label>

                <input type="text" name="guest_major" required
                    value="{{ old('guest_major', $formData['guest_major'] ?? '') }}" placeholder="Informatika"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

        </div>

        {{-- WA & EMAIL --}}
        <div class="grid md:grid-cols-2 gap-4 items-start">

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Nomor WhatsApp <span class="text-red-500">*</span>
                </label>

                <input type="tel" id="phone" name="contact_phone" required
                    value="{{ old('contact_phone', $formData['contact_phone'] ?? (auth()->user()->number_phone ?? '')) }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
                <p class="mt-2 text-xs text-red-500">
                    Gunakan nomor WhatsApp aktif.
                </p>
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Email <span class="text-red-500">*</span>
                </label>

                <input type="email" name="contact_email" required
                    value="{{ old('contact_email', $formData['contact_email'] ?? (auth()->user()->email ?? '')) }}"
                    placeholder="nama@gmail.com"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
                <p class="mt-2 text-xs text-red-500">
                    Gunakan Email Aktif.
                </p>
            </div>

        </div>

        {{-- TEMPAT & TANGGAL LAHIR --}}
        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Tempat Lahir <span class="text-red-500">*</span>
                </label>

                <input type="text" name="birth_place" required
                    value="{{ old('birth_place', $formData['birth_place'] ?? '') }}" placeholder="Semarang"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-bold text-slate-800">
                    Tanggal Lahir <span class="text-red-500">*</span>
                </label>

                <input type="date" name="birth_date" required
                    value="{{ old('birth_date', $formData['birth_date'] ?? '') }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

        </div>

        <div>
            <label class="block mb-3 text-sm font-bold text-slate-800">
                Jalur Pembiayaan <span class="text-red-500">*</span>
            </label>

            <div class="grid md:grid-cols-2 gap-4">

                <label
                    class="rounded-2xl border border-slate-300 p-4 cursor-pointer hover:border-orange-400 hover:bg-orange-50/40 transition">

                    <input type="radio" name="jalur_pembiayaan" value="Non-Bidikmisi/KIP-K" required
                        class="text-orange-500 focus:ring-orange-500"
                        {{ old('jalur_pembiayaan', $formData['jalur_pembiayaan'] ?? 'Non-Bidikmisi/KIP-K') == 'Non-Bidikmisi/KIP-K' ? 'checked' : '' }}>
                    <div class="mt-2 font-bold text-red-600">
                        Non Bidikmisi / KIP-K
                    </div>

                    <div class="mt-1 text-sm text-slate-500">
                        Mahasiswa reguler dengan skema pembayaran normal.
                    </div>

                </label>

                <label
                    class="rounded-2xl border border-slate-300 p-4 cursor-pointer hover:border-orange-400 hover:bg-orange-50/40 transition">
                    {{-- 
                                        <input type="radio" name="jalur_pembiayaan" value="Bidikmisi/KIP-K" required
                                            class="text-orange-500 focus:ring-orange-500"
                                            {{ old('jalur_pembiayaan', ($formData['jalur_pembiayaan'] ?? '') === 'Bidikmisi/KIP-K' ? 'checked' : '') }}> --}}
                    <input type="radio" name="jalur_pembiayaan" value="Bidikmisi/KIP-K" required
                        class="text-orange-500 focus:ring-orange-500"
                        {{ old('jalur_pembiayaan', $formData['jalur_pembiayaan'] ?? '') == 'Bidikmisi/KIP-K' ? 'checked' : '' }}>

                    <div class="mt-2 font-bold text-emerald-600">
                        Bidikmisi / KIP-K
                    </div>

                    <div class="mt-1 text-sm text-slate-500">
                        Dapat memilih pembayaran penuh semester atau termin 3 bulan.
                    </div>

                </label>

            </div>

        </div>

        {{-- AGAMA --}}
        <div>

            <label class="block mb-2 text-sm font-bold text-slate-800">
                Agama <span class="text-red-500">*</span>
            </label>

            <select name="religion" required
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">

                <option value="">Pilih Agama</option>
                <option value="Islam" @selected(old('religion', $formData['religion'] ?? '') === 'Islam')>
                    Islam
                </option>

                <option value="Kristen" @selected(old('religion', $formData['religion'] ?? '') === 'Kristen')>
                    Kristen
                </option>

                <option value="Katolik" @selected(old('religion', $formData['religion'] ?? '') === 'Katolik')>
                    Katolik
                </option>

                <option value="Hindu" @selected(old('religion', $formData['religion'] ?? '') === 'Hindu')>
                    Hindu
                </option>
                <option value="Buddha" @selected(old('religion', $formData['religion'] ?? '') === 'Buddha')>
                    Buddha
                </option>
                <option value="Konghucu" @selected(old('religion', $formData['religion'] ?? '') === 'Konghucu')>
                    Konghucu
                </option>

            </select>

        </div>

        {{-- ALAMAT --}}
        <div>

            <label class="block mb-2 text-sm font-bold text-slate-800">
                Alamat Rumah Asal <span class="text-red-500">*</span>
            </label>

            <textarea name="home_address" rows="4" required placeholder="Masukkan alamat rumah asal lengkap"
                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-orange-500 focus:ring-orange-500">{{ old('home_address', $formData['home_address'] ?? '') }}</textarea>

        </div>

    </div>

</div>
