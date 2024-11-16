<?php
session_start();
require 'config.php';

// Pastikan folder 'uploads' ada
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Fungsi untuk mengunggah file
function uploadFile($file, $uploadDir)
{
    $fileName = time() . '_' . basename($file['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $fileName;
    } else {
        return null;
    }
}

// Inisialisasi variabel untuk menyimpan nama file
$fotoKTP = null;
$fotoAkte = null;
$fotoKK = null;

// Proses upload file
if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] == 0) {
    $fotoKTP = uploadFile($_FILES['foto_ktp'], $uploadDir);
}
if (isset($_FILES['foto_akte_kelahiran']) && $_FILES['foto_akte_kelahiran']['error'] == 0) {
    $fotoAkte = uploadFile($_FILES['foto_akte_kelahiran'], $uploadDir);
}
if (isset($_FILES['foto_kartu_keluarga']) && $_FILES['foto_kartu_keluarga']['error'] == 0) {
    $fotoKK = uploadFile($_FILES['foto_kartu_keluarga'], $uploadDir);
}

// Masukkan data ke dalam database (Contoh)
$alamat = $_POST['alamat'];

$stmt = $conn->prepare("INSERT INTO pendaftaran (alamat, foto_ktp, foto_akte_kelahiran, foto_kartu_keluarga) VALUES (?, ?, ?, ?)");
$stmt->execute([$alamat, $fotoKTP, $fotoAkte, $fotoKK]);

echo "Data berhasil disimpan!";
