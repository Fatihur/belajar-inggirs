# Migrasi dari Trix ke Quill Editor

## Perubahan yang Dilakukan

### 1. Komponen Editor Baru
- **File Baru**: `resources/views/components/quill-editor.blade.php`
- Menggantikan komponen `x-trix-input` dengan `x-quill-editor`
- Menggunakan Quill 2.0.2 dari CDN

### 2. Model Updates
Menghapus dependency rich text package dari model:

#### `app/Models/Materi.php`
- Menghapus `use HasRichText` trait
- Menghapus `AsRichTextContent` cast
- Menghapus `$richTextAttributes` property
- Field `konten` dan `deskripsi` sekarang disimpan sebagai HTML string

#### `app/Models/Kuis.php`
- Menghapus `AsRichTextContent` cast untuk field `deskripsi`
- Field `deskripsi` sekarang disimpan sebagai HTML string

### 3. View Updates

#### Materi Views
- `resources/views/guru/materi/create.blade.php` - Menggunakan `x-quill-editor`
- `resources/views/guru/materi/edit.blade.php` - Menggunakan `x-quill-editor`
- `resources/views/guru/materi/show.blade.php` - Menampilkan HTML dengan `{!! $materi->konten !!}`
- `resources/views/siswa/materi/show.blade.php` - Menampilkan HTML dengan `{!! $materi->konten !!}`

#### Kuis Views
- `resources/views/guru/kuis/create.blade.php` - Menggunakan `x-quill-editor`
- `resources/views/guru/kuis/edit.blade.php` - Menggunakan `x-quill-editor`
- `resources/views/guru/kuis/show.blade.php` - Menampilkan HTML dengan `{!! $kuis->deskripsi !!}`
- `resources/views/siswa/kuis/show.blade.php` - Menampilkan HTML dengan `{!! $kuis->deskripsi !!}`

### 4. Styling
File `public/assets/css/custom.css` sudah berisi styling untuk class `.content-html` yang menangani tampilan konten HTML dari Quill editor.

## Cara Penggunaan

### Menambahkan Editor di View
```blade
<x-quill-editor 
    id="konten" 
    name="konten" 
    value="{{ old('konten', '') }}" 
/>
```

### Menampilkan Konten HTML
```blade
<div class="content-html">
    {!! $materi->konten !!}
</div>
```

## Fitur Quill Editor
- Headers (H1-H6)
- Bold, Italic, Underline, Strike
- Ordered & Bullet Lists
- Text Color & Background Color
- Text Alignment
- Link, Image, Video
- Clean formatting

## Catatan Penting
- Konten disimpan sebagai HTML string di database
- Tidak perlu lagi menggunakan `toTrixHtml()` method
- Pastikan menggunakan `{!! !!}` untuk menampilkan HTML (bukan `{{ }}`)
- Class `.content-html` memberikan styling yang konsisten untuk konten
