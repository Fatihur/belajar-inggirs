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

        $totalMateri = Materi::where('aktif', true)->count();
        $totalKuis = Kuis::where('aktif', true)->count();
        
        $kuisDikerjakan = PercobaanKuis::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->count();

        $rataRataNilai = PercobaanKuis::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->avg('nilai') ?? 0;

        // Ambil riwayat kuis terbaru
        $riwayatKuis = PercobaanKuis::where('siswa_id', $siswa->id)
            ->with('kuis')
            ->latest()
            ->take(5)
            ->get();

        // Ambil materi terbaru
        $materiTerbaru = Materi::where('aktif', true)
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
