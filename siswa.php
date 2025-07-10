<?php
require 'config.php';
require 'functions.php';
require_login();

$siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Daftar Siswa</h2>
    <a href="siswa_add.php" class="btn">Tambah Siswa</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tingkat</th>
            <th>Jurusan</th>
            <th>Ruangan</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($siswa)): ?>
        <tr>
            <td><?= esc($row['nis']) ?></td>
            <td><?= esc($row['nama']) ?></td>
            <td><?= esc($row['tingkat']) ?></td>
            <td><?= esc($row['jurusan']) ?></td>
            <td><?= esc($row['ruangan']) ?></td>
            <td>
                <a href="siswa_view.php?id=<?= $row['id'] ?>" class="btn-view">View</a>
                <a href="siswa_edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                <a href="siswa_delete.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html> 