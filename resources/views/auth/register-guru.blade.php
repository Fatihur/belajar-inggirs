@extends('layouts.auth')

@section('title', 'Registrasi Guru')

@section('col-class', 'col-md-10 col-lg-8 col-xl-6')

@section('content')
<div class="card mb-0">
    <div class="card-body p-4">
        <h3 class="text-center fw-bold mb-2">Registrasi Guru</h3>
        <p class="text-center text-muted mb-4">Lengkapi data berikut untuk membuat akun guru</p>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.guru.post') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="nip" class="form-label">NIP / NUPTK<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="kelas_mengajar" class="form-label">Kelas Mengajar <span class="text-danger">*</span></label>
                    <select class="form-select" id="kelas_mengajar" name="kelas_mengajar" required>
                        <option value="">Pilih Kelas</option>
                        <option value="7" {{ old('kelas_mengajar') == '7' ? 'selected' : '' }}>Kelas 7</option>
                        <option value="8" {{ old('kelas_mengajar') == '8' ? 'selected' : '' }}>Kelas 8</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                    <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                        <option value="">Pilih</option>
                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bidang_studi" class="form-label">Bidang Studi</label>
                    <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" value="{{ old('bidang_studi') }}" placeholder="Bahasa Inggris">
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fs-5 mb-3 rounded-2">Daftar</button>
            
            <div class="d-flex align-items-center justify-content-center">
                <p class="mb-0">Sudah punya akun?</p>
                <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
                <span class="mx-2">|</span>
                <a href="{{ route('register') }}" class="text-muted">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
