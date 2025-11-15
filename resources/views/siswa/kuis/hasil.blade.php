@extends('layouts.app')

@section('title', 'Hasil Kuis')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Hasil Nilai -->
    <div class="card mb-4 {{ $percobaan->lulus ? 'bg-light-success' : 'bg-light-danger' }}">
        <div class="card-body text-center py-5">
            <h2 class="fw-bold mb-3">{{ $kuis->judul }}</h2>
            
            <div class="display-1 fw-bold {{ $percobaan->lulus ? 'text-success' : 'text-danger' }}">
                {{ $percobaan->nilai }}
            </div>
            <p class="fs-4 mb-4">Nilai Anda</p>

            @if($percobaan->lulus)
                <div class="alert alert-success d-inline-block">
                    <i class="ti ti-check-circle fs-6"></i>
                    <strong>Selamat! Anda LULUS</strong>
                </div>
            @else
                <div class="alert alert-danger d-inline-block">
                    <i class="ti ti-x-circle fs-6"></i>
                    <strong>Anda TIDAK LULUS</strong>
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-md-4">
                    <h5 class="fw-semibold">{{ $percobaan->jumlah_benar }}</h5>
                    <p class="text-muted">Jawaban Benar</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-semibold">{{ $percobaan->jumlah_salah }}</h5>
                    <p class="text-muted">Jawaban Salah</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-semibold">{{ $percobaan->total_soal }}</h5>
                    <p class="text-muted">Total Soal</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('siswa.kuis.show', $kuis->id) }}" class="btn btn-primary me-2">
                    <i class="ti ti-refresh"></i> Coba Lagi
                </a>
                <a href="{{ route('siswa.kuis.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali ke Daftar Kuis
                </a>
            </div>
        </div>
    </div>

    <!-- Pembahasan (jika diaktifkan) -->
    @if($kuis->tampilkan_jawaban)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Pembahasan Soal</h5>

                @foreach($kuis->soal as $index => $soal)
                    @php
                        $jawabanSiswa = $percobaan->jawaban->where('soal_id', $soal->id)->first();
                        $benar = $jawabanSiswa ? $jawabanSiswa->benar : false;
                    @endphp

                    <div class="card mb-3 border-{{ $benar ? 'success' : 'danger' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h6 class="fw-semibold">Soal {{ $index + 1 }}</h6>
                                <span class="badge bg-{{ $benar ? 'success' : 'danger' }}">
                                    {{ $benar ? 'Benar' : 'Salah' }}
                                </span>
                            </div>

                            <p class="mb-3">{{ $soal->pertanyaan }}</p>

                            @if($soal->gambar_path)
                                <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 300px;">
                            @endif

                            @if($soal->jenis_soal != 'isian')
                                <div class="list-group mb-3">
                                    @foreach($soal->pilihanJawaban as $pilihan)
                                        @php
                                            $isPilihanSiswa = $jawabanSiswa && $jawabanSiswa->pilihan_jawaban_id == $pilihan->id;
                                            $isJawabanBenar = $pilihan->jawaban_benar;
                                        @endphp
                                        <div class="list-group-item {{ $isJawabanBenar ? 'list-group-item-success' : ($isPilihanSiswa ? 'list-group-item-danger' : '') }}">
                                            {{ chr(65 + $pilihan->urutan) }}. {{ $pilihan->teks_jawaban }}
                                            @if($isJawabanBenar)
                                                <i class="ti ti-check text-success float-end"></i>
                                            @endif
                                            @if($isPilihanSiswa && !$isJawabanBenar)
                                                <i class="ti ti-x text-danger float-end"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                @if($jawabanSiswa)
                                    <small class="text-muted">
                                        <strong>Jawaban Anda:</strong> 
                                        {{ $jawabanSiswa->pilihanJawaban ? chr(65 + $jawabanSiswa->pilihanJawaban->urutan) . '. ' . $jawabanSiswa->pilihanJawaban->teks_jawaban : 'Tidak dijawab' }}
                                    </small>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <strong>Jawaban Anda:</strong> {{ $jawabanSiswa->jawaban_isian ?? 'Tidak dijawab' }}
                                </div>
                                <small class="text-muted">Soal isian perlu dikoreksi manual oleh guru</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
