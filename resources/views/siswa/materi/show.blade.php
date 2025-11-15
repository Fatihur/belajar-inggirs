@extends('layouts.app')

@section('title', $materi->judul)

@section('content')
<div class="container-fluid">
    <!-- Header Materi -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge bg-{{ $materi->jenis_materi == 'vocabulary' ? 'primary' : 'info' }} mb-2">
                        {{ $materi->jenis_materi == 'vocabulary' ? 'Vocabulary' : 'Grammar' }}
                    </span>
                    <h4 class="fw-semibold">{{ $materi->judul }}</h4>
                    @if($materi->deskripsi)
                        <div class="text-muted content-html">
                            {!! $materi->deskripsi !!}
                        </div>
                    @endif
                </div>
                <a href="{{ route('siswa.materi.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if($materi->jenis_materi == 'grammar')
        <!-- Konten Grammar -->
        @if($materi->konten)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Penjelasan Materi</h5>
                    <div class="content-text content-html">
                        {!! $materi->konten !!}
                    </div>
                </div>
            </div>
        @endif

        <!-- Video Pembelajaran -->
        @if($materi->video_url || $materi->video_path)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Video Pembelajaran</h5>
                    @if($materi->video_url)
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ video_embed_url($materi->video_url) }}" 
                                    allowfullscreen 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    frameborder="0"></iframe>
                        </div>
                    @elseif($materi->video_path)
                        <video controls class="w-100">
                            <source src="{{ asset('storage/' . $materi->video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @endif
                </div>
            </div>
        @endif

    @else
        <!-- Daftar Vocabulary -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Daftar Kosakata ({{ $materi->kosakata->count() }})</h5>
                
                @forelse($materi->kosakata as $index => $kata)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6 class="fw-bold text-primary mb-1">{{ $kata->kata_inggris }}</h6>
                                    <p class="text-muted mb-2">{{ $kata->kata_indonesia }}</p>
                                    @if($kata->jenis_kata)
                                        <span class="badge bg-secondary">{{ $kata->jenis_kata }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if($kata->contoh_kalimat)
                                        <small class="text-muted">
                                            <strong>Contoh:</strong><br>
                                            <em>{{ $kata->contoh_kalimat }}</em>
                                        </small>
                                    @endif
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($kata->audio_path)
                                        <audio controls class="w-100 mb-2">
                                            <source src="{{ asset('storage/' . $kata->audio_path) }}" type="audio/mpeg">
                                        </audio>
                                    @endif
                                    @if($kata->gambar_path)
                                        <img src="{{ asset('storage/' . $kata->gambar_path) }}" 
                                             alt="{{ $kata->kata_inggris }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 150px; cursor: pointer;"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#imageModal{{ $kata->id }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Gambar -->
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
                                             class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Belum ada kosakata dalam materi ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.content-text {
    line-height: 1.8;
    font-size: 1.05rem;
}
</style>
@endpush
@endsection
