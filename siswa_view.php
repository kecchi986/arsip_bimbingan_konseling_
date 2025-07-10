<?php
require 'config.php';
require 'functions.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM siswa WHERE id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) redirect('siswa.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Siswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>View Siswa</h2>
    <table>
        <tr><td>NIS</td><td><?= esc($data['nis']) ?></td></tr>
        <tr><td>Nama</td><td><?= esc($data['nama']) ?></td></tr>
        <tr><td>Tingkat</td><td><?= esc($data['tingkat']) ?></td></tr>
        <tr><td>Jurusan</td><td><?= esc($data['jurusan']) ?></td></tr>
        <tr><td>Ruangan</td><td><?= esc($data['ruangan']) ?></td></tr>
    </table>
    <br>
    <a href="siswa.php" class="btn">Back</a>
    <a href="siswa_edit.php?id=<?= $data['id'] ?>" class="btn-edit">Edit</a>
    <a href="siswa_delete.php?id=<?= $data['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
</body>
</html> 