<?php
$pageTitle = 'Contact Messages';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['view'] ?? 0);
if ($id) {
    $row = find_row('contact_messages', $id);
    if ($row && $row['is_read'] === 0) { update_row('contact_messages', $id, ['is_read'=>1, 'status'=>'read']); }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_csrf();
        if (isset($_POST['_delete'])) { delete_row('contact_messages', $id); flash('ok','Deleted.'); redirect('index.php'); }
        update_row('contact_messages', $id, ['status'=>$_POST['status'] ?? 'new']);
        flash('ok','Saved.'); redirect('index.php?view='.$id);
    }
    if (!$row) { flash('err','Not found.'); redirect('index.php'); }
?>
<div class="admin-card"><h2>Message #<?= e($row['id']) ?> · <?= e($row['name']) ?></h2></div>
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <p class="text-slate"><?= e(format_date($row['created_at'],'j M Y H:i')) ?> · <?= e($row['email']) ?> · <?= e($row['phone']) ?></p>
    <?php if ($row['subject']): ?><h3><?= e($row['subject']) ?></h3><?php endif; ?>
    <div style="white-space:pre-wrap;background:var(--ivory);padding:18px;border-radius:12px;color:var(--navy);line-height:1.6"><?= e($row['message']) ?></div>
    <div style="margin-top:16px"><a class="btn btn-navy btn-sm" href="mailto:<?= e($row['email']) ?>">Reply by email</a></div>
  </div>
  <div class="admin-card">
    <h2>Manage</h2>
    <form method="POST" class="form-inline"><?= csrf_field() ?>
      <label>Status<select name="status">
        <?php foreach (['new'=>'New','read'=>'Read','replied'=>'Replied','archived'=>'Archived'] as $k=>$v): ?>
          <option value="<?= e($k) ?>"<?= $row['status']===$k?' selected':'' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select></label>
      <button class="btn btn-navy">Save</button>
    </form>
    <hr style="margin:22px 0;border:0;border-top:1px solid var(--line)">
    <form method="POST" onsubmit="return confirm('Delete?')"><?= csrf_field() ?><input type="hidden" name="_delete" value="1"><button class="btn btn-ghost" style="color:var(--red);border-color:var(--red)">Delete</button></form>
  </div>
</div>
<?php
} else {
    $rows = db()->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
?>
<div class="admin-card">
  <h2>Contact messages (<?= count($rows) ?>)</h2>
  <?php if (!$rows): ?><p class="text-slate">No contact messages yet.</p><?php else: ?>
  <table class="admin-table">
    <thead><tr><th>From</th><th>Subject</th><th>Status</th><th>Received</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr<?= $r['is_read']?'':' style="font-weight:600"' ?>>
        <td><?= e($r['name']) ?><br><small class="text-slate"><?= e($r['email']) ?></small></td>
        <td><?= e($r['subject'] ?: mb_strimwidth($r['message'], 0, 60, '…')) ?></td>
        <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e($r['status']) ?></span></td>
        <td><?= e(format_date($r['created_at'],'j M Y')) ?></td>
        <td><a class="btn btn-ghost btn-sm" href="?view=<?= e($r['id']) ?>">Open</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php }
require_once dirname(__DIR__) . '/includes/footer.php'; ?>
