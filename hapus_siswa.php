<?php
require 'config.php'; // Koneksi ke database

// Mengambil ID siswa yang akan dihapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status siswa menjadi 'terhapus'
    $stmt = $conn->prepare("UPDATE pendaftaran SET status = 'terhapus' WHERE id = ?");
    $stmt->execute([$id]);

    echo "Siswa berhasil dipindahkan ke tempat sampah.";
    header("Location: kelola_siswa.php"); // Redirect kembali ke halaman kelola_siswa
} else {
    echo "ID siswa tidak ditemukan.";
}
