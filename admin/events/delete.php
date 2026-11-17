<?php
require_once dirname(__DIR__, 2) . '/config/app.php';
require_once dirname(__DIR__, 2) . '/includes/auth.php';
require_admin(); require_csrf();
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_POST['id'] ?? 0);
if ($id) { delete_row('events', $id); flash('ok','Deleted.'); }
redirect('index.php');
