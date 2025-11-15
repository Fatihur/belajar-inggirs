<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $peranSiswa = Peran::where('nama_peran', 'siswa')->first();
        $siswaList = User::where('peran_id', $peranSiswa->id)
            ->latest()
            ->get();

        return view('superadmin.siswa.index', compact('siswaList'));
    }

    public function create()
    {
        return view('superadmin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'kelas' => 'required|string',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nomor_induk.required' => 'NIS harus diisi',
            'nomor_induk.unique' => 'NIS sudah terdaftar',
            'kelas.required' => 'Kelas harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih'
        ]);

        $peranSiswa = Peran::where('nama_peran', 'siswa')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran_id' => $peranSiswa->id,
            'nomor_induk' => $request->nomor_induk,
            'kelas' => $request->kelas,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email_verified_at' => now()
        ]);

        return redirect()->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        return view('superadmin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $id,
            'kelas' => 'required|string',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'kelas' => $request->kelas,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
