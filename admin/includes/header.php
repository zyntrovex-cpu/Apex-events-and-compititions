<?php
require_once dirname(__DIR__, 2) . '/config/app.php';
require_once dirname(__DIR__, 2) . '/includes/auth.php';

$user = require_admin();
$pageTitle = $pageTitle ?? 'Dashboard';
$basePath = str_repeat('../', substr_count(ltrim($_SERVER['PHP_SELF'] ?? '', '/'), '/') - 1);

function admin_nav_link(string $path, string $label, string $icon = ''): void {
    $current = trim($_SERVER['REQUEST_URI'] ?? '', '/');
    $isActive = str_contains($current, '/' . trim($path, '/'));
    echo '<a href="' . e($path) . '"' . ($isActive ? ' aria-current="page"' : '') . '>';
    if ($icon) echo '<svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $icon . '</svg>';
    echo e($label) . '</a>';
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>APEX Admin — <?= e($pageTitle) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/admin.css">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 110'%3E%3Cpath d='M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z' fill='%23D4A63A'/%3E%3Cpath d='M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z' fill='%230E1A2B'/%3E%3C/svg%3E">
</head>
<body class="admin">
<div class="admin-shell">
  <aside class="admin-side">
    <a class="admin-brand" href="../dashboard.php">
      <svg viewBox="0 0 120 110" width="30" height="27" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#F6F3EC"/></svg>
      <span><span class="name">APEX</span><span class="sub">ADMIN PANEL</span></span>
    </a>
    <nav class="admin-nav">
      <h4>MANAGE</h4>
      <?php
      admin_nav_link('../dashboard.php', 'Dashboard', '<rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/>');
      admin_nav_link('../competitions/index.php', 'Competitions', '<path d="M8 3h8v6a4 4 0 0 1-8 0z"/><path d="M8 5H5a3 3 0 0 0 3 4.5"/><path d="M16 5h3a3 3 0 0 1-3 4.5"/><path d="M12 13v4"/><path d="M8.5 17h7v4h-7z"/>');
      admin_nav_link('../events/index.php', 'Event Services', '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>');
      admin_nav_link('../portfolio/index.php', 'Portfolio / Past Events', '<path d="M4 7h3l2-3h6l2 3h3v12H4z"/><circle cx="12" cy="13" r="4"/>');
      admin_nav_link('../partners/index.php', 'Partners', '<circle cx="9" cy="7" r="4"/><path d="M3 21v-1a6 6 0 0 1 6-6"/><circle cx="17" cy="11" r="3"/><path d="M13 21v-1a4 4 0 0 1 4-4"/>');
      admin_nav_link('../sponsorship/index.php', 'Sponsorship Tiers', '<path d="M8 21h8"/><path d="M12 17v4"/><path d="M7 4h10v5a5 5 0 0 1-10 0z"/><path d="M7 4H4v2a3 3 0 0 0 3 3"/><path d="M17 4h3v2a3 3 0 0 1-3 3"/>');
      admin_nav_link('../card/index.php', 'APEX Card', '<rect x="3" y="6" width="18" height="12" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>');
      admin_nav_link('../team/index.php', 'Team Members', '<circle cx="9" cy="7" r="4"/><path d="M3 21v-1a6 6 0 0 1 6-6"/><circle cx="17" cy="7" r="4"/><path d="M15 21v-1a6 6 0 0 1 6-6"/>');
      admin_nav_link('../faq/index.php', 'FAQ', '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12" y2="17.01"/>');
      admin_nav_link('../testimonials/index.php', 'Testimonials', '<path d="M3 11c0-5 3-8 9-8s9 3 9 8-4 7-5 7v3l-3-2c-6 0-10-3-10-8z"/>');
      ?>

      <h4>SUBMISSIONS</h4>
      <?php
      admin_nav_link('../enquiries/index.php', 'Proposal Enquiries', '<path d="M4 4h16v12H5l-1 4z"/>');
      admin_nav_link('../registrations/index.php', 'Competition Registrations', '<path d="M9 11l3 3 7-7"/><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8"/>');
      admin_nav_link('../applications/index.php', 'APEX Card Applications', '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/><path d="M7 15h4"/>');
      admin_nav_link('../sponsorship/applications.php', 'Sponsorship Applications', '<path d="M12 2l9 4v6c0 5-4 9-9 10-5-1-9-5-9-10V6z"/>');
      admin_nav_link('../trips/index.php', 'Trip Enquiries', '<circle cx="12" cy="10" r="3"/><path d="M12 22s-7-8-7-13a7 7 0 0 1 14 0c0 5-7 13-7 13z"/>');
      admin_nav_link('../messages/index.php', 'Contact Messages', '<path d="M4 4h16v12H4z"/><polyline points="4 4 12 13 20 4"/>');
      ?>

      <h4>SITE</h4>
      <?php
      admin_nav_link('../navigation/index.php', 'Navigation &amp; Social', '<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/>');
      admin_nav_link('../settings/index.php', 'Site Settings', '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>');
      admin_nav_link('../media/index.php', 'Media Library', '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>');
      ?>

      <h4>ACCOUNT</h4>
      <a href="../logout.php">Log out</a>
      <a href="../../index.php" target="_blank">View public site ↗</a>
    </nav>
  </aside>

  <section class="admin-main">
    <header class="admin-topbar">
      <h1><?= e($pageTitle) ?></h1>
      <div class="user">
        <div style="text-align:right">
          <div style="font-weight:600"><?= e($user['name']) ?></div>
          <div style="color:var(--slate);font-size:12px"><?= e(ucfirst(str_replace('_',' ',$user['role']))) ?></div>
        </div>
        <div class="avatar"><?= e(strtoupper(substr($user['name'],0,1))) ?></div>
      </div>
    </header>
    <div class="admin-content">
      <?php
      if ($ok = flash_get('ok')) echo '<div class="alert-ok">' . e($ok) . '</div>';
      if ($err = flash_get('err')) echo '<div class="alert-err">' . e($err) . '</div>';
      ?>
