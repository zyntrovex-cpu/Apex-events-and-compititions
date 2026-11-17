<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'School & College Event Management Services | APEX';
$pageDescription = 'Academic competitions, sports tournaments, annual days, convocations, exhibitions, cultural festivals and full event production for educational institutions.';

try {
    $events = db()->query('SELECT e.*, ec.name AS category_name FROM events e LEFT JOIN event_categories ec ON ec.id=e.category_id WHERE e.is_active=1 ORDER BY e.sort_order')->fetchAll();
} catch (Throwable $e) { $events = []; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">EVENTS (SERVICES)</p>
    <h1 class="disp">Every Event on Your Academic Calendar. Managed Professionally.</h1>
    <p class="lead">Competitions first, events always. Choose a single service or let APEX manage your event from concept to prize distribution.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="contact.php?interest=Organise%20a%20competition">Request a Proposal</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="gap:28px">
      <?php foreach ($events as $ev):
        $deliverables = array_filter(array_map('trim', explode('|', $ev['deliverables'] ?? ''))); ?>
      <article class="card reveal" id="<?= e($ev['slug']) ?>" style="padding:0">
        <div class="grid" style="grid-template-columns:1.2fr 1fr;gap:0">
          <div style="padding:32px clamp(20px,3vw,36px)">
            <p class="eyebrow dark"><?= e($ev['category_name'] ?? 'Service') ?></p>
            <h2 class="disp"><?= $ev['name'] ?></h2>
            <p class="lead" style="margin-bottom:18px"><?= e($ev['description']) ?></p>
            <?php if ($deliverables): ?>
            <h3 style="font-size:12px;letter-spacing:.2em;color:var(--dgold);margin-bottom:14px;font-family:Inter,sans-serif;text-transform:uppercase">What we deliver</h3>
            <ul style="list-style:none;padding:0;margin:0 0 18px;display:grid;gap:8px">
              <?php foreach ($deliverables as $d): ?>
                <li style="display:flex;gap:10px;align-items:flex-start;color:var(--slate);font-size:14.5px"><span style="color:var(--gold);font-weight:700">›</span><span><?= e($d) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <p style="font-size:14px;color:var(--navy);margin:0"><b>Ideal for:</b> <span style="color:var(--slate)"><?= e($ev['ideal_for']) ?></span></p>
            <div style="margin-top:20px"><a class="btn btn-navy" href="contact.php?interest=<?= urlencode($ev['headline']) ?>">Request a proposal</a></div>
          </div>
          <div style="background:linear-gradient(135deg,var(--navy),var(--panel));padding:32px;color:var(--ivory);display:flex;flex-direction:column;justify-content:center;gap:16px">
            <svg viewBox="0 0 120 110" width="88" height="80" aria-hidden="true" style="opacity:.3;align-self:flex-end"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#F6F3EC"/></svg>
            <div>
              <p class="eyebrow">APEX SERVICE</p>
              <h3 style="color:var(--ivory);margin:6px 0 10px;font-size:22px"><?= e($ev['headline']) ?></h3>
              <p style="color:var(--mist);font-size:14.5px;margin:0">Published rules, independent judges, transparent results.</p>
            </div>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <p style="margin-top:24px;color:var(--slate);font-size:14.5px">Also available: supervised educational trips and study tours. <a href="educational-trips.php">See Educational Trips →</a></p>

    <div class="cta-band reveal" style="margin-top:32px">
      <div>
        <h2 class="disp">Not sure which service you need?</h2>
        <p>Tell us what your institution is planning — we will recommend the right format, scale and budget.</p>
      </div>
      <a class="btn btn-gold" href="contact.php">Talk to Our Team</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
