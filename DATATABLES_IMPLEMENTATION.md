# DataTables Implementation

## Overview
DataTables telah diimplementasikan di semua tabel untuk menyediakan fitur search, filter, pagination, dan sorting secara otomatis dengan UI yang lebih baik dan performa optimal.

## Features

### ✅ Built-in Features
- **Search**: Global search di semua kolom
- **Sorting**: Click column header untuk sort ascending/descending
- **Pagination**: Navigasi halaman dengan pilihan jumlah data per halaman
- **Responsive**: Otomatis responsive di mobile devices
- **Export**: Bisa ditambahkan export ke Excel, PDF, CSV
- **Bahasa Indonesia**: Interface dalam Bahasa Indonesia

## Implementation

### 1. CDN Added to Layout

**File**: `resources/views/layouts/app.blade.php`

**CSS**:
```html
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
```

**JavaScript**:
```html
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
```

### 2. Controllers Simplified

Controllers tidak perlu lagi handle pagination, search, dan filter secara manual:

**Before**:
```php
public function index(Request $request)
{
    $query = Model::query();
    
    // Manual search
    if ($request->filled('search')) {
        $query->where('field', 'like', "%{$request->search}%");
    }
    
    // Manual pagination
    $results = $query->paginate(10);
    
    return view('view', compact('results'));
}
```

**After**:
```php
public function index()
{
    $results = Model::latest()->get();
    return view('view', compact('results'));
}
```

### 3. Views with DataTables

**Basic Implementation**:
```blade
<table id="myTable" class="table table-hover table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->field1 }}</td>
            <td>{{ $item->field2 }}</td>
            <td>
                <!-- Action buttons -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        columnDefs: [
            { orderable: false, targets: -1 } // Disable sorting on last column (actions)
        ]
    });
});
</script>
@endpush
```

## Implemented Tables

### 1. Guru - Materi (`/guru/materi`)
- **Table ID**: `#materiTable`
- **Columns**: No, Judul, Jenis, Jumlah Kosakata, Urutan, Status, Aksi
- **Default Sort**: No (ascending)
- **Page Length**: 10

### 2. Guru - Kuis (`/guru/kuis`)
- **Table ID**: `#kuisTable`
- **Columns**: No, Judul, Materi, Tingkat, Soal, Durasi, Percobaan, Status, Aksi
- **Default Sort**: No (ascending)
- **Page Length**: 10

### 3. SuperAdmin - Guru (`/superadmin/guru`)
- **Table ID**: `#guruTable`
- **Columns**: No, Nama, Email, NIP, Jenis Kelamin, No. Telepon, Aksi
- **Default Sort**: Nama (ascending)
- **Page Length**: 10

### 4. SuperAdmin - Siswa (`/superadmin/siswa`)
- **Table ID**: `#siswaTable`
- **Columns**: No, Nama, Email, NIS, Kelas, Jenis Kelamin, Aksi
- **Default Sort**: Kelas (ascending), then Nama (ascending)
- **Page Length**: 10

## Configuration Options

### Basic Options
```javascript
$('#myTable').DataTable({
    // Enable responsive
    responsive: true,
    
    // Set language to Indonesian
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
    },
    
    // Default sorting
    order: [[0, 'asc']],
    
    // Default page length
    pageLength: 10,
    
    // Page length options
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    
    // Column specific settings
    columnDefs: [
        { orderable: false, targets: -1 } // Disable sorting on last column
    ]
});
```

### Advanced Options
```javascript
$('#myTable').DataTable({
    // ... basic options ...
    
    // Enable/disable features
    searching: true,      // Enable search box
    ordering: true,       // Enable column sorting
    paging: true,         // Enable pagination
    info: true,           // Show "Showing X to Y of Z entries"
    lengthChange: true,   // Show page length dropdown
    
    // Scroll options
    scrollX: true,        // Enable horizontal scroll
    scrollY: '400px',     // Enable vertical scroll with height
    scrollCollapse: true, // Collapse when less data
    
    // State saving
    stateSave: true,      // Remember user settings (page, search, etc)
    
    // Custom rendering
    columnDefs: [
        {
            targets: 0,
            render: function(data, type, row) {
                return '<strong>' + data + '</strong>';
            }
        }
    ]
});
```

## Customization

### Custom Search Placeholder
```javascript
$('#myTable').DataTable({
    language: {
        search: "Cari:",
        searchPlaceholder: "Ketik untuk mencari..."
    }
});
```

### Custom Buttons (Export)
```html
<!-- Add buttons extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$('#myTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>
```

### Column Filtering
```javascript
$('#myTable thead tr').clone(true).appendTo('#myTable thead');
$('#myTable thead tr:eq(1) th').each(function(i) {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    
    $('input', this).on('keyup change', function() {
        if (table.column(i).search() !== this.value) {
            table.column(i).search(this.value).draw();
        }
    });
});

var table = $('#myTable').DataTable();
```

## Performance Tips

### 1. Server-Side Processing
Untuk data yang sangat besar (>10,000 rows), gunakan server-side processing:

```javascript
$('#myTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/api/data',
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'email' }
    ]
});
```

**Controller**:
```php
public function getData(Request $request)
{
    return datatables()->of(Model::query())->toJson();
}
```

### 2. Defer Rendering
```javascript
$('#myTable').DataTable({
    deferRender: true
});
```

### 3. Limit Initial Load
```javascript
$('#myTable').DataTable({
    deferLoading: 57 // Total records, but only load first page
});
```

## Troubleshooting

### Table not initializing?
1. Check jQuery is loaded before DataTables
2. Check table has `<thead>` and `<tbody>`
3. Check console for JavaScript errors
4. Ensure table ID is unique

### Responsive not working?
1. Add `style="width:100%"` to table
2. Ensure responsive CSS is loaded
3. Check parent container width

### Search not working?
1. Check `searching: true` is set
2. Verify data is in `<tbody>`
3. Check for JavaScript errors

### Sorting not working on column?
1. Check `orderable: true` for that column
2. Verify data format is consistent
3. Use `type: 'date'` for date columns

## Browser Support

- ✅ Chrome/Edge (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Mobile Browsers
- ✅ IE11 (with polyfills)

## Resources

- **Official Docs**: https://datatables.net/
- **Examples**: https://datatables.net/examples/
- **API Reference**: https://datatables.net/reference/
- **Extensions**: https://datatables.net/extensions/

---

**Status**: ✅ IMPLEMENTED
**Version**: 1.13.7
**Date**: 2025-11-15
