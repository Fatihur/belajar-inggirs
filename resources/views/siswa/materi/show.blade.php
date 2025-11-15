@extends('layouts.app')

@section('title', $materi->judul)

@section('content')
<div class="learning-wrapper py-4">
    <div class="hero-banner rounded-4 p-4 p-lg-5 mb-4 text-white position-relative overflow-hidden">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
            <div>
                <span class="course-chip {{ $materi->jenis_materi == 'vocabulary' ? 'chip-primary' : 'chip-info' }} mb-3">
                    {{ ucfirst($materi->jenis_materi) }}
                </span>
                <h2 class="fw-bold mb-3">{{ $materi->judul }}</h2>
                @if($materi->deskripsi)
                    <div class="text-white-75 content-html mb-3">{!! $materi->deskripsi !!}</div>
                @endif
                <div class="d-flex flex-wrap gap-3">
                    <div class="info-chip text-white">
                        <small class="text-white-50 d-block">Diperbarui</small>
                        <strong>{{ optional($materi->updated_at)->format('d M Y') }}</strong>
                    </div>
                    <div class="info-chip text-white">
                        <small class="text-white-50 d-block">Jenis</small>
                        <strong>{{ ucfirst($materi->jenis_materi) }}</strong>
                    </div>
                    @if($materi->jenis_materi == 'vocabulary')
                        <div class="info-chip text-white">
                            <small class="text-white-50 d-block">Kosakata</small>
                            <strong>{{ $materi->kosakata->count() }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="align-self-start">
                <a href="{{ route('siswa.materi.index') }}" class="btn btn-light text-primary">
                    <i class="ti ti-arrow-left"></i> Kembali ke daftar materi
                </a>
            </div>
        </div>
        <div class="hero-glow"></div>
    </div>

    @if($materi->jenis_materi == 'grammar')
        @if($materi->konten)
            <div class="card modern-card mb-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="section-heading d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Materi inti</p>
                            <h4 class="fw-semibold mb-0">Penjelasan Materi</h4>
                        </div>
                    </div>
                    <div class="content-text content-html">
                        {!! $materi->konten !!}
                    </div>
                </div>
            </div>
        @endif

        @if($materi->video_url || $materi->video_path)
            <div class="card modern-card mb-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="section-heading mb-4">
                        <p class="text-uppercase text-muted small mb-1">Video Pembelajaran</p>
                        <h4 class="fw-semibold mb-0">Simak materi lewat video</h4>
                    </div>
                    @if($materi->video_url)
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                            <iframe src="{{ video_embed_url($materi->video_url) }}"
                                    allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    frameborder="0"></iframe>
                        </div>
                    @elseif($materi->video_path)
                        <video controls class="w-100 rounded-4 shadow-sm">
                            <source src="{{ asset('storage/' . $materi->video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="card modern-card">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <p class="text-uppercase text-muted small mb-1">Kosakata</p>
                        <h4 class="fw-semibold mb-0">Daftar Kosakata ({{ $materi->kosakata->count() }})</h4>
                    </div>
                    <span class="badge bg-primary-subtle text-primary">Vocabulary Focus</span>
                </div>

                @forelse($materi->kosakata as $kata)
                    <div class="vocab-card">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <h5 class="mb-1 text-primary">{{ $kata->kata_inggris }}</h5>
                                <p class="text-muted mb-1">{{ $kata->kata_indonesia }}</p>
                                @if($kata->jenis_kata)
                                    <span class="badge bg-light text-dark border">{{ $kata->jenis_kata }}</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if($kata->contoh_kalimat)
                                    <small class="text-muted d-block">
                                        <strong>Contoh kalimat:</strong>
                                    </small>
                                    <blockquote class="mb-0 text-muted fst-italic">
                                        {{ $kata->contoh_kalimat }}
                                    </blockquote>
                                @endif
                            </div>
                            <div class="col-md-4 text-md-end">
                                @if($kata->audio_path)
                                    <audio controls class="w-100 mb-2">
                                        <source src="{{ asset('storage/' . $kata->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                @endif
                                @if($kata->gambar_path)
                                    <img src="{{ asset('storage/' . $kata->gambar_path) }}"
                                         alt="{{ $kata->kata_inggris }}"
                                         class="img-fluid rounded-3 shadow-sm vocab-image"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModal{{ $kata->id }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($kata->gambar_path)
                        <div class="modal fade" id="imageModal{{ $kata->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $kata->kata_inggris }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $kata->gambar_path) }}"
                                             alt="{{ $kata->kata_inggris }}"
                                             class="img-fluid rounded-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-muted py-4">
                        Belum ada kosakata dalam materi ini.
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .learning-wrapper {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 28px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .hero-banner {
        background: linear-gradient(135deg, #1d4ed8, #60a5fa);
        color: #fff;
    }

    .hero-glow {
        position: absolute;
        inset: auto 20px 20px auto;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        filter: blur(30px);
    }

    .info-chip {
        padding: 0.85rem 1.3rem;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(4px);
    }

    .modern-card {
        border: none;
        border-radius: 28px;
        box-shadow: 0 18px 45px rgba(15, 56, 107, 0.08);
    }

    .course-chip {
        padding: 0.2rem 0.95rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .chip-primary {
        background: rgba(45, 150, 255, 0.2);
        color: #e0f2ff;
    }

    .chip-info {
        background: rgba(56, 189, 248, 0.2);
        color: #ecfeff;
    }

    .content-text {
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .vocab-card {
        border: 1px solid #eef2ff;
        border-radius: 24px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        background: #fffdfa;
    }

    .vocab-image {
        max-width: 180px;
        cursor: pointer;
    }

    @media (max-width: 767.98px) {
        .hero-banner {
            text-align: center;
        }

        .info-chip {
            width: 100%;
        }
    }
</style>
@endpush
@endsection
