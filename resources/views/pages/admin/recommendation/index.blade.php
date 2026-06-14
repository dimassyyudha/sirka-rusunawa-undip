@extends('layouts.app')
@section('title', 'Rekomendasi Kamar')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Rekomendasi Kamar</h3>
                    <p class="text-subtitle text-muted">Kelola daftar kamar rekomendasi yang tampil di landing page.</p>
                </div>

                <div class="col-12 col-md-6 text-md-end">
                    <a href="{{ route('admin.settings.recommendation.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Rekomendasi
                    </a>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th width="80">Urut</th>
                                    <th>Kamar</th>
                                    <th>Gedung</th>
                                    <th>Lantai</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th width="120">Aktif</th>
                                    <th width="220">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($items as $it)
                                    @php
                                        $room = $it->room;
                                        $floor = $room?->floor;
                                        $building = $floor?->building;

                                        $gedungLabel = $building
                                            ? str_replace('Gedung ', '', $building->name)
                                            : '-';

                                        $lantai = $floor?->floor_number ?? '-';
                                        $harga = (int) ($floor?->monthly_price ?? 0);
                                    @endphp

                                    <tr>
                                        <td class="fw-bold">{{ $it->sort_order }}</td>
                                        <td class="fw-bold">{{ $room->kode_kamar ?? '-' }}</td>
                                        <td>{{ $gedungLabel }}</td>
                                        <td>{{ $lantai }}</td>
                                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>

                                        <td>
                                            @if (!$room)
                                                <span class="badge bg-secondary">Room hilang</span>
                                            @else
                                                <span class="badge bg-light text-dark border">
                                                    {{ $room->status }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($it->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.settings.recommendation.edit', $it->id) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <form action="{{ route('admin.settings.recommendation.destroy', $it->id) }}"
                                                  method="POST"
                                                  class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Belum ada rekomendasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection