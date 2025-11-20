# 🚀 Quick Reference - Seeder

## 📊 Data Summary

| Item | Jumlah | Detail |
|------|--------|--------|
| **Users** | 17 | 3 admin + 4 guru + 10 siswa |
| **Guru** | 4 | 2 kelas 7 + 2 kelas 8 |
| **Siswa** | 10 | 5 kelas 7 + 5 kelas 8 |
| **Materi** | 10 | 6 kelas 7 + 4 kelas 8 |
| **Kosakata** | 50 | 30 kelas 7 + 20 kelas 8 |
| **Kuis** | 7 | 4 kelas 7 + 3 kelas 8 |
| **Soal** | 19 | 13 kelas 7 + 6 kelas 8 |
| **Pilihan Jawaban** | 70 | 48 kelas 7 + 22 kelas 8 |
| **Percobaan Kuis** | 26 | 24 selesai + 1 sedang + 1 timeout |
| **Jawaban Siswa** | 96 | Data lengkap untuk testing |

---

## 🔑 Login Credentials

### Super Admin
```
Email: admin@example.com
Password: password
```

### Guru Kelas 7
```
budi.guru@example.com / password123
siti.guru@example.com / password123
```

### Guru Kelas 8
```
ahmad.guru@example.com / password123
dewi.guru@example.com / password123
```

### Siswa Kelas 7
```
andi.siswa@example.com / password123
bella.siswa@example.com / password123
candra.siswa@example.com / password123
dina.siswa@example.com / password123
eko.siswa@example.com / password123
```

### Siswa Kelas 8
```
farah.siswa@example.com / password123
gilang.siswa@example.com / password123
hana.siswa@example.com / password123
irfan.siswa@example.com / password123
julia.siswa@example.com / password123
```

---

## 🚀 Commands

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

---

## 📚 Materi per Kelas

### Kelas 7 (6 materi)
1. Simple Present Tense (Grammar)
2. Present Continuous Tense (Grammar)
3. Simple Past Tense (Grammar)
4. Daily Activities (Vocabulary - 10 kata)
5. Family Members (Vocabulary - 10 kata)
6. Colors (Vocabulary - 10 kata)

### Kelas 8 (4 materi)
1. Present Perfect Tense (Grammar)
2. Passive Voice (Grammar)
3. Technology (Vocabulary - 10 kata)
4. Environment (Vocabulary - 10 kata)

---

## 📝 Kuis per Kelas

### Kelas 7 (4 kuis)
1. Quiz: Simple Present Tense (5 soal, 15 menit, Mudah)
2. Quiz: Daily Activities Vocabulary (3 soal, 10 menit, Mudah)
3. Quiz: Family Members (3 soal, 10 menit, Mudah)
4. Mixed Grammar Quiz (2 soal, 20 menit, Sedang)

### Kelas 8 (3 kuis)
1. Quiz: Present Perfect Tense (2 soal, 20 menit, Sedang)
2. Quiz: Technology Vocabulary (2 soal, 15 menit, Sedang)
3. Quiz: Passive Voice (2 soal, 20 menit, Sulit)

---

## 🧪 Testing Scenarios

### Test Guru Kelas 7
```
Login: budi.guru@example.com / password123
Expected: Lihat 6 materi, 4 kuis, 5 siswa kelas 7
Not See: Data kelas 8
```

### Test Guru Kelas 8
```
Login: ahmad.guru@example.com / password123
Expected: Lihat 4 materi, 3 kuis, 5 siswa kelas 8
Not See: Data kelas 7
```

### Test Siswa Kelas 7
```
Login: andi.siswa@example.com / password123
Expected: Lihat 6 materi, 4 kuis kelas 7
Has: Riwayat percobaan kuis
Not See: Materi/kuis kelas 8
```

### Test Siswa Kelas 8
```
Login: farah.siswa@example.com / password123
Expected: Lihat 4 materi, 3 kuis kelas 8
Has: Riwayat percobaan kuis
Not See: Materi/kuis kelas 7
```

---

## 📁 Seeder Files

1. `database/seeders/PeranSeeder.php` - 3 peran + 1 super admin
2. `database/seeders/GuruSeeder.php` - 4 guru
3. `database/seeders/SiswaSeeder.php` - 10 siswa
4. `database/seeders/MateriSeeder.php` - 10 materi + 50 kosakata
5. `database/seeders/KuisSeeder.php` - 7 kuis + 19 soal + 70 pilihan
6. `database/seeders/PercobaanKuisSeeder.php` - 26 percobaan + 96 jawaban ⭐
7. `database/seeders/DatabaseSeeder.php` - Main orchestrator

---

## ✅ Verification

After seeding, verify with:
```bash
php artisan tinker
```

Then run:
```php
// Count users
App\Models\User::count(); // Should be 17

// Count by role
App\Models\User::whereHas('peran', fn($q) => $q->where('nama_peran', 'guru'))->count(); // 4
App\Models\User::whereHas('peran', fn($q) => $q->where('nama_peran', 'siswa'))->count(); // 10

// Count materi
App\Models\Materi::count(); // 10
App\Models\Materi::where('kelas_target', '7')->count(); // 6
App\Models\Materi::where('kelas_target', '8')->count(); // 4

// Count kuis
App\Models\Kuis::count(); // 7
App\Models\Kuis::where('kelas_target', '7')->count(); // 4
App\Models\Kuis::where('kelas_target', '8')->count(); // 3

// Count percobaan
App\Models\PercobaanKuis::count(); // 26
App\Models\JawabanSiswa::count(); // 96
```

---

**Last Updated**: 2025-11-20  
**Version**: 1.3.2  
**Status**: ✅ Production Ready
