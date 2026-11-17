<?php
$pageTitle = 'Edit FAQ';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('faqs', $id) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'question' => trim($_POST['question'] ?? ''),
        'answer' => trim($_POST['answer'] ?? ''),
        'category' => trim($_POST['category'] ?? 'General'),
        'sort_order' => (int)($_POST['sort_order'] ?? 0),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    if ($row) update_row('faqs', $id, $data); else $id = insert_row('faqs', $data);
    flash('ok','FAQ saved.');
    redirect('index.php');
}
?>
<div class="admin-card">
  <h2><?= $row ? 'Edit FAQ' : 'New FAQ' ?></h2>
  <form method="POST" class="form-inline">
    <?= csrf_field() ?>
    <label>Question<input type="text" name="question" required value="<?= e($row['question'] ?? '') ?>"></label>
    <label>Answer<textarea name="answer" rows="5" required><?= e($row['answer'] ?? '') ?></textarea></label>
    <div class="form-cols">
      <label>Category<select name="category">
        <?php foreach (['General','Planning','Safety','Competitions','APEX Card'] as $c): ?>
          <option<?= ($row['category'] ?? 'General')===$c?' selected':'' ?>><?= e($c) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Sort order<input type="number" name="sort_order" value="<?= e($row['sort_order'] ?? 0) ?>"></label>
      <label><input type="checkbox" name="is_active" value="1"<?= (!$row || !empty($row['is_active']))?' checked':'' ?>> Active</label>
    </div>
    <div style="display:flex;gap:10px"><button class="btn btn-navy">Save</button><a class="btn btn-ghost" href="index.php">Cancel</a></div>
  </form>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
