# Aplikasi Dokumentasi Arsip Bimbingan Konseling

Aplikasi web untuk mengelola dokumentasi arsip bimbingan konseling di sekolah. Dibangun dengan React TypeScript untuk frontend dan Node.js Express untuk backend, menggunakan SQLite sebagai database.

## Fitur Utama

### 🔐 Autentikasi
- Login dan logout dengan JWT
- Ganti password
- Autentikasi pengguna (Guru BP/BK)

### 👥 Manajemen Data Siswa
- Lihat daftar siswa dengan pencarian
- Tambah siswa baru
- Edit data siswa
- Hapus siswa
- Lihat detail siswa

### 📋 Manajemen Rekaman Konseling
- Lihat daftar rekaman kegiatan konseling
- Tambah rekaman baru
- Edit rekaman
- Hapus rekaman
- Lihat detail rekaman
- Cetak (print) rekaman

### 🎯 Manajemen Layanan Konseling
- Lihat daftar layanan dan sub layanan
- Tambah layanan baru
- Edit layanan
- Hapus layanan
- Tambah sub layanan
- Edit sub layanan
- Hapus sub layanan

### 📊 Dashboard
- Ringkasan statistik (total siswa, rekaman, layanan)
- Rekaman terbaru
- Aksi cepat untuk navigasi

## Teknologi yang Digunakan

### Frontend
- React 18 dengan TypeScript
- React Router untuk navigasi
- Tailwind CSS untuk styling
- Lucide React untuk icons
- React Hook Form untuk form handling
- React Hot Toast untuk notifikasi
- Axios untuk HTTP requests

### Backend
- Node.js dengan Express
- SQLite database
- JWT untuk autentikasi
- bcryptjs untuk enkripsi password
- Helmet untuk keamanan
- CORS untuk cross-origin requests
- Rate limiting

## Instalasi dan Setup

### Prerequisites
- Node.js (versi 16 atau lebih baru)
- npm atau yarn

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd arsip_bimbingan_konseling_
   ```

2. **Install dependencies untuk semua bagian**
   ```bash
   npm run install-all
   ```

3. **Jalankan aplikasi dalam mode development**
   ```bash
   npm run dev
   ```

   Ini akan menjalankan:
   - Backend server di `http://localhost:5000`
   - Frontend client di `http://localhost:3000`

### Akses Aplikasi

1. Buka browser dan kunjungi `http://localhost:3000`
2. Login dengan kredensial default:
   - **Email:** admin@school.com
   - **Password:** admin123

## Struktur Database

### Tabel Users
- `id` - Primary key
- `email` - Email pengguna (unique)
- `password` - Password terenkripsi
- `name` - Nama pengguna
- `created_at` - Timestamp pembuatan

### Tabel Students
- `id` - Primary key
- `nis` - Nomor Induk Siswa (unique)
- `name` - Nama siswa
- `grade` - Tingkat kelas
- `major` - Jurusan
- `room` - Ruangan
- `created_at` - Timestamp pembuatan

### Tabel Services
- `id` - Primary key
- `name` - Nama layanan
- `parent_id` - ID layanan induk (untuk sub layanan)
- `created_at` - Timestamp pembuatan

### Tabel Counseling Records
- `id` - Primary key
- `date` - Tanggal kegiatan
- `activity` - Nama kegiatan
- `location` - Tempat kegiatan
- `description` - Uraian kegiatan
- `notes` - Keterangan tambahan
- `student_id` - Foreign key ke tabel students
- `service_id` - Foreign key ke tabel services
- `user_id` - Foreign key ke tabel users
- `created_at` - Timestamp pembuatan

## API Endpoints

### Autentikasi
- `POST /api/auth/login` - Login pengguna
- `POST /api/auth/change-password` - Ganti password

### Siswa
- `GET /api/students` - Ambil semua siswa
- `POST /api/students` - Tambah siswa baru
- `GET /api/students/:id` - Ambil detail siswa
- `PUT /api/students/:id` - Update data siswa
- `DELETE /api/students/:id` - Hapus siswa

### Layanan
- `GET /api/services` - Ambil semua layanan
- `POST /api/services` - Tambah layanan baru
- `PUT /api/services/:id` - Update layanan
- `DELETE /api/services/:id` - Hapus layanan

### Rekaman Konseling
- `GET /api/counseling-records` - Ambil semua rekaman
- `POST /api/counseling-records` - Tambah rekaman baru
- `GET /api/counseling-records/:id` - Ambil detail rekaman
- `PUT /api/counseling-records/:id` - Update rekaman
- `DELETE /api/counseling-records/:id` - Hapus rekaman

## Scripts NPM

- `npm run dev` - Jalankan aplikasi dalam mode development
- `npm run server` - Jalankan backend server saja
- `npm run client` - Jalankan frontend client saja
- `npm run build` - Build aplikasi untuk production
- `npm run install-all` - Install dependencies untuk semua bagian

## Keamanan

- Password dienkripsi menggunakan bcryptjs
- JWT untuk autentikasi
- Rate limiting untuk mencegah abuse
- Helmet untuk security headers
- CORS dikonfigurasi dengan aman

## Deployment

### Production Build
```bash
npm run build
```

### Environment Variables
Untuk production, set environment variables:
- `NODE_ENV=production`
- `JWT_SECRET=your-secure-secret-key`
- `PORT=5000` (atau port yang diinginkan)

## Kontribusi

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

Untuk pertanyaan atau dukungan, silakan buat issue di repository ini.