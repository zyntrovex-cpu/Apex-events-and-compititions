<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../apex-card.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../apex-card.php?ok=1'); }

$errors = [];
$cardTypeId  = (int)($_POST['card_type_id'] ?? 0) ?: null;
$studentName = trim($_POST['student_name'] ?? '');
$dob         = trim($_POST['date_of_birth'] ?? '');
$instClass   = trim($_POST['institution_class'] ?? '');
$guardian    = trim($_POST['guardian_name'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$email       = trim($_POST['email'] ?? '');
$city        = trim($_POST['city'] ?? '');
$address     = trim($_POST['delivery_address'] ?? '');
$consent     = ($_POST['consent'] ?? '') === 'yes';

if (!$cardTypeId)    $errors[] = 'Please choose a card type.';
if ($studentName === '') $errors[] = 'Please enter the student\'s name.';
if ($instClass === '')   $errors[] = 'Please enter the institution and class.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';
if ($email !== '' && !validate_email($email)) $errors[] = 'Please check the email.';
if ($city === '')     $errors[] = 'Please enter your city.';
if ($address === '')  $errors[] = 'Please enter a delivery address.';
if (!$consent)        $errors[] = 'Please tick the consent box.';
if ($dob && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) $dob = '';

$cardTypeName = null;
if ($cardTypeId) {
    try {
        $s = db()->prepare('SELECT name FROM apex_card_types WHERE id=?');
        $s->execute([$cardTypeId]);
        $cardTypeName = $s->fetchColumn() ?: null;
    } catch (Throwable $e) {}
}

$photoPath = null;
if (!empty($_FILES['photo']['tmp_name'])) {
    $photoPath = upload_file($_FILES['photo'], 'applications', 3145728);
    if ($photoPath === null && ($_FILES['photo']['error'] ?? 0) !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'The uploaded photo could not be saved. Please use JPG, PNG or WebP under 3 MB.';
    }
}

if ($errors) { flash_errors($errors); redirect('../apex-card.php#apply'); }

try {
    $stmt = db()->prepare('INSERT INTO apex_card_applications
      (card_type_id,card_type_name,student_name,date_of_birth,institution_name,class_year,guardian_name,phone,email,city,delivery_address,photo,consent_given)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $instParts = explode(',', $instClass, 2);
    $stmt->execute([
        $cardTypeId, $cardTypeName, $studentName, $dob ?: null,
        trim($instParts[0] ?? $instClass), trim($instParts[1] ?? ''),
        $guardian, $phone, $email ?: null, $city, $address, $photoPath, 1,
    ]);
    $id = (int)db()->lastInsertId();

    notify_admin_submission('APEX Card application', "Card application #$id from $studentName", [
        'Card type' => $cardTypeName, 'Student' => $studentName, 'DOB' => $dob,
        'Institution / Class' => $instClass, 'Guardian' => $guardian,
        'Phone' => $phone, 'Email' => $email, 'City' => $city, 'Address' => $address,
    ]);

    if ($email) {
        send_applicant_confirmation($email, '[APEX] APEX Card application received',
            'Thank you — your APEX Card application has been received!',
            'We will confirm payment details within ' . setting('response_time','one working day') . '. Your digital card will arrive within ['
            . setting('digital_card_days','2') . '] working days once payment is confirmed, and the printed card within [' . setting('printed_card_days','7–10') . '] days.');
    }

    flash('card_ok', 'A confirmation and payment details will be sent to you within ' . setting('response_time','one working day') . '.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    error_log('[APEX card] ' . $e->getMessage());
    flash_errors(['We could not save your application right now. Please try again shortly.']);
}
redirect('../apex-card.php#apply');
