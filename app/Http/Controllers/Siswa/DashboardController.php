<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\PercobaanKuis;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user();
        $kelasSiswa = $siswa->kelas; // Ambil kelas siswa (7 atau 8)

        // Filter berdasarkan kelas siswa
        $totalMateri = Materi::where('aktif', true)
            ->where('kelas_target', $kelasSiswa)
            ->count();
            
        $totalKuis = Kuis::where('aktif', true)
            ->where('kelas_target', $kelasSiswa)
            ->count();
        
        $kuisDikerjakan = PercobaanKuis::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->count();

        $rataRataNilai = PercobaanKuis::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->avg('nilai') ?? 0;

        // Ambil riwayat kuis terbaru (hanya kuis sesuai kelas)
        $riwayatKuis = PercobaanKuis::where('siswa_id', $siswa->id)
            ->with(['kuis' => function($query) use ($kelasSiswa) {
                $query->where('kelas_target', $kelasSiswa);
            }])
            ->whereHas('kuis', function($query) use ($kelasSiswa) {
                $query->where('kelas_target', $kelasSiswa);
            })
            ->latest()
            ->take(5)
            ->get();

        // Ambil materi terbaru (hanya materi sesuai kelas)
        $materiTerbaru = Materi::where('aktif', true)
            ->where('kelas_target', $kelasSiswa)
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalMateri',
            'totalKuis',
            'kuisDikerjakan',
            'rataRataNilai',
            'riwayatKuis',
            'materiTerbaru'
        ));
    }
}
