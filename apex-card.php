<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'APEX Card | Education Discount Card for Students';
$pageDescription = 'Save on competition fees, tuition, books, courses and more with the APEX Card — for students, families and institutions.';

try {
    $cardTypes = db()->query('SELECT * FROM apex_card_types WHERE is_active=1 ORDER BY sort_order')->fetchAll();
    $cardPartners = db()->query('SELECT p.*, pc.name AS category_name FROM partners p LEFT JOIN partner_categories pc ON pc.id=p.category_id WHERE p.is_card_partner=1 AND p.is_active=1 ORDER BY pc.sort_order, p.sort_order LIMIT 20')->fetchAll();
} catch (Throwable $e) { $cardTypes = $cardPartners = []; }

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('card_ok');
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">APEX CARD</p>
    <h1 class="disp">One Card. Savings on Learning All Year.</h1>
    <p class="lead">The APEX Card gives students, families and institutions discounts on competitions, tuition, books, courses and more across the APEX partner network — for a full 12 months.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="#apply">Apply for Your Card</a>
      <a class="btn btn-outline-ivory btn-lg" href="#partners">See Partner Discounts</a>
    </div>
  </div>
</section>

<!-- Intro -->
<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">INTRODUCTION</p>
      <h2 class="disp">What Is the APEX Card?</h2>
      <p class="lead">Education adds up: competition fees, tuition, books, stationery, courses and workshops. The APEX Card is a yearly membership card that brings those costs down. Show your card — physical or digital — at any APEX partner and the discount is applied on the spot.</p>
      <p class="lead">Cardholders also get priority access to APEX Signature Championships and members-only rewards throughout the year.</p>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">BENEFITS</p>
      <h3 style="color:var(--ivory);margin-top:6px">What cardholders get</h3>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:10px">
        <?php foreach (['Up to [X]% off registration for APEX competitions and Signature Championships','Discounts at partner academies, tuition centres and test-preparation institutes','Savings on books, stationery, bags and uniforms at partner stores','Reduced fees on online courses, skills workshops and APEX seminars','Early access to limited seats in championships, events and workshops','Scholarship draws, free event passes and special member offers through the year'] as $b): ?>
          <li style="display:flex;gap:10px;align-items:flex-start;color:var(--mist);font-size:14.5px"><svg width="20" height="20" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span><?= e($b) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- Card types -->
<section class="section section-panel" style="background:#fff">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">CARD TYPES</p>
      <h2 class="disp">Choose Your Card</h2>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($cardTypes as $i => $t):
        $benefits = array_filter(array_map('trim', explode('|', $t['benefits'] ?? '')));
      ?>
      <div class="tier<?= $i===0 ? ' featured' : '' ?>">
        <?php if ($i===0): ?><span class="ribbon">Most popular</span><?php endif; ?>
        <h3><?= e($t['name']) ?></h3>
        <p class="tagline"><?= e($t['tagline']) ?></p>
        <div class="price"><?= e($t['price']) ?></div>
        <p style="margin:0;color:<?= $i===0 ? 'var(--mist)' : 'var(--slate)' ?>;font-size:14px"><?= e($t['description']) ?></p>
        <ul>
          <?php foreach ($benefits as $b): ?><li><?= e($b) ?></li><?php endforeach; ?>
        </ul>
        <a class="btn <?= $i===0 ? 'btn-gold' : 'btn-navy' ?>" href="#apply" style="margin-top:auto;align-self:flex-start">Apply for this card</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- How it works -->
<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">HOW IT WORKS</p>
      <h2 class="disp">Start Saving in Four Steps</h2>
    </div>
    <div class="steps reveal">
      <div class="step"><div class="n">01</div><div><h3>Apply</h3><p>Fill in the online form. Students under 18 apply through a parent, guardian or their school.</p></div></div>
      <div class="step"><div class="n">02</div><div><h3>Pay</h3><p>Pay the yearly fee online, by bank transfer or through your school.</p></div></div>
      <div class="step"><div class="n">03</div><div><h3>Get your card</h3><p>Receive your digital card by email or WhatsApp within [<?= e(setting('digital_card_days','2')) ?>] working days, and your printed card within [<?= e(setting('printed_card_days','7–10')) ?>] days.</p></div></div>
      <div class="step"><div class="n">04</div><div><h3>Show &amp; save</h3><p>Show your card or scan its QR code at any APEX partner to get your discount. Renew each year to keep saving.</p></div></div>
    </div>
  </div>
