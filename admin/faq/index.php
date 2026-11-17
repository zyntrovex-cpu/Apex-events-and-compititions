<?php
$pageTitle = 'FAQ';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT * FROM faqs ORDER BY category, sort_order')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">FAQ (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Question</a></div>
  <table class="admin-table">
    <thead><tr><th>Category</th><th>Question</th><th>Active</th><th>Order</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['category']) ?></td>
        <td style="max-width:500px"><?= e($r['question']) ?></td>
        <td><?= $r['is_active'] ? '<span class="badge-status bs-approved">Yes</span>' : '<span class="badge-status bs-closed">No</span>' ?></td>
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
