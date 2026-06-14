@extends('layouts.app')
@section('title', 'Detail Reservasi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Reservasi</h3>
                    <p class="text-subtitle text-muted">
                        Informasi lengkap reservasi kamar mahasiswa.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.reservations.index') }}">Manajemen Reservasi</a>
                            </li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @php
            /**
             * RULE:
             * - Tampilkan kamar hanya jika:
             *   1) lantai = 1
             *   2) status = tersedia
             *   3) slot > 0 (capacity - occupied)
             * - Kalau tidak memenuhi, tampilkan "-" (anggap penuh / tidak tersedia)
             */
            $room = $reservation->room ?? null;

            $capacity = (int) ($room->capacity ?? 2);
            $occupied = (int) ($room->occupied ?? 0);
            $slots = max(0, $capacity - $occupied);

            $roomOk = $room && (int) ($room->lantai ?? 0) === 1 && ($room->status ?? '') === 'tersedia' && $slots > 0;

            $roomToShow = $roomOk ? $room : null;
        @endphp

        <section class="section">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Data Reservasi</h4>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>

                            {{-- MAHASISWA --}}
                            <tr>
                                <th width="30%">Nama Mahasiswa</th>
                                <td>{{ $reservation->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $reservation->user->email }}</td>
                            </tr>

                            {{-- KAMAR (HANYA LANTAI 1 & TERSEDIA, YANG PENUH TIDAK DITAMPILKAN) --}}
                            <tr>
                                <th>Kode Kamar</th>
                                <td class="fw-bold">
                                    {{ $roomToShow?->kode_kamar ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Gedung / Lantai</th>
                                <td>
                                    @if ($roomToShow)
                                        Gedung {{ $roomToShow->gedung }},
                                        Lantai {{ $roomToShow->lantai }}
                                        <span class="badge bg-success ms-2">Tersedia</span>
                                        <span class="badge bg-info ms-2">Sisa {{ $slots }} slot</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>

                            {{-- PERIODE --}}
                            <tr>
                                <th>Periode</th>
                                <td>{{ $reservation->periode ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>{{ optional($reservation->start_date)->format('d M Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ optional($reservation->end_date)->format('d M Y') ?? '-' }}</td>
                            </tr>

                            {{-- STATUS --}}
                            <tr>
                                <th>Status Reservasi</th>
                                <td>
                                    @php($st = $reservation->status)
                                    @if ($st === 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($st === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($st === 'cancelled')
                                        <span class="badge bg-secondary">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- CATATAN --}}
                            <tr>
                                <th>Catatan Admin</th>
                                <td>{{ $reservation->notes ?? '-' }}</td>
                            </tr>

                            {{-- WAKTU --}}
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $reservation->created_at->format('d M Y H:i') }}</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
