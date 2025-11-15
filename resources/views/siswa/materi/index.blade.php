@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="container-fluid">
    <div class="card bg-light-primary shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-2">Materi Pembelajaran</h4>
            <p class="mb-0">Pilih materi yang ingin Anda pelajari</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('siswa.materi.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_materi" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="vocabulary" {{ request('jenis_materi') == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ request('jenis_materi') == 'grammar' ? 'selected' : '' }}>Grammar</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select">
                            <option value="12" {{ request('per_page') == '12' ? 'selected' : '' }}>12 per halaman</option>
                            <option value="24" {{ request('per_page') == '24' ? 'selected' : '' }}>24 per halaman</option>
                            <option value="48" {{ request('per_page') == '48' ? 'selected' : '' }}>48 per halaman</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i> Filter
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'jenis_materi']))
                    <div class="mt-2">
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-x"></i> Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($materiList as $materi)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-{{ $materi->jenis_materi == 'vocabulary' ? 'primary' : 'info' }} fs-2">
                                {{ $materi->jenis_materi == 'vocabulary' ? 'Vocabulary' : 'Grammar' }}
                            </span>
                            @if($materi->jenis_materi == 'vocabulary')
                                <span class="badge bg-success">{{ $materi->kosakata_count }} kata</span>
                            @endif
                        </div>
                        
                        <h5 class="card-title fw-semibold">{{ $materi->judul }}</h5>
                        
                        @if($materi->deskripsi)
                            <p class="card-text text-muted">{{ Str::limit($materi->deskripsi, 100) }}</p>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('siswa.materi.show', $materi->id) }}" class="btn btn-primary w-100">
                                <i class="ti ti-book-2"></i> Pelajari Materi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-book-off fs-10 text-muted"></i>
                        <h5 class="mt-3">Belum Ada Materi</h5>
                        <p class="text-muted">Materi pembelajaran belum tersedia</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $materiList->links() }}
    </div>
</div>

@push('styles')
<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection
