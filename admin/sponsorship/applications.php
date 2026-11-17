<?php
$pageTitle = 'Sponsorship Applications';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['view'] ?? 0);

if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['_delete'])) { delete_row('sponsorship_applications', $id); flash('ok','Deleted.'); redirect('applications.php'); }
    update_row('sponsorship_applications', $id, [
        'status' => $_POST['status'] ?? 'new',
        'admin_notes' => trim($_POST['admin_notes'] ?? ''),
    ]);
    flash('ok','Saved.'); redirect('applications.php?view=' . $id);
}

if ($id) {
    $row = find_row('sponsorship_applications', $id);
    if (!$row) { flash('err','Not found.'); redirect('applications.php'); }
?>
<div class="admin-card"><h2>Application #<?= e($row['id']) ?> · <?= e($row['company_name']) ?></h2></div>
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <table class="admin-table">
      <?php foreach ([
        'Received' => format_date($row['created_at'],'j M Y H:i'),
        'Company' => $row['company_name'],
        'Contact' => $row['contact_person'] . ' — ' . $row['designation'],
        'Email' => $row['email'],
        'Phone' => $row['phone'],
        'Preferred tier' => $row['tier_id'] ?: '—',
        'Interests' => $row['interests'],
        'Budget' => $row['budget'],
        'Message' => $row['message'],
      ] as $k=>$v): ?>
      <tr><td style="width:180px;background:var(--ivory);font-weight:600"><?= e($k) ?></td><td><?= nl2br(e($v)) ?></td></tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="admin-card">
    <h2>Manage</h2>
    <form method="POST" class="form-inline">
      <?= csrf_field() ?>
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
    $rows = db()->query('SELECT * FROM sponsorship_applications ORDER BY created_at DESC')->fetchAll();
?>
<div class="admin-card">
  <h2>Sponsorship applications (<?= count($rows) ?>)</h2>
  <table class="admin-table">
    <thead><tr><th>#</th><th>Company</th><th>Contact</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e($r['id']) ?></td>
        <td><?= e($r['company_name']) ?></td>
        <td><?= e($r['contact_person']) ?><br><small class="text-slate"><?= e($r['phone']) ?></small></td>
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
