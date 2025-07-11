-- Struktur tabel user
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user'
);

-- Struktur tabel siswa
CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    tingkat VARCHAR(10) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    ruangan VARCHAR(20) NOT NULL
);

-- Struktur tabel layanan
CREATE TABLE layanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

-- Struktur tabel sublayanan
CREATE TABLE sublayanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    layanan_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    FOREIGN KEY (layanan_id) REFERENCES layanan(id) ON DELETE CASCADE
);

-- Struktur tabel bimbingan
CREATE TABLE bimbingan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    kegiatan VARCHAR(100) NOT NULL,
    tempat VARCHAR(100) NOT NULL,
    uraian VARCHAR(255) NOT NULL,
    keterangan VARCHAR(255),
    siswa_id INT NOT NULL,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE
);

-- Insert user admin default (email: admin@admin.com, password: admin123)
INSERT INTO user (email, password, role) VALUES 
('admin@admin.com', '$2y$10$j7zCXkKkw2TZgoVVzFgFOOs.AVAQBSPdrEMZjsC5bXkO0/qfEEWYi', 'admin'); 