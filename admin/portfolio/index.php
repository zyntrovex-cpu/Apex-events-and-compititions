<?php
$pageTitle = 'Portfolio / Past events';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT * FROM portfolio_items ORDER BY event_date DESC, id DESC')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">Past events (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Past Event</a></div>
  <?php if (!$rows): ?><p class="text-slate">None yet. <a href="edit.php">Create one</a>.</p><?php else: ?>
  <table class="admin-table">
    <thead><tr><th>Event</th><th>Category</th><th>Institution</th><th>Date</th><th>Published</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['category']) ?></td>
        <td><?= e($r['institution']) ?>, <?= e($r['city']) ?></td>
        <td><?= e(format_date($r['event_date'])) ?></td>
        <td><?= $r['is_published'] ? '<span class="badge-status bs-approved">Yes</span>' : '<span class="badge-status bs-closed">Draft</span>' ?></td>
        <td class="actions">
          <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= e($r['id']) ?>">Edit</a>
          <form method="POST" action="delete.php" style="display:inline" onsubmit="return confirm('Delete this event and its images?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= e($r['id']) ?>"><button class="btn btn-ghost btn-sm" style="color:var(--red);border-color:var(--red)">Delete</button></form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
