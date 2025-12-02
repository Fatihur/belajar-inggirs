# 📋 Daftar Tabel Database

> Dokumentasi lengkap struktur tabel berdasarkan file migration

---

## 📊 Ringkasan

**Total Tabel**: 20 tabel  
**Database**: MySQL/MariaDB  
**Charset**: utf8mb4  
**Collation**: utf8mb4_unicode_ci

---

## 1. TABEL `users`

**Fungsi**: Menyimpan data autentikasi pengguna

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NOT NULL | Nama pengguna |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email login |
| email_verified_at | TIMESTAMP | NULL | Waktu verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password (hashed) |
| peran_id | BIGINT | FK → peran, NOT NULL | Role pengguna |
| remember_token | VARCHAR(100) | NULL | Token remember me |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- UNIQUE KEY (email)
- FOREIGN KEY (peran_id) REFERENCES peran(id) ON DELETE CASCADE

---

## 2. TABEL `peran`

**Fungsi**: Menyimpan jenis role pengguna

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| nama_peran | VARCHAR(255) | NOT NULL | super_admin / guru / siswa |
| deskripsi | VARCHAR(255) | NULL | Deskripsi role |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)

---

## 3. TABEL `guru`

**Fungsi**: Menyimpan detail data guru

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT | FK → users, NOT NULL | Relasi ke users |
| nip | VARCHAR(255) | UNIQUE, NOT NULL | Nomor Induk Pegawai |
| nama_lengkap | VARCHAR(255) | NOT NULL | Nama lengkap guru |
| kelas_mengajar | VARCHAR(255) | NOT NULL | Kelas yang diajar (7/8) |
| jenis_kelamin | ENUM('L','P') | NULL | Jenis kelamin |
| tempat_lahir | VARCHAR(255) | NULL | Tempat lahir |
| tanggal_lahir | DATE | NULL | Tanggal lahir |
| alamat | TEXT | NULL | Alamat lengkap |
| no_telepon | VARCHAR(255) | NULL | Nomor telepon |
| pendidikan_terakhir | VARCHAR(255) | NULL | Pendidikan terakhir |
| bidang_studi | VARCHAR(255) | NULL | Bidang studi |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- UNIQUE KEY (nip)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

---

## 4. TABEL `siswa`

**Fungsi**: Menyimpan detail data siswa

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT | FK → users, NOT NULL | Relasi ke users |
| nis | VARCHAR(255) | UNIQUE, NOT NULL | Nomor Induk Siswa |
| kelas | VARCHAR(255) | NOT NULL | Kelas siswa (7/8) |
| nama_lengkap | VARCHAR(255) | NOT NULL | Nama lengkap siswa |
| jenis_kelamin | ENUM('L','P') | NULL | Jenis kelamin |
| tempat_lahir | VARCHAR(255) | NULL | Tempat lahir |
| tanggal_lahir | DATE | NULL | Tanggal lahir |
| alamat | TEXT | NULL | Alamat lengkap |
| no_telepon | VARCHAR(255) | NULL | Nomor telepon |
| nama_orang_tua | VARCHAR(255) | NULL | Nama orang tua/wali |
| no_telepon_orang_tua | VARCHAR(255) | NULL | No. telepon orang tua |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- UNIQUE KEY (nis)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

---

## 5. TABEL `materi`

**Fungsi**: Menyimpan materi pembelajaran

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| judul | VARCHAR(255) | NOT NULL | Judul materi |
| jenis_materi | ENUM('vocabulary','grammar') | NOT NULL | Jenis materi |
| deskripsi | TEXT | NULL | Deskripsi materi |
| konten | TEXT | NULL | Konten (untuk grammar) |
| video_url | VARCHAR(255) | NULL | URL video YouTube |
| video_path | VARCHAR(255) | NULL | Path video lokal |
| dibuat_oleh | BIGINT | FK → users, NOT NULL | Guru pembuat |
| kelas_target | VARCHAR(255) | NULL | Target kelas (7/8) |
| urutan | INT | DEFAULT 0 | Urutan tampilan |
| aktif | BOOLEAN | DEFAULT 1 | Status aktif |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (dibuat_oleh) REFERENCES users(id) ON DELETE CASCADE

---

## 6. TABEL `kosakata`

**Fungsi**: Menyimpan kosakata untuk materi vocabulary

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| materi_id | BIGINT | FK → materi, NOT NULL | Relasi ke materi |
| kata_inggris | VARCHAR(255) | NOT NULL | Kata bahasa Inggris |
| kata_indonesia | VARCHAR(255) | NOT NULL | Terjemahan Indonesia |
| jenis_kata | VARCHAR(255) | NULL | noun/verb/adjective/dll |
| contoh_kalimat | TEXT | NULL | Contoh penggunaan |
| audio_path | VARCHAR(255) | NULL | Path audio pelafalan |
| gambar_path | VARCHAR(255) | NULL | Path gambar ilustrasi |
| urutan | INT | DEFAULT 0 | Urutan tampilan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (materi_id) REFERENCES materi(id) ON DELETE CASCADE

