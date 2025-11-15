<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\PercobaanKuis;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KuisController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user();
        $query = Kuis::where('aktif', true)->with('materi')->withCount('soal');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by materi
        if ($request->filled('materi_id')) {
            $query->where('materi_id', $request->materi_id);
        }

        // Filter by tingkat_kesulitan
        if ($request->filled('tingkat_kesulitan')) {
            $query->where('tingkat_kesulitan', $request->tingkat_kesulitan);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $kuisList = $query->paginate($perPage)->withQueryString();

        // Ambil percobaan siswa untuk setiap kuis
        foreach ($kuisList as $kuis) {
            $kuis->percobaan_siswa = PercobaanKuis::where('kuis_id', $kuis->id)
                ->where('siswa_id', $siswa->id)
                ->latest()
                ->first();
        }

        // Get materi list for filter
        $materiList = Materi::where('aktif', true)
            ->orderBy('judul')
            ->get();

        return view('siswa.kuis.index', compact('kuisList', 'materiList'));
    }

    public function show($id)
    {
        $kuis = Kuis::with(['materi', 'soal'])->findOrFail($id);
        
        if (!$kuis->aktif) {
            abort(404, 'Kuis tidak ditemukan');
        }

        $siswa = auth()->user();
        
        // Cek apakah ada percobaan yang sedang berlangsung
        $percobaanAktif = PercobaanKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sedang_dikerjakan')
            ->first();

        // Ambil riwayat percobaan
        $riwayatPercobaan = PercobaanKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', '!=', 'sedang_dikerjakan')
            ->latest()
            ->get();

        return view('siswa.kuis.show', compact('kuis', 'percobaanAktif', 'riwayatPercobaan'));
    }

    public function mulai(Request $request, $id)
    {
        $kuis = Kuis::with('soal.pilihanJawaban')->findOrFail($id);
        
        if (!$kuis->aktif) {
            return back()->with('error', 'Kuis tidak tersedia');
        }

        $siswa = auth()->user();

        // Cek apakah sudah ada percobaan yang sedang berlangsung
        $percobaanAktif = PercobaanKuis::where('kuis_id', $kuis->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', 'sedang_dikerjakan')
            ->first();

        if ($percobaanAktif) {
            return redirect()->route('siswa.kuis.mengerjakan', $percobaanAktif->id);
        }

        // Buat percobaan baru
        $percobaan = PercobaanKuis::create([
            'kuis_id' => $kuis->id,
            'siswa_id' => $siswa->id,
            'waktu_mulai' => now(),
            'total_soal' => $kuis->soal->count(),
            'status' => 'sedang_dikerjakan'
        ]);

        return redirect()->route('siswa.kuis.mengerjakan', $percobaan->id);
    }

    public function mengerjakan($percobaanId)
    {
        $percobaan = PercobaanKuis::with(['kuis.soal.pilihanJawaban', 'jawaban'])
            ->findOrFail($percobaanId);

        // Pastikan percobaan milik siswa yang login
        if ($percobaan->siswa_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        // Cek apakah sudah selesai
        if ($percobaan->status != 'sedang_dikerjakan') {
            return redirect()->route('siswa.kuis.hasil', $percobaan->id);
        }

        $kuis = $percobaan->kuis;
        
        // Acak soal jika diatur
        $soalList = $kuis->acak_soal 
            ? $kuis->soal->shuffle() 
            : $kuis->soal->sortBy('urutan');

        // Hitung waktu tersisa
        $waktuMulai = Carbon::parse($percobaan->waktu_mulai);
        $waktuSekarang = now();
        $waktuTerpakai = $waktuMulai->diffInMinutes($waktuSekarang);
        $waktuTersisa = max(0, $kuis->durasi_menit - $waktuTerpakai);

        // Jika waktu habis, otomatis submit
        if ($waktuTersisa <= 0) {
            return $this->autoSubmit($percobaan);
        }

        return view('siswa.kuis.mengerjakan', compact('percobaan', 'kuis', 'soalList', 'waktuTersisa'));
    }

    public function submit(Request $request, $percobaanId)
    {
        $percobaan = PercobaanKuis::with('kuis.soal.pilihanJawaban')->findOrFail($percobaanId);

        // Pastikan percobaan milik siswa yang login
        if ($percobaan->siswa_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        // Cek apakah sudah selesai
        if ($percobaan->status != 'sedang_dikerjakan') {
            return redirect()->route('siswa.kuis.hasil', $percobaan->id);
        }

        $kuis = $percobaan->kuis;
        $jawaban = $request->input('jawaban', []);

        $jumlahBenar = 0;
        $jumlahSalah = 0;
        $totalPoin = 0;
        $poinDidapat = 0;

        // Proses setiap jawaban
        foreach ($kuis->soal as $soal) {
            $totalPoin += $soal->poin;
            $jawabanSiswa = $jawaban[$soal->id] ?? null;
            $benar = false;
            $poinSoal = 0;

            if ($soal->jenis_soal == 'isian') {
                // Untuk soal isian, simpan jawaban text
                JawabanSiswa::create([
                    'percobaan_id' => $percobaan->id,
                    'soal_id' => $soal->id,
                    'jawaban_isian' => $jawabanSiswa,
                    'benar' => false, // Perlu dikoreksi manual
                    'poin_didapat' => 0
                ]);
            } else {
                // Untuk pilihan ganda dan benar/salah
                if ($jawabanSiswa) {
                    $pilihanBenar = $soal->pilihanJawaban->where('jawaban_benar', true)->first();
                    
                    if ($pilihanBenar && $jawabanSiswa == $pilihanBenar->id) {
                        $benar = true;
                        $poinSoal = $soal->poin;
                        $jumlahBenar++;
                        $poinDidapat += $poinSoal;
                    } else {
                        $jumlahSalah++;
                    }

                    JawabanSiswa::create([
                        'percobaan_id' => $percobaan->id,
                        'soal_id' => $soal->id,
                        'pilihan_jawaban_id' => $jawabanSiswa,
                        'benar' => $benar,
                        'poin_didapat' => $poinSoal
                    ]);
                } else {
                    $jumlahSalah++;
                }
            }
        }

        // Hitung nilai (skala 0-100)
        $nilai = $totalPoin > 0 ? round(($poinDidapat / $totalPoin) * 100) : 0;
        $lulus = $nilai >= $kuis->nilai_minimal;

        // Update percobaan
        $percobaan->update([
            'waktu_selesai' => now(),
            'nilai' => $nilai,
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah,
            'status' => 'selesai',
            'lulus' => $lulus
        ]);

        return redirect()->route('siswa.kuis.hasil', $percobaan->id)
            ->with('success', 'Kuis berhasil diselesaikan!');
    }

    private function autoSubmit($percobaan)
    {
        $percobaan->update([
            'waktu_selesai' => now(),
            'nilai' => 0,
            'status' => 'waktu_habis',
            'lulus' => false
        ]);

        return redirect()->route('siswa.kuis.hasil', $percobaan->id)
            ->with('warning', 'Waktu habis! Kuis otomatis diselesaikan.');
    }

    public function hasil($percobaanId)
    {
        $percobaan = PercobaanKuis::with([
            'kuis.soal.pilihanJawaban',
            'jawaban.soal.pilihanJawaban',
            'jawaban.pilihanJawaban'
        ])->findOrFail($percobaanId);

        // Pastikan percobaan milik siswa yang login
        if ($percobaan->siswa_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke hasil kuis ini');
        }

        $kuis = $percobaan->kuis;

        return view('siswa.kuis.hasil', compact('percobaan', 'kuis'));
    }
}
