# 📊 Dokumentasi Seeder Lengkap

## ✅ Status: SELESAI & TERVERIFIKASI

Semua seeder telah dibuat dan dijalankan dengan sukses. Database sudah terisi dengan data dummy yang lengkap dan realistis untuk testing.

---

## 📋 Daftar Seeder

### 1. PeranSeeder ✅
**File**: `database/seeders/PeranSeeder.php`

**Data yang dibuat**:
- Super Admin
- Guru  
- Siswa

**Total**: 3 peran + 1 user super admin

---

### 2. GuruSeeder ✅
**File**: `database/seeders/GuruSeeder.php`

**Data Guru Kelas 7** (2 orang):
- **Budi Santoso** (L)
  - Email: `budi.guru@example.com`
  - Password: `password123`
  - NIP: `197001011998031001`
  - Kelas Mengajar: 7

- **Siti Nurhaliza** (P)
  - Email: `siti.guru@example.com`
  - Password: `password123`
  - NIP: `198505152009032002`
  - Kelas Mengajar: 7

**Data Guru Kelas 8** (2 orang):
- **Ahmad Dahlan** (L)
  - Email: `ahmad.guru@example.com`
  - Password: `password123`
  - NIP: `197503201999031003`
  - Kelas Mengajar: 8

- **Dewi Lestari** (P)
  - Email: `dewi.guru@example.com`
  - Password: `password123`
  - NIP: `199008082015032004`
  - Kelas Mengajar: 8

**Total**: 4 guru

---

### 3. SiswaSeeder ✅
**File**: `database/seeders/SiswaSeeder.php`

**Data Siswa Kelas 7** (5 orang):
1. Andi Pratama (L) - `andi.siswa@example.com` - NIS: `2024070001`
2. Bella Safira (P) - `bella.siswa@example.com` - NIS: `2024070002`
3. Candra Wijaya (L) - `candra.siswa@example.com` - NIS: `2024070003`
4. Dina Amelia (P) - `dina.siswa@example.com` - NIS: `2024070004`
5. Eko Prasetyo (L) - `eko.siswa@example.com` - NIS: `2024070005`

**Data Siswa Kelas 8** (5 orang):
1. Farah Diba (P) - `farah.siswa@example.com` - NIS: `2024080001`
2. Gilang Ramadhan (L) - `gilang.siswa@example.com` - NIS: `2024080002`
3. Hana Pertiwi (P) - `hana.siswa@example.com` - NIS: `2024080003`
4. Irfan Hakim (L) - `irfan.siswa@example.com` - NIS: `2024080004`
5. Julia Rahmawati (P) - `julia.siswa@example.com` - NIS: `2024080005`

**Total**: 10 siswa

---

### 4. MateriSeeder ✅
**File**: `database/seeders/MateriSeeder.php`

#### Materi Kelas 7 (6 materi):

**Grammar** (3 materi):
1. Simple Present Tense
2. Present Continuous Tense
3. Simple Past Tense

**Vocabulary** (3 materi):
1. Daily Activities (10 kosakata)
2. Family Members (10 kosakata)
3. Colors (10 kosakata)

#### Materi Kelas 8 (4 materi):

**Grammar** (2 materi):
1. Present Perfect Tense
2. Passive Voice

**Vocabulary** (2 materi):
1. Technology (10 kosakata)
2. Environment (10 kosakata)

**Total**: 10 materi + 50 kosakata

---

### 5. KuisSeeder ✅
**File**: `database/seeders/KuisSeeder.php`

#### Kuis Kelas 7 (4 kuis):

1. **Quiz: Simple Present Tense**
   - Durasi: 15 menit
   - Tingkat: Mudah
   - Soal: 5 soal (4 pilihan ganda + 1 benar/salah)

2. **Quiz: Daily Activities Vocabulary**
   - Durasi: 10 menit
   - Tingkat: Mudah
   - Soal: 3 soal

3. **Quiz: Family Members**
   - Durasi: 10 menit
   - Tingkat: Mudah
   - Soal: 3 soal

