<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Kosakata;
use App\Models\User;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil guru
        $guru = User::whereHas('peran', function($q) {
            $q->where('nama_peran', 'guru');
        })->first();

        // Materi Grammar 1: Simple Present Tense
        $grammar1 = Materi::create([
            'judul' => 'Simple Present Tense',
            'jenis_materi' => 'grammar',
            'deskripsi' => 'Pelajari penggunaan Simple Present Tense dalam bahasa Inggris',
            'konten' => "Simple Present Tense digunakan untuk:\n\n1. Kebiasaan atau rutinitas\nContoh: I go to school every day.\n\n2. Fakta umum\nContoh: The sun rises in the east.\n\n3. Kebenaran yang tidak berubah\nContoh: Water boils at 100 degrees Celsius.\n\nRumus:\n(+) Subject + Verb1 (s/es) + Object\n(-) Subject + do/does + not + Verb1 + Object\n(?) Do/Does + Subject + Verb1 + Object?",
            'video_url' => 'https://www.youtube.com/embed/DRJf-wNrALs',
            'dibuat_oleh' => $guru->id,
            'urutan' => 1,
            'aktif' => true
        ]);

        // Materi Grammar 2: Present Continuous Tense
        $grammar2 = Materi::create([
            'judul' => 'Present Continuous Tense',
            'jenis_materi' => 'grammar',
            'deskripsi' => 'Memahami penggunaan Present Continuous Tense',
            'konten' => "Present Continuous Tense digunakan untuk:\n\n1. Aktivitas yang sedang berlangsung\nContoh: I am studying English now.\n\n2. Rencana di masa depan yang sudah pasti\nContoh: We are going to Bali next week.\n\nRumus:\n(+) Subject + am/is/are + Verb-ing + Object\n(-) Subject + am/is/are + not + Verb-ing + Object\n(?) Am/Is/Are + Subject + Verb-ing + Object?",
            'video_url' => 'https://www.youtube.com/embed/8NP5ghXqJYo',
            'dibuat_oleh' => $guru->id,
            'urutan' => 2,
            'aktif' => true
        ]);

        // Materi Vocabulary 1: Daily Activities
        $vocab1 = Materi::create([
            'judul' => 'Daily Activities (Kegiatan Sehari-hari)',
            'jenis_materi' => 'vocabulary',
            'deskripsi' => 'Kosakata tentang kegiatan sehari-hari',
            'dibuat_oleh' => $guru->id,
            'urutan' => 3,
            'aktif' => true
        ]);

        // Kosakata untuk Daily Activities
        $dailyActivities = [
            ['wake up', 'bangun tidur', 'verb', 'I wake up at 6 AM every morning.'],
            ['take a bath', 'mandi', 'verb', 'She takes a bath before breakfast.'],
            ['have breakfast', 'sarapan', 'verb', 'We have breakfast together.'],
            ['go to school', 'pergi ke sekolah', 'verb', 'They go to school by bus.'],
            ['study', 'belajar', 'verb', 'I study English every day.'],
            ['have lunch', 'makan siang', 'verb', 'We have lunch at 12 PM.'],
            ['do homework', 'mengerjakan PR', 'verb', 'He does homework after school.'],
            ['watch TV', 'menonton TV', 'verb', 'They watch TV in the evening.'],
            ['have dinner', 'makan malam', 'verb', 'My family has dinner at 7 PM.'],
            ['go to bed', 'tidur', 'verb', 'I go to bed at 10 PM.'],
        ];

        foreach ($dailyActivities as $index => $kata) {
            Kosakata::create([
                'materi_id' => $vocab1->id,
                'kata_inggris' => $kata[0],
                'kata_indonesia' => $kata[1],
                'jenis_kata' => $kata[2],
                'contoh_kalimat' => $kata[3],
                'urutan' => $index
            ]);
        }

        // Materi Vocabulary 2: Family Members
        $vocab2 = Materi::create([
            'judul' => 'Family Members (Anggota Keluarga)',
            'jenis_materi' => 'vocabulary',
            'deskripsi' => 'Kosakata tentang anggota keluarga',
            'dibuat_oleh' => $guru->id,
            'urutan' => 4,
            'aktif' => true
        ]);

        // Kosakata untuk Family Members
        $familyMembers = [
            ['father', 'ayah', 'noun', 'My father is a teacher.'],
            ['mother', 'ibu', 'noun', 'My mother cooks delicious food.'],
            ['brother', 'saudara laki-laki', 'noun', 'I have one brother.'],
            ['sister', 'saudara perempuan', 'noun', 'My sister is younger than me.'],
            ['grandfather', 'kakek', 'noun', 'My grandfather is 70 years old.'],
            ['grandmother', 'nenek', 'noun', 'My grandmother lives with us.'],
            ['uncle', 'paman', 'noun', 'My uncle works in Jakarta.'],
            ['aunt', 'bibi', 'noun', 'My aunt is very kind.'],
            ['cousin', 'sepupu', 'noun', 'I have many cousins.'],
            ['parents', 'orang tua', 'noun', 'My parents love me very much.'],
        ];

        foreach ($familyMembers as $index => $kata) {
            Kosakata::create([
                'materi_id' => $vocab2->id,
                'kata_inggris' => $kata[0],
                'kata_indonesia' => $kata[1],
                'jenis_kata' => $kata[2],
                'contoh_kalimat' => $kata[3],
                'urutan' => $index
            ]);
        }

        // Materi Vocabulary 3: Colors
        $vocab3 = Materi::create([
            'judul' => 'Colors (Warna)',
            'jenis_materi' => 'vocabulary',
            'deskripsi' => 'Kosakata tentang warna-warna',
            'dibuat_oleh' => $guru->id,
            'urutan' => 5,
            'aktif' => true
        ]);

        // Kosakata untuk Colors
        $colors = [
            ['red', 'merah', 'adjective', 'The apple is red.'],
            ['blue', 'biru', 'adjective', 'The sky is blue.'],
            ['green', 'hijau', 'adjective', 'The grass is green.'],
            ['yellow', 'kuning', 'adjective', 'The sun is yellow.'],
            ['black', 'hitam', 'adjective', 'My shoes are black.'],
            ['white', 'putih', 'adjective', 'The clouds are white.'],
            ['orange', 'oranye', 'adjective', 'I like orange juice.'],
            ['purple', 'ungu', 'adjective', 'She wears a purple dress.'],
            ['pink', 'merah muda', 'adjective', 'The flower is pink.'],
            ['brown', 'coklat', 'adjective', 'The table is brown.'],
        ];

        foreach ($colors as $index => $kata) {
            Kosakata::create([
                'materi_id' => $vocab3->id,
                'kata_inggris' => $kata[0],
                'kata_indonesia' => $kata[1],
                'jenis_kata' => $kata[2],
                'contoh_kalimat' => $kata[3],
                'urutan' => $index
            ]);
        }

        // Materi Grammar 3: Simple Past Tense
        $grammar3 = Materi::create([
            'judul' => 'Simple Past Tense',
            'jenis_materi' => 'grammar',
            'deskripsi' => 'Memahami penggunaan Simple Past Tense',
            'konten' => "Simple Past Tense digunakan untuk:\n\n1. Kejadian yang terjadi di masa lampau\nContoh: I went to school yesterday.\n\n2. Kebiasaan di masa lampau\nContoh: She always studied hard when she was young.\n\nRumus:\n(+) Subject + Verb2 + Object\n(-) Subject + did + not + Verb1 + Object\n(?) Did + Subject + Verb1 + Object?\n\nTime signals: yesterday, last week, ago, in 1990, etc.",
            'video_url' => 'https://www.youtube.com/embed/Y_JtkwYudyg',
            'dibuat_oleh' => $guru->id,
            'urutan' => 6,
            'aktif' => true
        ]);
    }
}
