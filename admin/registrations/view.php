<?php
$pageTitle = 'Registration details';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('event_registrations', $id) : null;
if (!$row) { flash('err','Registration not found.'); redirect('index.php'); }

$comp = find_row('competitions', (int)$row['competition_id']);
$parts = db()->prepare('SELECT * FROM participants WHERE registration_id=? ORDER BY id');
$parts->execute([$id]);
$participants = $parts->fetchAll();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    require_csrf();
    if (isset($_POST['_delete'])) {
        delete_row('event_registrations', $id); flash('ok','Registration deleted.'); redirect('index.php');
    }
    update_row('event_registrations', $id, [
        'status' => $_POST['status'] ?? 'new',
        'admin_notes' => trim($_POST['admin_notes'] ?? ''),
    ]);
    flash('ok','Updated.');
    redirect('view.php?id='.$id);
}
?>
<div class="admin-card"><h2>Registration #<?= e($row['id']) ?> · <?= e($row['institution_name']) ?></h2><p class="text-slate" style="margin:0">For: <?= e($comp['name'] ?? '—') ?></p></div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <h2>Details</h2>
    <table class="admin-table">
      <?php foreach ([
        'Received' => format_date($row['created_at'],'j M Y H:i'),
        'Competition' => $comp['name'] ?? '—',
        'Institution' => $row['institution_name'] . ' (' . $row['institution_type'] . ')',
        'City' => $row['city'],
        'Coordinator' => $row['coordinator_name'] . ' — ' . $row['coordinator_role'],
        'Coordinator email' => $row['coordinator_email'],
        'Coordinator phone' => $row['coordinator_phone'],
        'Team name' => $row['team_name'] ?: '—',
        'Team size' => $row['team_size'] ?: '—',
        'Category level' => $row['category_level'] ?: '—',
        'Notes' => $row['notes'] ?: '—',
      ] as $k=>$v): ?>
      <tr><td style="width:180px;font-weight:600;background:var(--ivory)"><?= e($k) ?></td><td><?= nl2br(e($v)) ?></td></tr>
      <?php endforeach; ?>
    </table>

    <?php if ($participants): ?>
      <h3 style="margin-top:22px">Participants</h3>
      <table class="admin-table">
        <thead><tr><th>Name</th><th>Class / Grade</th><th>Age</th></tr></thead>
        <tbody>
        <?php foreach ($participants as $p): ?>
          <tr><td><?= e($p['full_name']) ?></td><td><?= e($p['class_grade']) ?></td><td><?= e($p['age']) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <div class="admin-card">
    <h2>Manage</h2>
    <form method="POST" class="form-inline">
      <?= csrf_field() ?>
      <label>Status<select name="status">
        <?php foreach (['new'=>'New','confirmed'=>'Confirmed','contacted'=>'Contacted','rejected'=>'Rejected','cancelled'=>'Cancelled'] as $k=>$v): ?>
          <option value="<?= e($k) ?>"<?= $row['status']===$k?' selected':'' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Internal notes<textarea name="admin_notes" rows="6"><?= e($row['admin_notes']) ?></textarea></label>
      <button class="btn btn-navy">Save</button>
    </form>
    <hr style="margin:22px 0;border:0;border-top:1px solid var(--line)">
    <form method="POST" onsubmit="return confirm('Delete this registration?')"><?= csrf_field() ?><input type="hidden" name="_delete" value="1"><button class="btn btn-ghost" style="color:var(--red);border-color:var(--red)">Delete</button></form>
  </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
