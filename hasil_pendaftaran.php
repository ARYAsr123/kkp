<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Ambil NIK dari URL atau session
$nik = $_GET['nik'];  // Anda bisa mengubah cara mengambil nik jika menggunakan session

// Ambil data pendaftar dari database
require 'config.php';
$stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE nik = ?");
$stmt->execute([$nik]);
$user = $stmt->fetch();

// Jika tidak ada data ditemukan
if (!$user) {
    echo "Pendaftaran tidak ditemukan.";
    exit();
}

// Format tanggal pendaftaran
$tanggal_pendaftaran = date('d F Y', strtotime($user['tanggal_pendaftaran']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="hasil_pendaftaran.css">
</head>
</head>

<body>
    <div class="card">
        <h2>Hasil Pendaftaran</h2>
        <p>Selamat, Anda telah berhasil mendaftar sebagai pendaftar nomor ke-<?= $user['id']; ?>.</p>
        <p>Tanggal Pendaftaran: <?= $tanggal_pendaftaran; ?></p>
        <a href="dashboard_user.php">
            <button class="btn-finish">Selesai</button>
        </a>
    </div>
</body>

</html>