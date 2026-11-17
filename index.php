<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'APEX | School & College Event and Competition Management';
$pageDescription = 'Inter-school quiz, debate, science and sports competitions, plus annual days, convocations and festivals — organised and judged by APEX.';
$pageSlug = 'home';

try {
    $catStmt = db()->query('SELECT id,name,slug,description FROM competition_categories WHERE is_active=1 ORDER BY sort_order LIMIT 6');
    $competitionCategories = $catStmt->fetchAll();
    $featured = db()->query("SELECT id,name,slug,city,event_date,registration_status,category_id FROM competitions WHERE is_featured=1 AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3")->fetchAll();
    $featuredCats = [];
    foreach ($featured as $f) { $featuredCats[$f['category_id']] = null; }
    if ($featuredCats) {
        $in = implode(',', array_fill(0, count($featuredCats), '?'));
        $s = db()->prepare("SELECT id,name FROM competition_categories WHERE id IN ($in)");
        $s->execute(array_keys($featuredCats));
        foreach ($s->fetchAll() as $r) $featuredCats[$r['id']] = $r['name'];
    }
    $pastEvents = db()->query('SELECT id,name,slug,city,institution,event_date,category,summary,cover_image FROM portfolio_items WHERE is_published=1 ORDER BY event_date DESC LIMIT 3')->fetchAll();
    $testimonials = db()->query('SELECT quote,author_name,author_role,author_institution FROM testimonials WHERE is_active=1 ORDER BY is_featured DESC, sort_order LIMIT 3')->fetchAll();
} catch (Throwable $e) {
    $competitionCategories = $featured = $pastEvents = $testimonials = []; $featuredCats = [];
}

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">WHERE EVERY STUDENT GETS A STAGE</p>
    <h1 class="disp">Where Every Student<br>Gets a Stage.</h1>
    <p class="lead">APEX Events &amp; Competitions organises, judges and manages competitions and events for schools, colleges, universities and institutions — from inter-school quiz, debate, science and sports championships to annual days, convocations and cultural festivals.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="competitions.php">Explore Competitions</a>
      <a class="btn btn-outline-ivory btn-lg" href="contact.php">Request a Proposal</a>
    </div>
  </div>
</section>

<!-- Tagline strip -->
<section style="background:var(--panel);color:var(--ivory);padding:18px 0">
  <div class="container text-center" style="letter-spacing:.14em;font-family:Archivo,sans-serif;font-stretch:108%;font-weight:600;font-size:13px">
    CREATING EXPERIENCES · MANAGING COMPETITIONS · CELEBRATING EXCELLENCE
  </div>
</section>

<!-- Introduction -->
<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">INTRODUCTION</p>
      <h2 class="disp">Built for Schools, Colleges and Institutions</h2>
      <p class="lead">Teachers and administrators already carry full timetables. Organising a sports gala, an inter-school quiz or a convocation on top of that takes weeks of extra work — permissions, venues, judges, schedules, certificates, parents, media and a hundred small details.</p>
      <p class="lead">APEX takes that load off your staff. We are a specialist team focused only on educational events and competitions, so we understand academic calendars, student safety, fair judging and the pride every institution feels on its big day. You stay in control of the vision; we handle everything that makes it happen.</p>
      <div class="hero-actions" style="margin-top:20px">
        <a class="btn btn-navy" href="about.php">About APEX</a>
        <a class="btn btn-outline" href="contact.php">Talk to Our Team</a>
      </div>
    </div>
    <div class="card card-navy" style="padding:32px">
      <p class="eyebrow">WHY INSTITUTIONS TRUST APEX</p>
      <div class="grid grid-2" style="gap:14px;margin-top:14px">
        <div style="background:var(--panel);border-radius:12px;padding:16px">
          <h3 style="color:var(--ivory);margin:0 0 6px;font-size:16px">Education specialists</h3>
          <p style="color:var(--mist);font-size:13.5px;margin:0">We work only with schools, colleges and institutions, so our plans fit your calendar, culture and rules.</p>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px">
          <h3 style="color:var(--ivory);margin:0 0 6px;font-size:16px">Student safety first</h3>
          <p style="color:var(--mist);font-size:13.5px;margin:0">Supervised zones, trained staff, first aid and clear parent communication at every event.</p>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px">
          <h3 style="color:var(--ivory);margin:0 0 6px;font-size:16px">Fair competitions</h3>
          <p style="color:var(--mist);font-size:13.5px;margin:0">Published rules, independent judges, scoring rubrics and transparent results protect your reputation.</p>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px">
          <h3 style="color:var(--ivory);margin:0 0 6px;font-size:16px">Budget-friendly</h3>
          <p style="color:var(--mist);font-size:13.5px;margin:0">Itemised proposals with no hidden costs, scaled to school and college budgets.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured competitions -->
