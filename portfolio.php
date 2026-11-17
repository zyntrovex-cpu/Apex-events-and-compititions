<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Our School & College Events | APEX Portfolio';
$pageDescription = 'See the competitions, ceremonies, tournaments and festivals APEX has managed for schools, colleges and universities.';

// Redirect to the richer past-events listing
header('Location: past-events.php');
exit;
