# 🗄️ Database Schema & Relasi

## 📊 Overview

Aplikasi Belajar Bahasa Inggris menggunakan **14 tabel** dengan relasi yang terstruktur untuk mendukung sistem pembelajaran berbasis kelas (7 & 8).

---

## 📋 Daftar Tabel

### Core Tables
1. `users` - Data pengguna (admin, guru, siswa)
2. `peran` - Role/peran pengguna
3. `sessions` - Session management
4. `password_reset_tokens` - Token reset password

### Content Tables
5. `materi` - Materi pembelajaran
6. `kosakata` - Kosakata vocabulary
7. `rich_texts` - Rich text content

### Quiz Tables
8. `kuis` - Data kuis
9. `soal_kuis` - Soal/pertanyaan kuis
10. `pilihan_jawaban` - Pilihan jawaban untuk soal
11. `percobaan_kuis` - Percobaan mengerjakan kuis
12. `jawaban_siswa` - Jawaban siswa per soal

### System Tables
13. `cache` - Cache system
14. `jobs` - Queue jobs

---

## 🔗 Entity Relationship Diagram (ERD)

```
┌─────────────┐
│    peran    │
│─────────────│
│ id          │◄──────┐
│ nama_peran  │       │
│ deskripsi   │       │
└─────────────┘       │
                      │ 1:N
                      │
┌─────────────────────┴───────────────────────────────┐
│                    users                            │
│─────────────────────────────────────────────────────│
│ id                                                  │◄────┐
│ name                                                │     │
│ email                                               │     │
│ password                                            │     │
│ peran_id (FK → peran)                              │     │
│ nomor_induk (NIP/NIS)                              │     │
│ kelas (untuk siswa: 7/8)                           │     │
│ kelas_mengajar (untuk guru: 7/8)                   │     │
│ alamat, no_telepon, jenis_kelamin, tanggal_lahir   │     │
└─────────────────────────────────────────────────────┘     │
                      │                                     │
                      │ 1:N                                 │
                      ▼                                     │
┌─────────────────────────────────────────────────────┐     │
│                   materi                            │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │◄────┤
│ judul                                               │     │
│ jenis_materi (vocabulary/grammar)                   │     │
│ deskripsi                                           │     │
│ konten (untuk grammar)                              │     │
│ video_url, video_path                               │     │
│ dibuat_oleh (FK → users)                           │     │
│ kelas_target (7/8)                                  │     │
│ urutan, aktif                                       │     │
└─────────────────────────────────────────────────────┘     │
                      │                                     │
                      │ 1:N                                 │
                      ▼                                     │
┌─────────────────────────────────────────────────────┐     │
│                  kosakata                           │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │     │
│ materi_id (FK → materi)                            │     │
│ kata_inggris                                        │     │
│ kata_indonesia                                      │     │
│ jenis_kata (noun/verb/adjective)                    │     │
│ contoh_kalimat                                      │     │
│ audio_path, gambar_path                             │     │
│ urutan                                              │     │
└─────────────────────────────────────────────────────┘     │
                                                            │
┌─────────────────────────────────────────────────────┐     │
│                     kuis                            │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │◄────┤
│ judul                                               │     │
│ deskripsi                                           │     │
│ materi_id (FK → materi, nullable)                  │     │
│ durasi_menit                                        │     │
│ nilai_minimal                                       │     │
│ tingkat_kesulitan (mudah/sedang/sulit)             │     │
│ dibuat_oleh (FK → users)                           │     │
│ kelas_target (7/8)                                  │     │
│ aktif, acak_soal, tampilkan_jawaban                │     │
└─────────────────────────────────────────────────────┘     │
                      │                                     │
                      │ 1:N                                 │
                      ▼                                     │
┌─────────────────────────────────────────────────────┐     │
│                 soal_kuis                           │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │◄────┤
│ kuis_id (FK → kuis)                                │     │
│ pertanyaan                                          │     │
│ jenis_soal (pilihan_ganda/benar_salah/isian)       │     │
│ gambar_path, audio_path                             │     │
│ poin                                                │     │
│ urutan                                              │     │
└─────────────────────────────────────────────────────┘     │
                      │                                     │
                      │ 1:N                                 │
                      ▼                                     │
┌─────────────────────────────────────────────────────┐     │
│              pilihan_jawaban                        │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │◄────┐
│ soal_id (FK → soal_kuis)                           │     │
│ teks_jawaban                                        │     │
│ jawaban_benar (boolean)                             │     │
│ urutan                                              │     │
└─────────────────────────────────────────────────────┘     │
                                                            │
┌─────────────────────────────────────────────────────┐     │
│               percobaan_kuis                        │     │
│─────────────────────────────────────────────────────│     │
│ id                                                  │◄────┤
│ kuis_id (FK → kuis)                                │     │
│ siswa_id (FK → users)                              │─────┘
│ waktu_mulai, waktu_selesai                          │
│ nilai                                               │
│ jumlah_benar, jumlah_salah, total_soal             │
│ status (sedang_dikerjakan/selesai/waktu_habis)     │
│ lulus (boolean)                                     │
└─────────────────────────────────────────────────────┘
                      │
                      │ 1:N
                      ▼
┌─────────────────────────────────────────────────────┐
│               jawaban_siswa                         │
│─────────────────────────────────────────────────────│
│ id                                                  │
│ percobaan_id (FK → percobaan_kuis)                 │
│ soal_id (FK → soal_kuis)                           │
│ pilihan_jawaban_id (FK → pilihan_jawaban, nullable)│
│ jawaban_isian (untuk soal isian)                   │
│ benar (boolean)                                     │
│ poin_didapat                                        │
└─────────────────────────────────────────────────────┘
```

