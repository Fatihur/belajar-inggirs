<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\PercobaanKuis;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user();

        $totalMateri = Materi::where('dibuat_oleh', $guru->id)->count();
        $totalKuis = Kuis::where('dibuat_oleh', $guru->id)->count();
        $totalSiswa = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'siswa');
        })->count();

        // Ambil kuis yang dibuat guru dengan statistik
        $kuisList = Kuis::where('dibuat_oleh', $guru->id)
            ->withCount('percobaan')
            ->with(['percobaan' => function($q) {
                $q->where('status', 'selesai');
            }])
            ->latest()
            ->take(5)
            ->get();

        // Hitung rata-rata nilai per kuis
        foreach ($kuisList as $kuis) {
            $kuis->rata_nilai = $kuis->percobaan()
                ->where('status', 'selesai')
                ->avg('nilai') ?? 0;
            
            $kuis->tingkat_ketuntasan = $kuis->percobaan()
                ->where('status', 'selesai')
                ->where('lulus', true)
                ->count();
        }

        return view('guru.dashboard', compact(
            'totalMateri',
            'totalKuis',
            'totalSiswa',
            'kuisList'
        ));
    }
}
