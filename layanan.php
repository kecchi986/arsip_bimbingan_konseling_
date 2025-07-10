<?php
require 'config.php';
require 'functions.php';
require_login();

// Ambil layanan dan sublayanan
default:
$layanan = mysqli_query($conn, "SELECT * FROM layanan ORDER BY id");
$sub = [];
$subq = mysqli_query($conn, "SELECT * FROM sublayanan ORDER BY layanan_id");
while($row = mysqli_fetch_assoc($subq)) {
    $sub[$row['layanan_id']][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Layanan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Layanan</h2>
    <a href="layanan_add.php" class="btn">Tambah Layanan</a>
    <br><br>
    <?php while($l = mysqli_fetch_assoc($layanan)): ?>
        <div class="layanan-block">
            <b><?= esc($l['nama']) ?></b>
            <a href="layanan_edit.php?id=<?= $l['id'] ?>" class="btn-edit">Edit</a>
            <a href="layanan_delete.php?id=<?= $l['id'] ?>" class="btn-delete" onclick="return confirm('Hapus layanan ini?')">Delete</a>
            <a href="sublayanan_add.php?layanan_id=<?= $l['id'] ?>" class="btn">Tambah sub layanan</a>
            <ul>
                <?php if(isset($sub[$l['id']])): foreach($sub[$l['id']] as $s): ?>
                    <li>
                        <?= esc($s['nama']) ?>
                        <a href="sublayanan_edit.php?id=<?= $s['id'] ?>" class="btn-edit">Edit</a>
                        <a href="sublayanan_delete.php?id=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Hapus sub layanan ini?')">Delete</a>
                    </li>
                <?php endforeach; endif; ?>
            </ul>
        </div>
    <?php endwhile; ?>
    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html> 