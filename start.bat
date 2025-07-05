@echo off
echo ========================================
echo   Aplikasi Arsip Bimbingan Konseling
echo ========================================
echo.
echo Memeriksa Node.js...

node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Node.js tidak ditemukan!
    echo Silakan install Node.js terlebih dahulu.
    pause
    exit /b 1
)

echo Node.js ditemukan!
echo.
echo Memulai aplikasi...
echo.
echo Backend akan berjalan di: http://localhost:5000
echo Frontend akan berjalan di: http://localhost:3000
echo.
echo Tekan Ctrl+C untuk menghentikan aplikasi
echo.

call npm run dev 