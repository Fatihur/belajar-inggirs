@extends('layouts.app')

@section('title', 'Kelola Kuis')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold">Daftar Kuis</h5>
                <a href="{{ route('guru.kuis.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Kuis
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="kuisTable" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Materi</th>
                            <th>Tingkat</th>
                            <th>Soal</th>
                            <th>Durasi</th>
                            <th>Percobaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kuisList as $index => $kuis)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kuis->judul }}</td>
                            <td>{{ $kuis->materi->judul ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $kuis->tingkat_kesulitan == 'mudah' ? 'success' : ($kuis->tingkat_kesulitan == 'sedang' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($kuis->tingkat_kesulitan) }}
                                </span>
                            </td>
                            <td>{{ $kuis->soal_count }} soal</td>
                            <td>{{ $kuis->durasi_menit }} menit</td>
                            <td>{{ $kuis->percobaan_count }}x</td>
                            <td>
                                @if($kuis->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('guru.kuis.show', $kuis->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('guru.kuis.edit', $kuis->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('guru.kuis.destroy', $kuis->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kuis ini? Semua soal dan data percobaan akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
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
    $('#kuisTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 8 } // Disable sorting on action column
        ]
    });
});
</script>
@endpush
@endsection
