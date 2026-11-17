<?php
$pageTitle = 'APEX Card Applications';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';
$status = $_GET['status'] ?? '';
$where = $params = [];
if ($status) { $where[] = 'status=?'; $params[] = $status; }
$sql = 'SELECT * FROM apex_card_applications';
if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
$sql .= ' ORDER BY created_at DESC';
$stmt = db()->prepare($sql); $stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<div class="admin-card">
  <h2>APEX Card applications (<?= count($rows) ?>)</h2>
  <form method="GET" class="admin-filters">
    <select name="status"><option value="">All</option><?php foreach (['new'=>'New','pending_payment'=>'Pending payment','approved'=>'Approved','printed'=>'Printed','delivered'=>'Delivered','rejected'=>'Rejected'] as $k=>$v): ?><option value="<?= e($k) ?>"<?= $status===$k?' selected':'' ?>><?= e($v) ?></option><?php endforeach; ?></select>
    <button class="btn btn-ghost btn-sm">Filter</button>
  </form>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Student</th><th>Institution</th><th>Card type</th><th>City</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['id']) ?></td>
        <td><?= e($r['student_name']) ?><br><small class="text-slate"><?= e($r['phone']) ?></small></td>
        <td><?= e($r['institution_name']) ?> · <?= e($r['class_year']) ?></td>
        <td><?= e($r['card_type_name']) ?></td>
        <td><?= e($r['city']) ?></td>
        <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e(str_replace('_',' ',$r['status'])) ?></span></td>
        <td><?= e(format_date($r['created_at'],'j M Y')) ?></td>
        <td><a class="btn btn-ghost btn-sm" href="view.php?id=<?= e($r['id']) ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
