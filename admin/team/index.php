<?php
$pageTitle = 'Team Members';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT * FROM team_members ORDER BY sort_order, id')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">Team members (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Member</a></div>
  <table class="admin-table">
    <thead><tr><th>Photo</th><th>Name</th><th>Role</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?php if ($r['photo']): ?><img src="../../<?= e($r['photo']) ?>" style="width:40px;height:40px;object-fit:cover;border-radius:50%"><?php else: ?>—<?php endif; ?></td>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['role']) ?></td>
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
