<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'College & University Event Management | APEX';
$pageDescription = 'Convocations, orientation weeks, inter-university championships, debates, MUNs, hackathons and festivals managed by APEX.';

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">FOR COLLEGES &amp; UNIVERSITIES</p>
    <h1 class="disp">Campus Events That Match Your Ambition.</h1>
    <p class="lead">Convocations, championships, festivals and conferences managed with the professionalism your institution's name deserves.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="contact.php?interest=Organise%20a%20competition">Request a Proposal</a>
      <a class="btn btn-outline-ivory btn-lg" href="competitions.php">College Competitions</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">EVENTS WE MANAGE FOR COLLEGES AND UNIVERSITIES</p>
      <h2 class="disp">Built for campus-scale events</h2>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:12px">
        <?php foreach ([
          'Convocations and graduation ceremonies',
          'Orientation weeks and freshers\' events',
          'Inter-college and inter-university sports championships',
          'Debating championships, MUNs and hackathons',
          'Cultural festivals, concerts and society events',
          'Career fairs, conferences and seminars',
          'Recreational trips and study tours',
        ] as $it): ?>
          <li style="display:flex;gap:12px;align-items:flex-start;font-size:15px"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><?= $it ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">WORKING WITH STUDENT SOCIETIES</p>
      <h3 style="color:var(--ivory);margin:6px 0 14px">Structure meets the energy</h3>
      <p style="color:var(--mist);font-size:15px;line-height:1.6;margin:0">Student societies bring the energy; APEX brings the structure. We work alongside your society and faculty advisers on budgets, sponsorship decks, vendor management and on-the-day operations, while the students keep ownership and learn how a professional event is run.</p>
      <a class="btn btn-outline-ivory" href="contact.php?interest=Corporate%20event" style="margin-top:18px">Work with APEX</a>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">SIGNATURE EVENTS FOR CAMPUSES</p>
      <h2 class="disp">Campus favourites</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ([
        ['Convocation','Gown logistics, seating plans, protocol, chief guest and multi-stage rehearsals.'],
        ['Orientation Week','Welcome sessions, activity tracks, campus tours and keepsakes.'],
        ['Inter-University Sports','Fixtures, officials, medical cover, finals production and awards nights.'],
        ['MUN / Debate','Committee rooms, parliamentary and classical formats, adjudicators and awards.'],
        ['Cultural Festival','Night-scale production: stage, sound, lighting, security and media.'],
        ['Hackathon','24-hour production: workshops, mentors, judging, catering and closing ceremony.'],
      ] as $it): ?>
      <div class="feature">
        <h3><?= e($it[0]) ?></h3>
        <p><?= e($it[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">Convocation, MUN, festival — in planning?</h2>
        <p>Share your brief and we'll come back with a timeline and itemised budget your committee can act on.</p>
      </div>
      <a class="btn btn-gold" href="contact.php?interest=Annual%20day%20%2F%20convocation%20%2F%20ceremony">Request a Proposal</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
