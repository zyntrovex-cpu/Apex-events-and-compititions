<?php
/**
 * Minimal-site "freeze" mode.
 *
 * When `site_mode = minimal`, only the pages listed in
 * allowed_minimal_pages() are served to the public. Every other public
 * page files are left on disk so they can be re-enabled later by
 * simply setting `site_mode = full` in the admin Site Settings.
 *
 * To restore the full site: UPDATE site_settings
 *                           SET setting_value='full'
 *                           WHERE setting_key='site_mode';
 */

if (!function_exists('site_mode')) {
    function site_mode(): string {
        $m = setting('site_mode', 'minimal');
        return $m === 'full' ? 'full' : 'minimal';
    }
}

if (!function_exists('allowed_minimal_pages')) {
    function allowed_minimal_pages(): array {
        return [
            'index.php',
            'competitions.php',
            'about.php',
            'contact.php',
            'register-university.php',
            'register-college.php',
        ];
    }
}

if (!function_exists('freeze_if_minimal')) {
    /**
     * Call this at the very top of any page that should disappear when
     * site_mode is 'minimal'.
     */
    function freeze_if_minimal(): void {
        if (site_mode() !== 'minimal') return;
        $current = basename($_SERVER['PHP_SELF'] ?? '');
        if (!in_array($current, allowed_minimal_pages(), true)) {
            header('Location: index.php', true, 302);
            exit;
        }
    }
}

if (!function_exists('is_minimal_mode')) {
    function is_minimal_mode(): bool { return site_mode() === 'minimal'; }
}
