<?php
require 'config.php';
require 'functions.php';
require_login();

// Statistik
$totalSiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM siswa"))['jml'];
$totalRekaman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM bimbingan"))['jml'];
$totalLayanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM layanan"))['jml'];

// Info admin
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'admin@school.com';
$page = 'dashboard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Arsip Bimbingan Konseling</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            background: #f4f7fb;
            margin: 0;
            padding: 0;
        }
        .layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: #fff;
            border-right: 1px solid #e3eaf6;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0;
        }
        .sidebar-header {
            font-size: 1.25em;
            font-weight: bold;
            color: #1976d2;
            padding: 32px 0 24px 32px;
            letter-spacing: 0.5px;
        }
        .sidebar-menu {
            flex: 1;
        }
        .sidebar-menu ul {
            list-style: none;
            padding: 0 0 0 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin-bottom: 2px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 32px;
            color: #222;
            text-decoration: none;
            font-size: 1em;
            border-left: 4px solid transparent;
            transition: background 0.15s, border 0.15s;
        }
        .sidebar-menu a.active, .sidebar-menu a:hover {
            background: #e3eaf6;
            border-left: 4px solid #1976d2;
            color: #1976d2;
        }
        .sidebar-footer {
            padding: 24px 32px 32px 32px;
            border-top: 1px solid #e3eaf6;
        }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }
        .admin-avatar {
            width: 38px;
            height: 38px;
            background: #1976d2;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3em;
            font-weight: bold;
        }
        .admin-details {
            display: flex;
            flex-direction: column;
        }
        .admin-name {
            font-weight: bold;
            font-size: 1em;
        }
        .admin-email {
            font-size: 0.95em;
            color: #555;
        }
        .btn-logout {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 8px 0;
            border-radius: 6px;
            width: 100%;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 8px;
            transition: background 0.2s;
        }
        .btn-logout:hover {
            background: #b71c1c;
        }
        .main {
            flex: 1;
            padding: 0 0 0 0;
            min-width: 0;
        }
        .main-content {
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 32px 32px 32px;
        }
        .main-content h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 8px;
            color: #222;
        }
        .main-content .subtitle {
            color: #555;
            margin-bottom: 32px;
            font-size: 1.1em;
        }
        .stats-row {
            display: flex;
            gap: 24px;
            margin-bottom: 32px;
        }
        .stat-card {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 28px 24px 18px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
        }
        .stat-label {
            color: #888;
            font-size: 1em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stat-value {
            font-size: 2.1em;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 8px;
        }
        .stat-link {
            color: #1976d2;
            font-size: 1em;
            text-decoration: none;
            font-weight: 500;
            margin-top: 4px;
        }
        .stat-link:hover {
            text-decoration: underline;
        }
        .quick-actions {
            margin-top: 18px;
        }
        .quick-title {
            font-size: 1.15em;
            font-weight: bold;
            margin-bottom: 18px;
            color: #222;
        }
        .quick-row {
            display: flex;
            gap: 24px;
        }
        .quick-card {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 28px 24px 18px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
            transition: box-shadow 0.2s;
        }
        .quick-card:hover {
            box-shadow: 0 4px 18px rgba(25, 118, 210, 0.10);
        }
        .quick-icon {
            font-size: 2em;
            color: #1976d2;
            margin-bottom: 10px;
        }
        .quick-label {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 6px;
            color: #222;
        }
        .quick-desc {
            color: #555;
            font-size: 1em;
        }
        @media (max-width: 900px) {
            .main-content { padding: 32px 8px; }
            .stats-row, .quick-row { flex-direction: column; gap: 18px; }
        }
        @media (max-width: 700px) {
            .sidebar { width: 100px; }
            .sidebar-header, .sidebar-footer { padding-left: 10px; padding-right: 10px; }
            .sidebar-menu a { padding: 12px 10px; font-size: 0.95em; }
            .main-content { padding: 18px 2px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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
            <h1>Dashboard</h1>
            <div class="subtitle">Selamat datang di sistem arsip bimbingan konseling</div>
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label"><i class="fa fa-users"></i> Total Siswa</div>
                    <div class="stat-value"><?= $totalSiswa ?></div>
                    <a href="siswa.php" class="stat-link">Lihat semua siswa</a>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><i class="fa fa-file-alt"></i> Total Rekaman</div>
                    <div class="stat-value"><?= $totalRekaman ?></div>
                    <a href="bimbingan_list.php" class="stat-link">Lihat semua rekaman</a>
                </div>
                <div class="stat-card">
                    <div class="stat-label"><i class="fa fa-book"></i> Total Layanan</div>
                    <div class="stat-value"><?= $totalLayanan ?></div>
                    <a href="layanan.php" class="stat-link">Lihat semua layanan</a>
                </div>
            </div>
            <div class="quick-actions">
                <div class="quick-title">Aksi Cepat</div>
                <div class="quick-row">
                    <div class="quick-card" onclick="window.location='bimbingan_add.php'" style="cursor:pointer;">
                        <div class="quick-icon"><i class="fa fa-plus"></i></div>
                        <div class="quick-label">Tambah Rekaman</div>
                        <div class="quick-desc">Buat rekaman kegiatan konseling baru</div>
                    </div>
                    <div class="quick-card" onclick="window.location='siswa.php'" style="cursor:pointer;">
                        <div class="quick-icon"><i class="fa fa-users"></i></div>
                        <div class="quick-label">Kelola Siswa</div>
                        <div class="quick-desc">Tambah atau edit data siswa</div>
                    </div>
                    <div class="quick-card" onclick="window.location='layanan.php'" style="cursor:pointer;">
                        <div class="quick-icon"><i class="fa fa-book"></i></div>
                        <div class="quick-label">Kelola Layanan</div>
                        <div class="quick-desc">Tambah atau edit layanan konseling</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 