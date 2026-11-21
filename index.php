<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'All Karachi Table Tennis Leagues 2026 | APEX';
$pageDescription = 'University & College table tennis leagues in Karachi, 5–20 Dec 2026. 10 categories, 6 university campuses, free entry. Register 21–29 Nov.';
$pageSlug = 'home';

include __DIR__ . '/includes/header.php';
?>

<!-- Homepage banner (from PDF section 03) -->
<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">APEX SPORTS · INAUGURAL SEASON · KARACHI</p>
    <h1 class="disp">All Karachi Table Tennis Leagues · 5–20 December 2026</h1>
    <p class="lead">University League and College League. 10 categories, 6 university campuses, free entry for spectators. Registration: Saturday 21 – Sunday 29 November.</p>
    <div class="hero-actions">
      <a class="btn btn-primary btn-lg" href="competitions.php#register">Register Your Team</a>
      <a class="btn btn-outline-ivory btn-lg" href="competitions.php">League Details</a>
    </div>
  </div>
</section>

<!-- Tagline strip -->
<section style="background:var(--panel);color:var(--ivory);padding:18px 0">
  <div class="container text-center" style="letter-spacing:.14em;font-family:Archivo,sans-serif;font-stretch:108%;font-weight:600;font-size:13px">
    CREATING EXPERIENCES · MANAGING COMPETITIONS · CELEBRATING EXCELLENCE
  </div>
</section>

<!-- At a glance (from the League page) -->
<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">AT A GLANCE</p>
    <h2 class="disp">Two leagues, one city, one title to win.</h2>
    <p class="lead">APEX launches the All Karachi University Table Tennis League and the All Karachi College Table Tennis League, with team, singles and mixed doubles championships, played in a straight knockout format from Saturday 5 to Sunday 20 December 2026, on weekends only. Registration runs from Saturday 21 to Sunday 29 November 2026.</p>
  </div>

  <div class="container">
    <div class="grid grid-4 reveal" style="margin-top:24px">
      <div class="feature">
        <h3>5–20 Dec 2026</h3>
        <p>Three weekends. Matches on Saturdays and Sundays only.</p>
      </div>
      <div class="feature">
        <h3>5 categories</h3>
        <p>Men's &amp; women's team and singles, plus mixed doubles, in each league.</p>
      </div>
      <div class="feature">
        <h3>Format</h3>
        <p>Straight knockout: win and advance, lose and you're out.</p>
      </div>
      <div class="feature">
        <h3>Venues</h3>
        <p>6 leading university campuses across Karachi · free entry for spectators.</p>
      </div>
    </div>
  </div>
</section>

<!-- Two leagues short intro -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">CHOOSE YOUR LEAGUE</p>
      <h2 class="disp">Two Leagues for Karachi's Best Players</h2>
      <p class="lead">Each institution may enter all five categories of its league: team, singles and mixed doubles.</p>
    </div>
    <div class="grid grid-2 reveal">
      <article class="card" style="padding:28px">
        <h3 style="font-size:22px;margin:0 0 8px">All Karachi University Table Tennis League</h3>
        <p class="text-slate" style="margin:0 0 14px">For universities and degree-awarding institutes in Karachi. Represent your campus against the city's best university players.</p>
        <div style="display:grid;gap:6px;font-size:14px;color:var(--slate)">
          <div><b style="color:var(--navy)">Who:</b> Enrolled undergraduate and postgraduate students</div>
          <div><b style="color:var(--navy)">Categories:</b> Men's Team · Women's Team · Men's Singles · Women's Singles · Mixed Doubles</div>
          <div><b style="color:var(--navy)">Dates:</b> Sat 5 – Sun 20 December 2026 (weekends only)</div>
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team · PKR 1,500 per mixed pair · PKR 1,000 per singles player</div>
        </div>
        <a class="btn btn-primary" href="register-university.php" style="margin-top:18px;align-self:flex-start">Register for the University League</a>
      </article>
      <article class="card" style="padding:28px">
        <h3 style="font-size:22px;margin:0 0 8px">All Karachi College Table Tennis League</h3>
        <p class="text-slate" style="margin:0 0 14px">For intermediate and A Level colleges in Karachi. The city's first dedicated college table tennis league.</p>
        <div style="display:grid;gap:6px;font-size:14px;color:var(--slate)">
          <div><b style="color:var(--navy)">Who:</b> Enrolled Intermediate (FA, FSc, ICS, I.Com) and A Level students</div>
          <div><b style="color:var(--navy)">Categories:</b> Boys' Team · Girls' Team · Boys' Singles · Girls' Singles · Mixed Doubles</div>
          <div><b style="color:var(--navy)">Dates:</b> Sat 5 – Sun 20 December 2026 (weekends only)</div>
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team · PKR 1,500 per mixed pair · PKR 1,000 per singles player</div>
        </div>
        <a class="btn btn-primary" href="register-college.php" style="margin-top:18px;align-self:flex-start">Register for the College League</a>
      </article>
    </div>
  </div>
</section>

<!-- Closing CTA -->
<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <p class="eyebrow">REGISTRATION OPENS SATURDAY 21 NOVEMBER</p>
        <h2 class="disp">Get your teams ready.</h2>
        <p>Registration runs from Saturday 21 to Sunday 29 November 2026. One form covers all five categories of your league.</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-primary" href="competitions.php#register">Register Your Team</a>
        <a class="btn btn-outline-ivory" href="competitions.php">See full details</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
