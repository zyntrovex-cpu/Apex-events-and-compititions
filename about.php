<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'About APEX | Education Event Management Specialists';
$pageDescription = 'APEX Events & Competitions helps schools, colleges and institutions run safe, well-organised events and fair, inspiring competitions.';

try {
    $team = db()->query('SELECT name,role,bio,photo FROM team_members WHERE is_active=1 ORDER BY sort_order')->fetchAll();
} catch (Throwable $e) { $team = []; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">ABOUT US</p>
    <h1 class="disp">Helping Institutions Bring Out the Best in Their Students.</h1>
    <p class="lead">APEX Events &amp; Competitions is an event and competition management company dedicated to schools, colleges, universities and educational institutions.</p>
  </div>
</section>

<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">OUR STORY</p>
      <h2 class="disp">Our Story</h2>
      <p class="lead">APEX began with a simple belief: students grow when they are given a stage. A quiz final, a debate, a sports trophy or a moment in the spotlight at an annual day can build confidence that lasts a lifetime. Yet institutions often struggle to organise these events alongside teaching, exams and administration.</p>
      <p class="lead">We set out to become the partner they could rely on. Today APEX helps schools, colleges and universities plan and run competitions, ceremonies, tournaments and festivals that are safe, well-organised and genuinely inspiring. Our name reflects our standard: every student, and every event, deserves to reach its highest point.</p>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">MISSION &amp; VISION</p>
      <h3 style="color:var(--ivory);margin:12px 0 6px">Our Mission</h3>
      <p style="color:var(--mist);font-size:15px;line-height:1.6;margin:0 0 18px">To give every student the chance to compete, perform and be celebrated, by delivering safe, fair and memorable events and competitions for educational institutions.</p>
      <h3 style="color:var(--ivory);margin:0 0 6px">Our Vision</h3>
      <p style="color:var(--mist);font-size:15px;line-height:1.6;margin:0">To become the most trusted event and competition partner for schools, colleges and universities, raising the standard of how institutions celebrate talent and achievement.</p>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">OUR VALUES</p>
      <h2 class="disp">What We Stand For</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ([
        ['Student First','Every decision starts with the safety, dignity and experience of the students.'],
        ['Fair Play','Clear rules, impartial judges and transparent results, always.'],
        ['Excellence','We hold every detail to the highest standard, because institutions trust us with their name.'],
        ['Reliability','We plan for the unexpected so principals and teachers never have to.'],
        ['Celebration','Effort and achievement deserve to be recognised, loudly and proudly.'],
        ['Integrity','We say what we will do, we show what we did, and we keep our promises in writing.'],
      ] as $v): ?>
      <div class="feature">
        <h3><?= e($v[0]) ?></h3>
        <p><?= e($v[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ($team): ?>
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">OUR TEAM</p>
      <h2 class="disp">The People Behind APEX</h2>
      <p class="lead">Our team brings together event planners, competition coordinators, production specialists, designers and on-ground managers with experience in educational settings.</p>
    </div>
    <div class="grid grid-4 reveal">
      <?php foreach ($team as $m): ?>
      <div class="card" style="padding:0;text-align:center">
        <div style="aspect-ratio:1/1;background:var(--navy);overflow:hidden;display:flex;align-items:center;justify-content:center;color:var(--gold);font-family:Archivo,sans-serif;font-weight:800;font-size:32px">
          <?php if ($m['photo']): ?><img src="<?= e($m['photo']) ?>" alt="<?= e($m['name']) ?>" style="width:100%;height:100%;object-fit:cover"><?php else: echo e(strtoupper(substr($m['name'], 0, 1))); endif; ?>
        </div>
        <div style="padding:16px">
          <h3 style="margin:0 0 4px;font-size:16px"><?= e($m['name']) ?></h3>
          <div style="color:var(--dgold);font-size:13px;font-weight:600;letter-spacing:.14em;text-transform:uppercase"><?= e($m['role']) ?></div>
          <?php if ($m['bio']): ?><p style="margin:8px 0 0;font-size:13.5px;color:var(--slate);line-height:1.5"><?= e($m['bio']) ?></p><?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">Work with APEX</h2>
        <p>Partner with the team dedicated to giving every student a stage.</p>
      </div>
      <a class="btn btn-gold" href="contact.php">Talk to Our Team</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
