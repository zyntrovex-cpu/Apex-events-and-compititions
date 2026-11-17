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
<meta name="theme-color" content="#0E1A2B">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 110'%3E%3Cpath d='M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z' fill='%23D4A63A'/%3E%3Cpath d='M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z' fill='%230E1A2B'/%3E%3C/svg%3E">
</head>
<body>
<a href="#main" class="sr-only">Skip to content</a>

<header class="site-header">
  <div class="bar">
    <a class="brand" href="index.php" aria-label="APEX Events &amp; Competitions — home">
      <span class="mark">
        <svg viewBox="0 0 120 110" width="42" height="39" aria-hidden="true">
          <path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/>
          <path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#F6F3EC"/>
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
