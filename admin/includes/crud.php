<?php
/**
 * Lightweight CRUD helpers for admin modules.
 */

/** Safe table name (allow-list via known tables in init). */
function tbl(string $name): string {
    static $allowed = [
        'competitions','competition_categories','events','event_categories',
        'event_registrations','participants','portfolio_items','portfolio_images',
        'partners','partner_categories','sponsorship_tiers','sponsorship_applications',
        'apex_card_types','apex_card_applications','proposal_enquiries','contact_messages',
        'trip_enquiries','faqs','team_members','testimonials','subscribers','media',
        'site_settings','pages','navigation_items','social_links','admins'
    ];
    if (!in_array($name, $allowed, true)) {
        http_response_code(500); exit('Unknown table ' . e($name));
    }
    return "`$name`";
}

function find_row(string $table, int $id): ?array {
    $stmt = db()->prepare('SELECT * FROM ' . tbl($table) . ' WHERE id=? LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function insert_row(string $table, array $data): int {
    $cols = array_keys($data);
    $sql = 'INSERT INTO ' . tbl($table) . ' (' . implode(',', array_map(fn($c)=>'`'.preg_replace('/[^a-z_]/','',$c).'`', $cols)) . ') VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')';
    $stmt = db()->prepare($sql);
    $stmt->execute(array_values($data));
    return (int)db()->lastInsertId();
}

function update_row(string $table, int $id, array $data): void {
    $cols = array_keys($data);
    $set = implode(',', array_map(fn($c)=>'`'.preg_replace('/[^a-z_]/','',$c).'`=?', $cols));
    $stmt = db()->prepare('UPDATE ' . tbl($table) . ' SET ' . $set . ' WHERE id=?');
    $values = array_values($data); $values[] = $id;
    $stmt->execute($values);
}

function delete_row(string $table, int $id): void {
    $stmt = db()->prepare('DELETE FROM ' . tbl($table) . ' WHERE id=?');
    $stmt->execute([$id]);
}

function status_options(array $options): string {
    $out = '';
    foreach ($options as $k=>$v) {
        $out .= '<option value="' . e($k) . '">' . e($v) . '</option>';
    }
    return $out;
}
