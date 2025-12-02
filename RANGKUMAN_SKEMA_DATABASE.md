# 📊 Rangkuman Skema Database

> Rangkuman lengkap struktur database berdasarkan analisis semua file migration

---

## 🎯 Gambaran Umum

Database aplikasi **Belajar Bahasa Inggris** terdiri dari **20 tabel** yang dibagi menjadi 4 kategori utama:

1. **User Management** (5 tabel) - Mengelola pengguna dan autentikasi
2. **Content Management** (3 tabel) - Mengelola materi pembelajaran
3. **Quiz System** (5 tabel) - Mengelola kuis dan penilaian
4. **System Tables** (7 tabel) - Cache, jobs, sessions, dll

---

## 👥 1. USER MANAGEMENT

### Struktur Pengguna
Sistem menggunakan **role-based access control** dengan 3 jenis pengguna:
- **Super Admin** - Mengelola seluruh sistem
- **Guru** - Membuat materi dan kuis untuk kelas tertentu (7 atau 8)
- **Siswa** - Mengakses materi dan mengerjakan kuis sesuai kelasnya

### Tabel Terkait

**`users`** - Tabel utama pengguna
- Menyimpan: id, name, email, password
- Relasi ke `peran` untuk menentukan role
- Setelah normalisasi: hanya data login, detail dipindah ke tabel `guru`/`siswa`

**`peran`** - Jenis role pengguna
- Menyimpan: super_admin, guru, siswa
- Relasi 1:N dengan `users`

**`guru`** - Detail data guru
- Menyimpan: NIP, nama_lengkap, kelas_mengajar (7/8), biodata
- Relasi 1:1 dengan `users` via user_id
- Field khusus: pendidikan_terakhir, bidang_studi

**`siswa`** - Detail data siswa
- Menyimpan: NIS, nama_lengkap, kelas (7/8), biodata
- Relasi 1:1 dengan `users` via user_id
- Field khusus: nama_orang_tua, no_telepon_orang_tua

**`password_reset_tokens`** - Token reset password
- Menyimpan token untuk fitur lupa password

### Sistem Kelas
- Guru memiliki `kelas_mengajar` → menentukan kelas yang diajar (7 atau 8)
- Siswa memiliki `kelas` → menentukan kelas siswa (7 atau 8)
- Data otomatis ter-filter berdasarkan kelas untuk isolasi data

---

## 📚 2. CONTENT MANAGEMENT

### Struktur Konten
Materi pembelajaran dibagi menjadi 2 jenis:
- **Grammar** - Materi tata bahasa dengan konten text/video
- **Vocabulary** - Materi kosakata dengan daftar kata + audio + gambar

### Tabel Terkait

**`materi`** - Materi pembelajaran
- Jenis: vocabulary atau grammar
- Grammar: konten text (rich text) + video (URL/upload)
- Vocabulary: hanya judul & deskripsi, detail di tabel `kosakata`
- Field penting: `kelas_target` (7/8), `dibuat_oleh` (guru), `aktif`, `urutan`
- Relasi: dibuat oleh guru, punya banyak kosakata

**`kosakata`** - Daftar kosakata untuk materi vocabulary
- Menyimpan: kata_inggris, kata_indonesia, jenis_kata
- Media: audio_path (pelafalan), gambar_path (ilustrasi)
- Contoh: contoh_kalimat untuk setiap kata
- Relasi: belongs to `materi`

**`rich_texts`** - Konten rich text (Trix Editor)
- Polymorphic relation untuk menyimpan konten HTML
- Digunakan untuk konten materi grammar dan deskripsi kuis
- Format: field, body, recordable_type, recordable_id

### Sistem Kelas pada Konten
- Materi memiliki `kelas_target` (7 atau 8)
- Guru kelas 7 hanya bisa buat materi kelas 7
- Siswa kelas 7 hanya bisa lihat materi kelas 7

---

## 📝 3. QUIZ SYSTEM

### Struktur Kuis
Sistem kuis yang lengkap dengan berbagai jenis soal dan tracking jawaban:
- **Kuis** - Container untuk soal-soal
- **Soal** - 3 jenis: pilihan ganda, benar/salah, isian
- **Pilihan Jawaban** - Untuk soal pilihan ganda/benar-salah
- **Percobaan** - Tracking siswa mengerjakan kuis
- **Jawaban Siswa** - Detail jawaban per soal

### Tabel Terkait