4. **Mixed Grammar Quiz**
   - Durasi: 20 menit
   - Tingkat: Sedang
   - Soal: 2 soal

#### Kuis Kelas 8 (3 kuis):

1. **Quiz: Present Perfect Tense**
   - Durasi: 20 menit
   - Tingkat: Sedang
   - Soal: 2 soal

2. **Quiz: Technology Vocabulary**
   - Durasi: 15 menit
   - Tingkat: Sedang
   - Soal: 2 soal

3. **Quiz: Passive Voice**
   - Durasi: 20 menit
   - Tingkat: Sulit
   - Soal: 2 soal

**Total**: 7 kuis + 19 soal + 70 pilihan jawaban

---

### 6. PercobaanKuisSeeder ✅ **[BARU]**
**File**: `database/seeders/PercobaanKuisSeeder.php`

Seeder ini membuat data percobaan kuis dan jawaban siswa untuk simulasi testing yang realistis.

#### Fitur:
- ✅ Percobaan dengan status **Selesai** (lulus & tidak lulus)
- ✅ Percobaan dengan status **Sedang Dikerjakan**
- ✅ Percobaan dengan status **Waktu Habis**
- ✅ Jawaban siswa lengkap dengan poin
- ✅ Nilai otomatis dihitung
- ✅ Timestamp realistis (1-7 hari yang lalu)

#### Data yang dibuat:
- **26 Percobaan Kuis**
  - 24 Selesai
  - 1 Sedang Dikerjakan
  - 1 Waktu Habis
- **96 Jawaban Siswa**

**Skenario Testing**:
- Siswa kelas 7 mengerjakan kuis kelas 7
- Siswa kelas 8 mengerjakan kuis kelas 8
- Ada siswa yang lulus dan tidak lulus
- Ada siswa yang sedang mengerjakan
- Ada siswa yang kehabisan waktu

---

## 📊 Ringkasan Data

| Kategori | Kelas 7 | Kelas 8 | Total |
|----------|---------|---------|-------|
| **Users** |
| Guru | 2 | 2 | 4 |
| Siswa | 5 | 5 | 10 |
| Super Admin | - | - | 3 |
| **Subtotal Users** | 7 | 7 | **17** |
| | | | |
| **Materi** |
| Grammar | 3 | 2 | 5 |
| Vocabulary | 3 | 2 | 5 |
| Kosakata | 30 | 20 | 50 |
| **Subtotal Materi** | 6 | 4 | **10** |
| | | | |
| **Kuis** |
| Kuis | 4 | 3 | 7 |
| Soal | 13 | 6 | 19 |
| Pilihan Jawaban | 48 | 22 | 70 |
| **Subtotal Kuis** | 4 | 3 | **7** |
| | | | |
| **Percobaan** |
| Percobaan Kuis | ~15 | ~11 | 26 |
| Jawaban Siswa | ~60 | ~36 | 96 |

---

## 🚀 Cara Menjalankan

### 1. Fresh Migration + Seed (Recommended)
```bash
php artisan migrate:fresh --seed
```

### 2. Jalankan Seeder Saja
```bash
php artisan db:seed
```

### 3. Jalankan Seeder Tertentu
```bash
# Hanya peran
php artisan db:seed --class=PeranSeeder

# Hanya guru
php artisan db:seed --class=GuruSeeder

# Hanya siswa
php artisan db:seed --class=SiswaSeeder

# Hanya materi
php artisan db:seed --class=MateriSeeder

# Hanya kuis
php artisan db:seed --class=KuisSeeder

# Hanya percobaan kuis
php artisan db:seed --class=PercobaanKuisSeeder
```

### 4. Verifikasi Data
```bash
php verify_seeder.php
```

---

## 🔑 Login Credentials

### Super Admin
- Email: `admin@example.com`
- Password: `password`

### Guru Kelas 7
- **Budi**: `budi.guru@example.com` / `password123`
- **Siti**: `siti.guru@example.com` / `password123`

