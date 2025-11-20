# Update Controllers untuk Sistem Kelas

## Status: Views SuperAdmin Guru ✅ SELESAI

Views sudah diupdate:
- ✅ `resources/views/superadmin/guru/create.blade.php` - Tambah field kelas_mengajar
- ✅ `resources/views/superadmin/guru/edit.blade.php` - Tambah field kelas_mengajar  
- ✅ `resources/views/superadmin/guru/index.blade.php` - Tampilkan kolom kelas_mengajar

## Langkah Selanjutnya: Update Controllers

Jalankan perintah berikut untuk mengupdate semua controllers sekaligus:

### 1. Update Guru MateriController

Tambahkan auto-set kelas_target di method store dan update:

```bash
# Buka file: app/Http/Controllers/Guru/MateriController.php
```

**Di method `store()` line ~40, tambahkan:**
```php
$guru = auth()->user();
$data['kelas_target'] = $guru->kelas_mengajar;
```

**Di method `update()` line ~120, tambahkan:**
```php
$guru = auth()->user();
$data['kelas_target'] = $guru->kelas_mengajar;
```

### 2. Update Guru KuisController

```bash
# Buka file: app/Http/Controllers/Guru/KuisController.php
```

**Di method `store()` line ~50, tambahkan:**
```php
$guru = auth()->user();
// Tambahkan ke array create:
'kelas_target' => $guru->kelas_mengajar,
```

**Di method `update()` line ~120, tambahkan:**
```php
$guru = auth()->user();
// Tambahkan ke array update:
'kelas_target' => $guru->kelas_mengajar,
```

### 3. Update Siswa MateriController

```bash
# Buka file: app/Http/Controllers/Siswa/MateriController.php
```

**Di method `index()` line ~15, tambahkan filter:**
```php
$siswa = auth()->user();
$kelasSiswa = $siswa->kelas;

$query = Materi::where('aktif', true)
    ->where('kelas_target', $kelasSiswa) // TAMBAHKAN INI
    ->withCount('kosakata');
```

### 4. Update Siswa KuisController

```bash
# Buka file: app/Http/Controllers/Siswa/KuisController.php
```

**Di method `index()` line ~20, tambahkan filter:**
```php
$siswa = auth()->user();
$kelasSiswa = $siswa->kelas;

$query = Kuis::where('aktif', true)
    ->where('kelas_target', $kelasSiswa) // TAMBAHKAN INI
    ->with('materi')
    ->withCount('soal');
```

### 5. Update Guru NilaiController

```bash
# Buka file: app/Http/Controllers/Guru/NilaiController.php
```

**Di method `index()` line ~20, tambahkan filter:**
```php
$guru = auth()->user();
$kelasGuru = $guru->kelas_mengajar;

// Filter siswa by kelas
$siswaList = User::whereHas('peran', function($q) {
    $q->where('nama_peran', 'siswa');
})
->where('kelas', $kelasGuru) // TAMBAHKAN INI
->with([...])
->orderBy('name')
->get();
```

## Atau Gunakan Script Otomatis

Saya akan membuat script untuk mengupdate semua controllers sekaligus.

---

**Next**: Jalankan update controllers di atas, lalu test sistem kelas.
