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
                    <div class="col-md-6 mb-3">
                        <label>Pilih Aset</label>
                        <select name="aset_id" class="form-select" required>
                            <option value="">-- Pilih Aset --</option>
                            @foreach ($asets as $aset)
                                <option value="{{ $aset->aset_id }}">{{ $aset->kode_aset }} - {{ $aset->nama_aset }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Pengerjaan</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Biaya (Rp)</label>
                        <input type="number" name="biaya" class="form-control" required placeholder="Contoh: 150000">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Pelaksana / Teknisi</label>
                        <input type="text" name="pelaksana" class="form-control" required placeholder="Nama Vendor / Teknisi">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Tindakan Perbaikan</label>
                        <textarea name="tindakan" class="form-control" rows="3" required placeholder="Jelaskan detail perbaikan..."></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Bukti Pemeliharaan (Bisa Pilih Banyak)</label>
                        <input type="file" name="bukti[]" class="form-control" multiple accept="image/*,.pdf">
                        <small class="text-muted">Tekan CTRL saat memilih file untuk upload lebih dari satu.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pemeliharaan.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
