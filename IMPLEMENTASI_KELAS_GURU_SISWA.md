# Implementasi Sistem Kelas untuk Guru dan Siswa

## Overview
Sistem ini memungkinkan guru mengajar di kelas tertentu (7 atau 8) dan siswa hanya menerima materi/kuis dari guru kelas mereka.

## ✅ Yang Sudah Dilakukan

### 1. Database Migration
✅ File: `database/migrations/2025_11_20_005615_add_kelas_to_users_and_content_tables.php`

**Kolom Baru**:
- `users.kelas_mengajar` - Kelas yang diajar guru (7 atau 8)
- `materi.kelas_target` - Target kelas untuk materi
- `kuis.kelas_target` - Target kelas untuk kuis

✅ Migration sudah dijalankan

### 2. Model Updates
✅ `app/Models/User.php` - Tambah `kelas_mengajar` ke fillable
✅ `app/Models/Materi.php` - Tambah `kelas_target` ke fillable
✅ `app/Models/Kuis.php` - Tambah `kelas_target` ke fillable

### 3. Controller Updates
✅ `app/Http/Controllers/SuperAdmin/GuruController.php`
- Validation untuk `kelas_mengajar` (required, in:7,8)
- Store dan Update method sudah include `kelas_mengajar`

## 📝 Yang Perlu Dilakukan Manual

### 1. Update Views SuperAdmin Guru

#### File: `resources/views/superadmin/guru/create.blade.php`

Tambahkan field kelas_mengajar setelah NIP:

```blade
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">NIP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="nomor_induk" value="{{ old('nomor_induk') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Kelas Mengajar <span class="text-danger">*</span></label>
        <select class="form-select" name="kelas_mengajar" required>
            <option value="">Pilih Kelas</option>
            <option value="7" {{ old('kelas_mengajar') == '7' ? 'selected' : '' }}>Kelas 7</option>
            <option value="8" {{ old('kelas_mengajar') == '8' ? 'selected' : '' }}>Kelas 8</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">No. Telepon</label>
        <input type="text" class="form-control" name="no_telepon" value="{{ old('no_telepon') }}">
    </div>
</div>
```

#### File: `resources/views/superadmin/guru/edit.blade.php`

Sama seperti create, tambahkan field kelas_mengajar:

```blade
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">NIP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="nomor_induk" value="{{ old('nomor_induk', $guru->nomor_induk) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Kelas Mengajar <span class="text-danger">*</span></label>
        <select class="form-select" name="kelas_mengajar" required>
            <option value="">Pilih Kelas</option>
            <option value="7" {{ old('kelas_mengajar', $guru->kelas_mengajar) == '7' ? 'selected' : '' }}>Kelas 7</option>
            <option value="8" {{ old('kelas_mengajar', $guru->kelas_mengajar) == '8' ? 'selected' : '' }}>Kelas 8</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">No. Telepon</label>
        <input type="text" class="form-control" name="no_telepon" value="{{ old('no_telepon', $guru->no_telepon) }}">
    </div>
</div>
```

#### File: `resources/views/superadmin/guru/index.blade.php`

Tambahkan kolom Kelas Mengajar di tabel:

```blade
<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>NIP</th>
        <th>Kelas Mengajar</th>
        <th>Jenis Kelamin</th>
        <th>No. Telepon</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach($guruList as $index => $guru)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $guru->name }}</td>
        <td>{{ $guru->email }}</td>
        <td>{{ $guru->nomor_induk }}</td>
        <td><span class="badge bg-primary">Kelas {{ $guru->kelas_mengajar }}</span></td>
        <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        <td>{{ $guru->no_telepon ?? '-' }}</td>
        <td>
            <!-- actions -->
        </td>
    </tr>
    @endforeach
</tbody>
```

### 2. Update Controller Guru - Materi

#### File: `app/Http/Controllers/Guru/MateriController.php`

**Method `store()`** - Auto-set kelas_target dari guru:

