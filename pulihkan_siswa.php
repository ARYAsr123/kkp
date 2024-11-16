<?php
require 'config.php'; // Koneksi ke database

// Mengambil ID siswa yang akan dipulihkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status siswa menjadi 'aktif'
    $stmt = $conn->prepare("UPDATE pendaftaran SET status = 'aktif' WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect kembali ke halaman kelola_siswa.php
    header("Location: kelola_siswa.php");
    exit();
} else {
    echo "ID siswa tidak ditemukan.";
}
