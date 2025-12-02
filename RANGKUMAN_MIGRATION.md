# 📋 Rangkuman Migration Database

## 📊 Overview

Total **17 migration files** yang membuat **20 tabel** dalam database.

---

## 🗂️ Daftar Migration (Urutan Eksekusi)

### 1. Laravel Default Migrations (3 files)

#### `0001_01_01_000000_create_users_table.php`
**Membuat 3 tabel**:

**Tabel `users`**:
- id (BIGINT, PK)
- name (VARCHAR)
- email (VARCHAR, UNIQUE)
- email_verified_at (TIMESTAMP, nullable)
- password (VARCHAR)
- remember_token (VARCHAR)
- timestamps

**Tabel `password_reset_tokens`**:
- email (VARCHAR, PK)
- token (VARCHAR)
- created_at (TIMESTAMP, nullable)

**Tabel `sessions`**:
- id (VARCHAR, PK)
- user_id (BIGINT, FK, nullable)
- ip_address (VARCHAR 45, nullable)
- user_agent (TEXT, nullable)
- payload (LONGTEXT)
- last_activity (INT, indexed)

---

#### `0001_01_01_000001_create_cache_table.php`
**Membuat 2 tabel**:

**Tabel `cache`**:
- key (VARCHAR, PK)
- value (MEDIUMTEXT)
- expiration (INT)

**Tabel `cache_locks`**:
- key (VARCHAR, PK)
- owner (VARCHAR)
- expiration (INT)

---

#### `0001_01_01_000002_create_jobs_table.php`
**Membuat 3 tabel**:

**Tabel `jobs`**:
- id (BIGINT, PK)
- queue (VARCHAR, indexed)
- payload (LONGTEXT)
- attempts (TINYINT)
- reserved_at (INT, nullable)
- available_at (INT)
- created_at (INT)

**Tabel `job_batches`**:
- id (VARCHAR, PK)
- name (VARCHAR)
- total_jobs (INT)
- pending_jobs (INT)
- failed_jobs (INT)
- failed_job_ids (LONGTEXT)
- options (MEDIUMTEXT, nullable)
- cancelled_at (INT, nullable)
- created_at (INT)
- finished_at (INT, nullable)

**Tabel `failed_jobs`**:
- id (BIGINT, PK)
- uuid (VARCHAR, UNIQUE)
- connection (TEXT)
- queue (TEXT)
- payload (LONGTEXT)
- exception (LONGTEXT)
- failed_at (TIMESTAMP, default CURRENT_TIMESTAMP)

---

### 2. Application Migrations (14 files)

#### `2025_11_15_062816_create_roles_table.php`
**Membuat 1 tabel**:

**Tabel `peran`**:
- id (BIGINT, PK)
- nama_peran (VARCHAR) - super_admin, guru, siswa
- deskripsi (VARCHAR, nullable)
- timestamps

**Fungsi**: Menyimpan jenis peran pengguna

---

#### `2025_11_15_062817_add_role_to_users_table.php`
**Menambahkan kolom ke tabel `users`**:
- peran_id (BIGINT, FK → peran) CASCADE
- nomor_induk (VARCHAR, nullable) - NIP/NIS
- kelas (VARCHAR, nullable) - untuk siswa
- alamat (TEXT, nullable)
- no_telepon (VARCHAR, nullable)
- jenis_kelamin (ENUM: L/P, nullable)
- tanggal_lahir (DATE, nullable)

**Fungsi**: Extend tabel users dengan data profil lengkap

---

#### `2025_11_15_062819_create_materials_table.php`
**Membuat 1 tabel**:

**Tabel `materi`**:
- id (BIGINT, PK)
- judul (VARCHAR)
- jenis_materi (ENUM: vocabulary/grammar)
- deskripsi (TEXT, nullable)
- konten (TEXT, nullable) - untuk grammar
- video_url (VARCHAR, nullable) - URL YouTube
- video_path (VARCHAR, nullable) - path video lokal
- dibuat_oleh (BIGINT, FK → users) CASCADE
- urutan (INT, default 0)
- aktif (BOOLEAN, default true)
- timestamps

**Fungsi**: Menyimpan materi pembelajaran

---

#### `2025_11_15_062821_create_vocabularies_table.php`
**Membuat 1 tabel**:

**Tabel `kosakata`**:
- id (BIGINT, PK)
- materi_id (BIGINT, FK → materi) CASCADE
- kata_inggris (VARCHAR)
- kata_indonesia (VARCHAR)
- jenis_kata (VARCHAR, nullable) - noun, verb, adjective
- contoh_kalimat (TEXT, nullable)
- audio_path (VARCHAR, nullable)
- gambar_path (VARCHAR, nullable)
- urutan (INT, default 0)
- timestamps

**Fungsi**: Menyimpan kosakata untuk materi vocabulary

---

#### `2025_11_15_062823_create_quizzes_table.php`
**Membuat 1 tabel**:

**Tabel `kuis`**:
- id (BIGINT, PK)
- judul (VARCHAR)
- deskripsi (TEXT, nullable)
- materi_id (BIGINT, FK → materi, nullable) SET NULL
- durasi_menit (INT, default 30)
- nilai_minimal (INT, default 70)
- tingkat_kesulitan (ENUM: mudah/sedang/sulit, default sedang)
- dibuat_oleh (BIGINT, FK → users) CASCADE
- aktif (BOOLEAN, default true)
- acak_soal (BOOLEAN, default false)
- tampilkan_jawaban (BOOLEAN, default true)
- timestamps

**Fungsi**: Menyimpan data kuis/ujian

---

#### `2025_11_15_062825_create_quiz_questions_table.php`
**Membuat 1 tabel**:

