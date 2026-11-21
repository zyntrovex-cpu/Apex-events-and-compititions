<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Contact · APEX Events & Competitions';
$pageDescription = 'Contact APEX about the All Karachi Table Tennis Leagues — sports departments, players, parents, media and sponsors.';

$prefillSubject = $_GET['subject'] ?? '';

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('contact_ok');
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">CONTACT</p>
    <h1 class="disp">Talk to the APEX team.</h1>
    <p class="lead">Questions about the All Karachi Table Tennis Leagues? Sports departments, players, parents, media and sponsors — we'd love to hear from you.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="display:grid;grid-template-columns:1.4fr 1fr;gap:36px;align-items:start" id="contact-grid">
    <div>
      <?php if ($ok): ?>
        <div class="alert ok"><h3>Thank you — your message is in!</h3><p><?= e($ok) ?></p></div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div>
      <?php endif; ?>

      <form class="form card" style="padding:32px" method="POST" action="handlers/contact.php" data-validate novalidate>
        <?= csrf_field() ?>
        <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

        <div class="form-grid">
          <label class="f" data-req><span>Your name <span class="req">*</span></span>
            <input type="text" name="name" value="<?= e(old('name')) ?>" required>
            <span class="err-msg">Please enter your name.</span>
          </label>
          <label class="f" data-req data-email><span>Email <span class="req">*</span></span>
            <input type="email" name="email" value="<?= e(old('email')) ?>" required>
            <span class="err-msg">Please check the email address.</span>
          </label>
          <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span>
            <input type="tel" name="phone" value="<?= e(old('phone')) ?>" placeholder="+92 3XX XXXXXXX" required>
            <span class="err-msg">Please enter a valid phone number.</span>
          </label>
          <label class="f"><span>I am a / an</span>
            <select name="role">
              <option value="">Select…</option>
              <option>Sports department / institution</option>
              <option>Player / student</option>
              <option>Parent / guardian</option>
              <option>Sponsor</option>
              <option>Media</option>
              <option>Other</option>
            </select>
          </label>
          <label class="f full"><span>Subject</span>
            <input type="text" name="subject" value="<?= e(old('subject', $prefillSubject)) ?>" placeholder="e.g. University League registration, Sponsorship, Finals Day">
          </label>
          <label class="f full" data-req><span>Message <span class="req">*</span></span>
            <textarea name="message" required placeholder="Tell us how we can help…"><?= e(old('message')) ?></textarea>
            <span class="err-msg">Please add a short message.</span>
          </label>
        </div>

        <div class="form" style="gap:10px">
          <label class="consent" data-consent><input type="checkbox" name="consent" value="yes" required><span>I agree that APEX may contact me about this enquiry. <span class="req">*</span></span></label>
          <span class="err-msg" style="margin-left:32px">Please tick to let us contact you.</span>
        </div>

        <div class="actions">
          <button class="btn btn-primary btn-lg" type="submit">Send Message</button>
          <span class="text-slate" style="font-size:13px">We'll reply within <?= e(setting('response_time','one working day')) ?>.</span>
        </div>
      </form>
    </div>

    <aside class="reveal" style="position:sticky;top:90px">
      <div class="card card-navy" style="padding:28px">
        <p class="eyebrow">CONTACT DETAILS</p>
        <ul style="list-style:none;padding:0;margin:14px 0 0;display:grid;gap:14px;color:var(--mist);font-size:14.5px;line-height:1.6">
          <?php if (setting('contact_phone')): ?>
            <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Phone</b><a href="tel:<?= e(preg_replace('/[^0-9+]/','', setting('contact_phone'))) ?>" style="color:var(--gold)"><?= e(setting('contact_phone')) ?></a></li>
          <?php endif; ?>
          <?php if (setting('contact_whatsapp')): ?>
            <li><b style="color:var(--ivory);display:block;margin-bottom:2px">WhatsApp</b><a href="https://wa.me/<?= e(preg_replace('/[^0-9]/','', setting('contact_whatsapp'))) ?>" target="_blank" rel="noopener" style="color:var(--gold)"><?= e(setting('contact_whatsapp')) ?></a></li>
          <?php endif; ?>
          <?php if (setting('contact_email')): ?>
            <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Email</b><a href="mailto:<?= e(setting('contact_email')) ?>" style="color:var(--gold)"><?= e(setting('contact_email')) ?></a></li>
          <?php endif; ?>
          <?php if (setting('contact_hours')): ?>
            <li><b style="color:var(--ivory);display:block;margin-bottom:2px">Hours</b><?= e(setting('contact_hours')) ?></li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="card" style="padding:24px;margin-top:16px">
        <p class="eyebrow dark">QUICK LINKS</p>
        <ul style="list-style:none;padding:0;margin:10px 0 0;display:grid;gap:10px;font-size:14.5px">
          <li>→ <a href="competitions.php">League details</a></li>
          <li>→ <a href="register-university.php">University League registration</a></li>
          <li>→ <a href="register-college.php">College League registration</a></li>
        </ul>
      </div>
    </aside>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
<style>@media (max-width:860px){#contact-grid{grid-template-columns:1fr !important}}</style>
