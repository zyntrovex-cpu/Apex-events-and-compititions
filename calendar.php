<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'APEX Calendar | Upcoming Competitions';
$pageDescription = 'Browse upcoming APEX competitions and championships by date, category and city.';

$filterCat = $_GET['category'] ?? '';
$filterMonth = $_GET['month'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$q = trim($_GET['q'] ?? '');

$where = [];
$params = [];
if ($filterCat) { $where[] = 'cc.slug=?'; $params[] = $filterCat; }
if ($filterMonth && preg_match('/^\d{4}-\d{2}$/', $filterMonth)) {
    $where[] = "DATE_FORMAT(c.event_date,'%Y-%m')=?"; $params[] = $filterMonth;
}
if ($filterStatus) { $where[] = 'c.registration_status=?'; $params[] = $filterStatus; }
if ($q !== '') { $where[] = '(c.name LIKE ? OR c.city LIKE ? OR c.venue LIKE ?)'; $qq = "%$q%"; array_push($params, $qq, $qq, $qq); }

$sql = "SELECT c.*,cc.name AS category_name,cc.slug AS category_slug FROM competitions c LEFT JOIN competition_categories cc ON cc.id=c.category_id";
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY c.event_date ASC, c.id ASC';

try {
    $stmt = db()->prepare($sql); $stmt->execute($params);
    $comps = $stmt->fetchAll();
    $categories = db()->query('SELECT id,name,slug FROM competition_categories WHERE is_active=1 ORDER BY sort_order')->fetchAll();
    $monthsRaw = db()->query("SELECT DISTINCT DATE_FORMAT(event_date,'%Y-%m') AS ym FROM competitions WHERE event_date IS NOT NULL ORDER BY ym")->fetchAll(PDO::FETCH_COLUMN);
} catch (Throwable $e) { $comps = $categories = $monthsRaw = []; }

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-inner reveal">
    <p class="eyebrow">CALENDAR</p>
    <h1 class="disp">Upcoming Competitions</h1>
    <p class="lead">Register your team for an open APEX competition. Dates, venues and fees shown below are drawn directly from our database and updated by the APEX team.</p>
  </div>
</section>

<section class="section-sm" style="background:#fff;border-bottom:1px solid var(--line)">
  <div class="container">
    <form method="GET" class="form" style="display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr auto;gap:12px;align-items:end">
      <label class="f"><span>Search</span><input type="search" name="q" value="<?= e($q) ?>" placeholder="Name, city or venue"></label>
      <label class="f"><span>Category</span>
        <select name="category">
          <option value="">All categories</option>
          <?php foreach ($categories as $c): ?>
            <option value="<?= e($c['slug']) ?>"<?= $filterCat===$c['slug']?' selected':'' ?>><?= e($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="f"><span>Month</span>
        <select name="month">
          <option value="">All months</option>
          <?php foreach ($monthsRaw as $m): if(!$m) continue; ?>
            <option value="<?= e($m) ?>"<?= $filterMonth===$m?' selected':'' ?>><?= e(format_date($m.'-01','F Y')) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="f"><span>Status</span>
        <select name="status">
          <option value="">All</option>
          <option value="open"<?= $filterStatus==='open'?' selected':'' ?>>Registration open</option>
          <option value="closing_soon"<?= $filterStatus==='closing_soon'?' selected':'' ?>>Closing soon</option>
          <option value="coming_soon"<?= $filterStatus==='coming_soon'?' selected':'' ?>>Coming soon</option>
          <option value="closed"<?= $filterStatus==='closed'?' selected':'' ?>>Closed</option>
        </select>
      </label>
      <button class="btn btn-navy" type="submit">Filter</button>
    </form>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (!$comps): ?>
      <div class="card" style="padding:40px;text-align:center">
        <h3>No competitions match these filters.</h3>
        <p class="text-slate">Try clearing the filters or check back soon — our team adds new competitions regularly.</p>
        <a class="btn btn-ghost" href="calendar.php">Show all competitions</a>
      </div>
    <?php else: ?>

    <div class="grid grid-3 reveal">
      <?php foreach ($comps as $c):
        $status = $c['registration_status'];
        $badge = ['open'=>['badge-open','Registration open'],'closing_soon'=>['badge-soon','Closing soon'],'closed'=>['badge-closed','Closed'],'coming_soon'=>['badge-coming','Coming soon']][$status] ?? ['badge-open','Open'];
        $canRegister = in_array($status,['open','closing_soon'],true);
      ?>
      <article class="ev-card">
        <div class="ev-photo">
          <?php if ($c['cover_image']): ?>
            <img src="<?= e($c['cover_image']) ?>" alt="<?= e($c['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="ph"><svg viewBox="0 0 120 110" width="64" height="59" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#263A57"/></svg><span><?= e($c['category_name'] ?: 'Competition') ?></span></div>
          <?php endif; ?>
          <?php if ($c['category_name']): ?><span class="badge-cat"><?= e($c['category_name']) ?></span><?php endif; ?>
        </div>
        <div class="ev-body">
          <div class="meta"><?= e(format_date($c['event_date'])) ?> · <?= e($c['city'] ?: 'Multiple cities') ?></div>
          <h3><?= e($c['name']) ?></h3>
          <p><?= e(mb_strimwidth($c['description'] ?? '', 0, 140, '…')) ?></p>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:13px;color:var(--slate)">
            <div><b style="color:var(--navy)">Team:</b> <?= e($c['team_size'] ?: '—') ?></div>
            <div><b style="color:var(--navy)">Fee:</b> <?= e($c['entry_fee'] ?: '—') ?></div>
            <div><b style="color:var(--navy)">Level:</b> <?= e($c['level'] ?: '—') ?></div>
            <div><b style="color:var(--navy)">Deadline:</b> <?= e(format_date($c['registration_deadline'])) ?: '—' ?></div>
          </div>
          <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <span class="badge <?= e($badge[0]) ?>" style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600"><?= e($badge[1]) ?></span>
            <?php if ($c['is_featured']): ?><span class="badge badge-soon" style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600">Featured</span><?php endif; ?>
          </div>
          <div class="actions">
            <?php if ($canRegister): ?>
              <a class="btn btn-navy btn-sm" href="register-team.php?competition=<?= urlencode($c['slug']) ?>">Register Your Team</a>
            <?php else: ?>
              <button class="btn btn-ghost btn-sm" type="button" disabled>Not open</button>
            <?php endif; ?>
            <a class="btn btn-ghost btn-sm" href="data:text/calendar;charset=utf-8,<?= rawurlencode("BEGIN:VCALENDAR\nVERSION:2.0\nBEGIN:VEVENT\nSUMMARY:".$c['name']."\nDTSTART:".str_replace('-','',$c['event_date'])."\nEND:VEVENT\nEND:VCALENDAR") ?>" download="<?= e(slugify($c['name'])) ?>.ics">Add to Calendar</a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
