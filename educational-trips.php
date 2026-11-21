<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'Educational Trips & Study Tours | APEX';
$pageDescription = 'Supervised school picnics, field trips and study tours arranged by APEX for schools and colleges.';

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('trip_ok');
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">EDUCATIONAL TRIPS</p>
    <h1 class="disp">Learning Beyond the Classroom.</h1>
    <p class="lead">Alongside our competitions and events, APEX arranges supervised picnics, educational field trips and study tours for schools and colleges.</p>
    <div class="hero-actions"><a class="btn btn-gold btn-lg" href="#plan">Plan a Trip</a></div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">TRIP TYPES</p>
      <h2 class="disp">Trips designed with safety first</h2>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:14px">
        <?php foreach ([
          ['School picnics','Relaxed one-day outings with games and meals arranged.'],
          ['Educational field trips','Museums, science centres, factories and historical sites.'],
          ['Study tours &amp; camps','Multi-day trips that combine learning and adventure.'],
          ['College tours','Recreational and departmental trips for students and societies.'],
        ] as $t): ?>
          <li style="background:var(--ivory);border-radius:12px;padding:16px 18px"><b style="font-family:Archivo,sans-serif;display:block;margin-bottom:4px"><?= $t[0] ?></b><span style="color:var(--slate);font-size:14.5px"><?= $t[1] ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">SAFETY</p>
      <h3 style="color:var(--ivory);margin:6px 0 14px">Every trip is planned around safety</h3>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:10px;color:var(--mist);font-size:14.5px">
        <?php foreach ([
          'An itinerary approved by the institution',
          'APEX tour leaders, including female staff for girls\' groups',
          'First aid on every trip',
          'Headcounts at every stop',
          'Parent consent forms collected in advance',
          'Regular updates to the school during the trip',
        ] as $s): ?>
          <li style="display:flex;gap:10px;align-items:flex-start"><svg width="18" height="18" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span><?= e($s) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff" id="plan">
  <div class="container" style="max-width:860px;margin-left:auto;margin-right:auto">
    <div class="reveal" style="margin-bottom:24px">
      <p class="eyebrow dark">PLAN A TRIP</p>
      <h2 class="disp">Trip enquiry</h2>
      <p class="lead">Tell us about the group and destination, and we'll come back with a plan, timeline and quote.</p>
    </div>

    <?php if ($ok): ?><div class="alert ok"><h3>Thank you!</h3><p><?= e($ok) ?></p></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form class="form card" style="padding:32px" method="POST" action="handlers/trip.php" data-validate novalidate>
      <?= csrf_field() ?>
      <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

      <div class="form-grid">
        <label class="f" data-req><span>Institution name <span class="req">*</span></span><input type="text" name="institution_name" value="<?= e(old('institution_name')) ?>" required><span class="err-msg">Please enter the institution.</span></label>
        <label class="f" data-req><span>Contact person <span class="req">*</span></span><input type="text" name="contact_name" value="<?= e(old('contact_name')) ?>" required><span class="err-msg">Please enter a contact name.</span></label>
        <label class="f" data-email><span>Email</span><input type="email" name="email" value="<?= e(old('email')) ?>"><span class="err-msg">Please check the email address.</span></label>
        <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="phone" value="<?= e(old('phone')) ?>" required placeholder="+92 3XX XXXXXXX"><span class="err-msg">Please enter a valid phone number.</span></label>
        <label class="f"><span>Trip type</span>
          <select name="trip_type">
            <option value="">Select…</option>
            <option<?= old('trip_type')==='School picnic' ? ' selected' : '' ?>>School picnic</option>
            <option<?= old('trip_type')==='Educational field trip' ? ' selected' : '' ?>>Educational field trip</option>
            <option<?= old('trip_type')==='Study tour / camp' ? ' selected' : '' ?>>Study tour / camp</option>
            <option<?= old('trip_type')==='College tour' ? ' selected' : '' ?>>College tour</option>
          </select>
        </label>
        <label class="f"><span>Destination (if known)</span><input type="text" name="destination" value="<?= e(old('destination')) ?>" placeholder="e.g. Islamabad Science Museum"></label>
        <label class="f"><span>Expected date</span><input type="date" name="expected_date" value="<?= e(old('expected_date')) ?>"></label>
        <label class="f"><span>Number of participants</span><input type="text" name="participants" value="<?= e(old('participants')) ?>" placeholder="e.g. 60 students, 4 teachers"></label>
        <label class="f"><span>Age group</span><input type="text" name="age_group" value="<?= e(old('age_group')) ?>" placeholder="e.g. Grade 6–8"></label>
        <label class="f full"><span>Additional notes</span><textarea name="notes" placeholder="Learning goals, dietary requirements, special needs…"><?= e(old('notes')) ?></textarea></label>
      </div>

      <div class="actions"><button class="btn btn-gold btn-lg" type="submit">Request Trip Plan</button></div>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