---

## 7. TABEL `kuis`

**Fungsi**: Menyimpan data kuis/ujian

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| judul | VARCHAR(255) | NOT NULL | Judul kuis |
| deskripsi | TEXT | NULL | Deskripsi kuis |
| materi_id | BIGINT | FK → materi, NULL | Relasi ke materi (optional) |
| durasi_menit | INT | DEFAULT 30 | Durasi pengerjaan (menit) |
| nilai_minimal | INT | DEFAULT 70 | Nilai minimal lulus |
| tingkat_kesulitan | ENUM('mudah','sedang','sulit') | DEFAULT 'sedang' | Tingkat kesulitan |
| dibuat_oleh | BIGINT | FK → users, NOT NULL | Guru pembuat |
| kelas_target | VARCHAR(255) | NULL | Target kelas (7/8) |
| aktif | BOOLEAN | DEFAULT 1 | Status aktif |
| acak_soal | BOOLEAN | DEFAULT 0 | Acak urutan soal |
| tampilkan_jawaban | BOOLEAN | DEFAULT 1 | Tampilkan pembahasan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (materi_id) REFERENCES materi(id) ON DELETE SET NULL
- FOREIGN KEY (dibuat_oleh) REFERENCES users(id) ON DELETE CASCADE

---

## 8. TABEL `soal_kuis`

**Fungsi**: Menyimpan soal/pertanyaan kuis

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| kuis_id | BIGINT | FK → kuis, NOT NULL | Relasi ke kuis |
| pertanyaan | TEXT | NOT NULL | Teks pertanyaan |
| jenis_soal | ENUM('pilihan_ganda','benar_salah','isian') | DEFAULT 'pilihan_ganda' | Jenis soal |
| gambar_path | VARCHAR(255) | NULL | Path gambar soal |
| audio_path | VARCHAR(255) | NULL | Path audio soal |
| poin | INT | DEFAULT 10 | Poin soal |
| urutan | INT | DEFAULT 0 | Urutan soal |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (kuis_id) REFERENCES kuis(id) ON DELETE CASCADE

---

## 9. TABEL `pilihan_jawaban`

**Fungsi**: Menyimpan pilihan jawaban untuk soal

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| soal_id | BIGINT | FK → soal_kuis, NOT NULL | Relasi ke soal |
| teks_jawaban | TEXT | NOT NULL | Teks pilihan jawaban |
| jawaban_benar | BOOLEAN | DEFAULT 0 | Apakah jawaban benar |
| urutan | INT | DEFAULT 0 | Urutan pilihan |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (soal_id) REFERENCES soal_kuis(id) ON DELETE CASCADE

---

## 10. TABEL `percobaan_kuis`

**Fungsi**: Menyimpan percobaan siswa mengerjakan kuis

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| kuis_id | BIGINT | FK → kuis, NOT NULL | Relasi ke kuis |
| siswa_id | BIGINT | FK → users, NOT NULL | Relasi ke siswa |
| waktu_mulai | TIMESTAMP | NOT NULL | Waktu mulai mengerjakan |
| waktu_selesai | TIMESTAMP | NULL | Waktu selesai |
| nilai | INT | NULL | Nilai akhir (0-100) |
| jumlah_benar | INT | DEFAULT 0 | Jumlah jawaban benar |
| jumlah_salah | INT | DEFAULT 0 | Jumlah jawaban salah |
| total_soal | INT | DEFAULT 0 | Total soal |
| status | ENUM('sedang_dikerjakan','selesai','waktu_habis') | DEFAULT 'sedang_dikerjakan' | Status percobaan |
| lulus | BOOLEAN | DEFAULT 0 | Apakah lulus |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (kuis_id) REFERENCES kuis(id) ON DELETE CASCADE
- FOREIGN KEY (siswa_id) REFERENCES users(id) ON DELETE CASCADE

---

## 11. TABEL `jawaban_siswa`

**Fungsi**: Menyimpan jawaban siswa per soal

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| percobaan_id | BIGINT | FK → percobaan_kuis, NOT NULL | Relasi ke percobaan |
| soal_id | BIGINT | FK → soal_kuis, NOT NULL | Relasi ke soal |
| pilihan_jawaban_id | BIGINT | FK → pilihan_jawaban, NULL | Pilihan yang dipilih |
| jawaban_isian | TEXT | NULL | Jawaban untuk soal isian |
| benar | BOOLEAN | DEFAULT 0 | Apakah jawaban benar |
| poin_didapat | INT | DEFAULT 0 | Poin yang didapat |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- FOREIGN KEY (percobaan_id) REFERENCES percobaan_kuis(id) ON DELETE CASCADE
- FOREIGN KEY (soal_id) REFERENCES soal_kuis(id) ON DELETE CASCADE
- FOREIGN KEY (pilihan_jawaban_id) REFERENCES pilihan_jawaban(id) ON DELETE SET NULL

