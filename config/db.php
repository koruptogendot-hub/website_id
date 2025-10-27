<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "cyber_access";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Buat tabel jika belum ada
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    access TINYINT(1) DEFAULT 0
)
");
?>
