<?php
/**
 * Admin authentication helpers.
 */

function admin_user(): ?array
{
    if (empty($_SESSION['admin_id'])) return null;
    static $cached = null;
    if ($cached !== null && (int)$cached['id'] === (int)$_SESSION['admin_id']) return $cached;
    try {
        $stmt = db()->prepare('SELECT id,name,email,role,is_active FROM admins WHERE id=? LIMIT 1');
        $stmt->execute([(int)$_SESSION['admin_id']]);
        $u = $stmt->fetch();
        if ($u && (int)$u['is_active'] === 1) {
            return $cached = $u;
        }
    } catch (Throwable $e) { /* ignore */ }
    return null;
}

function require_admin(): array
{
    $u = admin_user();
    if (!$u) {
        $_SESSION['_after_login'] = $_SERVER['REQUEST_URI'] ?? '';
        header('Location: login.php');
        exit;
    }
    return $u;
}

function attempt_login(string $email, string $password): bool
{
    $email = strtolower(trim($email));
    try {
        $stmt = db()->prepare('SELECT id,name,password_hash,is_active,failed_login_count,locked_until FROM admins WHERE email=? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        if (!$row) { usleep(300000); return false; }

        if ($row['locked_until'] && strtotime($row['locked_until']) > time()) {
            return false;
        }

        if ((int)$row['is_active'] !== 1) return false;

        if (!password_verify($password, $row['password_hash'])) {
            $failed = ((int)$row['failed_login_count']) + 1;
            $lockUntil = $failed >= 6 ? date('Y-m-d H:i:s', time() + 900) : null;
            $u = db()->prepare('UPDATE admins SET failed_login_count=?, locked_until=? WHERE id=?');
            $u->execute([$failed, $lockUntil, $row['id']]);
            usleep(300000);
            return false;
        }

        // success
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$row['id'];

        $u = db()->prepare('UPDATE admins SET failed_login_count=0, locked_until=NULL, last_login_at=NOW() WHERE id=?');
        $u->execute([$row['id']]);

        log_admin_activity('login', null, null, 'Admin signed in');
        return true;
    } catch (Throwable $e) {
        error_log('[APEX login] ' . $e->getMessage());
        return false;
    }
}

function admin_logout(): void
{
    if (!empty($_SESSION['admin_id'])) {
        log_admin_activity('logout', null, null, 'Admin signed out');
    }
    unset($_SESSION['admin_id']);
    session_regenerate_id(true);
}

function log_admin_activity(string $action, ?string $entityType = null, ?int $entityId = null, ?string $description = null): void
{
    try {
        $stmt = db()->prepare('INSERT INTO admin_activity_logs (admin_id,action,entity_type,entity_id,description,ip_address) VALUES (?,?,?,?,?,?)');
        $stmt->execute([
            (int)($_SESSION['admin_id'] ?? 0) ?: null,
            $action, $entityType, $entityId, $description, $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
    } catch (Throwable $e) { /* ignore */ }
}
