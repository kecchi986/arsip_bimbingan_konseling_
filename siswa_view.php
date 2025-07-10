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
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 40px 40px 40px;
        }
        .form-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 24px;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
        }
        .form-table td {
            padding: 8px 6px;
            vertical-align: top;
        }
        .form-table label {
            font-weight: normal;
            color: #333;
        }
        .form-actions {
            text-align: right;
            padding-top: 18px;
        }
        .btn-back {
            background: #888;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            margin-right: 8px;
            text-decoration: none;
        }
        .btn-edit {
            background: #ff9800;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            margin-right: 8px;
            text-decoration: none;
        }
        .btn-delete {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            margin-right: 8px;
            text-decoration: none;
        }
        @media (max-width: 700px) {
            .form-container { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-title">View Siswa</div>
        <table class="form-table">
            <tr><td style="width:180px;"><label>NIS</label></td><td><?= esc($data['nis']) ?></td></tr>
            <tr><td><label>Nama</label></td><td><?= esc($data['nama']) ?></td></tr>
            <tr><td><label>Tingkat</label></td><td><?= esc($data['tingkat']) ?></td></tr>
            <tr><td><label>Jurusan</label></td><td><?= esc($data['jurusan']) ?></td></tr>
            <tr><td><label>Ruangan</label></td><td><?= esc($data['ruangan']) ?></td></tr>
        </table>
        <div class="form-actions">
            <a href="siswa.php" class="btn-back">Back</a>
            <a href="siswa_delete.php?id=<?= $data['id'] ?>" class="btn-delete" onclick="return confirm('Hapus data ini?')">Delete</a>
            <a href="siswa_edit.php?id=<?= $data['id'] ?>" class="btn-edit">Edit</a>
        </div>
    </div>
</body>
</html> 