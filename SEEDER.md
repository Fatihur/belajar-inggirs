# Dokumentasi Seeder

## Daftar Seeder

### 1. PeranSeeder
Membuat data awal untuk tabel `peran` dan `users`.

**Data yang dibuat:**
- 3 Peran: super_admin, guru, siswa
- 3 User default:
  - Super Admin (admin@belajaringgris.com / admin123)
  - Guru Demo (guru@belajaringgris.com / guru123)
  - Siswa Demo (siswa@belajaringgris.com / siswa123)

---

### 2. MateriSeeder
Membuat data contoh untuk tabel `materi` dan `kosakata`.

**Data yang dibuat:**

#### Materi Grammar (3 materi):
1. **Simple Present Tense**
   - Konten lengkap dengan penjelasan dan rumus
   - Video YouTube embedded
   - Urutan: 1

2. **Present Continuous Tense**
   - Konten lengkap dengan penjelasan dan rumus
   - Video YouTube embedded
   - Urutan: 2

3. **Simple Past Tense**
   - Konten lengkap dengan penjelasan dan rumus
   - Video YouTube embedded
   - Urutan: 6

#### Materi Vocabulary (3 materi):
1. **Daily Activities (Kegiatan Sehari-hari)**
   - 10 kosakata dengan contoh kalimat
   - Urutan: 3

2. **Family Members (Anggota Keluarga)**
   - 10 kosakata dengan contoh kalimat
   - Urutan: 4

3. **Colors (Warna)**
   - 10 kosakata dengan contoh kalimat
   - Urutan: 5

**Total:** 6 materi, 30 kosakata

---

### 3. KuisSeeder
Membuat data contoh untuk tabel `kuis`, `soal_kuis`, dan `pilihan_jawaban`.

**Data yang dibuat:**

#### Kuis 1: Simple Present Tense
- Durasi: 15 menit
- Nilai minimal: 70
- Tingkat: Mudah
- Soal: 5 soal (4 pilihan ganda, 1 benar/salah)
- Total poin: 50

#### Kuis 2: Daily Activities Vocabulary
- Durasi: 10 menit
- Nilai minimal: 70
- Tingkat: Mudah
- Soal: 3 soal (2 pilihan ganda, 1 benar/salah)
- Total poin: 30

#### Kuis 3: Family Members
- Durasi: 10 menit
- Nilai minimal: 70
- Tingkat: Mudah
- Soal: 3 soal (2 pilihan ganda, 1 benar/salah)
- Total poin: 30

#### Kuis 4: Mixed Grammar Quiz
- Durasi: 20 menit
- Nilai minimal: 75
- Tingkat: Sedang
- Soal: 2 soal (pilihan ganda)
- Total poin: 30

**Total:** 4 kuis, 13 soal, 48 pilihan jawaban

---

## Cara Menjalankan Seeder

### Jalankan Semua Seeder
```bash
php artisan db:seed
```

### Jalankan Seeder Tertentu
```bash
php artisan db:seed --class=PeranSeeder
php artisan db:seed --class=MateriSeeder
php artisan db:seed --class=KuisSeeder
```

### Fresh Migration + Seeder
```bash
php artisan migrate:fresh --seed
```

---

## Detail Data Seeder

### Materi Grammar

#### 1. Simple Present Tense
```
Konten:
- Kebiasaan atau rutinitas
- Fakta umum
- Kebenaran yang tidak berubah
- Rumus lengkap (+, -, ?)

Video: YouTube embedded
```

#### 2. Present Continuous Tense
```
Konten:
- Aktivitas yang sedang berlangsung
- Rencana di masa depan yang sudah pasti
- Rumus lengkap (+, -, ?)

Video: YouTube embedded
```

#### 3. Simple Past Tense
```
Konten:
- Kejadian di masa lampau
- Kebiasaan di masa lampau
- Rumus lengkap (+, -, ?)
- Time signals

Video: YouTube embedded
```

---

### Materi Vocabulary

#### 1. Daily Activities (10 kata)
- wake up (bangun tidur)
- take a bath (mandi)
- have breakfast (sarapan)
- go to school (pergi ke sekolah)
- study (belajar)
- have lunch (makan siang)
- do homework (mengerjakan PR)
- watch TV (menonton TV)
- have dinner (makan malam)
- go to bed (tidur)

#### 2. Family Members (10 kata)
- father (ayah)
- mother (ibu)
- brother (saudara laki-laki)
- sister (saudara perempuan)
- grandfather (kakek)
- grandmother (nenek)
- uncle (paman)
- aunt (bibi)
- cousin (sepupu)
- parents (orang tua)

#### 3. Colors (10 kata)
- red (merah)
- blue (biru)
- green (hijau)
- yellow (kuning)
- black (hitam)
- white (putih)
- orange (oranye)
- purple (ungu)
- pink (merah muda)
- brown (coklat)

---

### Kuis & Soal

#### Kuis 1: Simple Present Tense (5 soal)
1. She ... to school every day. (goes)
2. They ... football every Sunday. (play)
3. My father ... not drink coffee. (does)
4. ... you like pizza? (Do)
5. The sun rises in the east. (Benar)

#### Kuis 2: Daily Activities (3 soal)
1. What is the meaning of "wake up"? (bangun tidur)
2. Apa bahasa Inggris dari "mengerjakan PR"? (do homework)
3. "Have breakfast" means eating in the morning. (Benar)

#### Kuis 3: Family Members (3 soal)
1. What is the English word for "ayah"? (father)
2. Apa arti dari "grandmother"? (nenek)
3. "Cousin" means saudara kandung. (Salah)

#### Kuis 4: Mixed Grammar (2 soal)
1. I ... studying English now. (am)
2. She ... to Bali last week. (went)

---

## Statistik Data Seeder

| Tabel | Jumlah Data |
|-------|-------------|
| peran | 3 |
| users | 3 |
| materi | 6 |
| kosakata | 30 |
| kuis | 4 |
| soal_kuis | 13 |
| pilihan_jawaban | 48 |

**Total:** 107 records

---

## Catatan

1. **Video URL** menggunakan YouTube embed format
2. **Semua materi** dibuat oleh user Guru Demo
3. **Semua kuis** aktif dan siap digunakan
4. **Kosakata** sudah terurut dengan baik
5. **Soal kuis** memiliki jawaban yang benar
6. **Tingkat kesulitan** bervariasi (mudah & sedang)

---

## Testing

Setelah menjalankan seeder, Anda dapat:

1. **Login sebagai Guru:**
   - Email: guru@belajaringgris.com
   - Password: guru123
   - Lihat materi dan kuis yang sudah dibuat

2. **Login sebagai Siswa:**
   - Email: siswa@belajaringgris.com
   - Password: siswa123
   - Akses materi dan kerjakan kuis

3. **Login sebagai Super Admin:**
   - Email: admin@belajaringgris.com
   - Password: admin123
   - Kelola guru dan siswa

---

**Versi:** 1.3.0  
**Tanggal:** 15 November 2025
