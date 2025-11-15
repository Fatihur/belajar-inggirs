<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PeranSeeder extends Seeder
{
    public function run(): void
    {
        // Buat peran
        $superAdmin = Peran::create([
            'nama_peran' => 'super_admin',
            'deskripsi' => 'Super Administrator dengan akses penuh'
        ]);

        $guru = Peran::create([
            'nama_peran' => 'guru',
            'deskripsi' => 'Guru yang mengelola materi dan kuis'
        ]);

        $siswa = Peran::create([
            'nama_peran' => 'siswa',
            'deskripsi' => 'Siswa yang mengakses materi dan mengerjakan kuis'
        ]);

        // Buat user default
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@belajaringgris.com',
            'password' => Hash::make('admin123'),
            'peran_id' => $superAdmin->id,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@belajaringgris.com',
            'password' => Hash::make('guru123'),
            'peran_id' => $guru->id,
            'nomor_induk' => '198501012010011001',
            'no_telepon' => '081234567890',
            'jenis_kelamin' => 'L',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@belajaringgris.com',
            'password' => Hash::make('siswa123'),
            'peran_id' => $siswa->id,
            'nomor_induk' => '2024001',
            'kelas' => 'X-A',
            'no_telepon' => '081234567891',
            'jenis_kelamin' => 'P',
            'email_verified_at' => now()
        ]);
    }
}
