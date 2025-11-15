<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuis;
use App\Models\SoalKuis;
use App\Models\PilihanJawaban;
use App\Models\Materi;
use App\Models\User;

class KuisSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil guru dan materi
        $guru = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'guru');
        })->first();

        $materiSimplePresent = Materi::where('judul', 'Simple Present Tense')->first();
        $materiDailyActivities = Materi::where('judul', 'Daily Activities (Kegiatan Sehari-hari)')->first();
        $materiFamilyMembers = Materi::where('judul', 'Family Members (Anggota Keluarga)')->first();

        // Kuis 1: Simple Present Tense
        $kuis1 = Kuis::create([
            'judul' => 'Quiz: Simple Present Tense',
            'deskripsi' => 'Uji pemahaman Anda tentang Simple Present Tense',
            'materi_id' => $materiSimplePresent->id,
            'durasi_menit' => 15,
            'nilai_minimal' => 70,
            'tingkat_kesulitan' => 'mudah',
            'dibuat_oleh' => $guru->id,
            'aktif' => true,
            'acak_soal' => true,
            'tampilkan_jawaban' => true
        ]);

        // Soal 1
        $soal1 = SoalKuis::create([
            'kuis_id' => $kuis1->id,
            'pertanyaan' => 'She ... to school every day.',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 1
        ]);

        PilihanJawaban::create(['soal_id' => $soal1->id, 'teks_jawaban' => 'go', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal1->id, 'teks_jawaban' => 'goes', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal1->id, 'teks_jawaban' => 'going', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal1->id, 'teks_jawaban' => 'gone', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 2
        $soal2 = SoalKuis::create([
            'kuis_id' => $kuis1->id,
            'pertanyaan' => 'They ... football every Sunday.',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 2
        ]);

        PilihanJawaban::create(['soal_id' => $soal2->id, 'teks_jawaban' => 'plays', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal2->id, 'teks_jawaban' => 'play', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal2->id, 'teks_jawaban' => 'playing', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal2->id, 'teks_jawaban' => 'played', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 3
        $soal3 = SoalKuis::create([
            'kuis_id' => $kuis1->id,
            'pertanyaan' => 'My father ... not drink coffee.',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 3
        ]);

        PilihanJawaban::create(['soal_id' => $soal3->id, 'teks_jawaban' => 'do', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal3->id, 'teks_jawaban' => 'does', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal3->id, 'teks_jawaban' => 'is', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal3->id, 'teks_jawaban' => 'are', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 4
        $soal4 = SoalKuis::create([
            'kuis_id' => $kuis1->id,
            'pertanyaan' => '... you like pizza?',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 4
        ]);

        PilihanJawaban::create(['soal_id' => $soal4->id, 'teks_jawaban' => 'Does', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal4->id, 'teks_jawaban' => 'Do', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal4->id, 'teks_jawaban' => 'Is', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal4->id, 'teks_jawaban' => 'Are', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 5
        $soal5 = SoalKuis::create([
            'kuis_id' => $kuis1->id,
            'pertanyaan' => 'The sun rises in the east.',
            'jenis_soal' => 'benar_salah',
            'poin' => 10,
            'urutan' => 5
        ]);

        PilihanJawaban::create(['soal_id' => $soal5->id, 'teks_jawaban' => 'Benar', 'jawaban_benar' => true, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal5->id, 'teks_jawaban' => 'Salah', 'jawaban_benar' => false, 'urutan' => 1]);

        // Kuis 2: Daily Activities Vocabulary
        $kuis2 = Kuis::create([
            'judul' => 'Quiz: Daily Activities Vocabulary',
            'deskripsi' => 'Uji pengetahuan kosakata kegiatan sehari-hari',
            'materi_id' => $materiDailyActivities->id,
            'durasi_menit' => 10,
            'nilai_minimal' => 70,
            'tingkat_kesulitan' => 'mudah',
            'dibuat_oleh' => $guru->id,
            'aktif' => true,
            'acak_soal' => true,
            'tampilkan_jawaban' => true
        ]);

        // Soal 1
        $soal6 = SoalKuis::create([
            'kuis_id' => $kuis2->id,
            'pertanyaan' => 'What is the meaning of "wake up"?',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 1
        ]);

        PilihanJawaban::create(['soal_id' => $soal6->id, 'teks_jawaban' => 'tidur', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal6->id, 'teks_jawaban' => 'bangun tidur', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal6->id, 'teks_jawaban' => 'mandi', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal6->id, 'teks_jawaban' => 'sarapan', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 2
        $soal7 = SoalKuis::create([
            'kuis_id' => $kuis2->id,
            'pertanyaan' => 'Apa bahasa Inggris dari "mengerjakan PR"?',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 2
        ]);

        PilihanJawaban::create(['soal_id' => $soal7->id, 'teks_jawaban' => 'do homework', 'jawaban_benar' => true, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal7->id, 'teks_jawaban' => 'go to school', 'jawaban_benar' => false, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal7->id, 'teks_jawaban' => 'study', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal7->id, 'teks_jawaban' => 'watch TV', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 3
        $soal8 = SoalKuis::create([
            'kuis_id' => $kuis2->id,
            'pertanyaan' => '"Have breakfast" means eating in the morning.',
            'jenis_soal' => 'benar_salah',
            'poin' => 10,
            'urutan' => 3
        ]);

        PilihanJawaban::create(['soal_id' => $soal8->id, 'teks_jawaban' => 'Benar', 'jawaban_benar' => true, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal8->id, 'teks_jawaban' => 'Salah', 'jawaban_benar' => false, 'urutan' => 1]);

        // Kuis 3: Family Members
        $kuis3 = Kuis::create([
            'judul' => 'Quiz: Family Members',
            'deskripsi' => 'Uji pengetahuan tentang anggota keluarga',
            'materi_id' => $materiFamilyMembers->id,
            'durasi_menit' => 10,
            'nilai_minimal' => 70,
            'tingkat_kesulitan' => 'mudah',
            'dibuat_oleh' => $guru->id,
            'aktif' => true,
            'acak_soal' => false,
            'tampilkan_jawaban' => true
        ]);

        // Soal 1
        $soal9 = SoalKuis::create([
            'kuis_id' => $kuis3->id,
            'pertanyaan' => 'What is the English word for "ayah"?',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 1
        ]);

        PilihanJawaban::create(['soal_id' => $soal9->id, 'teks_jawaban' => 'mother', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal9->id, 'teks_jawaban' => 'father', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal9->id, 'teks_jawaban' => 'brother', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal9->id, 'teks_jawaban' => 'uncle', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 2
        $soal10 = SoalKuis::create([
            'kuis_id' => $kuis3->id,
            'pertanyaan' => 'Apa arti dari "grandmother"?',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 10,
            'urutan' => 2
        ]);

        PilihanJawaban::create(['soal_id' => $soal10->id, 'teks_jawaban' => 'kakek', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal10->id, 'teks_jawaban' => 'nenek', 'jawaban_benar' => true, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal10->id, 'teks_jawaban' => 'bibi', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal10->id, 'teks_jawaban' => 'ibu', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 3
        $soal11 = SoalKuis::create([
            'kuis_id' => $kuis3->id,
            'pertanyaan' => '"Cousin" means saudara kandung.',
            'jenis_soal' => 'benar_salah',
            'poin' => 10,
            'urutan' => 3
        ]);

        PilihanJawaban::create(['soal_id' => $soal11->id, 'teks_jawaban' => 'Benar', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal11->id, 'teks_jawaban' => 'Salah', 'jawaban_benar' => true, 'urutan' => 1]);

        // Kuis 4: Mixed Grammar (Sedang)
        $kuis4 = Kuis::create([
            'judul' => 'Mixed Grammar Quiz',
            'deskripsi' => 'Kuis campuran tentang berbagai grammar',
            'materi_id' => null,
            'durasi_menit' => 20,
            'nilai_minimal' => 75,
            'tingkat_kesulitan' => 'sedang',
            'dibuat_oleh' => $guru->id,
            'aktif' => true,
            'acak_soal' => true,
            'tampilkan_jawaban' => true
        ]);

        // Soal 1
        $soal12 = SoalKuis::create([
            'kuis_id' => $kuis4->id,
            'pertanyaan' => 'I ... studying English now. (Present Continuous)',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 15,
            'urutan' => 1
        ]);

        PilihanJawaban::create(['soal_id' => $soal12->id, 'teks_jawaban' => 'am', 'jawaban_benar' => true, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal12->id, 'teks_jawaban' => 'is', 'jawaban_benar' => false, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal12->id, 'teks_jawaban' => 'are', 'jawaban_benar' => false, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal12->id, 'teks_jawaban' => 'was', 'jawaban_benar' => false, 'urutan' => 3]);

        // Soal 2
        $soal13 = SoalKuis::create([
            'kuis_id' => $kuis4->id,
            'pertanyaan' => 'She ... to Bali last week. (Simple Past)',
            'jenis_soal' => 'pilihan_ganda',
            'poin' => 15,
            'urutan' => 2
        ]);

        PilihanJawaban::create(['soal_id' => $soal13->id, 'teks_jawaban' => 'go', 'jawaban_benar' => false, 'urutan' => 0]);
        PilihanJawaban::create(['soal_id' => $soal13->id, 'teks_jawaban' => 'goes', 'jawaban_benar' => false, 'urutan' => 1]);
        PilihanJawaban::create(['soal_id' => $soal13->id, 'teks_jawaban' => 'went', 'jawaban_benar' => true, 'urutan' => 2]);
        PilihanJawaban::create(['soal_id' => $soal13->id, 'teks_jawaban' => 'going', 'jawaban_benar' => false, 'urutan' => 3]);
    }
}
