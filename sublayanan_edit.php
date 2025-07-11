<?php
require 'config.php';
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('layanan.php');
}

$id = (int)($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM sublayanan WHERE id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) redirect('layanan.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "UPDATE sublayanan SET nama='$nama' WHERE id=$id");
    redirect('layanan.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Sub Layanan</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .form-container {
            max-width: 500px;
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
        .btn-simpan {
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
        <div class="form-title">Edit Sub Layanan</div>
        <form method="post">
            <table class="form-table">
                <tr>
                    <td style="width:180px;"><label>Nama Sub Layanan</label></td>
                    <td><input type="text" name="nama" value="<?= esc($data['nama']) ?>" required></td>
                </tr>
            </table>
            <div class="form-actions">
                <a href="layanan.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html> 