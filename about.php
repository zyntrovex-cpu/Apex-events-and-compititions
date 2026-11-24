<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'About · APEX Events & Competitions';
$pageDescription = 'APEX Events & Competitions launches the All Karachi University and College Table Tennis Leagues, the city\'s first dedicated table tennis leagues for university and college students.';

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">ABOUT</p>
    <h1 class="disp">APEX Launches the All Karachi University &amp; College Table Tennis Leagues</h1>
    <p class="hero-dates"><b>4–6 &amp; 11–13 December 2026</b> · Finals Day Sunday 13 December</p>
    <p class="lead">APEX Events &amp; Competitions has announced the inaugural All Karachi University Table Tennis League and All Karachi College Table Tennis League, the city's first dedicated table tennis leagues for university and college students.</p>
  </div>
</section>

<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">THE LEAGUES</p>
    <h2 class="disp">Creating Experiences. Managing Competitions. Celebrating Excellence.</h2>

    <p class="lead">The leagues run on 4–6 and 11–13 December 2026, with matches from Friday to Sunday over two weekends. Each of the six match days is hosted by a different leading Karachi university, with free entry for spectators.</p>

    <p class="lead">Each league has five categories: men's (boys') team, women's (girls') team, men's (boys') singles, women's (girls') singles and mixed doubles. In a straight knockout format, every category narrows from 16 to 8, 4 and 2, until one All Karachi Champion is crowned on Finals Day, Sunday 13 December.</p>

    <p class="lead">Registration opens on Wednesday 25 November and closes on Tuesday 1 December 2026. Entry fees are PKR 1,500 per team, PKR 1,500 per mixed doubles pair and PKR 1,000 per singles player. Champions will receive trophies, medals and prize money, and every player receives an official certificate.</p>

    <p class="lead">Sports departments can register at <a href="competitions.php#register"><?= e(setting('site_url','https://apexcompetitions.org')) ?>/competitions.php</a>. For queries and sponsorship enquiries, WhatsApp 0320 2051914 or 0325 2804916, or follow our WhatsApp channel.</p>
  </div>
</section>

<section class="section section-panel" style="background:#fff">
  <div class="container reveal" style="max-width:920px">
    <div class="ceo-card" style="box-shadow:var(--shadow-lg)">
      <div class="ceo-card-head">
        <p class="eyebrow">A MESSAGE FROM OUR CEO</p>
        <h2 class="disp">Welcome to the All Karachi Table Tennis League 2026</h2>
      </div>
      <div class="ceo-card-body">
        <p>Dear players, students, educators and table tennis fans,</p>

        <p>I'm proud to welcome you to the inaugural season of the All Karachi Table Tennis League, a competition we hope becomes a lasting tradition for this city.</p>

        <p>Karachi's universities and colleges are full of talented players who rarely get a real stage. We created this league to give them one: a structured, professionally run competition where students can test themselves against the best in the city, represent their institutions with pride, and compete for one title, All Karachi Champion.</p>

        <p><b style="color:var(--navy)">What the league offers</b><br>
        This season includes two leagues, a University League and a College League, across ten categories: Men's/Boys' and Women's/Girls' Team and Singles, plus Mixed Doubles. Matches will be played on 4–6 and 11–13 December 2026 at six university campuses across Karachi, in a straight knockout format leading to Finals Day on Sunday 13 December.</p>

        <p><b style="color:var(--navy)">Our commitment to you</b><br>
        We've built this league on three principles: fairness, quality and access. Every match is played under the official laws of the Pakistan Table Tennis Federation and the International Table Tennis Federation. APEX provides the rackets, balls and neutral umpires for every match, so every player competes on equal terms. Entry for spectators is free, because a great competition deserves a great crowd.</p>

        <p><b style="color:var(--navy)">An invitation</b><br>
        To every team, pair and player thinking of taking part: register, prepare, and come ready to compete. Play hard, play fair, and enjoy every moment at the table. To families, classmates and fans: come along and cheer them on.</p>

        <p>Registration is open from 25 November to 1 December 2026. I look forward to seeing you on court.</p>

        <p class="ceo-sign">With warm regards,<br><b>Muhammad Shahid</b><br>Chief Executive Officer<br>APEX Events &amp; Competitions</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">NEW: All Karachi Table Tennis Leagues</h2>
        <p>University &amp; College · Register by 1 Dec · 4–6 &amp; 11–13 Dec</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-primary" href="competitions.php">League Details</a>
        <a class="btn btn-outline-ivory" href="contact.php">Contact APEX</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
