# 🗄️ Skema Database - Aplikasi Belajar Bahasa Inggris

## 📊 Overview

Database terdiri dari **14 tabel** yang saling berelasi untuk mendukung sistem pembelajaran bahasa Inggris berbasis kelas (7 & 8).

---

## 🎯 Diagram Relasi Sederhana

```
┌──────────┐
│  PERAN   │
└────┬─────┘
     │ 1:N
     ▼
┌──────────┐         ┌──────────┐         ┌──────────┐
│  USERS   │────────►│  MATERI  │────────►│ KOSAKATA │
└────┬─────┘   1:N   └──────────┘   1:N   └──────────┘
     │
     │ 1:N
     ▼
┌──────────┐         ┌──────────┐         ┌──────────┐
│   KUIS   │────────►│SOAL_KUIS │────────►│ PILIHAN  │
└────┬─────┘   1:N   └────┬─────┘   1:N   │ JAWABAN  │
     │                    │                └────┬─────┘
     │ 1:N                │ 1:N                 │
     ▼                    ▼                     │ N:1
┌──────────┐         ┌──────────┐              │
│PERCOBAAN │────────►│ JAWABAN  │◄─────────────┘
│   KUIS   │   1:N   │  SISWA   │
└──────────┘         └──────────┘
```

---

## 📋 Tabel Utama

### 1️⃣ PERAN (Roles)
Menyimpan jenis peran pengguna dalam sistem.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| nama_peran | VARCHAR | super_admin / guru / siswa |
| deskripsi | VARCHAR | Deskripsi peran |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diupdate |

**Data**: 3 peran (super_admin, guru, siswa)

---

### 2️⃣ USERS (Pengguna)
Menyimpan data semua pengguna (admin, guru, siswa).

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| name | VARCHAR | Nama lengkap |
| email | VARCHAR | Email (unique) |
| password | VARCHAR | Password (hashed) |
| 🔗 peran_id | BIGINT | FK → peran |
| nomor_induk | VARCHAR | NIP (guru) / NIS (siswa) |
| kelas | VARCHAR | Kelas siswa: 7 / 8 |
| kelas_mengajar | VARCHAR | Kelas guru: 7 / 8 |
| alamat | TEXT | Alamat lengkap |
| no_telepon | VARCHAR | Nomor telepon |
| jenis_kelamin | ENUM | L / P |
| tanggal_lahir | DATE | Tanggal lahir |
| email_verified_at | TIMESTAMP | Verifikasi email |
| remember_token | VARCHAR | Token remember |

**Data**: 17 users (3 admin + 4 guru + 10 siswa)

**Relasi**:
- Belongs to `peran` (N:1)
- Has many `materi` (1:N) - untuk guru
- Has many `kuis` (1:N) - untuk guru
- Has many `percobaan_kuis` (1:N) - untuk siswa

---

### 3️⃣ MATERI (Materials)
Menyimpan materi pembelajaran (Grammar & Vocabulary).

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| judul | VARCHAR | Judul materi |
| jenis_materi | ENUM | vocabulary / grammar |
| deskripsi | TEXT | Deskripsi singkat |
| konten | TEXT | Konten (untuk grammar) |
| video_url | VARCHAR | URL YouTube |
| video_path | VARCHAR | Path video lokal |
| 🔗 dibuat_oleh | BIGINT | FK → users (guru) |
| kelas_target | VARCHAR | 7 / 8 |
| urutan | INT | Urutan tampilan |
| aktif | BOOLEAN | Status aktif |

**Data**: 10 materi (6 kelas 7 + 4 kelas 8)

**Relasi**:
- Belongs to `users` (N:1) - dibuat oleh guru
- Has many `kosakata` (1:N) - untuk vocabulary
- Has many `kuis` (1:N) - kuis terkait materi

---

### 4️⃣ KOSAKATA (Vocabularies)
Menyimpan kosakata untuk materi vocabulary.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| 🔗 materi_id | BIGINT | FK → materi |
| kata_inggris | VARCHAR | Kata bahasa Inggris |
| kata_indonesia | VARCHAR | Terjemahan Indonesia |
| jenis_kata | VARCHAR | noun/verb/adjective |
| contoh_kalimat | TEXT | Contoh penggunaan |
| audio_path | VARCHAR | Path audio pelafalan |
| gambar_path | VARCHAR | Path gambar ilustrasi |
| urutan | INT | Urutan tampilan |

