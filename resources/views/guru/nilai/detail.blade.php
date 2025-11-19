@extends('layouts.app')

@section('title', 'Detail Percobaan Kuis')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="card-title fw-semibold">{{ $percobaan->kuis->judul }}</h5>
                    <p class="mb-1"><strong>Siswa:</strong> {{ $percobaan->siswa->name }} ({{ $percobaan->siswa->nomor_induk }})</p>
                    <p class="mb-0"><strong>Tanggal:</strong> {{ $percobaan->created_at->format('d M Y, H:i') }}</p>
                </div>
                <a href="{{ route('guru.nilai.siswa', $percobaan->siswa_id) }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Score Summary -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light-{{ $percobaan->nilai >= 70 ? 'success' : 'danger' }}">
                <div class="card-body text-center">
                    <h6 class="text-muted">Nilai</h6>
                    <h2 class="fw-bold">{{ $percobaan->nilai }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-success">
                <div class="card-body text-center">
                    <h6 class="text-muted">Benar</h6>
                    <h2 class="fw-bold">{{ $percobaan->jumlah_benar }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-danger">
                <div class="card-body text-center">
                    <h6 class="text-muted">Salah</h6>
                    <h2 class="fw-bold">{{ $percobaan->jumlah_salah }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-info">
                <div class="card-body text-center">
                    <h6 class="text-muted">Status</h6>
                    <h4 class="fw-bold">
                        @if($percobaan->lulus)
                            <span class="badge bg-success">LULUS</span>
                        @else
                            <span class="badge bg-danger">TIDAK LULUS</span>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Answers -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Detail Jawaban</h5>

            @foreach($percobaan->kuis->soal as $index => $soal)
                @php
                    $jawaban = $percobaan->jawaban->where('soal_id', $soal->id)->first();
                @endphp
                <div class="card mb-3 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-semibold">Soal {{ $index + 1 }}</h6>
                            <div>
                                <span class="badge bg-primary">{{ $soal->poin }} poin</span>
                                @if($jawaban)
                                    @if($jawaban->benar)
                                        <span class="badge bg-success"><i class="ti ti-check"></i> Benar</span>
                                    @else
                                        <span class="badge bg-danger"><i class="ti ti-x"></i> Salah</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Tidak Dijawab</span>
                                @endif
                            </div>
                        </div>

                        <p class="mb-3">{{ $soal->pertanyaan }}</p>

                        @if($soal->gambar_path)
                            <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 300px;">
                        @endif

                        @if($soal->audio_path)
                            <audio controls class="w-100 mb-3" style="max-width: 400px;">
                                <source src="{{ asset('storage/' . $soal->audio_path) }}" type="audio/mpeg">
                            </audio>
                        @endif

                        @if($soal->jenis_soal != 'isian')
                            <div class="mt-3">
                                <strong>Pilihan Jawaban:</strong>
                                <ol type="A" class="mt-2">
                                    @foreach($soal->pilihanJawaban as $pilihan)
                                        <li class="mb-2 {{ $pilihan->jawaban_benar ? 'text-success fw-bold' : '' }} {{ $jawaban && $jawaban->pilihan_jawaban_id == $pilihan->id && !$pilihan->jawaban_benar ? 'text-danger' : '' }}">
                                            {{ $pilihan->teks_jawaban }}
                                            @if($pilihan->jawaban_benar)
                                                <i class="ti ti-check text-success"></i> <small>(Jawaban Benar)</small>
                                            @endif
                                            @if($jawaban && $jawaban->pilihan_jawaban_id == $pilihan->id)
                                                <i class="ti ti-arrow-left text-primary"></i> <small>(Jawaban Siswa)</small>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @else
                            <div class="mt-3">
                                <strong>Jawaban Siswa:</strong>
                                <p class="border p-2 rounded mt-2">{{ $jawaban->jawaban_isian ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