---

## 📊 Detail Tabel

### 1. `peran` (Roles)
**Fungsi**: Menyimpan jenis peran pengguna

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| nama_peran | VARCHAR | super_admin, guru, siswa |
| deskripsi | VARCHAR | Deskripsi peran |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `1:N` dengan `users` (satu peran bisa dimiliki banyak user)

---

### 2. `users` (Users)
**Fungsi**: Menyimpan data semua pengguna (admin, guru, siswa)

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| name | VARCHAR | Nama lengkap |
| email | VARCHAR | Email (unique) |
| password | VARCHAR | Password (hashed) |
| peran_id | BIGINT | FK → peran |
| nomor_induk | VARCHAR | NIP (guru) / NIS (siswa) |
| kelas | VARCHAR | Kelas siswa (7/8) |
| kelas_mengajar | VARCHAR | Kelas yang diajar guru (7/8) |
| alamat | TEXT | Alamat lengkap |
| no_telepon | VARCHAR | Nomor telepon |
| jenis_kelamin | ENUM | L (Laki-laki) / P (Perempuan) |
| tanggal_lahir | DATE | Tanggal lahir |
| email_verified_at | TIMESTAMP | Waktu verifikasi email |
| remember_token | VARCHAR | Token remember me |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `peran` (banyak user memiliki satu peran)
- `1:N` dengan `materi` (satu guru bisa buat banyak materi)
- `1:N` dengan `kuis` (satu guru bisa buat banyak kuis)
- `1:N` dengan `percobaan_kuis` (satu siswa bisa punya banyak percobaan)

**Index**:
- `email` (unique)
- `peran_id` (foreign key)

---

### 3. `materi` (Materials)
**Fungsi**: Menyimpan materi pembelajaran (Grammar & Vocabulary)

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| judul | VARCHAR | Judul materi |
| jenis_materi | ENUM | vocabulary / grammar |
| deskripsi | TEXT | Deskripsi singkat |
| konten | TEXT | Konten materi (untuk grammar) |
| video_url | VARCHAR | URL video YouTube |
| video_path | VARCHAR | Path video lokal |
| dibuat_oleh | BIGINT | FK → users (guru) |
| kelas_target | VARCHAR | Target kelas (7/8) |
| urutan | INT | Urutan tampilan |
| aktif | BOOLEAN | Status aktif/nonaktif |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `users` (banyak materi dibuat oleh satu guru)
- `1:N` dengan `kosakata` (satu materi vocabulary punya banyak kosakata)
- `1:N` dengan `kuis` (satu materi bisa punya banyak kuis)

**Index**:
- `dibuat_oleh` (foreign key)
- `kelas_target` (untuk filter)
- `jenis_materi` (untuk filter)

---

