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
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'eyeIcon1')">
                        <i class="ti ti-eye" id="eyeIcon1"></i>
                    </button>
                </div>
                <small class="text-muted">Minimal 8 karakter</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                        <i class="ti ti-eye" id="eyeIcon2"></i>
                    </button>
                </div>
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

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    } else {
        input.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    }
}
</script>
@endpush
@endsection
