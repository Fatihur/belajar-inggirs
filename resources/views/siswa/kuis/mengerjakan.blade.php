@extends('layouts.app')

@section('title', 'Mengerjakan: ' . $kuis->judul)

@section('content')
<div class="container-fluid">
    <!-- Timer & Info -->
    <div class="card bg-light-warning mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-semibold mb-2">{{ $kuis->judul }}</h5>
                    <p class="mb-0">Total Soal: {{ $soalList->count() }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <h4 class="fw-bold text-danger mb-0">
                        <i class="ti ti-clock"></i>
                        <span id="timer">{{ sprintf('%02d:%02d', floor($waktuTersisa), ($waktuTersisa % 1) * 60) }}</span>
                    </h4>
                    <small>Waktu Tersisa</small>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('siswa.kuis.submit', $percobaan->id) }}" method="POST" id="formKuis">
        @csrf
        
        @foreach($soalList as $index => $soal)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-semibold">Soal {{ $index + 1 }}</h6>
                        <span class="badge bg-primary">{{ $soal->poin }} poin</span>
                    </div>

                    <p class="mb-3">{{ $soal->pertanyaan }}</p>

                    @if($soal->gambar_path)
                        <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-thumbnail mb-3" style="max-width: 400px;">
                    @endif

                    @if($soal->audio_path)
                        <audio controls class="w-100 mb-3" style="max-width: 500px;">
                            <source src="{{ asset('storage/' . $soal->audio_path) }}" type="audio/mpeg">
                        </audio>
                    @endif

                    @if($soal->jenis_soal == 'isian')
                        <input type="text" class="form-control" name="jawaban[{{ $soal->id }}]" placeholder="Ketik jawaban Anda...">
                    @else
                        <div class="list-group">
                            @foreach($soal->pilihanJawaban as $pilihan)
                                <label class="list-group-item list-group-item-action cursor-pointer">
                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $pilihan->id }}" class="form-check-input me-2">
                                    {{ chr(65 + $pilihan->urutan) }}. {{ $pilihan->teks_jawaban }}
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="card">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Yakin ingin mengumpulkan jawaban? Pastikan semua soal sudah dijawab.')">
                    <i class="ti ti-send"></i> Selesai & Kumpulkan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Timer countdown
let waktuTersisa = {{ $waktuTersisa }}; // dalam menit
let detik = waktuTersisa * 60; // konversi ke detik

const timerElement = document.getElementById('timer');
const formKuis = document.getElementById('formKuis');

const countdown = setInterval(function() {
    detik--;
    
    const menit = Math.floor(detik / 60);
    const sisaDetik = detik % 60;
    
    timerElement.textContent = `${String(menit).padStart(2, '0')}:${String(sisaDetik).padStart(2, '0')}`;
    
    // Ubah warna jika waktu tinggal sedikit
    if (detik <= 60) {
        timerElement.classList.add('text-danger');
    }
    
    // Auto submit jika waktu habis
    if (detik <= 0) {
        clearInterval(countdown);
        alert('Waktu habis! Jawaban akan otomatis dikumpulkan.');
        formKuis.submit();
    }
}, 1000);

// Konfirmasi sebelum meninggalkan halaman
window.addEventListener('beforeunload', function (e) {
    e.preventDefault();
    e.returnValue = '';
});
</script>
@endpush

@push('styles')
<style>
.cursor-pointer {
    cursor: pointer;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection
