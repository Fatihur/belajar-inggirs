# 🗺️ ERD Sederhana - Quick Reference

## 📊 Relasi Utama (Simplified)

```
                    PERAN
                      │
                      │ 1:N
                      ▼
                    USERS
                      │
        ┌─────────────┼─────────────┐
        │             │             │
        │ 1:N         │ 1:N         │ 1:N
        │             │             │
        ▼             ▼             ▼
     MATERI         KUIS      PERCOBAAN_KUIS
        │             │             │
        │ 1:N         │ 1:N         │ 1:N
        │             │             │
        ▼             ▼             ▼
    KOSAKATA     SOAL_KUIS    JAWABAN_SISWA
                      │             ▲
                      │ 1:N         │ N:1
                      ▼             │
               PILIHAN_JAWABAN ─────┘
```

---

## 🔗 Relasi per Modul

### 1️⃣ User Management
```
PERAN (1) ──► USERS (N)
```
- 1 peran bisa dimiliki banyak user
- Setiap user harus punya 1 peran

### 2️⃣ Content Management (Materi)
```
USERS/Guru (1) ──► MATERI (N) ──► KOSAKATA (N)
```
- 1 guru bisa buat banyak materi
- 1 materi vocabulary bisa punya banyak kosakata

### 3️⃣ Quiz Management
```
USERS/Guru (1) ──► KUIS (N) ──► SOAL_KUIS (N) ──► PILIHAN_JAWABAN (N)
```
- 1 guru bisa buat banyak kuis
- 1 kuis punya banyak soal
- 1 soal punya banyak pilihan jawaban

### 4️⃣ Quiz Attempt (Siswa)
```
USERS/Siswa (1) ──► PERCOBAAN_KUIS (N) ──► JAWABAN_SISWA (N)
                           │                        │
                           │                        │
                    KUIS (1)                 SOAL_KUIS (1)
                                                    │
                                          PILIHAN_JAWABAN (1)
```
- 1 siswa bisa punya banyak percobaan
- 1 percobaan untuk 1 kuis
- 1 percobaan punya banyak jawaban
- 1 jawaban untuk 1 soal dan 1 pilihan

---

## 📋 Tabel Inti (9 Tabel)

| No | Tabel | Fungsi | Records (After Seed) |
|----|-------|--------|---------------------|
| 1 | `peran` | Role system | 3 |
| 2 | `users` | Semua pengguna | 17 |
| 3 | `materi` | Materi pembelajaran | 10 |
| 4 | `kosakata` | Vocabulary | 50 |
| 5 | `kuis` | Data kuis | 7 |
| 6 | `soal_kuis` | Soal kuis | 19 |
| 7 | `pilihan_jawaban` | Pilihan jawaban | 70 |
| 8 | `percobaan_kuis` | Percobaan siswa | 26 |
| 9 | `jawaban_siswa` | Jawaban siswa | 96 |

---

## 🔑 Foreign Keys

| Child Table | Parent Table | FK Column | ON DELETE |
|-------------|--------------|-----------|-----------|
| users | peran | peran_id | CASCADE |
| materi | users | dibuat_oleh | CASCADE |
| kosakata | materi | materi_id | CASCADE |
| kuis | users | dibuat_oleh | CASCADE |
| kuis | materi | materi_id | SET NULL |
| soal_kuis | kuis | kuis_id | CASCADE |
| pilihan_jawaban | soal_kuis | soal_id | CASCADE |
| percobaan_kuis | kuis | kuis_id | CASCADE |
| percobaan_kuis | users | siswa_id | CASCADE |
| jawaban_siswa | percobaan_kuis | percobaan_id | CASCADE |
| jawaban_siswa | soal_kuis | soal_id | CASCADE |
| jawaban_siswa | pilihan_jawaban | pilihan_jawaban_id | SET NULL |

---

## 🎯 Sistem Kelas (Class Isolation)

