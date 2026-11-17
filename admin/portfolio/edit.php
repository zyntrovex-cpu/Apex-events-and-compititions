<?php
$pageTitle = 'Edit past event';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('portfolio_items', $id) : null;
$images = $id ? db()->query('SELECT * FROM portfolio_images WHERE portfolio_id='.$id.' ORDER BY sort_order')->fetchAll() : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $resultsJson = null;
    if (!empty($_POST['results'])) {
        $pairs = [];
        foreach (array_filter(explode("\n", $_POST['results'])) as $ln) {
            if (strpos($ln, '|') !== false) {
                [$pos, $who] = array_map('trim', explode('|', $ln, 2));
                if ($pos || $who) $pairs[] = [$pos, $who];
            }
        }
        $resultsJson = $pairs ? json_encode($pairs, JSON_UNESCAPED_UNICODE) : null;
    }
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'slug' => slugify(trim($_POST['slug'] ?? '') ?: ($_POST['name'] ?? '')),
        'category' => trim($_POST['category'] ?? 'Academic & Quiz'),
        'institution' => trim($_POST['institution'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'event_date' => trim($_POST['event_date'] ?? '') ?: null,
        'summary' => trim($_POST['summary'] ?? ''),
        'brief' => trim($_POST['brief'] ?? ''),
        'what_we_did' => trim($_POST['what_we_did'] ?? ''),
        'result_text' => trim($_POST['result_text'] ?? ''),
        'participants_count' => (int)($_POST['participants_count'] ?? 0) ?: null,
        'teams_count' => (int)($_POST['teams_count'] ?? 0) ?: null,
        'video_url' => trim($_POST['video_url'] ?? ''),
        'results_json' => $resultsJson,
        'quote_text' => trim($_POST['quote_text'] ?? ''),
        'quote_by' => trim($_POST['quote_by'] ?? ''),
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        'is_published' => isset($_POST['is_published']) ? 1 : 0,
    ];
    if (!empty($_FILES['cover_image']['tmp_name'])) {
        if ($p = upload_file($_FILES['cover_image'], 'portfolio')) $data['cover_image'] = $p;
    }

    try {
        if ($row) { update_row('portfolio_items', $id, $data); }
        else { $id = insert_row('portfolio_items', $data); }

        // Add new gallery images
        if (!empty($_FILES['gallery']['tmp_name']) && is_array($_FILES['gallery']['tmp_name'])) {
            foreach ($_FILES['gallery']['tmp_name'] as $i => $tmp) {
                if (!$tmp) continue;
                $file = ['tmp_name'=>$tmp,'name'=>$_FILES['gallery']['name'][$i],'size'=>$_FILES['gallery']['size'][$i],'error'=>$_FILES['gallery']['error'][$i]];
                if ($p = upload_file($file, 'portfolio')) {
                    $s = db()->prepare('INSERT INTO portfolio_images (portfolio_id,image_path,sort_order) VALUES (?,?,?)');
                    $s->execute([$id, $p, $i]);
                }
            }
        }
        flash('ok','Past event saved.');
        redirect('index.php');
    } catch (Throwable $e) { flash('err','Save failed: '.$e->getMessage()); }
}

$results = '';
if (!empty($row['results_json'])) {
    foreach (json_safe_decode($row['results_json']) as $r) {
        $results .= ($r[0] ?? '') . ' | ' . ($r[1] ?? '') . "\n";
    }
}
?>

<div class="admin-card">
  <h2><?= $row ? 'Edit past event' : 'New past event' ?></h2>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Slug<input type="text" name="slug" value="<?= e($row['slug'] ?? '') ?>" placeholder="auto"></label>
      <label>Category<select name="category">
        <?php foreach (["Academic & Quiz","Debate & Speaking","Science & Technology","Sports","Arts & Talent","Ceremonies","Culture","Exhibitions","Seminars","Tours","Corporate"] as $c): ?>
          <option<?= ($row['category'] ?? '')===$c?' selected':'' ?>><?= e($c) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Institution<input type="text" name="institution" value="<?= e($row['institution'] ?? '') ?>"></label>
      <label>City<input type="text" name="city" value="<?= e($row['city'] ?? '') ?>"></label>
      <label>Event date<input type="date" name="event_date" value="<?= e($row['event_date'] ?? '') ?>"></label>
      <label>Participants<input type="number" name="participants_count" value="<?= e($row['participants_count'] ?? '') ?>"></label>
      <label>Teams<input type="number" name="teams_count" value="<?= e($row['teams_count'] ?? '') ?>"></label>
      <label>Video URL (YouTube / Facebook)<input type="url" name="video_url" value="<?= e($row['video_url'] ?? '') ?>"></label>
      <label class="full">Summary<textarea name="summary"><?= e($row['summary'] ?? '') ?></textarea></label>
      <label class="full">Brief (what the institution needed)<textarea name="brief"><?= e($row['brief'] ?? '') ?></textarea></label>
      <label class="full">What APEX did<textarea name="what_we_did"><?= e($row['what_we_did'] ?? '') ?></textarea></label>
      <label class="full">Result / outcomes<textarea name="result_text"><?= e($row['result_text'] ?? '') ?></textarea></label>
      <label class="full">Results (one per line, format "Position | Winner")<textarea name="results" placeholder="1st | Team Alpha&#10;2nd | Team Beta"><?= e($results) ?></textarea></label>
      <label>Quote<textarea name="quote_text"><?= e($row['quote_text'] ?? '') ?></textarea></label>
      <label>Quoted by (Name, Role, Institution)<input type="text" name="quote_by" value="<?= e($row['quote_by'] ?? '') ?>"></label>
      <label class="full">Cover image<input type="file" name="cover_image" accept="image/*"><?php if (!empty($row['cover_image'])): ?><div style="margin-top:6px"><img src="../../<?= e($row['cover_image']) ?>" style="max-width:220px;border-radius:8px"></div><?php endif; ?></label>
      <label class="full">Add gallery images<input type="file" name="gallery[]" accept="image/*" multiple></label>
      <label><input type="checkbox" name="is_featured" value="1"<?= !empty($row['is_featured'])?' checked':'' ?>> Featured</label>
      <label><input type="checkbox" name="is_published" value="1"<?= (!$row || !empty($row['is_published']))?' checked':'' ?>> Published</label>
    </div>
    <?php if ($images): ?>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
      <?php foreach ($images as $img): ?>
        <div style="position:relative"><img src="../../<?= e($img['image_path']) ?>" style="width:140px;height:100px;object-fit:cover;border-radius:8px"></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div style="display:flex;gap:10px;margin-top:10px">
      <button class="btn btn-navy" type="submit">Save</button>
      <a class="btn btn-ghost" href="index.php">Cancel</a>
    </div>
  </form>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
