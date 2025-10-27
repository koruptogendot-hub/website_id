<?php
include "config/db.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $newpass = password_hash("cyber123", PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$newpass' WHERE email='$email'");
        $msg = "Password reset to: cyber123";
    } else {
        $msg = "Email not found!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="cyber-form">
  <h2>RESET PASSWORD</h2>
  <?php if($msg) echo "<div class='warning'>$msg</div>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Your Email" required>
    <button type="submit">Reset</button>
  </form>
  <a class="link" href="/login">Back to Login</a>
</div>
