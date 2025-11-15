# 📖 Panduan Penggunaan untuk Guru

## Daftar Isi
1. [Login](#login)
2. [Dashboard](#dashboard)
3. [Kelola Materi](#kelola-materi)
4. [Kelola Kosakata](#kelola-kosakata)
5. [Tips & Trik](#tips--trik)

---

## 🔐 Login

1. Buka aplikasi di browser: `http://localhost:8000`
2. Masukkan email dan password Anda
3. Klik tombol **Login**
4. Anda akan diarahkan ke Dashboard Guru

**Akun Demo:**
- Email: `guru@belajaringgris.com`
- Password: `guru123`

---

## 📊 Dashboard

Dashboard menampilkan:
- **Materi Saya**: Total materi yang sudah dibuat
- **Kuis Saya**: Total kuis yang sudah dibuat
- **Total Siswa**: Jumlah siswa terdaftar
- **Statistik Kuis**: Tabel dengan informasi:
  - Judul kuis
  - Tingkat kesulitan
  - Jumlah percobaan
  - Rata-rata nilai
  - Tingkat ketuntasan
  - Status aktif/nonaktif

**Aksi Cepat:**
- Tombol **Tambah Materi Baru**
- Tombol **Tambah Kuis Baru**

---

## 📚 Kelola Materi

### Melihat Daftar Materi

1. Klik menu **Kelola Materi** di sidebar
2. Anda akan melihat tabel berisi:
   - Judul materi
   - Jenis (Vocabulary/Grammar)
   - Jumlah kosakata (untuk Vocabulary)
   - Urutan
   - Status (Aktif/Nonaktif)
   - Tombol aksi (Detail, Edit, Hapus)

### Menambah Materi Baru

#### A. Materi Grammar

1. Klik tombol **Tambah Materi**
2. Isi form:
   - **Judul Materi** (wajib)
   - **Jenis Materi**: Pilih **Grammar**
   - **Deskripsi**: Penjelasan singkat materi
   - **Konten Materi**: Penjelasan lengkap grammar
   - **URL Video**: Link YouTube/Vimeo (opsional)
   - **Upload Video**: Upload file video lokal (opsional)
     - Format: mp4, avi, mov
     - Maksimal: 50MB
   - **Urutan**: Nomor urutan tampilan (default: 0)
   - **Aktifkan materi**: Centang untuk mengaktifkan
3. Klik **Simpan**

**Catatan:**
- Anda bisa menggunakan URL video ATAU upload video, tidak perlu keduanya
- Video yang diupload akan disimpan di server

#### B. Materi Vocabulary

1. Klik tombol **Tambah Materi**
2. Isi form:
   - **Judul Materi** (wajib)
   - **Jenis Materi**: Pilih **Vocabulary**
   - **Deskripsi**: Penjelasan singkat materi
   - **Urutan**: Nomor urutan tampilan
   - **Aktifkan materi**: Centang untuk mengaktifkan
3. Klik **Simpan**
4. Anda akan diarahkan ke halaman detail untuk menambah kosakata

### Mengedit Materi

1. Klik tombol **Edit** (ikon pensil) pada materi yang ingin diedit
2. Ubah data yang diperlukan
3. Klik **Update**

**Catatan:**
- Jika mengupload video baru, video lama akan otomatis terhapus
- Kosongkan field video jika tidak ingin mengubah video

### Menghapus Materi

1. Klik tombol **Hapus** (ikon tempat sampah)
2. Konfirmasi penghapusan
3. Materi dan semua kosakata terkait akan terhapus

**⚠️ Peringatan:**
- Penghapusan bersifat permanen
- Semua kosakata dalam materi Vocabulary akan ikut terhapus
- File video, audio, dan gambar akan otomatis terhapus

---

## 📝 Kelola Kosakata

### Melihat Detail Materi Vocabulary

1. Klik tombol **Detail** (ikon mata) pada materi Vocabulary
2. Anda akan melihat:
   - Informasi materi
   - Daftar kosakata dalam tabel
   - Tombol **Tambah Kosakata**

### Menambah Kosakata

1. Di halaman detail materi, klik **Tambah Kosakata**
2. Modal akan muncul, isi form:
   - **Kata Inggris** (wajib): Kata dalam bahasa Inggris
   - **Terjemahan Indonesia** (wajib): Arti dalam bahasa Indonesia
   - **Jenis Kata** (opsional):
     - Noun (Kata Benda)
     - Verb (Kata Kerja)
     - Adjective (Kata Sifat)
     - Adverb (Kata Keterangan)
     - Pronoun (Kata Ganti)
   - **Urutan**: Nomor urutan tampilan
   - **Contoh Kalimat** (opsional): Contoh penggunaan kata
   - **Audio Pelafalan** (opsional):
     - Format: mp3, wav
     - Maksimal: 5MB
   - **Gambar Ilustrasi** (opsional):
     - Format: jpg, png
     - Maksimal: 2MB
3. Klik **Simpan**

**Tips:**
- Gunakan audio untuk membantu siswa belajar pelafalan
- Gunakan gambar untuk mempermudah pemahaman
- Contoh kalimat sangat membantu siswa memahami konteks penggunaan

### Menghapus Kosakata

1. Di halaman detail materi, klik tombol **Hapus** pada kosakata
2. Konfirmasi penghapusan
3. Kosakata dan file terkait (audio, gambar) akan terhapus

---

## 💡 Tips & Trik

### Membuat Materi yang Efektif

1. **Judul yang Jelas**
   - Gunakan judul yang deskriptif
   - Contoh: "Simple Present Tense" bukan "Tense 1"

2. **Deskripsi yang Informatif**
   - Jelaskan apa yang akan dipelajari siswa
   - Sebutkan level kesulitan jika perlu

3. **Urutan yang Logis**
   - Gunakan nomor urutan untuk mengurutkan materi dari mudah ke sulit
   - Contoh: Urutan 1, 2, 3, dst.

### Materi Grammar

1. **Konten yang Terstruktur**
   - Gunakan paragraf yang jelas
   - Pisahkan dengan enter untuk readability
   - Berikan contoh yang banyak

2. **Video Pembelajaran**
   - Pilih video yang berkualitas
   - Pastikan audio jelas
   - Durasi ideal: 5-15 menit

### Materi Vocabulary

1. **Kelompokkan Berdasarkan Tema**
   - Contoh: "Vocabulary: Family Members"
   - Contoh: "Vocabulary: Daily Activities"

2. **Jumlah Kosakata**
   - Ideal: 10-20 kata per materi
   - Jangan terlalu banyak agar tidak overwhelming

3. **Audio Pelafalan**
   - Rekam dengan jelas
   - Ucapkan dengan kecepatan normal
   - Hindari background noise

4. **Gambar Ilustrasi**
   - Gunakan gambar yang relevan
   - Resolusi yang cukup (tidak blur)
   - Ukuran file tidak terlalu besar

### Mengelola Status Materi

- **Aktif**: Materi dapat diakses oleh siswa
- **Nonaktif**: Materi tidak tampil untuk siswa (draft)

**Gunakan status Nonaktif untuk:**
- Materi yang masih dalam pengembangan
- Materi yang perlu direvisi
- Materi yang tidak relevan untuk semester ini

---

## ❓ FAQ

**Q: Apakah saya bisa mengubah jenis materi dari Vocabulary ke Grammar?**  
A: Ya, Anda bisa mengubahnya di halaman Edit. Namun jika mengubah dari Vocabulary ke Grammar, semua kosakata akan tetap ada di database (tidak otomatis terhapus).

**Q: Berapa ukuran maksimal file yang bisa diupload?**  
A: 
- Video: 50MB
- Audio: 5MB
- Gambar: 2MB

**Q: Apakah siswa bisa melihat materi yang statusnya Nonaktif?**  
A: Tidak, hanya materi dengan status Aktif yang bisa diakses siswa.

**Q: Bagaimana cara mengurutkan materi?**  
A: Gunakan field "Urutan" saat membuat/edit materi. Materi akan ditampilkan berdasarkan nomor urutan dari kecil ke besar.

**Q: Apakah saya bisa mengedit kosakata yang sudah ditambahkan?**  
A: Saat ini belum ada fitur edit kosakata. Anda bisa menghapus dan menambahkan kembali dengan data yang benar.

**Q: Format video apa saja yang didukung?**  
A: mp4, avi, dan mov

**Q: Apakah saya bisa melihat materi yang dibuat guru lain?**  
A: Tidak, Anda hanya bisa melihat dan mengelola materi yang Anda buat sendiri.

---

## 📞 Bantuan

Jika mengalami kendala atau memiliki pertanyaan, silakan hubungi administrator sistem.

---

**Versi Panduan:** 1.0  
**Terakhir Diperbarui:** 15 November 2025
