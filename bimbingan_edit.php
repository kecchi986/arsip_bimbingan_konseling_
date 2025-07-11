<?php
require 'config.php';
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('bimbingan_list.php');
}

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT * FROM bimbingan WHERE id=$id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
if (!$data) redirect('dashboard.php');

$siswa = mysqli_query($conn, "SELECT id, nama FROM siswa ORDER BY nama");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
    $tempat = mysqli_real_escape_string($conn, $_POST['tempat']);
    $uraian = mysqli_real_escape_string($conn, $_POST['uraian']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $siswa_id = (int)$_POST['siswa_id'];
    $sql = "UPDATE bimbingan SET tanggal='$tanggal', kegiatan='$kegiatan', tempat='$tempat', uraian='$uraian', keterangan='$keterangan', siswa_id=$siswa_id WHERE id=$id";
    mysqli_query($conn, $sql);
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Bimbingan</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .form-container {
            max-width: 700px;
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
        select, input[type="text"], input[type="date"] {
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
        <div class="form-title">Edit Bimbingan</div>
        <form method="post">
            <table class="form-table">
                <tr>
                    <td style="width:180px;"><label>Tanggal</label></td>
                    <td><input type="date" name="tanggal" value="<?= esc($data['tanggal']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Kegiatan</label></td>
                    <td><input type="text" name="kegiatan" value="<?= esc($data['kegiatan']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Tempat</label></td>
                    <td><input type="text" name="tempat" value="<?= esc($data['tempat']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Uraian Kegiatan</label></td>
                    <td><input type="text" name="uraian" value="<?= esc($data['uraian']) ?>" required></td>
                </tr>
                <tr>
                    <td><label>Keterangan</label></td>
                    <td><input type="text" name="keterangan" value="<?= esc($data['keterangan']) ?>"></td>
                </tr>
                <tr>
                    <td><label>Siswa yang bersangkutan</label></td>
                    <td>
                        <select name="siswa_id" required>
                            <option value="">- Pilih Siswa -</option>
                            <?php while($row = mysqli_fetch_assoc($siswa)): ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id']==$data['siswa_id']?'selected':'' ?>><?= esc($row['nama']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="form-actions">
                <a href="dashboard.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</body>
</html> 