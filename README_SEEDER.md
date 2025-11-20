# 📚 Seeder Documentation

## 📖 Daftar Dokumentasi

Dokumentasi seeder terbagi dalam beberapa file untuk kemudahan navigasi:

### 1. 🚀 [QUICK_REFERENCE_SEEDER.md](QUICK_REFERENCE_SEEDER.md)
**Quick reference untuk penggunaan sehari-hari**
- Data summary dalam tabel
- Login credentials semua user
- Commands untuk run seeder
- Testing scenarios
- Verification commands

**Gunakan ini untuk**: Akses cepat credentials dan commands

---

### 2. 📊 [SEEDER_LENGKAP.md](SEEDER_LENGKAP.md)
**Dokumentasi lengkap semua seeder**
- Deskripsi detail setiap seeder
- Data yang dibuat per seeder
- Struktur data lengkap
- Skenario testing detail
- Catatan teknis

**Gunakan ini untuk**: Memahami struktur data lengkap

---

### 3. 🔍 [ANALISIS_MIGRATION_DAN_SEEDER.md](ANALISIS_MIGRATION_DAN_SEEDER.md)
**Analisis migration dan mapping ke seeder**
- Analisis semua migration
- Mapping migration → seeder
- Checklist coverage
- Data distribution
- Kesimpulan dan next steps

**Gunakan ini untuk**: Memahami relasi migration dan seeder

---

### 4. 👥 [SEEDER_GURU_SISWA.md](SEEDER_GURU_SISWA.md)
**Dokumentasi khusus guru dan siswa seeder**
- Detail data guru per kelas
- Detail data siswa per kelas
- Login credentials
- Testing scenarios
- Format NIP/NIS

**Gunakan ini untuk**: Testing user management

---

## 🎯 Quick Start

### 1. Install & Seed Database
```bash
# Clone repository
git clone <repository-url>
cd belajar-inggirs

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed
```

### 2. Login & Test
```bash
# Start server
php artisan serve

# Open browser
http://localhost:8000

# Login as Super Admin
Email: admin@example.com
Password: password

# Login as Guru Kelas 7
Email: budi.guru@example.com
Password: password123

# Login as Siswa Kelas 7
Email: andi.siswa@example.com
Password: password123
```

---

## 📊 Data Overview

| Category | Total | Kelas 7 | Kelas 8 |
|----------|-------|---------|---------|
| **Users** | 17 | 7 | 7 |
| - Super Admin | 3 | - | - |
| - Guru | 4 | 2 | 2 |
| - Siswa | 10 | 5 | 5 |
| **Materi** | 10 | 6 | 4 |
| **Kosakata** | 50 | 30 | 20 |
| **Kuis** | 7 | 4 | 3 |
| **Soal** | 19 | 13 | 6 |
| **Pilihan Jawaban** | 70 | 48 | 22 |
| **Percobaan Kuis** | 26 | ~15 | ~11 |
| **Jawaban Siswa** | 96 | ~60 | ~36 |

---

## 🔑 Default Credentials

### Super Admin
```
admin@example.com / password
```

### Guru
```
Kelas 7:
- budi.guru@example.com / password123
- siti.guru@example.com / password123

Kelas 8:
- ahmad.guru@example.com / password123
- dewi.guru@example.com / password123
```

### Siswa
```
Kelas 7:
- andi.siswa@example.com / password123
- bella.siswa@example.com / password123
- candra.siswa@example.com / password123
- dina.siswa@example.com / password123
- eko.siswa@example.com / password123

Kelas 8:
- farah.siswa@example.com / password123
- gilang.siswa@example.com / password123
- hana.siswa@example.com / password123
- irfan.siswa@example.com / password123
- julia.siswa@example.com / password123
```

---

## 🚀 Seeder Commands

### Run All Seeders
```bash
php artisan migrate:fresh --seed
```

### Run Specific Seeder
```bash
php artisan db:seed --class=PeranSeeder
php artisan db:seed --class=GuruSeeder
php artisan db:seed --class=SiswaSeeder
php artisan db:seed --class=MateriSeeder
php artisan db:seed --class=KuisSeeder
php artisan db:seed --class=PercobaanKuisSeeder
```

### Reset Database
```bash
# Drop all tables and re-migrate
php artisan migrate:fresh

# Then seed again
php artisan db:seed
```

---

## 📁 Seeder Files

