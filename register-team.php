<?php
require_once __DIR__ . '/config/app.php';

$slug = $_GET['competition'] ?? '';
$comp = null;
if ($slug) {
    try {
        $s = db()->prepare('SELECT c.*,cc.name AS category_name FROM competitions c LEFT JOIN competition_categories cc ON cc.id=c.category_id WHERE c.slug=? LIMIT 1');
        $s->execute([$slug]);
        $comp = $s->fetch() ?: null;
    } catch (Throwable $e) { $comp = null; }
}

$pageTitle = $comp ? ('Register Your Team — ' . $comp['name'] . ' | APEX') : 'Register Your Team | APEX';
$pageDescription = $comp ? ('Register your team for ' . $comp['name'] . '. Submit your coordinator and participant details securely to APEX.') : 'Register your team for an upcoming APEX competition.';

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('registration_ok');
?>

<section class="hero" style="padding-bottom:0">
  <div class="hero-inner reveal">
    <p class="eyebrow">REGISTRATION</p>
    <h1 class="disp"><?= $comp ? 'Register for ' . e($comp['name']) : 'Team Registration' ?></h1>
    <?php if ($comp): ?>
      <p class="lead"><?= e($comp['category_name']) ?> · <?= e(format_date($comp['event_date'])) ?> · <?= e($comp['city'] ?: 'Multiple cities') ?></p>
    <?php else: ?>
      <p class="lead">Please choose a competition from the <a href="calendar.php" style="color:var(--gold)">calendar</a>.</p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:860px;margin-left:auto;margin-right:auto">
    <?php if ($ok): ?>
      <div class="alert ok"><h3>Your team is registered!</h3><p><?= e($ok) ?></p></div>
    <?php endif; ?>
    <?php if ($errors): ?>
      <div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <?php if (!$comp): ?>
      <div class="card" style="padding:32px;text-align:center">
        <p>No competition selected. Browse the calendar to choose one.</p>
        <a class="btn btn-navy" href="calendar.php">See upcoming competitions</a>
      </div>
    <?php else: ?>
    <form class="form card" style="padding:32px" method="POST" action="handlers/register_team.php" data-validate novalidate>
      <?= csrf_field() ?>
      <input type="hidden" name="competition_id" value="<?= e($comp['id']) ?>">
      <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

      <fieldset>
        <legend>INSTITUTION</legend>
        <div class="form-grid">
          <label class="f" data-req><span>Institution name <span class="req">*</span></span><input type="text" name="institution_name" value="<?= e(old('institution_name')) ?>" required><span class="err-msg">Please enter the institution name.</span></label>
          <label class="f"><span>Institution type</span>
            <select name="institution_type">
              <option value="">Select…</option>
              <?php foreach (['School','College','University','Academy / Institute','NGO / Foundation','Other'] as $t): ?>
                <option<?= old('institution_type')===$t?' selected':'' ?>><?= e($t) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label class="f" data-req><span>City <span class="req">*</span></span><input type="text" name="city" value="<?= e(old('city')) ?>" required><span class="err-msg">Please enter the city.</span></label>
          <label class="f"><span>Category level</span>
            <select name="category_level">
              <option value="">Select…</option>
              <?php foreach (['Junior','Middle','Senior','College & University','Open & Corporate'] as $l): ?>
                <option<?= old('category_level')===$l?' selected':'' ?>><?= e($l) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend>COORDINATOR</legend>
        <div class="form-grid">
          <label class="f" data-req><span>Coordinator name <span class="req">*</span></span><input type="text" name="coordinator_name" value="<?= e(old('coordinator_name')) ?>" required><span class="err-msg">Please enter the coordinator's name.</span></label>
          <label class="f"><span>Role / designation</span><input type="text" name="coordinator_role" value="<?= e(old('coordinator_role')) ?>" placeholder="e.g. Teacher, Section Head"></label>
          <label class="f" data-email data-req><span>Coordinator email <span class="req">*</span></span><input type="email" name="coordinator_email" value="<?= e(old('coordinator_email')) ?>" required><span class="err-msg">Please check the email address.</span></label>
          <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="coordinator_phone" value="<?= e(old('coordinator_phone')) ?>" placeholder="+92 3XX XXXXXXX" required><span class="err-msg">Please enter a valid phone number.</span></label>
        </div>
      </fieldset>

      <fieldset>
        <legend>TEAM</legend>
        <div class="form-grid">
          <label class="f"><span>Team name (optional)</span><input type="text" name="team_name" value="<?= e(old('team_name')) ?>"></label>
          <label class="f"><span>Team size</span><input type="number" name="team_size" min="1" max="30" value="<?= e(old('team_size')) ?>" placeholder="<?= e($comp['team_size'] ?: '') ?>"></label>
        </div>

        <h3 style="font-size:14px;letter-spacing:.18em;color:var(--dgold);margin:18px 0 10px;text-transform:uppercase;font-family:Inter,sans-serif">Participants</h3>
        <p class="text-slate" style="font-size:13.5px;margin:0 0 10px">List up to 5 participants. Students under 18 are registered by their school, parent or guardian.</p>
        <div id="participants">
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <div class="form-grid" style="margin-bottom:10px">
            <label class="f"><span>Participant <?= $i ?> — name</span><input type="text" name="participants[<?= $i ?>][name]"></label>
            <label class="f"><span>Class / grade</span><input type="text" name="participants[<?= $i ?>][class_grade]"></label>
            <label class="f"><span>Age</span><input type="number" name="participants[<?= $i ?>][age]" min="4" max="99"></label>
          </div>
          <?php endfor; ?>
        </div>
      </fieldset>

      <fieldset>
        <legend>ADDITIONAL NOTES</legend>
        <label class="f full"><span>Anything we should know?</span><textarea name="notes" placeholder="Dietary requirements, accessibility needs, prior experience…"><?= e(old('notes')) ?></textarea></label>
      </fieldset>

      <div class="form" style="gap:10px">
        <label class="consent" data-consent><input type="checkbox" name="consent" value="yes" required><span>I confirm the information is correct and agree that APEX may contact the coordinator about this registration. For participants under 18, I confirm the school / parent / guardian has consented. <span class="req">*</span></span></label>
        <span class="err-msg" style="margin-left:32px">Please tick to continue.</span>
      </div>

      <div class="actions">
        <button class="btn btn-gold btn-lg" type="submit">Submit Registration</button>
        <span class="text-slate" style="font-size:13px">Our team will contact the coordinator within <?= e(setting('response_time','one working day')) ?>.</span>
      </div>
    </form>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
