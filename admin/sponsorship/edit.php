<?php
$pageTitle = 'Edit sponsorship tier';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('sponsorship_tiers', $id) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'tagline' => trim($_POST['tagline'] ?? ''),
        'price' => trim($_POST['price'] ?? ''),
        'benefits' => trim($_POST['benefits'] ?? ''),
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    if ($row) update_row('sponsorship_tiers', $id, $data); else insert_row('sponsorship_tiers', $data);
    flash('ok','Saved.'); redirect('index.php');
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit tier' : 'New tier' ?></h2>
  <form method="POST" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Tagline<input type="text" name="tagline" value="<?= e($row['tagline'] ?? '') ?>"></label>
      <label>Price<input type="text" name="price" value="<?= e($row['price'] ?? '') ?>" placeholder="[PKR ___] or Negotiable"></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label class="full">Benefits (one per line, separate with |)<textarea name="benefits" rows="6"><?= e($row['benefits'] ?? '') ?></textarea></label>
      <label><input type="checkbox" name="is_featured" value="1"<?= !empty($row['is_featured'])?' checked':'' ?>> Featured (top of list)</label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
