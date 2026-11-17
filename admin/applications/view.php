<?php
$pageTitle = 'Card application';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('apex_card_applications', $id) : null;
if (!$row) { flash('err','Application not found.'); redirect('index.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (isset($_POST['_delete'])) { delete_row('apex_card_applications', $id); flash('ok','Deleted.'); redirect('index.php'); }
    update_row('apex_card_applications', $id, [
        'status' => $_POST['status'] ?? 'new',
        'admin_notes' => trim($_POST['admin_notes'] ?? ''),
    ]);
    flash('ok','Updated.'); redirect('view.php?id='.$id);
}
?>
<div class="admin-card"><h2>Application #<?= e($row['id']) ?> · <?= e($row['student_name']) ?></h2></div>
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
  <div class="admin-card">
    <table class="admin-table">
      <?php foreach ([
        'Received' => format_date($row['created_at'],'j M Y H:i'),
        'Card type' => $row['card_type_name'],
        'Student name' => $row['student_name'],
        'Date of birth' => $row['date_of_birth'] ?: '—',
        'Institution' => $row['institution_name'] . ' — ' . $row['class_year'],
        'Guardian' => $row['guardian_name'] ?: '—',
        'Phone / WhatsApp' => $row['phone'],
        'Email' => $row['email'] ?: '—',
        'City' => $row['city'],
        'Delivery address' => $row['delivery_address'],
      ] as $k=>$v): ?>
      <tr><td style="width:180px;background:var(--ivory);font-weight:600"><?= e($k) ?></td><td><?= nl2br(e($v)) ?></td></tr>
      <?php endforeach; ?>
    </table>
    <?php if ($row['photo']): ?><div style="margin-top:16px"><b>Student photo</b><br><img src="../../<?= e($row['photo']) ?>" style="max-width:220px;border-radius:12px;margin-top:8px"></div><?php endif; ?>
  </div>
  <div class="admin-card">
    <h2>Manage</h2>
    <form method="POST" class="form-inline">
      <?= csrf_field() ?>
      <label>Status<select name="status">
        <?php foreach (['new'=>'New','pending_payment'=>'Pending payment','approved'=>'Approved','printed'=>'Printed','delivered'=>'Delivered','rejected'=>'Rejected'] as $k=>$v): ?>
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
<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
