<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $peranGuru = Peran::where('nama_peran', 'guru')->first();
        $guruList = User::where('peran_id', $peranGuru->id)
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
            'nomor_induk' => 'required|string|unique:users,nomor_induk',
            'kelas_mengajar' => 'required|in:7,8',
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
            'nomor_induk.required' => 'NIP harus diisi',
            'nomor_induk.unique' => 'NIP sudah terdaftar',
            'kelas_mengajar.required' => 'Kelas mengajar harus dipilih',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih'
        ]);

        $peranGuru = Peran::where('nama_peran', 'guru')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran_id' => $peranGuru->id,
            'nomor_induk' => $request->nomor_induk,
            'kelas_mengajar' => $request->kelas_mengajar,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email_verified_at' => now()
        ]);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = User::findOrFail($id);
        return view('superadmin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $id,
            'kelas_mengajar' => 'required|in:7,8',
            'no_telepon' => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'kelas_mengajar' => $request->kelas_mengajar,
            'no_telepon' => $request->no_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('superadmin.guru.index')
            ->with('success', 'Data guru berhasil dihapus');
    }
}
