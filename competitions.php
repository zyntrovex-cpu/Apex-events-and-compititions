<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'All Karachi Table Tennis Leagues 2026 | APEX';
$pageDescription = 'University & College table tennis leagues in Karachi, 5–20 Dec 2026. 10 categories, 6 university campuses, free entry. Register 21–29 Nov.';
$pageSlug = 'league';

include __DIR__ . '/includes/header.php';
?>

<!-- League page HERO -->
<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">APEX SPORTS · INAUGURAL SEASON · KARACHI</p>
    <h1 class="disp">All Karachi Table Tennis Leagues</h1>
    <p class="lead">Two leagues, one city, one title to win. APEX launches the All Karachi University Table Tennis League and the All Karachi College Table Tennis League, with team, singles and mixed doubles championships, played in a straight knockout format from Saturday 5 to Sunday 20 December 2026, on weekends only. Registration runs from Saturday 21 to Sunday 29 November 2026.</p>
    <div class="hero-actions">
      <a class="btn btn-primary btn-lg" href="#register">Register Your Team</a>
      <a class="btn btn-outline-ivory btn-lg" href="#format">League Details</a>
    </div>
  </div>
</section>

<!-- At a glance strip -->
<section class="section-sm" style="background:var(--panel);color:var(--ivory)">
  <div class="container">
    <ul style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;font-size:14.5px">
      <li><b style="color:var(--gold)">5–20 Dec 2026</b> — Three weekends: matches on Saturdays and Sundays only</li>
      <li><b style="color:var(--gold)">5 categories</b> — Men's &amp; women's team and singles, plus mixed doubles, in each league</li>
      <li><b style="color:var(--gold)">Format</b> — Straight knockout: win and advance, lose and you're out</li>
      <li><b style="color:var(--gold)">Venues</b> — 6 leading university campuses across Karachi · free entry for spectators</li>
    </ul>
  </div>
</section>

<!-- Choose your league -->
<section class="section">
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
        <div style="display:grid;gap:8px;font-size:14px;color:var(--slate)">
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
        <div style="display:grid;gap:8px;font-size:14px;color:var(--slate)">
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

<!-- Five ways to compete -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">CATEGORIES</p>
      <h2 class="disp">Five Ways to Compete</h2>
      <p class="lead">The same five categories run in both leagues: 10 categories and 10 champions in all.</p>
    </div>
    <div class="grid grid-3 reveal">
      <div class="feature">
        <h3>Men's / Boys' Team</h3>
        <p>Teams of 2 players. An institution can enter more than one team. Each tie is best of three matches: two singles, then a doubles if needed. The first team to win two matches wins the tie.</p>
      </div>
      <div class="feature">
        <h3>Women's / Girls' Team</h3>
        <p>A separate team championship for women and girls, with its own trophies, prizes and Finals Day slot.</p>
      </div>
      <div class="feature">
        <h3>Men's / Boys' Singles</h3>
        <p>Any number of players per institution compete for the individual title and the Best Player award.</p>
      </div>
      <div class="feature">
        <h3>Women's / Girls' Singles</h3>
        <p>Any number of players per institution, in a separate women's draw with its own title.</p>
      </div>
      <div class="feature">
        <h3>Mixed Doubles</h3>
        <p>One man and one woman (or one boy and one girl) from the same institution play as a pair. Institutions can enter more than one pair.</p>
      </div>
      <div class="feature">
        <h3>Professional Match Play</h3>
        <p>Matches on competition tables with approved 40+ balls, run by qualified umpires.</p>
      </div>
    </div>
  </div>
</section>

