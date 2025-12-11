@extends('layouts.admin.app')
@section('title', 'Edit Mutasi')

@section('content')
    <div class="page-heading">
        <h3>Edit Data Mutasi</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('mutasi.update', $mutasi->mutasi_id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Aset</label>
                            <select name="aset_id" class="form-select" required>
                                @foreach ($asets as $aset)
                                    <option value="{{ $aset->aset_id }}"
                                        {{ $mutasi->aset_id == $aset->aset_id ? 'selected' : '' }}>
                                        {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ $mutasi->tanggal->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Jenis Mutasi</label>
                            <select name="jenis_mutasi" class="form-select" required>
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
                                        {{ old('jenis_mutasi', $mutasi->jenis_mutasi) == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $mutasi->keterangan }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('mutasi.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
