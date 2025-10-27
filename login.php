<?php
session_start();
include "config/db.php";
include "config/admin_config.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["email"] = $email;
            header("Location: /dashboard");
            exit;
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "Email not found!";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="cyber-form">
  <h2>LOGIN</h2>
  <?php if($msg) echo "<div class='warning'>$msg</div>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <a class="link" href="/register">Register</a>
  <a class="link" href="/reset_password">Reset Password</a>
</div>
