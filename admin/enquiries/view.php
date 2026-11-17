<?php
$pageTitle = 'Enquiry details';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('proposal_enquiries', $id) : null;
if (!$row) { flash('err','Enquiry not found.'); redirect('index.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['_delete'])) {
        delete_row('proposal_enquiries', $id); flash('ok','Enquiry deleted.'); log_admin_activity('delete','enquiry',$id); redirect('index.php');
    }
    update_row('proposal_enquiries', $id, [
        'status' => $_POST['status'] ?? 'new',
        'admin_notes' => trim($_POST['admin_notes'] ?? ''),
    ]);
    log_admin_activity('update','enquiry',$id,'status: ' . ($_POST['status'] ?? ''));
    flash('ok','Enquiry updated.');
    redirect('view.php?id=' . $id);
}
?>
<div class="admin-card">
  <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;align-items:flex-start">
    <div>
      <h2 style="margin:0">Enquiry #<?= e($row['id']) ?> · <?= e($row['full_name']) ?></h2>
      <p class="text-slate" style="margin:4px 0 0"><?= e($row['designation']) ?> · <?= e($row['institution_name']) ?> (<?= e($row['institution_type']) ?>)</p>
    </div>
    <a class="btn btn-ghost btn-sm" href="index.php">← Back to list</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <h2>Details</h2>
    <table class="admin-table">
      <?php foreach ([
        'Received' => format_date($row['created_at'],'j M Y H:i'),
        'Email' => $row['email'] ?: '—',
        'Phone / WhatsApp' => $row['phone'],
        'Interests' => $row['interests'],
        'Event type' => $row['event_type'] ?: '—',
        'Expected date' => format_date($row['expected_date']) ?: '—',
        'City / Venue' => $row['city_venue'] ?: '—',
        'Participants' => $row['participants'] ?: '—',
        'Budget' => $row['budget'] ?: '—',
        'Heard about us via' => $row['source'] ?: '—',
        'Message' => $row['message'] ?: '—',
        'IP address' => $row['ip_address'] ?: '—',
      ] as $k=>$v): ?>
      <tr><td style="width:180px;font-weight:600;background:var(--ivory)"><?= e($k) ?></td><td><?= nl2br(e($v)) ?></td></tr>
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
      <button class="btn btn-navy" type="submit">Save</button>
    </form>
    <hr style="margin:22px 0;border:0;border-top:1px solid var(--line)">
    <form method="POST" onsubmit="return confirm('Permanently delete this enquiry?')">
      <?= csrf_field() ?>
      <input type="hidden" name="_delete" value="1">
      <button class="btn btn-ghost" style="color:var(--red);border-color:var(--red)" type="submit">Delete enquiry</button>
    </form>
  </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
