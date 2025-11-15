@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-success shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0">NIP: {{ auth()->user()->nomor_induk ?? '-' }}</p>
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
        <div class="col-lg-4">
            <div class="card border-0 zoom-in bg-light-primary shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-book fs-8 text-primary"></i>
                        <p class="fw-semibold fs-3 text-primary mb-1">Materi Saya</p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $totalMateri }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 zoom-in bg-light-warning shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-clipboard-list fs-8 text-warning"></i>
                        <p class="fw-semibold fs-3 text-warning mb-1">Kuis Saya</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $totalKuis }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-users fs-8 text-info"></i>
                        <p class="fw-semibold fs-3 text-info mb-1">Total Siswa</p>
                        <h5 class="fw-semibold text-info mb-0">{{ $totalSiswa }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kuis -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold">Statistik Kuis Terbaru</h5>
                        <a href="{{ route('guru.kuis.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul Kuis</th>
                                    <th>Tingkat</th>
                                    <th>Percobaan</th>
                                    <th>Rata-rata Nilai</th>
                                    <th>Ketuntasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kuisList as $kuis)
                                <tr>
                                    <td>{{ $kuis->judul }}</td>
                                    <td>
                                        <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($kuis->tingkat_kesulitan) }}
                                        </span>
                                    </td>
                                    <td>{{ $kuis->percobaan_count }}</td>
                                    <td>
                                        <span class="badge bg-{{ $kuis->rata_nilai >= 70 ? 'success' : 'danger' }}">
                                            {{ number_format($kuis->rata_nilai, 1) }}
                                        </span>
                                    </td>
                                    <td>{{ $kuis->tingkat_ketuntasan }} siswa</td>
                                    <td>
                                        @if($kuis->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada kuis</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Aksi Cepat</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('guru.materi.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="ti ti-plus"></i> Tambah Materi Baru
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('guru.kuis.create') }}" class="btn btn-warning w-100 py-3">
                                <i class="ti ti-plus"></i> Tambah Kuis Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
