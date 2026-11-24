<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'All Karachi Table Tennis Leagues 2026 | APEX';
$pageDescription = 'University & College table tennis leagues in Karachi, 4–6 & 11–13 Dec 2026. 10 categories, 6 campuses, free for spectators. Register 25 Nov – 1 Dec.';
$pageSlug = 'home';

include __DIR__ . '/includes/header.php';
?>

<!-- HERO — clean two-column layout: content left, table-tennis illustration right -->
<section class="hero hero-league">
  <div class="hero-league-inner">
    <div class="hero-league-grid">

      <div class="hero-league-text reveal">
        <p class="eyebrow">APEX SPORTS · INAUGURAL SEASON · KARACHI</p>
        <h1 class="disp hero-league-title">All Karachi Table Tennis <span class="accent-orange">League</span></h1>
        <p class="hero-league-sub">University League · College League · 10 categories, one title to win: <b>All Karachi Champion</b></p>
        <p class="lead hero-league-lead">Karachi's first dedicated university and college table tennis leagues. Team, singles and mixed doubles championships in a straight knockout format across two weekends.</p>

        <ul class="hero-info">
          <li>
            <span class="hero-info-label">LEAGUE EVENT</span>
            <span class="hero-info-value">4–6 &amp; 11–13 December 2026</span>
            <span class="hero-info-sub">Friday to Sunday · 6 university campuses</span>
          </li>
          <li>
            <span class="hero-info-label">REGISTRATION</span>
            <span class="hero-info-value">25 November – 1 December</span>
            <span class="hero-info-sub">Wednesday to Tuesday · Open now</span>
          </li>
        </ul>

        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="competitions.php#register">Register Your Team</a>
          <a class="btn btn-outline-ivory btn-lg" href="competitions.php">League Details</a>
        </div>
      </div>

      <!-- Original stylised SVG: table-tennis table with net, ball in flight -->
      <div class="hero-league-art reveal" aria-hidden="true">
        <svg viewBox="0 0 440 440" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Table tennis table with ball in play">
          <defs>
            <radialGradient id="glow" cx="50%" cy="55%" r="55%">
              <stop offset="0%" stop-color="#2E6DD6" stop-opacity=".45"/>
              <stop offset="70%" stop-color="#0E1A2B" stop-opacity="0"/>
            </radialGradient>
            <linearGradient id="tableTop" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#1F4B99"/>
              <stop offset="100%" stop-color="#15356E"/>
            </linearGradient>
            <linearGradient id="tableSide" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#0A1A3A"/>
              <stop offset="100%" stop-color="#050F22"/>
            </linearGradient>
            <radialGradient id="ballGrad" cx="35%" cy="30%" r="70%">
              <stop offset="0%" stop-color="#FFFFFF"/>
              <stop offset="60%" stop-color="#F0E8D6"/>
              <stop offset="100%" stop-color="#9F977F"/>
            </radialGradient>
          </defs>

          <!-- Soft stage glow behind -->
          <circle cx="220" cy="240" r="200" fill="url(#glow)"/>

          <!-- Isometric table (viewed slightly from above) -->
          <g>
            <!-- Table top with centre line -->
            <polygon points="90,230 350,230 400,290 40,290" fill="url(#tableTop)" stroke="#5AA1FF" stroke-width="1.5"/>
            <!-- Centre line (lane) -->
            <line x1="220" y1="230" x2="220" y2="290" stroke="#9CC7FF" stroke-width="1.5" opacity=".6"/>
            <!-- White table edge -->
            <polyline points="90,230 350,230 400,290 40,290 90,230" fill="none" stroke="#FFFFFF" stroke-width="2" opacity=".85"/>

            <!-- Side thickness -->
            <polygon points="40,290 400,290 400,300 40,300" fill="url(#tableSide)"/>

            <!-- Legs (simple trapezoids) -->
            <polygon points="70,300 100,300 105,370 75,370" fill="#0A1A3A"/>
            <polygon points="340,300 370,300 365,370 335,370" fill="#0A1A3A"/>
            <polygon points="195,300 245,300 240,340 200,340" fill="#0A1A3A" opacity=".65"/>

            <!-- Net posts -->
            <rect x="85" y="190" width="6" height="42" rx="2" fill="#F0F2F5"/>
            <rect x="349" y="190" width="6" height="42" rx="2" fill="#F0F2F5"/>
            <!-- Net mesh -->
            <rect x="91" y="194" width="258" height="38" fill="rgba(240,242,245,.08)" stroke="#F0F2F5" stroke-width="1"/>
            <g stroke="#F0F2F5" stroke-width=".5" opacity=".55">
              <line x1="91" y1="202" x2="349" y2="202"/>
              <line x1="91" y1="212" x2="349" y2="212"/>
              <line x1="91" y1="222" x2="349" y2="222"/>
              <line x1="105" y1="194" x2="105" y2="232"/>
              <line x1="125" y1="194" x2="125" y2="232"/>
              <line x1="145" y1="194" x2="145" y2="232"/>
              <line x1="165" y1="194" x2="165" y2="232"/>
              <line x1="185" y1="194" x2="185" y2="232"/>
              <line x1="205" y1="194" x2="205" y2="232"/>
              <line x1="225" y1="194" x2="225" y2="232"/>
              <line x1="245" y1="194" x2="245" y2="232"/>
              <line x1="265" y1="194" x2="265" y2="232"/>
              <line x1="285" y1="194" x2="285" y2="232"/>
              <line x1="305" y1="194" x2="305" y2="232"/>
              <line x1="325" y1="194" x2="325" y2="232"/>
            </g>
            <!-- Net top band -->
            <rect x="85" y="190" width="270" height="6" fill="#FFFFFF" opacity=".9"/>
          </g>

          <!-- Ball with trajectory arc and shadow -->
          <g opacity=".4">
            <path d="M 110 230 Q 170 60 290 140" fill="none" stroke="#F5C542" stroke-width="2" stroke-dasharray="4 5"/>
          </g>
          <!-- Ball shadow on table -->
          <ellipse cx="300" cy="250" rx="18" ry="3" fill="#0A1422" opacity=".55"/>
          <!-- The ball itself, in flight above the table -->
          <circle cx="290" cy="140" r="18" fill="url(#ballGrad)"/>
          <circle cx="290" cy="140" r="18" fill="none" stroke="#FFFFFF" stroke-width=".8" opacity=".5"/>
          <circle cx="284" cy="134" r="4" fill="#FFFFFF" opacity=".7"/>
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
