<?php
require 'config.php';
require 'functions.php';
require_login();

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
</head>
<body>
    <h2>Edit Bimbingan Konseling</h2>
    <form method="post">
        <label>Tanggal</label><br>
        <input type="date" name="tanggal" value="<?= esc($data['tanggal']) ?>" required><br>
        <label>Kegiatan</label><br>
        <input type="text" name="kegiatan" value="<?= esc($data['kegiatan']) ?>" required><br>
        <label>Tempat</label><br>
        <input type="text" name="tempat" value="<?= esc($data['tempat']) ?>" required><br>
        <label>Uraian Kegiatan</label><br>
        <input type="text" name="uraian" value="<?= esc($data['uraian']) ?>" required><br>
        <label>Keterangan</label><br>
        <input type="text" name="keterangan" value="<?= esc($data['keterangan']) ?>"><br>
        <label>Siswa yang bersangkutan</label><br>
        <select name="siswa_id" required>
            <option value="">- Pilih Siswa -</option>
            <?php while($row = mysqli_fetch_assoc($siswa)): ?>
                <option value="<?= $row['id'] ?>" <?= $row['id']==$data['siswa_id']?'selected':'' ?>><?= esc($row['nama']) ?></option>
            <?php endwhile; ?>
        </select><br><br>
        <button type="submit">Update</button>
        <a href="dashboard.php" class="btn">Batal</a>
    </form>
</body>
</html> 