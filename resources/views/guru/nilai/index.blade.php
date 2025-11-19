@extends('layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Nilai Siswa</h5>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#perSiswa" role="tab">
                        <i class="ti ti-users"></i> Per Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#perKuis" role="tab">
                        <i class="ti ti-clipboard-list"></i> Per Kuis
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Per Siswa Tab -->
                <div class="tab-pane active" id="perSiswa" role="tabpanel">
                    <div class="table-responsive">
                        <table id="siswaTable" class="table table-hover table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Jumlah Percobaan</th>
                                    <th>Rata-rata Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswaList as $index => $siswa)
                                @php
                                    $percobaanSelesai = $siswa->percobaanKuis->where('status', 'selesai');
                                    $rataRata = $percobaanSelesai->avg('nilai');
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $siswa->name }}</td>
                                    <td>{{ $siswa->nomor_induk }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>{{ $percobaanSelesai->count() }}</td>
                                    <td>
                                        @if($rataRata)
                                            <span class="badge bg-{{ $rataRata >= 70 ? 'success' : 'danger' }}">
                                                {{ number_format($rataRata, 1) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.nilai.siswa', $siswa->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Per Kuis Tab -->
                <div class="tab-pane" id="perKuis" role="tabpanel">
                    <div class="table-responsive">
                        <table id="kuisTable" class="table table-hover table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Kuis</th>
                                    <th>Tingkat</th>
                                    <th>Jumlah Percobaan</th>
                                    <th>Rata-rata Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kuisList as $index => $kuis)
                                @php
                                    $percobaanSelesai = $kuis->percobaan->where('status', 'selesai');
                                    $rataRata = $percobaanSelesai->avg('nilai');
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kuis->judul }}</td>
                                    <td>
                                        <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($kuis->tingkat_kesulitan) }}
                                        </span>
                                    </td>
                                    <td>{{ $kuis->percobaan_count }}</td>
                                    <td>
                                        @if($rataRata)
                                            <span class="badge bg-{{ $rataRata >= 70 ? 'success' : 'danger' }}">
                                                {{ number_format($rataRata, 1) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.nilai.kuis', $kuis->id) }}" class="btn btn-sm btn-info">
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
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#siswaTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 6 }
        ]
    });

    $('#kuisTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });
});
</script>
@endpush
@endsection