<!-- How the leagues work -->
<section class="section" id="format">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">FORMAT</p>
      <h2 class="disp">How the Leagues Work</h2>
    </div>
    <div class="steps reveal">
      <div class="step"><div class="n">01</div><div><h3>Registration</h3><p>Institutions register teams and players and submit player documents.</p></div></div>
      <div class="step"><div class="n">02</div><div><h3>Open draw · Tue 1 Dec</h3><p>A public draw sets the knockout bracket. Byes are given if entries are not a full 8, 16 or 32.</p></div></div>
      <div class="step"><div class="n">03</div><div><h3>Weekend 1 · 5–6 Dec</h3><p>Saturday: every pre-Round-of-16 match for both leagues at Host Campus 1. Sunday: University League Round of 16 (8 ties) at Host Campus 2.</p></div></div>
      <div class="step"><div class="n">04</div><div><h3>Weekend 2 · 12–13 Dec</h3><p>Saturday: College League Round of 16 (8 ties) at Host Campus 3. Sunday: quarter-finals for both leagues at Host Campus 4.</p></div></div>
      <div class="step"><div class="n">05</div><div><h3>Weekend 3 · 19–20 Dec</h3><p>Semi-finals for both leagues at Host Campus 5 on Saturday. Finals Day for both leagues at Host Campus 6 on Sunday.</p></div></div>
    </div>

    <div class="reveal" style="margin-top:26px">
      <p class="eyebrow dark">PATH TO THE FINAL</p>
      <p class="lead" style="font-family:Archivo,sans-serif;font-stretch:108%;font-size:18px"><b>16 → 8 → 4 → 2 → 1</b> · Round of 16 · Quarter-finals · Semi-finals · Final · Champion</p>
      <p class="text-slate">In each of the five categories of both leagues (10 in all), 16 qualify for the Round of 16, then 8, 4 and 2 advance, and 1 is crowned All Karachi Champion.</p>
    </div>

    <div class="reveal" style="margin-top:26px">
      <p class="eyebrow dark">THE DRAW · NOTES UNDER THE BRACKET</p>
      <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:12px">
        <li><b>Seeding:</b> Inaugural season: a fully open public draw. From next season, the top [4] teams and players are seeded on this season's results, so they cannot meet before the semi-finals.</li>
        <li><b>Pre-Round-of-16 &amp; byes:</b> With more than 16 entries in a category, the pre-Round-of-16 matches on Saturday 5 December decide the last 16. Empty slots become byes, drawn at random and announced with the draw.</li>
        <li><b>Singles draw:</b> Men's and women's singles use the same knockout format, with draw size set by the number of entries.</li>
      </ul>
    </div>
  </div>
</section>

<!-- Season schedule -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">SEASON SCHEDULE</p>
      <h2 class="disp">Three Weekends, Two Leagues, One Champion</h2>
      <p class="lead">Matches are played on Saturdays and Sundays only, so players never miss classes. After the opening Saturday, each league plays its own Round of 16, then both leagues come together for the quarter-finals, semi-finals and Finals Day.</p>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="tbl" style="min-width:640px">
        <thead><tr><th>Day</th><th>Host campus</th><th>What's played</th></tr></thead>
        <tbody>
          <tr><td><b>Day 1 · Sat 5 Dec</b></td><td>[Host University 1]</td><td>All pre-Round-of-16 matches, both leagues, team and singles</td></tr>
          <tr><td><b>Day 2 · Sun 6 Dec</b></td><td>[Host University 2]</td><td>University League Round of 16: 8 ties, 16 → 8</td></tr>
          <tr><td><b>Day 3 · Sat 12 Dec</b></td><td>[Host University 3]</td><td>College League Round of 16: 8 ties, 16 → 8</td></tr>
          <tr><td><b>Day 4 · Sun 13 Dec</b></td><td>[Host University 4]</td><td>Quarter-finals, both leagues: 8 → 4</td></tr>
          <tr><td><b>Day 5 · Sat 19 Dec</b></td><td>[Host University 5]</td><td>Semi-finals, both leagues: 4 → 2</td></tr>
          <tr><td><b>Day 6 · Sun 20 Dec</b></td><td>[Host University 6]</td><td>FINALS DAY: third-place play-offs, all finals (2 → 1), trophy and awards ceremony</td></tr>
        </tbody>
      </table>
    </div>
    <p class="text-slate" style="margin-top:14px">Exact match times and venues for every tie are published with the fixtures on Tuesday 1 December. Play usually runs from [10:00 am] to [6:00 pm].</p>
  </div>
