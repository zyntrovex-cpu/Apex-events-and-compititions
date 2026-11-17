<?php
$footerCompany = nav_items('footer_company');
$footerServices = nav_items('footer_services');
$footerFor = nav_items('footer_for');
$footerCard = nav_items('footer_card');
$socials = social_links_all();
?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="index.php" style="text-decoration:none;color:inherit;display:inline-flex;align-items:center;gap:10px">
          <svg viewBox="0 0 120 110" width="36" height="33" aria-hidden="true">
            <path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/>
            <path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#F6F3EC"/>
          </svg>
          <span>
            <span class="name">APEX</span>
            <span class="sub">EVENTS &amp; COMPETITIONS</span>
          </span>
        </a>
        <p>APEX Events &amp; Competitions plans and manages events and competitions for schools, colleges, universities and educational institutions — inter-school and inter-college competitions, sports championships, ceremonies, festivals, exhibitions and seminars.</p>
        <?php if ($socials): ?>
        <div class="footer-social">
          <?php foreach ($socials as $s):
            $icon = strtolower($s['platform']);
            $svg = [
              'facebook'  => '<path d="M22 12a10 10 0 1 0-11.56 9.87v-7H8v-2.87h2.44V9.8c0-2.4 1.43-3.74 3.62-3.74 1.05 0 2.15.19 2.15.19v2.37h-1.21c-1.2 0-1.57.74-1.57 1.5v1.8h2.68l-.43 2.87h-2.25v7A10 10 0 0 0 22 12z"/>',
              'instagram' => '<path d="M12 2.2c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.22.41.56.22.96.48 1.38.9s.68.82.9 1.38c.16.42.36 1.05.41 2.22.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.22-.22.56-.48.96-.9 1.38s-.82.68-1.38.9c-.42.16-1.05.36-2.22.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.22-.41-.56-.22-.96-.48-1.38-.9s-.68-.82-.9-1.38c-.16-.42-.36-1.05-.41-2.22-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.22.22-.56.48-.96.9-1.38s.82-.68 1.38-.9c.42-.16 1.05-.36 2.22-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07c-1.28.06-2.15.26-2.92.55-.79.3-1.46.71-2.13 1.38A5.9 5.9 0 0 0 .62 4.13C.33 4.9.13 5.77.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.28.26 2.15.55 2.92.3.79.71 1.46 1.38 2.13a5.9 5.9 0 0 0 2.13 1.38c.77.29 1.64.49 2.92.55C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.28-.06 2.15-.26 2.92-.55a5.9 5.9 0 0 0 2.13-1.38 5.9 5.9 0 0 0 1.38-2.13c.29-.77.49-1.64.55-2.92.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.28-.26-2.15-.55-2.92a5.9 5.9 0 0 0-1.38-2.13A5.9 5.9 0 0 0 19.87.62C19.1.33 18.23.13 16.95.07 15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm6.41-11.85a1.44 1.44 0 1 1-1.44-1.44 1.44 1.44 0 0 1 1.44 1.44z"/>',
              'linkedin'  => '<path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.13 1.45-2.13 2.94v5.67H9.35V9H12.8v1.56h.05A3.76 3.76 0 0 1 16.2 8.7c3.62 0 4.29 2.38 4.29 5.48zM5.34 7.43A2.06 2.06 0 1 1 7.4 5.37a2.06 2.06 0 0 1-2.06 2.06zM3.56 9h3.56v11.45H3.56zM22.23 0H1.77A1.76 1.76 0 0 0 0 1.73v20.54A1.77 1.77 0 0 0 1.77 24h20.46A1.78 1.78 0 0 0 24 22.27V1.73A1.77 1.77 0 0 0 22.23 0z"/>',
              'youtube'   => '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.6 3.6 12 3.6 12 3.6s-7.6 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.8.5 9.4.5 9.4.5s7.6 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.6 15.6V8.4L15.8 12z"/>',
              'whatsapp'  => '<path d="M17.47 14.38c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15s-.77.97-.95 1.17c-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.5-.5-.67-.51-.17 0-.37-.02-.57-.02s-.52.07-.8.37c-.27.3-1.05 1.02-1.05 2.48 0 1.47 1.07 2.88 1.22 3.08.15.2 2.1 3.2 5.08 4.5.71.3 1.26.48 1.69.62.71.23 1.36.2 1.87.12.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35M12.04 0C5.4 0 0 5.4 0 12.04c0 2.12.55 4.15 1.6 5.95L0 24l6.17-1.62a12 12 0 0 0 5.87 1.5h.01c6.63 0 12.04-5.4 12.04-12.04C24.1 5.4 18.68 0 12.04 0"/>',
            ][$icon] ?? '<circle cx="12" cy="12" r="9"/>';
            ?>
            <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><?= $svg ?></svg>
            </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <?php foreach ($footerCompany as $it): ?>
          <li><a href="<?= e($it['url']) ?>"><?= e($it['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Services</h4>
        <ul>
          <?php foreach ($footerServices as $it): ?>
          <li><a href="<?= e($it['url']) ?>"><?= e($it['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="footer-col">
        <h4>For</h4>
        <ul>
          <?php foreach ($footerFor as $it): ?>
          <li><a href="<?= e($it['url']) ?>"><?= e($it['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>

        <h4 style="margin-top:22px">APEX Card</h4>
        <ul>
          <?php foreach ($footerCard as $it): ?>
          <li><a href="<?= e($it['url']) ?>"><?= e($it['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Never miss a competition</h4>
        <p style="color:var(--mist);font-size:14px;margin:0 0 10px;line-height:1.6">Get news of upcoming inter-school and inter-college competitions and open registrations.</p>
        <form class="footer-newsletter" method="POST" action="handlers/newsletter.php" novalidate>
          <?= csrf_field() ?>
          <input type="email" name="email" placeholder="Your email" required aria-label="Email address">
          <button type="submit">Subscribe</button>
        </form>
        <?php if ($msg = flash_get('newsletter_ok')): ?>
          <p style="color:#B4E8C8;font-size:13px;margin-top:8px"><?= e($msg) ?></p>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer-bottom">
      <div>© <?= date('Y') ?> <?= e(setting('site_name','APEX Events & Competitions')) ?>. All rights reserved. · <a href="#">Privacy Policy</a> · <a href="#">Terms of Use</a></div>
      <div>Creating Experiences. Managing Competitions. Celebrating Excellence.</div>
    </div>
  </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
