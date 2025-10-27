<?php
include "db.php";

// Buat admin default jika belum ada
$adminEmail = "admin@cyberpanel.com";
$adminPass = password_hash("cyber123", PASSWORD_DEFAULT);
$check = $conn->query("SELECT * FROM users WHERE email='$adminEmail'");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO users (email, password, access) VALUES ('$adminEmail', '$adminPass', 1)");
}
?>
