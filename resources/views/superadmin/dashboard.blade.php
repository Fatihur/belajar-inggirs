@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-light-danger shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Dashboard Super Admin</h4>
                    <p class="mb-0">Selamat Datang, {{ auth()->user()->name }}!</p>
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
                        <i class="ti ti-users fs-8 text-primary"></i>
                        <p class="fw-semibold fs-3 text-primary mb-1">Total Guru</p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $totalGuru }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-success shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-school fs-8 text-success"></i>
                        <p class="fw-semibold fs-3 text-success mb-1">Total Siswa</p>
                        <h5 class="fw-semibold text-success mb-0">{{ $totalSiswa }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-warning shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-book fs-8 text-warning"></i>
                        <p class="fw-semibold fs-3 text-warning mb-1">Total Materi</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $totalMateri }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-clipboard-list fs-8 text-info"></i>
                        <p class="fw-semibold fs-3 text-info mb-1">Total Kuis</p>
                        <h5 class="fw-semibold text-info mb-0">{{ $totalKuis }}</h5>
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
                    <h5 class="card-title fw-semibold mb-4">Manajemen Pengguna</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('superadmin.guru.index') }}" class="btn btn-primary w-100 py-3">
                                <i class="ti ti-users"></i> Kelola Guru
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('superadmin.siswa.index') }}" class="btn btn-success w-100 py-3">
                                <i class="ti ti-school"></i> Kelola Siswa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Informasi Sistem</h5>
                    <p class="mb-2"><strong>Aplikasi:</strong> Media Pembelajaran Interaktif Bahasa Inggris</p>
                    <p class="mb-2"><strong>Versi:</strong> 1.0.0</p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
