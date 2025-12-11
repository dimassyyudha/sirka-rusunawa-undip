@extends('layouts.admin.app')
@section('title', 'Catat Pemeliharaan')

@section('content')
<div class="page-heading">
    <h3>Catat Pemeliharaan Baru</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pemeliharaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Pilih Aset</label>
                            <select name="aset_id" class="form-select" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach ($asets as $aset)
                                    <option value="{{ $aset->aset_id }}">{{ $aset->kode_aset }} - {{ $aset->nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Pengerjaan</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Biaya (Rp)</label>
                            <input type="number" name="biaya" class="form-control" required placeholder="0">
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Pelaksana / Teknisi</label>
                            <input type="text" name="pelaksana" class="form-control" required placeholder="Nama Vendor / Teknisi">
                        </div>
                        <div class="mb-3">
                            <label>Bukti Pemeliharaan (Upload Banyak)</label>
                            <input type="file" name="bukti[]" class="form-control" multiple accept="image/*,.pdf">
                            <small class="text-muted d-block mt-1">Gunakan CTRL untuk memilih lebih dari 1 file.</small>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Tindakan Perbaikan</label>
                        <textarea name="tindakan" class="form-control" rows="2" required placeholder="Jelaskan perbaikan..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection