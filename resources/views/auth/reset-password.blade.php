@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="card mb-0">
    <div class="card-body p-4">
        <h3 class="text-center fw-bold mb-2">Reset Password</h3>
        <p class="text-center text-muted mb-4">Masukkan password baru Anda</p>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label for="email_display" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_display" value="{{ $email }}" disabled>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Minimal 8 karakter</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fs-5 mb-3 rounded-2">
                Reset Password
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