**Data**: 50 kosakata (30 kelas 7 + 20 kelas 8)

**Relasi**:
- Belongs to `materi` (N:1)

---

### 5️⃣ KUIS (Quizzes)
Menyimpan data kuis/ujian.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| judul | VARCHAR | Judul kuis |
| deskripsi | TEXT | Deskripsi kuis |
| 🔗 materi_id | BIGINT | FK → materi (nullable) |
| durasi_menit | INT | Durasi (menit) |
| nilai_minimal | INT | Nilai lulus (0-100) |
| tingkat_kesulitan | ENUM | mudah/sedang/sulit |
| 🔗 dibuat_oleh | BIGINT | FK → users (guru) |
| kelas_target | VARCHAR | 7 / 8 |
| aktif | BOOLEAN | Status aktif |
| acak_soal | BOOLEAN | Acak urutan soal |
| tampilkan_jawaban | BOOLEAN | Tampilkan pembahasan |

**Data**: 7 kuis (4 kelas 7 + 3 kelas 8)

**Relasi**:
- Belongs to `users` (N:1) - dibuat oleh guru
- Belongs to `materi` (N:1) - optional
- Has many `soal_kuis` (1:N)
- Has many `percobaan_kuis` (1:N)

---

### 6️⃣ SOAL_KUIS (Quiz Questions)
Menyimpan soal/pertanyaan kuis.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| 🔗 kuis_id | BIGINT | FK → kuis |
| pertanyaan | TEXT | Teks pertanyaan |
| jenis_soal | ENUM | pilihan_ganda/benar_salah/isian |
| gambar_path | VARCHAR | Path gambar soal |
| audio_path | VARCHAR | Path audio (listening) |
| poin | INT | Poin soal |
| urutan | INT | Urutan soal |

**Data**: 19 soal (13 kelas 7 + 6 kelas 8)

**Relasi**:
- Belongs to `kuis` (N:1)
- Has many `pilihan_jawaban` (1:N)
- Has many `jawaban_siswa` (1:N)

---

### 7️⃣ PILIHAN_JAWABAN (Answer Choices)
Menyimpan pilihan jawaban untuk soal.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| 🔗 soal_id | BIGINT | FK → soal_kuis |
| teks_jawaban | TEXT | Teks pilihan |
| jawaban_benar | BOOLEAN | Jawaban benar? |
| urutan | INT | Urutan pilihan |

**Data**: 70 pilihan (48 kelas 7 + 22 kelas 8)

**Relasi**:
- Belongs to `soal_kuis` (N:1)
- Has many `jawaban_siswa` (1:N)

---

### 8️⃣ PERCOBAAN_KUIS (Quiz Attempts)
Menyimpan percobaan siswa mengerjakan kuis.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| 🔗 kuis_id | BIGINT | FK → kuis |
| 🔗 siswa_id | BIGINT | FK → users |
| waktu_mulai | TIMESTAMP | Waktu mulai |
| waktu_selesai | TIMESTAMP | Waktu selesai |
| nilai | INT | Nilai (0-100) |
| jumlah_benar | INT | Jumlah benar |
| jumlah_salah | INT | Jumlah salah |
| total_soal | INT | Total soal |
| status | ENUM | sedang_dikerjakan/selesai/waktu_habis |
| lulus | BOOLEAN | Lulus? |

**Data**: 26 percobaan (24 selesai + 1 sedang + 1 timeout)

**Relasi**:
- Belongs to `kuis` (N:1)
- Belongs to `users` (N:1) - siswa
- Has many `jawaban_siswa` (1:N)

---

### 9️⃣ JAWABAN_SISWA (Student Answers)
Menyimpan jawaban siswa per soal.

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| 🔗 percobaan_id | BIGINT | FK → percobaan_kuis |
| 🔗 soal_id | BIGINT | FK → soal_kuis |
| 🔗 pilihan_jawaban_id | BIGINT | FK → pilihan_jawaban |
| jawaban_isian | TEXT | Jawaban isian |
| benar | BOOLEAN | Benar? |
| poin_didapat | INT | Poin didapat |

**Data**: 96 jawaban siswa

