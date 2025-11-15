@extends('layouts.app')

@section('title', 'Edit Kuis')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Kuis</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.kuis.update', $kuis->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Judul Kuis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" value="{{ old('judul', $kuis->judul) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Materi Terkait</label>
                        <select class="form-select" name="materi_id">
                            <option value="">Pilih Materi (Opsional)</option>
                            @foreach($materiList as $materi)
                                <option value="{{ $materi->id }}" {{ old('materi_id', $kuis->materi_id) == $materi->id ? 'selected' : '' }}>
                                    {{ $materi->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <x-quill-editor id="deskripsi" name="deskripsi" value="{!! old('deskripsi', $kuis->deskripsi ?? '') !!}" />
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Durasi (Menit) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="durasi_menit" value="{{ old('durasi_menit', $kuis->durasi_menit) }}" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nilai Minimal Lulus <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="nilai_minimal" value="{{ old('nilai_minimal', $kuis->nilai_minimal) }}" min="0" max="100" required>
                        <small class="text-muted">Skala 0-100</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tingkat Kesulitan <span class="text-danger">*</span></label>
                        <select class="form-select" name="tingkat_kesulitan" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="mudah" {{ old('tingkat_kesulitan', $kuis->tingkat_kesulitan) == 'mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="sedang" {{ old('tingkat_kesulitan', $kuis->tingkat_kesulitan) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="sulit" {{ old('tingkat_kesulitan', $kuis->tingkat_kesulitan) == 'sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="acak_soal" id="acak_soal" {{ old('acak_soal', $kuis->acak_soal) ? 'checked' : '' }}>
                            <label class="form-check-label" for="acak_soal">
                                Acak Urutan Soal
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tampilkan_jawaban" id="tampilkan_jawaban" {{ old('tampilkan_jawaban', $kuis->tampilkan_jawaban) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tampilkan_jawaban">
                                Tampilkan Jawaban Setelah Selesai
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ old('aktif', $kuis->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">
                                Aktifkan Kuis
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Update
                    </button>
                    <a href="{{ route('guru.kuis.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

