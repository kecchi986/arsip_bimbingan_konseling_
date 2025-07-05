# Panduan Instalasi Aplikasi Arsip Bimbingan Konseling

## Langkah 1: Install Node.js

1. Kunjungi website resmi Node.js: https://nodejs.org/
2. Download versi LTS (Long Term Support)
3. Install Node.js dengan mengikuti wizard instalasi
4. Restart komputer atau terminal/command prompt

## Langkah 2: Verifikasi Instalasi

Buka terminal/command prompt dan ketik:
```bash
node --version
npm --version
```

Jika muncul versi, berarti instalasi berhasil.

## Langkah 3: Install Dependencies

### Cara Otomatis (Direkomendasikan)
1. Double click file `install.bat`
2. Tunggu hingga proses instalasi selesai
3. Jika ada error, pastikan Node.js sudah terinstall dengan benar

### Cara Manual
1. Buka terminal/command prompt di folder project
2. Jalankan perintah berikut secara berurutan:

```bash
# Install dependencies root
npm install

# Install dependencies server
cd server
npm install
cd ..

# Install dependencies client
cd client
npm install
cd ..
```

## Langkah 4: Menjalankan Aplikasi

### Cara Otomatis
1. Double click file `start.bat`
2. Aplikasi akan berjalan otomatis

### Cara Manual
1. Buka terminal/command prompt di folder project
2. Jalankan perintah:
```bash
npm run dev
```

## Langkah 5: Akses Aplikasi

1. Buka browser web
2. Kunjungi: http://localhost:3000
3. Login dengan kredensial default:
   - **Email:** admin@school.com
   - **Password:** admin123

## Troubleshooting

### Error "node tidak dikenali"
- Pastikan Node.js sudah terinstall dengan benar
- Restart terminal/command prompt
- Restart komputer jika perlu

### Error saat npm install
- Pastikan koneksi internet stabil
- Coba hapus folder node_modules dan package-lock.json
- Jalankan npm install lagi

### Port sudah digunakan
- Tutup aplikasi lain yang menggunakan port 3000 atau 5000
- Atau ubah port di file konfigurasi

### Database error
- Pastikan folder server memiliki permission write
- Database akan dibuat otomatis saat pertama kali menjalankan aplikasi

## Fitur Aplikasi

✅ **Login & Logout**
- Autentikasi dengan JWT
- Ganti password

✅ **Manajemen Siswa**
- Tambah, edit, hapus data siswa
- Pencarian siswa
- Lihat detail siswa

✅ **Manajemen Layanan**
- Tambah, edit, hapus layanan
- Sub layanan
- Hierarki layanan

✅ **Rekaman Konseling**
- Tambah, edit, hapus rekaman
- Pencarian rekaman
- Cetak rekaman
- Detail lengkap

✅ **Dashboard**
- Statistik ringkasan
- Rekaman terbaru
- Navigasi cepat

## Struktur Folder

```
arsip_bimbingan_konseling_/
├── client/                 # Frontend React
│   ├── src/
│   │   ├── components/     # Komponen UI
│   │   ├── contexts/       # Context API
│   │   ├── pages/          # Halaman aplikasi
│   │   └── ...
│   └── ...
├── server/                 # Backend Node.js
│   ├── index.js           # Server utama
│   └── ...
├── install.bat            # Script instalasi otomatis
├── start.bat              # Script menjalankan aplikasi
└── README.md              # Dokumentasi lengkap
```

## Dukungan

Jika mengalami masalah, silakan:
1. Periksa error message dengan teliti
2. Pastikan semua langkah instalasi sudah benar
3. Cek versi Node.js (minimal v16)
4. Buat issue di repository jika masalah berlanjut 