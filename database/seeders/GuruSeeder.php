<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
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
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'budi.guru@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranGuru->id,
                    'email_verified_at' => now()
                ],
                'guru' => [
                    'nip' => '197001011998031001',
                    'nama_lengkap' => 'Budi Santoso',
                    'kelas_mengajar' => '7',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '1970-01-01',
                    'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
                    'no_telepon' => '081234567801',
                    'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Inggris',
                    'bidang_studi' => 'Bahasa Inggris'
                ]
            ],
            [
                'user' => [
                    'name' => 'Siti Nurhaliza',
                    'email' => 'siti.guru@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranGuru->id,
                    'email_verified_at' => now()
                ],
                'guru' => [
                    'nip' => '198505152009032002',
                    'nama_lengkap' => 'Siti Nurhaliza',
                    'kelas_mengajar' => '7',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '1985-05-15',
                    'alamat' => 'Jl. Guru No. 2, Jakarta',
                    'no_telepon' => '081234567802',
                    'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Inggris',
                    'bidang_studi' => 'Bahasa Inggris'
                ]
            ],
            
            // Guru Kelas 8
            [
                'user' => [
                    'name' => 'Ahmad Dahlan',
                    'email' => 'ahmad.guru@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranGuru->id,
                    'email_verified_at' => now()
                ],
                'guru' => [
                    'nip' => '197503201999031003',
                    'nama_lengkap' => 'Ahmad Dahlan',
                    'kelas_mengajar' => '8',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '1975-03-20',
                    'alamat' => 'Jl. Pahlawan No. 3, Jakarta',
                    'no_telepon' => '081234567803',
                    'pendidikan_terakhir' => 'S2 Pendidikan Bahasa Inggris',
                    'bidang_studi' => 'Bahasa Inggris'
                ]
            ],
            [
                'user' => [
                    'name' => 'Dewi Lestari',
                    'email' => 'dewi.guru@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranGuru->id,
                    'email_verified_at' => now()
                ],
                'guru' => [
                    'nip' => '199008082015032004',
                    'nama_lengkap' => 'Dewi Lestari',
                    'kelas_mengajar' => '8',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Yogyakarta',
                    'tanggal_lahir' => '1990-08-08',
                    'alamat' => 'Jl. Cendekia No. 4, Jakarta',
                    'no_telepon' => '081234567804',
                    'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Inggris',
                    'bidang_studi' => 'Bahasa Inggris'
                ]
            ],
        ];

        foreach ($guruList as $data) {
            $user = User::create($data['user']);
            
            $guruData = $data['guru'];
            $guruData['user_id'] = $user->id;
            Guru::create($guruData);
        }

        $this->command->info('✓ 4 Guru berhasil ditambahkan (2 Kelas 7, 2 Kelas 8)');
    }
}