<section class="section-sm" style="background:var(--white)">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">FEATURED COMPETITIONS</p>
      <h2 class="disp">Competitions That Bring Out the Best</h2>
      <p class="lead">Competitions are at the heart of APEX. We design formats, write rules, brief judges, score fairly and celebrate winners — for a single school or a city-wide championship.</p>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach (array_slice($competitionCategories, 0, 6) as $c): ?>
      <a href="competitions.php#cat-<?= e($c['slug']) ?>" class="cat-card">
        <span class="num">COMPETITION</span>
        <h3><?= e($c['name']) ?></h3>
        <p><?= e(mb_strimwidth($c['description'] ?? '', 0, 140, '…')) ?></p>
        <span class="tag">See competitions →</span>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="hero-actions" style="margin-top:28px">
      <a class="btn btn-navy" href="competitions.php">See All Competitions</a>
      <a class="btn btn-outline" href="calendar.php">Register Your Institution</a>
    </div>
  </div>
</section>

<!-- APEX Card promo band -->
<section class="section-sm">
  <div class="container">
    <div class="cta-band reveal" style="background:linear-gradient(135deg,var(--navy),var(--panel));position:relative;overflow:hidden">
      <div style="position:absolute;right:-60px;top:-60px;width:240px;height:240px;background:radial-gradient(circle,rgba(212,166,58,.18),transparent 60%);pointer-events:none"></div>
      <div style="position:relative;max-width:620px">
        <p class="eyebrow">APEX CARD</p>
        <h2 class="disp">Introducing the APEX Card</h2>
        <p>One card, savings on learning all year: discounts on APEX competitions, partner academies, books, stationery, courses and more. Available for students, families and whole institutions.</p>
      </div>
      <div style="position:relative;display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-gold" href="apex-card.php#apply">Get Your APEX Card</a>
        <a class="btn btn-outline-ivory" href="apex-card.php">See all benefits</a>
      </div>
    </div>
  </div>
</section>

<!-- Who We Serve -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px;text-align:center;margin-left:auto;margin-right:auto">
      <p class="eyebrow dark">WHO WE SERVE</p>
      <h2 class="disp">Who We Work With</h2>
    </div>
    <div class="grid grid-4 reveal">
      <div class="feature">
        <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 4 2 10l10 6 10-6z"/><path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg></div>
        <h3>Schools</h3>
        <p>Primary, middle and high schools, including school systems and campus networks.</p>
      </div>
      <div class="feature">
        <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V8l7-4 7 4v13"/><path d="M9 21v-6h6v6"/></svg></div>
        <h3>Colleges</h3>
        <p>Intermediate, degree and professional colleges, including cadet and technical colleges.</p>
      </div>
      <div class="feature">
        <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></div>
        <h3>Universities</h3>
        <p>Public and private universities, their departments, faculties and student societies.</p>
      </div>
      <div class="feature">
        <div class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7l9-4 9 4"/><path d="M4 7v13h16V7"/><path d="M9 20v-6h6v6"/></svg></div>
        <h3>Institutions &amp; Academies</h3>
        <p>Coaching academies, education boards, NGOs, foundations and training institutes.</p>
      </div>
    </div>
  </div>
</section>

