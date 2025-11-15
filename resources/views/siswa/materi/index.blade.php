@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="learning-wrapper py-4">
    <div class="hero-banner rounded-4 p-4 p-lg-5 mb-4 text-white position-relative overflow-hidden">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase text-white-50 small mb-2">Materi Pembelajaran</p>
                <h2 class="fw-bold mb-3">Jelajahi materi Bahasa Inggris pilihan guru</h2>
                <p class="mb-0 text-white-75">Temukan materi vocabulary atau grammar yang siap dipelajari. Tersedia {{ $materiList->total() }} materi aktif untukmu.</p>
            </div>
            <div class="col-lg-5">
                <div class="hero-stat text-lg-end text-white-75">
                    <p class="small mb-1 text-uppercase">Materi aktif bulan ini</p>
                    <h1 class="display-4 fw-bolder mb-0 text-white">{{ $materiList->total() }}</h1>
                </div>
            </div>
        </div>
        <div class="hero-glow"></div>
    </div>

    <!-- Search & Filter -->
    <div class="card filter-card border-0 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('siswa.materi.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <label class="form-label small text-muted mb-1">Pencarian</label>
                        <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari materi, misal 'Simple Past Tense'..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Jenis Materi</label>
                        <select name="jenis_materi" class="form-select form-select-lg">
                            <option value="">Semua Jenis</option>
                            <option value="vocabulary" {{ request('jenis_materi') == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ request('jenis_materi') == 'grammar' ? 'selected' : '' }}>Grammar</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted mb-1">Per halaman</label>
                        <select name="per_page" class="form-select form-select-lg">
                            <option value="12" {{ request('per_page') == '12' ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == '24' ? 'selected' : '' }}>24</option>
                            <option value="48" {{ request('per_page') == '48' ? 'selected' : '' }}>48</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <label class="form-label small text-muted mb-1">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-search me-1"></i> Terapkan
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'jenis_materi', 'per_page']))
                    <div class="mt-3">
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-link text-decoration-none text-primary">
                            <i class="ti ti-refresh"></i> Reset filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($materiList as $materi)
            <div class="col-xl-4 col-md-6">
                <div class="course-card h-100">
                    <div class="course-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="course-chip {{ $materi->jenis_materi == 'vocabulary' ? 'chip-primary' : 'chip-info' }}">
                                {{ ucfirst($materi->jenis_materi) }}
                            </span>
                            @if($materi->jenis_materi == 'vocabulary')
                                <small class="text-muted">{{ $materi->kosakata_count }} kosakata</small>
                            @endif
                        </div>
                        <h5 class="fw-semibold mb-2">{{ $materi->judul }}</h5>
                        @if($materi->deskripsi)
                            <p class="text-muted mb-0">{{ Str::limit(strip_tags($materi->deskripsi), 120) }}</p>
                        @else
                            <p class="text-muted mb-0">Tidak ada deskripsi tambahan.</p>
                        @endif
                    </div>
                    <div class="course-card-footer">
                        <a href="{{ route('siswa.materi.show', $materi->id) }}" class="btn btn-outline-primary w-100">
                            Pelajari Materi
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <span class="empty-icon">
                        <i class="ti ti-book-off"></i>
                    </span>
                    <h5 class="mt-3">Belum ada materi</h5>
                    <p class="text-muted">Materi pembelajaran belum tersedia. Silakan cek kembali nanti.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $materiList->links() }}
    </div>
</div>

@push('styles')
<style>
    .learning-wrapper {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 28px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .hero-banner {
        background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.25), transparent 45%),
            linear-gradient(135deg, #2650f5, #51a0ff);
        color: #fff;
    }

    .hero-glow {
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        filter: blur(20px);
    }

    .filter-card {
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(73, 137, 255, 0.08);
    }

    .course-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 12px 35px rgba(15, 56, 107, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #eef2ff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .course-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 45px rgba(15, 56, 107, 0.12);
    }

    .course-card-body {
        padding: 1.75rem;
        flex: 1;
    }

    .course-card-footer {
        padding: 1.25rem 1.75rem 1.75rem;
    }

    .course-chip {
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .chip-primary {
        background: rgba(45, 150, 255, 0.15);
        color: #1d4ed8;
    }

    .chip-info {
        background: rgba(56, 189, 248, 0.15);
        color: #0f766e;
    }

    .empty-state {
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 15px 40px rgba(15, 56, 107, 0.08);
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(37, 99, 235, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #2563eb;
    }

    @media (max-width: 767.98px) {
        .hero-banner {
            text-align: center;
        }

        .hero-glow {
            display: none;
        }
    }
</style>
@endpush
@endsection
