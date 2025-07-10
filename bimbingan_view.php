<?php
require 'config.php';
require 'functions.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT b.*, s.nama as nama_siswa FROM bimbingan b LEFT JOIN siswa s ON b.siswa_id = s.id WHERE b.id=$id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
if (!$data) redirect('dashboard.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bimbingan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>View Bimbingan Konseling</h2>
    <table>
        <tr><td>Tanggal</td><td><?= esc($data['tanggal']) ?></td></tr>
        <tr><td>Kegiatan</td><td><?= esc($data['kegiatan']) ?></td></tr>
        <tr><td>Tempat</td><td><?= esc($data['tempat']) ?></td></tr>
        <tr><td>Uraian</td><td><?= esc($data['uraian']) ?></td></tr>
        <tr><td>Keterangan</td><td><?= esc($data['keterangan']) ?></td></tr>
        <tr><td>Siswa</td><td><?= esc($data['nama_siswa']) ?></td></tr>
    </table>
    <br>
    <a href="dashboard.php" class="btn">Back</a>
    <a href="bimbingan_edit.php?id=<?= $data['id'] ?>" class="btn-edit">Edit</a>
    <a href="bimbingan_delete.php?id=<?= $data['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
</body>
</html> 