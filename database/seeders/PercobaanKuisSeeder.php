<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PercobaanKuis;
use App\Models\JawabanSiswa;
use App\Models\Kuis;
use App\Models\SoalKuis;
use App\Models\PilihanJawaban;
use App\Models\User;
use Carbon\Carbon;

class PercobaanKuisSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil siswa kelas 7 dan 8
        $siswaKelas7 = User::whereHas('peran', fn($q) => $q->where('nama_peran', 'siswa'))
            ->where('kelas', '7')
            ->get();
        
        $siswaKelas8 = User::whereHas('peran', fn($q) => $q->where('nama_peran', 'siswa'))
            ->where('kelas', '8')
            ->get();

        // Ambil kuis
        $kuisSimplePresent = Kuis::where('judul', 'Quiz: Simple Present Tense')->first();
        $kuisDailyActivities = Kuis::where('judul', 'Quiz: Daily Activities Vocabulary')->first();
        $kuisFamily = Kuis::where('judul', 'Quiz: Family Members')->first();
        $kuisMixed = Kuis::where('judul', 'Mixed Grammar Quiz')->first();

        if (!$kuisSimplePresent || !$kuisDailyActivities || !$kuisFamily || !$kuisMixed) {
            $this->command->warn('⚠️  Kuis belum ada. Jalankan KuisSeeder terlebih dahulu.');
            return;
        }

        // Simulasi percobaan untuk siswa kelas 7
        foreach ($siswaKelas7 as $index => $siswa) {
            // Percobaan 1: Simple Present Tense (Selesai - Lulus)
            $this->buatPercobaanSelesai($siswa, $kuisSimplePresent, 85, true);
            
            // Percobaan 2: Daily Activities (Selesai - Lulus)
            $this->buatPercobaanSelesai($siswa, $kuisDailyActivities, 90, true);
            
            // Percobaan 3: Family Members (Selesai - Tidak Lulus untuk siswa pertama)
            if ($index === 0) {
                $this->buatPercobaanSelesai($siswa, $kuisFamily, 60, false);
            } else {
                $this->buatPercobaanSelesai($siswa, $kuisFamily, 80, true);
            }
            
            // Percobaan 4: Mixed Grammar (Sedang dikerjakan untuk siswa kedua)
            if ($index === 1) {
                $this->buatPercobaanSedangDikerjakan($siswa, $kuisMixed);
            }
        }

        // Simulasi percobaan untuk siswa kelas 8
        foreach ($siswaKelas8 as $index => $siswa) {
            // Percobaan 1: Simple Present Tense (Selesai - Lulus)
            $this->buatPercobaanSelesai($siswa, $kuisSimplePresent, 75, true);
            
            // Percobaan 2: Daily Activities (Waktu Habis)
            if ($index === 0) {
                $this->buatPercobaanWaktuHabis($siswa, $kuisDailyActivities);
            } else {
                $this->buatPercobaanSelesai($siswa, $kuisDailyActivities, 85, true);
            }
        }

        $totalPercobaan = PercobaanKuis::count();
        $this->command->info("✓ {$totalPercobaan} Percobaan kuis berhasil ditambahkan");
    }

    private function buatPercobaanSelesai($siswa, $kuis, $nilai, $lulus)
    {
        $soalKuis = SoalKuis::where('kuis_id', $kuis->id)->get();
        $totalSoal = $soalKuis->count();
        
        // Hitung jumlah benar berdasarkan nilai
        $jumlahBenar = round(($nilai / 100) * $totalSoal);
        $jumlahSalah = $totalSoal - $jumlahBenar;

        $waktuMulai = Carbon::now()->subDays(rand(1, 7))->subHours(rand(1, 3));
        $waktuSelesai = $waktuMulai->copy()->addMinutes(rand(5, $kuis->durasi_menit));

        $percobaan = PercobaanKuis::create([
            'kuis_id' => $kuis->id,
            'siswa_id' => $siswa->id,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'nilai' => $nilai,
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah,
            'total_soal' => $totalSoal,
            'status' => 'selesai',
            'lulus' => $lulus
        ]);

        // Buat jawaban siswa
        $soalDijawabBenar = $soalKuis->random($jumlahBenar);
        
        foreach ($soalKuis as $soal) {
            $benar = $soalDijawabBenar->contains($soal);
            $pilihanJawaban = PilihanJawaban::where('soal_id', $soal->id)->get();
            
            if ($benar) {
                // Pilih jawaban yang benar
                $jawaban = $pilihanJawaban->where('jawaban_benar', true)->first();
            } else {
                // Pilih jawaban yang salah
                $jawabanSalah = $pilihanJawaban->where('jawaban_benar', false);
                $jawaban = $jawabanSalah->isNotEmpty() ? $jawabanSalah->random() : $pilihanJawaban->first();
            }

            JawabanSiswa::create([
                'percobaan_id' => $percobaan->id,
                'soal_id' => $soal->id,
                'pilihan_jawaban_id' => $jawaban->id,
                'benar' => $benar,
                'poin_didapat' => $benar ? $soal->poin : 0
            ]);
        }
    }

    private function buatPercobaanSedangDikerjakan($siswa, $kuis)
    {
        $soalKuis = SoalKuis::where('kuis_id', $kuis->id)->get();
        $totalSoal = $soalKuis->count();
        
        $waktuMulai = Carbon::now()->subMinutes(rand(5, 10));

        $percobaan = PercobaanKuis::create([
            'kuis_id' => $kuis->id,
            'siswa_id' => $siswa->id,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => null,
            'nilai' => null,
            'jumlah_benar' => 0,
            'jumlah_salah' => 0,
            'total_soal' => $totalSoal,
            'status' => 'sedang_dikerjakan',
            'lulus' => false
        ]);

        // Jawab beberapa soal saja (50%)
        $soalDijawab = $soalKuis->random(ceil($totalSoal / 2));
        
        foreach ($soalDijawab as $soal) {
            $pilihanJawaban = PilihanJawaban::where('soal_id', $soal->id)->inRandomOrder()->first();
            
            JawabanSiswa::create([
                'percobaan_id' => $percobaan->id,
                'soal_id' => $soal->id,
                'pilihan_jawaban_id' => $pilihanJawaban->id,
                'benar' => $pilihanJawaban->jawaban_benar,
                'poin_didapat' => $pilihanJawaban->jawaban_benar ? $soal->poin : 0
            ]);
        }
    }

    private function buatPercobaanWaktuHabis($siswa, $kuis)
    {
        $soalKuis = SoalKuis::where('kuis_id', $kuis->id)->get();
        $totalSoal = $soalKuis->count();
        
        $waktuMulai = Carbon::now()->subDays(rand(1, 3))->subHours(rand(1, 2));
        $waktuSelesai = $waktuMulai->copy()->addMinutes($kuis->durasi_menit + 1);

        // Hitung nilai berdasarkan soal yang dijawab
        $soalDijawab = $soalKuis->random(ceil($totalSoal * 0.7)); // 70% soal dijawab
        $jumlahBenar = ceil($soalDijawab->count() * 0.5); // 50% benar
        $jumlahSalah = $soalDijawab->count() - $jumlahBenar;
        $nilai = round(($jumlahBenar / $totalSoal) * 100);

        $percobaan = PercobaanKuis::create([
            'kuis_id' => $kuis->id,
            'siswa_id' => $siswa->id,
            'waktu_mulai' => $waktuMulai,
            'waktu_selesai' => $waktuSelesai,
            'nilai' => $nilai,
            'jumlah_benar' => $jumlahBenar,
            'jumlah_salah' => $jumlahSalah,
            'total_soal' => $totalSoal,
            'status' => 'waktu_habis',
            'lulus' => false
        ]);

        // Buat jawaban untuk soal yang dijawab
        $soalDijawabBenar = $soalDijawab->random($jumlahBenar);
        
        foreach ($soalDijawab as $soal) {
            $benar = $soalDijawabBenar->contains($soal);
            $pilihanJawaban = PilihanJawaban::where('soal_id', $soal->id)->get();
            
            if ($benar) {
                $jawaban = $pilihanJawaban->where('jawaban_benar', true)->first();
            } else {
                $jawabanSalah = $pilihanJawaban->where('jawaban_benar', false);
                $jawaban = $jawabanSalah->isNotEmpty() ? $jawabanSalah->random() : $pilihanJawaban->first();
            }

            JawabanSiswa::create([
                'percobaan_id' => $percobaan->id,
                'soal_id' => $soal->id,
                'pilihan_jawaban_id' => $jawaban->id,
                'benar' => $benar,
                'poin_didapat' => $benar ? $soal->poin : 0
            ]);
        }
    }
}