</section>

<!-- Venues -->
<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">VENUES</p>
    <h2 class="disp">Six Match Days, Six University Campuses</h2>
    <p class="lead">The leagues travel the city. Each of the six match days is hosted by a different leading Karachi university, so every host campus gets its own day of top-level table tennis.</p>
    <p class="lead">Saturday 5 December is the biggest day, with every pre-Round-of-16 match for both leagues, so Host Campus 1 runs [6–8] competition tables from [9:00 am]. Other days use [4] tables. College League days give college players a chance to experience university sport.</p>
    <div class="alert info"><p><b>Note:</b> Name a host university only after it has confirmed in writing.</p></div>
  </div>
</section>

<!-- Eligibility -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">ELIGIBILITY</p>
      <h2 class="disp">Who Can Play</h2>
      <p class="lead">Every player is checked against their documents before their first match.</p>
    </div>
    <div class="grid grid-3 reveal">
      <article class="card" style="padding:24px">
        <h3 style="font-size:18px;color:var(--dgold);margin:0 0 10px">University players</h3>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:8px;font-size:14.5px;color:var(--slate)">
          <li>• Currently enrolled in an undergraduate or postgraduate programme at a university campus in Karachi</li>
          <li>• Valid university student ID card</li>
          <li>• Letter from the university's sports department confirming the team</li>
          <li>• A player may represent only one university in the season</li>
        </ul>
      </article>
      <article class="card" style="padding:24px">
        <h3 style="font-size:18px;color:var(--dgold);margin:0 0 10px">College players</h3>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:8px;font-size:14.5px;color:var(--slate)">
          <li>• Currently enrolled in Intermediate (FA, FSc, ICS, I.Com) or A Level at a college in Karachi</li>
          <li>• Valid college ID card, plus B-Form or CNIC</li>
          <li>• Aged [under 20] on [cut-off date]</li>
          <li>• Letter from the principal or sports department confirming the team</li>
          <li>• Parent or guardian consent for players under 18</li>
        </ul>
      </article>
      <article class="card" style="padding:24px">
        <h3 style="font-size:18px;color:var(--dgold);margin:0 0 10px">Every team</h3>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:8px;font-size:14.5px;color:var(--slate)">
          <li>• 2 players, both from the same institution. An institution can enter more than one team, and a player can play for only one team per category</li>
          <li>• A team manager or coach from the institution's staff, present at every tie</li>
          <li>• Team kit in matching colours, with non-marking sports shoes</li>
          <li>• Players bring their own bats; APEX provides tables and balls</li>
        </ul>
      </article>
    </div>
  </div>
</section>

