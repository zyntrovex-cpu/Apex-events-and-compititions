<?php
$pageTitle = 'Sponsorship Tiers';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT * FROM sponsorship_tiers ORDER BY sort_order')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
    <h2 style="margin:0">Sponsorship tiers (<?= count($rows) ?>)</h2>
    <div style="display:flex;gap:8px"><a class="btn btn-ghost btn-sm" href="applications.php">View applications</a><a class="btn btn-navy btn-sm" href="edit.php">+ New Tier</a></div>
  </div>
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Tagline</th><th>Price</th><th>Featured</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['tagline']) ?></td>
        <td><?= e($r['price']) ?></td>
        <td><?= $r['is_featured']?'✓':'—' ?></td>
        <td><?= $r['is_active']?'✓':'—' ?></td>
        <td class="actions">
          <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= e($r['id']) ?>">Edit</a>
          <form method="POST" action="delete.php" style="display:inline" onsubmit="return confirm('Delete?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-ghost btn-sm" style="color:var(--red);border-color:var(--red)">×</button></form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
