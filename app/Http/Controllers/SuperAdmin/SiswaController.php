<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $peranSiswa = Peran::where('nama_peran', 'siswa')->first();
        $siswaList = User::with('siswa')
            ->where('peran_id', $peranSiswa->id)
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
            'nis' => 'required|string|unique:siswa,nis',
            'kelas' => 'required|in:7,8',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string',
            'no_telepon_orang_tua' => 'nullable|string'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nis.required' => 'NIS harus diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'kelas.required' => 'Kelas harus dipilih',
            'kelas.in' => 'Kelas harus 7 atau 8',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih'
        ]);

        try {
            DB::beginTransaction();

            $peranSiswa = Peran::where('nama_peran', 'siswa')->first();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran_id' => $peranSiswa->id,
                'email_verified_at' => now()
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'nama_lengkap' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_telepon_orang_tua' => $request->no_telepon_orang_tua,
            ]);

            DB::commit();

            return redirect()->route('superadmin.siswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    public function edit($id)
    {
        $siswa = User::with('siswa')->findOrFail($id);
        return view('superadmin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('siswa')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'nis' => 'required|string|unique:siswa,nis,' . ($user->siswa->id ?? 0),
            'kelas' => 'required|in:7,8',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_orang_tua' => 'nullable|string',
            'no_telepon_orang_tua' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $siswaData = [
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'nama_lengkap' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_telepon_orang_tua' => $request->no_telepon_orang_tua,
            ];

            if ($user->siswa) {
                $user->siswa->update($siswaData);
            } else {
                $siswaData['user_id'] = $user->id;
                Siswa::create($siswaData);
            }

            DB::commit();

            return redirect()->route('superadmin.siswa.index')
                ->with('success', 'Data siswa berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('superadmin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
