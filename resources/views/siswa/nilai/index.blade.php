@extends('layouts.app')

@section('title', 'Nilai Saya')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Total Percobaan</h6>
                    <h3 class="mb-0">{{ $totalPercobaan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Rata-rata Nilai</h6>
                    <h3 class="mb-0">{{ $rataRataNilai ? number_format($rataRataNilai, 1) : '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Nilai Tertinggi</h6>
                    <h3 class="mb-0">{{ $nilaiTertinggi ?? '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="text-white-50">Jumlah Lulus</h6>
                    <h3 class="mb-0">{{ $jumlahLulus }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Rekap Nilai Per Kuis</h5>
            
            @if($perKuis->isEmpty())
                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i> Anda belum mengerjakan kuis apapun.
                </div>
            @else
                <div class="table-responsive">
                    <table id="nilaiTable" class="table table-hover table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Kuis</th>
                                <th>Jumlah Percobaan</th>
                                <th>Nilai Tertinggi</th>
                                <th>Nilai Terendah</th>
                                <th>Rata-rata</th>
                                <th>Status Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perKuis as $index => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['kuis']->judul }}</td>
                                <td>{{ $data['jumlah'] }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $data['tertinggi'] }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $data['terendah'] }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $data['rata_rata'] >= 70 ? 'success' : 'warning' }}">
                                        {{ number_format($data['rata_rata'], 1) }}
                                    </span>
                                </td>
                                <td>
                                    @if($data['lulus'] > 0)
                                        <span class="badge bg-success">
                                            <i class="ti ti-check"></i> Lulus ({{ $data['lulus'] }}x)
                                        </span>
                                    @else
                                        <span class="badge bg-danger">Belum Lulus</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Riwayat Semua Percobaan</h5>
            
            @if($percobaan->isEmpty())
                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i> Belum ada riwayat percobaan.
                </div>
            @else
                <div class="table-responsive">
                    <table id="riwayatTable" class="table table-hover table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kuis</th>
                                <th>Tanggal</th>
                                <th>Benar</th>
                                <th>Salah</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($percobaan as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->kuis->judul }}</td>
                                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td><span class="text-success">{{ $p->jumlah_benar }}</span></td>
                                <td><span class="text-danger">{{ $p->jumlah_salah }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $p->nilai >= 70 ? 'success' : 'danger' }}">
                                        {{ $p->nilai }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->lulus)
                                        <span class="badge bg-success">Lulus</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Lulus</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('siswa.kuis.hasil', $p->id) }}" class="btn btn-sm btn-info">
                                        <i class="ti ti-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
    });

    $('#riwayatTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[2, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 7 }
        ]
    });
});
</script>
@endpush
@endsection
