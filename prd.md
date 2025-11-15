
# Product Requirements Document (PRD)

## Aplikasi Media Pembelajaran Interaktif Bahasa Inggris Berbasis Web

### 1. Gambaran Umum

Aplikasi web pembelajaran bahasa Inggris interaktif yang dirancang untuk memfasilitasi proses belajar mengajar dengan fitur manajemen materi, quiz, dan monitoring progress siswa.

### 2. Pengguna dan Peran

#### 2.1 Super Admin

**Fungsi Utama:**
- Mengelola seluruh sistem dan pengguna

**Fitur:**
- Login dan autentikasi
- Mengelola akun guru (CRUD - Create, Read, Update, Delete)
- Mengelola akun siswa (CRUD)
- Melihat statistik penggunaan sistem
- Logout

---

#### 2.2 Guru

**Fungsi Utama:**
- Mengelola konten pembelajaran dan monitoring siswa

**Fitur:**

**a. Autentikasi**
- Login dengan kredensial guru
- Logout

**b. Dashboard**
- Melihat ringkasan progress siswa
- Melihat tingkat ketuntasan belajar
- Melihat statistik nilai quiz
- Grafik dan visualisasi data pembelajaran

**c. Manajemen Materi**
- Melihat daftar materi yang tersedia
- Menambah materi baru
- Mengubah materi yang sudah ada
- Menghapus materi
- Upload dan kelola video pembelajaran
- Kelola kosa kata (vocabulary)
- Upload audio pelafalan untuk setiap kosa kata
- Organisasi materi sesuai kurikulum

**d. Manajemen Quiz**
- Melihat daftar quiz
- Membuat quiz baru
- Mengubah quiz yang sudah ada
- Menghapus quiz
- Melihat hasil quiz siswa
- Mengatur tingkat kesulitan soal

---

#### 2.3 Siswa

**Fungsi Utama:**
- Mengakses materi pembelajaran dan mengerjakan quiz

**Fitur:**

**a. Autentikasi**
- Login dengan kredensial siswa
- Logout

**b. Dashboard/Home**
- Melihat ringkasan materi yang tersedia
- Melihat progress quiz pribadi
- Melihat nilai dan pencapaian
- Notifikasi materi atau quiz baru

**c. Menu Materi**

**Vocabulary:**
- Daftar kosa kata dengan kategori
- Audio pelafalan untuk setiap kata
- Contoh penggunaan dalam kalimat
- Fitur pencarian kata

**Grammar:**
- Video pembelajaran grammar
- Penjelasan aturan tata bahasa
- Contoh penggunaan
- Catatan penting

**d. Quiz/Latihan Soal**
- Mengerjakan quiz yang tersedia
- Melihat hasil quiz secara langsung
- Review jawaban yang salah
- Riwayat quiz yang pernah dikerjakan
- Skor dan feedback

---

### 3. Fitur Teknis

#### 3.1 Autentikasi & Autorisasi
- Role-based access control (Super Admin, Guru, Siswa)
- Session management
- Password encryption

#### 3.2 Manajemen Konten
- Upload file (video, audio)
- CRUD operations untuk materi dan quiz
- Kategorisasi konten

#### 3.3 Tracking & Reporting
- Progress tracking siswa
- Quiz scoring system
- Dashboard analytics

#### 3.4 User Interface
- Responsive design (mobile-friendly)
- Intuitive navigation
- Interactive learning components

---
