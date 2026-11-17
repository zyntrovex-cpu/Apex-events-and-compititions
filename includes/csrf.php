<?php
/**
 * CSRF token helpers — token stored in session, verified on every POST.
 */

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_verify(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}

function require_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_verify($_POST['_csrf'] ?? null)) {
        http_response_code(419);
        exit('Invalid CSRF token. Please reload the page and try again.');
    }
}