**Relasi**:
- Belongs to `percobaan_kuis` (N:1)
- Belongs to `soal_kuis` (N:1)
- Belongs to `pilihan_jawaban` (N:1)

---

### 🔟 RICH_TEXTS
Menyimpan konten rich text (Trix Editor).

| Field | Type | Keterangan |
|-------|------|------------|
| 🔑 id | BIGINT | Primary Key |
| field | VARCHAR | Nama field |
| body | LONGTEXT | Konten HTML |
| recordable_type | VARCHAR | Model type |
| recordable_id | BIGINT | Model ID |

**Relasi**: Polymorphic relation

---

## 🔐 Foreign Key Constraints

| Parent | Child | ON DELETE |
|--------|-------|-----------|
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

---

## 🎯 Business Rules

### Sistem Kelas
- ✅ Guru memiliki `kelas_mengajar` (7 atau 8)
- ✅ Siswa memiliki `kelas` (7 atau 8)
- ✅ Materi memiliki `kelas_target` (7 atau 8)
- ✅ Kuis memiliki `kelas_target` (7 atau 8)
- ✅ Data otomatis ter-filter berdasarkan kelas

### Isolasi Data
- 🔒 Guru kelas 7 hanya lihat data kelas 7
- 🔒 Guru kelas 8 hanya lihat data kelas 8
- 🔒 Siswa kelas 7 hanya lihat materi/kuis kelas 7
- 🔒 Siswa kelas 8 hanya lihat materi/kuis kelas 8
- 🔓 Super admin lihat semua data

### Validasi
- ✅ Email harus unique
- ✅ Kuis harus punya minimal 1 soal
- ✅ Soal pilihan ganda harus punya minimal 2 pilihan
- ✅ Harus ada tepat 1 jawaban benar per soal
- ✅ Nilai dihitung otomatis dari jawaban benar
- ✅ Lulus jika nilai ≥ nilai_minimal

---

## 📊 Statistik Data (After Seeding)

| Tabel | Total | Kelas 7 | Kelas 8 |
|-------|-------|---------|---------|
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

## 🔍 Contoh Query

### 1. Get Materi untuk Siswa Kelas 7
```sql
SELECT * FROM materi 
WHERE kelas_target = '7' AND aktif = 1
ORDER BY urutan;
```

### 2. Get Kuis dengan Jumlah Soal
```sql
SELECT k.*, COUNT(s.id) as jumlah_soal
FROM kuis k
LEFT JOIN soal_kuis s ON k.id = s.kuis_id
WHERE k.kelas_target = '7'
GROUP BY k.id;
```

### 3. Get Nilai Siswa
```sql
SELECT 
    u.name as nama_siswa,
    k.judul as judul_kuis,
    p.nilai,
    p.status,
    p.lulus
FROM percobaan_kuis p
JOIN users u ON p.siswa_id = u.id
JOIN kuis k ON p.kuis_id = k.id
WHERE k.kelas_target = '7'
ORDER BY p.waktu_selesai DESC;
```

### 4. Get Detail Jawaban Siswa
```sql
SELECT 
    s.pertanyaan,
    pj.teks_jawaban,
    js.benar,
    js.poin_didapat
FROM jawaban_siswa js
JOIN soal_kuis s ON js.soal_id = s.id
LEFT JOIN pilihan_jawaban pj ON js.pilihan_jawaban_id = pj.id
WHERE js.percobaan_id = ?
ORDER BY s.urutan;
```

---

## 🛡️ Security

### Password
- ✅ Hashed dengan bcrypt
- ✅ Minimum 8 karakter
- ✅ Remember token untuk persistent login

### File Upload
- ✅ Validasi tipe file (image, audio, video)
- ✅ Validasi ukuran file
- ✅ Path disimpan di database

### SQL Injection
- ✅ Eloquent ORM
- ✅ Prepared statements
- ✅ Input validation

---

## 📝 Catatan Teknis

**Database**: MySQL/MariaDB  
**Charset**: utf8mb4  
**Collation**: utf8mb4_unicode_ci  
**Engine**: InnoDB  
**Laravel Version**: 12.x  
**PHP Version**: 8.2+

---

**Last Updated**: 2025-11-20  
**Version**: 1.3.2  
**Status**: ✅ Production Ready
