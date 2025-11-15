@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0">Kelas: {{ auth()->user()->kelas ?? '-' }}</p>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/backgrounds/rocket.png') }}" alt="" class="img-fluid mb-n4" style="max-width: 100px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-primary shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-book fs-8 text-primary"></i>
                        <p class="fw-semibold fs-3 text-primary mb-1">Total Materi</p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $totalMateri }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-warning shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-clipboard-list fs-8 text-warning"></i>
                        <p class="fw-semibold fs-3 text-warning mb-1">Total Kuis</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $totalKuis }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-success shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-check fs-8 text-success"></i>
                        <p class="fw-semibold fs-3 text-success mb-1">Kuis Dikerjakan</p>
                        <h5 class="fw-semibold text-success mb-0">{{ $kuisDikerjakan }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-star fs-8 text-info"></i>
                        <p class="fw-semibold fs-3 text-info mb-1">Rata-rata Nilai</p>
                        <h5 class="fw-semibold text-info mb-0">{{ number_format($rataRataNilai, 1) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Riwayat Kuis -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Riwayat Kuis Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kuis</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatKuis as $percobaan)
                                <tr>
                                    <td>{{ $percobaan->kuis->judul }}</td>
                                    <td>
                                        <span class="badge bg-{{ $percobaan->nilai >= 70 ? 'success' : 'danger' }}">
                                            {{ $percobaan->nilai ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($percobaan->lulus)
                                            <span class="badge bg-success">Lulus</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Lulus</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada riwayat kuis</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materi Terbaru -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Materi Terbaru</h5>
                    <div class="list-group">
                        @forelse($materiTerbaru as $materi)
                        <a href="{{ route('siswa.materi.show', $materi->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $materi->judul }}</h6>
                                <small>
                                    <span class="badge bg-{{ $materi->jenis_materi == 'vocabulary' ? 'primary' : 'info' }}">
                                        {{ ucfirst($materi->jenis_materi) }}
                                    </span>
                                </small>
                            </div>
                            <p class="mb-1 text-muted small">{{ Str::limit($materi->deskripsi, 100) }}</p>
                        </a>
                        @empty
                        <div class="text-center py-3">Belum ada materi</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
