<?php
require_once dirname(__DIR__) . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../index.php'); }
require_csrf();

$email = trim($_POST['email'] ?? '');
$back = $_SERVER['HTTP_REFERER'] ?? '../index.php';

if (!validate_email($email)) { flash('newsletter_ok', 'Please enter a valid email.'); redirect($back); }

try {
    $stmt = db()->prepare('INSERT INTO subscribers (email,source) VALUES (?,?) ON DUPLICATE KEY UPDATE is_active=1');
    $stmt->execute([$email, basename(parse_url($back, PHP_URL_PATH) ?: 'footer')]);
    flash('newsletter_ok', 'Thanks — you\'re on the APEX list.');
} catch (Throwable $e) {
    error_log('[APEX news] ' . $e->getMessage());
    flash('newsletter_ok', 'We could not add you right now. Please try again.');
}

redirect($back);
