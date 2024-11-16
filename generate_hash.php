<?php
$password = "admin1234";  // Password admin
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash password
echo "Hash Password: " . $hashedPassword;
