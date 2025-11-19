@extends('layouts.app')

@section('title', 'Nilai Per Kuis')

@section('content')
<div class="container-fluid">
    <!-- Quiz Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="card-title fw-semibold">{{ $kuis->judul }}</h5>
                    <p class="mb-1">
                        <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                            {{ ucfirst($kuis->tingkat_kesulitan) }}
                        </span>
                        <span class="badge bg-info">{{ $kuis->durasi_menit }} menit</span>
                        <span class="badge bg-secondary">Nilai Minimal: {{ $kuis->nilai_minimal }}</span>
                    </p>
                    @if($kuis->materi)
                        <p class="mb-0"><strong>Materi:</strong> {{ $kuis->materi->judul }}</p>
                    @endif
                </div>
                <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light-primary">
                <div class="card-body">
                    <h6 class="text-muted">Total Siswa</h6>
                    <h3 class="fw-bold">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-success">
                <div class="card-body">
                    <h6 class="text-muted">Rata-rata Kelas</h6>
                    <h3 class="fw-bold">{{ $rataRataKelas ? number_format($rataRataKelas, 1) : '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-info">
                <div class="card-body">
                    <h6 class="text-muted">Nilai Tertinggi</h6>
                    <h3 class="fw-bold">{{ $nilaiTertinggi ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-warning">
                <div class="card-body">
                    <h6 class="text-muted">Tingkat Kelulusan</h6>
                    <h3 class="fw-bold">{{ number_format($tingkatKelulusan, 1) }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Results -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Nilai Per Siswa</h5>

            <div class="table-responsive">
                <table id="nilaiTable" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Percobaan</th>
                            <th>Rata-rata</th>
                            <th>Tertinggi</th>
                            <th>Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perSiswa as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data['siswa']->name }}</td>
                            <td>{{ $data['siswa']->nomor_induk }}</td>
                            <td>{{ $data['siswa']->kelas }}</td>
                            <td>{{ $data['jumlah'] }}x</td>
                            <td>
                                <span class="badge bg-{{ $data['rata_rata'] >= 70 ? 'success' : 'danger' }}">
                                    {{ number_format($data['rata_rata'], 1) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $data['tertinggi'] }}</span>
                            </td>
                            <td>{{ $data['lulus'] }} / {{ $data['jumlah'] }}</td>
                            <td>
                                <a href="{{ route('guru.nilai.siswa', $data['siswa']->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#nilaiTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[5, 'desc']], // Sort by average descending
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 8 }
        ]
    });
});
</script>
@endpush
@endsection
