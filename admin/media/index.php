<?php
$pageTitle = 'Media Library';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['delete_id'])) {
        $m = find_row('media', (int)$_POST['delete_id']);
        if ($m) {
            $abs = APP_ROOT . '/' . $m['file_path'];
            if (is_file($abs)) @unlink($abs);
            delete_row('media', (int)$m['id']);
            flash('ok','File deleted.');
        }
    } else if (!empty($_FILES['files']['tmp_name']) && is_array($_FILES['files']['tmp_name'])) {
        $count = 0;
        foreach ($_FILES['files']['tmp_name'] as $i => $tmp) {
            if (!$tmp) continue;
            $file = ['tmp_name'=>$tmp,'name'=>$_FILES['files']['name'][$i],'size'=>$_FILES['files']['size'][$i],'error'=>$_FILES['files']['error'][$i]];
            if ($p = upload_file($file, $_POST['collection'] ?? 'media', 8388608)) {
                $stmt = db()->prepare('INSERT INTO media (file_path,original_name,mime_type,file_size,collection,uploaded_by) VALUES (?,?,?,?,?,?)');
                $stmt->execute([$p, $file['name'], mime_content_type(APP_ROOT.'/'.$p) ?: null, $file['size'], $_POST['collection'] ?? 'media', $_SESSION['admin_id']]);
                $count++;
            }
        }
        flash('ok', "$count file(s) uploaded.");
    }
    redirect('index.php');
}

$collection = $_GET['c'] ?? '';
$where = $params = [];
if ($collection) { $where[] = 'collection=?'; $params[] = $collection; }
$sql = 'SELECT * FROM media';
if ($where) $sql .= ' WHERE '.implode(' AND ',$where);
$sql .= ' ORDER BY created_at DESC LIMIT 200';
$stmt = db()->prepare($sql); $stmt->execute($params);
$rows = $stmt->fetchAll();

$collections = db()->query('SELECT DISTINCT collection FROM media ORDER BY collection')->fetchAll(PDO::FETCH_COLUMN);
?>
<div class="admin-card">
  <h2>Upload files</h2>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Collection<select name="collection">
        <?php foreach (['general','events','portfolio','partners','team','banners','applications','media'] as $c): ?>
          <option<?= $c==='media'?' selected':'' ?>><?= e($c) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label class="full">Files (images, PDF)<input type="file" name="files[]" accept="image/*,application/pdf" multiple required></label>
    </div>
    <div><button class="btn btn-navy">Upload</button></div>
    <p class="text-slate" style="font-size:12.5px;margin-top:6px">Allowed: JPG, PNG, WebP, GIF, PDF. Maximum 8MB each. Files are renamed and stored outside the web root as needed.</p>
  </form>
</div>

<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px"><h2 style="margin:0">Library</h2>
  <form method="GET"><select name="c" onchange="this.form.submit()" style="font:inherit;padding:8px 12px;border:1.5px solid var(--line);border-radius:999px;background:#fff">
    <option value="">All collections</option>
    <?php foreach ($collections as $c): ?><option value="<?= e($c) ?>"<?= $collection===$c?' selected':'' ?>><?= e($c) ?></option><?php endforeach; ?>
  </select></form>
  </div>

  <?php if (!$rows): ?><p class="text-slate">No files uploaded yet.</p><?php else: ?>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-top:16px">
    <?php foreach ($rows as $m):
      $isImg = str_starts_with($m['mime_type'] ?? '', 'image/'); ?>
    <div class="card" style="padding:0;overflow:hidden">
      <div style="aspect-ratio:1/1;background:var(--navy);display:flex;align-items:center;justify-content:center">
        <?php if ($isImg): ?>
          <img src="../../<?= e($m['file_path']) ?>" alt="<?= e($m['original_name']) ?>" style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
          <div style="color:var(--gold);font-family:Archivo,sans-serif;font-weight:800;font-size:20px">PDF</div>
        <?php endif; ?>
      </div>
      <div style="padding:10px">
        <div style="font-size:12.5px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= e($m['original_name']) ?>"><?= e($m['original_name']) ?></div>
        <div style="font-size:11px;color:var(--slate);margin:3px 0 6px"><?= e($m['collection']) ?> · <?= number_format($m['file_size']/1024,1) ?> KB</div>
        <div style="display:flex;gap:4px">
          <a class="btn btn-ghost" style="font-size:11px;padding:4px 8px;min-height:0" href="../../<?= e($m['file_path']) ?>" target="_blank">Open</a>
          <form method="POST" style="display:inline" onsubmit="return confirm('Delete this file?')"><?= csrf_field() ?><input type="hidden" name="delete_id" value="<?= e($m['id']) ?>"><button class="btn btn-ghost" style="font-size:11px;padding:4px 8px;min-height:0;color:var(--red)">×</button></form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
