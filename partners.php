<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'Our Partners | APEX Events & Competitions';
$pageDescription = 'APEX partner institutions, sponsors, APEX Card discount partners, media, venue and production partners.';

$filterType = $_GET['type'] ?? '';
$filterCity = $_GET['city'] ?? '';
$q = trim($_GET['q'] ?? '');

try {
    $categories = db()->query('SELECT * FROM partner_categories ORDER BY sort_order')->fetchAll();
    $where = ['p.is_active=1']; $params = [];
    if ($filterType) { $where[] = 'pc.slug=?'; $params[] = $filterType; }
    if ($filterCity) { $where[] = 'p.city=?'; $params[] = $filterCity; }
    if ($q !== '') { $where[] = '(p.name LIKE ? OR p.description LIKE ? OR p.discount LIKE ?)'; $qq="%$q%"; array_push($params,$qq,$qq,$qq); }
    $sql = 'SELECT p.*, pc.name AS category_name, pc.slug AS category_slug, pc.description AS cat_desc FROM partners p LEFT JOIN partner_categories pc ON pc.id=p.category_id';
    if ($where) $sql .= ' WHERE '.implode(' AND ',$where);
    $sql .= ' ORDER BY pc.sort_order, p.sort_order';
    $stmt = db()->prepare($sql); $stmt->execute($params);
    $partners = $stmt->fetchAll();
    $cities = db()->query('SELECT DISTINCT city FROM partners WHERE city IS NOT NULL AND city<>"" AND is_active=1 ORDER BY city')->fetchAll(PDO::FETCH_COLUMN);

    $countsByCat = [];
    foreach ($partners as $p) { $countsByCat[$p['category_slug'] ?? ''] = ($countsByCat[$p['category_slug'] ?? ''] ?? 0) + 1; }
    $totalActive = count($partners);
} catch (Throwable $e) { $partners = $categories = $cities = []; $countsByCat = []; $totalActive = 0; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner">
    <div class="reveal" style="display:flex;flex-wrap:wrap;gap:24px;align-items:flex-end;justify-content:space-between">
      <div>
        <p class="eyebrow">OUR PARTNERS</p>
        <h1 class="disp">Partners who make it possible</h1>
        <p class="lead">The institutions, sponsors, businesses and experts who work with APEX to give students a bigger stage, and APEX Card holders bigger savings.</p>
      </div>
      <a class="btn btn-gold" href="#join">Become a Partner</a>
    </div>
  </div>
</section>

<section class="section-sm" style="background:#fff;border-bottom:1px solid var(--line)">
  <div class="container">
    <div class="chip-row reveal" style="margin-bottom:12px">
      <a class="chip-btn" href="partners.php" aria-pressed="<?= $filterType===''?'true':'false' ?>"><b>All partners</b> · <?= $totalActive ?></a>
      <?php foreach ($categories as $c):
        $cnt = (int)($countsByCat[$c['slug']] ?? 0);
        if ($cnt < 1) continue; ?>
        <a class="chip-btn" href="<?= e(url_with(['type'=>$c['slug']])) ?>" aria-pressed="<?= $filterType===$c['slug']?'true':'false' ?>"><?= e($c['name']) ?> · <?= $cnt ?></a>
      <?php endforeach; ?>
    </div>
    <form method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:end">
      <?php if ($filterType): ?><input type="hidden" name="type" value="<?= e($filterType) ?>"><?php endif; ?>
      <label class="f" style="min-width:260px"><span style="font-size:13px;color:var(--slate)">Search partners</span><input type="search" name="q" value="<?= e($q) ?>" placeholder="Name, city or discount" style="padding:10px 16px;border:1.5px solid var(--line);border-radius:999px;background:#fff;font:inherit;font-size:15px;min-height:42px"></label>
      <label class="f"><span style="font-size:13px;color:var(--slate)">City</span>
        <select name="city" style="padding:10px 16px;border:1.5px solid var(--line);border-radius:999px;background:#fff;font:inherit;font-size:15px;min-height:42px">
          <option value="">All cities</option>
          <?php foreach ($cities as $c): ?><option value="<?= e($c) ?>"<?= $filterCity===$c?' selected':'' ?>><?= e($c) ?></option><?php endforeach; ?>
        </select>
      </label>
      <button class="btn btn-navy btn-sm" type="submit">Apply</button>
    </form>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <?php if (!$partners): ?>
      <div class="card" style="padding:40px;text-align:center">
        <h3>No partners match these filters.</h3>
        <a class="btn btn-ghost" href="partners.php">Show all partners</a>
      </div>
    <?php else:
      $grouped = [];
      foreach ($partners as $p) { $grouped[$p['category_name'] ?? 'Partners'][] = $p; }
      foreach ($grouped as $catName => $ps):
        $catDesc = $ps[0]['cat_desc'] ?? '';
    ?>
      <section class="section-sm" id="<?= e($ps[0]['category_slug'] ?? '') ?>">
        <h2 class="disp"><?= e($catName) ?></h2>
        <?php if ($catDesc): ?><p class="text-slate" style="margin:0 0 20px"><?= e($catDesc) ?></p><?php endif; ?>
        <div class="grid grid-3 reveal">
          <?php foreach ($ps as $p): ?>
          <article class="card" style="padding:22px">
            <div style="display:flex;gap:14px;align-items:center;margin-bottom:12px">
              <div style="width:60px;height:60px;border-radius:14px;background:var(--ivory);border:1px solid var(--line);display:flex;align-items:center;justify-content:center;font-family:Archivo,sans-serif;font-weight:800;color:var(--dgold);font-size:20px">
                <?php if ($p['logo']): ?>
                  <img src="<?= e($p['logo']) ?>" alt="" style="max-width:100%;max-height:100%;object-fit:contain">
                <?php else:
                  $ini = strtoupper(substr(preg_replace('/[^A-Za-z]/','', $p['name']), 0, 2));
                  echo e($ini ?: 'AP'); endif; ?>
              </div>
              <div>
                <h3 style="font-size:17px;margin:0;line-height:1.25"><?= e($p['name']) ?></h3>
                <div style="font-size:13px;color:var(--slate);margin-top:3px"><?= e($p['city']) ?></div>
              </div>
            </div>
            <?php if ($p['discount']): ?><div style="background:var(--greenbg);color:var(--green);padding:9px 12px;border-radius:10px;font-weight:600;font-size:13.5px;margin-bottom:10px">APEX Card: <?= e($p['discount']) ?></div><?php endif; ?>
            <p style="margin:0;color:var(--slate);font-size:14px;line-height:1.55"><?= e($p['description']) ?></p>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:13px;color:var(--slate);flex-wrap:wrap;gap:8px">
              <?php if ($p['since_year'] && $p['since_year'] !== '[Year]'): ?><span>Partner since <?= e($p['since_year']) ?></span><?php else: ?><span></span><?php endif; ?>
              <?php if ($p['website'] && preg_match('~^https?://~', $p['website'])): ?><a href="<?= e($p['website']) ?>" target="_blank" rel="noopener">Visit website →</a><?php endif; ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; endif; ?>

    <section class="cta-band reveal" id="join" style="margin-top:40px">
      <div style="width:100%">
        <div style="display:flex;flex-wrap:wrap;gap:22px;align-items:center;justify-content:space-between;margin-bottom:22px">
          <div>
            <h2 class="disp">Become an APEX partner</h2>
            <p>Join a growing network of institutions and businesses that support students, competitions and learning.</p>
          </div>
          <a class="btn btn-gold" href="contact.php?interest=Become%20a%20partner%20%2F%20sponsor">Apply to Partner</a>
        </div>
        <div class="grid grid-3">
          <div style="background:var(--panel);border-radius:14px;padding:20px">
            <b style="color:var(--ivory);font-family:Archivo,sans-serif;display:block;margin-bottom:6px">Partner institutions</b>
            <span style="color:var(--mist);font-size:14px;line-height:1.5">Host APEX rounds on your campus, send teams to championships and get priority dates for your own events.</span>
          </div>
          <div style="background:var(--panel);border-radius:14px;padding:20px">
            <b style="color:var(--ivory);font-family:Archivo,sans-serif;display:block;margin-bottom:6px">APEX Card partners</b>
            <span style="color:var(--mist);font-size:14px;line-height:1.5">Offer cardholders an exclusive discount and get listed here, promoted at events and shared with families all year.</span>
          </div>
          <div style="background:var(--panel);border-radius:14px;padding:20px">
            <b style="color:var(--ivory);font-family:Archivo,sans-serif;display:block;margin-bottom:6px">Sponsors &amp; service partners</b>
            <span style="color:var(--mist);font-size:14px;line-height:1.5">Put your brand on the APEX stage, or supply venues, production, media or prizes in return for recognition.</span>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
