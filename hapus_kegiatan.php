<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM jadwal_kegiatan WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: setting.php");
    exit();
} else {
    echo "ID kegiatan tidak ditemukan.";
}