### 4. `kosakata` (Vocabularies)
**Fungsi**: Menyimpan kosakata untuk materi vocabulary

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| materi_id | BIGINT | FK → materi |
| kata_inggris | VARCHAR | Kata dalam bahasa Inggris |
| kata_indonesia | VARCHAR | Terjemahan Indonesia |
| jenis_kata | VARCHAR | noun, verb, adjective, dll |
| contoh_kalimat | TEXT | Contoh penggunaan |
| audio_path | VARCHAR | Path file audio pelafalan |
| gambar_path | VARCHAR | Path gambar ilustrasi |
| urutan | INT | Urutan tampilan |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `materi` (banyak kosakata dalam satu materi)

**Index**:
- `materi_id` (foreign key)

---

### 5. `kuis` (Quizzes)
**Fungsi**: Menyimpan data kuis/ujian

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| judul | VARCHAR | Judul kuis |
| deskripsi | TEXT | Deskripsi kuis |
| materi_id | BIGINT | FK → materi (nullable) |
| durasi_menit | INT | Durasi pengerjaan (menit) |
| nilai_minimal | INT | Nilai minimal lulus (0-100) |
| tingkat_kesulitan | ENUM | mudah, sedang, sulit |
| dibuat_oleh | BIGINT | FK → users (guru) |
| kelas_target | VARCHAR | Target kelas (7/8) |
| aktif | BOOLEAN | Status aktif/nonaktif |
| acak_soal | BOOLEAN | Acak urutan soal |
| tampilkan_jawaban | BOOLEAN | Tampilkan pembahasan |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `users` (banyak kuis dibuat oleh satu guru)
- `N:1` dengan `materi` (banyak kuis bisa terkait satu materi)
- `1:N` dengan `soal_kuis` (satu kuis punya banyak soal)
- `1:N` dengan `percobaan_kuis` (satu kuis bisa dikerjakan berkali-kali)

**Index**:
- `dibuat_oleh` (foreign key)
- `materi_id` (foreign key)
- `kelas_target` (untuk filter)

---

### 6. `soal_kuis` (Quiz Questions)
**Fungsi**: Menyimpan soal/pertanyaan kuis

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| kuis_id | BIGINT | FK → kuis |
| pertanyaan | TEXT | Teks pertanyaan |
| jenis_soal | ENUM | pilihan_ganda, benar_salah, isian |
| gambar_path | VARCHAR | Path gambar soal |
| audio_path | VARCHAR | Path audio soal (listening) |
| poin | INT | Poin untuk soal ini |
| urutan | INT | Urutan soal |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `kuis` (banyak soal dalam satu kuis)
- `1:N` dengan `pilihan_jawaban` (satu soal punya banyak pilihan)
- `1:N` dengan `jawaban_siswa` (satu soal bisa dijawab banyak siswa)

**Index**:
- `kuis_id` (foreign key)

---

### 7. `pilihan_jawaban` (Answer Choices)
**Fungsi**: Menyimpan pilihan jawaban untuk soal pilihan ganda/benar-salah

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| soal_id | BIGINT | FK → soal_kuis |
| teks_jawaban | TEXT | Teks pilihan jawaban |
| jawaban_benar | BOOLEAN | Apakah jawaban benar |
| urutan | INT | Urutan pilihan |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `soal_kuis` (banyak pilihan dalam satu soal)
- `1:N` dengan `jawaban_siswa` (satu pilihan bisa dipilih banyak siswa)

**Index**:
- `soal_id` (foreign key)

---

### 8. `percobaan_kuis` (Quiz Attempts)
**Fungsi**: Menyimpan percobaan siswa mengerjakan kuis

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| kuis_id | BIGINT | FK → kuis |
| siswa_id | BIGINT | FK → users |
| waktu_mulai | TIMESTAMP | Waktu mulai mengerjakan |
| waktu_selesai | TIMESTAMP | Waktu selesai (nullable) |
| nilai | INT | Nilai akhir (0-100) |
| jumlah_benar | INT | Jumlah jawaban benar |
| jumlah_salah | INT | Jumlah jawaban salah |
| total_soal | INT | Total soal dalam kuis |
| status | ENUM | sedang_dikerjakan, selesai, waktu_habis |
| lulus | BOOLEAN | Apakah lulus |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `kuis` (banyak percobaan untuk satu kuis)
- `N:1` dengan `users` (banyak percobaan oleh satu siswa)
- `1:N` dengan `jawaban_siswa` (satu percobaan punya banyak jawaban)

