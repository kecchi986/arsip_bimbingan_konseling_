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
</head>
<body>
    <h2>Tambah Bimbingan</h2>
    <form method="post">
        <label>Tanggal</label><br>
        <input type="date" name="tanggal" required><br>
        <label>Kegiatan</label><br>
        <input type="text" name="kegiatan" required><br>
        <label>Tempat</label><br>
        <input type="text" name="tempat" required><br>
        <label>Uraian Kegiatan</label><br>
        <input type="text" name="uraian" required><br>
        <label>Keterangan</label><br>
        <input type="text" name="keterangan"><br>
        <label>Siswa yang bersangkutan</label><br>
        <select name="siswa_id" required>
            <option value="">- Pilih Siswa -</option>
            <?php while($row = mysqli_fetch_assoc($siswa)): ?>
                <option value="<?= $row['id'] ?>"><?= esc($row['nama']) ?></option>
            <?php endwhile; ?>
        </select><br><br>
        <button type="submit">Simpan</button>
        <a href="dashboard.php" class="btn">Batal</a>
    </form>
</body>
</html> 