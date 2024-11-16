<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require 'config.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nama_panggilan = $_POST['nama_panggilan'];
    $nik = $_POST['nik'];
    $ttl = $_POST['tempat_tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $alamat = $_POST['alamat'];

    // Insert data ke tabel pendaftaran
    $stmt = $conn->prepare("INSERT INTO pendaftaran (nama, nama_panggilan, nik, tempat_tanggal_lahir, jenis_kelamin, agama, nama_ayah, nama_ibu, alamat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $nama_panggilan, $nik, $ttl, $jenis_kelamin, $agama, $nama_ayah, $nama_ibu, $alamat]);
    echo "Data siswa berhasil ditambahkan!";
    header("Location: kelola_siswa.php");
    exit();
}
?>

<h2>Tambah Data Siswa</h2>
<form method="POST">
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" required><br>
    <label>Nama Panggilan:</label>
    <input type="text" name="nama_panggilan" required><br>
    <label>NIK:</label>
    <input type="text" name="nik" required><br>
    <label>Tempat, Tanggal Lahir:</label>
    <input type="text" name="tempat_tanggal_lahir" required><br>
    <label>Jenis Kelamin:</label>
    <select name="jenis_kelamin" required>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br>
    <label>Agama:</label>
    <input type="text" name="agama" required><br>
    <label>Nama Ayah:</label>
    <input type="text" name="nama_ayah"><br>
    <label>Nama Ibu:</label>
    <input type="text" name="nama_ibu"><br>
    <label>Alamat:</label>
    <textarea name="alamat" required></textarea><br>
    <input type="submit" name="submit" value="Tambah Data">
</form>
<a href="kelola_siswa.php"><button>Kembali</button></a>