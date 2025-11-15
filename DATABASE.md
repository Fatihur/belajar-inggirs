# Struktur Database - Aplikasi Belajar Bahasa Inggris

## Daftar Tabel

### 1. Tabel `peran`
Menyimpan jenis peran pengguna dalam sistem.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| nama_peran | varchar | super_admin, guru, siswa |
| deskripsi | varchar | Deskripsi peran |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 2. Tabel `users`
Menyimpan data pengguna (Super Admin, Guru, Siswa).

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | varchar | Nama lengkap |
| email | varchar | Email (unique) |
| email_verified_at | timestamp | |
| password | varchar | Password (hashed) |
| peran_id | bigint | Foreign key ke tabel peran |
| nomor_induk | varchar | NIP (guru) / NIS (siswa) |
| kelas | varchar | Kelas siswa |
| alamat | text | Alamat lengkap |
| no_telepon | varchar | Nomor telepon |
| jenis_kelamin | enum | L / P |
| tanggal_lahir | date | Tanggal lahir |
| remember_token | varchar | |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 3. Tabel `materi`
Menyimpan materi pembelajaran (Vocabulary & Grammar).

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| judul | varchar | Judul materi |
| jenis_materi | enum | vocabulary / grammar |
| deskripsi | text | Deskripsi materi |
| konten | text | Konten untuk grammar |
| video_url | varchar | URL video YouTube/eksternal |
| video_path | varchar | Path video lokal |
| dibuat_oleh | bigint | Foreign key ke users (guru) |
| urutan | integer | Urutan tampilan |
| aktif | boolean | Status aktif/nonaktif |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 4. Tabel `kosakata`
Menyimpan daftar kosakata untuk materi vocabulary.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| materi_id | bigint | Foreign key ke materi |
| kata_inggris | varchar | Kata dalam bahasa Inggris |
| kata_indonesia | varchar | Terjemahan bahasa Indonesia |
| jenis_kata | varchar | noun, verb, adjective, dll |
| contoh_kalimat | text | Contoh penggunaan |
| audio_path | varchar | Path file audio pelafalan |
| gambar_path | varchar | Path gambar ilustrasi |
| urutan | integer | Urutan tampilan |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 5. Tabel `kuis`
Menyimpan data kuis/latihan soal.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| judul | varchar | Judul kuis |
| deskripsi | text | Deskripsi kuis |
| materi_id | bigint | Foreign key ke materi (nullable) |
| durasi_menit | integer | Durasi pengerjaan (menit) |
| nilai_minimal | integer | Nilai minimal lulus (0-100) |
| tingkat_kesulitan | enum | mudah / sedang / sulit |
| dibuat_oleh | bigint | Foreign key ke users (guru) |
| aktif | boolean | Status aktif/nonaktif |
| acak_soal | boolean | Acak urutan soal |
| tampilkan_jawaban | boolean | Tampilkan jawaban setelah selesai |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 6. Tabel `soal_kuis`
Menyimpan soal-soal dalam kuis.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| kuis_id | bigint | Foreign key ke kuis |
| pertanyaan | text | Teks pertanyaan |
| jenis_soal | enum | pilihan_ganda / benar_salah / isian |
| gambar_path | varchar | Path gambar soal |
| audio_path | varchar | Path audio soal (listening) |
| poin | integer | Poin untuk soal ini |
| urutan | integer | Urutan soal |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 7. Tabel `pilihan_jawaban`
Menyimpan pilihan jawaban untuk soal pilihan ganda.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| soal_id | bigint | Foreign key ke soal_kuis |
| teks_jawaban | text | Teks pilihan jawaban |
| jawaban_benar | boolean | Apakah jawaban benar |
| urutan | integer | Urutan pilihan (A, B, C, D) |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 8. Tabel `percobaan_kuis`
Menyimpan data percobaan siswa mengerjakan kuis.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| kuis_id | bigint | Foreign key ke kuis |
| siswa_id | bigint | Foreign key ke users (siswa) |
| waktu_mulai | timestamp | Waktu mulai mengerjakan |
| waktu_selesai | timestamp | Waktu selesai mengerjakan |
| nilai | integer | Nilai akhir (0-100) |
| jumlah_benar | integer | Jumlah jawaban benar |
| jumlah_salah | integer | Jumlah jawaban salah |
| total_soal | integer | Total soal |
| status | enum | sedang_dikerjakan / selesai / waktu_habis |
| lulus | boolean | Apakah lulus |
| created_at | timestamp | |
| updated_at | timestamp | |

---

### 9. Tabel `jawaban_siswa`
Menyimpan jawaban siswa per soal.

| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| percobaan_id | bigint | Foreign key ke percobaan_kuis |
| soal_id | bigint | Foreign key ke soal_kuis |
| pilihan_jawaban_id | bigint | Foreign key ke pilihan_jawaban (nullable) |
| jawaban_isian | text | Jawaban untuk soal isian |
| benar | boolean | Apakah jawaban benar |
| poin_didapat | integer | Poin yang didapat |
| created_at | timestamp | |
| updated_at | timestamp | |

---

## Relasi Antar Tabel

### Peran & Users
- 1 Peran memiliki banyak Users
- 1 User memiliki 1 Peran

### Users & Materi
- 1 User (Guru) dapat membuat banyak Materi
- 1 Materi dibuat oleh 1 User (Guru)

### Materi & Kosakata
- 1 Materi dapat memiliki banyak Kosakata
- 1 Kosakata milik 1 Materi

### Materi & Kuis
- 1 Materi dapat memiliki banyak Kuis
- 1 Kuis dapat terkait dengan 1 Materi (optional)

### Users & Kuis
- 1 User (Guru) dapat membuat banyak Kuis
- 1 Kuis dibuat oleh 1 User (Guru)

### Kuis & Soal Kuis
- 1 Kuis memiliki banyak Soal
- 1 Soal milik 1 Kuis

### Soal Kuis & Pilihan Jawaban
- 1 Soal memiliki banyak Pilihan Jawaban
- 1 Pilihan Jawaban milik 1 Soal

### Users & Percobaan Kuis
- 1 User (Siswa) dapat memiliki banyak Percobaan Kuis
- 1 Percobaan Kuis milik 1 User (Siswa)

### Kuis & Percobaan Kuis
- 1 Kuis dapat memiliki banyak Percobaan
- 1 Percobaan untuk 1 Kuis

### Percobaan Kuis & Jawaban Siswa
- 1 Percobaan memiliki banyak Jawaban Siswa
- 1 Jawaban Siswa milik 1 Percobaan

---

## Data Default (Seeder)

### Peran
1. **super_admin** - Super Administrator dengan akses penuh
2. **guru** - Guru yang mengelola materi dan kuis
3. **siswa** - Siswa yang mengakses materi dan mengerjakan kuis

### Users Default
1. **Super Admin**
   - Email: admin@belajaringgris.com
   - Password: admin123

2. **Guru Demo**
   - Email: guru@belajaringgris.com
   - Password: guru123

3. **Siswa Demo**
   - Email: siswa@belajaringgris.com
   - Password: siswa123

---

## Cara Menjalankan Migration

```bash
# Fresh migration dengan seeder
php artisan migrate:fresh --seed

# Migration biasa
php artisan migrate

# Rollback
php artisan migrate:rollback

# Reset dan migrate ulang
php artisan migrate:refresh
```
