<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config.php';  // Pastikan sudah ada koneksi ke database

    // Ambil data dari form
    $nama = $_POST['nama'];
    $nama_panggilan = $_POST['nama_panggilan'];
    $nik = $_POST['nik'];
    $tempat_tanggal_lahir = $_POST['tempat_tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];

    // Data Ayah
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ayah = $_POST['nik_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $nomor_hp_ayah = $_POST['nomor_hp_ayah'];
    $tempat_tanggal_lahir_ayah = $_POST['tempat_tanggal_lahir_ayah'];

    // Data Ibu
    $nama_ibu = $_POST['nama_ibu'];
    $nik_ibu = $_POST['nik_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $nomor_hp_ibu = $_POST['nomor_hp_ibu'];
    $tempat_tanggal_lahir_ibu = $_POST['tempat_tanggal_lahir_ibu'];

    // Cek jika NIK sudah terdaftar
    $stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE nik = ?");
    $stmt->execute([$nik]);
    $existing = $stmt->fetch();

    if ($existing) {
        echo "NIK sudah terdaftar!";
    } else {
        // Simpan data pendaftaran ke database tanpa alamat
        $stmt = $conn->prepare("INSERT INTO pendaftaran (nama, nama_panggilan, nik, tempat_tanggal_lahir, jenis_kelamin, agama, 
                                nama_ayah, nik_ayah, pekerjaan_ayah, pendidikan_ayah, nomor_hp_ayah, tempat_tanggal_lahir_ayah, 
                                nama_ibu, nik_ibu, pekerjaan_ibu, pendidikan_ibu, nomor_hp_ibu, tempat_tanggal_lahir_ibu)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([
            $nama,
            $nama_panggilan,
            $nik,
            $tempat_tanggal_lahir,
            $jenis_kelamin,
            $agama,
            $nama_ayah,
            $nik_ayah,
            $pekerjaan_ayah,
            $pendidikan_ayah,
            $nomor_hp_ayah,
            $tempat_tanggal_lahir_ayah,
            $nama_ibu,
            $nik_ibu,
            $pekerjaan_ibu,
            $pendidikan_ibu,
            $nomor_hp_ibu,
            $tempat_tanggal_lahir_ibu
        ])) {
            // Redirect ke form alamat setelah berhasil
            header("Location: form_alamat.php?nik=" . $nik);
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="form_pendaftaran.css">
</head>

<body>
    <header>
        <h1>Halaman Pendaftaran</h1>
    </header>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label for="nama_panggilan">Nama Panggilan:</label>
            <input type="text" name="nama_panggilan" required>
        </div>

        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="text" name="nik" required>
        </div>

        <div class="form-group">
            <label for="tempat_tanggal_lahir">Tempat, Tanggal Lahir:</label>
            <input type="text" name="tempat_tanggal_lahir" required>
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select name="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="agama">Agama:</label>
            <select name="agama" required>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </div>

        <div class="split-container">
            <!-- Data Ayah -->
            <div class="form-section">
                <h3>Data Ayah</h3>
                <label for="nama_ayah">Nama Ayah:</label>
                <input type="text" name="nama_ayah" required>

                <label for="nik_ayah">NIK Ayah:</label>
                <input type="text" name="nik_ayah" required>

                <label for="pekerjaan_ayah">Pekerjaan Ayah:</label>
                <input type="text" name="pekerjaan_ayah" required>

                <label for="pendidikan_ayah">Pendidikan Terakhir Ayah:</label>
                <input type="text" name="pendidikan_ayah" required>

                <label for="nomor_hp_ayah">Nomor HP Ayah:</label>
                <input type="text" name="nomor_hp_ayah" required>
            </div>

            <!-- Data Ibu -->
            <div class="form-section">
                <h3>Data Ibu</h3>
                <label for="nama_ibu">Nama Ibu:</label>
                <input type="text" name="nama_ibu" required>

                <label for="nik_ibu">NIK Ibu:</label>
                <input type="text" name="nik_ibu" required>

                <label for="pekerjaan_ibu">Pekerjaan Ibu:</label>
                <input type="text" name="pekerjaan_ibu" required>

                <label for="pendidikan_ibu">Pendidikan Terakhir Ibu:</label>
                <input type="text" name="pendidikan_ibu" required>

                <label for="nomor_hp_ibu">Nomor HP Ibu:</label>
                <input type="text" name="nomor_hp_ibu" required>
            </div>
        </div>

        <button type="submit">Selanjutnya</button>
    </form>
</body>

</html>