</section>

<!-- Partner directory -->
<section class="section section-panel" style="background:#fff" id="partners">
  <div class="container">
    <div class="reveal" style="max-width:680px;margin-bottom:28px">
      <p class="eyebrow dark">PARTNER NETWORK</p>
      <h2 class="disp">Where You Can Use It</h2>
      <p class="lead">Current APEX Card partners by category. For the complete partner directory with search, visit <a href="partners.php">Partners</a>.</p>
    </div>
    <div class="grid grid-3 reveal">
      <?php if (!$cardPartners): ?>
        <div class="card" style="padding:24px"><p class="text-slate">The APEX partner network is growing. Check back soon.</p></div>
      <?php else: foreach ($cardPartners as $p): ?>
      <article class="card" style="padding:22px">
        <div style="display:flex;gap:12px;align-items:center;margin-bottom:12px">
          <div style="width:52px;height:52px;border-radius:12px;background:var(--ivory);border:1px solid var(--line);display:flex;align-items:center;justify-content:center;font-family:Archivo,sans-serif;font-weight:800;color:var(--dgold)">
            <?php if ($p['logo']): ?><img src="<?= e($p['logo']) ?>" alt="" style="max-width:100%;max-height:100%;object-fit:contain"><?php else: $ini = strtoupper(preg_replace('/[^A-Z]/','', strtoupper($p['name']))); echo e(substr($ini, 0, 2) ?: 'AP'); endif; ?>
          </div>
          <div>
            <h3 style="font-size:16px;margin:0"><?= e($p['name']) ?></h3>
            <div style="font-size:13px;color:var(--slate)"><?= e($p['city']) ?></div>
          </div>
        </div>
        <?php if ($p['discount']): ?><div style="background:var(--greenbg);color:var(--green);padding:9px 12px;border-radius:10px;font-weight:600;font-size:13.5px">APEX Card: <?= e($p['discount']) ?></div><?php endif; ?>
        <?php if ($p['description']): ?><p style="margin:10px 0 0;color:var(--slate);font-size:14px"><?= e($p['description']) ?></p><?php endif; ?>
      </article>
      <?php endforeach; endif; ?>
    </div>
    <div style="margin-top:28px"><a class="btn btn-navy" href="partners.php#card">See all APEX Card partners</a></div>
  </div>
</section>

