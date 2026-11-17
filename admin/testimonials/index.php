<?php
$pageTitle = 'Testimonials';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$rows = db()->query('SELECT * FROM testimonials ORDER BY sort_order, id DESC')->fetchAll();
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px"><h2 style="margin:0">Testimonials (<?= count($rows) ?>)</h2><a class="btn btn-navy btn-sm" href="edit.php">+ New Testimonial</a></div>
  <?php if (!$rows): ?><p class="text-slate">None yet. Collect signed quotes from principals or coordinators first; do not fabricate.</p><?php endif; ?>
  <table class="admin-table">
    <thead><tr><th>Quote</th><th>By</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td style="max-width:420px;font-style:italic">“<?= e(mb_strimwidth($r['quote'], 0, 120, '…')) ?>”</td>
        <td><?= e($r['author_name']) ?><br><small class="text-slate"><?= e($r['author_role']) ?> · <?= e($r['author_institution']) ?></small></td>
        <td><?= $r['is_active']?'<span class="badge-status bs-approved">Yes</span>':'<span class="badge-status bs-closed">No</span>' ?></td>
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
