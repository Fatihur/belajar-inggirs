@extends('layouts.app')

@section('title', 'Tambah Materi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Materi Baru</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Materi <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_materi" id="jenis_materi" required>
                            <option value="">Pilih Jenis</option>
                            <option value="vocabulary" {{ old('jenis_materi') == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ old('jenis_materi') == 'grammar' ? 'selected' : '' }}>Grammar</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <div id="grammar-fields" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Konten Materi</label>
                        <x-quill-editor id="konten" name="konten" value="{{ old('konten', '') }}" />
                        <small class="text-muted">Penjelasan materi grammar</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL Video (YouTube/Vimeo)</label>
                            <input type="url" class="form-control" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" class="form-control" name="video_path" accept="video/*">
                            <small class="text-muted">Format: mp4, avi, mov. Maksimal 50MB</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" class="form-control" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                        <small class="text-muted">Urutan tampilan materi</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ old('aktif', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">
                                Aktifkan materi
                            </label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <strong>Catatan:</strong> Jika memilih Vocabulary, Anda akan diarahkan ke halaman untuk menambahkan daftar kosakata setelah menyimpan.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan
                    </button>
                    <a href="{{ route('guru.materi.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('jenis_materi').addEventListener('change', function() {
    const grammarFields = document.getElementById('grammar-fields');
    if (this.value === 'grammar') {
        grammarFields.style.display = 'block';
    } else {
        grammarFields.style.display = 'none';
    }
});

// Trigger on page load if old value exists
if (document.getElementById('jenis_materi').value === 'grammar') {
    document.getElementById('grammar-fields').style.display = 'block';
}
</script>
@endpush
@endsection
