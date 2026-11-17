<?php
/**
 * Lightweight email dispatcher.
 *
 * - If SMTP credentials are configured in site_settings AND PHPMailer is available,
 *   messages go through SMTP.
 * - Otherwise the function falls back to PHP mail(). If no mail transport is
 *   available (shared hosting without sendmail), it logs the message and returns false.
 */
function send_mail(string $to, string $subject, string $htmlBody, string $textBody = ''): bool
{
    $from     = setting('smtp_from', 'info@apex.local');
    $fromName = setting('smtp_from_name', 'APEX Events & Competitions');
    $host     = setting('smtp_host');
    $user     = setting('smtp_user');
    $pass     = setting('smtp_pass');
    $port     = (int)(setting('smtp_port', '587'));
    $enc      = strtolower(setting('smtp_encryption', 'tls'));

    // Try PHPMailer (if the host has installed it via composer)
    $phpMailer = APP_ROOT . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    if ($host && $user && file_exists($phpMailer)) {
        require_once APP_ROOT . '/vendor/autoload.php';
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $user;
            $mail->Password   = $pass;
            $mail->Port       = $port;
            if ($enc === 'ssl') $mail->SMTPSecure = 'ssl';
            elseif ($enc === 'tls') $mail->SMTPSecure = 'tls';
            $mail->CharSet    = 'UTF-8';
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body    = $htmlBody;
            $mail->AltBody = $textBody ?: strip_tags($htmlBody);
            return $mail->send();
        } catch (Throwable $e) {
            error_log('[APEX mail/PHPMailer] ' . $e->getMessage());
        }
    }

    // Fallback to native mail()
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= 'From: ' . $fromName . ' <' . $from . ">\r\n";
    $headers .= 'Reply-To: ' . $from . "\r\n";
    $headers .= 'X-Mailer: APEX/1.0' . "\r\n";

    if (function_exists('mail')) {
        $ok = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $htmlBody, $headers);
        if (!$ok) error_log("[APEX mail] native mail() failed for {$to}");
        return (bool)$ok;
    }
    error_log("[APEX mail] no transport — would send {$subject} to {$to}");
    return false;
}

function notify_admin_submission(string $type, string $summary, array $details): void
{
    $to = setting('admin_notify_email', 'admin@apex.local');
    if (!$to) return;
    $rows = '';
    foreach ($details as $k => $v) {
        $rows .= '<tr><td style="padding:6px 10px;background:#F6F3EC;border-bottom:1px solid #D9D3C4"><b>'
              . e($k) . '</b></td><td style="padding:6px 10px;border-bottom:1px solid #D9D3C4">'
              . nl2br(e(is_array($v) ? implode(', ', $v) : (string)$v)) . '</td></tr>';
    }
    $html = '<div style="font-family:Arial,sans-serif;color:#0E1A2B">
      <h2 style="color:#0E1A2B">New ' . e($type) . ' — APEX</h2>
      <p>' . e($summary) . '</p>
      <table cellpadding="0" cellspacing="0" style="border-collapse:collapse;border:1px solid #D9D3C4;width:100%">' . $rows . '</table>
      <p style="margin-top:20px;color:#5B6576;font-size:13px">Signed in to the dashboard to view and manage this record.</p>
    </div>';
    send_mail($to, '[APEX] New ' . $type, $html);
}

function send_applicant_confirmation(string $to, string $subject, string $heading, string $message): void
{
    if (!validate_email($to)) return;
    $html = '<div style="font-family:Arial,sans-serif;color:#0E1A2B">
      <div style="background:#0E1A2B;padding:24px;color:#F6F3EC;border-radius:10px 10px 0 0">
        <h2 style="margin:0;font-family:Georgia,serif">' . e($heading) . '</h2>
      </div>
      <div style="padding:20px;background:#F6F3EC;border-radius:0 0 10px 10px">
        <p style="font-size:15px;line-height:1.6">' . e($message) . '</p>
        <p style="font-size:14px;color:#5B6576;margin-top:24px">Need to reach us sooner? Email '
        . e(setting('contact_email')) . ' or call/WhatsApp ' . e(setting('contact_phone')) . '.</p>
      </div>
    </div>';
    send_mail($to, $subject, $html);
}
