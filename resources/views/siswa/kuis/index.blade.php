@extends('layouts.app')

@section('title', 'Daftar Kuis')

@section('content')
<div class="container-fluid">
    <div class="card bg-light-warning shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-2">Daftar Kuis</h4>
            <p class="mb-0">Pilih kuis yang ingin Anda kerjakan</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('siswa.kuis.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari kuis..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="materi_id" class="form-select">
                            <option value="">Semua Materi</option>
                            @foreach($materiList as $materi)
                                <option value="{{ $materi->id }}" {{ request('materi_id') == $materi->id ? 'selected' : '' }}>
                                    {{ $materi->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tingkat_kesulitan" class="form-select">
                            <option value="">Semua Tingkat</option>
                            <option value="mudah" {{ request('tingkat_kesulitan') == 'mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="sedang" {{ request('tingkat_kesulitan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="sulit" {{ request('tingkat_kesulitan') == 'sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <select name="per_page" class="form-select">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i> Filter
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'materi_id', 'tingkat_kesulitan']))
                    <div class="mt-2">
                        <a href="{{ route('siswa.kuis.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-x"></i> Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($kuisList as $kuis)
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title fw-semibold">{{ $kuis->judul }}</h5>
                                @if($kuis->materi)
                                    <small class="text-muted">Materi: {{ $kuis->materi->judul }}</small>
                                @endif
                            </div>
                            <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                                {{ ucfirst($kuis->tingkat_kesulitan) }}
                            </span>
                        </div>

                        @if($kuis->deskripsi)
                            <p class="text-muted">{{ Str::limit($kuis->deskripsi, 100) }}</p>
                        @endif

                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <i class="ti ti-clipboard-list text-primary fs-6"></i>
                                <p class="mb-0 small">{{ $kuis->soal_count }} Soal</p>
                            </div>
                            <div class="col-4">
                                <i class="ti ti-clock text-info fs-6"></i>
                                <p class="mb-0 small">{{ $kuis->durasi_menit }} Menit</p>
                            </div>
                            <div class="col-4">
                                <i class="ti ti-target text-success fs-6"></i>
                                <p class="mb-0 small">Min. {{ $kuis->nilai_minimal }}</p>
                            </div>
                        </div>

                        @if($kuis->percobaan_siswa)
                            <div class="alert alert-info mb-3">
                                <small>
                                    <strong>Percobaan Terakhir:</strong><br>
                                    Nilai: <strong>{{ $kuis->percobaan_siswa->nilai }}</strong> | 
                                    Status: 
                                    @if($kuis->percobaan_siswa->lulus)
                                        <span class="badge bg-success">Lulus</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Lulus</span>
                                    @endif
                                </small>
                            </div>
                        @endif

                        <a href="{{ route('siswa.kuis.show', $kuis->id) }}" class="btn btn-primary w-100">
                            <i class="ti ti-pencil"></i> 
                            {{ $kuis->percobaan_siswa ? 'Lihat Detail & Coba Lagi' : 'Mulai Kuis' }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-clipboard-off fs-10 text-muted"></i>
                        <h5 class="mt-3">Belum Ada Kuis</h5>
                        <p class="text-muted">Kuis belum tersedia</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
