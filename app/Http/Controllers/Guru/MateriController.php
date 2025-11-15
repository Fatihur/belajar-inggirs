<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Kosakata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MateriController extends Controller
{
    public function index()
    {
        $guru = auth()->user();
        $materiList = Materi::where('dibuat_oleh', $guru->id)
            ->withCount('kosakata')
            ->latest()
            ->get();

        return view('guru.materi.index', compact('materiList'));
    }

    public function create()
    {
        return view('guru.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_materi' => 'required|in:vocabulary,grammar',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:51200', // max 50MB
            'urutan' => 'nullable|integer'
        ], [
            'judul.required' => 'Judul materi harus diisi',
            'jenis_materi.required' => 'Jenis materi harus dipilih',
            'video_url.url' => 'Format URL video tidak valid',
            'video_path.mimes' => 'File video harus berformat mp4, avi, atau mov',
            'video_path.max' => 'Ukuran file video maksimal 50MB'
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis_materi' => $request->jenis_materi,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
            'video_url' => $request->video_url,
            'dibuat_oleh' => auth()->id(),
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif')
        ];

        // Upload video jika ada
        if ($request->hasFile('video_path')) {
            $path = $request->file('video_path')->store('videos', 'public');
            $data['video_path'] = $path;
        }

        $materi = Materi::create($data);

        // Jika jenis vocabulary, redirect ke halaman tambah kosakata
        if ($request->jenis_materi == 'vocabulary') {
            return redirect()->route('guru.materi.show', $materi->id)
                ->with('success', 'Materi berhasil ditambahkan. Silakan tambahkan kosakata.');
        }

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil ditambahkan');
    }

    public function show($id)
    {
        $materi = Materi::with('kosakata')->findOrFail($id);
        
        // Pastikan guru hanya bisa melihat materinya sendiri
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        return view('guru.materi.show', compact('materi'));
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        return view('guru.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_materi' => 'required|in:vocabulary,grammar',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:51200',
            'urutan' => 'nullable|integer'
        ]);

        $data = [
            'judul' => $request->judul,
            'jenis_materi' => $request->jenis_materi,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
            'video_url' => $request->video_url,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif')
        ];

        // Upload video baru jika ada
        if ($request->hasFile('video_path')) {
            // Hapus video lama jika ada
            if ($materi->video_path) {
                Storage::disk('public')->delete($materi->video_path);
            }
            $path = $request->file('video_path')->store('videos', 'public');
            $data['video_path'] = $path;
        }

        $materi->update($data);

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        // Hapus video jika ada
        if ($materi->video_path) {
            Storage::disk('public')->delete($materi->video_path);
        }

        // Hapus semua kosakata terkait (cascade)
        $materi->delete();

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil dihapus');
    }

    // Method untuk menambah kosakata
    public function storeKosakata(Request $request, $materiId)
    {
        $materi = Materi::findOrFail($materiId);
        
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        $request->validate([
            'kata_inggris' => 'required|string|max:255',
            'kata_indonesia' => 'required|string|max:255',
            'jenis_kata' => 'nullable|string',
            'contoh_kalimat' => 'nullable|string',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120', // max 5MB
            'gambar_path' => 'nullable|image|max:2048', // max 2MB
            'urutan' => 'nullable|integer'
        ]);

        $data = [
            'materi_id' => $materiId,
            'kata_inggris' => $request->kata_inggris,
            'kata_indonesia' => $request->kata_indonesia,
            'jenis_kata' => $request->jenis_kata,
            'contoh_kalimat' => $request->contoh_kalimat,
            'urutan' => $request->urutan ?? 0
        ];

        // Upload audio jika ada
        if ($request->hasFile('audio_path')) {
            $path = $request->file('audio_path')->store('audio', 'public');
            $data['audio_path'] = $path;
        }

        // Upload gambar jika ada
        if ($request->hasFile('gambar_path')) {
            $path = $request->file('gambar_path')->store('images', 'public');
            $data['gambar_path'] = $path;
        }

        Kosakata::create($data);

        return redirect()->route('guru.materi.show', $materiId)
            ->with('success', 'Kosakata berhasil ditambahkan');
    }

    // Method untuk menghapus kosakata
    public function destroyKosakata($materiId, $kosakatId)
    {
        $materi = Materi::findOrFail($materiId);
        
        if ($materi->dibuat_oleh != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke materi ini');
        }

        $kosakata = Kosakata::findOrFail($kosakatId);

        // Hapus file audio dan gambar jika ada
        if ($kosakata->audio_path) {
            Storage::disk('public')->delete($kosakata->audio_path);
        }
        if ($kosakata->gambar_path) {
            Storage::disk('public')->delete($kosakata->gambar_path);
        }

        $kosakata->delete();

        return redirect()->route('guru.materi.show', $materiId)
            ->with('success', 'Kosakata berhasil dihapus');
    }
}
