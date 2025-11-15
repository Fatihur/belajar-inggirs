# Search, Filter & Pagination Documentation

## Overview
Fitur pencarian, filter, dan pagination telah ditambahkan ke semua tabel/list di aplikasi untuk meningkatkan user experience dan memudahkan navigasi data.

## Implementasi

### 1. Guru - Materi (`/guru/materi`)

#### Controller: `App\Http\Controllers\Guru\MateriController@index`

**Fitur:**
- ✅ Search: Judul, Deskripsi
- ✅ Filter: Jenis Materi (vocabulary/grammar), Status (aktif/nonaktif)
- ✅ Pagination: 10, 25, 50, 100 per halaman
- ✅ Sort: Berbagai kolom dengan order asc/desc

**Query Parameters:**
```
?search=grammar
&jenis_materi=grammar
&status=aktif
&per_page=25
&sort_by=created_at
&sort_order=desc
```

---

### 2. Guru - Kuis (`/guru/kuis`)

#### Controller: `App\Http\Controllers\Guru\KuisController@index`

**Fitur:**
- ✅ Search: Judul, Deskripsi
- ✅ Filter: Materi, Tingkat Kesulitan, Status
- ✅ Pagination: 10, 25, 50 per halaman
- ✅ Sort: Berbagai kolom dengan order asc/desc

**Query Parameters:**
```
?search=quiz
&materi_id=1
&tingkat_kesulitan=mudah
&status=aktif
&per_page=25
```

---

### 3. SuperAdmin - Guru (`/superadmin/guru`)

#### Controller: `App\Http\Controllers\SuperAdmin\GuruController@index`

**Fitur:**
- ✅ Search: Nama, Email, NIP
- ✅ Filter: Jenis Kelamin
- ✅ Pagination: 10, 25, 50, 100 per halaman
- ✅ Sort: Berbagai kolom dengan order asc/desc

**Query Parameters:**
```
?search=john
&jenis_kelamin=L
&per_page=25
```

---

### 4. SuperAdmin - Siswa (`/superadmin/siswa`)

#### Controller: `App\Http\Controllers\SuperAdmin\SiswaController@index`

**Fitur:**
- ✅ Search: Nama, Email, NIS, Kelas
- ✅ Filter: Kelas, Jenis Kelamin
- ✅ Pagination: 10, 25, 50 per halaman
- ✅ Sort: Berbagai kolom dengan order asc/desc

**Query Parameters:**
```
?search=jane
&kelas=10A
&jenis_kelamin=P
&per_page=25
```

---

### 5. Siswa - Materi (`/siswa/materi`)

#### Controller: `App\Http\Controllers\Siswa\MateriController@index`

**Fitur:**
- ✅ Search: Judul, Deskripsi
- ✅ Filter: Jenis Materi (vocabulary/grammar)
- ✅ Pagination: 12, 24, 48 per halaman (card layout)
- ✅ Sort: Urutan, Tanggal

**Query Parameters:**
```
?search=grammar
&jenis_materi=vocabulary
&per_page=24
```

---

### 6. Siswa - Kuis (`/siswa/kuis`)

#### Controller: `App\Http\Controllers\Siswa\KuisController@index`

**Fitur:**
- ✅ Search: Judul, Deskripsi
- ✅ Filter: Materi, Tingkat Kesulitan
- ✅ Pagination: 10, 20 per halaman (card layout)
- ✅ Sort: Tanggal

**Query Parameters:**
```
?search=quiz
&materi_id=1
&tingkat_kesulitan=mudah
&per_page=20
```

---

## Struktur Kode

### Controller Pattern

```php
public function index(Request $request)
{
    $query = Model::query();

    // Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('field1', 'like', "%{$search}%")
              ->orWhere('field2', 'like', "%{$search}%");
        });
    }

    // Filter
    if ($request->filled('filter_field')) {
        $query->where('filter_field', $request->filter_field);
    }

    // Sort
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);

    // Pagination
    $perPage = $request->get('per_page', 10);
    $results = $query->paginate($perPage)->withQueryString();

    return view('view.name', compact('results'));
}
```

### View Pattern (Table Layout)