**Index**:
- `kuis_id` (foreign key)
- `siswa_id` (foreign key)
- `status` (untuk filter)

---

### 9. `jawaban_siswa` (Student Answers)
**Fungsi**: Menyimpan jawaban siswa per soal

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| percobaan_id | BIGINT | FK → percobaan_kuis |
| soal_id | BIGINT | FK → soal_kuis |
| pilihan_jawaban_id | BIGINT | FK → pilihan_jawaban (nullable) |
| jawaban_isian | TEXT | Jawaban untuk soal isian |
| benar | BOOLEAN | Apakah jawaban benar |
| poin_didapat | INT | Poin yang didapat |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- `N:1` dengan `percobaan_kuis` (banyak jawaban dalam satu percobaan)
- `N:1` dengan `soal_kuis` (banyak jawaban untuk satu soal)
- `N:1` dengan `pilihan_jawaban` (banyak siswa bisa pilih satu jawaban)

**Index**:
- `percobaan_id` (foreign key)
- `soal_id` (foreign key)
- `pilihan_jawaban_id` (foreign key)

---

### 10. `rich_texts` (Rich Text Content)
**Fungsi**: Menyimpan konten rich text (Trix Editor)

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary Key |
| field | VARCHAR | Nama field |
| body | LONGTEXT | Konten HTML |
| recordable_type | VARCHAR | Model type (polymorphic) |
| recordable_id | BIGINT | Model ID (polymorphic) |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Relasi**:
- Polymorphic relation dengan berbagai model

---

### 11-14. System Tables

**`sessions`**: Session management Laravel
**`password_reset_tokens`**: Token untuk reset password
**`cache`**: Cache system
**`jobs`**: Queue jobs

---

## 🔐 Foreign Key Constraints

### ON DELETE Behavior

| Parent Table | Child Table | ON DELETE |
|--------------|-------------|-----------|
| peran | users | CASCADE |
| users | materi | CASCADE |
| users | kuis | CASCADE |
| users | percobaan_kuis | CASCADE |
| materi | kosakata | CASCADE |
| materi | kuis | SET NULL |
| kuis | soal_kuis | CASCADE |
| kuis | percobaan_kuis | CASCADE |
| soal_kuis | pilihan_jawaban | CASCADE |
| soal_kuis | jawaban_siswa | CASCADE |
| pilihan_jawaban | jawaban_siswa | SET NULL |
| percobaan_kuis | jawaban_siswa | CASCADE |

**Penjelasan**:
- **CASCADE**: Jika parent dihapus, child juga dihapus
- **SET NULL**: Jika parent dihapus, FK di child jadi NULL

---

## 📈 Kardinalitas Relasi

### One-to-Many (1:N)
```
peran (1) ──────► users (N)
users/guru (1) ──────► materi (N)
users/guru (1) ──────► kuis (N)
users/siswa (1) ──────► percobaan_kuis (N)
materi (1) ──────► kosakata (N)
materi (1) ──────► kuis (N) [optional]
kuis (1) ──────► soal_kuis (N)
kuis (1) ──────► percobaan_kuis (N)
soal_kuis (1) ──────► pilihan_jawaban (N)
soal_kuis (1) ──────► jawaban_siswa (N)
pilihan_jawaban (1) ──────► jawaban_siswa (N)
percobaan_kuis (1) ──────► jawaban_siswa (N)
```

---

## 🎯 Business Rules

### 1. User Management
- Setiap user harus punya 1 peran
- Email harus unique
- Guru harus punya `kelas_mengajar` (7 atau 8)
- Siswa harus punya `kelas` (7 atau 8)

### 2. Content Management
- Materi harus dibuat oleh guru
- Materi harus punya `kelas_target` (7 atau 8)
- Materi vocabulary harus punya minimal 1 kosakata
- Materi grammar harus punya konten atau video

### 3. Quiz Management
- Kuis harus dibuat oleh guru
- Kuis harus punya `kelas_target` (7 atau 8)
- Kuis harus punya minimal 1 soal
- Soal pilihan ganda harus punya minimal 2 pilihan
- Soal harus punya tepat 1 jawaban benar

