<?php
/**
 * Shared header — included at the top of every public page.
 * Expects $pageTitle, $pageDescription, $pageSlug to be defined in the page.
 */
if (!isset($pageTitle)) $pageTitle = setting('site_name', 'APEX Events & Competitions');
if (!isset($pageDescription)) $pageDescription = setting('site_description');
if (!isset($pageSlug)) $pageSlug = '';

$headerNav = nav_items('header');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">
<link rel="canonical" href="<?= e((isset($_SERVER['HTTPS'])?'https':'http').'://'.($_SERVER['HTTP_HOST']??'').strtok($_SERVER['REQUEST_URI']??'','?')) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="assets/images/tt-league-poster.jpg">
<meta name="theme-color" content="#0E1A2B">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 100'%3E%3Cpolygon points='15,95 50,15 85,95' fill='%23F6F3EC'/%3E%3Cpolygon points='55,95 85,45 115,95' fill='%23F56E2E'/%3E%3C/svg%3E">
</head>
<body>
<a href="#main" class="sr-only">Skip to content</a>

<header class="site-header">
  <div class="bar">
    <a class="brand" href="index.php" aria-label="APEX Events &amp; Competitions — home">
      <span class="mark" aria-hidden="true">
        <!-- New APEX logo: two overlapping triangular peaks, navy "A" + orange smaller peak -->
        <svg viewBox="0 0 120 100" width="44" height="37" aria-hidden="true">
          <polygon points="15,95 50,15 85,95" fill="#0E1A2B"/>
          <polygon points="55,95 85,45 115,95" fill="#F56E2E"/>
        </svg>
      </span>
      <span>
        <span class="name">APEX</span>
        <span class="sub">EVENTS &amp; COMPETITIONS</span>
      </span>
    </a>

    <button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="apex-nav">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/></svg>
      Menu
    </button>

    <nav id="apex-nav" class="nav-main" data-nav aria-label="Main">
      <?php foreach ($headerNav as $it): ?>
        <a href="<?= e($it['url']) ?>"<?= nav_active($it['url']) ?><?= $it['is_cta'] ? ' class="cta"' : '' ?>><?= e($it['label']) ?></a>
      <?php endforeach; ?>
    </nav>
  </div>
</header>

<main id="main">
