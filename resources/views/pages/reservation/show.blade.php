{{-- resources/views/pages/Reservation/show.blade.php --}}
@extends('landing.landing')

@section('title', 'Detail Reservation #' . $reservation->reservation_id)

@section('content')
    @php
        use Illuminate\Support\Carbon;

        $room = $Reservation->room;
        $status = $Reservation->status;
        $paymentStatus = $Reservation->payment_status;

        $start = $Reservation->start_date ? Carbon::parse($Reservation->start_date) : Carbon::now();
        $end = $Reservation->end_date
            ? Carbon::parse($Reservation->end_date)
            : $start->copy()->addMonths($Reservation->duration_month ?? 3);

        $duration = (int) ($Reservation->duration_month ?? 3);
        $pricePerMonth = (int) ($Reservation->price_per_month ?? ($room->harga ?? 0));
        $total = (int) ($Reservation->total_price ?? $pricePerMonth * $duration);

        // Label status utama
        $statusLabel = [
            'pending' => [
                'Menunggu pembayaran / verifikasi',
                'bg-amber-50 text-amber-700 border-amber-200',
                'bi-hourglass-split',
            ],
            'approved' => [
                'Disetujui, menunggu pembayaran',
                'bg-emerald-50 text-emerald-700 border-emerald-200',
                'bi-check2-circle',
            ],
            'paid' => ['Sudah dibayar', 'bg-blue-50 text-blue-700 border-blue-200', 'bi-cash-coin'],
            'rejected' => ['Ditolak', 'bg-rose-50 text-rose-700 border-rose-200', 'bi-x-circle'],
            'completed' => ['Selesai', 'bg-slate-50 text-slate-700 border-slate-200', 'bi-flag'],
            'cancelled' => ['Dibatalkan', 'bg-slate-50 text-slate-500 border-slate-200', 'bi-slash-circle'],
        ][$status] ?? ['Menunggu verifikasi', 'bg-amber-50 text-amber-700 border-amber-200', 'bi-hourglass-split'];

        [$statusText, $statusClass, $statusIcon] = $statusLabel;

        // Step indicator aktif berdasarkan status
        $step1Active = true;
        $step2Active = in_array($status, ['pending', 'approved', 'paid', 'completed']);
        $step3Active = in_array($status, ['paid', 'completed']);

        // Motor?
        $hasMotor = (bool) $Reservation->has_motor;
    @endphp

    <section class="bg-slate-50 min-h-screen pb-10">
        <div class="max-w-6xl mx-auto px-4 md:px-6 pt-6 space-y-6">

            {{-- STEP INDICATOR --}}
            <x-ui.reservation-stepper step="4" :status="$reservation->status" />
            {{-- STEP BAR --}}
            <div class="flex items-center gap-4 text-sm font-semibold">
                {{-- Step 1 --}}
                <div class="flex items-center gap-2">
                    <span
                        class="w-7 h-7 inline-flex items-center justify-center rounded-full
            {{ $isPaid ? 'bg-emerald-600 text-white' : 'bg-blue-600 text-white' }}">
                        1
                    </span>
                    <span>Detail Reservation</span>
                </div>

                <div class="h-px flex-1 bg-slate-200"></div>

                {{-- Step 2 --}}
                <div class="flex items-center gap-2">
                    <span
                        class="w-7 h-7 inline-flex items-center justify-center rounded-full
            {{ $isPaid ? 'bg-emerald-600 text-white' : 'bg-blue-100 text-blue-600' }}">
                        2
                    </span>
                    <span class="{{ $isPaid ? 'text-emerald-700' : 'text-slate-700' }}">Metode Pembayaran</span>
                </div>

                <div class="h-px flex-1 bg-slate-200"></div>

                {{-- Step 3 --}}
                <div class="flex items-center gap-2">
                    <span
                        class="w-7 h-7 inline-flex items-center justify-center rounded-full
            {{ $isPaid ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                        3
                    </span>
                    <span class="{{ $isPaid ? 'text-emerald-700' : 'text-slate-400' }}">Selesai</span>
                </div>
            </div>

            {{-- FLASH --}}
            {{-- FLASH --}}
            @if ($paymentMessage ?? false)
                <div class="bg-sky-50 text-sky-800 border border-sky-200 rounded-2xl px-4 py-3 text-sm mb-2">
                    {{ $paymentMessage }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-2xl px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('info'))
                <div
                    class="bg-blue-50 text-blue-700 border border-blue-200 rounded-2xl px-4 py-3 text-sm flex items-center gap-2">
                    <i class="bi bi-info-circle-fill text-blue-500"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div
                    class="bg-rose-50 text-rose-700 border border-rose-200 rounded-2xl px-4 py-3 text-sm flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-rose-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- GRID: DETAIL + PAYMENT + SUMMARY --}}
            <div
                class="grid grid-cols-1 lg:grid-cols-[minmax(0,2.2fr)_minmax(0,2.2fr)_minmax(260px,1.6fr)] gap-6 items-start">

                {{-- ========== LEFT: DATA Reservation ========== --}}
                <div class="space-y-4">
                    {{-- STATUS --}}
                    {{-- STATUS Reservation --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Status Reservation</div>

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div class="text-xs text-slate-400">ID Reservation:</div>
                                <div class="font-mono font-bold text-slate-900">
                                    {{ $reservation->reservation_id }}
                                </div>

                                <div class="mt-2 text-xs text-slate-400">
                                    Terakhir diperbarui: {{ $Reservation->updated_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="text-right">
                                @if ($isPaid)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="bi bi-check-circle-fill mr-1"></i>
                                        Pembayaran berhasil
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="bi bi-hourglass-split mr-1"></i>
                                        Menunggu pembayaran / verifikasi
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol di bawah status --}}
                        <div class="mt-4">
                            @if ($isPaid)
                                <a href="{{ route('Reservation.success', $Reservation) }}"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-600
                      hover:bg-emerald-700 text-white text-sm font-extrabold">
                                    Lihat ringkasan & E-Ticket
                                </a>
                            @else
                                <a href="{{ route('Reservation.payment', $Reservation) }}"
                                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-blue-600
                      hover:bg-blue-700 text-white text-sm font-extrabold">
                                    Lanjutkan pembayaran
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- KONTAK & PENGHUNI --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 md:p-5 space-y-4">
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="text-base md:text-lg font-bold text-slate-900">Data pemesan & penghuni</h2>
                            <span class="inline-flex items-center gap-1 text-[11px] text-slate-500">
                                <i class="bi bi-person-badge"></i>
                                Dibuat oleh {{ $Reservation->contact_name }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-slate-500 uppercase">Kontak utama</div>
                                <div class="font-semibold text-slate-900">
                                    {{ $Reservation->contact_name }}
                                </div>
                                <div class="text-slate-600 flex items-center gap-1 text-sm">
                                    <i class="bi bi-phone text-slate-400 text-xs"></i>
                                    <span>{{ $Reservation->contact_phone }}</span>
                                </div>
                                <div class="text-slate-600 text-xs flex items-center gap-1 break-all">
                                    <i class="bi bi-envelope text-slate-400 text-xs"></i>
                                    <span>{{ $Reservation->contact_email }}</span>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-slate-500 uppercase">Penghuni kamar</div>
                                <div class="font-semibold text-slate-900">
                                    {{ $Reservation->guest_name }}
                                </div>

                                <div class="text-slate-600 text-xs flex flex-wrap gap-x-2 gap-y-0.5">
                                    @if ($Reservation->guest_nim)
                                        <span>NIM: {{ $Reservation->guest_nim }}</span>
                                    @endif
                                    @if ($Reservation->guest_major)
                                        <span>{{ $Reservation->guest_major }}</span>
                                    @endif
                                    @if ($Reservation->guest_faculty)
                                        <span>• {{ $Reservation->guest_faculty }}</span>
                                    @endif
                                    @if ($Reservation->guest_intake_year)
                                        <span>• Angkatan {{ $Reservation->guest_intake_year }}</span>
                                    @endif
                                </div>

                                @if ($Reservation->parent_name || $Reservation->parent_phone)
                                    <div class="mt-1 text-xs text-slate-500">
                                        Orang tua / wali:
                                        <span class="font-semibold text-slate-700">
                                            {{ $Reservation->parent_name ?? '-' }}
                                        </span>
                                        @if ($Reservation->parent_phone)
                                            • {{ $Reservation->parent_phone }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($Reservation->special_request)
                            <div class="pt-3 border-t border-slate-100 text-xs text-slate-600">
                                <div class="font-semibold text-slate-800 mb-1">Catatan untuk pengelola:</div>
                                <p class="whitespace-pre-line">{{ $Reservation->special_request }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- DOKUMEN --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 md:p-5 space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center">
                                <i class="bi bi-file-earmark-text text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-base md:text-lg font-bold text-slate-900">Dokumen pendukung</h2>
                                <p class="text-xs text-slate-500">
                                    Dokumen digunakan untuk verifikasi oleh admin Rusunawa UNDIP.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs md:text-sm">
                            <div
                                class="border border-dashed border-slate-300 rounded-xl px-3 py-3 bg-slate-50/60 flex flex-col gap-1.5">
                                <div class="font-semibold text-slate-800 flex items-center gap-1.5">
                                    <i class="bi bi-card-text text-slate-500"></i>
                                    <span>KTM</span>
                                </div>
                                @if ($Reservation->ktm_path)
                                    <a href="{{ asset('storage/' . $Reservation->ktm_path) }}" target="_blank"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                        <i class="bi bi-file-earmark"></i>
                                        <span>Lihat file KTM</span>
                                    </a>
                                @else
                                    <p class="text-slate-500">Belum ada file.</p>
                                @endif
                            </div>

                            <div
                                class="border border-dashed border-slate-300 rounded-xl px-3 py-3 bg-slate-50/60 flex flex-col gap-1.5">
                                <div class="font-semibold text-slate-800 flex items-center gap-1.5">
                                    <i class="bi bi-bicycle text-slate-500"></i>
                                    <span>STNK (jika membawa motor)</span>
                                </div>
                                @if ($hasMotor)
                                    @if ($Reservation->stnk_path)
                                        <a href="{{ asset('storage/' . $Reservation->stnk_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                            <i class="bi bi-file-earmark"></i>
                                            <span>Lihat file STNK</span>
                                        </a>
                                    @else
                                        <p class="text-slate-500">Motor terdaftar, tetapi file STNK belum ada.</p>
                                    @endif
                                @else
                                    <p class="text-slate-500">Mahasiswa tidak membawa motor.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== MIDDLE: METODE PEMBAYARAN (INFO) ========== --}}
                {{-- METODE PEMBAYARAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <h2 class="text-lg font-bold text-slate-900 mb-1">Metode pembayaran</h2>

                    @if ($isPaid)
                        <p class="text-sm text-slate-600 mb-3">
                            Pembayaran kamu sudah <span class="font-semibold text-emerald-700">berhasil</span>.
                            Tidak perlu melakukan pembayaran lagi.
                        </p>

                        <ul class="text-xs text-slate-500 space-y-1 mb-4">
                            <li>• Tunjukkan ID Reservation di loket saat check-in.</li>
                            <li>• Kamu bisa mengunduh E-ticket / bukti reservasi pada tombol di sebelah kanan.</li>
                        </ul>

                        <a href="{{ route('Reservation.success', $Reservation) }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-600
                  hover:bg-emerald-700 text-white text-sm font-extrabold">
                            Download E-Ticket / Bukti Reservasi
                        </a>
                    @else
                        {{-- versi lama: pilihan metode + tombol "Lanjutkan pembayaran" --}}
                        {{-- ... (kode yang sudah kamu punya) ... --}}
                    @endif
                </div>

                {{-- ========== RIGHT: SUMMARY KAMAR & BIAYA ========== --}}
                <aside class="lg:sticky lg:top-6">
                    <div class="space-y-4">

                        {{-- ROOM SUMMARY --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-4 md:px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                    @php
                                        $roomThumb = optional($room->photos->first())->path ?? ($room->foto ?? null);
                                        $roomThumb = $roomThumb
                                            ? asset(ltrim($roomThumb, '/'))
                                            : asset('assets-admin/images/hero-1.jpg');
                                    @endphp
                                    <img src="{{ $roomThumb }}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-semibold text-slate-500 uppercase">Kamar yang diReservation
                                    </div>
                                    <div class="text-sm md:text-base font-bold text-slate-900 truncate">
                                        Kamar {{ $room->kode_kamar ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        Gedung {{ preg_replace('/^Gedung\s+/i', '', (string) ($room->gedung ?? '-')) }},
                                        Lantai {{ $room->lantai ?? '-' }} • Kapasitas {{ $room->capacity ?? 2 }}
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 md:px-5 py-4 space-y-3 text-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="text-xs text-slate-500 uppercase">Perkiraan mulai sewa</div>
                                    <div class="text-right">
                                        <div class="font-semibold text-slate-900">
                                            {{ $start->translatedFormat('l, d F Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start justify-between gap-3">
                                    <div class="text-xs text-slate-500 uppercase">Perkiraan selesai sewa</div>
                                    <div class="text-right">
                                        <div class="font-semibold text-slate-900">
                                            {{ $end->translatedFormat('l, d F Y') }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            Durasi {{ $duration }} bulan • 1 kamar
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRICE SUMMARY --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                            <div class="px-4 md:px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Rincian biaya</div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        Sewa kamar berbasis paket bulanan.
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 md:px-5 py-4 space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">
                                        Sewa kamar ({{ $duration }} bulan)
                                    </span>
                                    <span class="font-semibold text-slate-900">
                                        Rp {{ number_format($pricePerMonth * $duration, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="border-t border-slate-200 pt-3 mt-1 flex items-center justify-between">
                                    <div class="text-xs font-semibold text-slate-500 uppercase">
                                        TOTAL YANG DIBAYAR
                                    </div>
                                    <div class="text-base md:text-lg font-black text-orange-600">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </div>
                                </div>

                                <p class="mt-2 text-[11px] text-slate-400">
                                    Nominal di atas adalah simulasi perhitungan berdasarkan durasi sewa yang dipilih.
                                    Perhitungan final mengikuti konfirmasi dari pengelola Rusunawa UNDIP.
                                </p>
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex flex-col gap-2">
                            @if (in_array($status, ['pending', 'approved']) && $paymentStatus === 'pending')
                                <a href="{{ route('Reservation.payment', $Reservation) }}"
                                    class="inline-flex justify-center items-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-xs md:text-sm font-extrabold text-white shadow-sm">
                                    <i class="bi bi-credit-card-2-front mr-1.5"></i>
                                    Lanjutkan pembayaran
                                </a>
                            @endif

                            <a href="{{ route('cari-kamar.index') }}"
                                class="inline-flex justify-center items-center px-4 py-2.5 rounded-xl border border-slate-300 text-xs md:text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <i class="bi bi-search me-1.5"></i>
                                Reservasi Kamar lain
                            </a>

                            <a
                                href="{{ route('dashboard') }}
                           "class="inline-flex justify-center items-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-xs md:text-sm font-semibold text-white">
                                <i class="bi bi-layout-text-sidebar me-1.5"></i>
                                Lihat riwayat Reservation di dashboard
                            </a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>
@endsection