<!-- Events overview -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">EVENTS OVERVIEW</p>
      <h2 class="disp">Events We Manage</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php
      $eventRows = [
        ['Academic Competitions','Quiz, debate, spelling bee, MUN, science fairs, robotics, coding — with fair, transparent judging.'],
        ['Sports Tournaments &amp; Sports Days','Inter-school and inter-college tournaments, sports galas and annual sports days.'],
        ['Annual Days, Convocations &amp; Ceremonies','Annual days, prize distributions, result days, graduations and convocations.'],
        ['Cultural Festivals &amp; Talent Shows','Cultural weeks, talent hunts, drama, music and art competitions.'],
        ['Exhibitions &amp; Education Expos','Science and art exhibitions, career fairs, open days and education expos.'],
        ['Seminars, Orientations &amp; Workshops','Orientation weeks, parent sessions, teacher training and education conferences.'],
      ];
      foreach ($eventRows as $r): ?>
      <div class="feature">
        <h3><?= $r[0] ?></h3>
        <p><?= $r[1] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="hero-actions" style="margin-top:24px">
      <a class="btn btn-navy" href="events.php">View All Events</a>
      <a class="btn btn-ghost" href="educational-trips.php">Educational Trips</a>
    </div>
  </div>
</section>

<!-- How we work -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">HOW WE WORK</p>
      <h2 class="disp">From Idea to Prize Distribution in Five Steps</h2>
    </div>
    <div class="steps reveal">
      <div class="step"><div class="n">01</div><div><h3>Discover</h3><p>We meet your principal or event committee to understand goals, dates, student numbers and budget.</p></div></div>
      <div class="step"><div class="n">02</div><div><h3>Design</h3><p>We propose the format, rules, schedule and an itemised budget that fits your academic calendar.</p></div></div>
      <div class="step"><div class="n">03</div><div><h3>Plan</h3><p>Venue, permissions, invitations, registrations, judges, trophies, branding and logistics are confirmed.</p></div></div>
      <div class="step"><div class="n">04</div><div><h3>Deliver</h3><p>Our on-ground team runs setup, student flow, schedules, judging, guests and every live moment.</p></div></div>
      <div class="step"><div class="n">05</div><div><h3>Celebrate &amp; Review</h3><p>Results, certificates, photos and a short report with recommendations for next year.</p></div></div>
    </div>
  </div>
</section>

<!-- Numbers band -->
<section class="section-sm section-navy">
  <div class="container">
    <div class="grid grid-4 reveal" style="text-align:center">
      <div><div style="font-family:Archivo,sans-serif;font-weight:800;font-size:40px;color:var(--gold)" data-count="50" data-suffix="+">50+</div><p>Institutions Served</p></div>
      <div><div style="font-family:Archivo,sans-serif;font-weight:800;font-size:40px;color:var(--gold)" data-count="120" data-suffix="+">120+</div><p>Competitions Managed</p></div>
      <div><div style="font-family:Archivo,sans-serif;font-weight:800;font-size:40px;color:var(--gold)" data-count="12000" data-suffix="+">12,000+</div><p>Students Participated</p></div>
      <div><div style="font-family:Archivo,sans-serif;font-weight:800;font-size:40px;color:var(--gold)" data-count="8" data-suffix="+">8+</div><p>Cities</p></div>
    </div>
    <p style="text-align:center;color:var(--mist);font-size:13px;margin:24px 0 0;opacity:.7">Figures shown are placeholders until confirmed by your administrator.</p>
  </div>
</section>

