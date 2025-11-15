@extends('layouts.app')

@section('title', 'Daftar Kuis')

@section('content')
<div class="quiz-wrapper py-4">
    <div class="hero-banner rounded-4 p-4 p-lg-5 mb-4 text-white position-relative overflow-hidden">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase text-white-50 small mb-2">Kumpulan Kuis</p>
                <h2 class="fw-bold mb-3">Uji kemampuanmu dengan kuis daring</h2>
                <p class="mb-0 text-white-75">Pilih kuis sesuai materi atau tingkat kesulitan. Raih nilai terbaik dan pantau progres belajarmu.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="hero-stat">
                    <p class="small text-white-50 text-uppercase mb-1">Kuis Aktif</p>
                    <h1 class="display-4 fw-bolder text-white mb-0">{{ $kuisList->total() }}</h1>
                </div>
            </div>
        </div>
        <div class="hero-glow"></div>
    </div>

    <div class="card filter-card border-0 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('siswa.kuis.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Pencarian</label>
                        <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari kuis, misal 'Tenses'" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Materi</label>
                        <select name="materi_id" class="form-select form-select-lg">
                            <option value="">Semua Materi</option>
                            @foreach($materiList as $materi)
                                <option value="{{ $materi->id }}" {{ request('materi_id') == $materi->id ? 'selected' : '' }}>
                                    {{ $materi->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Tingkat</label>
                        <select name="tingkat_kesulitan" class="form-select form-select-lg">
                            <option value="">Semua</option>
                            <option value="mudah" {{ request('tingkat_kesulitan') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="sedang" {{ request('tingkat_kesulitan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="sulit" {{ request('tingkat_kesulitan') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label small text-muted">Per Hal</label>
                        <select name="per_page" class="form-select form-select-lg">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-filter me-1"></i> Terapkan
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'materi_id', 'tingkat_kesulitan']))
                    <div class="mt-3">
                        <a href="{{ route('siswa.kuis.index') }}" class="btn btn-link text-decoration-none text-primary">
                            <i class="ti ti-refresh"></i> Reset filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($kuisList as $kuis)
            <div class="col-lg-6">
                <div class="quiz-card h-100">
                    <div class="quiz-card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $kuis->judul }}</h5>
                                @if($kuis->materi)
                                    <small class="text-muted">Materi: {{ $kuis->materi->judul }}</small>
                                @endif
                            </div>
                            <span class="level-chip {{ $kuis->tingkat_kesulitan }}">
                                {{ ucfirst($kuis->tingkat_kesulitan) }}
                            </span>
                        </div>

                        @if($kuis->deskripsi)
                            <p class="text-muted mb-3">{{ Str::limit($kuis->deskripsi, 120) }}</p>
                        @endif

                        <div class="quiz-meta mb-3">
                            <div>
                                <span class="icon-circle text-primary"><i class="ti ti-clipboard-list"></i></span>
                                <small>{{ $kuis->soal_count }} Soal</small>
                            </div>
                            <div>
                                <span class="icon-circle text-info"><i class="ti ti-clock"></i></span>
                                <small>{{ $kuis->durasi_menit }} Menit</small>
                            </div>
                            <div>
                                <span class="icon-circle text-success"><i class="ti ti-target-arrow"></i></span>
                                <small>Min. {{ $kuis->nilai_minimal }}</small>
                            </div>
                        </div>

                        @if($kuis->percobaan_siswa)
                            <div class="attempt-card mb-3">
                                <div>
                                    <small class="text-muted d-block">Percobaan terakhir</small>
                                    <span class="fw-semibold">Nilai {{ $kuis->percobaan_siswa->nilai }}</span>
                                </div>
                                <span class="status-pill {{ $kuis->percobaan_siswa->lulus ? 'status-success' : 'status-danger' }}">
                                    {{ $kuis->percobaan_siswa->lulus ? 'Lulus' : 'Belum Lulus' }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="quiz-card-footer">
                        <a href="{{ route('siswa.kuis.show', $kuis->id) }}" class="btn btn-outline-primary w-100">
                            {{ $kuis->percobaan_siswa ? 'Lihat Detail & Coba Lagi' : 'Mulai Kuis' }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <span class="empty-icon">
                        <i class="ti ti-clipboard-off"></i>
                    </span>
                    <h5 class="mt-3">Belum ada kuis</h5>
                    <p class="text-muted">Kuis belum tersedia. Coba kembali beberapa saat lagi.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .quiz-wrapper {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 28px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .hero-banner {
        background: linear-gradient(135deg, #ff8f5a, #ffb347);
    }

    .hero-glow {
        position: absolute;
        bottom: -30px;
        right: 40px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        filter: blur(20px);
    }

    .filter-card {
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(255, 165, 105, 0.12);
    }

    .quiz-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #ffe3d0;
        box-shadow: 0 15px 40px rgba(255, 149, 90, 0.15);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s ease;
    }

    .quiz-card:hover {
        transform: translateY(-6px);
    }

    .quiz-card-body {
        padding: 1.75rem;
        flex: 1;
    }

    .quiz-card-footer {
        padding: 1.25rem 1.75rem 1.75rem;
    }

    .quiz-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .icon-circle {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.05);
        margin-right: 0.35rem;
    }

    .level-chip {
        padding: 0.3rem 1rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .level-chip.mudah {
        background: rgba(16, 185, 129, 0.15);
        color: #047857;
    }

    .level-chip.sedang {
        background: rgba(245, 158, 11, 0.15);
        color: #b45309;
    }

    .level-chip.sulit {
        background: rgba(248, 113, 113, 0.2);
        color: #b91c1c;
    }

    .attempt-card {
        border: 1px dashed #ffe3d0;
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-pill {
        padding: 0.35rem 0.9rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-success {
        background: rgba(16, 185, 129, 0.15);
        color: #047857;
    }

    .status-danger {
        background: rgba(248, 113, 113, 0.15);
        color: #b91c1c;
    }

    .empty-state {
        border-radius: 28px;
        background: #fff7f1;
        border: 1px solid #ffe1cf;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255, 149, 90, 0.15);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #ff7b54;
    }

    @media (max-width: 767.98px) {
        .hero-banner {
            text-align: center;
        }
    }
</style>
@endpush
@endsection
