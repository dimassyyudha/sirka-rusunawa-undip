@extends('layouts.admin.app')
@section('title', 'Kategori Aset')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets-admin/vendors/simple-datatables/style.css') }}">
@endpush

@section('content')
<div class="page-heading">
    <h3>Data Kategori Aset</h3>
    <p class="text-subtitle text-muted">Daftar kategori untuk pengelompokan aset.</p>
</div>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Kategori</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <table class="table table-striped" id="table1">
                <thead>
                    <tr><th>#</th><th>Kode</th><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $item->kategori_id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('kategori.destroy', $item->kategori_id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')" title="Hapus Data">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@push('scripts-bottom')
    <script src="{{ asset('assets-admin/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush