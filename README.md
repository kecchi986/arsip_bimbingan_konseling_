# Arsip Bimbingan Konseling

Aplikasi web sederhana untuk mengelola arsip bimbingan konseling siswa. Dibangun menggunakan PHP dan MySQL.

## Fitur
- **Manajemen Data Siswa:** Tambah, edit, lihat, dan hapus data siswa (khusus admin).
- **Manajemen Layanan & Sublayanan:** Kelola jenis layanan dan sublayanan bimbingan konseling (khusus admin).
- **Pencatatan Bimbingan Konseling:** Catat, edit, lihat, dan hapus riwayat bimbingan siswa (khusus admin).
- **Autentikasi Pengguna:** Registrasi, login, dan ganti password.
- **Dashboard:** Ringkasan data dan statistik bimbingan.

## Hak Akses Pengguna
Aplikasi ini memiliki dua jenis role user:

- **Admin**
  - Dapat menambah, mengedit, dan menghapus data siswa, layanan, sublayanan, dan bimbingan.
  - Dapat melihat seluruh data.
- **User (hasil register)**
  - Hanya dapat melihat (view) data siswa, layanan, sublayanan, dan bimbingan.
  - Tidak dapat menambah, mengedit, atau menghapus data apapun.

Role user diatur otomatis saat registrasi (default: user). Admin hanya bisa dibuat langsung di database atau oleh admin lain.

## Instalasi
1. **Clone repository** ke folder web server Anda (misal: `htdocs` pada XAMPP).
   ```bash
   git clone https://github.com/username/arsip_bimbingan_konseling_.git
   ```
2. **Import database**
   - Buka phpMyAdmin.
   - Buat database baru, misal: `arsip_bk`.
   - Import file `db.sql` ke database tersebut.
3. **Konfigurasi database**
   - Edit file `config.php` dan sesuaikan:
     ```php
     $db_host = 'localhost';
     $db_user = 'root';
     $db_pass = '';
     $db_name = 'arsip_bk';
     ```
4. **Jalankan aplikasi**
   - Buka browser dan akses: `http://localhost/arsip_bimbingan_konseling_`

## Penggunaan
- **Login:** Gunakan akun yang sudah terdaftar atau lakukan registrasi.
- **Manajemen Data:** Gunakan menu navigasi untuk mengelola siswa, layanan, sublayanan, dan bimbingan (khusus admin).
- **Ganti Password:** Tersedia di menu profil.

### Contoh Akun Awal
Jika belum ada user, silakan registrasi terlebih dahulu. Jika sudah ada, gunakan kredensial berikut (jika tersedia di `db.sql`):
- Username: `admin@admin.com`
- Password: `admin123` *(atau sesuai yang diatur di database)*

## Struktur Folder & Penjelasan File
- `assets/style.css` : File CSS utama untuk styling.
- `config.php` : Konfigurasi koneksi database.
- `db.sql` : Struktur dan data awal database.
- `functions.php` : Fungsi-fungsi PHP yang digunakan bersama.
- `dashboard.php` : Halaman utama setelah login.
- `register.php`, `ganti_password.php`, `logout.php` : Fitur autentikasi.
- `siswa.php`, `siswa_add.php`, `siswa_edit.php`, `siswa_view.php` : Manajemen data siswa.
- `layanan.php`, `layanan_add.php`, `layanan_edit.php` : Manajemen layanan.
- `sublayanan_add.php`, `sublayanan_edit.php` : Manajemen sublayanan.
- `bimbingan_list.php`, `bimbingan_add.php`, `bimbingan_edit.php`, `bimbingan_view.php` : Manajemen bimbingan konseling.
- `index.php` : Halaman login.
- `generate_hash.php` : Untuk generate hash password (opsional).

## Kontribusi
Pull request dan saran sangat terbuka untuk pengembangan lebih lanjut.

## Lisensi
Aplikasi ini bersifat open source dan dapat digunakan sesuai kebutuhan.

## Kontak
Untuk pertanyaan atau saran, silakan hubungi pengembang melalui email: [your.email@example.com](mailto:your.email@example.com) 