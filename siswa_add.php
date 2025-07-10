<?php
require 'config.php';
require 'functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tingkat = mysqli_real_escape_string($conn, $_POST['tingkat']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $ruangan = mysqli_real_escape_string($conn, $_POST['ruangan']);
    mysqli_query($conn, "INSERT INTO siswa (nis, nama, tingkat, jurusan, ruangan) VALUES ('$nis', '$nama', '$tingkat', '$jurusan', '$ruangan')");
    redirect('siswa.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Tambah Siswa</h2>
    <form method="post">
        <label>NIS</label><br>
        <input type="text" name="nis" required><br>
        <label>Nama</label><br>
        <input type="text" name="nama" required><br>
        <label>Tingkat</label><br>
        <input type="text" name="tingkat" required><br>
        <label>Jurusan</label><br>
        <input type="text" name="jurusan" required><br>
        <label>Ruangan</label><br>
        <input type="text" name="ruangan" required><br><br>
        <button type="submit">Simpan</button>
        <a href="siswa.php" class="btn">Batal</a>
    </form>
</body>
</html> 