<?php
$pageTitle = 'Event Services';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT e.*, ec.name AS category_name FROM events e LEFT JOIN event_categories ec ON ec.id=e.category_id ORDER BY e.sort_order')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">Event services (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Service</a></div>
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Category</th><th>Active</th><th>Order</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['category_name']) ?></td>
        <td><?= $r['is_active']?'✓':'—' ?></td>
        <td><?= e($r['sort_order']) ?></td>
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
