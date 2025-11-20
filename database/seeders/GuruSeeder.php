<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Peran;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peranGuru = Peran::where('nama_peran', 'guru')->first();

        $guruList = [
            // Guru Kelas 7
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.guru@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranGuru->id,
                'nomor_induk' => '197001011998031001',
                'kelas_mengajar' => '7',
                'no_telepon' => '081234567801',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1970-01-01',
                'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.guru@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranGuru->id,
                'nomor_induk' => '198505152009032002',
                'kelas_mengajar' => '7',
                'no_telepon' => '081234567802',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1985-05-15',
                'alamat' => 'Jl. Guru No. 2, Jakarta',
                'email_verified_at' => now()
            ],
            
            // Guru Kelas 8
            [
                'name' => 'Ahmad Dahlan',
                'email' => 'ahmad.guru@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranGuru->id,
                'nomor_induk' => '197503201999031003',
                'kelas_mengajar' => '8',
                'no_telepon' => '081234567803',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1975-03-20',
                'alamat' => 'Jl. Pahlawan No. 3, Jakarta',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.guru@example.com',
                'password' => Hash::make('password123'),
                'peran_id' => $peranGuru->id,
                'nomor_induk' => '199008082015032004',
                'kelas_mengajar' => '8',
                'no_telepon' => '081234567804',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1990-08-08',
                'alamat' => 'Jl. Cendekia No. 4, Jakarta',
                'email_verified_at' => now()
            ],
        ];

        foreach ($guruList as $guru) {
            User::create($guru);
        }

        $this->command->info('✓ 4 Guru berhasil ditambahkan (2 Kelas 7, 2 Kelas 8)');
    }
}
