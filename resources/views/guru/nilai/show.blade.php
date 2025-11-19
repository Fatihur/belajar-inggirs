@extends('layouts.app')

@section('title', 'Detail Nilai Siswa')

@section('content')
<div class="container-fluid">
    <!-- Student Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="card-title fw-semibold">{{ $siswa->name }}</h5>
                    <p class="mb-1"><strong>NIS:</strong> {{ $siswa->nomor_induk }}</p>
                    <p class="mb-1"><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $siswa->email }}</p>
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
                    <h6 class="text-muted">Total Percobaan</h6>
                    <h3 class="fw-bold">{{ $totalPercobaan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light-success">
                <div class="card-body">
                    <h6 class="text-muted">Rata-rata Nilai</h6>
                    <h3 class="fw-bold">{{ $rataRataNilai ? number_format($rataRataNilai, 1) : '-' }}</h3>
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
                    <h6 class="text-muted">Jumlah Lulus</h6>
                    <h3 class="fw-bold">{{ $jumlahLulus }} / {{ $totalPercobaan }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Results -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Riwayat Kuis</h5>

            <div class="table-responsive">
                <table id="nilaiTable" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kuis</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Benar/Salah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($percobaan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->kuis->judul }}</td>
                            <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $p->nilai >= 70 ? 'success' : 'danger' }} fs-4">
                                    {{ $p->nilai }}
                                </span>
                            </td>
                            <td>
                                <span class="text-success">{{ $p->jumlah_benar }}</span> / 
                                <span class="text-danger">{{ $p->jumlah_salah }}</span>
                            </td>
                            <td>
                                @if($p->lulus)
                                    <span class="badge bg-success">Lulus</span>
                                @else
                                    <span class="badge bg-danger">Tidak Lulus</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('guru.nilai.percobaan', $p->id) }}" class="btn btn-sm btn-info">
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
        order: [[2, 'desc']], // Sort by date descending
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 6 }
        ]
    });
});
</script>
@endpush
@endsection
