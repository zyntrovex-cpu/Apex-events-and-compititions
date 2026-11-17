<?php
/**
 * APEX — shared helpers used across public pages and admin.
 */

if (!function_exists('e')) {
    function e($v): string {
        return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('old')) {
    function old(string $key, string $default = ''): string {
        if (!empty($_SESSION['_flash']['old'][$key])) {
            return (string)$_SESSION['_flash']['old'][$key];
        }
        return $default;
    }
}

if (!function_exists('flash')) {
    function flash(string $type, string $message): void {
        $_SESSION['_flash'][$type] = $message;
    }
    function flash_get(string $type): ?string {
        $v = $_SESSION['_flash'][$type] ?? null;
        unset($_SESSION['_flash'][$type]);
        return $v;
    }
    function flash_errors(array $errors = []): void {
        $_SESSION['_flash']['errors'] = $errors;
    }
    function errors_get(): array {
        $v = $_SESSION['_flash']['errors'] ?? [];
        unset($_SESSION['_flash']['errors']);
        return $v;
    }
    function flash_old(array $data): void {
        // Strip sensitive fields before flashing back
        unset($data['_csrf'], $data['password'], $data['password_hash']);
        $_SESSION['_flash']['old'] = $data;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void {
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('nav_items')) {
    function nav_items(string $location): array {
        try {
            $stmt = db()->prepare('SELECT label,url,is_cta FROM navigation_items WHERE location=? AND is_active=1 ORDER BY sort_order');
            $stmt->execute([$location]);
            return $stmt->fetchAll();
        } catch (Throwable $e) { return []; }
    }
}

if (!function_exists('social_links_all')) {
    function social_links_all(): array {
        try {
            $stmt = db()->query('SELECT platform,label,url,icon FROM social_links WHERE is_active=1 ORDER BY sort_order');
            return $stmt->fetchAll();
        } catch (Throwable $e) { return []; }
    }
}

if (!function_exists('current_page')) {
    function current_page(): string {
        return basename($_SERVER['PHP_SELF'] ?? '');
    }
}

if (!function_exists('nav_active')) {
    function nav_active(string $url): string {
        $url = basename(parse_url($url, PHP_URL_PATH) ?: '');
        return current_page() === $url ? ' aria-current="page"' : '';
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date, string $format = 'j M Y'): string {
        if (!$date) return '';
        try {
            return (new DateTime($date))->format($format);
        } catch (Throwable $e) { return $date; }
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT//IGNORE', $text) ?: $text;
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return $text ?: ('item-' . substr(bin2hex(random_bytes(3)), 0, 6));
    }
}

if (!function_exists('json_safe_decode')) {
    function json_safe_decode(?string $json): array {
        if (!$json) return [];
        $d = json_decode($json, true);
        return is_array($d) ? $d : [];
    }
}

if (!function_exists('validate_email')) {
    function validate_email(?string $email): bool {
        return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('validate_phone')) {
    function validate_phone(?string $phone): bool {
        if (!is_string($phone)) return false;
        $digits = preg_replace('/[^0-9]/', '', $phone);
        return strlen($digits) >= 10 && strlen($digits) <= 15;
    }
}

if (!function_exists('spam_honeypot_ok')) {
    function spam_honeypot_ok(string $field = 'website_url'): bool {
        return empty($_POST[$field]);
    }
}

if (!function_exists('upload_file')) {
    /**
     * Safely accept an uploaded image file.
     * Returns relative path (under uploads/) on success, null otherwise.
     */
    function upload_file(array $file, string $collection = 'general', int $maxBytes = 5242880): ?string {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
        if ($file['size'] > $maxBytes) return null;

        $allowed = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp','gif'=>'image/gif','pdf'=>'application/pdf'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) return null;

        $safe = bin2hex(random_bytes(10)) . '.' . $ext;
        $relDir = 'uploads/' . preg_replace('/[^a-z0-9_]/', '', $collection);
        $absDir = APP_ROOT . '/' . $relDir;
        if (!is_dir($absDir)) @mkdir($absDir, 0775, true);
        $target = $absDir . '/' . $safe;
        if (!move_uploaded_file($file['tmp_name'], $target)) return null;
        return $relDir . '/' . $safe;
    }
}

if (!function_exists('count_table')) {
    function count_table(string $table, string $where = '', array $params = []): int {
        $sql = "SELECT COUNT(*) FROM `" . preg_replace('/[^a-z_]/', '', $table) . "`";
        if ($where !== '') $sql .= ' WHERE ' . $where;
        try {
            $stmt = db()->prepare($sql);
            $stmt->execute($params);
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) { return 0; }
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return 'assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url_with')) {
    function url_with(array $params): string {
        $current = $_GET;
        foreach ($params as $k=>$v) {
            if ($v === null || $v === '') unset($current[$k]);
            else $current[$k] = $v;
        }
        $q = http_build_query($current);
        return '?' . $q;
    }
}