<!-- Key dates & fees -->
<section class="section" id="register">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">KEY DATES &amp; FEES</p>
      <h2 class="disp">Registration Deadlines</h2>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="tbl" style="min-width:600px">
        <thead><tr><th>Milestone</th><th>Date</th><th>Notes</th></tr></thead>
        <tbody>
          <tr><td><b>Registration opens</b></td><td>Saturday 21 November 2026</td><td>Both leagues</td></tr>
          <tr><td><b>Registration closes</b></td><td>Sunday 29 November 2026</td><td>Both leagues</td></tr>
          <tr><td><b>Open draw &amp; fixtures</b></td><td>Tuesday 1 December 2026</td><td>Streamed live</td></tr>
          <tr><td><b>League begins</b></td><td>Saturday 5 December 2026</td><td>[Host University 1]</td></tr>
          <tr><td><b>Finals Day &amp; awards</b></td><td>Sunday 20 December 2026</td><td>[Host University 6]</td></tr>
        </tbody>
      </table>
    </div>

    <div class="reveal" style="margin-top:22px">
      <h3 style="color:var(--dgold);font-size:18px;margin:0 0 10px">Entry fees (same for both leagues)</h3>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:8px;font-size:15px">
        <li>• <b>Team:</b> PKR 1,500 per team</li>
        <li>• <b>Mixed doubles:</b> PKR 1,500 per pair</li>
        <li>• <b>Singles:</b> PKR 1,000 per player</li>
      </ul>
    </div>

    <div class="grid grid-2 reveal" style="margin-top:28px">
      <article class="card" style="padding:28px">
        <h3 style="font-size:20px;margin:0 0 8px">University League registration</h3>
        <p class="text-slate" style="margin:0 0 10px">For universities and degree-awarding institutes in Karachi. Enter Men's Team, Women's Team, Men's Singles, Women's Singles and Mixed Doubles in one form.</p>
        <div style="display:grid;gap:6px;font-size:14px;color:var(--slate);margin-bottom:14px">
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team or mixed pair · PKR 1,000 per singles player</div>
          <div><b style="color:var(--navy)">Deadline:</b> Sunday 29 November 2026</div>
        </div>
        <a class="btn btn-primary" href="register-university.php">Register Your University</a>
      </article>
      <article class="card" style="padding:28px">
        <h3 style="font-size:20px;margin:0 0 8px">College League registration</h3>
        <p class="text-slate" style="margin:0 0 10px">For Intermediate and A Level colleges in Karachi. Enter Boys' Team, Girls' Team, Boys' Singles, Girls' Singles and Mixed Doubles in one form.</p>
        <div style="display:grid;gap:6px;font-size:14px;color:var(--slate);margin-bottom:14px">
          <div><b style="color:var(--navy)">Fees:</b> PKR 1,500 per team or mixed pair · PKR 1,000 per singles player</div>
          <div><b style="color:var(--navy)">Deadline:</b> Sunday 29 November 2026</div>
        </div>
        <a class="btn btn-primary" href="register-college.php">Register Your College</a>
      </article>
    </div>
  </div>
</section>

<!-- Prizes & recognition -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">PRIZES &amp; RECOGNITION</p>
      <h2 class="disp">What's at Stake</h2>
    </div>
    <div class="grid grid-3 reveal">
      <div class="feature"><h3>Champions' Trophies</h3><p>Trophies for the champions, runners-up and third-place finishers in all 10 categories.</p></div>
      <div class="feature"><h3>Medals</h3><p>Gold, silver and bronze medals for players in every category.</p></div>
      <div class="feature"><h3>Prize Money</h3><p>[PKR ___] for the team champions and [PKR ___] for the singles champions in each league.</p></div>
      <div class="feature"><h3>Best Player Awards</h3><p>Best Player of the League awards for men and women in both leagues.</p></div>
      <div class="feature"><h3>Certificates for All</h3><p>Every registered player receives an official APEX participation certificate.</p></div>
      <div class="feature"><h3>Media Coverage</h3><p>Results, photos and highlights on APEX channels, shared with consent.</p></div>
    </div>
  </div>
</section>

<!-- Rules & fair play -->
<section class="section">
  <div class="container reveal" style="max-width:860px">
    <p class="eyebrow dark">RULES &amp; FAIR PLAY</p>
    <h2 class="disp">Fair Matches, Every Time</h2>
    <p class="lead">The leagues follow the international Laws of Table Tennis, with APEX league rules for eligibility, scheduling and conduct. The full rulebook is shared with every registered institution.</p>
    <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:10px;font-size:15px;color:var(--slate)">
      <li>• Team ties are best of three matches (two singles, then a doubles if needed). Each match is best of three games, each played to 11 points (win by 2).</li>
      <li>• Qualified umpires officiate every match. A tournament referee rules on any dispute.</li>
      <li>• Player eligibility is checked against original documents before each team's first tie.</li>
      <li>• Every round is knockout: the loser of each tie is eliminated. There are no replays.</li>
      <li>• Teams and players from the same institution are placed in different halves of the draw where possible.</li>
      <li>• A team that fails to appear within [15] minutes of the scheduled start forfeits the tie, and the opponent advances.</li>
      <li>• Queries go to the tournament referee in writing within [30] minutes of the match ending.</li>
      <li>• Respect for opponents, umpires and spectators at all times. Misconduct can lead to disqualification.</li>
      <li>• Separate women's and girls' events, with female officials and staff present.</li>
    </ul>
  </div>