### 4. Quiz Attempt
- Siswa hanya bisa mengerjakan kuis sesuai kelasnya
- Satu percobaan hanya untuk 1 kuis dan 1 siswa
- Status percobaan: sedang_dikerjakan → selesai/waktu_habis
- Nilai dihitung otomatis dari jawaban benar
- Lulus jika nilai ≥ nilai_minimal

### 5. Class Isolation
- Guru kelas 7 hanya lihat data kelas 7
- Guru kelas 8 hanya lihat data kelas 8
- Siswa kelas 7 hanya lihat materi/kuis kelas 7
- Siswa kelas 8 hanya lihat materi/kuis kelas 8
- Super admin lihat semua data

---

## 📊 Data Statistics (After Seeding)

| Table | Total Records | Kelas 7 | Kelas 8 |
|-------|---------------|---------|---------|
| peran | 3 | - | - |
| users | 17 | 7 | 7 |
| materi | 10 | 6 | 4 |
| kosakata | 50 | 30 | 20 |
| kuis | 7 | 4 | 3 |
| soal_kuis | 19 | 13 | 6 |
| pilihan_jawaban | 70 | 48 | 22 |
| percobaan_kuis | 26 | ~15 | ~11 |
| jawaban_siswa | 96 | ~60 | ~36 |

---

## 🔍 Query Examples

### Get Materi untuk Siswa Kelas 7
```sql
SELECT m.* 
FROM materi m
WHERE m.kelas_target = '7' 
  AND m.aktif = 1
ORDER BY m.urutan;
```

### Get Kuis dengan Soal untuk Guru Kelas 8
```sql
SELECT k.*, COUNT(s.id) as jumlah_soal
FROM kuis k
LEFT JOIN soal_kuis s ON k.id = s.kuis_id
WHERE k.dibuat_oleh = ? 
  AND k.kelas_target = '8'
GROUP BY k.id;
```

### Get Nilai Siswa per Kuis
```sql
SELECT 
    u.name as nama_siswa,
    k.judul as judul_kuis,
    p.nilai,
    p.status,
    p.lulus,
    p.waktu_selesai
FROM percobaan_kuis p
JOIN users u ON p.siswa_id = u.id
JOIN kuis k ON p.kuis_id = k.id
WHERE k.dibuat_oleh = ?
  AND k.kelas_target = ?
ORDER BY p.waktu_selesai DESC;
```

### Get Detail Jawaban Siswa
```sql
SELECT 
    s.pertanyaan,
    pj.teks_jawaban as jawaban_dipilih,
    js.benar,
    js.poin_didapat,
    s.poin as poin_maksimal
FROM jawaban_siswa js
JOIN soal_kuis s ON js.soal_id = s.id
LEFT JOIN pilihan_jawaban pj ON js.pilihan_jawaban_id = pj.id
WHERE js.percobaan_id = ?
ORDER BY s.urutan;
```

---

## 🛡️ Security Considerations

### 1. Data Isolation
- Middleware `CheckRole` untuk akses control
- Query scope berdasarkan `kelas_target` dan `kelas_mengajar`
- Validasi ownership sebelum update/delete

### 2. Password Security
- Password di-hash menggunakan bcrypt
- Minimum 8 karakter
- Remember token untuk persistent login

### 3. File Upload
- Validasi tipe file (image, audio, video)
- Validasi ukuran file
- Storage di folder terpisah per jenis
- Path disimpan di database, bukan file content

### 4. SQL Injection Prevention
- Menggunakan Eloquent ORM
- Prepared statements untuk raw queries
- Input validation dan sanitization

---

## 📝 Notes

### Naming Convention
- Tabel: plural, lowercase, underscore (snake_case)
- Field: lowercase, underscore (snake_case)
- Foreign Key: `{table_singular}_id`
- Timestamps: `created_at`, `updated_at`

### Bahasa Indonesia
- Nama tabel dan field menggunakan bahasa Indonesia
- Enum values menggunakan bahasa Indonesia
- Untuk kemudahan developer lokal

### Soft Deletes
- Tidak menggunakan soft deletes
- Menggunakan hard delete dengan CASCADE
- Untuk menjaga integritas data

---

**Last Updated**: 2025-11-20  
**Version**: 1.3.2  
**Database**: MySQL/MariaDB  
**Charset**: utf8mb4  
**Collation**: utf8mb4_unicode_ci
