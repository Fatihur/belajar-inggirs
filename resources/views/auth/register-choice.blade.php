@extends('layouts.auth')

@section('title', 'Pilih Registrasi')

@section('content')
<div class="card mb-0">
    <div class="card-body">
        <h3 class="text-center fw-bold mb-2">Registrasi Akun</h3>
        <p class="text-center text-muted mb-4">Pilih jenis akun yang ingin didaftarkan</p>
        
        <div class="row g-3">
            <div class="col-12">
                <a href="{{ route('register.siswa') }}" class="btn btn-primary w-100 py-3 fs-4 rounded-2">
                    <i class="ti ti-user me-2"></i> Siswa
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('register.guru') }}" class="btn btn-success w-100 py-3 fs-4 rounded-2">
                    <i class="ti ti-school me-2"></i> Guru
                </a>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center mt-4">
            <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
            <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection
