<?php
$pageTitle = 'Edit team member';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('team_members', $id) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'role' => trim($_POST['role'] ?? ''),
        'bio' => trim($_POST['bio'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'linkedin' => trim($_POST['linkedin'] ?? ''),
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    if (!empty($_FILES['photo']['tmp_name'])) { if ($p = upload_file($_FILES['photo'], 'team')) $data['photo'] = $p; }
    if ($row) update_row('team_members', $id, $data); else insert_row('team_members', $data);
    flash('ok','Saved.'); redirect('index.php');
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit team member' : 'New team member' ?></h2>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Role<input type="text" name="role" required value="<?= e($row['role'] ?? '') ?>"></label>
      <label>Email<input type="email" name="email" value="<?= e($row['email'] ?? '') ?>"></label>
      <label>LinkedIn<input type="url" name="linkedin" value="<?= e($row['linkedin'] ?? '') ?>"></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label>Photo<input type="file" name="photo" accept="image/*"></label>
      <label class="full">One-line bio<input type="text" name="bio" value="<?= e($row['bio'] ?? '') ?>"></label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
