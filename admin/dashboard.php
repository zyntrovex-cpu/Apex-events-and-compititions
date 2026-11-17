<?php
$pageTitle = 'Dashboard';
require_once dirname(__DIR__) . '/admin/includes/header.php';

$stats = [
    'Total enquiries'          => count_table('proposal_enquiries'),
    'Unread contact messages'  => count_table('contact_messages', "status='new'"),
    'Open competitions'        => count_table('competitions', "registration_status IN ('open','closing_soon')"),
    'Upcoming events'          => count_table('competitions', 'event_date >= CURDATE()'),
    'Past events'              => count_table('portfolio_items', 'is_published=1'),
    'Competition registrations'=> count_table('event_registrations'),
    'Total institutions'       => (int)db()->query('SELECT COUNT(DISTINCT institution_name) FROM proposal_enquiries')->fetchColumn(),
    'Total partners'           => count_table('partners', 'is_active=1'),
    'Sponsorship applications' => count_table('sponsorship_applications'),
    'APEX Card applications'   => count_table('apex_card_applications'),
    'Trip enquiries'           => count_table('trip_enquiries'),
    'Newsletter subscribers'   => count_table('subscribers', 'is_active=1'),
];

$recentEnquiries = db()->query('SELECT id,full_name,institution_name,status,created_at FROM proposal_enquiries ORDER BY created_at DESC LIMIT 5')->fetchAll();
$recentRegs = db()->query('SELECT r.id,r.institution_name,r.coordinator_name,r.status,r.created_at,c.name AS comp FROM event_registrations r LEFT JOIN competitions c ON c.id=r.competition_id ORDER BY r.created_at DESC LIMIT 5')->fetchAll();
?>

<div class="stat-grid">
  <?php foreach ($stats as $label => $count): ?>
  <div class="stat">
    <b><?= number_format($count) ?></b>
    <span><?= e($label) ?></span>
  </div>
  <?php endforeach; ?>
</div>

<div class="admin-card">
  <h2>Recent proposal enquiries</h2>
  <?php if (!$recentEnquiries): ?>
    <p class="text-slate">No enquiries yet. They will appear here as soon as someone submits the Request a Proposal form.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>#</th><th>Name</th><th>Institution</th><th>Status</th><th>Received</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($recentEnquiries as $r): ?>
        <tr>
          <td><?= e($r['id']) ?></td>
          <td><?= e($r['full_name']) ?></td>
          <td><?= e($r['institution_name']) ?></td>
          <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e(str_replace('_',' ',$r['status'])) ?></span></td>
          <td><?= e(format_date($r['created_at'],'j M Y H:i')) ?></td>
          <td><a class="btn btn-ghost btn-sm" href="enquiries/view.php?id=<?= e($r['id']) ?>">Open</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="admin-card">
  <h2>Recent competition registrations</h2>
  <?php if (!$recentRegs): ?>
    <p class="text-slate">No team registrations yet.</p>
  <?php else: ?>
    <table class="admin-table">
      <thead><tr><th>#</th><th>Competition</th><th>Institution</th><th>Coordinator</th><th>Status</th><th>Received</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($recentRegs as $r): ?>
        <tr>
          <td><?= e($r['id']) ?></td>
          <td><?= e($r['comp']) ?></td>
          <td><?= e($r['institution_name']) ?></td>
          <td><?= e($r['coordinator_name']) ?></td>
          <td><span class="badge-status bs-<?= e($r['status']) ?>"><?= e(str_replace('_',' ',$r['status'])) ?></span></td>
          <td><?= e(format_date($r['created_at'],'j M Y')) ?></td>
          <td><a class="btn btn-ghost btn-sm" href="registrations/view.php?id=<?= e($r['id']) ?>">Open</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="admin-card">
  <h2>Quick links</h2>
  <div style="display:flex;flex-wrap:wrap;gap:10px">
    <a class="btn btn-navy btn-sm" href="competitions/edit.php">+ New Competition</a>
    <a class="btn btn-ghost btn-sm" href="portfolio/edit.php">+ New Past Event</a>
    <a class="btn btn-ghost btn-sm" href="partners/edit.php">+ New Partner</a>
    <a class="btn btn-ghost btn-sm" href="faq/edit.php">+ New FAQ</a>
    <a class="btn btn-ghost btn-sm" href="testimonials/edit.php">+ New Testimonial</a>
  </div>
</div>

<?php require_once dirname(__DIR__) . '/admin/includes/footer.php'; ?>
