<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $peranGuru = Peran::where('nama_peran', 'guru')->first();
        $guruList = User::with('guru')
            ->where('peran_id', $peranGuru->id)
            ->latest()
            ->get();

        return view('superadmin.guru.index', compact('guruList'));
    }

    public function create()
    {
        return view('superadmin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nip' => 'required|string|unique:guru,nip',
            'kelas_mengajar' => 'required|in:7,8',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'bidang_studi' => 'nullable|string'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'kelas_mengajar.required' => 'Kelas mengajar harus dipilih',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih'
        ]);

        try {
            DB::beginTransaction();

            $peranGuru = Peran::where('nama_peran', 'guru')->first();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran_id' => $peranGuru->id,
                'email_verified_at' => now()
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama_lengkap' => $request->name,
                'kelas_mengajar' => $request->kelas_mengajar,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'bidang_studi' => $request->bidang_studi,
            ]);

            DB::commit();

            return redirect()->route('superadmin.guru.index')
                ->with('success', 'Data guru berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    public function edit($id)
    {
        $guru = User::with('guru')->findOrFail($id);
        return view('superadmin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('guru')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'nip' => 'required|string|unique:guru,nip,' . ($user->guru->id ?? 0),
            'kelas_mengajar' => 'required|in:7,8',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'bidang_studi' => 'nullable|string'
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

            $guruData = [
                'nip' => $request->nip,
                'nama_lengkap' => $request->name,
                'kelas_mengajar' => $request->kelas_mengajar,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'bidang_studi' => $request->bidang_studi,
            ];

            if ($user->guru) {
                $user->guru->update($guruData);
            } else {
                $guruData['user_id'] = $user->id;
                Guru::create($guruData);
            }

            DB::commit();

            return redirect()->route('superadmin.guru.index')
                ->with('success', 'Data guru berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil dihapus');
    }
}