```blade
<!-- Search & Filter Form -->
<form method="GET" action="{{ route('route.name') }}" class="mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" 
                   placeholder="Cari..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="filter" class="form-select">
                <option value="">Semua</option>
                <option value="value1" {{ request('filter') == 'value1' ? 'selected' : '' }}>
                    Option 1
                </option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="per_page" class="form-select">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-search"></i> Filter
            </button>
        </div>
    </div>
    @if(request()->hasAny(['search', 'filter']))
        <div class="mt-2">
            <a href="{{ route('route.name') }}" class="btn btn-sm btn-secondary">
                <i class="ti ti-x"></i> Reset Filter
            </a>
        </div>
    @endif
</form>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-hover">
        <!-- Table content -->
    </table>
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $results->links() }}
</div>
```

### View Pattern (Card Layout)

```blade
<!-- Search & Filter Card -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('route.name') }}">
            <!-- Filter fields -->
        </form>
    </div>
</div>

<!-- Cards Grid -->
<div class="row">
    @foreach($items as $item)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <!-- Card content -->
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $items->links() }}
</div>
```

---

## Fitur Tambahan

### 1. Persist Query String
Semua pagination menggunakan `->withQueryString()` untuk mempertahankan parameter search dan filter saat berpindah halaman.

```php
$results = $query->paginate($perPage)->withQueryString();
```

### 2. Reset Filter Button
Tombol reset muncul otomatis ketika ada filter aktif.

```blade
@if(request()->hasAny(['search', 'filter']))
    <a href="{{ route('route.name') }}" class="btn btn-sm btn-secondary">
        <i class="ti ti-x"></i> Reset Filter
    </a>
@endif
```

### 3. Dynamic Per Page
User bisa memilih jumlah item per halaman sesuai kebutuhan.

### 4. Multiple Search Fields
Search bisa mencari di multiple kolom menggunakan `orWhere`.

---

## Testing

### Test Search
1. Buka halaman list
2. Ketik keyword di search box
3. Klik Filter
4. Verifikasi hasil sesuai keyword

### Test Filter
1. Pilih filter option
2. Klik Filter
3. Verifikasi hasil sesuai filter

### Test Pagination
1. Pilih jumlah per halaman
2. Klik Filter
3. Verifikasi jumlah item per halaman
4. Klik halaman berikutnya
5. Verifikasi filter tetap aktif

### Test Reset
1. Aktifkan beberapa filter
2. Klik Reset Filter
3. Verifikasi semua filter ter-reset

---

## Performance Tips

### 1. Index Database
Pastikan kolom yang sering di-search memiliki index:

```php
$table->index('judul');
$table->index('email');
$table->index(['jenis_materi', 'aktif']);
```

### 2. Eager Loading
Gunakan `with()` untuk menghindari N+1 query:

```php
$query->with('materi', 'pembuat');
```

### 3. Select Specific Columns
Jika tidak perlu semua kolom:

```php
$query->select('id', 'judul', 'jenis_materi', 'aktif');
```

### 4. Cache Filter Options
Cache dropdown options yang jarang berubah:

```php
$kelasList = Cache::remember('kelas_list', 3600, function() {
    return User::distinct()->pluck('kelas');
});
```

---

## Customization

### Menambah Filter Baru

1. **Controller:**
```php
if ($request->filled('new_filter')) {
    $query->where('new_field', $request->new_filter);
}
```

2. **View:**
```blade
<select name="new_filter" class="form-select">
    <option value="">Semua</option>
    <option value="value1">Option 1</option>
</select>
```

### Menambah Sort Option

1. **Controller:**
```php
$sortBy = $request->get('sort_by', 'created_at');
$sortOrder = $request->get('sort_order', 'desc');
$query->orderBy($sortBy, $sortOrder);
```

2. **View:**
```blade
<select name="sort_by" class="form-select">
    <option value="created_at">Terbaru</option>
    <option value="judul">Judul</option>
    <option value="urutan">Urutan</option>
</select>
```

---

## Browser Compatibility

- ✅ Chrome/Edge (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Mobile Browsers

---

## Accessibility

- ✅ Keyboard navigation support
- ✅ Screen reader friendly
- ✅ ARIA labels on form elements
- ✅ Focus indicators

---

**Status**: ✅ IMPLEMENTED & TESTED
**Version**: 1.0.0
**Date**: 2025-11-15
