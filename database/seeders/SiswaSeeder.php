<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peranSiswa = Peran::where('nama_peran', 'siswa')->first();

        $siswaList = [
            // Siswa Kelas 7
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024070001',
                'kelas' => '7',
                'no_telepon' => '081234560001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2011-01-15',
                'alamat' => 'Jl. Siswa No. 1, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Bella Safira',
                'email' => 'bella.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024070002',
                'kelas' => '7',
                'no_telepon' => '081234560002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2011-02-20',
                'alamat' => 'Jl. Siswa No. 2, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Candra Wijaya',
                'email' => 'candra.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024070003',
                'kelas' => '7',
                'no_telepon' => '081234560003',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2011-03-10',
                'alamat' => 'Jl. Siswa No. 3, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Dina Amelia',
                'email' => 'dina.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024070004',
                'kelas' => '7',
                'no_telepon' => '081234560004',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2011-04-25',
                'alamat' => 'Jl. Siswa No. 4, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024070005',
                'kelas' => '7',
                'no_telepon' => '081234560005',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2011-05-30',
                'alamat' => 'Jl. Siswa No. 5, Jakarta',
                'email_verified_at' => now()
            ],

            // Siswa Kelas 8
            [
                'name' => 'Farah Diba',
                'email' => 'farah.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024080001',
                'kelas' => '8',
                'no_telepon' => '081234560006',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2010-06-12',
                'alamat' => 'Jl. Siswa No. 6, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Gilang Ramadhan',
                'email' => 'gilang.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024080002',
                'kelas' => '8',
                'no_telepon' => '081234560007',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2010-07-18',
                'alamat' => 'Jl. Siswa No. 7, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Hana Pertiwi',
                'email' => 'hana.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024080003',
                'kelas' => '8',
                'no_telepon' => '081234560008',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2010-08-22',
                'alamat' => 'Jl. Siswa No. 8, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Irfan Hakim',
                'email' => 'irfan.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024080004',
                'kelas' => '8',
                'no_telepon' => '081234560009',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2010-09-05',
                'alamat' => 'Jl. Siswa No. 9, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Julia Rahmawati',
                'email' => 'julia.siswa@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranSiswa->id,
                'nomor_induk' => '2024080005',
                'kelas' => '8',
                'no_telepon' => '081234560010',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2010-10-11',
                'alamat' => 'Jl. Siswa No. 10, Jakarta',
                'email_verified_at' => now()
            ],
        ];

        foreach ($siswaList as $siswa) {
            User::create($siswa);
        }

        $this->command->info('✓ 10 Siswa berhasil ditambahkan (5 Kelas 7, 5 Kelas 8)');
    }
}