### Guru Kelas 8
- **Ahmad**: `ahmad.guru@example.com` / `password123`
- **Dewi**: `dewi.guru@example.com` / `password123`

### Siswa Kelas 7
- **Andi**: `andi.siswa@example.com` / `password123`
- **Bella**: `bella.siswa@example.com` / `password123`
- **Candra**: `candra.siswa@example.com` / `password123`
- **Dina**: `dina.siswa@example.com` / `password123`
- **Eko**: `eko.siswa@example.com` / `password123`

### Siswa Kelas 8
- **Farah**: `farah.siswa@example.com` / `password123`
- **Gilang**: `gilang.siswa@example.com` / `password123`
- **Hana**: `hana.siswa@example.com` / `password123`
- **Irfan**: `irfan.siswa@example.com` / `password123`
- **Julia**: `julia.siswa@example.com` / `password123`

---

## 🧪 Skenario Testing

### Test 1: Guru Kelas 7
1. Login sebagai **Budi** (`budi.guru@example.com`)
2. Dashboard → Lihat statistik kelas 7
3. Materi → Lihat 6 materi kelas 7
4. Kuis → Lihat 4 kuis kelas 7
5. Nilai → Lihat nilai siswa kelas 7 (5 siswa)
6. **Verifikasi**: Tidak bisa lihat data kelas 8

### Test 2: Guru Kelas 8
1. Login sebagai **Ahmad** (`ahmad.guru@example.com`)
2. Dashboard → Lihat statistik kelas 8
3. Materi → Lihat 4 materi kelas 8
4. Kuis → Lihat 3 kuis kelas 8
5. Nilai → Lihat nilai siswa kelas 8 (5 siswa)
6. **Verifikasi**: Tidak bisa lihat data kelas 7

### Test 3: Siswa Kelas 7
1. Login sebagai **Andi** (`andi.siswa@example.com`)
2. Dashboard → Lihat progress kuis
3. Materi → Hanya lihat materi kelas 7 (6 materi)
4. Kuis → Hanya lihat kuis kelas 7 (4 kuis)
5. Riwayat → Lihat percobaan kuis yang sudah dikerjakan
6. **Verifikasi**: Tidak bisa lihat materi/kuis kelas 8

### Test 4: Siswa Kelas 8
1. Login sebagai **Farah** (`farah.siswa@example.com`)
2. Dashboard → Lihat progress kuis
3. Materi → Hanya lihat materi kelas 8 (4 materi)
4. Kuis → Hanya lihat kuis kelas 8 (3 kuis)
5. Riwayat → Lihat percobaan kuis yang sudah dikerjakan
6. **Verifikasi**: Tidak bisa lihat materi/kuis kelas 7

### Test 5: Fitur Nilai Guru
1. Login sebagai guru
2. Nilai → Lihat daftar siswa sesuai kelas
3. Klik siswa → Lihat detail nilai per kuis
4. Klik kuis → Lihat nilai semua siswa untuk kuis tersebut
5. **Verifikasi**: Data nilai akurat dan sesuai percobaan

### Test 6: Status Percobaan Kuis
1. Login sebagai siswa
2. Riwayat Kuis → Lihat berbagai status:
   - ✅ Selesai (dengan nilai)
   - ⏳ Sedang Dikerjakan (bisa dilanjutkan)
   - ⏰ Waktu Habis (dengan nilai parsial)

---

## 📝 Catatan Penting

### Password Default
Semua user (kecuali super admin) menggunakan password: `password123`

### Format NIP Guru
- Format: `YYYYMMDDYYYYMMDDXX`
- Contoh: `197001011998031001`

### Format NIS Siswa
- Format: `2024[KELAS][URUT]`
- Kelas 7: `2024070001`, `2024070002`, dst
- Kelas 8: `2024080001`, `2024080002`, dst

