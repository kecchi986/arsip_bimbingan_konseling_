<?php
require 'config.php';
require 'functions.php';
require_login();

// Query data bimbingan + siswa
$sql = "SELECT b.*, s.nama as nama_siswa FROM bimbingan b LEFT JOIN siswa s ON b.siswa_id = s.id ORDER BY b.tanggal DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Rekaman Bimbingan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Bimbingan</h2>
    <a href="bimbingan_add.php" class="btn">Tambah Bimbingan</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kegiatan</th>
            <th>Tempat</th>
            <th>Uraian</th>
            <th>Keterangan</th>
            <th>Siswa yang bersangkutan</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= esc($row['tanggal']) ?></td>
            <td><?= esc($row['kegiatan']) ?></td>
            <td><?= esc($row['tempat']) ?></td>
            <td><?= esc($row['uraian']) ?></td>
            <td><?= esc($row['keterangan']) ?></td>
            <td><?= esc($row['nama_siswa']) ?></td>
            <td>
                <a href="bimbingan_view.php?id=<?= $row['id'] ?>" class="btn-view">View</a>
                <a href="bimbingan_edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                <a href="bimbingan_delete.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="layanan.php">Layanan</a> | <a href="siswa.php">Siswa</a> | <a href="logout.php">Logout</a>
</body>
</html> 