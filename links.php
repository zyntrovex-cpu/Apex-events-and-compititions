<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'APEX Links | All APEX Pages';
$pageDescription = 'Quick access to every APEX page — Calendar, Past Events, Partners, Sponsorship, APEX Card, Request a Proposal.';

try {
    $socials = social_links_all();
} catch (Throwable $e) { $socials = []; }

include __DIR__ . '/includes/header.php';

$quick = [
    ['Upcoming Competitions','calendar.php','Browse open registrations and see dates and venues.','event'],
    ['Register Your Team','calendar.php','Pick a competition and register your institution\'s team.','register'],
    ['Request a Proposal','contact.php','Tell APEX about your next event and get a tailored proposal.','proposal'],
    ['APEX Card','apex-card.php','One card, savings on learning all year.','card'],
    ['Partner Directory','partners.php','Institutions, sponsors, APEX Card partners and services.','partners'],
    ['Become a Partner','partners.php#join','Join the APEX partner network.','partner'],
    ['Sponsorship','sponsorship.php','Title, gold, silver and category sponsorship tiers.','sponsor'],
    ['Past Events','past-events.php','Competitions, ceremonies and festivals we have delivered.','past'],
    ['Events &amp; Services','events.php','Every event service APEX offers for institutions.','services'],
    ['Competitions','competitions.php','Categories, signature championships and how it works.','comp'],
    ['FAQ','faq.php','Answers for principals, coordinators and parents.','faq'],
    ['About APEX','about.php','Our story, mission, values and team.','about'],
];
?>

<section class="hero">
  <div class="hero-inner reveal" style="text-align:center;max-width:700px;margin-left:auto;margin-right:auto">
    <div style="display:inline-flex;align-items:center;gap:10px;background:var(--panel);padding:10px 16px;border-radius:999px;margin-bottom:22px">
      <svg viewBox="0 0 120 110" width="30" height="27" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#F6F3EC"/></svg>
      <span style="font-family:Archivo,sans-serif;font-weight:700;letter-spacing:.14em;font-size:14px">APEX LINKS</span>
    </div>
    <h1 class="disp">All the APEX pages, in one place.</h1>
    <p class="lead">Quick links to our competitions, events, APEX Card and sponsorship pages.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:720px;margin-left:auto;margin-right:auto">
    <div class="grid reveal" style="gap:12px">
      <?php foreach ($quick as $q): ?>
      <a href="<?= e($q[1]) ?>" class="card" style="padding:20px;display:flex;gap:18px;align-items:center;text-decoration:none;color:var(--navy)">
        <div style="width:48px;height:48px;border-radius:12px;background:var(--navy);color:var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        </div>
        <div style="flex:1">
          <h3 style="font-size:16px;margin:0 0 4px"><?= $q[0] ?></h3>
          <p style="font-size:13.5px;color:var(--slate);margin:0"><?= $q[2] ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <?php if ($socials): ?>
    <div style="margin-top:36px">
      <p class="eyebrow dark" style="text-align:center">FOLLOW APEX</p>
      <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-top:14px">
        <?php foreach ($socials as $s): ?>
          <a class="btn btn-ghost btn-sm" href="<?= e($s['url']) ?>" target="_blank" rel="noopener"><?= e($s['label']) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
