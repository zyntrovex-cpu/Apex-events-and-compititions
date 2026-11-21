<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../contact.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../contact.php?ok=1'); }

$errors = [];
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$role    = trim($_POST['role'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$consent = ($_POST['consent'] ?? '') === 'yes';

if ($name === '')   $errors[] = 'Please enter your name.';
if (!validate_email($email)) $errors[] = 'Please enter a valid email address.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';
if ($message === '') $errors[] = 'Please add a short message.';
if (!$consent)      $errors[] = 'Please tick the consent box.';

if ($errors) { flash_errors($errors); redirect('../contact.php'); }

try {
    $stmt = db()->prepare('INSERT INTO contact_messages (name,email,phone,subject,message) VALUES (?,?,?,?,?)');
    $subjectFull = trim(($role ? "[$role] " : '') . ($subject ?: 'Contact enquiry'));
    $stmt->execute([$name, $email, $phone, $subjectFull, $message]);

    notify_admin_submission('Contact message', "Message from $name", [
        'Name' => $name, 'Email' => $email, 'Phone' => $phone,
        'Role' => $role, 'Subject' => $subject, 'Message' => $message,
    ]);
    send_applicant_confirmation($email, '[APEX] We received your message',
        'Thank you!', 'We have received your message and will reply within ' . setting('response_time','one working day') . '.');

    flash('contact_ok', 'Thanks — a member of the APEX team will reply within ' . setting('response_time','one working day') . '.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    error_log('[APEX contact] ' . $e->getMessage());
    flash_errors(['Sorry, we couldn\'t send your message right now. Please try again or call us.']);
}
redirect('../contact.php');
