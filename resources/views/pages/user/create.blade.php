@extends('layouts.admin.app')
@section('title', 'Tambah User')

@section('content')
<div class="page-heading">
    <h3>Tambah User Baru</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- KIRI --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff Inventaris</option>
                                <option value="kades">Kepala Desa</option>
                            </select>
                        </div>
                    </div>

                    {{-- KANAN --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label>Foto Profil</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('user.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection