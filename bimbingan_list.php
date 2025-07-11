<?php
require 'config.php';
require 'functions.php';
require_login();

// Query data bimbingan + siswa
$sql = "SELECT b.*, s.nama as nama_siswa FROM bimbingan b LEFT JOIN siswa s ON b.siswa_id = s.id ORDER BY b.tanggal DESC";
$result = mysqli_query($conn, $sql);
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'admin@school.com';
$page = 'bimbingan';
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekaman Konseling - Arsip Bimbingan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body { background: #f4f7fb; margin: 0; padding: 0; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #fff; border-right: 1px solid #e3eaf6; display: flex; flex-direction: column; justify-content: space-between; padding: 0; }
        .sidebar-header { font-size: 1.25em; font-weight: bold; color: #1976d2; padding: 32px 0 24px 32px; letter-spacing: 0.5px; }
        .sidebar-menu { flex: 1; }
        .sidebar-menu ul { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { margin-bottom: 2px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 32px; color: #222; text-decoration: none; font-size: 1em; border-left: 4px solid transparent; transition: background 0.15s, border 0.15s; }
        .sidebar-menu a.active, .sidebar-menu a:hover { background: #e3eaf6; border-left: 4px solid #1976d2; color: #1976d2; }
        .sidebar-footer { padding: 24px 32px 32px 32px; border-top: 1px solid #e3eaf6; }
        .admin-info { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .admin-avatar { width: 38px; height: 38px; background: #1976d2; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3em; font-weight: bold; }
        .admin-details { display: flex; flex-direction: column; }
        .admin-name { font-weight: bold; font-size: 1em; }
        .admin-email { font-size: 0.95em; color: #555; }
        .btn-logout { background: #e53935; color: #fff; border: none; padding: 8px 0; border-radius: 6px; width: 100%; font-size: 1em; font-weight: 500; cursor: pointer; text-align: center; text-decoration: none; display: block; margin-top: 8px; transition: background 0.2s; }
        .btn-logout:hover { background: #b71c1c; }
        .main { flex: 1; padding: 0 0 0 0; min-width: 0; }
        .main-content { max-width: 1100px; margin: 0 auto; padding: 48px 32px 32px 32px; }
        .main-content h1 { font-size: 2em; font-weight: bold; margin-bottom: 8px; color: #222; }
        .table-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .btn-add { background: #1976d2; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 1em; font-weight: 500; transition: background 0.2s; }
        .btn-add:hover { background: #1251a3; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 13px 14px; text-align: left; }
        th { background: #e3eaf6; color: #1976d2; font-weight: bold; border-bottom: 2px solid #d0d7e6; }
        tr { transition: background 0.15s; }
        tr:hover { background: #f0f6ff; }
        tr:nth-child(even) { background: #f8fafc; }
        .btn-view { background: #1976d2; color: #fff; border: none; padding: 6px 16px; border-radius: 6px; font-size: 0.97em; margin-right: 2px; text-decoration: none; transition: background 0.2s; }
        .btn-view:hover { background: #1251a3; }
        .btn-edit { background: #ff9800; color: #fff; border: none; padding: 6px 16px; border-radius: 6px; font-size: 0.97em; margin-right: 2px; text-decoration: none; transition: background 0.2s; }
        .btn-edit:hover { background: #c66900; }
        .btn-delete { background: #e53935; color: #fff; border: none; padding: 6px 16px; border-radius: 6px; font-size: 0.97em; text-decoration: none; transition: background 0.2s; }
        .btn-delete:hover { background: #b71c1c; }
        @media (max-width: 900px) { .main-content { padding: 32px 8px; } }
        @media (max-width: 700px) { .sidebar { width: 100px; } .sidebar-header, .sidebar-footer { padding-left: 10px; padding-right: 10px; } .sidebar-menu a { padding: 12px 10px; font-size: 0.95em; } .main-content { padding: 18px 2px; } }
    </style>
</head>
<body>
<div class="layout">
    <div class="sidebar">
        <div>
            <div class="sidebar-header">Arsip Bimbingan Konseling</div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.php" class="<?= $page=='dashboard'?'active':'' ?>"><i class="fa fa-home" style="width:22px;"></i> Dashboard</a></li>
                    <li><a href="bimbingan_list.php" class="<?= $page=='bimbingan'?'active':'' ?>"><i class="fa fa-file-alt" style="width:22px;"></i> Rekaman Konseling</a></li>
                    <li><a href="siswa.php" class="<?= $page=='siswa'?'active':'' ?>"><i class="fa fa-users" style="width:22px;"></i> Data Siswa</a></li>
                    <li><a href="layanan.php" class="<?= $page=='layanan'?'active':'' ?>"><i class="fa fa-book" style="width:22px;"></i> Layanan</a></li>
                    <li><a href="ganti_password.php" class="<?= $page=='password'?'active':'' ?>"><i class="fa fa-key" style="width:22px;"></i> Ganti Password</a></li>
                </ul>
            </nav>
        </div>
        <div class="sidebar-footer">
            <div class="admin-info">
                <div class="admin-avatar">A</div>
                <div class="admin-details">
                    <div class="admin-name">Administrator</div>
                    <div class="admin-email"><?= esc($email) ?></div>
                </div>
            </div>
            <a href="logout.php" class="btn-logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <div class="main">
        <div class="main-content">
            <div class="bimbingan-header" style="display:flex;justify-content:space-between;align-items:center;">
                <h1>Rekaman Konseling</h1>
                <?php if($is_admin): ?>
                <a href="bimbingan_add.php" class="btn-add"><i class="fa fa-plus"></i> Tambah Rekaman</a>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kegiatan</th>
                            <th>Tempat</th>
                            <th>Uraian</th>
                            <th>Keterangan</th>
                            <?php if($is_admin): ?><th>Aksi</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($row['tanggal']) ?></td>
                            <td><?= esc($row['nama_siswa']) ?></td>
                            <td><?= esc($row['kegiatan']) ?></td>
                            <td><?= esc($row['tempat']) ?></td>
                            <td><?= esc($row['uraian']) ?></td>
                            <td><?= esc($row['keterangan']) ?></td>
                            <?php if($is_admin): ?>
                            <td>
                                <a href="bimbingan_view.php?id=<?= $row['id'] ?>" class="btn-view">View</a>
                                <a href="bimbingan_edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                                <a href="bimbingan_delete.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus rekaman ini?')">Delete</a>
                            </td>
                            <?php else: ?>
                            <td><a href="bimbingan_view.php?id=<?= $row['id'] ?>" class="btn-view">View</a></td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html> 