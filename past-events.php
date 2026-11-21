<?php
require_once __DIR__ . '/config/app.php';
freeze_if_minimal();

$pageTitle = 'Past Events | APEX Events & Competitions';
$pageDescription = 'Competitions, championships and events organised by APEX for schools, colleges, universities, institutions and companies: results, photos and highlights.';

$filterCat = $_GET['category'] ?? '';
$filterYear = $_GET['year'] ?? '';
$slug = $_GET['event'] ?? '';

try {
    $where = ['is_published=1'];
    $params = [];
    if ($filterCat) { $where[] = 'category=?'; $params[] = $filterCat; }
    if ($filterYear && preg_match('/^\d{4}$/', $filterYear)) { $where[] = 'YEAR(event_date)=?'; $params[] = (int)$filterYear; }
    $sql = 'SELECT * FROM portfolio_items';
    if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
    $sql .= ' ORDER BY event_date DESC, id DESC';
    $stmt = db()->prepare($sql); $stmt->execute($params);
    $events = $stmt->fetchAll();

    $cats = db()->query('SELECT DISTINCT category FROM portfolio_items WHERE is_published=1 ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
    $years = db()->query('SELECT DISTINCT YEAR(event_date) AS y FROM portfolio_items WHERE is_published=1 AND event_date IS NOT NULL ORDER BY y DESC')->fetchAll(PDO::FETCH_COLUMN);

    $detail = null;
    if ($slug) {
        $s = db()->prepare('SELECT * FROM portfolio_items WHERE slug=? AND is_published=1 LIMIT 1');
        $s->execute([$slug]);
        $detail = $s->fetch() ?: null;
        if ($detail) {
            $imgStmt = db()->prepare('SELECT image_path,caption FROM portfolio_images WHERE portfolio_id=? ORDER BY sort_order');
            $imgStmt->execute([$detail['id']]);
            $detail['images'] = $imgStmt->fetchAll();
            $detail['results_arr'] = json_safe_decode($detail['results_json']);
        }
    }

    $totals = [
        'events' => count_table('portfolio_items', 'is_published=1'),
        'institutions' => (int)db()->query('SELECT COUNT(DISTINCT institution) FROM portfolio_items WHERE is_published=1 AND institution IS NOT NULL')->fetchColumn(),
        'participants' => (int)db()->query('SELECT COALESCE(SUM(participants_count),0) FROM portfolio_items WHERE is_published=1')->fetchColumn(),
        'cities' => (int)db()->query('SELECT COUNT(DISTINCT city) FROM portfolio_items WHERE is_published=1 AND city IS NOT NULL')->fetchColumn(),
    ];
} catch (Throwable $e) {
    $events = $cats = $years = []; $detail = null; $totals = ['events'=>0,'institutions'=>0,'participants'=>0,'cities'=>0];
}

include __DIR__ . '/includes/header.php';
?>

<section class="hero" style="padding-bottom:48px">
  <div class="hero-inner reveal">
    <p class="eyebrow">PAST EVENTS</p>
    <h1 class="disp">Moments we've made</h1>
    <p class="lead">Competitions, championships and events organised by APEX: the results, the winners and the photos.</p>
  </div>
</section>

<section class="container" style="transform:translateY(-36px);position:relative;z-index:5">
  <div class="stats reveal">
    <div><b data-count="<?= (int)$totals['events'] ?>" data-suffix="+"><?= (int)$totals['events'] ?>+</b><span>Events delivered</span></div>
    <div><b data-count="<?= (int)$totals['institutions'] ?>" data-suffix="+"><?= (int)$totals['institutions'] ?>+</b><span>Institutions &amp; companies</span></div>
    <div><b data-count="<?= (int)$totals['participants'] ?>" data-suffix="+"><?= (int)$totals['participants'] ?>+</b><span>Participants</span></div>
    <div><b data-count="<?= (int)$totals['cities'] ?>" data-suffix="+"><?= (int)$totals['cities'] ?>+</b><span>Cities</span></div>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;margin-bottom:24px">
      <div class="chip-row">
        <a class="chip-btn" href="past-events.php" aria-pressed="<?= $filterCat===''?'true':'false' ?>">All events</a>
        <?php foreach ($cats as $c): ?>
          <a class="chip-btn" href="<?= e(url_with(['category'=>$c, 'event'=>null])) ?>" aria-pressed="<?= $filterCat===$c?'true':'false' ?>"><?= e($c) ?></a>
        <?php endforeach; ?>
      </div>
      <label class="f" style="display:flex;flex-direction:row;align-items:center;gap:8px;font-size:14px;color:var(--slate)">Year
        <select name="year" onchange="this.form.submit()" style="font:inherit;font-size:14.5px;border:1.5px solid var(--line);border-radius:999px;padding:9px 16px;background:#fff;color:var(--navy);min-height:42px">
          <option value="">All years</option>
          <?php foreach ($years as $y): ?>
            <option value="<?= e($y) ?>"<?= (string)$filterYear===(string)$y?' selected':'' ?>><?= e($y) ?></option>
          <?php endforeach; ?>
        </select>
        <?php if ($filterCat): ?><input type="hidden" name="category" value="<?= e($filterCat) ?>"><?php endif; ?>
      </label>
    </form>

    <?php if (!$events): ?>
      <div class="card" style="padding:40px;text-align:center">
        <h3>No events match these filters.</h3>
        <a class="btn btn-ghost" href="past-events.php">Show all events</a>
      </div>
    <?php else: ?>
    <div class="grid grid-3 reveal">
      <?php foreach ($events as $e):
        $imgCount = 0;
        if (isset($imageCounts[$e['id']])) $imgCount = $imageCounts[$e['id']];
      ?>
      <article class="ev-card">
        <div class="ev-photo">
          <?php if ($e['cover_image']): ?>
            <img src="<?= e($e['cover_image']) ?>" alt="<?= e($e['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="ph"><svg viewBox="0 0 120 110" width="64" height="59" aria-hidden="true"><path d="M60 0 Q62 12 74 14 Q62 16 60 28 Q58 16 46 14 Q58 12 60 0 Z" fill="#D4A63A"/><path d="M49 34 L71 34 L112 110 L86 110 L60 62 L34 110 L8 110 Z" fill="#263A57"/></svg><span>Photos coming soon</span></div>
          <?php endif; ?>
          <span class="badge-cat"><?= e($e['category']) ?></span>
        </div>
        <div class="ev-body">
          <div class="meta"><?= e(format_date($e['event_date'])) ?> · <?= e($e['institution']) ?>, <?= e($e['city']) ?></div>
          <h3><?= e($e['name']) ?></h3>
          <p><?= e(mb_strimwidth($e['summary'] ?? '', 0, 160, '…')) ?></p>
          <?php if ($e['participants_count'] || $e['teams_count']): ?>
          <div style="display:flex;gap:8px;flex-wrap:wrap;font-size:13px;color:var(--slate)">
            <?php if ($e['participants_count']): ?><span style="background:var(--ivory);padding:6px 11px;border-radius:9px"><b style="color:var(--navy)"><?= e($e['participants_count']) ?></b> participants</span><?php endif; ?>
            <?php if ($e['teams_count']): ?><span style="background:var(--ivory);padding:6px 11px;border-radius:9px"><b style="color:var(--navy)"><?= e($e['teams_count']) ?></b> teams</span><?php endif; ?>
          </div>
          <?php endif; ?>
          <div class="actions">
            <a class="btn btn-navy btn-sm" href="?event=<?= urlencode($e['slug']) ?>">View details</a>
            <?php if ($e['video_url']): ?><a class="btn btn-ghost btn-sm" href="<?= e($e['video_url']) ?>" target="_blank" rel="noopener">Watch video</a><?php endif; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="cta-band reveal" style="margin-top:48px">
      <div>
        <h2 class="disp">Your institution's big day could be next.</h2>
        <p>Tell us about the competition or event you have in mind and we'll send ideas, a timeline and a clear proposal.</p>
      </div>
      <a class="btn btn-gold" href="contact.php?interest=Organise%20a%20competition">Start Planning</a>
    </div>
  </div>
</section>

<?php if ($detail): ?>
<div class="modal" role="dialog" aria-modal="true" aria-labelledby="dlg-title" id="eventModal">
  <a class="modal-backdrop" href="past-events.php" aria-label="Close dialog" tabindex="-1"></a>
  <div class="modal-box">
    <div class="dlg-head">
      <div>
        <div class="text-slate" style="font-size:13.5px"><?= e($detail['category']) ?> · <?= e(format_date($detail['event_date'])) ?> · <?= e($detail['institution']) ?>, <?= e($detail['city']) ?></div>
        <h2 class="disp" id="dlg-title"><?= e($detail['name']) ?></h2>
      </div>
      <a class="x-close" href="past-events.php" aria-label="Close" style="text-decoration:none;display:inline-flex;align-items:center;justify-content:center">×</a>
    </div>
    <div class="dlg-body">
    <?php if ($detail['summary']): ?><p class="text-slate" style="line-height:1.6;margin:0"><?= nl2br(e($detail['summary'])) ?></p><?php endif; ?>
    <?php if ($detail['brief']): ?><div><b>The brief:</b> <span class="text-slate"><?= e($detail['brief']) ?></span></div><?php endif; ?>
    <?php if ($detail['what_we_did']): ?><div><b>What we did:</b> <span class="text-slate"><?= e($detail['what_we_did']) ?></span></div><?php endif; ?>
    <?php if ($detail['result_text']): ?><div><b>The result:</b> <span class="text-slate"><?= e($detail['result_text']) ?></span></div><?php endif; ?>
    <?php if (!empty($detail['images'])): ?>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px">
      <?php foreach ($detail['images'] as $img): ?>
        <img src="<?= e($img['image_path']) ?>" alt="<?= e($img['caption'] ?: $detail['name']) ?>" loading="lazy" style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:10px">
      <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="background:var(--ivory);padding:26px;border-radius:12px;text-align:center;color:var(--slate)">Photos from this event will appear here.</div>
    <?php endif; ?>
    <?php if (!empty($detail['results_arr'])): ?>
      <div>
        <h3 style="font-size:12px;letter-spacing:.2em;color:var(--dgold);margin:0 0 10px;font-family:Inter,sans-serif">RESULTS</h3>
        <ol style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px">
        <?php foreach ($detail['results_arr'] as $r): ?>
          <li style="display:flex;gap:12px;align-items:center;background:var(--ivory);border-radius:10px;padding:10px 14px"><b style="font-family:Archivo,sans-serif;min-width:60px;color:var(--dgold)"><?= e($r[0] ?? '') ?></b><span><?= e($r[1] ?? '') ?></span></li>
        <?php endforeach; ?>
        </ol>
      </div>
    <?php endif; ?>
    <?php if ($detail['quote_text']): ?>
      <blockquote style="margin:0;background:var(--navy);color:var(--ivory);border-radius:14px;padding:20px 22px;font-size:16px;line-height:1.55">“<?= e($detail['quote_text']) ?>”<cite style="display:block;margin-top:10px;color:var(--mist);font-style:normal;font-size:13.5px">— <?= e($detail['quote_by']) ?></cite></blockquote>
    <?php endif; ?>
      <?php if ($detail['video_url']): ?>
        <a class="btn btn-navy" href="<?= e($detail['video_url']) ?>" target="_blank" rel="noopener" style="align-self:flex-start">Watch the highlights video</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<script>
  // Scroll lock + Escape to close
  (function(){
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
    function close(){ window.location.href = 'past-events.php'; }
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') close(); });
  })();
</script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