```php
public function store(Request $request)
{
    // ... validation ...
    
    $guru = auth()->user();
    
    $data = [
        'judul' => $request->judul,
        'jenis_materi' => $request->jenis_materi,
        'deskripsi' => $request->deskripsi,
        'konten' => $request->konten,
        'video_url' => $request->video_url,
        'dibuat_oleh' => $guru->id,
        'kelas_target' => $guru->kelas_mengajar, // AUTO SET
        'urutan' => $request->urutan ?? 0,
        'aktif' => $request->has('aktif')
    ];
    
    // ... rest of code ...
}
```

**Method `update()`** - Sama, auto-set kelas_target:

```php
public function update(Request $request, $id)
{
    // ... validation ...
    
    $guru = auth()->user();
    
    $data = [
        'judul' => $request->judul,
        'jenis_materi' => $request->jenis_materi,
        'deskripsi' => $request->deskripsi,
        'konten' => $request->konten,
        'video_url' => $request->video_url,
        'kelas_target' => $guru->kelas_mengajar, // AUTO SET
        'urutan' => $request->urutan ?? 0,
        'aktif' => $request->has('aktif')
    ];
    
    // ... rest of code ...
}
```

### 3. Update Controller Guru - Kuis

#### File: `app/Http/Controllers/Guru/KuisController.php`

**Method `store()`**:

```php
public function store(Request $request)
{
    // ... validation ...
    
    $guru = auth()->user();
    
    $kuis = Kuis::create([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'materi_id' => $request->materi_id,
        'durasi_menit' => $request->durasi_menit,
        'nilai_minimal' => $request->nilai_minimal,
        'tingkat_kesulitan' => $request->tingkat_kesulitan,
        'dibuat_oleh' => $guru->id,
        'kelas_target' => $guru->kelas_mengajar, // AUTO SET
        'aktif' => $request->has('aktif'),
        'acak_soal' => $request->has('acak_soal'),
        'tampilkan_jawaban' => $request->has('tampilkan_jawaban')
    ]);
    
    // ... rest of code ...
}
```

**Method `update()`**:

```php
public function update(Request $request, $id)
{
    // ... validation ...
    
    $guru = auth()->user();
    
    $kuis->update([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'materi_id' => $request->materi_id,
        'durasi_menit' => $request->durasi_menit,
        'nilai_minimal' => $request->nilai_minimal,
        'tingkat_kesulitan' => $request->tingkat_kesulitan,
        'kelas_target' => $guru->kelas_mengajar, // AUTO SET
        'aktif' => $request->has('aktif'),
        'acak_soal' => $request->has('acak_soal'),
        'tampilkan_jawaban' => $request->has('tampilkan_jawaban')
    ]);
    
    // ... rest of code ...
}
```

### 4. Update Controller Siswa - Materi

#### File: `app/Http/Controllers/Siswa/MateriController.php`

**Method `index()`** - Filter by kelas siswa:

```php
public function index(Request $request)
{
    $siswa = auth()->user();
    $kelasS iswa = $siswa->kelas; // "7" atau "8"
    
    $query = Materi::where('aktif', true)
        ->where('kelas_target', $kelasSiswa) // FILTER BY KELAS
        ->withCount('kosakata');

    // ... rest of filtering ...
    
    $materiList = $query->paginate($perPage)->withQueryString();

    return view('siswa.materi.index', compact('materiList'));
}
```

### 5. Update Controller Siswa - Kuis

#### File: `app/Http/Controllers/Siswa/KuisController.php`

**Method `index()`** - Filter by kelas siswa:

```php
public function index(Request $request)
{
    $siswa = auth()->user();
    $kelasSiswa = $siswa->kelas; // "7" atau "8"
    
    $query = Kuis::where('aktif', true)
        ->where('kelas_target', $kelasSiswa) // FILTER BY KELAS
        ->with('materi')
        ->withCount('soal');

    // ... rest of filtering ...
    
    $kuisList = $query->paginate($perPage)->withQueryString();

    // ... rest of code ...
}
```

### 6. Update Controller Guru - Nilai

#### File: `app/Http/Controllers/Guru/NilaiController.php`

**Method `index()`** - Filter siswa by kelas guru:

```php
public function index()
{
    $guru = auth()->user();
    $kelasGuru = $guru->kelas_mengajar;
    
    // Get all kuis created by this guru
    $kuisList = Kuis::where('dibuat_oleh', $guru->id)
        ->withCount('percobaan')
        ->latest()
        ->get();

    // Get students from same class only
    $siswaList = User::whereHas('peran', function($q) {
        $q->where('nama_peran', 'siswa');
    })
    ->where('kelas', $kelasGuru) // FILTER BY KELAS
    ->with(['percobaanKuis' => function($q) use ($guru) {
        $q->whereHas('kuis', function($query) use ($guru) {
            $query->where('dibuat_oleh', $guru->id);
        })
        ->where('status', 'selesai')
        ->latest();
    }])
    ->orderBy('name')
    ->get();

    return view('guru.nilai.index', compact('siswaList', 'kuisList'));
}
```

## 🎯 Cara Kerja Sistem

### Flow Guru:
1. SuperAdmin membuat akun guru dengan kelas_mengajar (7 atau 8)
2. Guru login dan membuat materi/kuis
3. Sistem otomatis set kelas_target = kelas_mengajar guru
4. Guru hanya bisa lihat nilai siswa dari kelasnya

### Flow Siswa:
1. SuperAdmin membuat akun siswa dengan kelas (7 atau 8)
2. Siswa login dan lihat materi/kuis
3. Sistem otomatis filter: hanya tampilkan materi/kuis dengan kelas_target = kelas siswa
4. Siswa hanya bisa mengerjakan kuis dari guru kelasnya

## 🔒 Security & Validation

### Validasi Kelas:
- Guru: `kelas_mengajar` required, in:7,8
- Siswa: `kelas` required (sudah ada)
- Materi: `kelas_target` auto-set dari guru
- Kuis: `kelas_target` auto-set dari guru

### Authorization:
- Guru hanya bisa edit/delete materi/kuis miliknya
- Siswa hanya bisa lihat materi/kuis kelasnya
- Guru hanya bisa lihat nilai siswa kelasnya

## 📊 Database Schema

```sql
-- users table
ALTER TABLE users ADD COLUMN kelas_mengajar VARCHAR(255) NULL COMMENT 'Kelas yang diajar guru (7 atau 8)';

-- materi table
ALTER TABLE materi ADD COLUMN kelas_target VARCHAR(255) NULL COMMENT 'Target kelas untuk materi (7 atau 8)';

-- kuis table
ALTER TABLE kuis ADD COLUMN kelas_target VARCHAR(255) NULL COMMENT 'Target kelas untuk kuis (7 atau 8)';
```

## 🧪 Testing Checklist

### SuperAdmin:
- [ ] Buat guru kelas 7
- [ ] Buat guru kelas 8
- [ ] Buat siswa kelas 7
- [ ] Buat siswa kelas 8
- [ ] Verifikasi field kelas_mengajar tersimpan

### Guru Kelas 7:
- [ ] Login sebagai guru kelas 7
- [ ] Buat materi (auto kelas_target = 7)
- [ ] Buat kuis (auto kelas_target = 7)
- [ ] Lihat nilai (hanya siswa kelas 7)

### Guru Kelas 8:
- [ ] Login sebagai guru kelas 8
- [ ] Buat materi (auto kelas_target = 8)
- [ ] Buat kuis (auto kelas_target = 8)
- [ ] Lihat nilai (hanya siswa kelas 8)

### Siswa Kelas 7:
- [ ] Login sebagai siswa kelas 7
- [ ] Lihat materi (hanya kelas 7)
- [ ] Lihat kuis (hanya kelas 7)
- [ ] Kerjakan kuis kelas 7

### Siswa Kelas 8:
- [ ] Login sebagai siswa kelas 8
- [ ] Lihat materi (hanya kelas 8)
- [ ] Lihat kuis (hanya kelas 8)
- [ ] Kerjakan kuis kelas 8

## 📝 Notes

- Kelas hanya 7 dan 8 (hardcoded)
- Guru tidak bisa ganti kelas setelah dibuat (harus edit via SuperAdmin)
- Materi/Kuis otomatis inherit kelas dari guru
- Siswa tidak bisa lihat materi/kuis kelas lain
- Guru tidak bisa lihat nilai siswa kelas lain

---

**Status**: ⚠️ PARTIALLY IMPLEMENTED
**Next Steps**: Update controllers dan views sesuai dokumentasi di atas
**Date**: 2025-11-20
