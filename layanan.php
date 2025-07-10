<?php
require 'config.php';
require 'functions.php';
require_login();

// Ambil layanan dan sublayanan
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
    <style>
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 40px 40px 40px;
        }
        .layanan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .layanan-title {
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
        .layanan-block {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 6px;
            margin-bottom: 18px;
            padding: 18px 20px 12px 20px;
        }
        .layanan-block-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .layanan-block-title {
            font-weight: bold;
            font-size: 1.1em;
            color: #333;
        }
        .layanan-block-actions {
            display: flex;
            gap: 6px;
        }
        .btn-edit {
            background: #ff9800;
            color: #fff;
            border: none;
            padding: 4px 14px;
            border-radius: 3px;
            font-size: 0.95em;
            text-decoration: none;
        }
        .btn-delete {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 4px 14px;
            border-radius: 3px;
            font-size: 0.95em;
            text-decoration: none;
        }
        .btn-sub {
            background: #1976d2;
            color: #fff;
            border: none;
            padding: 4px 14px;
            border-radius: 3px;
            font-size: 0.95em;
            text-decoration: none;
        }
        .sub-list {
            list-style: none;
            padding-left: 0;
            margin: 0 0 0 10px;
        }
        .sub-list li {
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sub-actions {
            display: inline-flex;
            gap: 4px;
            margin-left: 8px;
        }
        .btn-back {
            background: #888;
            color: #fff;
            border: none;
            padding: 7px 22px;
            border-radius: 4px;
            font-size: 1em;
            text-decoration: none;
        }
        @media (max-width: 700px) {
            .container { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="layanan-header">
            <div class="layanan-title">Layanan</div>
            <a href="layanan_add.php" class="btn-add">Tambah Layanan</a>
        </div>
        <?php while($l = mysqli_fetch_assoc($layanan)): ?>
            <div class="layanan-block">
                <div class="layanan-block-header">
                    <span class="layanan-block-title"><?= esc($l['nama']) ?></span>
                    <span class="layanan-block-actions">
                        <a href="layanan_edit.php?id=<?= $l['id'] ?>" class="btn-edit">Edit</a>
                        <a href="layanan_delete.php?id=<?= $l['id'] ?>" class="btn-delete" onclick="return confirm('Hapus layanan ini?')">Delete</a>
                        <a href="sublayanan_add.php?layanan_id=<?= $l['id'] ?>" class="btn-sub">Tambah Sub Layanan</a>
                    </span>
                </div>
                <ul class="sub-list">
                    <?php if(isset($sub[$l['id']])): foreach($sub[$l['id']] as $s): ?>
                        <li>
                            <?= esc($s['nama']) ?>
                            <span class="sub-actions">
                                <a href="sublayanan_edit.php?id=<?= $s['id'] ?>" class="btn-edit">Edit</a>
                                <a href="sublayanan_delete.php?id=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Hapus sub layanan ini?')">Delete</a>
                            </span>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        <?php endwhile; ?>
        <a href="dashboard.php" class="btn-back">Back</a>
    </div>
</body>
</html> 