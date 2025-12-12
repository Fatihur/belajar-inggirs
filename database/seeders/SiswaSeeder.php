<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
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
                'user' => [
                    'name' => 'Andi Pratama',
                    'email' => 'andi.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024070001',
                    'kelas' => '7',
                    'nama_lengkap' => 'Andi Pratama',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2011-01-15',
                    'alamat' => 'Jl. Siswa No. 1, Jakarta',
                    'no_telepon' => '081234560001',
                    'nama_orang_tua' => 'Bapak Pratama',
                    'no_telepon_orang_tua' => '081234570001'
                ]
            ],
            [
                'user' => [
                    'name' => 'Bella Safira',
                    'email' => 'bella.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024070002',
                    'kelas' => '7',
                    'nama_lengkap' => 'Bella Safira',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '2011-02-20',
                    'alamat' => 'Jl. Siswa No. 2, Jakarta',
                    'no_telepon' => '081234560002',
                    'nama_orang_tua' => 'Ibu Safira',
                    'no_telepon_orang_tua' => '081234570002'
                ]
            ],
            [
                'user' => [
                    'name' => 'Candra Wijaya',
                    'email' => 'candra.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024070003',
                    'kelas' => '7',
                    'nama_lengkap' => 'Candra Wijaya',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '2011-03-10',
                    'alamat' => 'Jl. Siswa No. 3, Jakarta',
                    'no_telepon' => '081234560003',
                    'nama_orang_tua' => 'Bapak Wijaya',
                    'no_telepon_orang_tua' => '081234570003'
                ]
            ],
            [
                'user' => [
                    'name' => 'Dina Amelia',
                    'email' => 'dina.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024070004',
                    'kelas' => '7',
                    'nama_lengkap' => 'Dina Amelia',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Yogyakarta',
                    'tanggal_lahir' => '2011-04-25',
                    'alamat' => 'Jl. Siswa No. 4, Jakarta',
                    'no_telepon' => '081234560004',
                    'nama_orang_tua' => 'Ibu Amelia',
                    'no_telepon_orang_tua' => '081234570004'
                ]
            ],
            [
                'user' => [
                    'name' => 'Eko Prasetyo',
                    'email' => 'eko.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024070005',
                    'kelas' => '7',
                    'nama_lengkap' => 'Eko Prasetyo',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Semarang',
                    'tanggal_lahir' => '2011-05-30',
                    'alamat' => 'Jl. Siswa No. 5, Jakarta',
                    'no_telepon' => '081234560005',
                    'nama_orang_tua' => 'Bapak Prasetyo',
                    'no_telepon_orang_tua' => '081234570005'
                ]
            ],

            // Siswa Kelas 8
            [
                'user' => [
                    'name' => 'Farah Diba',
                    'email' => 'farah.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024080001',
                    'kelas' => '8',
                    'nama_lengkap' => 'Farah Diba',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2010-06-12',
                    'alamat' => 'Jl. Siswa No. 6, Jakarta',
                    'no_telepon' => '081234560006',
                    'nama_orang_tua' => 'Ibu Diba',
                    'no_telepon_orang_tua' => '081234570006'
                ]
            ],
            [
                'user' => [
                    'name' => 'Gilang Ramadhan',
                    'email' => 'gilang.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024080002',
                    'kelas' => '8',
                    'nama_lengkap' => 'Gilang Ramadhan',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '2010-07-18',
                    'alamat' => 'Jl. Siswa No. 7, Jakarta',
                    'no_telepon' => '081234560007',
                    'nama_orang_tua' => 'Bapak Ramadhan',
                    'no_telepon_orang_tua' => '081234570007'
                ]
            ],
            [
                'user' => [
                    'name' => 'Hana Pertiwi',
                    'email' => 'hana.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024080003',
                    'kelas' => '8',
                    'nama_lengkap' => 'Hana Pertiwi',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Surabaya',
                    'tanggal_lahir' => '2010-08-22',
                    'alamat' => 'Jl. Siswa No. 8, Jakarta',
                    'no_telepon' => '081234560008',
                    'nama_orang_tua' => 'Ibu Pertiwi',
                    'no_telepon_orang_tua' => '081234570008'
                ]
            ],
            [
                'user' => [
                    'name' => 'Irfan Hakim',
                    'email' => 'irfan.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024080004',
                    'kelas' => '8',
                    'nama_lengkap' => 'Irfan Hakim',
                    'jenis_kelamin' => 'L',
                    'tempat_lahir' => 'Yogyakarta',
                    'tanggal_lahir' => '2010-09-05',
                    'alamat' => 'Jl. Siswa No. 9, Jakarta',
                    'no_telepon' => '081234560009',
                    'nama_orang_tua' => 'Bapak Hakim',
                    'no_telepon_orang_tua' => '081234570009'
                ]
            ],
            [
                'user' => [
                    'name' => 'Julia Rahmawati',
                    'email' => 'julia.siswa@example.com',
                    'password' => Hash::make('password123'),
                    'peran_id' => $peranSiswa->id,
                    'email_verified_at' => now()
                ],
                'siswa' => [
                    'nis' => '2024080005',
                    'kelas' => '8',
                    'nama_lengkap' => 'Julia Rahmawati',
                    'jenis_kelamin' => 'P',
                    'tempat_lahir' => 'Semarang',
                    'tanggal_lahir' => '2010-10-11',
                    'alamat' => 'Jl. Siswa No. 10, Jakarta',
                    'no_telepon' => '081234560010',
                    'nama_orang_tua' => 'Ibu Rahmawati',
                    'no_telepon_orang_tua' => '081234570010'
                ]
            ],
        ];

        foreach ($siswaList as $data) {
            $user = User::create($data['user']);
            
            $siswaData = $data['siswa'];
            $siswaData['user_id'] = $user->id;
            Siswa::create($siswaData);
        }

        $this->command->info('✓ 10 Siswa berhasil ditambahkan (5 Kelas 7, 5 Kelas 8)');
    }
}
