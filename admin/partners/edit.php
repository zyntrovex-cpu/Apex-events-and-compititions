<?php
$pageTitle = 'Edit partner';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('partners', $id) : null;
$cats = db()->query('SELECT id,name FROM partner_categories ORDER BY sort_order')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
        'city' => trim($_POST['city'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'website' => trim($_POST['website'] ?? ''),
        'discount' => trim($_POST['discount'] ?? ''),
        'since_year' => trim($_POST['since_year'] ?? ''),
        'is_card_partner' => isset($_POST['is_card_partner']) ? 1 : 0,
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
    ];
    if (!empty($_FILES['logo']['tmp_name'])) {
        if ($p = upload_file($_FILES['logo'], 'partners')) $data['logo'] = $p;
    }
    try {
        if ($row) update_row('partners', $id, $data); else $id = insert_row('partners', $data);
        flash('ok', 'Partner saved.'); redirect('index.php');
    } catch (Throwable $e) { flash('err','Save failed: '.$e->getMessage()); }
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit partner' : 'New partner' ?></h2>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Category<select name="category_id">
        <?php foreach ($cats as $c): ?><option value="<?= e($c['id']) ?>"<?= ($row['category_id'] ?? 0)==$c['id']?' selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
      </select></label>
      <label>City<input type="text" name="city" value="<?= e($row['city'] ?? '') ?>"></label>
      <label>Website<input type="url" name="website" value="<?= e($row['website'] ?? '') ?>" placeholder="https://..."></label>
      <label>Discount (for APEX Card partners)<input type="text" name="discount" value="<?= e($row['discount'] ?? '') ?>" placeholder="e.g. 15% off"></label>
      <label>Since year<input type="text" name="since_year" value="<?= e($row['since_year'] ?? '') ?>"></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label class="full">Description<textarea name="description"><?= e($row['description'] ?? '') ?></textarea></label>
      <label class="full">Logo<input type="file" name="logo" accept="image/*"><?php if (!empty($row['logo'])): ?><div style="margin-top:6px"><img src="../../<?= e($row['logo']) ?>" style="max-height:80px"></div><?php endif; ?></label>
      <label><input type="checkbox" name="is_card_partner" value="1"<?= !empty($row['is_card_partner'])?' checked':'' ?>> APEX Card partner</label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px;margin-top:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
