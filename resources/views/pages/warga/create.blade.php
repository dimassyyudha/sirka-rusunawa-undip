@extends('layouts.admin.app')

@section('title', 'Tambah Warga Baru')

@section('content')
<div class="page-heading">
    <h3>Tambah Warga Baru</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- KOLOM KIRI: Identitas Utama --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}" placeholder="16 digit NIK" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Sesuai KTP" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select" required>
                                <option value="">-- Pilih Agama --</option>
                                @php
                                    $listAgama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                                @endphp
                                @foreach($listAgama as $agm)
                                    <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Kontak & Pekerjaan --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" placeholder="Contoh: Wiraswasta" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon (Opsional)</label>
                            <input type="text" name="telp" class="form-control" value="{{ old('telp') }}" placeholder="08xx...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email (Opsional)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@contoh.com">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('warga.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection