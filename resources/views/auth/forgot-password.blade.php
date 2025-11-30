@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="card mb-0">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <div class="bg-light-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                <i class="ti ti-lock-question fs-4 text-primary"></i>
            </div>
            <h3 class="fw-bold mb-2">Lupa Password?</h3>
            <p class="text-muted">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fs-5 mb-3 rounded-2">
                <i class="ti ti-send me-2"></i>Kirim Link Reset
            </button>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-muted">
                    <i class="ti ti-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
