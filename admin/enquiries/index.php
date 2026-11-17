<?php
$pageTitle = 'Proposal Enquiries';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$status = $_GET['status'] ?? '';
$q = trim($_GET['q'] ?? '');
$where = []; $params = [];
if ($status) { $where[] = 'status=?'; $params[] = $status; }
if ($q !== '') { $where[] = '(full_name LIKE ? OR institution_name LIKE ? OR email LIKE ? OR phone LIKE ?)'; $qq = "%$q%"; array_push($params,$qq,$qq,$qq,$qq); }
$sql = 'SELECT * FROM proposal_enquiries';
if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
$sql .= ' ORDER BY created_at DESC';
$stmt = db()->prepare($sql); $stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<div class="admin-card">
  <h2>Proposal enquiries (<?= count($rows) ?>)</h2>
  <form method="GET" class="admin-filters">
    <input type="search" name="q" placeholder="Search name, institution, email or phone" value="<?= e($q) ?>">
    <select name="status">
      <option value="">All statuses</option>
      <?php foreach (['new'=>'New','in_progress'=>'In progress','contacted'=>'Contacted','resolved'=>'Resolved','rejected'=>'Rejected'] as $k=>$v): ?>
        <option value="<?= e($k) ?>"<?= $status===$k?' selected':'' ?>><?= e($v) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn btn-ghost btn-sm">Filter</button>
  </form>
  <?php if (!$rows): ?><p class="text-slate">No enquiries yet.</p><?php else: ?>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Name</th><th>Institution</th><th>Interests</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['id']) ?></td>
        <td><?= e($r['full_name']) ?><br><small class="text-slate"><?= e($r['phone']) ?></small></td>
        <td><?= e($r['institution_name']) ?><br><small class="text-slate"><?= e($r['institution_type']) ?></small></td>
        <td style="max-width:260px;font-size:12.5px;color:var(--slate)"><?= e(mb_strimwidth($r['interests'] ?? '', 0, 120, '…')) ?></td>
        <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e(str_replace('_',' ',$r['status'])) ?></span></td>
        <td><?= e(format_date($r['created_at'],'j M Y H:i')) ?></td>
        <td><a class="btn btn-ghost btn-sm" href="view.php?id=<?= e($r['id']) ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
