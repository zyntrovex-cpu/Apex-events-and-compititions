<?php
$pageTitle = 'Competition Registrations';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$status = $_GET['status'] ?? '';
$where = []; $params = [];
if ($status) { $where[] = 'r.status=?'; $params[] = $status; }
$sql = 'SELECT r.*, c.name AS comp_name FROM event_registrations r LEFT JOIN competitions c ON c.id=r.competition_id';
if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
$sql .= ' ORDER BY r.created_at DESC';
$stmt = db()->prepare($sql); $stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<div class="admin-card">
  <h2>Competition registrations (<?= count($rows) ?>)</h2>
  <form method="GET" class="admin-filters">
    <select name="status">
      <option value="">All statuses</option>
      <?php foreach (['new'=>'New','confirmed'=>'Confirmed','contacted'=>'Contacted','rejected'=>'Rejected','cancelled'=>'Cancelled'] as $k=>$v): ?>
        <option value="<?= e($k) ?>"<?= $status===$k?' selected':'' ?>><?= e($v) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn btn-ghost btn-sm">Filter</button>
  </form>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Competition</th><th>Institution</th><th>Coordinator</th><th>Team size</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['id']) ?></td>
        <td><?= e($r['comp_name']) ?></td>
        <td><?= e($r['institution_name']) ?>, <?= e($r['city']) ?></td>
        <td><?= e($r['coordinator_name']) ?><br><small class="text-slate"><?= e($r['coordinator_phone']) ?></small></td>
        <td><?= e($r['team_size'] ?: '—') ?></td>
        <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e($r['status']) ?></span></td>
        <td><?= e(format_date($r['created_at'],'j M Y')) ?></td>
        <td><a class="btn btn-ghost btn-sm" href="view.php?id=<?= e($r['id']) ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
