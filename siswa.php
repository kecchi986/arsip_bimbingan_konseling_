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
    <style>
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 40px 40px 40px;
        }
        .siswa-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .siswa-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #2c3e50;
        }
        .btn-add {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #fafbfc;
        }
        .btn-view {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
            margin-right: 2px;
            text-decoration: none;
        }
        .btn-edit {
            background: #ff9800;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
            margin-right: 2px;
            text-decoration: none;
        }
        .btn-delete {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.95em;
            text-decoration: none;
        }
        .btn-back {
            background: #888;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            text-decoration: none;
            margin-top: 18px;
            display: inline-block;
        }
        @media (max-width: 700px) {
            .container { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="siswa-header">
            <div class="siswa-title">Daftar Siswa</div>
            <a href="siswa_add.php" class="btn-add">Tambah Siswa</a>
        </div>
        <div class="table-responsive">
        <table>
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
        </div>
        <a href="dashboard.php" class="btn-back">Back</a>
    </div>
</body>
</html> 