# 🗺️ ERD Documentation Index

## 📚 Daftar File ERD

Dokumentasi ERD tersedia dalam beberapa format untuk berbagai kebutuhan:

---

### 1. 📄 [ERD.md](ERD.md) - **ERD Lengkap**
**Format**: Markdown dengan 8 variasi diagram

**Isi**:
- ✅ Mermaid Diagram (render di GitHub/GitLab)
- ✅ ASCII Art ERD (detailed)
- ✅ Simplified ERD
- ✅ Crow's Foot Notation
- ✅ Table Relationship Matrix
- ✅ Data Flow Diagram
- ✅ Class Isolation Diagram
- ✅ Database Statistics

**Gunakan untuk**: 
- Dokumentasi lengkap
- Presentasi
- Reference detail

---

### 2. 🎨 [ERD.puml](ERD.puml) - **PlantUML Diagram**
**Format**: PlantUML source code

**Cara Render**:
```bash
# Install PlantUML
npm install -g node-plantuml

# Generate PNG
puml generate ERD.puml -o ERD.png

# Generate SVG
puml generate ERD.puml -o ERD.svg
```

**Online Render**:
- http://www.plantuml.com/plantuml/uml/
- https://plantuml-editor.kkeisuke.com/

**Gunakan untuk**:
- Generate gambar ERD
- Export ke PNG/SVG/PDF
- Presentasi visual

---

### 3. 📋 [ERD_SIMPLE.md](ERD_SIMPLE.md) - **ERD Sederhana**
**Format**: Markdown dengan diagram simplified

**Isi**:
- ✅ Relasi utama (simplified)
- ✅ Relasi per modul
- ✅ Tabel inti (9 tabel)
- ✅ Foreign keys
- ✅ Sistem kelas (class isolation)
- ✅ Data flow
- ✅ Query patterns

**Gunakan untuk**:
- Quick reference
- Onboarding developer baru
- Daily development

---

### 4. 📊 [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) - **Schema Detail**
**Format**: Markdown dengan detail lengkap

**Isi**:
- ✅ Detail semua tabel (14 tabel)
- ✅ Field descriptions
- ✅ Relasi lengkap
- ✅ Business rules
- ✅ Query examples
- ✅ Security considerations

**Gunakan untuk**:
- Reference lengkap
- Database design
- Development guide

---

## 🎯 Quick Start

### Untuk Developer Baru
1. Baca **[ERD_SIMPLE.md](ERD_SIMPLE.md)** untuk overview
2. Lihat **[ERD.puml](ERD.puml)** untuk visualisasi
3. Baca **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)** untuk detail

### Untuk Presentasi
1. Generate gambar dari **[ERD.puml](ERD.puml)**
2. Gunakan diagram dari **[ERD.md](ERD.md)**
3. Referensi statistik dari **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)**

### Untuk Development
1. Quick reference: **[ERD_SIMPLE.md](ERD_SIMPLE.md)**
2. Query examples: **[DATABASE_SCHEMA.md](DATABASE_SCHEMA.md)**
3. Relasi detail: **[ERD.md](ERD.md)**

---

## 📊 ERD Overview

### Tabel Inti (9 Tabel)

```
1. peran              → Role system
2. users              → All users (admin, guru, siswa)
3. materi             → Learning materials
4. kosakata           → Vocabulary words
5. kuis               → Quizzes
6. soal_kuis          → Quiz questions
7. pilihan_jawaban    → Answer choices
8. percobaan_kuis     → Quiz attempts
9. jawaban_siswa      → Student answers
```

### Relasi Utama

```
peran (1) ──► users (N)
users/guru (1) ──► materi (N) ──► kosakata (N)
users/guru (1) ──► kuis (N) ──► soal_kuis (N) ──► pilihan_jawaban (N)
users/siswa (1) ──► percobaan_kuis (N) ──► jawaban_siswa (N)
```

### Sistem Kelas

```
GURU KELAS 7 → MATERI/KUIS (kelas_target=7) → SISWA KELAS 7
GURU KELAS 8 → MATERI/KUIS (kelas_target=8) → SISWA KELAS 8
```

---

## 🔧 Tools untuk Visualisasi

### Online Tools
1. **Mermaid Live Editor**
   - URL: https://mermaid.live/
   - Copy diagram dari ERD.md (Mermaid section)
   - Export ke PNG/SVG

2. **PlantUML Online**
   - URL: http://www.plantuml.com/plantuml/uml/
   - Paste ERD.puml content
   - Download gambar

3. **dbdiagram.io**
   - URL: https://dbdiagram.io/
   - Import dari SQL atau manual
   - Export ke berbagai format

### Desktop Tools
1. **MySQL Workbench**
   - Reverse engineer dari database
   - Generate ERD otomatis

2. **DBeaver**
   - ER Diagram viewer
   - Export ke gambar

