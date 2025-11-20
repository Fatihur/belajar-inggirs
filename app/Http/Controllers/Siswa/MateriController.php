<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user();
        $kelasSiswa = $siswa->kelas;
        
        $query = Materi::where('aktif', true)
            ->where('kelas_target', $kelasSiswa)
            ->withCount('kosakata');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by jenis_materi
        if ($request->filled('jenis_materi')) {
            $query->where('jenis_materi', $request->jenis_materi);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'urutan');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 12);
        $materiList = $query->paginate($perPage)->withQueryString();

        return view('siswa.materi.index', compact('materiList'));
    }

    public function show($id)
    {
        $materi = Materi::with(['kosakata' => function($q) {
            $q->orderBy('urutan');
        }])->findOrFail($id);

        // Pastikan materi aktif
        if (!$materi->aktif) {
            abort(404, 'Materi tidak ditemukan');
        }

        return view('siswa.materi.show', compact('materi'));
    }
}
