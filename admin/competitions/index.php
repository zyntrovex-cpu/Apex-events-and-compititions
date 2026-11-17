<?php
$pageTitle = 'Competitions';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$status = $_GET['status'] ?? '';
$q = trim($_GET['q'] ?? '');

$where = []; $params = [];
if ($status) { $where[] = 'c.registration_status=?'; $params[] = $status; }
if ($q !== '') { $where[] = '(c.name LIKE ? OR c.city LIKE ?)'; $params[] = "%$q%"; $params[] = "%$q%"; }

$sql = 'SELECT c.*, cc.name AS category_name FROM competitions c LEFT JOIN competition_categories cc ON cc.id=c.category_id';
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY c.event_date ASC, c.id DESC';
$stmt = db()->prepare($sql); $stmt->execute($params);
$rows = $stmt->fetchAll();
?>

<div class="admin-card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:12px">
    <h2 style="margin:0">All competitions (<?= count($rows) ?>)</h2>
    <a class="btn btn-navy btn-sm" href="edit.php">+ New Competition</a>
  </div>

  <form method="GET" class="admin-filters">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search by name or city">
    <select name="status">
      <option value="">All statuses</option>
      <?php foreach (['open'=>'Open','closing_soon'=>'Closing soon','coming_soon'=>'Coming soon','closed'=>'Closed'] as $k=>$v): ?>
        <option value="<?= e($k) ?>"<?= $status===$k?' selected':'' ?>><?= e($v) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn btn-ghost btn-sm">Filter</button>
  </form>

  <?php if (!$rows): ?>
    <p class="text-slate">No competitions yet. <a href="edit.php">Create one</a>.</p>
  <?php else: ?>
  <table class="admin-table">
    <thead><tr><th>Name</th><th>Category</th><th>Date</th><th>City</th><th>Status</th><th>Registered</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r):
      $regs = (int)db()->query('SELECT COUNT(*) FROM event_registrations WHERE competition_id=' . (int)$r['id'])->fetchColumn();
    ?>
      <tr>
        <td><b><?= e($r['name']) ?></b><?php if ($r['is_featured']): ?> <span class="badge-status bs-new">Featured</span><?php endif; ?></td>
        <td><?= e($r['category_name'] ?? '—') ?></td>
        <td><?= e(format_date($r['event_date'])) ?></td>
        <td><?= e($r['city']) ?></td>
        <td><span class="badge-status bs-<?= e($r['registration_status']) ?>"><?= e(str_replace('_',' ',$r['registration_status'])) ?></span></td>
        <td><?= $regs ?></td>
        <td class="actions">
          <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= e($r['id']) ?>">Edit</a>
          <form method="POST" action="delete.php" style="display:inline" onsubmit="return confirm('Delete this competition and ALL its registrations?')">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= e($r['id']) ?>">
            <button class="btn btn-ghost btn-sm" style="color:var(--red);border-color:var(--red)">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
