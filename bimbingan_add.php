<?php
require 'config.php';
require 'functions.php';
require_login();

// Ambil data siswa untuk dropdown
$siswa = mysqli_query($conn, "SELECT id, nama FROM siswa ORDER BY nama");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
    $tempat = mysqli_real_escape_string($conn, $_POST['tempat']);
    $uraian = mysqli_real_escape_string($conn, $_POST['uraian']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $siswa_id = (int)$_POST['siswa_id'];
    $sql = "INSERT INTO bimbingan (tanggal, kegiatan, tempat, uraian, keterangan, siswa_id) VALUES ('$tanggal', '$kegiatan', '$tempat', '$uraian', '$keterangan', $siswa_id)";
    mysqli_query($conn, $sql);
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Bimbingan</title>
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
        <div class="form-title">Tambah Bimbingan</div>
        <form method="post">
            <table class="form-table">
                <tr>
                    <td style="width:180px;"><label>Tanggal</label></td>
                    <td><input type="date" name="tanggal" required></td>
                </tr>
                <tr>
                    <td><label>Kegiatan</label></td>
                    <td><input type="text" name="kegiatan" required></td>
                </tr>
                <tr>
                    <td><label>Tempat</label></td>
                    <td><input type="text" name="tempat" required></td>
                </tr>
                <tr>
                    <td><label>Uraian Kegiatan</label></td>
                    <td><input type="text" name="uraian" required></td>
                </tr>
                <tr>
                    <td><label>Keterangan</label></td>
                    <td><input type="text" name="keterangan"></td>
                </tr>
                <tr>
                    <td><label>Siswa yang bersangkutan</label></td>
                    <td>
                        <select name="siswa_id" required>
                            <option value="">- Pilih Siswa -</option>
                            <?php while($row = mysqli_fetch_assoc($siswa)): ?>
                                <option value="<?= $row['id'] ?>"><?= esc($row['nama']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="form-actions">
                <a href="dashboard.php" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html> 