</section>

<!-- Sponsorship banner -->
<section class="section">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <p class="eyebrow">SPONSORSHIP</p>
        <h2 class="disp">Sponsor the First All Karachi Table Tennis Leagues</h2>
        <p>Put your brand on Karachi's first university and college table tennis leagues, from 5 to 20 December 2026: on the tables, the team shirts, the trophies and every livestream.</p>
      </div>
      <a class="btn btn-primary" href="contact.php?subject=Sponsorship">See Sponsorship Packages</a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section section-panel" style="background:#fff">
  <div class="container" style="max-width:920px">
    <div class="reveal" style="margin-bottom:24px">
      <p class="eyebrow dark">FAQ</p>
      <h2 class="disp">Questions About the Leagues</h2>
    </div>

    <?php
    $faqs = [
      ['Can one institution enter more than one team?',
       'Yes. An institution can enter as many teams as it likes in each team category, plus any number of singles players and mixed doubles pairs. Each team, player or pair pays its own entry fee. A player can play for only one team in each category, and teams from the same institution are placed in different halves of the draw where possible, so they don\'t meet in the early rounds.'],
      ['Who can play mixed doubles?',
       'Any eligible man and woman (or boy and girl) from the same institution. They can also play in their team and singles events.'],
      ['Are any matches on weekdays?',
       'No. All matches are on Saturdays and Sundays between 5 and 20 December 2026, so players don\'t miss classes. Every match before the Round of 16 is on Saturday 5 December. The University League Round of 16 is on Sunday 6 December and the College League Round of 16 on Saturday 12 December.'],
      ['What if a player has an exam on a match day?',
       'Tell APEX when you register and we will try to schedule your ties around exams. Because teams have 2 players, please plan ahead so both players are available on match days.'],
      ['What happens if we lose our first tie?',
       'In a knockout, the losing team or player is out of that category. You can still compete in your other categories.'],
      ['How is the draw made?',
       'Through an open public draw, held in front of team managers and streamed live, so every institution can see it is fair. Byes are drawn the same way.'],
      ['Our college has A Level and Intermediate students. Can they play together?',
       'Yes. Both count as college students, provided they meet the age limit and have valid college ID.'],
      ['Do we need our own table and balls?',
       'No. APEX provides competition tables and approved 40+ balls. Players bring their own bats.'],
      ['Where are matches played?',
       'Each of the six match days is at a different leading university campus in Karachi, listed in the schedule and in the fixtures published on Tuesday 1 December. If a venue changes, every team manager is told at least [7] days in advance.'],
      ['Do visiting players get access to the host campus?',
       'Yes. Registered players, team managers and officials are on the host university\'s guest list. Players should carry their student ID for campus entry.'],
      ['Are the matches open to spectators?',
       'Yes. Entry is free for everyone: students, parents and fans are all welcome at every match day. Please carry an ID card for campus entry. Finals Day will also be livestreamed on APEX channels.'],
      ['How do we pay the entry fee?',
       'After you register, APEX sends an invoice with bank details. Your place is confirmed when payment is received.'],
    ];
    foreach ($faqs as $f): ?>
      <details class="acc">
        <summary><?= e($f[0]) ?></summary>
        <div class="body"><?= e($f[1]) ?></div>
      </details>
    <?php endforeach; ?>
  </div>
</section>

<!-- Register section -->
<section class="section">
  <div class="container reveal" style="max-width:860px;text-align:center">
    <p class="eyebrow dark">REGISTER YOUR INSTITUTION</p>
    <h2 class="disp">Registration runs from Saturday 21 to Sunday 29 November 2026.</h2>
    <p class="lead">Choose your league: one form covers all five categories.</p>
    <div class="hero-actions" style="justify-content:center">
      <a class="btn btn-primary btn-lg" href="register-university.php">Register Your University</a>
      <a class="btn btn-navy btn-lg" href="register-college.php">Register Your College</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
