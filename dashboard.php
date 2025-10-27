<?php
session_start();
include "config/db.php";
if (!isset($_SESSION["email"])) header("Location: /login");

$email = $_SESSION["email"];
$user = $conn->query("SELECT * FROM users WHERE email='$email'")->fetch_assoc();

if ($email == "admin@cyberpanel.com") {
  header("Location: /control_admin");
  exit;
}

if ($user["access"] != 1) {
  die("<link rel='stylesheet' href='style.css'><div class='cyber-form'><h2>ACCESS DENIED</h2><p>Wait until admin gives access.</p></div>");
}
?>
<link rel="stylesheet" href="style.css">
<button class="menu-btn" onclick="toggleMenu()">☰</button>
<div class="sidebar" id="sidebar">
  <a href="/send_gmail">📨 SEND GMAIL</a>
  <a href="/pages/maintenance.php">🔗 PAIRING</a>
  <a href="/pages/maintenance.php">👤 CEK BIO</a>
  <a href="https://t.me/cyberadmin" target="_blank">💬 CONTACT ADMIN</a>
  <a href="/logout">🚪 LOGOUT</a>
</div>

<script>
function toggleMenu() {
  document.getElementById("sidebar").classList.toggle("open");
}
</script>
