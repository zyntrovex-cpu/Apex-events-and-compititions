<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../contact.php'); }
require_csrf();

flash_old($_POST);

$errors = [];

if (!spam_honeypot_ok('website_url')) {
    // Silent accept to avoid tipping off bots
    redirect('../contact.php?sent=1');
}

$fullName       = trim($_POST['full_name'] ?? '');
$designation    = trim($_POST['designation'] ?? '');
$institutionName= trim($_POST['institution_name'] ?? '');
$institutionType= trim($_POST['institution_type'] ?? '');
$email          = trim($_POST['email'] ?? '');
$phone          = trim($_POST['phone'] ?? '');
$interests      = $_POST['interests'] ?? [];
$eventType      = trim($_POST['event_type'] ?? '');
$expectedDate   = trim($_POST['expected_date'] ?? '');
$cityVenue      = trim($_POST['city_venue'] ?? '');
$participants   = trim($_POST['participants'] ?? '');
$budget         = trim($_POST['budget'] ?? '');
$source         = trim($_POST['source'] ?? '');
$message        = trim($_POST['message'] ?? '');
$consent        = ($_POST['consent'] ?? '') === 'yes';

if ($fullName === '')        $errors[] = 'Please enter your name.';
if ($designation === '')     $errors[] = 'Please enter your designation.';
if ($institutionName === '') $errors[] = 'Please enter your institution.';
if ($institutionType === '') $errors[] = 'Please choose institution type.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';
if ($email !== '' && !validate_email($email)) $errors[] = 'Please check the email address.';
if (!is_array($interests) || !$interests) $errors[] = 'Please choose at least one interest.';
if (!$consent)               $errors[] = 'Please consent so we can get back to you.';
if ($expectedDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $expectedDate)) $expectedDate = '';

if ($errors) { flash_errors($errors); redirect('../contact.php'); }

try {
    $stmt = db()->prepare('INSERT INTO proposal_enquiries
      (full_name,designation,institution_name,institution_type,email,phone,event_type,interests,expected_date,city_venue,participants,budget,source,message,consent_given,ip_address)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([
        $fullName, $designation, $institutionName, $institutionType,
        $email ?: null, $phone, $eventType,
        implode(', ', array_map('strval', $interests)),
        $expectedDate ?: null, $cityVenue, $participants, $budget, $source, $message,
        $consent ? 1 : 0, $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
    $id = (int)db()->lastInsertId();

    notify_admin_submission('Proposal enquiry', "Enquiry #$id from $fullName ($institutionName)", [
        'Name' => $fullName, 'Designation' => $designation,
        'Institution' => $institutionName, 'Type' => $institutionType,
        'Email' => $email, 'Phone' => $phone,
        'Interests' => $interests,
        'Event type' => $eventType, 'Expected date' => $expectedDate,
        'City / Venue' => $cityVenue, 'Participants' => $participants,
        'Budget' => $budget, 'Source' => $source, 'Message' => $message,
    ]);

    if ($email) {
        send_applicant_confirmation($email, '[APEX] We received your enquiry',
            'Thank you — your enquiry is in!',
            'A member of the APEX team will contact you within ' . setting('response_time','one working day') . '. We will share ideas, a timeline and an itemised proposal.');
    }

    flash('proposal_ok', 'A member of the APEX team will contact you within ' . setting('response_time','one working day') . '.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    error_log('[APEX proposal] ' . $e->getMessage());
    flash_errors(['We could not save your enquiry right now. Please try again, or call ' . setting('contact_phone') . '.']);
}
redirect('../contact.php');
