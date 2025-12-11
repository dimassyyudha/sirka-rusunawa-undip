@extends('layouts.admin.app')
@section('title', 'Tambah Mutasi')

@section('content')
    <div class="page-heading">
        <h3>Catat Mutasi Aset</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('mutasi.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Pilih Aset</label>
                            <select name="aset_id" class="form-select" required>
                                <option value="">-- Pilih Aset --</option>
                                @foreach ($asets as $aset)
                                    <option value="{{ $aset->aset_id }}">{{ $aset->kode_aset }} - {{ $aset->nama_aset }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal Mutasi</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Jenis Mutasi</label>
                            <select name="jenis_mutasi" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                @php
                                    $jenisList = [
                                        'Pemindahan',
                                        'Penghapusan',
                                        'Perubahan Status',
                                        'Peminjaman',
                                        'Pengembalian',
                                    ];
                                @endphp
                                @foreach ($jenisList as $jenis)
                                    <option value="{{ $jenis }}"
                                        {{ old('jenis_mutasi') == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Keterangan / Alasan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail mutasi..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('mutasi.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
