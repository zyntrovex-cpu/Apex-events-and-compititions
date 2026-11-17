<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Sponsor APEX Championships | Sponsorship Opportunities';
$pageDescription = 'Sponsor APEX championships, cups and leagues — title, gold, silver and category sponsorship tiers for schools, colleges and universities.';

try {
    $tiers = db()->query('SELECT * FROM sponsorship_tiers WHERE is_active=1 ORDER BY sort_order')->fetchAll();
} catch (Throwable $e) { $tiers = []; }

include __DIR__ . '/includes/header.php';

$errors = errors_get();
$ok = flash_get('sponsor_ok');
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">SPONSORSHIP</p>
    <h1 class="disp">Put Your Brand on the APEX Stage.</h1>
    <p class="lead">Sponsor an APEX championship, cup or league and reach thousands of students, parents, teachers and campus communities with a brand people trust.</p>
    <div class="hero-actions">
      <a class="btn btn-gold btn-lg" href="#apply">Apply to Sponsor</a>
      <a class="btn btn-outline-ivory btn-lg" href="#tiers">See Tiers</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container grid grid-asym reveal">
    <div>
      <p class="eyebrow dark">WHY SPONSOR APEX</p>
      <h2 class="disp">An engaged, educated, growing audience</h2>
      <p class="lead">APEX championships bring together schools, colleges, universities and families across multiple cities. Your brand reaches a highly engaged education audience — from decision-making principals and parents, to teenagers and students who are forming lifelong brand preferences.</p>
      <ul style="list-style:none;padding:0;margin:0;display:grid;gap:12px">
        <?php foreach ([
          'Prime stage exposure at live finals, award nights and opening ceremonies',
          'Branded certificates, backdrops, banners and trophies',
          'Press releases, media partnerships and social media campaigns',
          'Access to a loyal, repeat audience through the APEX Card',
          'Alignment with safety, fair play and educational excellence',
        ] as $b): ?>
          <li style="display:flex;gap:12px;align-items:flex-start;font-size:15px;color:var(--slate)"><svg width="22" height="22" viewBox="0 0 24 24" fill="#D4A63A" aria-hidden="true"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19 20 8l-1.5-1.5z"/></svg><span><?= e($b) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card card-navy" style="padding:28px">
      <p class="eyebrow">SPONSORSHIP IMPACT</p>
      <div class="grid grid-2" style="gap:14px;margin-top:14px">
        <div style="background:var(--panel);border-radius:12px;padding:16px;text-align:center">
          <b style="font-family:Archivo,sans-serif;font-size:28px;color:var(--gold)">8+</b>
          <div style="color:var(--mist);font-size:13.5px;margin-top:4px">Cities covered</div>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px;text-align:center">
          <b style="font-family:Archivo,sans-serif;font-size:28px;color:var(--gold)">12k+</b>
          <div style="color:var(--mist);font-size:13.5px;margin-top:4px">Students engaged</div>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px;text-align:center">
          <b style="font-family:Archivo,sans-serif;font-size:28px;color:var(--gold)">50+</b>
          <div style="color:var(--mist);font-size:13.5px;margin-top:4px">Institutions reached</div>
        </div>
        <div style="background:var(--panel);border-radius:12px;padding:16px;text-align:center">
          <b style="font-family:Archivo,sans-serif;font-size:28px;color:var(--gold)">12m</b>
          <div style="color:var(--mist);font-size:13.5px;margin-top:4px">Of annual exposure</div>
        </div>
      </div>
      <p style="margin-top:14px;color:var(--mist);font-size:12.5px;opacity:.75">Figures are placeholders until confirmed by your administrator.</p>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff" id="tiers">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">SPONSORSHIP TIERS</p>
      <h2 class="disp">Choose the recognition that matches your brand</h2>
      <p class="lead">Every tier is available for individual championships, seasonal leagues and a full annual sponsorship. All prices are managed by the APEX administrator and confirmed during the enquiry.</p>
    </div>
    <div class="grid grid-3 reveal">
      <?php foreach ($tiers as $t):
        $benefits = array_filter(array_map('trim', explode('|', $t['benefits'] ?? ''))); ?>
      <div class="tier<?= $t['is_featured'] ? ' featured' : '' ?>">
        <?php if ($t['is_featured']): ?><span class="ribbon">Headline</span><?php endif; ?>
        <h3><?= e($t['name']) ?></h3>
        <p class="tagline"><?= e($t['tagline']) ?></p>
        <div class="price"><?= e($t['price']) ?></div>
        <ul>
          <?php foreach ($benefits as $b): ?><li><?= e($b) ?></li><?php endforeach; ?>
        </ul>
        <a class="btn <?= $t['is_featured'] ? 'btn-gold' : 'btn-navy' ?>" href="#apply" style="margin-top:auto;align-self:flex-start">Enquire about this tier</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="reveal" style="max-width:720px;margin-bottom:28px">
      <p class="eyebrow dark">COMPARISON</p>
      <h2 class="disp">Sponsorship benefits at a glance</h2>
    </div>
    <div class="reveal" style="overflow-x:auto">
      <table class="tbl" style="min-width:720px">
        <thead><tr><th>Benefit</th><?php foreach ($tiers as $t): ?><th><?= e($t['name']) ?></th><?php endforeach; ?></tr></thead>
        <tbody>
          <?php
          $rows = [
            'Logo on stage and backdrop' => ['Title'=>'✓','Gold'=>'✓','Silver'=>'✓','Category'=>'✓','In-Kind'=>'—'],
            'Named championship / category' => ['Title'=>'✓','Gold'=>'—','Silver'=>'—','Category'=>'✓','In-Kind'=>'—'],
            'Speaking slot at ceremony' => ['Title'=>'✓','Gold'=>'✓','Silver'=>'—','Category'=>'—','In-Kind'=>'—'],
            'Social media feature' => ['Title'=>'✓','Gold'=>'✓','Silver'=>'✓','Category'=>'✓','In-Kind'=>'✓'],
            'Branded certificates' => ['Title'=>'✓','Gold'=>'✓','Silver'=>'—','Category'=>'✓','In-Kind'=>'—'],
            'VIP invitations' => ['Title'=>'✓','Gold'=>'✓','Silver'=>'✓','Category'=>'—','In-Kind'=>'—'],
          ];
          foreach ($rows as $label=>$map): ?>
          <tr><td style="font-weight:600"><?= e($label) ?></td>
          <?php foreach ($tiers as $t): $k = explode(' ', $t['name'])[0]; echo '<td>' . e($map[$k] ?? '—') . '</td>'; endforeach; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section section-panel" style="background:#fff" id="apply">
  <div class="container" style="max-width:860px;margin-left:auto;margin-right:auto">
    <div class="reveal" style="margin-bottom:24px">
      <p class="eyebrow dark">APPLY</p>
      <h2 class="disp">Sponsorship enquiry</h2>
      <p class="lead">Tell us about your brand and preferred tier. We'll come back with a proposal, media kit and conversation.</p>
    </div>

    <?php if ($ok): ?><div class="alert ok"><h3>Thank you!</h3><p><?= e($ok) ?></p></div><?php endif; ?>
    <?php if ($errors): ?><div class="alert err"><h3>Please check the form</h3><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form class="form card" style="padding:32px" method="POST" action="handlers/sponsor.php" data-validate novalidate>
      <?= csrf_field() ?>
      <p class="hidden-h"><label>Leave this empty: <input name="website_url" tabindex="-1" autocomplete="off"></label></p>

      <fieldset>
        <legend>ABOUT YOUR COMPANY</legend>
        <div class="form-grid">
          <label class="f" data-req><span>Company name <span class="req">*</span></span><input type="text" name="company_name" value="<?= e(old('company_name')) ?>" required><span class="err-msg">Please enter your company name.</span></label>
          <label class="f" data-req><span>Contact person <span class="req">*</span></span><input type="text" name="contact_person" value="<?= e(old('contact_person')) ?>" required><span class="err-msg">Please enter a contact name.</span></label>
          <label class="f"><span>Designation</span><input type="text" name="designation" value="<?= e(old('designation')) ?>"></label>
          <label class="f" data-email data-req><span>Email <span class="req">*</span></span><input type="email" name="email" value="<?= e(old('email')) ?>" required><span class="err-msg">Please check your email address.</span></label>
          <label class="f" data-req><span>Phone / WhatsApp <span class="req">*</span></span><input type="tel" name="phone" value="<?= e(old('phone')) ?>" required placeholder="+92 3XX XXXXXXX"><span class="err-msg">Please enter a valid phone number.</span></label>
          <label class="f"><span>Preferred tier</span>
            <select name="tier_id">
              <option value="">Not sure yet</option>
              <?php foreach ($tiers as $t): ?><option value="<?= e($t['id']) ?>"<?= (old('tier_id')==$t['id'])?' selected':'' ?>><?= e($t['name']) ?></option><?php endforeach; ?>
            </select>
          </label>
          <label class="f full"><span>Interests / championships</span>
            <input type="text" name="interests" value="<?= e(old('interests')) ?>" placeholder="e.g. APEX Quiz Championship, APEX Sports League">
          </label>
          <label class="f"><span>Proposed contribution / budget</span><input type="text" name="budget" value="<?= e(old('budget')) ?>" placeholder="[PKR ___] or product / service"></label>
          <label class="f full"><span>Additional message</span><textarea name="message" placeholder="Anything else we should know about your brand, goals or timeline…"><?= e(old('message')) ?></textarea></label>
        </div>
      </fieldset>

      <div class="actions">
        <button class="btn btn-gold btn-lg" type="submit">Send Sponsorship Enquiry</button>
        <span class="text-slate" style="font-size:13px">The APEX team will reply within <?= e(setting('response_time','one working day')) ?>.</span>
      </div>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
