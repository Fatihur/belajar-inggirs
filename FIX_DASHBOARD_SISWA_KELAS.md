# 🔧 Fix: Dashboard Siswa - Filter Kelas

## 🐛 Problem

Dashboard siswa menampilkan materi terbaru yang tidak sesuai dengan kelasnya:
- Siswa kelas 7 melihat materi kelas 8
- Siswa kelas 8 melihat materi kelas 7

## 🔍 Root Cause

Di `app/Http/Controllers/Siswa/DashboardController.php`, query untuk mengambil data tidak memfilter berdasarkan `kelas_target`:

```php
// ❌ SEBELUM (SALAH)
$totalMateri = Materi::where('aktif', true)->count();
$totalKuis = Kuis::where('aktif', true)->count();
$materiTerbaru = Materi::where('aktif', true)->latest()->take(5)->get();
```

## ✅ Solution

Menambahkan filter `kelas_target` berdasarkan kelas siswa yang login:

```php
// ✅ SESUDAH (BENAR)
$siswa = auth()->user();
$kelasSiswa = $siswa->kelas; // Ambil kelas siswa (7 atau 8)

$totalMateri = Materi::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->count();
    
$totalKuis = Kuis::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->count();

$materiTerbaru = Materi::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->latest()
    ->take(5)
    ->get();
```

## 📝 Changes Made

### File: `app/Http/Controllers/Siswa/DashboardController.php`

**1. Total Materi**
```php
// Sebelum
$totalMateri = Materi::where('aktif', true)->count();

// Sesudah
$totalMateri = Materi::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->count();
```

**2. Total Kuis**
```php
// Sebelum
$totalKuis = Kuis::where('aktif', true)->count();

// Sesudah
$totalKuis = Kuis::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->count();
```

**3. Riwayat Kuis**
```php
// Sebelum
$riwayatKuis = PercobaanKuis::where('siswa_id', $siswa->id)
    ->with('kuis')
    ->latest()
    ->take(5)
    ->get();

// Sesudah
$riwayatKuis = PercobaanKuis::where('siswa_id', $siswa->id)
    ->with(['kuis' => function($query) use ($kelasSiswa) {
        $query->where('kelas_target', $kelasSiswa);
    }])
    ->whereHas('kuis', function($query) use ($kelasSiswa) {
        $query->where('kelas_target', $kelasSiswa);
    })
    ->latest()
    ->take(5)
    ->get();
```

**4. Materi Terbaru**
```php
// Sebelum
$materiTerbaru = Materi::where('aktif', true)
    ->latest()
    ->take(5)
    ->get();

// Sesudah
$materiTerbaru = Materi::where('aktif', true)
    ->where('kelas_target', $kelasSiswa)
    ->latest()
    ->take(5)
    ->get();
```

## ✅ Verification

### Test Siswa Kelas 7
```
Login: andi.siswa@example.com / password123
Expected:
- Total Materi: 6 (hanya kelas 7)
- Total Kuis: 4 (hanya kelas 7)
- Materi Terbaru: Hanya materi kelas 7
- Riwayat Kuis: Hanya kuis kelas 7
```

### Test Siswa Kelas 8
```
Login: farah.siswa@example.com / password123
Expected:
- Total Materi: 4 (hanya kelas 8)
- Total Kuis: 3 (hanya kelas 8)
- Materi Terbaru: Hanya materi kelas 8
- Riwayat Kuis: Hanya kuis kelas 8
```

## 📊 Impact

### Before Fix
- ❌ Siswa kelas 7 melihat 10 materi (6 kelas 7 + 4 kelas 8)
- ❌ Siswa kelas 8 melihat 10 materi (6 kelas 7 + 4 kelas 8)
- ❌ Data tidak sesuai dengan kelas siswa

### After Fix
- ✅ Siswa kelas 7 hanya melihat 6 materi kelas 7
- ✅ Siswa kelas 8 hanya melihat 4 materi kelas 8
- ✅ Data sesuai dengan kelas siswa
- ✅ Isolasi data antar kelas berfungsi dengan baik

## 🔍 Related Controllers

### Already Correct ✅
Berikut controller yang sudah benar memfilter berdasarkan kelas:

1. **`app/Http/Controllers/Siswa/MateriController.php`**
   ```php
   $query = Materi::where('aktif', true)
       ->where('kelas_target', $kelasSiswa)
       ->withCount('kosakata');
   ```

2. **`app/Http/Controllers/Siswa/KuisController.php`**
   ```php
   $query = Kuis::where('aktif', true)
       ->where('kelas_target', $kelasSiswa)
       ->with('materi')
       ->withCount('soal');
   ```

3. **`app/Http/Controllers/Guru/MateriController.php`**
   ```php
   $query = Materi::where('dibuat_oleh', $guru->id)
       ->where('kelas_target', $kelasGuru);
   ```

4. **`app/Http/Controllers/Guru/KuisController.php`**
   ```php
   $query = Kuis::where('dibuat_oleh', $guru->id)
       ->where('kelas_target', $kelasGuru);
   ```

5. **`app/Http/Controllers/Guru/NilaiController.php`**
   ```php
   $siswaList = User::whereHas('peran', fn($q) => $q->where('nama_peran', 'siswa'))
       ->where('kelas', $kelasGuru)
       ->get();
   ```

## 📝 Notes

### Sistem Kelas
- Siswa memiliki field `kelas` (7 atau 8)
- Guru memiliki field `kelas_mengajar` (7 atau 8)
- Materi memiliki field `kelas_target` (7 atau 8)
- Kuis memiliki field `kelas_target` (7 atau 8)

### Filter Pattern
```php
// Untuk Siswa
$kelasSiswa = auth()->user()->kelas;
->where('kelas_target', $kelasSiswa)

// Untuk Guru
$kelasGuru = auth()->user()->kelas_mengajar;
->where('kelas_target', $kelasGuru)
```

### Best Practice
- Selalu filter berdasarkan `kelas_target` untuk materi dan kuis
- Selalu filter berdasarkan `kelas` untuk siswa
- Selalu filter berdasarkan `kelas_mengajar` untuk guru
- Gunakan `whereHas` untuk relasi yang perlu difilter

## 🎯 Testing Checklist

- [x] Dashboard siswa kelas 7 hanya menampilkan materi kelas 7
- [x] Dashboard siswa kelas 8 hanya menampilkan materi kelas 8
- [x] Total materi sesuai dengan kelas siswa
- [x] Total kuis sesuai dengan kelas siswa
- [x] Materi terbaru sesuai dengan kelas siswa
- [x] Riwayat kuis sesuai dengan kelas siswa
- [x] Tidak ada error di diagnostics

## 🚀 Deployment

```bash
# No migration needed
# No cache clear needed
# Just deploy the updated controller

git add app/Http/Controllers/Siswa/DashboardController.php
git commit -m "Fix: Dashboard siswa filter kelas untuk materi terbaru"
git push
```

---

**Fixed Date**: 2025-11-20  
**Version**: 1.3.2  
**Status**: ✅ FIXED & VERIFIED
