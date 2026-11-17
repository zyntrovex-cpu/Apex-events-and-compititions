<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/email.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('../calendar.php'); }
require_csrf();

flash_old($_POST);
if (!spam_honeypot_ok('website_url')) { redirect('../calendar.php?ok=1'); }

$errors = [];
$compId = (int)($_POST['competition_id'] ?? 0);
if ($compId < 1) $errors[] = 'Please choose a competition.';

$institutionName = trim($_POST['institution_name'] ?? '');
$institutionType = trim($_POST['institution_type'] ?? '');
$city            = trim($_POST['city'] ?? '');
$coordName       = trim($_POST['coordinator_name'] ?? '');
$coordRole       = trim($_POST['coordinator_role'] ?? '');
$coordEmail      = trim($_POST['coordinator_email'] ?? '');
$coordPhone      = trim($_POST['coordinator_phone'] ?? '');
$teamName        = trim($_POST['team_name'] ?? '');
$teamSize        = max(0, min(30, (int)($_POST['team_size'] ?? 0))) ?: null;
$categoryLevel   = trim($_POST['category_level'] ?? '');
$notes           = trim($_POST['notes'] ?? '');
$consent         = ($_POST['consent'] ?? '') === 'yes';

if ($institutionName === '') $errors[] = 'Please enter the institution name.';
if ($city === '')            $errors[] = 'Please enter the city.';
if ($coordName === '')       $errors[] = 'Please enter the coordinator\'s name.';
if (!validate_email($coordEmail)) $errors[] = 'Please enter a valid coordinator email.';
if (!validate_phone($coordPhone)) $errors[] = 'Please enter a valid coordinator phone number.';
if (!$consent)               $errors[] = 'Please tick the consent box.';

$participants = [];
foreach (($_POST['participants'] ?? []) as $row) {
    $name = trim($row['name'] ?? '');
    if ($name === '') continue;
    $participants[] = [
        'name' => $name,
        'class_grade' => trim($row['class_grade'] ?? ''),
        'age' => (int)($row['age'] ?? 0) ?: null,
    ];
}

// Confirm competition exists & open
try {
    $s = db()->prepare('SELECT id,name,slug,registration_status FROM competitions WHERE id=? LIMIT 1');
    $s->execute([$compId]);
    $comp = $s->fetch();
    if (!$comp) $errors[] = 'This competition was not found.';
    elseif (!in_array($comp['registration_status'], ['open','closing_soon'], true)) $errors[] = 'Registration for this competition is not currently open.';
} catch (Throwable $e) { $errors[] = 'We could not reach the database right now.'; $comp = null; }

if ($errors) {
    flash_errors($errors);
    redirect('../register-team.php?competition=' . urlencode($comp['slug'] ?? ''));
}

try {
    db()->beginTransaction();
    $stmt = db()->prepare('INSERT INTO event_registrations
      (competition_id,institution_name,institution_type,city,coordinator_name,coordinator_role,coordinator_email,coordinator_phone,team_name,team_size,category_level,participants_json,notes,consent_given,ip_address)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([
        $compId, $institutionName, $institutionType, $city,
        $coordName, $coordRole, $coordEmail, $coordPhone,
        $teamName, $teamSize, $categoryLevel,
        $participants ? json_encode($participants, JSON_UNESCAPED_UNICODE) : null,
        $notes, 1, $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
    $regId = (int)db()->lastInsertId();

    $pStmt = db()->prepare('INSERT INTO participants (registration_id,full_name,class_grade,age) VALUES (?,?,?,?)');
    foreach ($participants as $p) {
        $pStmt->execute([$regId, $p['name'], $p['class_grade'], $p['age']]);
    }
    db()->commit();

    notify_admin_submission('Competition registration', "Team #$regId from $institutionName for " . $comp['name'], [
        'Competition' => $comp['name'], 'Institution' => $institutionName, 'Type' => $institutionType,
        'City' => $city, 'Coordinator' => $coordName . ' (' . $coordRole . ')',
        'Email' => $coordEmail, 'Phone' => $coordPhone,
        'Team name' => $teamName, 'Team size' => $teamSize, 'Level' => $categoryLevel,
        'Participants' => count($participants), 'Notes' => $notes,
    ]);

    send_applicant_confirmation($coordEmail, '[APEX] Registration received for ' . $comp['name'],
        'Your team is registered!',
        'We have received your team\'s registration for ' . $comp['name'] . '. We will contact you about confirmation and next steps within ' . setting('response_time','one working day') . '.');

    flash('registration_ok', 'A confirmation has been sent to ' . $coordEmail . '. We will contact the coordinator with the next steps.');
    unset($_SESSION['_flash']['old']);
} catch (Throwable $e) {
    if (db()->inTransaction()) db()->rollBack();
    error_log('[APEX reg] ' . $e->getMessage());
    flash_errors(['We could not save your registration right now. Please try again shortly.']);
}

redirect('../register-team.php?competition=' . urlencode($comp['slug'] ?? ''));
