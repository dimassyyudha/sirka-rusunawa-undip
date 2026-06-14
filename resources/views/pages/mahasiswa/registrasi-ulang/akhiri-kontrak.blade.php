@extends('layouts.app')

@section('title', 'Akhiri Kontrak')
@section('page_title', 'Akhiri Kontrak')

@section('content')


    <div class="max-w-3xl mx-auto space-y-6">


        <div class="bg-white rounded-3xl border border-red-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-red-100 bg-red-50">

                <h1 class="text-2xl font-black text-red-600">
                    Akhiri Kontrak Kamar
                </h1>

                <p class="mt-2 text-sm text-red-500">
                    Pengajuan akhiri kontrak akan dikirim ke admin untuk diverifikasi.
                </p>

            </div>

            <div class="p-6">

                <div class="rounded-2xl border border-slate-200 p-5 mb-6">

                    <p class="text-sm text-slate-500">
                        Kamar Aktif
                    </p>

                    <h2 class="mt-2 text-3xl font-black text-slate-900">
                        {{ $room->kode_kamar ?? '-' }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        {{ $room->floor->building->name ?? '-' }}
                        •
                        Lantai {{ $room->floor->floor_number ?? '-' }}
                    </p>

                </div>

                <form action="{{ route('mahasiswa.registrasi-ulang.akhiri-kontrak.store') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5" data-confirm-form
                    data-confirm-title="Ajukan akhiri kontrak?"
                    data-confirm-text="Pengajuan akhiri kontrak akan dikirim ke admin."
                    data-confirm-button-text="Ya, ajukan">

                    @csrf

                    <div>
                        <label class="block mb-2 text-sm font-bold text-slate-700">
                            Tanggal Keluar
                        </label>

                        <input type="date" name="checkout_date" value="{{ old('checkout_date') }}"
                            min="{{ now()->format('Y-m-d') }}" max="{{ $period->lease_end_date?->format('Y-m-d') }}"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:border-red-500 focus:ring-red-500"
                            required>
                        <p class="mt-2 text-xs text-slate-500">
                            Tanggal keluar maksimal sampai
                            <span class="font-bold text-red-600">
                                {{ $period->lease_end_date?->format('d M Y') }}
                            </span>
                            sesuai batas akhir masa hunian periode ini.
                        </p>

                        @error('checkout_date')
                            <p class="mt-2 text-sm font-semibold text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-bold text-slate-700">
                            Alasan Mengakhiri Kontrak
                        </label>

                        <textarea name="notes" rows="5"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 focus:border-red-500 focus:ring-red-500"
                            placeholder="Tuliskan alasan mengakhiri kontrak..." required>{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-2 text-sm font-semibold text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- <div>
                        <label class="block mb-2 text-sm font-bold text-slate-700">
                            Surat Pernyataan Akhiri Kontrak
                        </label>

                        <label for="statement_file"
                            class="flex flex-col items-center justify-center w-full py-9 border border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition">

                            <div class="mb-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                    fill="none">
                                    <path
                                        d="M16.296 25.3935L19.9997 21.6667L23.7034 25.3935M19.9997 35V21.759M10.7404 27.3611H9.855C6.253 27.3611 3.33301 24.4411 3.33301 20.8391C3.33301 17.2371 6.253 14.3171 9.855 14.3171C10.344 14.3171 10.736 13.9195 10.7816 13.4326C11.2243 8.70174 15.1824 5 19.9997 5C25.1134 5 29.2589 9.1714 29.2589 14.3171H30.1444C33.7463 14.3171 36.6663 17.2371 36.6663 20.8391C36.6663 24.4411 33.7463 27.3611 30.1444 27.3611H29.2589"
                                        stroke="#f97316" stroke-width="1.6" stroke-linecap="round" />
                                </svg>
                            </div>

                            <h4 class="text-center text-slate-900 text-sm font-bold leading-snug">
                                Klik untuk upload surat pernyataan
                            </h4>

                            <p class="mt-1 text-center text-slate-400 text-xs">
                                PDF, JPG, JPEG, atau PNG maksimal 15MB
                            </p>

                            <input id="statement_file" name="statement_file" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                class="hidden" required>
                        </label>

                        <p id="selectedFileName"
                            class="mt-3 hidden rounded-2xl bg-slate-50 border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">
                        </p>

                        @error('statement_file')
                            <p class="mt-2 text-sm font-semibold text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div> --}}

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                        Setelah pengajuan dikirim, admin akan memverifikasi alasan dan surat pernyataan akhiri kontrak.
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">

                        <x-button.button-menu href="{{ route('mahasiswa.registrasi-ulang.index') }}"
                            class="bg-slate-100 text-slate-700 hover:bg-slate-200 justify-center">
                            Kembali
                        </x-button.button-menu>

                        <button type="submit"
                            class="flex-1 px-5 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-black transition">
                            Ajukan Pengakhiran Kontrak
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            const fileInput = document.getElementById('statement_file');
            const fileNameBox = document.getElementById('selectedFileName');

            if (fileInput && fileNameBox) {
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];

                    if (!file) {
                        fileNameBox.classList.add('hidden');
                        fileNameBox.textContent = '';
                        return;
                    }

                    fileNameBox.classList.remove('hidden');
                    fileNameBox.textContent = 'File dipilih: ' + file.name;
                });
            }
        </script>
    @endpush

@endsection
