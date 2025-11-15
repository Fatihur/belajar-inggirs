@extends('layouts.app')

@section('title', 'Detail Kuis')

@section('content')
<div class="container-fluid">
    <!-- Info Kuis -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="card-title fw-semibold">{{ $kuis->judul }}</h5>
                    <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                        {{ ucfirst($kuis->tingkat_kesulitan) }}
                    </span>
                    @if($kuis->aktif)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('guru.kuis.edit', $kuis->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit"></i> Edit
                    </a>
                    <a href="{{ route('guru.kuis.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    @if($kuis->materi)
                        <p class="mb-2"><strong>Materi Terkait:</strong> {{ $kuis->materi->judul }}</p>
                    @endif
                    @if($kuis->deskripsi)
                        <p class="mb-2"><strong>Deskripsi:</strong></p>
                        <div class="content-html">{!! $kuis->deskripsi !!}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Durasi:</strong> {{ $kuis->durasi_menit }} menit</p>
                    <p class="mb-2"><strong>Nilai Minimal:</strong> {{ $kuis->nilai_minimal }}</p>
                    <p class="mb-2"><strong>Total Soal:</strong> {{ $jumlahSoal }} soal ({{ $totalPoin }} poin)</p>
                </div>
            </div>

            <div class="mt-3">
                <span class="badge bg-info">
                    <i class="ti ti-{{ $kuis->acak_soal ? 'check' : 'x' }}"></i> 
                    {{ $kuis->acak_soal ? 'Soal Diacak' : 'Soal Tidak Diacak' }}
                </span>
                <span class="badge bg-info">
                    <i class="ti ti-{{ $kuis->tampilkan_jawaban ? 'check' : 'x' }}"></i> 
                    {{ $kuis->tampilkan_jawaban ? 'Tampilkan Jawaban' : 'Sembunyikan Jawaban' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Daftar Soal -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold">Daftar Soal ({{ $jumlahSoal }})</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSoalModal">
                    <i class="ti ti-plus"></i> Tambah Soal
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @forelse($kuis->soal as $index => $soal)
                <div class="card mb-3 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold">Soal {{ $index + 1 }}</h6>
                                <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $soal->jenis_soal)) }}</span>
                                <span class="badge bg-success">{{ $soal->poin }} poin</span>
                                
                                <p class="mt-3 mb-2">{{ $soal->pertanyaan }}</p>

                                @if($soal->gambar_path)
                                    <img src="{{ asset('storage/' . $soal->gambar_path) }}" alt="Gambar Soal" class="img-thumbnail mb-2" style="max-width: 300px;">
                                @endif

                                @if($soal->audio_path)
                                    <audio controls class="w-100 mb-2" style="max-width: 400px;">
                                        <source src="{{ asset('storage/' . $soal->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                @endif

                                @if($soal->jenis_soal != 'isian')
                                    <div class="mt-3">
                                        <strong>Pilihan Jawaban:</strong>
                                        <ol type="A">
                                            @foreach($soal->pilihanJawaban as $pilihan)
                                                <li class="{{ $pilihan->jawaban_benar ? 'text-success fw-bold' : '' }}">
                                                    {{ $pilihan->teks_jawaban }}
                                                    @if($pilihan->jawaban_benar)
                                                        <i class="ti ti-check text-success"></i>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <form action="{{ route('guru.kuis.soal.destroy', [$kuis->id, $soal->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <p class="text-muted">Belum ada soal. Silakan tambahkan soal untuk kuis ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Tambah Soal -->
<div class="modal fade" id="addSoalModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('guru.kuis.soal.store', $kuis->id) }}" method="POST" enctype="multipart/form-data" id="formSoal">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="pertanyaan" rows="3" required></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Soal <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenis_soal" id="jenis_soal" required>
                                <option value="">Pilih Jenis</option>
                                <option value="pilihan_ganda">Pilihan Ganda</option>
                                <option value="benar_salah">Benar/Salah</option>
                                <option value="isian">Isian</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gambar Soal (Opsional)</label>
                            <input type="file" class="form-control" name="gambar_path" accept="image/*">
                            <small class="text-muted">Format: jpg, png. Maksimal 2MB</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Audio Soal (Opsional)</label>
                            <input type="file" class="form-control" name="audio_path" accept="audio/*">
                            <small class="text-muted">Format: mp3, wav. Maksimal 5MB</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Poin <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="poin" value="10" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" class="form-control" name="urutan" value="0" min="0">
                        </div>
                    </div>

                    <!-- Pilihan Jawaban (untuk pilihan ganda dan benar/salah) -->
                    <div id="pilihan-container" style="display: none;">
                        <hr>
                        <h6 class="mb-3">Pilihan Jawaban</h6>
                        <div id="pilihan-ganda-container">
                            <div class="mb-3">
                                <label class="form-label">A.</label>
                                <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan A">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">B.</label>
                                <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan B">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">C.</label>
                                <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan C">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">D.</label>
                                <input type="text" class="form-control" name="pilihan[]" placeholder="Pilihan D">
                            </div>
                        </div>
                        <div id="benar-salah-container" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">A.</label>
                                <input type="text" class="form-control" name="pilihan[]" value="Benar" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">B.</label>
                                <input type="text" class="form-control" name="pilihan[]" value="Salah" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                            <select class="form-select" name="jawaban_benar" id="jawaban_benar">
                                <option value="">Pilih Jawaban Benar</option>
                                <option value="0">A</option>
                                <option value="1">B</option>
                                <option value="2">C</option>
                                <option value="3">D</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('jenis_soal').addEventListener('change', function() {
    const pilihanContainer = document.getElementById('pilihan-container');
    const pilihanGanda = document.getElementById('pilihan-ganda-container');
    const benarSalah = document.getElementById('benar-salah-container');
    const jawabanBenar = document.getElementById('jawaban_benar');
    
    if (this.value === 'pilihan_ganda') {
        pilihanContainer.style.display = 'block';
        pilihanGanda.style.display = 'block';
        benarSalah.style.display = 'none';
        
        // Reset options
        jawabanBenar.innerHTML = `
            <option value="">Pilih Jawaban Benar</option>
            <option value="0">A</option>
            <option value="1">B</option>
            <option value="2">C</option>
            <option value="3">D</option>
        `;
        
        // Set required
        pilihanGanda.querySelectorAll('input').forEach(input => input.required = true);
        benarSalah.querySelectorAll('input').forEach(input => input.required = false);
        jawabanBenar.required = true;
    } else if (this.value === 'benar_salah') {
        pilihanContainer.style.display = 'block';
        pilihanGanda.style.display = 'none';
        benarSalah.style.display = 'block';
        
        // Reset options
        jawabanBenar.innerHTML = `
            <option value="">Pilih Jawaban Benar</option>
            <option value="0">Benar</option>
            <option value="1">Salah</option>
        `;
        
        // Set required
        pilihanGanda.querySelectorAll('input').forEach(input => input.required = false);
        benarSalah.querySelectorAll('input').forEach(input => input.required = true);
        jawabanBenar.required = true;
    } else {
        pilihanContainer.style.display = 'none';
        pilihanGanda.querySelectorAll('input').forEach(input => input.required = false);
        benarSalah.querySelectorAll('input').forEach(input => input.required = false);
        jawabanBenar.required = false;
    }
});
</script>
@endpush
@endsection
