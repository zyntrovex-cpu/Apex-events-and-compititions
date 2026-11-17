<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../sponsorship.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../sponsorship.php?ok=1'); }

$errors = [];
$company   = trim($_POST['company_name'] ?? '');
$contact   = trim($_POST['contact_person'] ?? '');
$design    = trim($_POST['designation'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$tierId    = (int)($_POST['tier_id'] ?? 0) ?: null;
$interests = trim($_POST['interests'] ?? '');
$budget    = trim($_POST['budget'] ?? '');
$message   = trim($_POST['message'] ?? '');

if ($company === '')   $errors[] = 'Please enter your company name.';
if ($contact === '')   $errors[] = 'Please enter a contact person.';
if (!validate_email($email)) $errors[] = 'Please enter a valid email.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';

if ($errors) { flash_errors($errors); redirect('../sponsorship.php#apply'); }

try {
    $stmt = db()->prepare('INSERT INTO sponsorship_applications
      (company_name,contact_person,designation,email,phone,tier_id,interests,budget,message)
      VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$company, $contact, $design, $email, $phone, $tierId, $interests, $budget, $message]);
    $id = (int)db()->lastInsertId();

    notify_admin_submission('Sponsorship enquiry', "Sponsor enquiry #$id from $company", [
        'Company' => $company, 'Contact' => $contact . ' (' . $design . ')',
        'Email' => $email, 'Phone' => $phone,
        'Tier' => $tierId, 'Interests' => $interests, 'Budget' => $budget, 'Message' => $message,
    ]);

    send_applicant_confirmation($email, '[APEX] Sponsorship enquiry received',
        'Thank you!', 'We have received your sponsorship enquiry and will share a proposal and media kit within ' . setting('response_time','one working day') . '.');

    flash('sponsor_ok', 'A team member will share a proposal and media kit within ' . setting('response_time','one working day') . '.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    error_log('[APEX sponsor] ' . $e->getMessage());
    flash_errors(['We could not save your enquiry right now. Please try again shortly.']);
}
redirect('../sponsorship.php#apply');