<!-- Featured upcoming competitions -->
<?php if ($featured): ?>
<section class="section">
  <div class="container">
    <div class="reveal" style="display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end;justify-content:space-between;margin-bottom:28px">
      <div style="max-width:680px">
        <p class="eyebrow dark">UPCOMING</p>
        <h2 class="disp">Featured Upcoming Competitions</h2>
        <p class="lead">Register your institution for an APEX championship or inter-school round. Dates, fees and venues become final once your administrator confirms them.</p>
      </div>
      <a class="btn btn-navy" href="calendar.php">Full Calendar</a>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($featured as $f):
        $status = $f['registration_status'];
        $badge = ['open'=>['badge-open','Registration open'],'closing_soon'=>['badge-soon','Closing soon'],'closed'=>['badge-closed','Closed'],'coming_soon'=>['badge-coming','Coming soon']][$status] ?? ['badge-open','Open'];
      ?>
      <article class="ev-card">
        <div class="ev-photo"><div class="ph"><svg viewBox="0 0 120 110" width="64" height="59" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#263A57"/></svg><span><?= e($featuredCats[$f['category_id']] ?? 'Competition') ?></span></div><span class="badge-cat"><?= e($featuredCats[$f['category_id']] ?? 'Competition') ?></span></div>
        <div class="ev-body">
          <div class="meta"><?= e(format_date($f['event_date'])) ?> · <?= e($f['city'] ?: 'Multiple cities') ?></div>
          <h3><?= e($f['name']) ?></h3>
          <span class="badge <?= e($badge[0]) ?>" style="align-self:flex-start;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600"><?= e($badge[1]) ?></span>
          <div class="actions">
            <a class="btn btn-navy btn-sm" href="calendar.php?competition=<?= urlencode($f['slug']) ?>">View &amp; Register</a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Featured past events -->
<?php if ($pastEvents): ?>
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="display:flex;flex-wrap:wrap;gap:14px;align-items:flex-end;justify-content:space-between;margin-bottom:28px">
      <div style="max-width:680px">
        <p class="eyebrow dark">FEATURED PAST EVENTS</p>
        <h2 class="disp">Moments We've Made</h2>
        <p class="lead">A selection of the competitions, ceremonies, tournaments and festivals APEX has managed for schools, colleges and universities.</p>
      </div>
      <a class="btn btn-navy" href="past-events.php">All Past Events</a>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($pastEvents as $p): ?>
      <article class="ev-card">
        <div class="ev-photo">
          <?php if ($p['cover_image']): ?>
            <img src="<?= e($p['cover_image']) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="ph"><svg viewBox="0 0 120 110" width="64" height="59" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#263A57"/></svg><span>Photos to be added</span></div>
          <?php endif; ?>
          <span class="badge-cat"><?= e($p['category']) ?></span>
        </div>
        <div class="ev-body">
          <div class="meta"><?= e(format_date($p['event_date'])) ?> · <?= e($p['institution']) ?>, <?= e($p['city']) ?></div>
          <h3><?= e($p['name']) ?></h3>
          <p><?= e(mb_strimwidth($p['summary'] ?? '', 0, 140, '…')) ?></p>
          <div class="actions"><a class="btn btn-ghost btn-sm" href="past-events.php?event=<?= urlencode($p['slug']) ?>">See details</a></div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Testimonials -->
<?php if ($testimonials): ?>
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">TESTIMONIALS</p>
      <h2 class="disp">What Principals and Coordinators Say</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($testimonials as $t): ?>
      <blockquote class="card" style="padding:28px;margin:0;display:flex;flex-direction:column;gap:14px">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
        <p style="font-size:16px;line-height:1.55;color:var(--navy);font-style:italic">“<?= e($t['quote']) ?>”</p>
        <cite style="font-style:normal;color:var(--slate);font-size:14px"><b style="color:var(--navy)"><?= e($t['author_name']) ?></b><br><?= e($t['author_role']) ?><?php if ($t['author_institution']) echo ' · ' . e($t['author_institution']); ?></cite>
      </blockquote>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Closing CTA -->
<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <p class="eyebrow">PLAN YOUR NEXT EVENT</p>
        <h2 class="disp">Planning Your Next Annual Day, Tournament or Competition?</h2>
        <p>Tell us what your institution has in mind — a competition, a championship or a big event — and we will come back with a format, a timeline and a clear, itemised proposal.</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-gold" href="contact.php">Request a Free Consultation</a>
        <?php $wa = preg_replace('/[^0-9]/','',setting('contact_whatsapp')); ?>
        <a class="btn btn-outline-ivory" href="https://wa.me/<?= e($wa) ?>" target="_blank" rel="noopener">WhatsApp Us</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
