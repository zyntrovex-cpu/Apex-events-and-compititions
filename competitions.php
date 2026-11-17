<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Inter-School & Inter-College Competitions | APEX';
$pageDescription = 'Quiz, debate, olympiads, robotics, sports, arts and talent competitions for schools and colleges — fair judging, certificates and trophies.';

try {
    $categories = db()->query('SELECT id,name,slug,description FROM competition_categories WHERE is_active=1 ORDER BY sort_order')->fetchAll();
    $upcoming = db()->query("SELECT c.*,cc.name AS category_name FROM competitions c LEFT JOIN competition_categories cc ON cc.id=c.category_id WHERE c.event_date >= CURDATE() ORDER BY c.event_date ASC LIMIT 12")->fetchAll();
} catch (Throwable $e) { $categories = $upcoming = []; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">COMPETITIONS</p>
    <h1 class="disp">Compete. Perform. Win.</h1>
    <p class="lead">From a single-school spelling bee to a city-wide championship, APEX designs, runs and judges competitions that students trust and remember.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="calendar.php">See Upcoming Competitions</a>
      <a class="btn btn-outline-ivory btn-lg" href="contact.php?interest=Register%20for%20an%20APEX%20Championship">Register Your Institution</a>
    </div>
  </div>
</section>

<!-- Categories -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">COMPETITION CATEGORIES</p>
      <h2 class="disp">Competitions We Organise</h2>
      <p class="lead">APEX designs and manages competitions in nine categories. Each can run as an intra-school event, an inter-school or inter-college championship, a city-level contest, or with online qualifying rounds followed by live finals.</p>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($categories as $i => $c): ?>
      <article id="cat-<?= e($c['slug']) ?>" class="cat-card">
        <span class="num"><?= str_pad(($i+1),2,'0',STR_PAD_LEFT) ?></span>
        <h3><?= e($c['name']) ?></h3>
        <p><?= e($c['description']) ?></p>
        <a class="tag" href="calendar.php?category=<?= urlencode($c['slug']) ?>">See upcoming →</a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Signature Championships -->
<section class="section section-navy">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow">FLAGSHIP CHAMPIONSHIPS</p>
      <h2 class="disp" style="color:var(--ivory)">APEX Signature Championships</h2>
      <p>Our own open competitions, held every year for schools and colleges. Institutions register teams; APEX handles everything else.</p>
    </div>
    <div class="grid grid-3 reveal">
      <?php
      $signature = [
        ['APEX Quiz Championship','Inter-school and inter-college general knowledge and science quiz, with qualifying rounds and a live stage final.'],
        ['APEX Debate Cup','English and Urdu debating championship with parliamentary and classic formats and expert adjudicators.'],
        ['APEX Spelling Bee','Junior and senior spelling bee, building from school rounds to a grand final.'],
        ['APEX Science &amp; Robotics Challenge','Science projects, robotics and coding categories judged by subject experts.'],
        ['APEX Sports League','Inter-school and inter-college cricket, futsal and basketball leagues, with fixtures, standings and finals.'],
        ['APEX Talent Hunt','Singing, poetry recitation, Qirat &amp; Naat, drama and art, with a showcase final for the winners.'],
      ];
      foreach ($signature as $s): ?>
      <div class="card" style="background:var(--panel);color:var(--ivory);padding:24px">
        <h3 style="color:var(--ivory);margin:0 0 8px"><?= $s[0] ?></h3>
        <p style="color:var(--mist);font-size:14.5px;margin:0"><?= $s[1] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:24px;color:var(--mist);font-size:13.5px;opacity:.75">Championship names are suggestions. Dates, fees and prizes become final once your administrator confirms them.</p>
  </div>
</section>

<!-- Fair play -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">FAIR PLAY</p>
      <h2 class="disp">How We Keep Every Competition Fair</h2>
    </div>
    <div class="steps reveal">
      <div class="step"><div class="n">01</div><div><h3>Clear rules</h3><p>Rules, formats and judging criteria are published to every institution before registration closes.</p></div></div>
      <div class="step"><div class="n">02</div><div><h3>Independent judges</h3><p>Subject experts and trained adjudicators with no link to participating teams, briefed before every round.</p></div></div>
      <div class="step"><div class="n">03</div><div><h3>Scoring rubrics</h3><p>Structured score sheets for every round, recorded and double-checked by the APEX results team.</p></div></div>
      <div class="step"><div class="n">04</div><div><h3>Secure papers</h3><p>Question papers and topics are prepared confidentially and opened only at the start of each round.</p></div></div>
      <div class="step"><div class="n">05</div><div><h3>Transparent results</h3><p>Scores and results are shared with all institutions, with a clear process for queries and appeals.</p></div></div>
    </div>
  </div>
</section>

<!-- What participants receive -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="grid grid-2 reveal">
      <div>
        <p class="eyebrow dark">WHAT PARTICIPANTS RECEIVE</p>
        <h2 class="disp">Recognition that lasts</h2>
        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px">
          <li style="display:flex;gap:12px;align-items:flex-start"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span>Certificates for every participant.</span></li>
          <li style="display:flex;gap:12px;align-items:flex-start"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span>Trophies and medals for winners and runners-up.</span></li>
          <li style="display:flex;gap:12px;align-items:flex-start"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span>Results and standings shared with each institution.</span></li>
          <li style="display:flex;gap:12px;align-items:flex-start"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span>Photos, highlight videos and social media features.</span></li>
          <li style="display:flex;gap:12px;align-items:flex-start"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span>Scholarships or sponsored prizes for flagship finals, where available.</span></li>
        </ul>
      </div>
      <div>
        <p class="eyebrow dark">COMPETITION LEVELS</p>
        <h2 class="disp">A category for every age</h2>
        <div style="display:grid;gap:10px">
          <div style="background:var(--ivory);padding:14px 18px;border-radius:12px"><b>Junior:</b> Pre-school to Grade 5</div>
          <div style="background:var(--ivory);padding:14px 18px;border-radius:12px"><b>Middle:</b> Grades 6–8</div>
          <div style="background:var(--ivory);padding:14px 18px;border-radius:12px"><b>Senior:</b> Grades 9–12, including Matric, O Level, Intermediate and A Level</div>
          <div style="background:var(--ivory);padding:14px 18px;border-radius:12px"><b>College &amp; University:</b> undergraduate and postgraduate students</div>
          <div style="background:var(--ivory);padding:14px 18px;border-radius:12px"><b>Open &amp; Corporate:</b> staff teams, alumni and corporate participants</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How registration works -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">HOW REGISTRATION WORKS</p>
      <h2 class="disp">Four simple steps to compete</h2>
    </div>
    <div class="grid grid-4 reveal">
      <div class="step" style="grid-template-columns:1fr"><div class="n">01</div><div><h3>Choose a competition</h3><p>Read the rules, categories and dates for the competition you want to enter.</p></div></div>
      <div class="step" style="grid-template-columns:1fr"><div class="n">02</div><div><h3>Register your team</h3><p>Your institution's coordinator completes the online form and submits student details.</p></div></div>
      <div class="step" style="grid-template-columns:1fr"><div class="n">03</div><div><h3>Confirm your entry</h3><p>Pay the entry fee if applicable; you will receive a confirmation and participant guide.</p></div></div>
      <div class="step" style="grid-template-columns:1fr"><div class="n">04</div><div><h3>Compete &amp; celebrate</h3><p>Arrive on the day, compete, and receive results, certificates and photos afterwards.</p></div></div>
    </div>
    <div class="alert info" style="margin-top:28px">
      <p><b>Safety:</b> for school students, registrations should come through the school or a parent/guardian, not from children directly.</p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">Ready to register your institution?</h2>
        <p>Browse open registrations and secure your team's place.</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a class="btn btn-gold" href="calendar.php">Open Competitions</a>
        <a class="btn btn-outline-ivory" href="contact.php">Talk to Our Team</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