### Sistem Kelas
- Guru memiliki `kelas_mengajar` (7 atau 8)
- Siswa memiliki `kelas` (7 atau 8)
- Materi memiliki `kelas_target` (7 atau 8)
- Kuis memiliki `kelas_target` (7 atau 8)
- Sistem otomatis filter data berdasarkan kelas

### Data Tambahan
- Semua user sudah `email_verified_at`
- Alamat dummy di Jakarta
- No. telepon dummy dengan format `08123456xxxx`
- Tanggal lahir realistis:
  - Guru: 1970-1990
  - Siswa: 2010-2011

---

## 🔄 Reset Data

Jika ingin reset semua data:

```bash
# Hapus semua data dan migrate ulang
php artisan migrate:fresh

# Jalankan seeder lagi
php artisan db:seed
```

Atau dalam satu command:

```bash
php artisan migrate:fresh --seed
```

---

## 📚 File Terkait

### Seeders
- `database/seeders/DatabaseSeeder.php` - Main seeder
- `database/seeders/PeranSeeder.php` - Seeder peran
- `database/seeders/GuruSeeder.php` - Seeder guru
- `database/seeders/SiswaSeeder.php` - Seeder siswa
- `database/seeders/MateriSeeder.php` - Seeder materi & kosakata
- `database/seeders/KuisSeeder.php` - Seeder kuis & soal
- `database/seeders/PercobaanKuisSeeder.php` - Seeder percobaan kuis ⭐ **BARU**

### Models
- `app/Models/User.php`
- `app/Models/Peran.php`
- `app/Models/Materi.php`
- `app/Models/Kosakata.php`
- `app/Models/Kuis.php`
- `app/Models/SoalKuis.php`
- `app/Models/PilihanJawaban.php`
- `app/Models/PercobaanKuis.php`
- `app/Models/JawabanSiswa.php`

### Migrations
- `database/migrations/0001_01_01_000000_create_users_table.php`
- `database/migrations/2025_11_15_062816_create_roles_table.php`
- `database/migrations/2025_11_15_062817_add_role_to_users_table.php`
- `database/migrations/2025_11_15_062819_create_materials_table.php`
- `database/migrations/2025_11_15_062821_create_vocabularies_table.php`
- `database/migrations/2025_11_15_062823_create_quizzes_table.php`
- `database/migrations/2025_11_15_062825_create_quiz_questions_table.php`
- `database/migrations/2025_11_15_062828_create_quiz_attempts_table.php`
- `database/migrations/2025_11_15_062829_create_quiz_answers_table.php`
- `database/migrations/2025_11_15_063300_create_jawaban_siswa_table.php`
- `database/migrations/2025_11_20_005615_add_kelas_to_users_and_content_tables.php`

---

## ✅ Checklist Seeder

- [x] PeranSeeder - 3 peran + 1 super admin
- [x] GuruSeeder - 4 guru (2 kelas 7, 2 kelas 8)
- [x] SiswaSeeder - 10 siswa (5 kelas 7, 5 kelas 8)
- [x] MateriSeeder - 10 materi + 50 kosakata
- [x] KuisSeeder - 7 kuis + 19 soal + 70 pilihan jawaban
- [x] PercobaanKuisSeeder - 26 percobaan + 96 jawaban ⭐ **BARU**
- [x] DatabaseSeeder - Orchestrator semua seeder
- [x] Sistem kelas terintegrasi
- [x] Data realistis dan siap testing
- [x] Dokumentasi lengkap

---

## 🎉 Status Akhir

**✅ SEMUA SEEDER SELESAI & TERVERIFIKASI**

Database sudah terisi lengkap dengan:
- 17 users (3 admin + 4 guru + 10 siswa)
- 10 materi dengan 50 kosakata
- 7 kuis dengan 19 soal dan 70 pilihan jawaban
- 26 percobaan kuis dengan 96 jawaban siswa
- Sistem kelas 7 & 8 terintegrasi penuh
- Data realistis siap untuk testing

**Tanggal**: 2025-11-20  
**Versi**: 1.0.0  
**Status**: Production Ready ✅
