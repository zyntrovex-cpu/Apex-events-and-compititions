<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../educational-trips.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../educational-trips.php?ok=1'); }

$errors = [];
$inst    = trim($_POST['institution_name'] ?? '');
$contact = trim($_POST['contact_name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$type    = trim($_POST['trip_type'] ?? '');
$dest    = trim($_POST['destination'] ?? '');
$date    = trim($_POST['expected_date'] ?? '');
$pc      = trim($_POST['participants'] ?? '');
$age     = trim($_POST['age_group'] ?? '');
$notes   = trim($_POST['notes'] ?? '');

if ($inst === '') $errors[] = 'Please enter the institution.';
if ($contact === '') $errors[] = 'Please enter a contact name.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';
if ($email !== '' && !validate_email($email)) $errors[] = 'Please check the email.';
if ($date && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) $date = '';

if ($errors) { flash_errors($errors); redirect('../educational-trips.php#plan'); }

try {
    $stmt = db()->prepare('INSERT INTO trip_enquiries
      (institution_name,contact_name,email,phone,trip_type,destination,expected_date,participants,age_group,notes)
      VALUES (?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$inst, $contact, $email ?: null, $phone, $type, $dest, $date ?: null, $pc, $age, $notes]);
    $id = (int)db()->lastInsertId();

    notify_admin_submission('Trip enquiry', "Trip enquiry #$id from $inst", [
        'Institution' => $inst, 'Contact' => $contact, 'Email' => $email, 'Phone' => $phone,
        'Type' => $type, 'Destination' => $dest, 'Expected date' => $date,
        'Participants' => $pc, 'Age group' => $age, 'Notes' => $notes,
    ]);

    if ($email) {
        send_applicant_confirmation($email, '[APEX] Trip enquiry received', 'Thank you!',
            'We have received your trip enquiry and will share a plan, timeline and quote within ' . setting('response_time','one working day') . '.');
    }

    flash('trip_ok', 'We will share a plan, timeline and quote within ' . setting('response_time','one working day') . '.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    error_log('[APEX trip] ' . $e->getMessage());
    flash_errors(['We could not save your enquiry right now. Please try again shortly.']);
}
redirect('../educational-trips.php#plan');
