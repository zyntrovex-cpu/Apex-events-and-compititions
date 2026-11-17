<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/auth.php';

admin_logout();
redirect('login.php');
