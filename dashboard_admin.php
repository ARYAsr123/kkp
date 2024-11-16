<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dashboard_admin.css">
</head>

<body>
    <!-- Full-width header with only Logout button -->
    <div class="header">
        <h2>Dashboard Admin SDN Sukamanah 01</h2>
        <div class="nav-buttons">
            <button class="logout-btn" onclick="window.location.href='login.php'">Logout</button>

        </div>
    </div>

    <!-- Centered content with additional buttons below the welcome message -->
    <div class="container">
        <h3>Selamat Datang di Sistem PPDB Online</h3>
        <p>Halo, Selamat datang di sistem pendaftaran kami.</p>

        <div class="button-container">
            <a href="kelola_siswa.php"><button>Kelola Data Siswa</button></a>
            <a href="seleksi_siswa.php"><button>Seleksi Data Siswa</button></a>
            <a href="setting.php"><button>Setting Jadwal Kegiatan</button></a>
        </div>
    </div>
</body>

</html>