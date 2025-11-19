<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kuis;
use App\Models\PercobaanKuis;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        
        // Get all kuis created by this guru
        $kuisList = Kuis::where('dibuat_oleh', $guru->id)
            ->withCount('percobaan')
            ->latest()
            ->get();

        // Get all students with their quiz attempts
        $siswaList = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'siswa');
        })
        ->with(['percobaanKuis' => function($q) use ($guru) {
            $q->whereHas('kuis', function($query) use ($guru) {
                $query->where('dibuat_oleh', $guru->id);
            })
            ->where('status', 'selesai')
            ->latest();
        }])
        ->orderBy('name')
        ->get();

        return view('guru.nilai.index', compact('siswaList', 'kuisList'));
    }

    public function show($siswaId)
    {
        $guru = auth()->user();
        $siswa = User::findOrFail($siswaId);

        // Get all quiz attempts by this student for guru's quizzes
        $percobaan = PercobaanKuis::whereHas('kuis', function($q) use ($guru) {
            $q->where('dibuat_oleh', $guru->id);
        })
        ->where('siswa_id', $siswaId)
        ->where('status', '!=', 'sedang_dikerjakan')
        ->with(['kuis', 'jawaban.soal'])
        ->latest()
        ->get();

        // Group by kuis
        $perKuis = $percobaan->groupBy('kuis_id');

        // Calculate statistics
        $totalPercobaan = $percobaan->count();
        $rataRataNilai = $percobaan->avg('nilai');
        $nilaiTertinggi = $percobaan->max('nilai');
        $nilaiTerendah = $percobaan->min('nilai');
        $jumlahLulus = $percobaan->where('lulus', true)->count();

        return view('guru.nilai.show', compact(
            'siswa', 
            'percobaan', 
            'perKuis',
            'totalPercobaan',
            'rataRataNilai',
            'nilaiTertinggi',
            'nilaiTerendah',
            'jumlahLulus'
        ));
    }

    public function detailPercobaan($percobaanId)
    {
        $guru = auth()->user();
        
        $percobaan = PercobaanKuis::with([
            'kuis.soal.pilihanJawaban',
            'siswa',
            'jawaban.soal.pilihanJawaban',
            'jawaban.pilihanJawaban'
        ])->findOrFail($percobaanId);

        // Verify this quiz belongs to the guru
        if ($percobaan->kuis->dibuat_oleh != $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini');
        }

        return view('guru.nilai.detail', compact('percobaan'));
    }

    public function perKuis($kuisId)
    {
        $guru = auth()->user();
        $kuis = Kuis::where('dibuat_oleh', $guru->id)->findOrFail($kuisId);

        // Get all attempts for this quiz
        $percobaan = PercobaanKuis::where('kuis_id', $kuisId)
            ->where('status', '!=', 'sedang_dikerjakan')
            ->with('siswa')
            ->latest()
            ->get();

        // Group by student
        $perSiswa = $percobaan->groupBy('siswa_id')->map(function($attempts) {
            return [
                'siswa' => $attempts->first()->siswa,
                'percobaan' => $attempts,
                'rata_rata' => $attempts->avg('nilai'),
                'tertinggi' => $attempts->max('nilai'),
                'terendah' => $attempts->min('nilai'),
                'jumlah' => $attempts->count(),
                'lulus' => $attempts->where('lulus', true)->count()
            ];
        });

        // Statistics
        $totalSiswa = $perSiswa->count();
        $rataRataKelas = $percobaan->avg('nilai');
        $nilaiTertinggi = $percobaan->max('nilai');
        $nilaiTerendah = $percobaan->min('nilai');
        $tingkatKelulusan = $percobaan->count() > 0 
            ? ($percobaan->where('lulus', true)->count() / $percobaan->count()) * 100 
            : 0;

        return view('guru.nilai.per-kuis', compact(
            'kuis',
            'percobaan',
            'perSiswa',
            'totalSiswa',
            'rataRataKelas',
            'nilaiTertinggi',
            'nilaiTerendah',
            'tingkatKelulusan'
        ));
    }
}
