@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
<div class="container-fluid">
    <!-- Info Materi -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="card-title fw-semibold">{{ $materi->judul }}</h5>
                    <span class="badge bg-{{ $materi->jenis_materi == 'vocabulary' ? 'primary' : 'info' }}">
                        {{ ucfirst($materi->jenis_materi) }}
                    </span>
                    @if($materi->aktif)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('guru.materi.edit', $materi->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit"></i> Edit
                    </a>
                    <a href="{{ route('guru.materi.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if($materi->deskripsi)
                <p class="mb-2"><strong>Deskripsi:</strong></p>
                <div class="content-html">
                    {!! $materi->deskripsi !!}
                </div>
            @endif

            @if($materi->jenis_materi == 'grammar')
                @if($materi->konten)
                    <hr>
                    <p class="mb-2"><strong>Konten:</strong></p>
                    <div class="border p-3 rounded content-html">
                        {!! $materi->konten !!}
                    </div>
                @endif

                @if($materi->video_url || $materi->video_path)
                    <hr>
                    <p class="mb-2"><strong>Video Pembelajaran:</strong></p>
                    @if($materi->video_url)
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ video_embed_url($materi->video_url) }}" 
                                    allowfullscreen 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    frameborder="0"></iframe>
                        </div>
                    @elseif($materi->video_path)
                        <video controls class="w-100">
                            <source src="{{ asset('storage/' . $materi->video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @endif
                @endif
            @endif
        </div>
    </div>

    <!-- Daftar Kosakata (jika vocabulary) -->
    @if($materi->jenis_materi == 'vocabulary')
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold">Daftar Kosakata ({{ $materi->kosakata->count() }})</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addKosakataModal">
                        <i class="ti ti-plus"></i> Tambah Kosakata
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kata Inggris</th>
                                <th>Terjemahan</th>
                                <th>Jenis Kata</th>
                                <th>Contoh Kalimat</th>
                                <th>Media</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materi->kosakata as $index => $kata)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $kata->kata_inggris }}</strong></td>
                                <td>{{ $kata->kata_indonesia }}</td>
                                <td>{{ $kata->jenis_kata ?? '-' }}</td>
                                <td>{{ $kata->contoh_kalimat ?? '-' }}</td>
                                <td>
                                    @if($kata->audio_path)
                                        <audio controls class="w-100" style="max-width: 200px;">
                                            <source src="{{ asset('storage/' . $kata->audio_path) }}" type="audio/mpeg">
                                        </audio>
                                    @endif
                                    @if($kata->gambar_path)
                                        <img src="{{ asset('storage/' . $kata->gambar_path) }}" alt="{{ $kata->kata_inggris }}" class="img-thumbnail" style="max-width: 100px;">
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('guru.materi.kosakata.destroy', [$materi->id, $kata->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kosakata ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada kosakata. Silakan tambahkan kosakata.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Tambah Kosakata -->
<div class="modal fade" id="addKosakataModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('guru.materi.kosakata.store', $materi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kosakata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kata Inggris <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kata_inggris" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Terjemahan Indonesia <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kata_indonesia" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kata</label>
                            <select class="form-select" name="jenis_kata">
                                <option value="">Pilih Jenis</option>
                                <option value="noun">Noun (Kata Benda)</option>
                                <option value="verb">Verb (Kata Kerja)</option>
                                <option value="adjective">Adjective (Kata Sifat)</option>
                                <option value="adverb">Adverb (Kata Keterangan)</option>
                                <option value="pronoun">Pronoun (Kata Ganti)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" class="form-control" name="urutan" value="0" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contoh Kalimat</label>
                        <textarea class="form-control" name="contoh_kalimat" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Audio Pelafalan</label>
                            <input type="file" class="form-control" name="audio_path" accept="audio/*">
                            <small class="text-muted">Format: mp3, wav. Maksimal 5MB</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gambar Ilustrasi</label>
                            <input type="file" class="form-control" name="gambar_path" accept="image/*">
                            <small class="text-muted">Format: jpg, png. Maksimal 2MB</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
