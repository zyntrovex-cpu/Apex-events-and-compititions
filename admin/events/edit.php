<?php
$pageTitle = 'Edit event service';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('events', $id) : null;
$cats = db()->query('SELECT id,name FROM event_categories ORDER BY sort_order')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'slug' => slugify(trim($_POST['slug'] ?? '') ?: ($_POST['name'] ?? '')),
        'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
        'headline' => trim($_POST['headline'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'deliverables' => trim($_POST['deliverables'] ?? ''),
        'ideal_for' => trim($_POST['ideal_for'] ?? ''),
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    if ($row) update_row('events', $id, $data); else insert_row('events', $data);
    flash('ok','Saved.'); redirect('index.php');
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit service' : 'New service' ?></h2>
  <form method="POST" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Slug<input type="text" name="slug" value="<?= e($row['slug'] ?? '') ?>"></label>
      <label>Category<select name="category_id"><?php foreach ($cats as $c): ?><option value="<?= e($c['id']) ?>"<?= ($row['category_id'] ?? 0)==$c['id']?' selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label class="full">Headline<input type="text" name="headline" value="<?= e($row['headline'] ?? '') ?>"></label>
      <label class="full">Description<textarea name="description" rows="3"><?= e($row['description'] ?? '') ?></textarea></label>
      <label class="full">Deliverables (separate with |)<textarea name="deliverables" rows="5" placeholder="Annual days|Prize distributions|Convocations"><?= e($row['deliverables'] ?? '') ?></textarea></label>
      <label class="full">Ideal for<input type="text" name="ideal_for" value="<?= e($row['ideal_for'] ?? '') ?>"></label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
