-- ============================================================================
-- DATABASE SCHEMA - Aplikasi Belajar Bahasa Inggris
-- Version: 1.3.2
-- Date: 2025-11-20
-- Description: Complete SQL schema based on ERD
-- ============================================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS belajar_inggris 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE belajar_inggris;

-- ============================================================================
-- TABLE 1: peran (Roles)
-- Description: User roles (super_admin, guru, siswa)
-- ============================================================================
CREATE TABLE peran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_peran VARCHAR(255) NOT NULL COMMENT 'super_admin, guru, siswa',
    deskripsi VARCHAR(255) NULL COMMENT 'Role description',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_nama_peran (nama_peran)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='User roles table';

-- ============================================================================
-- TABLE 2: users (Users)
-- Description: All users (admin, guru, siswa)
-- ============================================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL COMMENT 'Full name',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email address',
    password VARCHAR(255) NOT NULL COMMENT 'Hashed password',
    peran_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to peran',
    nomor_induk VARCHAR(255) NULL COMMENT 'NIP for guru, NIS for siswa',
    kelas VARCHAR(255) NULL COMMENT 'Class for siswa (7 or 8)',
    kelas_mengajar VARCHAR(255) NULL COMMENT 'Teaching class for guru (7 or 8)',
    alamat TEXT NULL COMMENT 'Address',
    no_telepon VARCHAR(255) NULL COMMENT 'Phone number',
    jenis_kelamin ENUM('L', 'P') NULL COMMENT 'Gender: L=Male, P=Female',
    tanggal_lahir DATE NULL COMMENT 'Birth date',
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_peran_id (peran_id),
    INDEX idx_kelas (kelas),
    INDEX idx_kelas_mengajar (kelas_mengajar),
    
    CONSTRAINT fk_users_peran 
        FOREIGN KEY (peran_id) 
        REFERENCES peran(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Users table (admin, guru, siswa)';

-- ============================================================================
-- TABLE 3: materi (Materials)
-- Description: Learning materials (Grammar & Vocabulary)
-- ============================================================================
CREATE TABLE materi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL COMMENT 'Material title',
    jenis_materi ENUM('vocabulary', 'grammar') NOT NULL COMMENT 'Material type',
    deskripsi TEXT NULL COMMENT 'Description',
    konten TEXT NULL COMMENT 'Content for grammar',
    video_url VARCHAR(255) NULL COMMENT 'YouTube video URL',
    video_path VARCHAR(255) NULL COMMENT 'Local video path',
    dibuat_oleh BIGINT UNSIGNED NOT NULL COMMENT 'FK to users (guru)',
    kelas_target VARCHAR(255) NULL COMMENT 'Target class (7 or 8)',
    urutan INT NOT NULL DEFAULT 0 COMMENT 'Display order',
    aktif TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Active status',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_dibuat_oleh (dibuat_oleh),
    INDEX idx_jenis_materi (jenis_materi),
    INDEX idx_kelas_target (kelas_target),
    INDEX idx_aktif (aktif),
    
    CONSTRAINT fk_materi_users 
        FOREIGN KEY (dibuat_oleh) 
        REFERENCES users(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Learning materials table';

-- ============================================================================
-- TABLE 4: kosakata (Vocabularies)
-- Description: Vocabulary words for vocabulary materials
-- ============================================================================
CREATE TABLE kosakata (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    materi_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to materi',
    kata_inggris VARCHAR(255) NOT NULL COMMENT 'English word',
    kata_indonesia VARCHAR(255) NOT NULL COMMENT 'Indonesian translation',
    jenis_kata VARCHAR(255) NULL COMMENT 'Word type (noun, verb, adjective, etc)',
    contoh_kalimat TEXT NULL COMMENT 'Example sentence',
    audio_path VARCHAR(255) NULL COMMENT 'Audio file path',
    gambar_path VARCHAR(255) NULL COMMENT 'Image file path',
    urutan INT NOT NULL DEFAULT 0 COMMENT 'Display order',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_materi_id (materi_id),
    INDEX idx_urutan (urutan),
    
    CONSTRAINT fk_kosakata_materi 
        FOREIGN KEY (materi_id) 
        REFERENCES materi(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Vocabulary words table';

-- ============================================================================
-- TABLE 5: kuis (Quizzes)
-- Description: Quiz/test data
-- ============================================================================
CREATE TABLE kuis (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL COMMENT 'Quiz title',
    deskripsi TEXT NULL COMMENT 'Quiz description',
    materi_id BIGINT UNSIGNED NULL COMMENT 'FK to materi (optional)',
    durasi_menit INT NOT NULL DEFAULT 30 COMMENT 'Duration in minutes',
    nilai_minimal INT NOT NULL DEFAULT 70 COMMENT 'Minimum passing score (0-100)',
    tingkat_kesulitan ENUM('mudah', 'sedang', 'sulit') NOT NULL DEFAULT 'sedang' COMMENT 'Difficulty level',
    dibuat_oleh BIGINT UNSIGNED NOT NULL COMMENT 'FK to users (guru)',
    kelas_target VARCHAR(255) NULL COMMENT 'Target class (7 or 8)',
    aktif TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Active status',
    acak_soal TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Randomize questions',
    tampilkan_jawaban TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Show answers after completion',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_dibuat_oleh (dibuat_oleh),
    INDEX idx_materi_id (materi_id),
    INDEX idx_kelas_target (kelas_target),
    INDEX idx_aktif (aktif),
    
    CONSTRAINT fk_kuis_users 
        FOREIGN KEY (dibuat_oleh) 
        REFERENCES users(id) 
        ON DELETE CASCADE,
    CONSTRAINT fk_kuis_materi 
        FOREIGN KEY (materi_id) 
        REFERENCES materi(id) 
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Quizzes table';

-- ============================================================================
-- TABLE 6: soal_kuis (Quiz Questions)
-- Description: Questions for quizzes
-- ============================================================================
CREATE TABLE soal_kuis (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kuis_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to kuis',
    pertanyaan TEXT NOT NULL COMMENT 'Question text',
    jenis_soal ENUM('pilihan_ganda', 'benar_salah', 'isian') NOT NULL DEFAULT 'pilihan_ganda' COMMENT 'Question type',
    gambar_path VARCHAR(255) NULL COMMENT 'Image file path',
    audio_path VARCHAR(255) NULL COMMENT 'Audio file path (for listening)',
    poin INT NOT NULL DEFAULT 10 COMMENT 'Points for this question',
    urutan INT NOT NULL DEFAULT 0 COMMENT 'Display order',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_kuis_id (kuis_id),
    INDEX idx_urutan (urutan),
    
    CONSTRAINT fk_soal_kuis_kuis 
        FOREIGN KEY (kuis_id) 
        REFERENCES kuis(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Quiz questions table';

-- ============================================================================
-- TABLE 7: pilihan_jawaban (Answer Choices)
-- Description: Answer choices for multiple choice questions
-- ============================================================================
CREATE TABLE pilihan_jawaban (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    soal_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to soal_kuis',
    teks_jawaban TEXT NOT NULL COMMENT 'Answer text',
    jawaban_benar TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Is correct answer',
    urutan INT NOT NULL DEFAULT 0 COMMENT 'Display order',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_soal_id (soal_id),
    INDEX idx_jawaban_benar (jawaban_benar),
    
    CONSTRAINT fk_pilihan_jawaban_soal 
        FOREIGN KEY (soal_id) 
        REFERENCES soal_kuis(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Answer choices table';

-- ============================================================================
-- TABLE 8: percobaan_kuis (Quiz Attempts)
-- Description: Student quiz attempts
-- ============================================================================
CREATE TABLE percobaan_kuis (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kuis_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to kuis',
    siswa_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to users (siswa)',
    waktu_mulai TIMESTAMP NOT NULL COMMENT 'Start time',
    waktu_selesai TIMESTAMP NULL COMMENT 'End time',
    nilai INT NULL COMMENT 'Final score (0-100)',
    jumlah_benar INT NOT NULL DEFAULT 0 COMMENT 'Number of correct answers',
    jumlah_salah INT NOT NULL DEFAULT 0 COMMENT 'Number of wrong answers',
    total_soal INT NOT NULL DEFAULT 0 COMMENT 'Total questions',
    status ENUM('sedang_dikerjakan', 'selesai', 'waktu_habis') NOT NULL DEFAULT 'sedang_dikerjakan' COMMENT 'Attempt status',
    lulus TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Passed or not',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_kuis_id (kuis_id),
    INDEX idx_siswa_id (siswa_id),
    INDEX idx_status (status),
    INDEX idx_waktu_mulai (waktu_mulai),
    
    CONSTRAINT fk_percobaan_kuis_kuis 
        FOREIGN KEY (kuis_id) 
        REFERENCES kuis(id) 
        ON DELETE CASCADE,
    CONSTRAINT fk_percobaan_kuis_users 
        FOREIGN KEY (siswa_id) 
        REFERENCES users(id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Quiz attempts table';

-- ============================================================================
-- TABLE 9: jawaban_siswa (Student Answers)
-- Description: Student answers for each question
-- ============================================================================
CREATE TABLE jawaban_siswa (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    percobaan_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to percobaan_kuis',
    soal_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to soal_kuis',
    pilihan_jawaban_id BIGINT UNSIGNED NULL COMMENT 'FK to pilihan_jawaban',
    jawaban_isian TEXT NULL COMMENT 'Answer text for essay questions',
    benar TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Is answer correct',
    poin_didapat INT NOT NULL DEFAULT 0 COMMENT 'Points earned',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_percobaan_id (percobaan_id),
    INDEX idx_soal_id (soal_id),
    INDEX idx_pilihan_jawaban_id (pilihan_jawaban_id),
    
    CONSTRAINT fk_jawaban_siswa_percobaan 
        FOREIGN KEY (percobaan_id) 
        REFERENCES percobaan_kuis(id) 
        ON DELETE CASCADE,
    CONSTRAINT fk_jawaban_siswa_soal 
        FOREIGN KEY (soal_id) 
        REFERENCES soal_kuis(id) 
        ON DELETE CASCADE,
    CONSTRAINT fk_jawaban_siswa_pilihan 
        FOREIGN KEY (pilihan_jawaban_id) 
        REFERENCES pilihan_jawaban(id) 
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Student answers table';

-- ============================================================================
-- SYSTEM TABLES (Laravel Default)
-- ============================================================================

-- Password Reset Tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sessions
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    
    INDEX idx_queue (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rich Texts (Trix Editor)
CREATE TABLE rich_texts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    field VARCHAR(255) NOT NULL,
    body LONGTEXT NOT NULL,
    recordable_type VARCHAR(255) NOT NULL,
    recordable_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    INDEX idx_recordable (recordable_type, recordable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SAMPLE DATA (Optional - for testing)
-- ============================================================================

-- Insert Roles
INSERT INTO peran (nama_peran, deskripsi, created_at, updated_at) VALUES
('super_admin', 'Super Administrator', NOW(), NOW()),
('guru', 'Guru/Teacher', NOW(), NOW()),
('siswa', 'Siswa/Student', NOW(), NOW());

-- Insert Super Admin
INSERT INTO users (name, email, password, peran_id, email_verified_at, created_at, updated_at) VALUES
('Super Admin', 'admin@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), NOW(), NOW());
-- Password: password

-- ============================================================================
-- VIEWS (Optional - for reporting)
-- ============================================================================

-- View: Guru dengan jumlah materi
CREATE OR REPLACE VIEW v_guru_materi AS
SELECT 
    u.id,
    u.name,
    u.email,
    u.kelas_mengajar,
    COUNT(m.id) as jumlah_materi
FROM users u
LEFT JOIN materi m ON u.id = m.dibuat_oleh
WHERE u.peran_id = (SELECT id FROM peran WHERE nama_peran = 'guru')
GROUP BY u.id, u.name, u.email, u.kelas_mengajar;

-- View: Siswa dengan progress kuis
CREATE OR REPLACE VIEW v_siswa_progress AS
SELECT 
    u.id,
    u.name,
    u.email,
    u.kelas,
    COUNT(pk.id) as total_percobaan,
    SUM(CASE WHEN pk.status = 'selesai' THEN 1 ELSE 0 END) as selesai,
    AVG(CASE WHEN pk.status = 'selesai' THEN pk.nilai ELSE NULL END) as rata_rata_nilai
FROM users u
LEFT JOIN percobaan_kuis pk ON u.id = pk.siswa_id
WHERE u.peran_id = (SELECT id FROM peran WHERE nama_peran = 'siswa')
GROUP BY u.id, u.name, u.email, u.kelas;

-- ============================================================================
-- STORED PROCEDURES (Optional)
-- ============================================================================

DELIMITER //

-- Procedure: Hitung nilai percobaan kuis
CREATE PROCEDURE sp_hitung_nilai_percobaan(IN p_percobaan_id BIGINT)
BEGIN
    DECLARE v_total_poin INT;
    DECLARE v_poin_didapat INT;
    DECLARE v_nilai INT;
    DECLARE v_jumlah_benar INT;
    DECLARE v_jumlah_salah INT;
    DECLARE v_total_soal INT;
    DECLARE v_nilai_minimal INT;
    DECLARE v_lulus TINYINT;
    
    -- Get total poin dari kuis
    SELECT SUM(sk.poin) INTO v_total_poin
    FROM soal_kuis sk
    JOIN percobaan_kuis pk ON sk.kuis_id = pk.kuis_id
    WHERE pk.id = p_percobaan_id;
    
    -- Get poin yang didapat
    SELECT 
        SUM(js.poin_didapat),
        SUM(CASE WHEN js.benar = 1 THEN 1 ELSE 0 END),
        SUM(CASE WHEN js.benar = 0 THEN 1 ELSE 0 END),
        COUNT(*)
    INTO v_poin_didapat, v_jumlah_benar, v_jumlah_salah, v_total_soal
    FROM jawaban_siswa js
    WHERE js.percobaan_id = p_percobaan_id;
    
    -- Hitung nilai (0-100)
    IF v_total_poin > 0 THEN
        SET v_nilai = ROUND((v_poin_didapat / v_total_poin) * 100);
    ELSE
        SET v_nilai = 0;
    END IF;
    
    -- Check lulus atau tidak
    SELECT k.nilai_minimal INTO v_nilai_minimal
    FROM percobaan_kuis pk
    JOIN kuis k ON pk.kuis_id = k.id
    WHERE pk.id = p_percobaan_id;
    
    SET v_lulus = IF(v_nilai >= v_nilai_minimal, 1, 0);
    
    -- Update percobaan_kuis
    UPDATE percobaan_kuis
    SET 
        nilai = v_nilai,
        jumlah_benar = v_jumlah_benar,
        jumlah_salah = v_jumlah_salah,
        total_soal = v_total_soal,
        lulus = v_lulus,
        status = 'selesai',
        waktu_selesai = NOW()
    WHERE id = p_percobaan_id;
END //

DELIMITER ;

-- ============================================================================
-- TRIGGERS (Optional)
-- ============================================================================

DELIMITER //

-- Trigger: Auto update nilai setelah jawaban siswa diinsert
CREATE TRIGGER tr_after_jawaban_siswa_insert
AFTER INSERT ON jawaban_siswa
FOR EACH ROW
BEGIN
    DECLARE v_total_soal INT;
    DECLARE v_total_dijawab INT;
    
    -- Check apakah semua soal sudah dijawab
    SELECT COUNT(*) INTO v_total_soal
    FROM soal_kuis sk
    JOIN percobaan_kuis pk ON sk.kuis_id = pk.kuis_id
    WHERE pk.id = NEW.percobaan_id;
    
    SELECT COUNT(*) INTO v_total_dijawab
    FROM jawaban_siswa
    WHERE percobaan_id = NEW.percobaan_id;
    
    -- Jika semua soal sudah dijawab, hitung nilai
    IF v_total_soal = v_total_dijawab THEN
        CALL sp_hitung_nilai_percobaan(NEW.percobaan_id);
    END IF;
END //

DELIMITER ;

-- ============================================================================
-- INDEXES FOR PERFORMANCE (Additional)
-- ============================================================================

-- Composite indexes for common queries
CREATE INDEX idx_materi_guru_kelas ON materi(dibuat_oleh, kelas_target, aktif);
CREATE INDEX idx_kuis_guru_kelas ON kuis(dibuat_oleh, kelas_target, aktif);
CREATE INDEX idx_percobaan_siswa_status ON percobaan_kuis(siswa_id, status);

-- ============================================================================
-- GRANTS (Optional - for production)
-- ============================================================================

-- Create application user
-- CREATE USER 'belajar_app'@'localhost' IDENTIFIED BY 'secure_password_here';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON belajar_inggris.* TO 'belajar_app'@'localhost';
-- FLUSH PRIVILEGES;

-- ============================================================================
-- END OF SCHEMA
-- ============================================================================

-- Verify tables
SELECT 
    TABLE_NAME,
    TABLE_ROWS,
    ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = 'belajar_inggris'
ORDER BY TABLE_NAME;
