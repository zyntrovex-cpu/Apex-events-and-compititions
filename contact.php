<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Contact APEX | Request an Event Proposal';
$pageDescription = 'Tell us about your school or college event and receive a tailored proposal from the APEX team.';

$prefillInterest = $_GET['interest'] ?? '';

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('proposal_ok');
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">CONTACT · REQUEST A PROPOSAL</p>
    <h1 class="disp">Let's Plan Your Institution's Next Big Day.</h1>
    <p class="lead">Share a few details about your event or competition and our team will get back to you within <?= e(setting('response_time','one working day')) ?> with ideas and a tailored proposal.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="display:grid;grid-template-columns:1.4fr 1fr;gap:36px;align-items:start">
    <div>
      <?php if ($ok): ?>
        <div class="alert ok"><h3>Thank you — your enquiry is in!</h3><p><?= e($ok) ?></p></div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
      <?php endif; ?>

      <form class="form card" style="padding:32px" method="POST" action="handlers/proposal.php" data-validate novalidate>
        <?= csrf_field() ?>
        <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

        <fieldset>
          <legend>ABOUT YOU</legend>
          <div class="form-grid">
            <label class="f" data-req><span>Full name <span class="req">*</span></span><input type="text" name="full_name" value="<?= e(old('full_name')) ?>" required><span class="err-msg">Please enter your name.</span></label>
            <label class="f" data-req><span>Designation <span class="req">*</span></span><input type="text" name="designation" value="<?= e(old('designation')) ?>" placeholder="e.g. Principal, Coordinator, President" required><span class="err-msg">Please tell us your role.</span></label>
            <label class="f" data-req><span>Institution name <span class="req">*</span></span><input type="text" name="institution_name" value="<?= e(old('institution_name')) ?>" required><span class="err-msg">Please enter your institution.</span></label>
            <label class="f" data-req><span>Institution type <span class="req">*</span></span>
              <select name="institution_type" required>
                <option value="">Select…</option>
                <?php foreach (['School','College','University','Academy / Institute','Corporation / Company','NGO / Foundation','Parent / Student','Other'] as $t): ?>
                  <option<?= old('institution_type')===$t?' selected':'' ?>><?= e($t) ?></option>
                <?php endforeach; ?>
              </select>
              <span class="err-msg">Please choose one.</span>
            </label>
            <label class="f" data-email><span>Email address</span><input type="email" name="email" value="<?= e(old('email')) ?>"><span class="err-msg">Please check the email.</span></label>
            <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="phone" value="<?= e(old('phone')) ?>" placeholder="+92 3XX XXXXXXX" required><span class="err-msg">Please enter a valid phone number.</span></label>
          </div>
        </fieldset>

        <fieldset id="interests" data-chips-required>
          <legend>WHAT ARE YOU INTERESTED IN? <span class="req">*</span></legend>
          <div class="chips-grid">
          <?php foreach ([
            'Organise a competition','Register for an APEX Championship','Sports tournament / sports day',
            'Annual day / convocation / ceremony','Cultural festival / talent show','Corporate event',
            'APEX Card','Become a partner / sponsor','Educational trip','Something else'
          ] as $opt): ?>
            <label class="chip"><input type="checkbox" name="interests[]" value="<?= e($opt) ?>"<?= $prefillInterest===$opt?' checked':'' ?>> <?= e($opt) ?></label>
          <?php endforeach; ?>
          </div>
          <span class="err-msg" style="margin-top:8px">Please choose at least one.</span>
        </fieldset>

        <fieldset>
          <legend>EVENT DETAILS</legend>
          <div class="form-grid">
            <label class="f"><span>Type of event</span><input type="text" name="event_type" value="<?= e(old('event_type')) ?>" placeholder="e.g. Annual Day, Science Fair"></label>
            <label class="f"><span>Expected date</span><input type="date" name="expected_date" value="<?= e(old('expected_date')) ?>"></label>
            <label class="f"><span>City / venue</span><input type="text" name="city_venue" value="<?= e(old('city_venue')) ?>"></label>
            <label class="f"><span>Expected number of students or guests</span>
              <select name="participants">
                <option value="">Select…</option>
                <?php foreach (['Under 100','100 – 300','300 – 1,000','1,000 – 5,000','Over 5,000','Not sure yet'] as $o): ?>
                  <option<?= old('participants')===$o?' selected':'' ?>><?= e($o) ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="f"><span>Approximate budget (optional)</span>
              <select name="budget">
                <option value="">Prefer not to say</option>
                <?php foreach (['Under PKR 100,000','PKR 100,000 – 500,000','PKR 500,000 – 2,000,000','Over PKR 2,000,000'] as $o): ?>
                  <option<?= old('budget')===$o?' selected':'' ?>><?= e($o) ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="f"><span>How did you hear about us?</span>
              <select name="source">
                <option value="">Select…</option>
                <?php foreach (['Facebook / Instagram','WhatsApp','Google search','Another school or company','At an APEX event','Other'] as $o): ?>
                  <option<?= old('source')===$o?' selected':'' ?>><?= e($o) ?></option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="f full"><span>Tell us about your event</span><textarea name="message" placeholder="Type of competition or event, goals, venue, anything we should know…"><?= e(old('message')) ?></textarea></label>
          </div>
        </fieldset>

        <div class="form" style="gap:10px">
          <label class="consent" data-consent><input type="checkbox" name="consent" value="yes" required><span>I agree that APEX may contact me by phone, WhatsApp or email about this enquiry. <span class="req">*</span></span></label>
          <span class="err-msg" style="margin-left:32px">Please tick to let us contact you.</span>
        </div>

        <div class="actions">
          <button class="btn btn-gold btn-lg" type="submit">Get My Free Proposal</button>
          <span class="text-slate" style="font-size:13px">We use your details only to reply to your enquiry and never share them.</span>
        </div>
      </form>
    </div>

    <aside class="reveal" style="position:sticky;top:20px">
      <div class="card card-navy" style="padding:28px">
        <p class="eyebrow">CONTACT DETAILS</p>
        <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:14px;color:var(--mist);font-size:14.5px;line-height:1.6">
          <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Office</b><?= nl2br(e(setting('contact_address'))) ?></li>
          <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Phone</b><a href="tel:<?= e(preg_replace('/[^0-9+]/','', setting('contact_phone'))) ?>" style="color:var(--gold)"><?= e(setting('contact_phone')) ?></a></li>
          <li><b style="color:var(--ivory);display:block;margin-bottom:2px">WhatsApp</b><a href="https://wa.me/<?= e(preg_replace('/[^0-9]/','', setting('contact_whatsapp'))) ?>" target="_blank" rel="noopener" style="color:var(--gold)"><?= e(setting('contact_whatsapp')) ?></a></li>
          <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Email</b><a href="mailto:<?= e(setting('contact_email')) ?>" style="color:var(--gold)"><?= e(setting('contact_email')) ?></a></li>
          <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Hours</b><?= e(setting('contact_hours')) ?></li>
        </ul>
      </div>

      <div class="card" style="padding:24px;margin-top:16px">
        <p class="eyebrow dark">THE APEX PROMISE</p>
        <ul style="list-style:none;padding:0;margin:10px 0 0;display:grid;gap:10px;font-size:14px;color:var(--slate)">
          <li>✓ Free, no-obligation proposal</li>
          <li>✓ Itemised costs with no hidden charges</li>
          <li>✓ Response within <?= e(setting('response_time','one working day')) ?></li>
          <li>✓ We never share your details</li>
        </ul>
      </div>
    </aside>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
<style>@media (max-width:860px){.container[style*="grid-template-columns:1.4fr 1fr"]{grid-template-columns:1fr !important}}</style>
