<?php
$pageTitle = 'Navigation & Social Links';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (!empty($_POST['nav_new']['label'])) {
        insert_row('navigation_items', [
            'label' => trim($_POST['nav_new']['label']),
            'url' => trim($_POST['nav_new']['url']),
            'location' => $_POST['nav_new']['location'],
            'sort_order' => (int)$_POST['nav_new']['sort_order'],
            'is_active' => 1,
            'is_cta' => !empty($_POST['nav_new']['is_cta']) ? 1 : 0,
        ]);
    }
    if (!empty($_POST['social_new']['platform'])) {
        insert_row('social_links', [
            'platform' => trim($_POST['social_new']['platform']),
            'label' => trim($_POST['social_new']['label']),
            'url' => trim($_POST['social_new']['url']),
            'sort_order' => (int)$_POST['social_new']['sort_order'],
            'is_active' => 1,
        ]);
    }
    foreach ($_POST['nav'] ?? [] as $id => $vals) {
        update_row('navigation_items', (int)$id, [
            'label' => trim($vals['label'] ?? ''),
            'url' => trim($vals['url'] ?? ''),
            'location' => $vals['location'] ?? 'header',
            'sort_order' => (int)$vals['sort_order'],
            'is_active' => isset($vals['is_active']) ? 1 : 0,
            'is_cta' => isset($vals['is_cta']) ? 1 : 0,
        ]);
    }
    foreach ($_POST['social'] ?? [] as $id => $vals) {
        update_row('social_links', (int)$id, [
            'platform' => trim($vals['platform'] ?? ''),
            'label' => trim($vals['label'] ?? ''),
            'url' => trim($vals['url'] ?? ''),
            'sort_order' => (int)$vals['sort_order'],
            'is_active' => isset($vals['is_active']) ? 1 : 0,
        ]);
    }
    foreach ($_POST['nav_delete'] ?? [] as $id) delete_row('navigation_items', (int)$id);
    foreach ($_POST['social_delete'] ?? [] as $id) delete_row('social_links', (int)$id);
    flash('ok', 'Navigation updated.');
    redirect('index.php');
}

$navs = db()->query('SELECT * FROM navigation_items ORDER BY location, sort_order')->fetchAll();
$socials = db()->query('SELECT * FROM social_links ORDER BY sort_order')->fetchAll();
?>
<form method="POST">
  <?= csrf_field() ?>
  <div class="admin-card">
    <h2>Navigation items</h2>
    <table class="admin-table">
      <thead><tr><th>Label</th><th>URL</th><th>Location</th><th>Order</th><th>CTA</th><th>Active</th><th>Delete</th></tr></thead>
      <tbody>
      <?php foreach ($navs as $n): ?>
      <tr>
        <td><input type="text" name="nav[<?= e($n['id']) ?>][label]" value="<?= e($n['label']) ?>"></td>
        <td><input type="text" name="nav[<?= e($n['id']) ?>][url]" value="<?= e($n['url']) ?>"></td>
        <td><select name="nav[<?= e($n['id']) ?>][location]">
          <?php foreach (['header','footer_company','footer_services','footer_for','footer_card'] as $loc): ?>
            <option value="<?= e($loc) ?>"<?= $n['location']===$loc?' selected':'' ?>><?= e($loc) ?></option>
          <?php endforeach; ?>
        </select></td>
        <td><input type="number" name="nav[<?= e($n['id']) ?>][sort_order]" value="<?= e($n['sort_order']) ?>" style="width:70px"></td>
        <td><input type="checkbox" name="nav[<?= e($n['id']) ?>][is_cta]" value="1"<?= $n['is_cta']?' checked':'' ?>></td>
        <td><input type="checkbox" name="nav[<?= e($n['id']) ?>][is_active]" value="1"<?= $n['is_active']?' checked':'' ?>></td>
        <td><label><input type="checkbox" name="nav_delete[]" value="<?= e($n['id']) ?>"> Delete</label></td>
      </tr>
      <?php endforeach; ?>
      <tr style="background:var(--greenbg)">
        <td><input type="text" name="nav_new[label]" placeholder="+ New label"></td>
        <td><input type="text" name="nav_new[url]" placeholder="new.php"></td>
        <td><select name="nav_new[location]">
          <?php foreach (['header','footer_company','footer_services','footer_for','footer_card'] as $loc): ?>
            <option value="<?= e($loc) ?>"><?= e($loc) ?></option>
          <?php endforeach; ?>
        </select></td>
        <td><input type="number" name="nav_new[sort_order]" value="99" style="width:70px"></td>
        <td><input type="checkbox" name="nav_new[is_cta]" value="1"></td>
        <td colspan="2">New row</td>
      </tr>
      </tbody>
    </table>
  </div>

  <div class="admin-card">
    <h2>Social media links</h2>
    <table class="admin-table">
      <thead><tr><th>Platform</th><th>Label</th><th>URL</th><th>Order</th><th>Active</th><th>Delete</th></tr></thead>
      <tbody>
      <?php foreach ($socials as $s): ?>
      <tr>
        <td><input type="text" name="social[<?= e($s['id']) ?>][platform]" value="<?= e($s['platform']) ?>"></td>
        <td><input type="text" name="social[<?= e($s['id']) ?>][label]" value="<?= e($s['label']) ?>"></td>
        <td><input type="url" name="social[<?= e($s['id']) ?>][url]" value="<?= e($s['url']) ?>"></td>
        <td><input type="number" name="social[<?= e($s['id']) ?>][sort_order]" value="<?= e($s['sort_order']) ?>" style="width:70px"></td>
        <td><input type="checkbox" name="social[<?= e($s['id']) ?>][is_active]" value="1"<?= $s['is_active']?' checked':'' ?>></td>
        <td><label><input type="checkbox" name="social_delete[]" value="<?= e($s['id']) ?>"> Delete</label></td>
      </tr>
      <?php endforeach; ?>
      <tr style="background:var(--greenbg)">
        <td><input type="text" name="social_new[platform]" placeholder="facebook"></td>
        <td><input type="text" name="social_new[label]" placeholder="Facebook"></td>
        <td><input type="url" name="social_new[url]" placeholder="https://..."></td>
        <td><input type="number" name="social_new[sort_order]" value="99" style="width:70px"></td>
        <td colspan="2">New row</td>
      </tr>
      </tbody>
    </table>
  </div>

  <div class="admin-card"><button class="btn btn-navy btn-lg" type="submit">Save all changes</button></div>
</form>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
