@echo off
echo ========================================
echo   Aplikasi Arsip Bimbingan Konseling
echo ========================================
echo.
echo Memeriksa Node.js...

node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Node.js tidak ditemukan!
    echo.
    echo Silakan install Node.js terlebih dahulu:
    echo 1. Kunjungi https://nodejs.org/
    echo 2. Download dan install Node.js LTS
    echo 3. Restart terminal/command prompt
    echo 4. Jalankan script ini lagi
    echo.
    pause
    exit /b 1
)

echo Node.js ditemukan!
echo.

echo Installing dependencies...
echo.

echo Installing root dependencies...
call npm install

echo.
echo Installing server dependencies...
cd server
call npm install
cd ..

echo.
echo Installing client dependencies...
cd client
call npm install
cd ..

echo.
echo ========================================
echo Instalasi selesai!
echo.
echo Untuk menjalankan aplikasi:
echo 1. npm run dev
echo.
echo Atau jalankan secara terpisah:
echo - Backend: npm run server
echo - Frontend: npm run client
echo ========================================
echo.
pause 