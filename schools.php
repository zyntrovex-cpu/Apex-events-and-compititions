<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'School Event & Competition Management | APEX';
$pageDescription = 'Annual days, sports days, prize distributions, quiz and spelling bee competitions and inter-school events — safe, organised and stress-free.';

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">FOR SCHOOLS</p>
    <h1 class="disp">Big Days for Young Achievers.</h1>
    <p class="lead">From sports days to spelling bees, APEX helps schools run safe, joyful and well-organised events — so teachers can focus on the children.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="contact.php?interest=Organise%20a%20competition">Request a Proposal</a>
      <a class="btn btn-outline-ivory btn-lg" href="competitions.php">Competitions for Schools</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">EVENTS WE MANAGE FOR SCHOOLS</p>
      <h2 class="disp">Everything your academic year needs</h2>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:12px">
        <?php foreach ([
          'Annual days, parents\' days and prize distributions',
          'Sports days and inter-school tournaments',
          'Quiz, spelling bee, olympiad and art competitions',
          'Science fairs and project exhibitions',
          'Talent shows, cultural weeks and fun fairs',
          'Picnics, field trips and educational study tours',
        ] as $it): ?>
          <li style="display:flex;gap:12px;align-items:flex-start;font-size:15px"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><?= $it ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">OUR PROMISE TO SCHOOLS AND PARENTS</p>
      <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:12px">
        <?php foreach ([
          ['Supervised areas and controlled entry for every event','Safe, secure access for students and visitors.'],
          ['Trained staff, including female staff for girls\' events','Age- and gender-appropriate supervision at all times.'],
          ['First aid on site and an emergency plan agreed in advance','A documented plan with on-site medical cover.'],
          ['Clear communication with parents before and after the event','Timely updates and a contact person parents can reach.'],
          ['Age-appropriate formats, rules and content','Everything tailored to the age group taking part.'],
        ] as $p): ?>
          <li style="background:var(--panel);border-radius:10px;padding:14px">
            <b style="color:var(--ivory);display:block;margin-bottom:4px"><?= e($p[0]) ?></b>
            <span style="color:var(--mist);font-size:13.5px"><?= e($p[1]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">POPULAR FOR SCHOOLS</p>
      <h2 class="disp">Events schools book most</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ([
        ['Annual Day','Stage, sound, lighting, rehearsals, chief-guest handling and certificates in one coordinated package.'],
        ['Sports Day','Fixtures, officials, first aid, march-past, opening ceremonies and medal presentations.'],
        ['Spelling Bee / Quiz','Secure question papers, trained quiz masters, scoring rubrics and stage finals.'],
        ['Talent Show','Auditions, stage production, judging panel and a highlight reel to share with parents.'],
        ['Science Fair','Booth layout, exhibitor management, judging panels and best-project awards.'],
        ['Prize Distribution','Trophy and certificate design, stage plan, speeches and photography.'],
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
        <h2 class="disp">Ready to plan your next school event?</h2>
        <p>Share a few details and we'll come back with a tailored plan, timeline and itemised budget.</p>
      </div>
      <a class="btn btn-gold" href="contact.php?interest=Organise%20a%20competition">Request a Proposal</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
