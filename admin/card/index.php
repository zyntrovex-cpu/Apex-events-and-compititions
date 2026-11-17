<?php
$pageTitle = 'APEX Card — Types & Partners';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$types = db()->query('SELECT * FROM apex_card_types ORDER BY sort_order')->fetchAll();
$cardPartners = db()->query('SELECT COUNT(*) FROM partners WHERE is_card_partner=1')->fetchColumn();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">APEX Card types (<?= count($types) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Card Type</a></div>
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Tagline</th><th>Price</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($types as $r): ?>
      <tr>
        <td><b><?= e($r['name']) ?></b></td>
        <td><?= e($r['tagline']) ?></td>
        <td><?= e($r['price']) ?></td>
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

<div class="admin-card">
  <h2>APEX Card partners</h2>
  <p class="text-slate"><?= (int)$cardPartners ?> partners currently marked as APEX Card partners.</p>
  <a class="btn btn-ghost" href="../partners/index.php">Manage partners →</a>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