<!-- Application form -->
<section class="section" id="apply">
  <div class="container" style="max-width:860px;margin-left:auto;margin-right:auto">
    <div class="reveal" style="margin-bottom:24px">
      <p class="eyebrow dark">APPLY</p>
      <h2 class="disp">Apply for Your APEX Card</h2>
      <p class="lead">Students under 18 apply through a parent, guardian or their school. We collect the minimum data needed, and the printed card arrives within [<?= e(setting('printed_card_days','7–10')) ?>] days.</p>
    </div>

    <?php if ($ok): ?><div class="alert ok"><h3>Thank you — your APEX Card application has been received!</h3><p><?= e($ok) ?></p></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form class="form card" style="padding:32px" method="POST" action="handlers/card_apply.php" enctype="multipart/form-data" data-validate novalidate>
      <?= csrf_field() ?>
      <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

      <fieldset>
        <legend>CARD CHOICE</legend>
        <div class="form-grid">
          <label class="f" data-req><span>Card type <span class="req">*</span></span>
            <select name="card_type_id" required>
              <option value="">Select…</option>
              <?php foreach ($cardTypes as $t): ?>
                <option value="<?= e($t['id']) ?>" data-name="<?= e($t['name']) ?>"><?= e($t['name']) ?> — <?= e($t['price']) ?></option>
              <?php endforeach; ?>
            </select>
            <span class="err-msg">Please choose a card type.</span>
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend>STUDENT DETAILS</legend>
        <div class="form-grid">
          <label class="f" data-req><span>Student's full name <span class="req">*</span></span><input type="text" name="student_name" value="<?= e(old('student_name')) ?>" required><span class="err-msg">Please enter the student's name.</span></label>
          <label class="f"><span>Date of birth</span><input type="date" name="date_of_birth" value="<?= e(old('date_of_birth')) ?>"></label>
          <label class="f" data-req><span>Institution name &amp; class/year <span class="req">*</span></span><input type="text" name="institution_class" value="<?= e(old('institution_class')) ?>" required placeholder="e.g. Beaconhouse, Grade 9"><span class="err-msg">Please enter the institution and class.</span></label>
          <label class="f"><span>Parent / guardian name (required for under 18)</span><input type="text" name="guardian_name" value="<?= e(old('guardian_name')) ?>"></label>
          <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="phone" value="<?= e(old('phone')) ?>" placeholder="+92 3XX XXXXXXX" required><span class="err-msg">Please enter a valid phone number.</span></label>
          <label class="f" data-email><span>Email address</span><input type="email" name="email" value="<?= e(old('email')) ?>"><span class="err-msg">Please check your email address.</span></label>
          <label class="f" data-req><span>City <span class="req">*</span></span><input type="text" name="city" value="<?= e(old('city')) ?>" required><span class="err-msg">Please enter your city.</span></label>
          <label class="f full" data-req><span>Delivery address for printed card <span class="req">*</span></span><textarea name="delivery_address" required><?= e(old('delivery_address')) ?></textarea><span class="err-msg">Please enter a delivery address.</span></label>
          <label class="f full"><span>Student photo (optional, for printed card)</span><input type="file" name="photo" accept="image/*"></label>
        </div>
      </fieldset>

      <div class="form" style="gap:10px">
        <label class="consent" data-consent><input type="checkbox" name="consent" value="yes" required><span>I agree to the APEX Card terms and conditions, and (for applicants under 18) confirm that a parent or guardian has consented. <span class="req">*</span></span></label>
        <span class="err-msg" style="margin-left:32px">Please tick to continue.</span>
      </div>

      <div class="actions">
        <button class="btn btn-gold btn-lg" type="submit">Apply for My Card</button>
        <span class="text-slate" style="font-size:13px">We'll confirm payment details within <?= e(setting('response_time','one working day')) ?>.</span>
      </div>
    </form>
  </div>
</section>

<!-- Terms -->
<section class="section" id="terms" style="padding-top:0">
  <div class="container" style="max-width:860px;margin-left:auto;margin-right:auto">
    <div class="card" style="padding:28px">
      <p class="eyebrow dark">TERMS SUMMARY</p>
      <h3 style="font-size:20px;margin:6px 0 14px">APEX Card Terms &amp; Conditions</h3>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:9px;color:var(--slate);font-size:14.5px">
        <li>• The card is valid for <?= e(setting('apex_card_renewal','12 months')) ?> from the date of issue.</li>
        <li>• The card is personal and cannot be transferred. Partners may ask for student ID.</li>
        <li>• Discounts are offered by partners and may change; the latest offers are always listed on this page.</li>
        <li>• Discounts cannot be combined with other offers unless the partner allows it.</li>
        <li>• Lost or damaged cards can be replaced for [PKR ___].</li>
      </ul>
      <p style="margin-top:14px;font-size:13px;color:var(--slate)"><b>Privacy:</b> we collect only the minimum data needed to issue the card. For anyone under 18, we need a parent or guardian's consent.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container">
    <div class="cta-band reveal">
      <div>
        <h2 class="disp">Become an APEX Card Partner</h2>
        <p>Reach thousands of students and families. APEX Card partners are listed in our directory, featured at APEX events and promoted to cardholders throughout the year — in return for an exclusive discount.</p>
      </div>
      <a class="btn btn-gold" href="partners.php#join">Become a Partner</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
