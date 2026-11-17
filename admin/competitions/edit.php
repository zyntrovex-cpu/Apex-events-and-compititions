<?php
$pageTitle = 'Edit competition';
require_once dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/crud.php';

$id = (int)($_GET['id'] ?? 0);
$row = $id ? find_row('competitions', $id) : null;

$categories = db()->query('SELECT id,name FROM competition_categories WHERE is_active=1 ORDER BY sort_order')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'name'             => trim($_POST['name'] ?? ''),
        'slug'             => slugify(trim($_POST['slug'] ?? '') ?: ($_POST['name'] ?? '')),
        'category_id'      => (int)($_POST['category_id'] ?? 0) ?: null,
        'description'      => trim($_POST['description'] ?? ''),
        'eligibility'      => trim($_POST['eligibility'] ?? ''),
        'level'            => trim($_POST['level'] ?? ''),
        'team_size'        => trim($_POST['team_size'] ?? ''),
        'event_date'       => trim($_POST['event_date'] ?? '') ?: null,
        'event_end_date'   => trim($_POST['event_end_date'] ?? '') ?: null,
        'registration_deadline' => trim($_POST['registration_deadline'] ?? '') ?: null,
        'venue'            => trim($_POST['venue'] ?? ''),
        'city'             => trim($_POST['city'] ?? ''),
        'entry_fee'        => trim($_POST['entry_fee'] ?? ''),
        'prizes'           => trim($_POST['prizes'] ?? ''),
        'registration_status' => $_POST['registration_status'] ?? 'open',
        'is_featured'      => isset($_POST['is_featured']) ? 1 : 0,
    ];
    if (!empty($_FILES['cover_image']['tmp_name'])) {
        if ($p = upload_file($_FILES['cover_image'], 'events')) $data['cover_image'] = $p;
    }
    if ($data['name'] === '') { flash('err','Name is required.'); redirect('edit.php' . ($id ? '?id='.$id : '')); }

    try {
        if ($row) { update_row('competitions', $id, $data); flash('ok', 'Competition updated.'); log_admin_activity('update','competition',$id); }
        else { $id = insert_row('competitions', $data); flash('ok', 'Competition created.'); log_admin_activity('create','competition',$id); }
        redirect('index.php');
    } catch (Throwable $e) {
        flash('err', 'Save failed: ' . $e->getMessage());
    }
}
?>

<div class="admin-card">
  <h2><?= $row ? 'Edit competition' : 'New competition' ?></h2>
  <form method="POST" enctype="multipart/form-data" class="form-inline">
    <?= csrf_field() ?>
    <div class="form-cols">
      <label>Name<input type="text" name="name" required value="<?= e($row['name'] ?? '') ?>"></label>
      <label>Slug (URL)<input type="text" name="slug" value="<?= e($row['slug'] ?? '') ?>" placeholder="auto from name"></label>
      <label>Category<select name="category_id">
        <option value="">—</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= e($c['id']) ?>"<?= ($row['category_id'] ?? 0)==$c['id']?' selected':'' ?>><?= e($c['name']) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Registration status<select name="registration_status">
        <?php foreach (['open'=>'Open','closing_soon'=>'Closing soon','coming_soon'=>'Coming soon','closed'=>'Closed'] as $k=>$v): ?>
          <option value="<?= e($k) ?>"<?= ($row['registration_status'] ?? '')===$k?' selected':'' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select></label>
      <label>Event date<input type="date" name="event_date" value="<?= e($row['event_date'] ?? '') ?>"></label>
      <label>End date (optional)<input type="date" name="event_end_date" value="<?= e($row['event_end_date'] ?? '') ?>"></label>
      <label>Registration deadline<input type="date" name="registration_deadline" value="<?= e($row['registration_deadline'] ?? '') ?>"></label>
      <label>City<input type="text" name="city" value="<?= e($row['city'] ?? '') ?>"></label>
      <label>Venue<input type="text" name="venue" value="<?= e($row['venue'] ?? '') ?>"></label>
      <label>Level<input type="text" name="level" value="<?= e($row['level'] ?? '') ?>" placeholder="Junior, Middle, Senior…"></label>
      <label>Team size<input type="text" name="team_size" value="<?= e($row['team_size'] ?? '') ?>" placeholder="2 per team, Individual…"></label>
      <label>Entry fee<input type="text" name="entry_fee" value="<?= e($row['entry_fee'] ?? '') ?>" placeholder="PKR ..., Free"></label>
      <label class="full">Prizes<input type="text" name="prizes" value="<?= e($row['prizes'] ?? '') ?>" placeholder="Trophies, medals, certificates, scholarships"></label>
      <label class="full">Eligibility<input type="text" name="eligibility" value="<?= e($row['eligibility'] ?? '') ?>"></label>
      <label class="full">Description<textarea name="description"><?= e($row['description'] ?? '') ?></textarea></label>
      <label class="full">Cover image<input type="file" name="cover_image" accept="image/*"><?php if (!empty($row['cover_image'])): ?><span style="font-size:12px;color:var(--slate)">Current: <?= e($row['cover_image']) ?></span><?php endif; ?></label>
      <label><input type="checkbox" name="is_featured" value="1"<?= !empty($row['is_featured'])?' checked':'' ?>> Featured on homepage</label>
    </div>
    <div style="display:flex;gap:10px;margin-top:10px">
      <button class="btn btn-navy" type="submit">Save</button>
      <a class="btn btn-ghost" href="index.php">Cancel</a>
    </div>
  </form>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
