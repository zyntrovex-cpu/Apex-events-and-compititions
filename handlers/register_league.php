<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../competitions.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../index.php'); }

$league = (($_POST['league'] ?? '') === 'college') ? 'college' : 'university';
$back   = $league === 'college' ? '../register-college.php' : '../register-university.php';
$okFlag = $league === 'college' ? 'reg_college_ok' : 'reg_university_ok';

$errors = [];

$inst   = trim($_POST['institution_name'] ?? '');
$campus = trim($_POST['campus_area'] ?? '');
$name   = trim($_POST['manager_name'] ?? '');
$role   = trim($_POST['manager_role'] ?? '');
$phone  = trim($_POST['manager_phone'] ?? '');
$email  = trim($_POST['manager_email'] ?? '');
$second = trim($_POST['second_contact'] ?? '');
$notes  = trim($_POST['notes'] ?? '');
$cats   = $_POST['categories'] ?? [];
if (!is_array($cats)) $cats = [];
$confirmEl = ($_POST['confirm_eligibility'] ?? '') === 'yes';
$confirmRu = ($_POST['confirm_rules'] ?? '')       === 'yes';
$confirmPc = ($_POST['confirm_consent'] ?? '')     === 'yes';

if ($inst === '')   $errors[] = 'Please enter the institution name.';
if ($campus === '') $errors[] = 'Please enter the campus or area in Karachi.';
if ($name === '')   $errors[] = 'Please enter the team manager\'s name.';
if (!validate_phone($phone)) $errors[] = 'Please enter a valid phone number.';
if (!validate_email($email)) $errors[] = 'Please enter a valid email address.';
if (!$cats)         $errors[] = 'Please choose at least one category.';
if (!$confirmEl)    $errors[] = 'Please confirm eligibility.';
if (!$confirmRu)    $errors[] = 'Please agree to the league rules.';
if ($league === 'college' && !$confirmPc) $errors[] = 'Please confirm you will submit parent consent for under-18 players.';

// Collect players (skip empty rows)
$players = [];
foreach (($_POST['players'] ?? []) as $row) {
    $pname = trim($row['name'] ?? '');
    if ($pname === '') continue;
    $players[] = [
        'name'       => $pname,
        'programme'  => trim($row['programme'] ?? ''),
        'year'       => trim($row['year'] ?? ''),
        'class'      => trim($row['class'] ?? ''),
        'dob'        => trim($row['dob'] ?? ''),
        'student_id' => trim($row['student_id'] ?? ''),
    ];
}

$letter = null;
if (!empty($_FILES['letter']['tmp_name'])) {
    $letter = upload_file($_FILES['letter'], 'applications', 8388608);
    if ($letter === null && ($_FILES['letter']['error'] ?? 0) !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'The letter file is larger than 8 MB or not an allowed type. Please upload a smaller file or email it later.';
    }
}

if ($errors) { flash_errors($errors); redirect($back); }

try {
    db()->beginTransaction();
    $stmt = db()->prepare('INSERT INTO event_registrations
      (competition_id,institution_name,institution_type,city,coordinator_name,coordinator_role,coordinator_email,coordinator_phone,team_name,team_size,category_level,participants_json,notes,consent_given,ip_address)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

    $instType = ucfirst($league); // "University" / "College"
    $teamName = $inst . ' · ' . $campus;
    $catLabel = 'All Karachi Table Tennis Leagues · ' . $instType . ' League';
    $categories = implode(', ', $cats);
    $teamSize = count($players) ?: null;
    $notesWithExtras = trim(
        ($notes !== '' ? $notes . "\n\n" : '') .
        "Categories: $categories\n" .
        "Campus/area: $campus\n" .
        ($second !== '' ? "Second contact: $second\n" : '') .
        ($letter ? "Letter uploaded: $letter\n" : '')
    );

    $stmt->execute([
        null,                   // no competition_id: league is stored by name
        $inst, $instType, 'Karachi',
        $name, $role, $email, $phone,
        $teamName, $teamSize, $catLabel,
        $players ? json_encode($players, JSON_UNESCAPED_UNICODE) : null,
        $notesWithExtras,
        1,
        $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
    $regId = (int)db()->lastInsertId();

    $pStmt = db()->prepare('INSERT INTO participants (registration_id,full_name,class_grade,age) VALUES (?,?,?,?)');
    foreach ($players as $p) {
        $classGrade = $league === 'college'
            ? trim(($p['class'] ?? '') . ($p['dob'] ? ' · DOB ' . $p['dob'] : ''))
            : trim(($p['programme'] ?? '') . ($p['year'] ? ' · ' . $p['year'] : ''));
        if ($p['student_id']) $classGrade .= ' · ID ' . $p['student_id'];
        $pStmt->execute([$regId, $p['name'], $classGrade, null]);
    }
    db()->commit();

    notify_admin_submission('League registration (' . $instType . ')',
        "Registration #$regId from $inst for the $instType League",
        [
            'League'         => $catLabel,
            'Institution'    => $inst,
            'Campus / area'  => $campus,
            'Team manager'   => $name . ($role ? " ($role)" : ''),
            'Phone'          => $phone,
            'Email'          => $email,
            'Second contact' => $second ?: '—',
            'Categories'     => $categories,
            'Players'        => count($players) . ' listed',
            'Notes'          => $notes ?: '—',
            'Letter'         => $letter ?: 'not uploaded',
        ]
    );

    send_applicant_confirmation($email,
        '[APEX] Registration received — ' . $instType . ' League',
        'Registration received!',
        'Thank you. APEX will email your invoice with bank details and the player document checklist within [2 working days]. Your place is confirmed once payment is received.'
    );

    flash($okFlag, 'Thank you. APEX will email your invoice and the player document checklist within [2 working days]. Your place is confirmed once payment is received.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    if (db()->inTransaction()) db()->rollBack();
    error_log('[APEX league reg] ' . $e->getMessage());
    flash_errors(['Sorry, we couldn\'t send your registration. Please try again, or contact APEX on ' . setting('contact_phone') . '.']);
}

redirect($back);
