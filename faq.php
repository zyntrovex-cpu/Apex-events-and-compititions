<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'FAQ | APEX Events & Competitions';
$pageDescription = 'Budgets, timelines, student safety, judging, certificates and registrations — answers for principals, coordinators and parents.';

try {
    $faqs = db()->query('SELECT * FROM faqs WHERE is_active=1 ORDER BY category, sort_order, id')->fetchAll();
    $grouped = [];
    foreach ($faqs as $f) { $grouped[$f['category']][] = $f; }
} catch (Throwable $e) { $grouped = []; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">FAQ</p>
    <h1 class="disp">Frequently Asked Questions</h1>
    <p class="lead">Answers to the questions principals, coordinators, student committees and parents ask most about APEX events, competitions and the APEX Card.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:920px;margin-left:auto;margin-right:auto">
    <?php foreach ($grouped as $cat => $items): ?>
      <div class="reveal" style="margin-bottom:28px">
        <p class="eyebrow dark"><?= e(strtoupper($cat)) ?></p>
        <div>
          <?php foreach ($items as $f): ?>
          <details class="acc">
            <summary><?= e($f['question']) ?></summary>
            <div class="body"><?= nl2br(e($f['answer'])) ?></div>
          </details>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="cta-band reveal" style="margin-top:36px">
      <div>
        <h2 class="disp">Still have questions?</h2>
        <p>Send a short enquiry and we'll get back to you within <?= e(setting('response_time','one working day')) ?>.</p>
      </div>
      <a class="btn btn-gold" href="contact.php">Contact Us</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