**`kuis`** - Data kuis/ujian
- Setting: durasi_menit, nilai_minimal, tingkat_kesulitan
- Opsi: acak_soal, tampilkan_jawaban
- Field penting: `kelas_target` (7/8), `dibuat_oleh` (guru), `materi_id` (optional)
- Relasi: dibuat oleh guru, terkait materi (optional), punya banyak soal

**`soal_kuis`** - Soal/pertanyaan kuis
- Jenis soal: pilihan_ganda, benar_salah, isian
- Media: gambar_path, audio_path (untuk listening)
- Poin: setiap soal punya poin berbeda
- Relasi: belongs to `kuis`, punya banyak pilihan jawaban

**`pilihan_jawaban`** - Pilihan jawaban untuk soal
- Menyimpan: teks_jawaban, jawaban_benar (boolean)
- Hanya untuk soal pilihan_ganda dan benar_salah
- Relasi: belongs to `soal_kuis`

**`percobaan_kuis`** - Percobaan siswa mengerjakan kuis
- Tracking: waktu_mulai, waktu_selesai
- Hasil: nilai (0-100), jumlah_benar, jumlah_salah, total_soal
- Status: sedang_dikerjakan, selesai, waktu_habis
- Lulus: boolean (nilai ≥ nilai_minimal)
- Relasi: belongs to `kuis` dan `siswa`, punya banyak jawaban

**`jawaban_siswa`** - Jawaban siswa per soal
- Untuk pilihan ganda: pilihan_jawaban_id
- Untuk isian: jawaban_isian (text)
- Hasil: benar (boolean), poin_didapat
- Relasi: belongs to `percobaan_kuis`, `soal_kuis`, `pilihan_jawaban`

### Flow Mengerjakan Kuis
1. Siswa mulai kuis → create `percobaan_kuis` (status: sedang_dikerjakan)
2. Siswa jawab soal → create `jawaban_siswa` per soal
3. Siswa submit/waktu habis → update `percobaan_kuis`:
   - Hitung nilai dari jawaban benar
   - Set status: selesai/waktu_habis
   - Set lulus: true/false

### Sistem Kelas pada Kuis
- Kuis memiliki `kelas_target` (7 atau 8)
- Guru kelas 7 hanya bisa buat kuis kelas 7
- Siswa kelas 7 hanya bisa lihat & kerjakan kuis kelas 7

---

## 🔧 4. SYSTEM TABLES

### Tabel Laravel Default

**`sessions`** - Session management
- Menyimpan session user yang login
- Tracking: user_id, ip_address, user_agent, last_activity

**`cache` & `cache_locks`** - Cache system
- Menyimpan cache aplikasi untuk performa
- Cache locks untuk prevent race condition

**`jobs`, `job_batches`, `failed_jobs`** - Queue system
- Untuk background jobs (email, notifikasi, dll)
- Tracking jobs yang gagal untuk retry

---

## 🔗 Relasi Antar Tabel

### Relasi Utama

```
peran (1) ──► users (N)
  │
  └──► guru (1:1) ──► materi (1:N) ──► kosakata (1:N)
  │                   │
  │                   └──► kuis (1:N)
  │
  └──► siswa (1:1) ──► percobaan_kuis (1:N)

kuis (1) ──► soal_kuis (N) ──► pilihan_jawaban (N)
  │
  └──► percobaan_kuis (N) ──► jawaban_siswa (N)
                                  │
                                  └──► soal_kuis (N:1)
                                  └──► pilihan_jawaban (N:1)
```

### Foreign Key Constraints

**CASCADE (hapus parent → hapus child)**:
- peran → users
- users → guru, siswa
- users → materi, kuis, percobaan_kuis
- materi → kosakata
- kuis → soal_kuis, percobaan_kuis
- soal_kuis → pilihan_jawaban, jawaban_siswa
- percobaan_kuis → jawaban_siswa

**SET NULL (hapus parent → FK jadi NULL)**:
- materi → kuis (kuis bisa tanpa materi)
- pilihan_jawaban → jawaban_siswa (jika pilihan dihapus)

---

## 🎯 Fitur Utama Database

### 1. Role-Based Access Control (RBAC)
- 3 role: super_admin, guru, siswa
- Setiap user punya 1 role via `peran_id`
- Middleware filter akses berdasarkan role

### 2. Class-Based Isolation
- Guru: `kelas_mengajar` (7 atau 8)
- Siswa: `kelas` (7 atau 8)
- Materi: `kelas_target` (7 atau 8)
- Kuis: `kelas_target` (7 atau 8)
- **Isolasi data**: Guru/siswa kelas 7 tidak bisa akses data kelas 8

