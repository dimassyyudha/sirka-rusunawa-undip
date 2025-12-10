@extends('layouts.admin.app')
@section('title', 'Edit Pemeliharaan')

@section('content')
    <div class="page-heading">
        <h3>Edit Data Pemeliharaan</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pemeliharaan.update', $pemeliharaan->pemeliharaan_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Aset</label>
                            <select name="aset_id" class="form-select" required>
                                @foreach ($asets as $aset)
                                    <option value="{{ $aset->aset_id }}"
                                        {{ $pemeliharaan->aset_id == $aset->aset_id ? 'selected' : '' }}>
                                        {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ $pemeliharaan->tanggal->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Biaya</label>
                            <input type="number" name="biaya" class="form-control" value="{{ $pemeliharaan->biaya }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Pelaksana</label>
                            <input type="text" name="pelaksana" class="form-control"
                                value="{{ $pemeliharaan->pelaksana }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Tindakan</label>
                            <textarea name="tindakan" class="form-control" rows="3">{{ $pemeliharaan->tindakan }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Bukti Tersimpan ({{ $pemeliharaan->bukti->count() }})</label>
                            <div class="row g-2 mt-2">
                                @foreach ($pemeliharaan->bukti as $file)
                                    <div class="col-2 text-center">
                                        <img src="{{ asset('uploads/pemeliharaan/' . $file->file_name) }}"
                                            class="img-thumbnail" style="height: 80px; object-fit: cover">

                                        {{-- PERBAIKAN DI SINI: Gunakan 'id' atau 'media_id' --}}
                                        @php
                                            // Deteksi ID yang tersedia (id atau media_id)
                                            $mediaId = $file->id ?? $file->media_id;
                                        @endphp

                                        @if ($mediaId)
                                            <a href="{{ route('pemeliharaan.delete-bukti', $mediaId) }}"
                                                class="btn btn-danger btn-sm mt-1"
                                                onclick="return confirm('Hapus file ini?')">Hapus</a>
                                        @else
                                            <button class="btn btn-secondary btn-sm mt-1" disabled>Error ID</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Tambah Bukti Baru (Opsional)</label>
                            <input type="file" name="bukti[]" class="form-control" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
