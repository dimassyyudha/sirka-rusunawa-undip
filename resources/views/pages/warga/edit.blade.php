@extends('layouts.admin.app')

@section('title', 'Edit Warga')

@section('content')
<div class="page-heading">
    <h3>Edit Data Warga</h3>
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

            <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- KOLOM KIRI --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp', $warga->no_ktp) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $warga->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                    <option value="{{ $agm }}"
                                        {{ (old('agama', $warga->agama) == $agm) ? 'selected' : '' }}>
                                        {{ $agm }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $warga->pekerjaan) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telp" class="form-control" value="{{ old('telp', $warga->telp) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $warga->email) }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('warga.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection