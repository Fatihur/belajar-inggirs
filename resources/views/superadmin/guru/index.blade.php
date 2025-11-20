@extends('layouts.app')

@section('title', 'Kelola Guru')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title fw-semibold">Daftar Guru</h5>
                <a href="{{ route('superadmin.guru.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Guru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="guruTable" class="table table-hover table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Kelas Mengajar</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guruList as $index => $guru)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $guru->name }}</td>
                            <td>{{ $guru->email }}</td>
                            <td>{{ $guru->nomor_induk }}</td>
                            <td>
                                @if($guru->kelas_mengajar)
                                    <span class="badge bg-primary">Kelas {{ $guru->kelas_mengajar }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $guru->no_telepon ?? '-' }}</td>
                            <td>
                                <a href="{{ route('superadmin.guru.edit', $guru->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('superadmin.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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
    $('#guruTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        columnDefs: [
            { orderable: false, targets: 7 } // Disable sorting on action column
        ]
    });
});
</script>
@endpush
@endsection
