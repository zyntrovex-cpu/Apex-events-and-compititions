<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'About · APEX Events & Competitions';
$pageDescription = 'APEX Events & Competitions launches the All Karachi University and College Table Tennis Leagues, the city\'s first dedicated table tennis leagues for university and college students.';

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">ABOUT</p>
    <h1 class="disp">APEX Launches the All Karachi University &amp; College Table Tennis Leagues</h1>
    <p class="lead">APEX Events &amp; Competitions has announced the inaugural All Karachi University Table Tennis League and All Karachi College Table Tennis League, the city's first dedicated table tennis leagues for university and college students.</p>
  </div>
</section>

<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">THE LEAGUES</p>
    <h2 class="disp">Creating Experiences. Managing Competitions. Celebrating Excellence.</h2>

    <p class="lead">The leagues run from Saturday 5 to Sunday 20 December 2026, with matches on weekends only so players never miss classes. Each of the six match days is hosted by a different leading Karachi university, with free entry for spectators.</p>

    <p class="lead">Each league has five categories: men's (boys') team, women's (girls') team, men's (boys') singles, women's (girls') singles and mixed doubles. In a straight knockout format, every category narrows from 16 to 8, 4 and 2, until one All Karachi Champion is crowned on Finals Day, Sunday 20 December.</p>

    <p class="lead">Registration opens on Saturday 21 November and closes on Sunday 29 November 2026. Entry fees are PKR 1,500 per team, PKR 1,500 per mixed doubles pair and PKR 1,000 per singles player. Champions will receive trophies, medals and prize money, and every player receives an official certificate.</p>

    <blockquote style="margin:32px 0 0;padding:22px 24px;background:var(--ivory);border-left:4px solid var(--gold);border-radius:12px;font-size:17px;line-height:1.55;color:var(--navy);font-style:italic">
      "[Quote from APEX founder about why the leagues matter for Karachi's students.]"
      <cite style="display:block;margin-top:10px;color:var(--slate);font-size:14px;font-style:normal">— [Name], [Title], APEX Events &amp; Competitions</cite>
    </blockquote>

    <p class="lead" style="margin-top:28px">Sports departments can register at <a href="competitions.php#register"><?= e(setting('site_url','https://apexcompetitions.org')) ?>/competitions.php</a>. Sponsorship enquiries: <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a>.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">NEW: All Karachi Table Tennis Leagues</h2>
        <p>University &amp; College · Registration 21–29 Nov · 5–20 Dec</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-primary" href="competitions.php">League Details</a>
        <a class="btn btn-outline-ivory" href="contact.php">Contact APEX</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
