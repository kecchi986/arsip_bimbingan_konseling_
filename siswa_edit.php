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
        .btn-update {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            margin-left: 8px;
        }
        .btn-batal {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
        }
        input[type="text"] {
            width: 100%;
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        @media (max-width: 700px) {
            .form-container { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-title">Edit Siswa</div>
        <form method="post">
            <table class="form-table">
                <tr>
                    <td style="width:180px;"><label>NIS</label></td>
                    <td><input type="text" name="nis" value="<?= esc($data['nis']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Nama</label></td>
                    <td><input type="text" name="nama" value="<?= esc($data['nama']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Tingkat</label></td>
                    <td><input type="text" name="tingkat" value="<?= esc($data['tingkat']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Jurusan</label></td>
                    <td><input type="text" name="jurusan" value="<?= esc($data['jurusan']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Ruangan</label></td>
                    <td><input type="text" name="ruangan" value="<?= esc($data['ruangan']) ?>" required></td>
                </tr>
            </table>
            <div class="form-actions">
                <a href="siswa.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</body>
</html> 