<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/auth.php';
redirect(admin_user() ? 'dashboard.php' : 'login.php');
