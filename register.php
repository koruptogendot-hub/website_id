<?php
include "config/db.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    if ($conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')")) {
        $msg = "Registration successful. Wait for admin access!";
    } else {
        $msg = "Email already registered!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="cyber-form">
  <h2>REGISTER</h2>
  <?php if($msg) echo "<div class='warning'>$msg</div>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <a class="link" href="/login">Back to Login</a>
</div>