3. **Visual Studio Code**
   - Extension: PlantUML
   - Extension: Mermaid Preview

---

## 📝 Cara Generate Gambar ERD

### Method 1: PlantUML (Recommended)
```bash
# Install
npm install -g node-plantuml

# Generate PNG
puml generate ERD.puml -o ERD.png

# Generate SVG (scalable)
puml generate ERD.puml -o ERD.svg
```

### Method 2: Mermaid CLI
```bash
# Install
npm install -g @mermaid-js/mermaid-cli

# Extract mermaid code from ERD.md
# Save to ERD.mmd

# Generate PNG
mmdc -i ERD.mmd -o ERD.png

# Generate SVG
mmdc -i ERD.mmd -o ERD.svg
```

### Method 3: Online (No Install)
1. Buka https://mermaid.live/
2. Copy Mermaid diagram dari ERD.md
3. Paste dan edit
4. Download PNG/SVG

---

## 🎨 Customization

### Warna dan Style
Edit file **ERD.puml**:
```plantuml
' Change colors
skinparam class {
    BackgroundColor LightBlue
    BorderColor Navy
    ArrowColor DarkGreen
}

' Change font
skinparam defaultFontName Arial
skinparam defaultFontSize 12
```

### Tambah Notes
```plantuml
note right of table_name
  Your note here
end note
```

### Highlight Table
```plantuml
table(important_table) #LightYellow {
    ...
}
```

---

## 📊 Database Statistics

### After Seeding

| Table | Records | Kelas 7 | Kelas 8 |
|-------|---------|---------|---------|
| peran | 3 | - | - |
| users | 17 | 7 | 7 |
| materi | 10 | 6 | 4 |
| kosakata | 50 | 30 | 20 |
| kuis | 7 | 4 | 3 |
| soal_kuis | 19 | 13 | 6 |
| pilihan_jawaban | 70 | 48 | 22 |
| percobaan_kuis | 26 | ~15 | ~11 |
| jawaban_siswa | 96 | ~60 | ~36 |

---

## 🔗 Related Documentation

### Database
- [DATABASE_SCHEMA.md](DATABASE_SCHEMA.md) - Schema lengkap
- [ANALISIS_MIGRATION_DAN_SEEDER.md](ANALISIS_MIGRATION_DAN_SEEDER.md) - Analisis migration

### Seeder
- [SEEDER_LENGKAP.md](SEEDER_LENGKAP.md) - Dokumentasi seeder
- [QUICK_REFERENCE_SEEDER.md](QUICK_REFERENCE_SEEDER.md) - Quick reference
- [README_SEEDER.md](README_SEEDER.md) - Index seeder

### Application
- [README.md](README.md) - Main documentation
- [CHANGELOG.md](CHANGELOG.md) - Version history
- [prd.md](prd.md) - Product requirements

---

## 🎯 Best Practices

### Saat Membuat Perubahan Database

1. **Update Migration**
   ```bash
   php artisan make:migration update_table_name
   ```

2. **Update ERD**
   - Edit ERD.puml
   - Regenerate gambar
   - Update ERD.md dan ERD_SIMPLE.md

3. **Update Documentation**
   - Update DATABASE_SCHEMA.md
   - Update ANALISIS_MIGRATION_DAN_SEEDER.md

4. **Update Seeder**
   - Sesuaikan seeder dengan struktur baru
   - Test dengan `php artisan migrate:fresh --seed`

5. **Commit Changes**
   ```bash
   git add .
   git commit -m "Update database schema: [description]"
   ```

---

## 📞 Support

### Jika Menemukan Masalah

1. **ERD tidak sesuai dengan database**
   - Cek migration terbaru
   - Update ERD.puml
   - Regenerate diagram

2. **Relasi tidak jelas**
   - Baca DATABASE_SCHEMA.md
   - Lihat query examples
   - Check foreign keys di migration

3. **Butuh format lain**
   - Export dari PlantUML
   - Gunakan online tools
   - Request format baru

---

## 📝 Changelog

### Version 1.3.2 (2025-11-20)
- ✅ Added complete ERD documentation
- ✅ Added PlantUML source
- ✅ Added simplified ERD
- ✅ Added 8 diagram variations
- ✅ Added class isolation diagram
- ✅ Added data flow diagram

### Version 1.3.1 (2025-11-20)
- ✅ Added kelas_target to materi & kuis
- ✅ Added kelas_mengajar to users
- ✅ Updated all seeders for class system

### Version 1.0.0 (2025-11-15)
- ✅ Initial database schema
- ✅ 14 tables created
- ✅ Basic relationships established

---

**Last Updated**: 2025-11-20  
**Version**: 1.3.2  
**Database**: MySQL/MariaDB  
**Total Tables**: 14 (9 core + 5 system)  
**Total Relationships**: 12 foreign keys
