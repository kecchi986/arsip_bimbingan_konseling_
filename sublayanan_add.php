<?php
require 'config.php';
require 'functions.php';
require_login();

$layanan_id = (int)($_GET['layanan_id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "INSERT INTO sublayanan (layanan_id, nama) VALUES ($layanan_id, '$nama')");
    redirect('layanan.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Sub Layanan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Tambah Sub Layanan</h2>
    <form method="post">
        <label>Nama Sub Layanan</label><br>
        <input type="text" name="nama" required><br><br>
        <button type="submit">Simpan</button>
        <a href="layanan.php" class="btn">Batal</a>
    </form>
</body>
</html> 