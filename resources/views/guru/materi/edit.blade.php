@extends('layouts.app')

@section('title', 'Edit Materi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Materi</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" value="{{ old('judul', $materi->judul) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Materi <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_materi" id="jenis_materi" required>
                            <option value="">Pilih Jenis</option>
                            <option value="vocabulary" {{ old('jenis_materi', $materi->jenis_materi) == 'vocabulary' ? 'selected' : '' }}>Vocabulary</option>
                            <option value="grammar" {{ old('jenis_materi', $materi->jenis_materi) == 'grammar' ? 'selected' : '' }}>Grammar</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                </div>

                <div id="grammar-fields" style="display: {{ $materi->jenis_materi == 'grammar' ? 'block' : 'none' }};">
                    <div class="mb-3">
                        <label class="form-label">Konten Materi</label>
                        <x-quill-editor id="konten" name="konten" value="{!! old('konten', $materi->konten ?? '') !!}" />
                        <small class="text-muted">Penjelasan materi grammar</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL Video (YouTube/Vimeo)</label>
                            <input type="url" class="form-control" name="video_url" value="{{ old('video_url', $materi->video_url) }}" placeholder="https://youtube.com/watch?v=...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Video Baru</label>
                            <input type="file" class="form-control" name="video_path" accept="video/*">
                            <small class="text-muted">Format: mp4, avi, mov. Maksimal 50MB</small>
                            @if($materi->video_path)
                                <div class="mt-2">
                                    <small class="text-success">Video saat ini: {{ basename($materi->video_path) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" class="form-control" name="urutan" value="{{ old('urutan', $materi->urutan) }}" min="0">
                        <small class="text-muted">Urutan tampilan materi</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" {{ old('aktif', $materi->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">
                                Aktifkan materi
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Update
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
</script>
@endpush
@endsection
