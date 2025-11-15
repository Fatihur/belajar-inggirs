@extends('layouts.app')

@section('title', 'Hasil Kuis')

@section('content')
<div class="quiz-wrapper py-4">
    <div class="hero-banner rounded-4 p-4 p-lg-5 mb-4 text-white position-relative overflow-hidden">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
            <div>
                <p class="text-uppercase text-white-50 small mb-2">Hasil Kuis</p>
                <h2 class="fw-bold mb-3">{{ $kuis->judul }}</h2>
                <p class="text-white-75 mb-0">Berikut rangkuman hasil dan pembahasan kuis yang baru saja Anda selesaikan.</p>
            </div>
            <div class="text-lg-end">
                <a href="{{ route('siswa.kuis.index') }}" class="btn btn-light text-primary">
                    <i class="ti ti-arrow-left"></i> Kembali ke daftar kuis
                </a>
            </div>
        </div>
        <div class="hero-glow"></div>
    </div>

    <div class="result-card {{ $percobaan->lulus ? 'result-success' : 'result-danger' }} mb-5">
        <div class="result-score">
            <span class="label">Nilai Anda</span>
            <div class="score">{{ $percobaan->nilai }}</div>
            <span class="status text-uppercase">{{ $percobaan->lulus ? 'Lulus' : 'Belum Lulus' }}</span>
        </div>
        <div class="result-stats">
            <div>
                <small class="text-muted text-uppercase">Benar</small>
                <h4 class="mb-0">{{ $percobaan->jumlah_benar }}</h4>
            </div>
            <div>
                <small class="text-muted text-uppercase">Salah</small>
                <h4 class="mb-0">{{ $percobaan->jumlah_salah }}</h4>
            </div>
            <div>
                <small class="text-muted text-uppercase">Total Soal</small>
                <h4 class="mb-0">{{ $percobaan->total_soal }}</h4>
            </div>
        </div>
        <div class="result-actions">
            <a href="{{ route('siswa.kuis.show', $kuis->id) }}" class="btn btn-outline-light">
                <i class="ti ti-refresh"></i> Coba Lagi
            </a>
            <a href="{{ route('siswa.kuis.index') }}" class="btn btn-light text-primary">
                Lihat Kuis Lain
            </a>
        </div>
    </div>

    @if($kuis->tampilkan_jawaban)
        <div class="card modern-card">
            <div class="card-body p-4 p-lg-5">
                <p class="text-uppercase text-muted small mb-1">Pembahasan</p>
                <h4 class="fw-semibold mb-4">Cek kembali jawabanmu</h4>

                @foreach($kuis->soal as $index => $soal)
                    @php
                        $jawabanSiswa = $percobaan->jawaban->where('soal_id', $soal->id)->first();
                        $benar = $jawabanSiswa ? $jawabanSiswa->benar : false;
                    @endphp
                    <div class="explain-card {{ $benar ? 'correct' : 'incorrect' }}">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Soal {{ $index + 1 }}</p>
                                <h6 class="fw-semibold mb-0">{{ $soal->pertanyaan }}</h6>
                            </div>
                            <span class="status-pill {{ $benar ? 'status-success' : 'status-danger' }}">
                                {{ $benar ? 'Benar' : 'Salah' }}
                            </span>
                        </div>

                        @if($soal->gambar_path)
                            <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-fluid rounded-3 mb-3" style="max-width: 320px;">
                        @endif

                        @if($soal->jenis_soal != 'isian')
                            <div class="list-group pembahasan mb-3">
                                @foreach($soal->pilihanJawaban as $pilihan)
                                    @php
                                        $isPilihanSiswa = $jawabanSiswa && $jawabanSiswa->pilihan_jawaban_id == $pilihan->id;
                                        $isJawabanBenar = $pilihan->jawaban_benar;
                                    @endphp
                                    <div class="list-group-item d-flex align-items-center justify-content-between
                                        {{ $isJawabanBenar ? 'correct-answer' : ($isPilihanSiswa ? 'wrong-answer' : '') }}">
                                        <span>{{ chr(65 + $pilihan->urutan) }}. {{ $pilihan->teks_jawaban }}</span>
                                        <span>
                                            @if($isJawabanBenar)
                                                <i class="ti ti-check text-success"></i>
                                            @endif
                                            @if($isPilihanSiswa && !$isJawabanBenar)
                                                <i class="ti ti-x text-danger"></i>
                                            @endif
                                        </span>
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
                                <strong>Jawaban Anda:</strong> {{ $jawabanSiswa->jawaban_isian ?? 'Tidak dijawab' }}<br>
                                <small class="text-muted">Soal isian akan dinilai oleh guru.</small>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .quiz-wrapper {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 28px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .hero-banner {
        background: linear-gradient(135deg, #2563eb, #22d3ee);
        color: #fff;
    }

    .hero-glow {
        position: absolute;
        bottom: -30px;
        right: 60px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        filter: blur(25px);
    }

    .result-card {
        border-radius: 28px;
        padding: 2rem;
        color: #fff;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.5rem;
        align-items: center;
    }

    .result-card.result-success {
        background: linear-gradient(135deg, #16a34a, #4ade80);
    }

    .result-card.result-danger {
        background: linear-gradient(135deg, #ef4444, #f97316);
    }

    .result-score {
        text-align: center;
    }

    .result-score .label {
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .result-score .score {
        font-size: clamp(3rem, 6vw, 4.5rem);
        font-weight: 700;
        line-height: 1;
    }

    .result-stats {
        display: flex;
        justify-content: space-around;
        gap: 1.5rem;
        text-align: center;
    }

    .result-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .modern-card {
        border: none;
        border-radius: 28px;
        box-shadow: 0 15px 40px rgba(15, 56, 107, 0.08);
    }

    .explain-card {
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: #fff;
    }

    .explain-card.correct {
        border-color: rgba(34, 197, 94, 0.4);
    }

    .explain-card.incorrect {
        border-color: rgba(248, 113, 113, 0.4);
    }

    .pembahasan .correct-answer {
        background: rgba(34, 197, 94, 0.12);
    }

    .pembahasan .wrong-answer {
        background: rgba(248, 113, 113, 0.12);
    }

    @media (max-width: 991.98px) {
        .result-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .result-actions {
            justify-content: center;
        }
    }
</style>
@endpush
@endsection