### 3. Content Management
- 2 jenis materi: Grammar (text/video) & Vocabulary (kata-kata)
- Rich text editor untuk konten
- Upload media: video, audio, gambar
- Urutan materi bisa diatur

### 4. Quiz System
- 3 jenis soal: pilihan ganda, benar/salah, isian
- Timer otomatis (durasi_menit)
- Auto-submit saat waktu habis
- Acak soal (optional)
- Tampilkan pembahasan (optional)
- Tracking percobaan & jawaban detail

### 5. Grading System
- Nilai otomatis dihitung dari jawaban benar
- Poin per soal bisa berbeda
- Nilai minimal untuk lulus (configurable)
- Status lulus/tidak lulus otomatis

### 6. Data Normalization
- User data dipisah ke tabel `guru` dan `siswa`
- Tabel `users` hanya untuk autentikasi
- Detail profil di tabel masing-masing
- Menghindari NULL values untuk field yang tidak relevan

---

## 📊 Statistik Database

### Jumlah Tabel: 20
- User Management: 5 tabel
- Content Management: 3 tabel
- Quiz System: 5 tabel
- System Tables: 7 tabel

### Jumlah Foreign Keys: 15
- users ← peran
- guru, siswa ← users
- materi ← users (guru)
- kosakata ← materi
- kuis ← users (guru), materi
- soal_kuis ← kuis
- pilihan_jawaban ← soal_kuis
- percobaan_kuis ← kuis, users (siswa)
- jawaban_siswa ← percobaan_kuis, soal_kuis, pilihan_jawaban

### Jumlah Index
- Primary Keys: 20 (semua tabel)
- Unique Keys: 5 (email, nis, nip, uuid, rich_texts composite)
- Foreign Keys: 15 (auto-indexed)
- Custom Index: 3 (sessions.last_activity, jobs.queue, dll)

---

## 🔐 Security Features

### Authentication
- Password hashing (bcrypt)
- Email verification
- Remember token untuk persistent login
- Password reset via token

### Data Isolation
- Class-based filtering (kelas 7 vs 8)
- Role-based access control
- Foreign key constraints untuk data integrity

### File Upload
- Path storage (bukan binary di database)
- Validasi tipe file di aplikasi
- Separate folders per jenis (video, audio, image)

---

## 💡 Design Decisions

### 1. Normalisasi User Data
**Keputusan**: Pisahkan data guru dan siswa ke tabel terpisah

**Alasan**:
- Guru dan siswa punya field berbeda
- Menghindari banyak NULL values
- Lebih mudah extend field khusus
- Query lebih efisien

### 2. Sistem Kelas
**Keputusan**: Gunakan VARCHAR untuk kelas (bukan INT atau ENUM)

**Alasan**:
- Fleksibel untuk format kelas (7, 8, atau "7A", "7B" di masa depan)
- Mudah di-filter dengan WHERE clause
- Tidak perlu migration jika ada perubahan format

### 3. Materi & Kosakata Terpisah
**Keputusan**: Tabel `kosakata` terpisah dari `materi`

**Alasan**:
- 1 materi vocabulary bisa punya banyak kosakata
- Setiap kosakata punya audio & gambar sendiri
- Mudah CRUD kosakata tanpa touch materi
- Normalisasi data

### 4. Percobaan & Jawaban Terpisah
**Keputusan**: Tabel `percobaan_kuis` dan `jawaban_siswa` terpisah

**Alasan**:
- 1 percobaan punya banyak jawaban
- Tracking detail per soal
- Bisa analisis jawaban salah
- History lengkap untuk review

### 5. Rich Text Table
**Keputusan**: Gunakan polymorphic relation untuk rich text

**Alasan**:
- 1 tabel untuk semua konten rich text
- Tidak perlu kolom LONGTEXT di setiap tabel
- Package Laravel Rich Text Laravel
- Mudah manage attachments

---

## 📝 Catatan Teknis

**Database Engine**: InnoDB (support foreign keys & transactions)  
**Charset**: utf8mb4 (support emoji & special characters)  
**Collation**: utf8mb4_unicode_ci (case-insensitive)  
**Laravel Version**: 12.x  
**PHP Version**: 8.2+  

**Naming Convention**:
- Tabel: lowercase, bahasa Indonesia
- Field: snake_case, bahasa Indonesia
- Foreign Key: `{table}_id`
- Timestamps: `created_at`, `updated_at`

---

**Dibuat**: 2025-11-30  
**Versi**: 1.3.2  
**Status**: ✅ Production Ready
