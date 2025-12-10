@extends('layouts.admin.app')
@section('title', 'Edit Lokasi Aset')

@section('content')
<div class="page-heading">
    <h3>Edit Lokasi Aset</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lokasi-aset.update', $lokasiAset->lokasi_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label>Pilih Aset</label>
                    <select name="aset_id" class="form-select" required>
                        @foreach ($aset as $item)
                            <option value="{{ $item->aset_id }}" {{ $lokasiAset->aset_id == $item->aset_id ? 'selected' : '' }}>
                                {{ $item->kode_aset }} - {{ $item->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Lokasi (Jalan/Gedung)</label>
                    <input type="text" name="lokasi_text" class="form-control" value="{{ $lokasiAset->lokasi_text }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ $lokasiAset->rt }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ $lokasiAset->rw }}" required>
                    </div>
                </div>

                {{-- PREVIEW FOTO --}}
                <div class="mb-3">
                    <label>Foto Saat Ini</label><br>
                    {{-- $media dikirim dari controller (sudah objek tunggal) --}}
                    @if($media)
                        <img src="{{ asset('uploads/lokasi/' . $media->file_name) }}" class="img-thumbnail mb-2" style="max-height: 200px">
                    @else
                        <p class="text-muted text-sm">Belum ada foto.</p>
                    @endif

                    <label class="d-block mt-2">Ganti Foto (media_file)</label>
                    <input type="file" name="media_file" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ $lokasiAset->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('lokasi-aset.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
