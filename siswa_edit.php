<?php
require 'config.php';
require 'functions.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM siswa WHERE id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) redirect('siswa.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tingkat = mysqli_real_escape_string($conn, $_POST['tingkat']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $ruangan = mysqli_real_escape_string($conn, $_POST['ruangan']);
    mysqli_query($conn, "UPDATE siswa SET nis='$nis', nama='$nama', tingkat='$tingkat', jurusan='$jurusan', ruangan='$ruangan' WHERE id=$id");
    redirect('siswa.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Edit Siswa</h2>
    <form method="post">
        <label>NIS</label><br>
        <input type="text" name="nis" value="<?= esc($data['nis']) ?>" required><br>
        <label>Nama</label><br>
        <input type="text" name="nama" value="<?= esc($data['nama']) ?>" required><br>
        <label>Tingkat</label><br>
        <input type="text" name="tingkat" value="<?= esc($data['tingkat']) ?>" required><br>
        <label>Jurusan</label><br>
        <input type="text" name="jurusan" value="<?= esc($data['jurusan']) ?>" required><br>
        <label>Ruangan</label><br>
        <input type="text" name="ruangan" value="<?= esc($data['ruangan']) ?>" required><br><br>
        <button type="submit">Update</button>
        <a href="siswa.php" class="btn">Batal</a>
    </form>
</body>
</html> 