```
┌─────────────────────────────────────────────┐
│              SUPER ADMIN                    │
│         (Lihat semua data)                  │
└─────────────────────────────────────────────┘
                    │
        ┌───────────┴───────────┐
        │                       │
┌───────▼────────┐      ┌───────▼────────┐
│  GURU KELAS 7  │      │  GURU KELAS 8  │
│ kelas_mengajar │      │ kelas_mengajar │
│      = 7       │      │      = 8       │
└───────┬────────┘      └───────┬────────┘
        │                       │
        │ creates               │ creates
        │                       │
┌───────▼────────┐      ┌───────▼────────┐
│ MATERI KELAS 7 │      │ MATERI KELAS 8 │
│ kelas_target=7 │      │ kelas_target=8 │
└───────┬────────┘      └───────┬────────┘
        │                       │
┌───────▼────────┐      ┌───────▼────────┐
│  KUIS KELAS 7  │      │  KUIS KELAS 8  │
│ kelas_target=7 │      │ kelas_target=8 │
└───────┬────────┘      └───────┬────────┘
        │                       │
        │ accessed by           │ accessed by
        │                       │
┌───────▼────────┐      ┌───────▼────────┐
│ SISWA KELAS 7  │      │ SISWA KELAS 8  │
│   kelas = 7    │      │   kelas = 8    │
└────────────────┘      └────────────────┘
```

**Aturan Isolasi:**
- ✅ Guru kelas 7 → Hanya kelola data `kelas_target=7`
- ✅ Guru kelas 8 → Hanya kelola data `kelas_target=8`
- ✅ Siswa kelas 7 → Hanya lihat data `kelas_target=7`
- ✅ Siswa kelas 8 → Hanya lihat data `kelas_target=8`
- ✅ Super Admin → Lihat semua (no filter)

---

## 📊 Data Flow

### Flow 1: Guru Membuat Materi
```
1. Guru login
2. Pilih jenis materi (Grammar/Vocabulary)
3. Input data materi (judul, deskripsi, konten)
4. Set kelas_target (7 atau 8)
5. Jika Vocabulary → Tambah kosakata
6. Save ke database
```

### Flow 2: Guru Membuat Kuis
```
1. Guru login
2. Buat kuis baru (judul, durasi, nilai minimal)
3. Set kelas_target (7 atau 8)
4. Tambah soal kuis
5. Untuk setiap soal → Tambah pilihan jawaban
6. Tandai jawaban yang benar
7. Save ke database
```

### Flow 3: Siswa Mengerjakan Kuis
```
1. Siswa login
2. Pilih kuis (sesuai kelas)
3. Mulai kuis → Create percobaan_kuis
4. Jawab soal → Create jawaban_siswa
5. Submit → Update percobaan_kuis
6. Hitung nilai otomatis
7. Tampilkan hasil
```

---

## 🔍 Query Pattern

### Get Data by Class
```sql
-- Materi untuk kelas 7
SELECT * FROM materi WHERE kelas_target = '7';

-- Kuis untuk kelas 8
SELECT * FROM kuis WHERE kelas_target = '8';
```

### Get Data by User Role
```sql
-- Materi yang dibuat guru tertentu
SELECT * FROM materi WHERE dibuat_oleh = :guru_id;

-- Percobaan kuis siswa tertentu
SELECT * FROM percobaan_kuis WHERE siswa_id = :siswa_id;
```

### Get Related Data
```sql
-- Kosakata dalam materi
SELECT k.* FROM kosakata k
JOIN materi m ON k.materi_id = m.id
WHERE m.id = :materi_id;

-- Soal dalam kuis
SELECT s.* FROM soal_kuis s
JOIN kuis k ON s.kuis_id = k.id
WHERE k.id = :kuis_id;
```

---

## 📝 Catatan Penting

### Cascade Delete
Jika parent dihapus, child juga terhapus:
- Hapus `peran` → Hapus semua `users` dengan peran tersebut
- Hapus `users/guru` → Hapus semua `materi` dan `kuis` yang dibuat
- Hapus `kuis` → Hapus semua `soal_kuis` dan `percobaan_kuis`
- Hapus `percobaan_kuis` → Hapus semua `jawaban_siswa`

### Set Null
Jika parent dihapus, FK di child jadi NULL:
- Hapus `materi` → `kuis.materi_id` jadi NULL (kuis tetap ada)
- Hapus `pilihan_jawaban` → `jawaban_siswa.pilihan_jawaban_id` jadi NULL

### Unique Constraints
- `users.email` → Harus unique
- Tidak ada unique constraint lain

### Indexes
- Primary Keys: Semua tabel punya `id` sebagai PK
- Foreign Keys: Auto-indexed
- Recommended: Index pada `kelas_target`, `kelas`, `kelas_mengajar`

---

**Version**: 1.3.2  
**Last Updated**: 2025-11-20  
**Total Tables**: 9 core + 5 system = 14 tables
