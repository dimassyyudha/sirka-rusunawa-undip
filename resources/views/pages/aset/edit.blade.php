@extends('layouts.admin.app')

@section('title', 'Edit Lokasi Aset')

@section('content')
<div class="page-heading">
    <h3>Edit Lokasi Aset</h3>
</div>
<div class="page-content">

    {{-- BAGIAN INI YANG HILANG: Menampilkan Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan!</h4>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('lokasi-aset.update', $lokasiAset->lokasi_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Pilih Aset</label>
                    <select name="aset_id" class="form-select" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach ($aset as $item)
                            <option value="{{ $item->aset_id }}"
                                {{ (old('aset_id', $lokasiAset->aset_id) == $item->aset_id) ? 'selected' : '' }}>
                                {{ $item->kode_aset }} - {{ $item->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Lokasi (Jalan/Gedung)</label>
                    {{-- Tambahkan old() agar input tidak hilang saat error --}}
                    <input type="text" name="lokasi_text" class="form-control"
                           value="{{ old('lokasi_text', $lokasiAset->lokasi_text) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control"
                               value="{{ old('rt', $lokasiAset->rt) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control"
                               value="{{ old('rw', $lokasiAset->rw) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Foto Saat Ini</label><br>
                    @if($media)
                        <img src="{{ asset('uploads/lokasi/' . $media->file_name) }}"
                             class="img-thumbnail mb-2" style="max-height: 200px">
                    @else
                        <p class="text-muted text-sm fst-italic">Belum ada foto.</p>
                    @endif

                    <label class="d-block mt-2">Ganti Foto (media_file)</label>
                    <input type="file" name="media_file" class="form-control @error('media_file') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. (Maks: 4MB)</small>

                    {{-- Error spesifik di bawah input --}}
                    @error('media_file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $lokasiAset->keterangan) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('lokasi-aset.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