---

## 12. TABEL `rich_texts`

**Fungsi**: Menyimpan konten rich text (Trix Editor)

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| record_type | VARCHAR(255) | NOT NULL | Model type (polymorphic) |
| record_id | BIGINT | NOT NULL | Model ID (polymorphic) |
| field | VARCHAR(255) | NOT NULL | Nama field |
| body | LONGTEXT | NULL | Konten HTML |
| created_at | TIMESTAMP | NULL | Waktu dibuat |
| updated_at | TIMESTAMP | NULL | Waktu diupdate |

**Index**:
- PRIMARY KEY (id)
- UNIQUE KEY (field, record_type, record_id)

---

## 13. TABEL `password_reset_tokens`

**Fungsi**: Menyimpan token reset password

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| email | VARCHAR(255) | PK | Email pengguna |
| token | VARCHAR(255) | NOT NULL | Token reset |
| created_at | TIMESTAMP | NULL | Waktu dibuat |

**Index**:
- PRIMARY KEY (email)

---

## 14. TABEL `sessions`

**Fungsi**: Menyimpan session pengguna

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | VARCHAR(255) | PK | Session ID |
| user_id | BIGINT | NULL, INDEXED | User ID |
| ip_address | VARCHAR(45) | NULL | IP address |
| user_agent | TEXT | NULL | User agent browser |
| payload | LONGTEXT | NOT NULL | Session data |
| last_activity | INT | INDEXED | Last activity timestamp |

**Index**:
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (last_activity)

---

## 15. TABEL `cache`

**Fungsi**: Menyimpan cache aplikasi

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| key | VARCHAR(255) | PK | Cache key |
| value | MEDIUMTEXT | NOT NULL | Cache value |
| expiration | INT | NOT NULL | Expiration time |

**Index**:
- PRIMARY KEY (key)

---

## 16. TABEL `cache_locks`

**Fungsi**: Menyimpan lock untuk cache

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| key | VARCHAR(255) | PK | Lock key |
| owner | VARCHAR(255) | NOT NULL | Lock owner |
| expiration | INT | NOT NULL | Expiration time |

**Index**:
- PRIMARY KEY (key)

---

## 17. TABEL `jobs`

**Fungsi**: Menyimpan queue jobs

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| queue | VARCHAR(255) | INDEXED | Queue name |
| payload | LONGTEXT | NOT NULL | Job data |
| attempts | TINYINT | NOT NULL | Jumlah percobaan |
| reserved_at | INT | NULL | Waktu reserved |
| available_at | INT | NOT NULL | Waktu available |
| created_at | INT | NOT NULL | Waktu dibuat |

**Index**:
- PRIMARY KEY (id)
- INDEX (queue)

---

## 18. TABEL `job_batches`

**Fungsi**: Menyimpan batch jobs

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | VARCHAR(255) | PK | Batch ID |
| name | VARCHAR(255) | NOT NULL | Batch name |
| total_jobs | INT | NOT NULL | Total jobs |
| pending_jobs | INT | NOT NULL | Pending jobs |
| failed_jobs | INT | NOT NULL | Failed jobs |
| failed_job_ids | LONGTEXT | NOT NULL | Failed job IDs |
| options | MEDIUMTEXT | NULL | Batch options |
| cancelled_at | INT | NULL | Waktu cancelled |
| created_at | INT | NOT NULL | Waktu dibuat |
| finished_at | INT | NULL | Waktu selesai |

**Index**:
- PRIMARY KEY (id)

---

## 19. TABEL `failed_jobs`

**Fungsi**: Menyimpan jobs yang gagal

| Field | Type | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT | PK, AUTO_INCREMENT | Primary key |
| uuid | VARCHAR(255) | UNIQUE | UUID job |
| connection | TEXT | NOT NULL | Connection name |
| queue | TEXT | NOT NULL | Queue name |
| payload | LONGTEXT | NOT NULL | Job data |
| exception | LONGTEXT | NOT NULL | Exception message |
| failed_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu gagal |

**Index**:
- PRIMARY KEY (id)
- UNIQUE KEY (uuid)

---

## 🔗 Relasi Foreign Key

| Child Table | Parent Table | ON DELETE |
|-------------|--------------|-----------|
| users | peran | CASCADE |
| guru | users | CASCADE |
| siswa | users | CASCADE |
| materi | users | CASCADE |
| kosakata | materi | CASCADE |
| kuis | users | CASCADE |
| kuis | materi | SET NULL |
| soal_kuis | kuis | CASCADE |
| pilihan_jawaban | soal_kuis | CASCADE |
| percobaan_kuis | kuis | CASCADE |
| percobaan_kuis | users | CASCADE |
| jawaban_siswa | percobaan_kuis | CASCADE |
| jawaban_siswa | soal_kuis | CASCADE |
| jawaban_siswa | pilihan_jawaban | SET NULL |

---

**Dibuat**: 2025-11-30  
**Versi**: 1.3.2  
**Total Tabel**: 20
