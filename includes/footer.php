<?php
$socials = social_links_all();
?>
</main>

<footer class="site-footer site-footer-min">
  <div class="container">
    <div class="footer-min">
      <div class="footer-brand-min">
        <a href="index.php" aria-label="APEX Events &amp; Competitions — home">
          <svg viewBox="0 0 120 100" width="36" height="30" aria-hidden="true">
            <polygon points="15,95 50,15 85,95" fill="#F6F3EC"/>
            <polygon points="55,95 85,45 115,95" fill="#F56E2E"/>
          </svg>
          <span>
            <span class="name">APEX</span>
            <span class="sub">EVENTS &amp; COMPETITIONS</span>
          </span>
        </a>
      </div>

      <nav class="footer-nav-min" aria-label="Footer">
        <a href="index.php">Home</a>
        <a href="competitions.php">Competition</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
      </nav>

      <div class="footer-contact-min">
        <?php if (setting('contact_phone')): ?><a href="tel:<?= e(preg_replace('/[^0-9+]/','',setting('contact_phone'))) ?>"><?= e(setting('contact_phone')) ?></a><?php endif; ?>
        <?php if (setting('contact_email')): ?><a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a><?php endif; ?>
      </div>
    </div>

    <?php if ($socials): ?>
    <div class="footer-social-min">
      <?php foreach ($socials as $s): ?>
        <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>" title="<?= e($s['label']) ?>">
          <?= e(strtoupper(substr($s['platform'],0,1))) ?>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="footer-bottom-min">
      © <?= date('Y') ?> <?= e(setting('site_name','APEX Events &amp; Competitions')) ?>. Creating Experiences. Managing Competitions. Celebrating Excellence.
    </div>
  </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
