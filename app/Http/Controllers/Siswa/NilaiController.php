<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PercobaanKuis;

class NilaiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user();
        
        $percobaan = PercobaanKuis::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')
            ->with(['kuis'])
            ->latest()
            ->get();

        // Group by kuis
        $perKuis = $percobaan->groupBy('kuis_id')->map(function($attempts) {
            return [
                'kuis' => $attempts->first()->kuis,
                'percobaan' => $attempts,
                'rata_rata' => $attempts->avg('nilai'),
                'tertinggi' => $attempts->max('nilai'),
                'terendah' => $attempts->min('nilai'),
                'jumlah' => $attempts->count(),
                'lulus' => $attempts->where('lulus', true)->count()
            ];
        });

        // Statistics
        $totalPercobaan = $percobaan->count();
        $rataRataNilai = $percobaan->avg('nilai');
        $nilaiTertinggi = $percobaan->max('nilai');
        $nilaiTerendah = $percobaan->min('nilai');
        $jumlahLulus = $percobaan->where('lulus', true)->count();

        return view('siswa.nilai.index', compact(
            'percobaan',
            'perKuis',
            'totalPercobaan',
            'rataRataNilai',
            'nilaiTertinggi',
            'nilaiTerendah',
            'jumlahLulus'
        ));
    }
}
