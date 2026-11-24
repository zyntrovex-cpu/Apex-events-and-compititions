<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'All Karachi Table Tennis Leagues 2026 | APEX';
$pageDescription = 'University & College table tennis leagues in Karachi, 4–6 & 11–13 Dec 2026. 10 categories, 6 campuses, free for spectators. Register 25 Nov – 1 Dec.';
$pageSlug = 'home';

include __DIR__ . '/includes/header.php';
?>

<!-- Hero: poster-left + text-right, premium split layout -->
<section class="hero hero-split">
  <div class="hero-split-inner">
    <div class="hero-split-text reveal">
      <p class="eyebrow">APEX SPORTS · INAUGURAL SEASON · KARACHI</p>
      <h1 class="disp">All Karachi Table Tennis Leagues</h1>
      <p class="hero-dates"><b>4–6 &amp; 11–13 December 2026</b> · Friday to Sunday</p>
      <p class="lead">University League and College League. 10 categories, 6 university campuses, free entry for spectators. Registration: Wednesday 25 November – Tuesday 1 December.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="competitions.php#register">Register Your Team</a>
        <a class="btn btn-outline-ivory btn-lg" href="competitions.php">League Details</a>
      </div>
    </div>
    <div class="hero-split-image reveal">
      <img src="assets/images/tt-league-poster.jpg" alt="All Karachi Table Tennis League · University League · College League · Inaugural Season Karachi 2026 · 4–6 & 11–13 Dec · Registration 25 Nov – 1 Dec" loading="eager" fetchpriority="high">
    </div>
  </div>
</section>

<!-- Tagline strip -->
<section style="background:var(--panel);color:var(--ivory);padding:18px 0">
  <div class="container text-center" style="letter-spacing:.14em;font-family:Archivo,sans-serif;font-stretch:108%;font-weight:600;font-size:13px">
    CREATING EXPERIENCES · MANAGING COMPETITIONS · CELEBRATING EXCELLENCE
  </div>
</section>

<!-- At a glance -->
<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">AT A GLANCE</p>
    <h2 class="disp">Two leagues, one city, one title to win.</h2>
    <p class="lead">APEX launches the All Karachi University Table Tennis League and the All Karachi College Table Tennis League, with team, singles and mixed doubles championships, played in a straight knockout format on 4–6 and 11–13 December 2026, Friday to Sunday. Registration runs from Wednesday 25 November to Tuesday 1 December 2026.</p>
  </div>

  <div class="container">
    <div class="grid grid-4 reveal" style="margin-top:24px">
      <div class="feature">
        <h3>4–6 &amp; 11–13 Dec 2026</h3>
        <p>Two weekends. Matches on Fridays, Saturdays and Sundays.</p>
      </div>
      <div class="feature">
        <h3>10 categories</h3>
        <p>Men's &amp; women's team and singles, plus mixed doubles, in each league.</p>
      </div>
      <div class="feature">
        <h3>Straight knockout</h3>
        <p>Win and advance, lose and you're out — 16 → 8 → 4 → 2 → 1 Champion.</p>
      </div>
      <div class="feature">
        <h3>6 university campuses</h3>
        <p>Matches travel the city · free entry for spectators.</p>
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
          <div><b style="color:var(--navy)">Dates:</b> Fri 4 – Sun 6 and Fri 11 – Sun 13 December 2026</div>
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team · PKR 1,500 per mixed pair · PKR 1,000 per singles player</div>
        </div>
        <a class="btn btn-primary" href="competitions.php#register" style="margin-top:18px;align-self:flex-start">Register for the University League</a>
      </article>
      <article class="card" style="padding:28px">
        <h3 style="font-size:22px;margin:0 0 8px">All Karachi College Table Tennis League</h3>
        <p class="text-slate" style="margin:0 0 14px">For intermediate and A Level colleges in Karachi. The city's first dedicated college table tennis league.</p>
        <div style="display:grid;gap:6px;font-size:14px;color:var(--slate)">
          <div><b style="color:var(--navy)">Who:</b> Enrolled Intermediate (FA, FSc, ICS, I.Com) and A Level students</div>
          <div><b style="color:var(--navy)">Categories:</b> Boys' Team · Girls' Team · Boys' Singles · Girls' Singles · Mixed Doubles</div>
          <div><b style="color:var(--navy)">Dates:</b> Fri 4 – Sun 6 and Fri 11 – Sun 13 December 2026</div>
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team · PKR 1,500 per mixed pair · PKR 1,000 per singles player</div>
        </div>
        <a class="btn btn-primary" href="competitions.php#register" style="margin-top:18px;align-self:flex-start">Register for the College League</a>
      </article>
    </div>
  </div>
</section>

<!-- CEO Message -->
<section class="section">
  <div class="container reveal" style="max-width:920px">
    <div class="ceo-card">
      <div class="ceo-card-head">
        <p class="eyebrow dark">A MESSAGE FROM OUR CEO</p>
        <h2 class="disp">Welcome to the All Karachi Table Tennis League 2026</h2>
      </div>
      <div class="ceo-card-body">
        <p>Dear players, students, educators and table tennis fans,</p>
        <p>I'm proud to welcome you to the inaugural season of the All Karachi Table Tennis League, a competition we hope becomes a lasting tradition for this city.</p>
        <p>Karachi's universities and colleges are full of talented players who rarely get a real stage. We created this league to give them one: a structured, professionally run competition where students can test themselves against the best in the city, represent their institutions with pride, and compete for one title, All Karachi Champion.</p>
        <p>Registration is open from 25 November to 1 December 2026. I look forward to seeing you on court.</p>
        <p class="ceo-sign">With warm regards,<br><b>Muhammad Shahid</b><br>Chief Executive Officer<br>APEX Events &amp; Competitions</p>
      </div>
    </div>
  </div>
</section>

<!-- Closing CTA -->
<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <p class="eyebrow">REGISTRATION OPENS WEDNESDAY 25 NOVEMBER</p>
        <h2 class="disp">Get your teams ready.</h2>
        <p>Registration runs from Wednesday 25 November to Tuesday 1 December 2026. Download the team registration form, pay by QR code and send it back.</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-primary" href="competitions.php#register">Register Your Team</a>
        <a class="btn btn-outline-ivory" href="competitions.php">See full details</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
