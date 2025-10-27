<?php
session_start();
require __DIR__ . '/config/db.php';

// cek login
if (!isset($_SESSION['email'])) {
    header("Location: /login");
    exit;
}

// cek akses
$email = $_SESSION['email'];
$user = $conn->query("SELECT * FROM users WHERE email='$email'")->fetch_assoc();
if (!$user || $user['access'] != 1) {
    echo "<link rel='stylesheet' href='style.css'><div class='cyber-form'><h2>ACCESS DENIED</h2><p>Menunggu admin memberi akses.</p></div>";
    exit;
}

// load PHPMailer dan config Gmail
require __DIR__ . '/vendor/autoload.php';
$mailAccounts = include __DIR__ . '/config/mail_config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// pilih Gmail
$gmail_active = isset($_GET['gmail']) ? intval($_GET['gmail']) : 1;
if (!isset($mailAccounts[$gmail_active])) $gmail_active = 1;
$account = $mailAccounts[$gmail_active];

// kirim email
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = trim($_POST['number']);
    if (!preg_match('/^[0-9]{6,15}$/', $number)) {
        $error = "Nomor tidak valid.";
    } else {
        $bodyText = "HI THIS {$number} PLEASE CHECK";
        $recipientEmail = $number . "@sms-gateway.example"; // ganti sesuai gateway/email tujuan

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $account['email'];
            $mail->Password = $account['app_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($account['email'], 'Cyber Control');
            $mail->addAddress($recipientEmail);
            $mail->Subject = "Notification for {$number}";
            $mail->Body = $bodyText;

            $mail->send();
            $success = "Terkirim via {$account['email']} → {$recipientEmail}";
        } catch (Exception $e) {
            $error = "Gagal mengirim: " . $mail->ErrorInfo;
        }
    }
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
<script>function toggleMenu(){document.getElementById('sidebar').classList.toggle('open');}</script>
<div class="cyber-form">
  <h2>📨 SEND GMAIL (Gmail <?=htmlspecialchars($gmail_active)?>)</h2>
  <?php if(isset($error)) echo "<div class='warning'>$error</div>"; ?>
  <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
  <div class="gmail-buttons">
    <?php for($i=1;$i<=10;$i++): ?>
      <a href="?gmail=<?=$i?>" class="btn <?=($gmail_active==$i?'active':'')?>">GMAIL <?=$i?></a>
    <?php endfor; ?>
  </div>
  <form method="POST">
    <input type="text" name="number" placeholder="Input Number (ex: 628...)" required>
    <button type="submit">Send with <?=htmlspecialchars($account['email'])?></button>
  </form>
</div>
