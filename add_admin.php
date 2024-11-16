<?php
$password = "admin1234";  // Password admin
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Generate hash

// Koneksi ke database
require 'config.php';  // Pastikan sudah ada koneksi ke database

// Query untuk menambahkan admin
$stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
$stmt->execute(['admin', $hashedPassword, 'admin@example.com', 'admin']);

echo "Admin berhasil ditambahkan!";