**Tabel `soal_kuis`**:
- id (BIGINT, PK)
- kuis_id (BIGINT, FK → kuis) CASCADE
- pertanyaan (TEXT)
- jenis_soal (ENUM: pilihan_ganda/benar_salah/isian, default pilihan_ganda)
- gambar_path (VARCHAR, nullable)
- audio_path (VARCHAR, nullable)
- poin (INT, default 10)
- urutan (INT, default 0)
- timestamps

**Fungsi**: Menyimpan soal/pertanyaan kuis

---

#### `2025_11_15_062828_create_quiz_attempts_table.php`
**Membuat 1 tabel**:

**Tabel `percobaan_kuis`**:
- id (BIGINT, PK)
- kuis_id (BIGINT, FK → kuis) CASCADE
- siswa_id (BIGINT, FK → users) CASCADE
- waktu_mulai (TIMESTAMP)
- waktu_selesai (TIMESTAMP, nullable)
- nilai (INT, nullable) - 0-100
- jumlah_benar (INT, default 0)
- jumlah_salah (INT, default 0)
- total_soal (INT, default 0)
- status (ENUM: sedang_dikerjakan/selesai/waktu_habis, default sedang_dikerjakan)
- lulus (BOOLEAN, default false)
- timestamps

**Fungsi**: Menyimpan percobaan siswa mengerjakan kuis

---

#### `2025_11_15_062829_create_quiz_answers_table.php`
**Membuat 1 tabel**:

**Tabel `pilihan_jawaban`**:
- id (BIGINT, PK)
- soal_id (BIGINT, FK → soal_kuis) CASCADE
- teks_jawaban (TEXT)
- jawaban_benar (BOOLEAN, default false)
- urutan (INT, default 0)
- timestamps

**Fungsi**: Menyimpan pilihan jawaban untuk soal

---

#### `2025_11_15_063300_create_jawaban_siswa_table.php`
**Membuat 1 tabel**:

**Tabel `jawaban_siswa`**:
- id (BIGINT, PK)
- percobaan_id (BIGINT, FK → percobaan_kuis) CASCADE
- soal_id (BIGINT, FK → soal_kuis) CASCADE
- pilihan_jawaban_id (BIGINT, FK → pilihan_jawaban, nullable) SET NULL
- jawaban_isian (TEXT, nullable)
- benar (BOOLEAN, default false)
- poin_didapat (INT, default 0)
- timestamps

**Fungsi**: Menyimpan jawaban siswa per soal

---

#### `2025_11_15_105605_create_rich_texts_table.php`
**Membuat 1 tabel**:

**Tabel `rich_texts`**:
- id (BIGINT, PK)
- record_type (VARCHAR) - polymorphic
- record_id (BIGINT) - polymorphic
- field (VARCHAR)
- body (LONGTEXT, nullable)
- timestamps
- UNIQUE(field, record_type, record_id)

**Fungsi**: Menyimpan konten rich text (Trix Editor)

---

#### `2025_11_20_005615_add_kelas_to_users_and_content_tables.php`
**Menambahkan kolom**:

**Ke tabel `users`**:
- kelas_mengajar (VARCHAR, nullable) - untuk guru (7/8)

**Ke tabel `materi`**:
- kelas_target (VARCHAR, nullable) - target kelas (7/8)

**Ke tabel `kuis`**:
- kelas_target (VARCHAR, nullable) - target kelas (7/8)

**Fungsi**: Implementasi sistem kelas 7 & 8

---

#### `2025_11_30_000001_create_siswa_table.php` ⭐ **BARU**
**Membuat 1 tabel**:

**Tabel `siswa`**:
- id (BIGINT, PK)
- user_id (BIGINT, FK → users) CASCADE
- nis (VARCHAR, UNIQUE) - Nomor Induk Siswa
- kelas (VARCHAR) - 7 atau 8
- nama_lengkap (VARCHAR)
- jenis_kelamin (ENUM: L/P, nullable)
- tempat_lahir (VARCHAR, nullable)
- tanggal_lahir (DATE, nullable)
- alamat (TEXT, nullable)
- no_telepon (VARCHAR, nullable)
- nama_orang_tua (VARCHAR, nullable)
- no_telepon_orang_tua (VARCHAR, nullable)
- timestamps

**Fungsi**: Tabel terpisah untuk data siswa (normalisasi)

---

#### `2025_11_30_000002_create_guru_table.php` ⭐ **BARU**
**Membuat 1 tabel**:

**Tabel `guru`**:
- id (BIGINT, PK)
- user_id (BIGINT, FK → users) CASCADE
- nip (VARCHAR, UNIQUE) - Nomor Induk Pegawai
- nama_lengkap (VARCHAR)
- kelas_mengajar (VARCHAR) - 7 atau 8
- jenis_kelamin (ENUM: L/P, nullable)
- tempat_lahir (VARCHAR, nullable)
- tanggal_lahir (DATE, nullable)
- alamat (TEXT, nullable)
- no_telepon (VARCHAR, nullable)
- pendidikan_terakhir (VARCHAR, nullable)
- bidang_studi (VARCHAR, nullable)
- timestamps

**Fungsi**: Tabel terpisah untuk data guru (normalisasi)

---

#### `2025_11_30_000003_simplify_users_table.php` ⭐ **BARU**
**Menghapus kolom dari tabel `users`**:
- nomor_induk ❌
- kelas ❌
- kelas_mengajar ❌
- alamat ❌
- no_telepon ❌
- jenis_kelamin ❌
- tanggal_lahir ❌

**Fungsi**: Simplifikasi tabel users, data dipindah ke tabel siswa/guru

---

