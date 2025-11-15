@extends('layouts.app')

@section('title', $kuis->judul)

@section('content')
<div class="container-fluid">
    <!-- Info Kuis -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="fw-semibold">{{ $kuis->judul }}</h4>
                    <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                        {{ ucfirst($kuis->tingkat_kesulitan) }}
                    </span>
                    @if($kuis->materi)
                        <span class="badge bg-info">{{ $kuis->materi->judul }}</span>
                    @endif
                </div>
                <a href="{{ route('siswa.kuis.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

            @if($kuis->deskripsi)
                <div class="mt-3 mb-0 content-html">{!! $kuis->deskripsi !!}</div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Informasi Kuis -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Informasi Kuis</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="ti ti-clipboard-list text-primary"></i>
                            <strong>Jumlah Soal:</strong> {{ $kuis->soal->count() }} soal
                        </li>
                        <li class="mb-3">
                            <i class="ti ti-clock text-info"></i>
                            <strong>Durasi:</strong> {{ $kuis->durasi_menit }} menit
                        </li>
                        <li class="mb-3">
                            <i class="ti ti-target text-success"></i>
                            <strong>Nilai Minimal:</strong> {{ $kuis->nilai_minimal }}
                        </li>
                        <li class="mb-3">
                            <i class="ti ti-{{ $kuis->acak_soal ? 'check' : 'x' }} text-warning"></i>
                            <strong>Soal:</strong> {{ $kuis->acak_soal ? 'Diacak' : 'Berurutan' }}
                        </li>
                    </ul>

                    @if(!$percobaanAktif)
                        <form action="{{ route('siswa.kuis.mulai', $kuis->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="ti ti-player-play"></i> Mulai Kuis
                            </button>
                        </form>
                    @else
                        <a href="{{ route('siswa.kuis.mengerjakan', $percobaanAktif->id) }}" class="btn btn-warning w-100 btn-lg">
                            <i class="ti ti-pencil"></i> Lanjutkan Mengerjakan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Riwayat Percobaan -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Riwayat Percobaan</h5>
                    @forelse($riwayatPercobaan as $percobaan)
                        <div class="card mb-2 border">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">{{ $percobaan->created_at->format('d M Y, H:i') }}</small>
                                        <h6 class="mb-1">Nilai: <strong>{{ $percobaan->nilai }}</strong></h6>
                                        <small>
                                            Benar: {{ $percobaan->jumlah_benar }} | 
                                            Salah: {{ $percobaan->jumlah_salah }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        @if($percobaan->lulus)
                                            <span class="badge bg-success">Lulus</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Lulus</span>
                                        @endif
                                        <br>
                                        <a href="{{ route('siswa.kuis.hasil', $percobaan->id) }}" class="btn btn-sm btn-info mt-2">
                                            <i class="ti ti-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Belum ada percobaan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
