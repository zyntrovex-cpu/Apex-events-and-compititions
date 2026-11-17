<?php
require_once dirname(__DIR__, 2) . '/config/app.php';
require_once dirname(__DIR__, 2) . '/includes/auth.php';
require_admin(); require_csrf();
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_POST['id'] ?? 0);
if ($id) {
    try { delete_row('competitions', $id); flash('ok', 'Competition deleted.'); log_admin_activity('delete','competition',$id); }
    catch (Throwable $e) { flash('err', 'Delete failed: ' . $e->getMessage()); }
}
redirect('index.php');
