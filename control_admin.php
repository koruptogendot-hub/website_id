<?php
session_start();
include "config/db.php";
$email = $_SESSION["email"];
if ($email != "admin@cyberpanel.com") die("Access Denied");

$msg = "";
if (isset($_POST["add_access"])) {
  $mail = $_POST["email"];
  $conn->query("UPDATE users SET access=1 WHERE email='$mail'");
  $msg = "Access added for $mail";
}

if (isset($_POST["remove_access"])) {
  $mail = $_POST["email"];
  $conn->query("UPDATE users SET access=0 WHERE email='$mail'");
  $msg = "Access removed for $mail";
}

if (isset($_POST["delete_user"])) {
  $mail = $_POST["email"];
  $conn->query("DELETE FROM users WHERE email='$mail'");
  $msg = "User deleted: $mail";
}

if (isset($_POST["change_pass"])) {
  $new = password_hash($_POST["newpass"], PASSWORD_DEFAULT);
  $conn->query("UPDATE users SET password='$new' WHERE email='$email'");
  $msg = "Admin password updated!";
}

$users = $conn->query("SELECT * FROM users");
?>
<link rel="stylesheet" href="style.css">

<div class="admin-panel">
  <h2>⚙️ CONTROL ADMIN</h2>
  <?php if($msg) echo "<div class='warning'>$msg</div>"; ?>

  <form method="POST">
    <input type="email" name="email" placeholder="User Email">
    <button name="add_access">Add Access</button>
    <button name="remove_access" class="warn">Remove Access</button>
    <button name="delete_user" class="danger">Delete User</button>
  </form>

  <form method="POST" style="margin-top:20px;">
    <input type="password" name="newpass" placeholder="New Admin Password" required>
    <button name="change_pass">Change Password</button>
  </form>

  <table>
    <tr><th>Email</th><th>Access</th></tr>
    <?php while($u=$users->fetch_assoc()): ?>
      <tr><td><?=$u["email"]?></td><td><?=$u["access"]?"✅":"❌"?></td></tr>
    <?php endwhile; ?>
  </table>
</div>
