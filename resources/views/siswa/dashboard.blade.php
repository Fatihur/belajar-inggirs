@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="student-dashboard py-4">
    <div class="hero-card rounded-4 p-4 p-lg-5 mb-4 position-relative overflow-hidden">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase text-white-50 fw-semibold small mb-2">Selamat Datang Kembali</p>
                <h2 class="text-white fw-bolder mb-3">Halo, {{ auth()->user()->name }}!</h2>
                <p class="text-white-50 mb-4">Teruskan perjalanan belajar Bahasa Inggris-mu. Pantau materi, selesaikan kuis, dan lihat perkembangan nilaimu di sini.</p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="info-chip">
                        <span class="text-white-50 small d-block">Kelas</span>
                        <strong class="text-white">{{ auth()->user()->kelas ?? '-' }}</strong>
                    </div>
                    <div class="info-chip">
                        <span class="text-white-50 small d-block">Rata-rata Nilai</span>
                        <strong class="text-white">{{ number_format($rataRataNilai, 1) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end text-white-50">
                    <div>
                        <p class="mb-1 text-white-50 small">Total Materi</p>
                        <h3 class="text-white mb-0">{{ $totalMateri }}</h3>
                    </div>
                    <div>
                        <p class="mb-1 text-white-50 small">Total Kuis</p>
                        <h3 class="text-white mb-0">{{ $totalKuis }}</h3>
                    </div>
                    <div>
                        <p class="mb-1 text-white-50 small">Kuis Dikerjakan</p>
                        <h3 class="text-white mb-0">{{ $kuisDikerjakan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('assets/images/backgrounds/rocket.png') }}" alt="Rocket" class="hero-rocket">
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <span class="stat-icon bg-primary-subtle text-primary"><i class="ti ti-book"></i></span>
                <p class="mb-1 text-muted small">Materi Tersedia</p>
                <h4 class="mb-0">{{ $totalMateri }}</h4>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <span class="stat-icon bg-success-subtle text-success"><i class="ti ti-clipboard-list"></i></span>
                <p class="mb-1 text-muted small">Total Kuis</p>
                <h4 class="mb-0">{{ $totalKuis }}</h4>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <span class="stat-icon bg-warning-subtle text-warning"><i class="ti ti-check"></i></span>
                <p class="mb-1 text-muted small">Kuis Dikerjakan</p>
                <h4 class="mb-0">{{ $kuisDikerjakan }}</h4>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <span class="stat-icon bg-info-subtle text-info"><i class="ti ti-star"></i></span>
                <p class="mb-1 text-muted small">Rata-rata Nilai</p>
                <h4 class="mb-0">{{ number_format($rataRataNilai, 1) }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card modern-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Materi Terbaru</p>
                            <h5 class="fw-semibold mb-0">Lanjutkan pembelajaranmu</h5>
                        </div>
                        <a href="{{ route('siswa.materi.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                    </div>

                    <div class="materi-list">
                        @forelse($materiTerbaru as $materi)
                        <div class="materi-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="materi-pill {{ $materi->jenis_materi === 'vocabulary' ? 'pill-primary' : 'pill-info' }}">
                                    {{ ucfirst($materi->jenis_materi) }}
                                </span>
                                <small class="text-muted">{{ optional($materi->created_at)->format('d M Y') }}</small>
                            </div>
                            <h6 class="fw-semibold mb-2">{{ $materi->judul }}</h6>
                            <p class="text-muted small mb-3">{{ Str::limit($materi->deskripsi, 140) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Durasi fleksibel</span>
                                <a href="{{ route('siswa.materi.show', $materi->id) }}" class="btn btn-primary btn-sm">Buka Materi</a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">Belum ada materi terbaru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card modern-card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Riwayat Kuis</p>
                            <h5 class="fw-semibold mb-0">Aktivitas Terbaru</h5>
                        </div>
                        <a href="{{ route('siswa.kuis.index') }}" class="btn btn-link btn-sm text-decoration-none">Semua Kuis</a>
                    </div>
                    <div class="activity-list">
                        @forelse($riwayatKuis as $percobaan)
                        <div class="activity-item">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $percobaan->kuis->judul }}</h6>
                                <small class="text-muted">{{ optional($percobaan->created_at)->format('d M Y') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $percobaan->nilai >= 70 ? 'success' : 'danger' }}">
                                    {{ $percobaan->nilai ?? '-' }}
                                </span>
                                <span class="status-pill {{ $percobaan->lulus ? 'status-success' : 'status-danger' }}">
                                    {{ $percobaan->lulus ? 'Lulus' : 'Belum Lulus' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">Belum ada aktivitas kuis.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card modern-card">
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-1">Aksi Cepat</p>
                    <h5 class="fw-semibold mb-3">Mulai belajar hari ini</h5>
                    <div class="quick-actions">
                        <a href="{{ route('siswa.materi.index') }}" class="quick-action">
                            <span class="quick-icon bg-primary-subtle text-primary"><i class="ti ti-notes"></i></span>
                            <div>
                                <h6 class="mb-0 fw-semibold">Jelajahi Materi</h6>
                                <small class="text-muted">Baca materi terbaru dari guru</small>
                            </div>
                        </a>
                        <a href="{{ route('siswa.kuis.index') }}" class="quick-action">
                            <span class="quick-icon bg-success-subtle text-success"><i class="ti ti-target"></i></span>
                            <div>
                                <h6 class="mb-0 fw-semibold">Ikuti Kuis</h6>
                                <small class="text-muted">Uji kemampuanmu secara berkala</small>
                            </div>
                        </a>
                        <a href="{{ route('siswa.dashboard') }}" class="quick-action">
                            <span class="quick-icon bg-warning-subtle text-warning"><i class="ti ti-chart-infographic"></i></span>
                            <div>
                                <h6 class="mb-0 fw-semibold">Lihat Analitik</h6>
                                <small class="text-muted">Pantau perkembangan nilaimu</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .student-dashboard {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 32px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .hero-card {
        background: linear-gradient(135deg, #2952ff, #4aa7ff);
        min-height: 240px;
    }

    .hero-rocket {
        position: absolute;
        bottom: -10px;
        right: 40px;
        width: 150px;
        opacity: 0.8;
    }

    .info-chip {
        padding: 0.85rem 1.25rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(4px);
    }

    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(15, 56, 107, 0.08);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .modern-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 12px 40px rgba(15, 56, 107, 0.08);
    }

    .materi-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .materi-card {
        border: 1px solid #eef2ff;
        border-radius: 20px;
        padding: 1.5rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
        background: #fdfdff;
    }

    .materi-card:hover {
        transform: translateY(-4px);
        border-color: #bed9ff;
    }

    .materi-pill {
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .pill-primary {
        background: rgba(13, 110, 253, 0.15);
        color: #0d6efd;
    }

    .pill-info {
        background: rgba(56, 189, 248, 0.15);
        color: #0891b2;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f2f7;
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .status-pill {
        display: inline-block;
        padding: 0.3rem 0.85rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.4rem;
    }

    .status-success {
        background: rgba(34, 197, 94, 0.15);
        color: #15803d;
    }

    .status-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #b91c1c;
    }

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 18px;
        border: 1px solid #edf2ff;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .quick-action:hover {
        background: #f5f8ff;
        border-color: #cdddfc;
    }

    .quick-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    @media (max-width: 767.98px) {
        .hero-rocket {
            display: none;
        }

        .hero-card {
            text-align: center;
        }

        .info-chip {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush
