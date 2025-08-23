<?php
require_once __DIR__ . '/../config/config.php';
$_SESSION = [];
session_destroy();
set_flash('success', 'Logged out.');
redirect('/admin/login.php');