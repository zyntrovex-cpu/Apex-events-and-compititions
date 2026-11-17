<?php
$pageTitle = 'Site Settings';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $updates = $_POST['settings'] ?? [];
    foreach ($updates as $key => $value) {
        $stmt = db()->prepare('UPDATE site_settings SET setting_value=? WHERE setting_key=?');
        $stmt->execute([$value, $key]);
    }
    flash('ok', 'Settings saved.');
    log_admin_activity('update','settings', null, 'Bulk settings update');
    redirect('index.php');
}

$settings = db()->query('SELECT * FROM site_settings ORDER BY setting_group, sort_order')->fetchAll();
$groups = [];
foreach ($settings as $s) { $groups[$s['setting_group']][] = $s; }
?>
<form method="POST" class="form-inline">
  <?= csrf_field() ?>
  <?php foreach ($groups as $group => $items): ?>
  <div class="admin-card">
    <h2><?= e(ucwords(str_replace('_',' ',$group))) ?></h2>
    <div class="form-cols">
      <?php foreach ($items as $s):
        $name = 'settings[' . htmlspecialchars($s['setting_key']) . ']';
        $val = $s['setting_value']; ?>
        <label<?= in_array($s['setting_type'], ['textarea'], true) ? ' class="full"' : '' ?>>
          <?= e($s['label'] ?: $s['setting_key']) ?>
          <?php if ($s['setting_type'] === 'textarea'): ?>
            <textarea name="<?= e($name) ?>" rows="3"><?= e($val) ?></textarea>
          <?php elseif ($s['setting_type'] === 'number'): ?>
            <input type="number" name="<?= e($name) ?>" value="<?= e($val) ?>">
          <?php elseif ($s['setting_type'] === 'email'): ?>
            <input type="email" name="<?= e($name) ?>" value="<?= e($val) ?>">
          <?php elseif ($s['setting_type'] === 'url'): ?>
            <input type="url" name="<?= e($name) ?>" value="<?= e($val) ?>">
          <?php elseif ($s['setting_type'] === 'bool'): ?>
            <select name="<?= e($name) ?>"><option value="1"<?= $val=='1'?' selected':'' ?>>Yes</option><option value="0"<?= $val=='0'?' selected':'' ?>>No</option></select>
          <?php else: ?>
            <input type="text" name="<?= e($name) ?>" value="<?= e($val) ?>">
          <?php endif; ?>
          <small class="text-slate" style="font-size:11px;color:var(--slate)"><?= e($s['setting_key']) ?></small>
        </label>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>

  <div class="admin-card">
    <button class="btn btn-navy btn-lg" type="submit">Save all settings</button>
  </div>
</form>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
