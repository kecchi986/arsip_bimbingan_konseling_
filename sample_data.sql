-- Sample data untuk aplikasi arsip bimbingan konseling
-- Jalankan query ini di database SQLite setelah aplikasi berjalan

-- Insert sample students
INSERT INTO students (nis, name, grade, major, room) VALUES
('2021001', 'Ahmad Fadillah', 'X', 'IPA', 'X-IPA-1'),
('2021002', 'Siti Nurhaliza', 'X', 'IPA', 'X-IPA-1'),
('2021003', 'Budi Santoso', 'X', 'IPS', 'X-IPS-1'),
('2021004', 'Dewi Sartika', 'XI', 'IPA', 'XI-IPA-1'),
('2021005', 'Rudi Hermawan', 'XI', 'IPS', 'XI-IPS-1'),
('2021006', 'Nina Safitri', 'XII', 'IPA', 'XII-IPA-1'),
('2021007', 'Agus Setiawan', 'XII', 'IPS', 'XII-IPS-1'),
('2021008', 'Maya Indah', 'X', 'IPA', 'X-IPA-2'),
('2021009', 'Doni Kusuma', 'XI', 'IPA', 'XI-IPA-2'),
('2021010', 'Rina Marlina', 'XII', 'IPS', 'XII-IPS-2');

-- Insert sample services
INSERT INTO services (name, parent_id) VALUES
('Bimbingan Pribadi', NULL),
('Bimbingan Sosial', NULL),
('Bimbingan Belajar', NULL),
('Bimbingan Karir', NULL);

-- Insert sub services
INSERT INTO services (name, parent_id) VALUES
('Konseling Individual', 1),
('Konseling Kelompok', 1),
('Pengembangan Diri', 1),
('Keterampilan Sosial', 2),
('Komunikasi Antar Teman', 2),
('Metode Belajar Efektif', 3),
('Manajemen Waktu', 3),
('Teknik Membaca Cepat', 3),
('Eksplorasi Minat', 4),
('Perencanaan Karir', 4),
('Pemilihan Jurusan', 4);

-- Insert sample counseling records
INSERT INTO counseling_records (date, activity, location, description, notes, student_id, service_id, user_id) VALUES
('2024-01-15', 'Konseling Individual - Masalah Belajar', 'Ruang BK', 'Siswa mengalami kesulitan dalam memahami mata pelajaran matematika. Diberikan tips belajar dan motivasi.', 'Siswa terlihat lebih semangat setelah konseling', 1, 5, 1),
('2024-01-16', 'Konseling Kelompok - Kepercayaan Diri', 'Ruang BK', 'Konseling kelompok untuk meningkatkan kepercayaan diri siswa dalam berinteraksi sosial.', 'Siswa aktif berpartisipasi dalam diskusi', 2, 6, 1),
('2024-01-17', 'Bimbingan Karir - Pemilihan Jurusan', 'Ruang BK', 'Memberikan informasi tentang berbagai jurusan di perguruan tinggi dan prospek karirnya.', 'Siswa sudah memiliki gambaran karir yang jelas', 4, 12, 1),
('2024-01-18', 'Konseling Individual - Masalah Keluarga', 'Ruang BK', 'Siswa mengalami konflik dengan orang tua. Diberikan saran untuk komunikasi yang lebih baik.', 'Siswa akan mencoba pendekatan yang disarankan', 3, 5, 1),
('2024-01-19', 'Bimbingan Belajar - Teknik Membaca', 'Ruang BK', 'Pelatihan teknik membaca cepat dan efektif untuk meningkatkan pemahaman materi pelajaran.', 'Siswa menunjukkan peningkatan dalam kecepatan membaca', 5, 8, 1),
('2024-01-20', 'Konseling Individual - Stress Akademik', 'Ruang BK', 'Siswa mengalami stress karena tekanan akademik. Diberikan teknik relaksasi dan manajemen stress.', 'Siswa merasa lebih tenang setelah konseling', 6, 5, 1),
('2024-01-21', 'Bimbingan Sosial - Komunikasi', 'Ruang BK', 'Pelatihan keterampilan komunikasi yang efektif dalam berinteraksi dengan teman dan guru.', 'Siswa lebih percaya diri dalam berkomunikasi', 7, 4, 1),
('2024-01-22', 'Konseling Individual - Motivasi Belajar', 'Ruang BK', 'Siswa mengalami penurunan motivasi belajar. Diberikan motivasi dan strategi belajar yang menarik.', 'Siswa kembali semangat untuk belajar', 8, 5, 1),
('2024-01-23', 'Bimbingan Karir - Eksplorasi Minat', 'Ruang BK', 'Membantu siswa mengeksplorasi minat dan bakat untuk menentukan arah karir yang tepat.', 'Siswa menemukan minat baru yang potensial', 9, 9, 1),
('2024-01-24', 'Konseling Kelompok - Kerjasama Tim', 'Ruang BK', 'Konseling kelompok untuk meningkatkan kemampuan kerjasama tim dan kepemimpinan.', 'Siswa belajar pentingnya kerjasama dalam tim', 10, 6, 1); 