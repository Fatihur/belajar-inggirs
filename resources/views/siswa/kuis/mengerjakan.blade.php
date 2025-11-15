@extends('layouts.app')

@section('title', 'Mengerjakan: ' . $kuis->judul)

@section('content')
@php
    $initialSeconds = max(0, (int) round($waktuTersisa * 60));
@endphp
<div class="quiz-wrapper py-4">
    <div class="timer-card rounded-4 p-4 mb-4 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
        <div>
            <p class="text-uppercase text-muted small mb-1">Sedang Mengerjakan</p>
            <h3 class="fw-bold mb-1">{{ $kuis->judul }}</h3>
            <p class="text-muted mb-0">Total Soal: {{ $soalList->count() }}</p>
        </div>
        <div class="timer-display text-center mt-3 mt-lg-0">
            <span class="label text-uppercase small text-muted d-block">Waktu tersisa</span>
            <div class="time fw-bold" id="timer">{{ gmdate('i:s', $initialSeconds) }}</div>
        </div>
    </div>

    <form action="{{ route('siswa.kuis.submit', $percobaan->id) }}" method="POST" id="formKuis">
        @csrf
        <div class="question-stack">
            @foreach($soalList as $index => $soal)
                <div class="question-card" data-question-index="{{ $index }}">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Soal {{ $index + 1 }}</p>
                            <h6 class="fw-semibold mb-0">{{ $soal->pertanyaan }}</h6>
                        </div>
                        <span class="badge bg-primary-subtle text-primary">{{ $soal->poin }} poin</span>
                    </div>

                    @if($soal->gambar_path)
                        <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-fluid rounded-3 mb-3" style="max-width: 420px;">
                    @endif

                    @if($soal->audio_path)
                        <audio controls class="w-100 rounded-3 mb-3">
                            <source src="{{ asset('storage/' . $soal->audio_path) }}" type="audio/mpeg">
                        </audio>
                    @endif

                    @if($soal->jenis_soal == 'isian')
                        <input type="text" class="form-control form-control-lg" name="jawaban[{{ $soal->id }}]" placeholder="Ketik jawaban Anda...">
                    @else
                        <div class="option-list">
                            @foreach($soal->pilihanJawaban as $pilihan)
                                <label class="option-choice">
                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $pilihan->id }}">
                                    <span class="choice-label">{{ chr(65 + $pilihan->urutan) }}</span>
                                    <span class="choice-text">{{ $pilihan->teks_jawaban }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="question-navigation text-center mt-4">
            <div class="progress-wrapper mb-3">
                <span class="small text-muted d-block mb-1">Soal ke- <span id="currentQuestion">1</span> dari {{ $soalList->count() }}</span>
                <div class="progress">
                    <div class="progress-bar" id="questionProgress" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-secondary" id="prevQuestion" disabled>Soal Sebelumnya</button>
                <button type="button" class="btn btn-primary" id="nextQuestion">Soal Berikutnya</button>
                <button type="button" class="btn btn-success btn-lg px-4" id="submitQuizBtn">
                    <i class="ti ti-send"></i> Selesai & Kumpulkan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let detik = {{ $initialSeconds }};
const timerElement = document.getElementById('timer');
const formKuis = document.getElementById('formKuis');

const countdown = setInterval(function() {
    detik--;

    const menit = Math.floor(detik / 60);
    const sisaDetik = detik % 60;
    timerElement.textContent = `${String(menit).padStart(2, '0')}:${String(sisaDetik).padStart(2, '0')}`;

    timerElement.classList.toggle('text-danger', detik <= 60);

    if (detik <= 0) {
        clearInterval(countdown);
        alert('Waktu habis! Jawaban akan otomatis dikumpulkan.');
        formKuis.submit();
    }
}, 1000);

// Question navigation
const questionCards = Array.from(document.querySelectorAll('.question-card'));
const totalQuestions = questionCards.length;
let currentIndex = 0;

const prevBtn = document.getElementById('prevQuestion');
const nextBtn = document.getElementById('nextQuestion');
const currentQuestionLabel = document.getElementById('currentQuestion');
const progressBar = document.getElementById('questionProgress');

function updateProgress(index) {
    if (!progressBar) {
        return;
    }
    const percent = totalQuestions > 1 ? (index / (totalQuestions - 1)) * 100 : 100;
    progressBar.style.width = `${percent}%`;
}

function showQuestion(index) {
    questionCards.forEach((card, idx) => {
        if (idx === index) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
    });
    currentQuestionLabel.textContent = index + 1;
    prevBtn.disabled = index === 0;
    nextBtn.disabled = index === totalQuestions - 1 || totalQuestions <= 1;
    updateProgress(index);
}

if (totalQuestions > 0) {
    prevBtn?.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showQuestion(currentIndex);
        }
    });

    nextBtn?.addEventListener('click', () => {
        if (currentIndex < totalQuestions - 1) {
            currentIndex++;
            showQuestion(currentIndex);
        }
    });

    showQuestion(0);
} else {
    prevBtn.disabled = true;
    nextBtn.disabled = true;
    currentQuestionLabel.textContent = 0;
    updateProgress(0);
}

// Highlight selected option
document.querySelectorAll('.option-choice input[type="radio"]').forEach((radio) => {
    radio.addEventListener('change', (e) => {
        const name = e.target.name;
        document.querySelectorAll(`input[name="${name}"]`).forEach((input) => {
            input.closest('.option-choice').classList.remove('selected');
        });
        e.target.closest('.option-choice').classList.add('selected');
    });
});

document.getElementById('submitQuizBtn')?.addEventListener('click', () => {
    Swal.fire({
        title: 'Kumpulkan jawaban?',
        text: 'Pastikan semua jawaban sudah diisi sebelum mengumpulkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0f9d58',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kumpulkan',
        cancelButtonText: 'Periksa lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            formKuis.submit();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .quiz-wrapper {
        background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        border-radius: 28px;
        padding-inline: clamp(0.5rem, 1.5vw, 1.5rem);
    }

    .timer-card {
        background: linear-gradient(135deg, #fff2e0, #ffe0c2);
        border: 1px solid #ffd1a4;
    }

    .timer-display .time {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        letter-spacing: 2px;
    }

    .question-stack {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .question-card {
        background: #fff;
        border-radius: 24px;
        padding: 1.75rem;
        border: 1px solid #eef2ff;
        box-shadow: 0 12px 30px rgba(15, 56, 107, 0.08);
        display: none;
    }

    .question-card.active {
        display: block;
    }

    .option-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .option-choice {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1.1rem;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s;
    }

    .option-choice:hover {
        border-color: #c7d2fe;
        background: #f8faff;
    }

    .option-choice input {
        display: none;
    }

    .choice-label {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #eef2ff;
        color: #4338ca;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .choice-text {
        flex: 1;
        color: #0f172a;
    }

    .option-choice.selected {
        border-color: #93c5fd;
        background: #eff6ff;
    }

    .option-choice.selected .choice-label {
        background: #dbeafe;
        color: #1d4ed8;
    }
</style>
@endpush
@endsection
