<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'All Karachi Table Tennis Leagues 2026 | APEX';
$pageDescription = 'University & College table tennis leagues in Karachi, 4–6 & 11–13 Dec 2026. 10 categories, 6 campuses, free for spectators. Register 25 Nov – 1 Dec.';
$pageSlug = 'home';

include __DIR__ . '/includes/header.php';
?>

<!-- HERO — banner recreated natively (headline, callouts, stylised paddle + ball SVG) -->
<section class="hero hero-league">
  <!-- Decorative diagonal accent strips, inspired by the poster's corner trims -->
  <span class="hero-accent hero-accent-tl" aria-hidden="true"></span>
  <span class="hero-accent hero-accent-br" aria-hidden="true"></span>

  <div class="hero-league-inner">
    <div class="hero-league-top reveal">
      <p class="eyebrow">APEX SPORTS · INAUGURAL SEASON · KARACHI</p>
      <p class="hero-sub-leagues">UNIVERSITY LEAGUE · COLLEGE LEAGUE</p>
    </div>

    <div class="hero-league-grid">
      <div class="hero-league-text reveal">
        <h1 class="hero-league-title">
          <span>All</span>
          <span>Karachi</span>
          <span class="accent-orange">Table Tennis</span>
          <span>League</span>
        </h1>
        <p class="hero-league-tagline"><i>Ten categories. One title to win:</i> <b>All Karachi Champion</b></p>

        <div class="hero-callouts">
          <div class="hero-callout">
            <p class="eyebrow gold">LEAGUE EVENT</p>
            <p class="hero-callout-date">4–6 &amp; 11–13 Dec 2026</p>
            <p class="hero-callout-sub">Friday to Sunday</p>
          </div>
          <div class="hero-callout">
            <p class="eyebrow gold">REGISTRATION</p>
            <p class="hero-callout-date">25 Nov – 1 Dec</p>
            <p class="hero-callout-sub">Wednesday to Tuesday</p>
          </div>
        </div>

        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="competitions.php#register">Register Your Team</a>
          <a class="btn btn-outline-ivory btn-lg" href="competitions.php">League Details</a>
        </div>
      </div>

      <!-- Stylised table-tennis illustration (SVG, built in-page — not a photo) -->
      <div class="hero-league-art reveal" aria-hidden="true">
        <svg viewBox="0 0 400 420" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
          <!-- soft stage glow -->
          <defs>
            <radialGradient id="stage" cx="50%" cy="60%" r="55%">
              <stop offset="0%" stop-color="#2E6DD6" stop-opacity=".55"/>
              <stop offset="60%" stop-color="#15253B" stop-opacity=".0"/>
            </radialGradient>
            <linearGradient id="table" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#1D3A66"/>
              <stop offset="100%" stop-color="#0E1A2B"/>
            </linearGradient>
            <linearGradient id="paddleRim" x1="0" y1="0" x2="1" y2="0">
              <stop offset="0%" stop-color="#8A1F0F"/>
              <stop offset="100%" stop-color="#C82E12"/>
            </linearGradient>
            <radialGradient id="paddleFace" cx="35%" cy="30%" r="80%">
              <stop offset="0%" stop-color="#F56E2E"/>
              <stop offset="60%" stop-color="#D9531A"/>
              <stop offset="100%" stop-color="#8A1F0F"/>
            </radialGradient>
            <radialGradient id="ball" cx="35%" cy="30%" r="70%">
              <stop offset="0%" stop-color="#FFFFFF"/>
              <stop offset="55%" stop-color="#F3EEDE"/>
              <stop offset="100%" stop-color="#B5B19D"/>
            </radialGradient>
          </defs>

          <!-- stage glow -->
          <circle cx="200" cy="230" r="220" fill="url(#stage)"/>

          <!-- Table surface + net (viewed almost head-on, perspective) -->
          <g transform="translate(40,260)">
            <polygon points="0,0 320,0 360,80 -40,80" fill="url(#table)" stroke="#2E6DD6" stroke-width="1.5" opacity=".92"/>
            <!-- centre line -->
            <line x1="160" y1="0" x2="160" y2="80" stroke="#8FB7E8" stroke-width="1" opacity=".55"/>
            <!-- net -->
            <rect x="-10" y="-14" width="340" height="18" fill="#0A1422" stroke="#2E6DD6" stroke-width="1.5"/>
            <g stroke="#6A86B0" stroke-width=".6" opacity=".7">
              <line x1="0" y1="-14" x2="0" y2="4"/>
              <line x1="20" y1="-14" x2="20" y2="4"/>
              <line x1="40" y1="-14" x2="40" y2="4"/>
              <line x1="60" y1="-14" x2="60" y2="4"/>
              <line x1="80" y1="-14" x2="80" y2="4"/>
              <line x1="100" y1="-14" x2="100" y2="4"/>
              <line x1="120" y1="-14" x2="120" y2="4"/>
              <line x1="140" y1="-14" x2="140" y2="4"/>
              <line x1="160" y1="-14" x2="160" y2="4"/>
              <line x1="180" y1="-14" x2="180" y2="4"/>
              <line x1="200" y1="-14" x2="200" y2="4"/>
              <line x1="220" y1="-14" x2="220" y2="4"/>
              <line x1="240" y1="-14" x2="240" y2="4"/>
              <line x1="260" y1="-14" x2="260" y2="4"/>
              <line x1="280" y1="-14" x2="280" y2="4"/>
              <line x1="300" y1="-14" x2="300" y2="4"/>
              <line x1="320" y1="-14" x2="320" y2="4"/>
            </g>
          </g>

          <!-- Paddle -->
          <g transform="translate(250,70) rotate(22)">
            <!-- handle -->
            <rect x="-10" y="150" width="20" height="120" rx="7" fill="#2A1510"/>
            <rect x="-6" y="160" width="12" height="100" rx="4" fill="#4A2B20"/>
            <!-- rim -->
            <ellipse cx="0" cy="90" rx="92" ry="92" fill="url(#paddleRim)"/>
            <!-- face -->
            <ellipse cx="0" cy="90" rx="84" ry="84" fill="url(#paddleFace)"/>
            <!-- subtle dots pattern on rubber -->
            <g fill="#8A1F0F" opacity=".35">
              <circle cx="-40" cy="60" r="2.3"/><circle cx="-20" cy="60" r="2.3"/>
              <circle cx="0" cy="60" r="2.3"/><circle cx="20" cy="60" r="2.3"/>
              <circle cx="40" cy="60" r="2.3"/>
              <circle cx="-50" cy="80" r="2.3"/><circle cx="-30" cy="80" r="2.3"/>
              <circle cx="-10" cy="80" r="2.3"/><circle cx="10" cy="80" r="2.3"/>
              <circle cx="30" cy="80" r="2.3"/><circle cx="50" cy="80" r="2.3"/>
              <circle cx="-40" cy="100" r="2.3"/><circle cx="-20" cy="100" r="2.3"/>
              <circle cx="0" cy="100" r="2.3"/><circle cx="20" cy="100" r="2.3"/>
              <circle cx="40" cy="100" r="2.3"/>
              <circle cx="-50" cy="120" r="2.3"/><circle cx="-30" cy="120" r="2.3"/>
              <circle cx="-10" cy="120" r="2.3"/><circle cx="10" cy="120" r="2.3"/>
              <circle cx="30" cy="120" r="2.3"/><circle cx="50" cy="120" r="2.3"/>
            </g>
            <!-- highlight -->
            <ellipse cx="-30" cy="55" rx="28" ry="18" fill="#FFFFFF" opacity=".15"/>
          </g>

          <!-- Ball with motion blur -->
          <g>
            <ellipse cx="110" cy="235" rx="28" ry="4" fill="#FFFFFF" opacity=".18"/>
            <circle cx="150" cy="235" r="18" fill="url(#ball)"/>
            <circle cx="150" cy="235" r="18" fill="none" stroke="#FFFFFF" stroke-width=".5" opacity=".6"/>
          </g>
        </svg>
      </div>
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

<!-- Two leagues -->
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
        <p class="eyebrow">A MESSAGE FROM OUR CEO</p>
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
