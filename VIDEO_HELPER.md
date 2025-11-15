# Video Helper Documentation

## Overview
Helper untuk mengkonversi URL video dari YouTube dan Vimeo ke format embed yang dapat ditampilkan di iframe.

## File Terkait
- `app/Helpers/VideoHelper.php` - Class helper utama
- `app/helpers.php` - Global helper functions
- `composer.json` - Autoload configuration

## Fungsi yang Tersedia

### 1. `video_embed_url($url)`
Mengkonversi URL video ke format embed.

**Supported Formats:**
- YouTube: `https://www.youtube.com/watch?v=VIDEO_ID`
- YouTube Short: `https://youtu.be/VIDEO_ID`
- YouTube Embed: `https://www.youtube.com/embed/VIDEO_ID` (sudah embed)
- Vimeo: `https://vimeo.com/VIDEO_ID`
- Vimeo Player: `https://player.vimeo.com/video/VIDEO_ID` (sudah embed)

**Contoh Penggunaan:**
```blade
<iframe src="{{ video_embed_url($materi->video_url) }}" allowfullscreen></iframe>
```

**Input/Output:**
```php
video_embed_url('https://www.youtube.com/watch?v=dQw4w9WgXcQ')
// Output: https://www.youtube.com/embed/dQw4w9WgXcQ

video_embed_url('https://youtu.be/dQw4w9WgXcQ')
// Output: https://www.youtube.com/embed/dQw4w9WgXcQ

video_embed_url('https://vimeo.com/123456789')
// Output: https://player.vimeo.com/video/123456789
```

### 2. `is_valid_video_url($url)`
Mengecek apakah URL adalah URL video yang valid.

**Contoh Penggunaan:**
```php
if (is_valid_video_url($url)) {
    // URL valid
}
```

**Return:** `boolean`

### 3. `video_platform($url)`
Mendapatkan nama platform video.

**Contoh Penggunaan:**
```php
$platform = video_platform('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
// Output: "YouTube"

$platform = video_platform('https://vimeo.com/123456789');
// Output: "Vimeo"
```

**Return:** `string|null` - "YouTube", "Vimeo", atau null

## Implementasi di Views

### Guru Materi Show
```blade
@if($materi->video_url)
    <div class="ratio ratio-16x9">
        <iframe src="{{ video_embed_url($materi->video_url) }}" 
                allowfullscreen 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                frameborder="0"></iframe>
    </div>
@endif
```

### Siswa Materi Show
```blade
@if($materi->video_url)
    <div class="ratio ratio-16x9">
        <iframe src="{{ video_embed_url($materi->video_url) }}" 
                allowfullscreen 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                frameborder="0"></iframe>
    </div>
@endif
```

## Validasi di Controller (Opsional)

Anda bisa menambahkan validasi di controller untuk memastikan URL yang diinput valid:

```php
use App\Helpers\VideoHelper;

public function store(Request $request)
{
    $request->validate([
        'video_url' => [
            'nullable',
            'url',
            function ($attribute, $value, $fail) {
                if ($value && !VideoHelper::isValidVideoUrl($value)) {
                    $fail('URL video harus dari YouTube atau Vimeo.');
                }
            },
        ],
    ]);
    
    // ...
}
```

## Bootstrap Ratio Classes

Untuk responsive video embed, gunakan Bootstrap ratio classes:

```blade
<div class="ratio ratio-16x9">
    <iframe src="..."></iframe>
</div>
```

**Available Ratios:**
- `ratio-1x1` - Square (1:1)
- `ratio-4x3` - Standard (4:3)
- `ratio-16x9` - Widescreen (16:9) - **Recommended for videos**
- `ratio-21x9` - Ultra-wide (21:9)

## Troubleshooting

### Video tidak muncul?
1. Pastikan URL video valid
2. Cek console browser untuk error
3. Pastikan iframe memiliki atribut `allowfullscreen`
4. Cek apakah video di-embed oleh platform (beberapa video private tidak bisa di-embed)

### URL tidak terkonversi?
1. Pastikan composer dump-autoload sudah dijalankan
2. Cek format URL sesuai dengan pattern yang didukung
3. Cek apakah helper function ter-load dengan `dd(function_exists('video_embed_url'))`

## Testing

Untuk testing helper function:

```php
// Test YouTube URL
$url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
echo video_embed_url($url);
// Expected: https://www.youtube.com/embed/dQw4w9WgXcQ

// Test Vimeo URL
$url = 'https://vimeo.com/123456789';
echo video_embed_url($url);
// Expected: https://player.vimeo.com/video/123456789

// Test validation
var_dump(is_valid_video_url('https://www.youtube.com/watch?v=test'));
// Expected: true

var_dump(is_valid_video_url('https://example.com'));
// Expected: false

// Test platform detection
echo video_platform('https://www.youtube.com/watch?v=test');
// Expected: YouTube
```

## Notes

- Helper ini hanya mendukung YouTube dan Vimeo
- Untuk platform lain, URL akan dikembalikan tanpa modifikasi
- Pastikan video yang di-embed memiliki permission untuk di-embed
- Beberapa video mungkin dibatasi oleh pemiliknya untuk tidak bisa di-embed
