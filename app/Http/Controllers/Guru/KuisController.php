<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\SoalKuis;
use App\Models\PilihanJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KuisController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $kuisList = Kuis::where('dibuat_oleh', $guru->id)
            ->with('materi')
            ->withCount(['soal', 'percobaan'])
            ->latest()
            ->get();

        return view('guru.kuis.index', compact('kuisList'));
    }

    public function create()
    {
        $guru = auth()->user();
        $materiList = Materi::where('dibuat_oleh', $guru->id)
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get();

        return view('guru.kuis.create', compact('materiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'materi_id' => 'nullable|exists:materi,id',
            'durasi_menit' => 'required|integer|min:1',
            'nilai_minimal' => 'required|integer|min:0|max:100',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit'
        ], [
            'judul.required' => 'Judul kuis harus diisi',
            'durasi_menit.required' => 'Durasi harus diisi',
            'durasi_menit.min' => 'Durasi minimal 1 menit',
            'nilai_minimal.required' => 'Nilai minimal harus diisi',
            'nilai_minimal.max' => 'Nilai minimal maksimal 100',
            'tingkat_kesulitan.required' => 'Tingkat kesulitan harus dipilih'
        ]);

        $guru = auth()->user();
        
        $kuis = Kuis::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'materi_id' => $request->materi_id,
            'durasi_menit' => $request->durasi_menit,
            'nilai_minimal' => $request->nilai_minimal,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
            'dibuat_oleh' => $guru->id,
            'kelas_target' => $guru->kelas_mengajar,
            'aktif' => $request->has('aktif'),
            'acak_soal' => $request->has('acak_soal'),
            'tampilkan_jawaban' => $request->has('tampilkan_jawaban')
        ]);

        return redirect()->route('guru.kuis.show', $kuis->id)
            ->with('success', 'Kuis berhasil ditambahkan. Silakan tambahkan soal.');
    }

    public function show($id)
    {
        $kuis = Kuis::with(['soal.pilihanJawaban', 'materi'])->findOrFail($id);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        // Hitung statistik
        $totalPoin = $kuis->soal->sum('poin');
        $jumlahSoal = $kuis->soal->count();

        return view('guru.kuis.show', compact('kuis', 'totalPoin', 'jumlahSoal'));
    }

    public function edit($id)
    {
        $kuis = Kuis::findOrFail($id);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        $guru = auth()->user();
        $materiList = Materi::where('dibuat_oleh', $guru->id)
            ->where('aktif', true)
            ->orderBy('urutan')
            ->get();

        return view('guru.kuis.edit', compact('kuis', 'materiList'));
    }

    public function update(Request $request, $id)
    {
        $kuis = Kuis::findOrFail($id);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'materi_id' => 'nullable|exists:materi,id',
            'durasi_menit' => 'required|integer|min:1',
            'nilai_minimal' => 'required|integer|min:0|max:100',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit'
        ]);

        $guru = auth()->user();
        
        $kuis->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'materi_id' => $request->materi_id,
            'durasi_menit' => $request->durasi_menit,
            'nilai_minimal' => $request->nilai_minimal,
            'tingkat_kesulitan' => $request->tingkat_kesulitan,
            'kelas_target' => $guru->kelas_mengajar,
            'aktif' => $request->has('aktif'),
            'acak_soal' => $request->has('acak_soal'),
            'tampilkan_jawaban' => $request->has('tampilkan_jawaban')
        ]);

        return redirect()->route('guru.kuis.index')
            ->with('success', 'Kuis berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kuis = Kuis::findOrFail($id);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        // Hapus semua file media dari soal
        foreach ($kuis->soal as $soal) {
            if ($soal->gambar_path) {
                Storage::disk('public')->delete($soal->gambar_path);
            }
            if ($soal->audio_path) {
                Storage::disk('public')->delete($soal->audio_path);
            }
        }

        $kuis->delete();

        return redirect()->route('guru.kuis.index')
            ->with('success', 'Kuis berhasil dihapus');
    }

    // Method untuk menambah soal
    public function storeSoal(Request $request, $kuisId)
    {
        $kuis = Kuis::findOrFail($kuisId);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        $request->validate([
            'pertanyaan' => 'required|string',
            'jenis_soal' => 'required|in:pilihan_ganda,benar_salah,isian',
            'gambar_path' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'poin' => 'required|integer|min:1',
            'urutan' => 'nullable|integer',
            'pilihan.*' => 'required_if:jenis_soal,pilihan_ganda,benar_salah',
            'jawaban_benar' => 'required_if:jenis_soal,pilihan_ganda,benar_salah'
        ]);

        $data = [
            'kuis_id' => $kuisId,
            'pertanyaan' => $request->pertanyaan,
            'jenis_soal' => $request->jenis_soal,
            'poin' => $request->poin,
            'urutan' => $request->urutan ?? 0
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar_path')) {
            $path = $request->file('gambar_path')->store('soal/images', 'public');
            $data['gambar_path'] = $path;
        }

        // Upload audio jika ada
        if ($request->hasFile('audio_path')) {
            $path = $request->file('audio_path')->store('soal/audio', 'public');
            $data['audio_path'] = $path;
        }

        $soal = SoalKuis::create($data);

        // Tambahkan pilihan jawaban jika pilihan ganda atau benar salah
        if (in_array($request->jenis_soal, ['pilihan_ganda', 'benar_salah'])) {
            foreach ($request->pilihan as $index => $teks) {
                if (!empty($teks)) {
                    PilihanJawaban::create([
                        'soal_id' => $soal->id,
                        'teks_jawaban' => $teks,
                        'jawaban_benar' => ($index == $request->jawaban_benar),
                        'urutan' => $index
                    ]);
                }
            }
        }

        return redirect()->route('guru.kuis.show', $kuisId)
            ->with('success', 'Soal berhasil ditambahkan');
    }

    // Method untuk menghapus soal
    public function destroySoal($kuisId, $soalId)
    {
        $kuis = Kuis::findOrFail($kuisId);
        
        if ($kuis->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke kuis ini');
        }

        $soal = SoalKuis::findOrFail($soalId);

        // Hapus file media jika ada
        if ($soal->gambar_path) {
            Storage::disk('public')->delete($soal->gambar_path);
        }
        if ($soal->audio_path) {
            Storage::disk('public')->delete($soal->audio_path);
        }

        $soal->delete();

        return redirect()->route('guru.kuis.show', $kuisId)
            ->with('success', 'Soal berhasil dihapus');
    }
}
