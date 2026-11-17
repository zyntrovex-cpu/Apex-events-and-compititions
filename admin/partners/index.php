<?php
$pageTitle = 'Partners';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT p.*, pc.name AS category_name FROM partners p LEFT JOIN partner_categories pc ON pc.id=p.category_id ORDER BY pc.sort_order, p.sort_order')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">Partners (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Partner</a></div>
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Category</th><th>City</th><th>Discount</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['category_name']) ?></td>
        <td><?= e($r['city']) ?></td>
        <td><?= e($r['discount'] ?: '—') ?></td>
        <td><?= $r['is_active']?'<span class="badge-status bs-approved">Yes</span>':'<span class="badge-status bs-closed">No</span>' ?></td>
        <td class="actions">
          <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= e($r['id']) ?>">Edit</a>
          <form method="POST" action="delete.php" style="display:inline" onsubmit="return confirm('Delete this partner?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-ghost btn-sm" style="color:var(--red);border-color:var(--red)">Delete</button></form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
