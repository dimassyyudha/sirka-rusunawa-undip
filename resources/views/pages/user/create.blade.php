@extends('layouts.admin.app')

@section('content')
    {{-- Start Main Content --}}
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('user.store') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Tambah User</h1>
                <p class="mb-0">Form untuk menambahkan data user baru.</p>
            </div>
            <div>
                <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-info">
            {!! session('success') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info">
                            {!! session('info') !!}
                        </div>
                    @endif
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!--Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name') }}">
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role / Jabatan</label>
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Role --</option>
                                        <option value="admin">Administrator</option>
                                        <option value="staff">Staff Inventaris</option>
                                        <option value="kades">Kepala Desa (Monitoring)</option>
                                    </select>
                                </div>

                                <!-- profile_photo -->
                                <div class="mb-3">
                                    <label>Foto Profil</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" class="form-control" name="email"
                                        value="{{ old('email') }}">
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" id="password " class="form-control" name="password "
                                        value="{{ old('password ') }}">
                                </div>

                                <!--Password Confirmation -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Confirmation</label>
                                    <input type="text" id="password" class="form-control" name="password"
                                        value="{{ old('password') }}">
                                </div>

                                <!-- Buttons -->
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- End Main Content --}}
@endsection