```
database/seeders/
├── DatabaseSeeder.php          # Main orchestrator
├── PeranSeeder.php            # 3 roles + 1 super admin
├── GuruSeeder.php             # 4 teachers (2 per class)
├── SiswaSeeder.php            # 10 students (5 per class)
├── MateriSeeder.php           # 10 materials + 50 vocabularies
├── KuisSeeder.php             # 7 quizzes + 19 questions + 70 answers
└── PercobaanKuisSeeder.php    # 26 attempts + 96 student answers ⭐
```

---

## 🧪 Testing Checklist

### Super Admin
- [ ] Login berhasil
- [ ] Dashboard menampilkan statistik
- [ ] CRUD Guru berfungsi
- [ ] CRUD Siswa berfungsi
- [ ] Lihat semua data (tidak ada filter kelas)

### Guru Kelas 7
- [ ] Login berhasil
- [ ] Dashboard menampilkan statistik kelas 7
- [ ] Lihat 6 materi kelas 7
- [ ] Lihat 4 kuis kelas 7
- [ ] Lihat 5 siswa kelas 7
- [ ] Tidak bisa lihat data kelas 8

### Guru Kelas 8
- [ ] Login berhasil
- [ ] Dashboard menampilkan statistik kelas 8
- [ ] Lihat 4 materi kelas 8
- [ ] Lihat 3 kuis kelas 8
- [ ] Lihat 5 siswa kelas 8
- [ ] Tidak bisa lihat data kelas 7

### Siswa Kelas 7
- [ ] Login berhasil
- [ ] Dashboard menampilkan progress
- [ ] Lihat 6 materi kelas 7
- [ ] Lihat 4 kuis kelas 7
- [ ] Lihat riwayat percobaan kuis
- [ ] Tidak bisa lihat materi/kuis kelas 8

### Siswa Kelas 8
- [ ] Login berhasil
- [ ] Dashboard menampilkan progress
- [ ] Lihat 4 materi kelas 8
- [ ] Lihat 3 kuis kelas 8
- [ ] Lihat riwayat percobaan kuis
- [ ] Tidak bisa lihat materi/kuis kelas 7

---

## 🔧 Troubleshooting

### Seeder Error: "Guru belum ada"
```bash
# Pastikan GuruSeeder dijalankan sebelum MateriSeeder
php artisan db:seed --class=GuruSeeder
php artisan db:seed --class=MateriSeeder
```

### Seeder Error: "Kuis belum ada"
```bash
# Pastikan KuisSeeder dijalankan sebelum PercobaanKuisSeeder
php artisan db:seed --class=KuisSeeder
php artisan db:seed --class=PercobaanKuisSeeder
```

### Database Connection Error
```bash
# Check .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_inggris
DB_USERNAME=root
DB_PASSWORD=

# Test connection
php artisan migrate
```

### Storage Link Error
```bash
# Create storage link
php artisan storage:link

# Check permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📝 Notes

### Password Security
- Super Admin: `password` (untuk kemudahan development)
- Guru & Siswa: `password123` (untuk kemudahan testing)
- **Production**: Ganti semua password dengan yang lebih aman

### Data Realistis
- Nama guru dan siswa menggunakan nama Indonesia
- NIP guru menggunakan format standar
- NIS siswa menggunakan format tahun + kelas + urutan
- Tanggal lahir realistis (guru: 1970-1990, siswa: 2010-2011)
- Alamat dummy di Jakarta
- No. telepon dummy dengan format Indonesia

### Sistem Kelas
- Guru memiliki `kelas_mengajar` (7 atau 8)
- Siswa memiliki `kelas` (7 atau 8)
- Materi memiliki `kelas_target` (7 atau 8)
- Kuis memiliki `kelas_target` (7 atau 8)
- Sistem otomatis filter data berdasarkan kelas

---

## 🎉 Status

**✅ COMPLETE & PRODUCTION READY**

Semua seeder telah dibuat dan diverifikasi:
- 6 seeder files
- 17 users (3 admin + 4 guru + 10 siswa)
- 10 materi dengan 50 kosakata
- 7 kuis dengan 19 soal dan 70 pilihan jawaban
- 26 percobaan kuis dengan 96 jawaban siswa
- Sistem kelas 7 & 8 terintegrasi penuh
- Data realistis dan siap untuk testing

---

## 📚 Related Documentation

- [CHANGELOG.md](CHANGELOG.md) - Version history
- [README.md](README.md) - Main documentation
- [prd.md](prd.md) - Product requirements
- [DATABASE.md](DATABASE.md) - Database schema (if exists)

---

**Last Updated**: 2025-11-20  
**Version**: 1.3.2  
**Author**: Development Team  
**Status**: ✅ Production Ready
