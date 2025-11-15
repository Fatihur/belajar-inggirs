@extends('layouts.app')

@section('title', 'Kelola Materi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold">Daftar Materi</h5>
                <a href="{{ route('guru.materi.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Materi
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="materiTable" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Jumlah Kosakata</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiList as $index => $materi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $materi->judul }}</td>
                            <td>
                                <span class="badge bg-{{ $materi->jenis_materi == 'vocabulary' ? 'primary' : 'info' }}">
                                    {{ ucfirst($materi->jenis_materi) }}
                                </span>
                            </td>
                            <td>
                                @if($materi->jenis_materi == 'vocabulary')
                                    {{ $materi->kosakata_count }} kata
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $materi->urutan }}</td>
                            <td>
                                @if($materi->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('guru.materi.show', $materi->id) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('guru.materi.edit', $materi->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
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
    $('#materiTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 6 } // Disable sorting on action column
        ]
    });
});
</script>
@endpush
@endsection
