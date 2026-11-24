<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'College League Registration | APEX';
$pageDescription = 'Register your college for the All Karachi College Table Tennis League 2026: team, singles and mixed doubles. Registration 21–29 November 2026.';

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('reg_college_ok');

$now = time();
$opens  = strtotime('2026-11-21 00:00:00');
$closes = strtotime('2026-11-29 23:59:59');
$beforeOpen = $now < $opens;
$afterClose = $now > $closes;
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">ALL KARACHI TABLE TENNIS LEAGUES · COLLEGE REGISTRATION</p>
    <h1 class="disp">College League registration</h1>
    <p class="lead">Register your college for the All Karachi College Table Tennis League. Enter any or all of the five categories in one form. Registration runs from Saturday 21 to Sunday 29 November 2026.</p>
  </div>
</section>

<section class="section-sm" style="background:var(--panel);color:var(--ivory)">
  <div class="container">
    <ul style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;font-size:14.5px">
      <li><b style="color:var(--gold)">21–29 Nov 2026</b> — Registration window. Registration closes Sunday 29 November.</li>
      <li><b style="color:var(--gold)">Fees</b> — PKR 1,500 per team or mixed pair · PKR 1,000 per singles player</li>
      <li><b style="color:var(--gold)">Who registers</b> — The college's sports department or a staff team manager</li>
      <li><b style="color:var(--gold)">League</b> — Sat 5 – Sun 20 December 2026, weekends only</li>
    </ul>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:920px;margin-left:auto;margin-right:auto">
    <div class="reveal" style="margin-bottom:24px">
      <p class="eyebrow dark">BEFORE YOU START</p>
      <h2 class="disp">Have These Ready</h2>
      <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:10px;font-size:15px;color:var(--slate)">
        <li>• <b style="color:var(--navy)">Student ID details:</b> ID numbers and dates of birth for every player.</li>
        <li>• <b style="color:var(--navy)">Institution letter:</b> A letter from your principal or sports department confirming the players (upload it in the form, or email it later).</li>
        <li>• <b style="color:var(--navy)">Team manager:</b> A staff member who will attend every tie and receive the invoice.</li>
        <li>• <b style="color:var(--navy)">Player details:</b> Each player's class. Players can enter team, singles and mixed doubles.</li>
        <li>• <b style="color:var(--navy)">Parent consent:</b> A signed consent form for every player under 18. We email the form with your invoice.</li>
      </ul>
    </div>

    <?php if ($beforeOpen): ?>
      <div class="alert info"><p><b>Before 21 November:</b> Registration opens Saturday 21 November 2026. You can fill in and send your entry now: early entries are processed when registration opens.</p></div>
    <?php elseif ($afterClose): ?>
      <div class="alert err"><p><b>After 29 November:</b> Registration closed on Sunday 29 November 2026. For late entries, please contact APEX directly.</p></div>
    <?php endif; ?>

    <?php if ($ok): ?>
      <div class="alert ok"><h3>Registration received!</h3><p><?= e($ok) ?></p></div>
    <?php endif; ?>
    <?php if ($errors): ?>
      <div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <form class="form card" style="padding:32px" method="POST" action="handlers/register_league.php" enctype="multipart/form-data" data-validate novalidate>
      <?= csrf_field() ?>
      <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>
      <input type="hidden" name="league" value="college">

      <h2 class="disp" style="font-size:22px;margin:0 0 6px">Register for the College League</h2>
      <p class="text-slate" style="margin:0 0 20px">Tick each category you want to enter, then add the players. Fields marked <span class="req" style="color:var(--red)">*</span> are required.</p>

      <fieldset>
        <legend>STEP 1 · INSTITUTION &amp; TEAM MANAGER</legend>
        <div class="form-grid">
          <label class="f" data-req><span>College name <span class="req">*</span></span><input type="text" name="institution_name" value="<?= e(old('institution_name')) ?>" required><span class="err-msg">Please enter the college name.</span></label>
          <label class="f" data-req><span>Campus / area in Karachi <span class="req">*</span></span><input type="text" name="campus_area" value="<?= e(old('campus_area')) ?>" placeholder="e.g. Main Campus, Gulshan" required><span class="err-msg">Please enter the campus or area.</span></label>
          <label class="f" data-req><span>Team manager name <span class="req">*</span></span><input type="text" name="manager_name" value="<?= e(old('manager_name')) ?>" required><span class="err-msg">Please enter the team manager's name.</span></label>
          <label class="f"><span>Designation</span><input type="text" name="manager_role" value="<?= e(old('manager_role')) ?>" placeholder="e.g. Sports Director, PE Teacher, Coach"></label>
          <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="manager_phone" value="<?= e(old('manager_phone')) ?>" placeholder="+92 3XX XXXXXXX" required><span class="err-msg">Please enter a valid phone number.</span></label>
          <label class="f" data-email data-req><span>Official email <span class="req">*</span></span><input type="email" name="manager_email" value="<?= e(old('manager_email')) ?>" required><span class="err-msg">Please check the email address.</span></label>
          <label class="f full"><span>Second contact (name and phone) — optional</span><input type="text" name="second_contact" value="<?= e(old('second_contact')) ?>"></label>
        </div>
      </fieldset>

      <fieldset id="categories" data-chips-required>
        <legend>STEP 2 · CATEGORIES &amp; PLAYERS <span class="req">*</span></legend>
        <p class="text-slate" style="margin:-6px 0 14px;font-size:14px">Choose at least one category. The same player can be entered in team, singles and mixed doubles.</p>

        <div class="chips-grid">
          <label class="chip"><input type="checkbox" name="categories[]" value="boys_team"> Boys' Team · PKR 1,500 per team</label>
          <label class="chip"><input type="checkbox" name="categories[]" value="girls_team"> Girls' Team · PKR 1,500 per team</label>
          <label class="chip"><input type="checkbox" name="categories[]" value="boys_singles"> Boys' Singles · PKR 1,000 per player</label>
          <label class="chip"><input type="checkbox" name="categories[]" value="girls_singles"> Girls' Singles · PKR 1,000 per player</label>
          <label class="chip"><input type="checkbox" name="categories[]" value="mixed_doubles"> Mixed Doubles · PKR 1,500 per pair</label>
        </div>
        <span class="err-msg" style="margin-top:8px">Please choose at least one category.</span>

        <h3 style="font-size:13px;letter-spacing:.18em;color:var(--dgold);margin:22px 0 10px;text-transform:uppercase;font-family:Inter,sans-serif">Players</h3>
        <p class="text-slate" style="margin:0 0 10px;font-size:13.5px">List the players you want to enter across all chosen categories. Add rows as needed (team entries use 2 players each; singles use 1; mixed doubles uses 1 boy + 1 girl per pair).</p>

        <div style="display:grid;gap:10px">
          <?php for ($i = 1; $i <= 8; $i++): ?>
          <div class="form-grid" style="margin:0">
            <label class="f"><span>Player <?= $i ?> — full name</span><input type="text" name="players[<?= $i ?>][name]"></label>
            <label class="f"><span>Class (e.g. FSc Part 1, A1)</span><input type="text" name="players[<?= $i ?>][class]"></label>
            <label class="f"><span>Date of birth (DD/MM/YYYY)</span><input type="text" name="players[<?= $i ?>][dob]" placeholder="DD/MM/YYYY"></label>
            <label class="f"><span>College ID number</span><input type="text" name="players[<?= $i ?>][student_id]"></label>
          </div>
          <?php endfor; ?>
        </div>
      </fieldset>

      <fieldset>
        <legend>STEP 3 · DOCUMENTS</legend>
        <div class="form-grid">
          <label class="f full"><span>Letter from your college confirming the players — PDF or photo, max 8 MB, or email it later (optional)</span><input type="file" name="letter" accept=".pdf,image/*"></label>
          <label class="f full"><span>Anything we should know? — accessibility needs, exam clashes on match days, questions (optional)</span><textarea name="notes" placeholder="Share any notes here…"><?= e(old('notes')) ?></textarea></label>
        </div>
      </fieldset>

      <fieldset>
        <legend>DECLARATIONS</legend>
        <div style="display:grid;gap:10px">
          <label class="consent" data-consent><input type="checkbox" name="confirm_eligibility" value="yes" required><span>I confirm that every player is currently enrolled at this college and meets the league eligibility rules. <span class="req">*</span></span></label>
          <label class="consent"><input type="checkbox" name="confirm_consent" value="yes" required><span>We will submit a signed parent or guardian consent form for every player under 18 before their first match. <span class="req">*</span></span></label>
          <label class="consent"><input type="checkbox" name="confirm_rules" value="yes" required><span>We agree to the league rules and fair-play code, and understand our place is confirmed once the entry fee is paid. <span class="req">*</span></span></label>
        </div>
        <span class="err-msg" style="margin-left:32px">Please confirm eligibility, consent and the rules.</span>
      </fieldset>

      <div class="actions">
        <button class="btn btn-primary btn-lg" type="submit"<?= $afterClose ? ' disabled' : '' ?>>Submit Registration</button>
        <span class="text-slate" style="font-size:13px">We use these details only to run the leagues, and never share them. APEX will email your invoice and the player document checklist within [2 working days].</span>
      </div>

      <p style="margin:18px 0 0;font-size:13.5px;color:var(--slate)">Registering a university instead? <a href="register-university.php">Go to University League registration</a>.</p>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
