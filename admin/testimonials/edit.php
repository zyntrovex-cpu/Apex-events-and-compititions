<?php
$pageTitle = 'Edit testimonial';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('testimonials', $id) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'quote' => trim($_POST['quote'] ?? ''),
        'author_name' => trim($_POST['author_name'] ?? ''),
        'author_role' => trim($_POST['author_role'] ?? ''),
        'author_institution' => trim($_POST['author_institution'] ?? ''),
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
    ];
    if (!empty($_FILES['photo']['tmp_name'])) { if ($p = upload_file($_FILES['photo'], 'team')) $data['photo'] = $p; }
    if ($row) update_row('testimonials', $id, $data); else insert_row('testimonials', $data);
    flash('ok','Testimonial saved.'); redirect('index.php');
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit testimonial' : 'New testimonial' ?></h2>
  <p class="text-slate" style="font-size:13px">Only publish quotes you have written permission to use.</p>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <label>Quote<textarea name="quote" rows="4" required><?= e($row['quote'] ?? '') ?></textarea></label>
    <div class="form-cols">
      <label>Author name<input type="text" name="author_name" required value="<?= e($row['author_name'] ?? '') ?>"></label>
      <label>Author role<input type="text" name="author_role" value="<?= e($row['author_role'] ?? '') ?>"></label>
      <label>Institution<input type="text" name="author_institution" value="<?= e($row['author_institution'] ?? '') ?>"></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label>Photo<input type="file" name="photo" accept="image/*"></label>
      <label><input type="checkbox" name="is_featured" value="1"<?= !empty($row['is_featured'])?' checked':'' ?>> Featured</label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
