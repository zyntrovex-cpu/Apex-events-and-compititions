<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/auth.php';

if (admin_user()) { redirect('dashboard.php'); }

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $email = trim($_POST['email'] ?? '');
    $pw    = (string)($_POST['password'] ?? '');
    if (!$email || !$pw) {
        $err = 'Please enter your email and password.';
    } else if (attempt_login($email, $pw)) {
        $back = $_SESSION['_after_login'] ?? 'dashboard.php';
        unset($_SESSION['_after_login']);
        redirect($back);
    } else {
        $err = 'Those credentials do not match, or the account is locked.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in — APEX Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin">
<div class="login-wrap">
  <div class="login-card">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:28px">
      <svg viewBox="0 0 120 110" width="40" height="37" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#0E1A2B"/></svg>
      <div>
        <div style="font-family:Archivo,sans-serif;font-stretch:125%;font-weight:800;font-size:22px;letter-spacing:.08em">APEX</div>
        <div style="font-family:Archivo,sans-serif;font-stretch:110%;font-weight:600;font-size:7.5px;letter-spacing:.34em;color:var(--dgold)">ADMIN PANEL</div>
      </div>
    </div>
    <h1>Welcome back</h1>
    <p class="sub">Sign in to manage competitions, enquiries, partners and site content.</p>

    <?php if ($err): ?><div class="alert-err"><?= e($err) ?></div><?php endif; ?>

    <form method="POST" class="form-inline">
      <?= csrf_field() ?>
      <label>Email<input type="email" name="email" required autofocus autocomplete="username" value="<?= e($_POST['email'] ?? '') ?>"></label>
      <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
      <button class="btn btn-navy btn-lg" type="submit" style="width:100%;justify-content:center">Sign in</button>
    </form>

    <p style="margin-top:22px;font-size:12.5px;color:var(--slate);text-align:center">Default demo account: <code>admin@apex.local</code> · <code>ApexAdmin!2026</code> — change it from Settings once you sign in.</p>
    <p style="margin-top:12px;text-align:center"><a href="../index.php" style="font-size:13px;color:var(--dgold)">← Back to site</a></p>
  </div>
</div>
</body>
</html>
