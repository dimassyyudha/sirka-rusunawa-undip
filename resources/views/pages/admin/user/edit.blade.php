@extends('layouts.app')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="#">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit User</h1>
                <p class="mb-0">Form untuk mengubah data User.</p>
            </div>
            <div>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- 1. BAGIAN PENTING: MENAMPILKAN ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('admin.user.update', $dataUser->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" class="form-control" required name="name"
                                    value="{{ old('name', $dataUser->name) }}">
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role / Jabatan</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="admin" {{ $dataUser->role == 'admin' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="staff" {{ $dataUser->role == 'staff' ? 'selected' : '' }}>Staff
                                        Inventaris</option>
                                    <option value="kades" {{ $dataUser->role == 'kades' ? 'selected' : '' }}>Kepala Desa
                                        (Monitoring)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Foto Profil</label><br>
                                @if ($dataUser->profile_photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('uploads/profile_pictures/' . $dataUser->profile_photo) }}"
                                            width="100" class="rounded-circle img-thumbnail"
                                            style="height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                                <input type="file" name="profile_photo" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto. (Max: 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" class="form-control" required name="email"
                                    value="{{ old('email', $dataUser->email) }}">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengganti password">
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
