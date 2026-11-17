<?php
$pageTitle = 'Trip Enquiries';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['view'] ?? 0);
if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['_delete'])) { delete_row('trip_enquiries', $id); flash('ok','Deleted.'); redirect('index.php'); }
    update_row('trip_enquiries', $id, [
        'status' => $_POST['status'] ?? 'new',
        'admin_notes' => trim($_POST['admin_notes'] ?? ''),
    ]);
    flash('ok','Saved.'); redirect('index.php?view='.$id);
}

if ($id) {
    $row = find_row('trip_enquiries', $id);
    if (!$row) { flash('err','Not found.'); redirect('index.php'); }
?>
<div class="admin-card"><h2>Trip enquiry #<?= e($row['id']) ?> · <?= e($row['institution_name']) ?></h2></div>
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <table class="admin-table">
      <?php foreach ([
        'Received' => format_date($row['created_at'],'j M Y H:i'),
        'Institution' => $row['institution_name'],
        'Contact' => $row['contact_name'],
        'Email' => $row['email'] ?: '—',
        'Phone' => $row['phone'],
        'Trip type' => $row['trip_type'],
        'Destination' => $row['destination'],
        'Expected date' => format_date($row['expected_date']) ?: '—',
        'Participants' => $row['participants'],
        'Age group' => $row['age_group'],
        'Notes' => $row['notes'],
      ] as $k=>$v): ?>
      <tr><td style="width:180px;background:var(--ivory);font-weight:600"><?= e($k) ?></td><td><?= nl2br(e($v)) ?></td></tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="admin-card">
    <h2>Manage</h2>
    <form method="POST" class="form-inline"><?= csrf_field() ?>
      <label>Status<select name="status">
        <?php foreach (['new'=>'New','in_progress'=>'In progress','contacted'=>'Contacted','resolved'=>'Resolved','rejected'=>'Rejected'] as $k=>$v): ?>
          <option value="<?= e($k) ?>"<?= $row['status']===$k?' selected':'' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Internal notes<textarea name="admin_notes" rows="6"><?= e($row['admin_notes']) ?></textarea></label>
      <button class="btn btn-navy">Save</button>
    </form>
    <hr style="margin:22px 0;border:0;border-top:1px solid var(--line)">
    <form method="POST" onsubmit="return confirm('Delete?')"><?= csrf_field() ?><input type="hidden" name="_delete" value="1"><button class="btn btn-ghost" style="color:var(--red);border-color:var(--red)">Delete</button></form>
  </div>
</div>
<?php
} else {
    $rows = db()->query('SELECT * FROM trip_enquiries ORDER BY created_at DESC')->fetchAll();
?>
<div class="admin-card">
  <h2>Trip enquiries (<?= count($rows) ?>)</h2>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Institution</th><th>Contact</th><th>Trip type</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['id']) ?></td>
        <td><?= e($r['institution_name']) ?></td>
        <td><?= e($r['contact_name']) ?><br><small class="text-slate"><?= e($r['phone']) ?></small></td>
        <td><?= e($r['trip_type']) ?></td>
        <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e(str_replace('_',' ',$r['status'])) ?></span></td>
        <td><?= e(format_date($r['created_at'],'j M Y')) ?></td>
        <td><a class="btn btn-ghost btn-sm" href="?view=<?= e($r['id']) ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php }
require_once dirname(__DIR__) . '/includes/footer.php'; ?>
