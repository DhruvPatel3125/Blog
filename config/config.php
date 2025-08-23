<?php
// Basic configuration and helpers

// Adjust these to your local MySQL settings
const DB_HOST = 'localhost';
const DB_NAME = 'blog_db';
const DB_USER = 'root';
const DB_PASS = '';

// Base URL for links (XAMPP default would be http://localhost/Blog)
// Do not include trailing slash
$BASE_URL = '/Blog';

// Start session (for auth and flash)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('UTC');

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): void {
    global $BASE_URL;
    header('Location: ' . $BASE_URL . $path);
    exit;
}

function set_flash(string $key, string $message): void {
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string {
    if (!empty($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function is_logged_in(): bool {
    return !empty($_SESSION['user']);
}

function require_login(): void {
    if (!is_logged_in()) {
        set_flash('error', 'Please login first.');
        redirect('/admin/login.php');
    }
}

function slugify(string $text): string {
    // Simple slug generator
    $text = strtolower($text);
    $text = preg_replace('~[^\pL\pN]+~u', '-', $text);
    $text = trim($text, '-');
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    $text = preg_replace('~[^-a-z0-9]+~', '', $text);
    $text = preg_replace('~-+~', '-', $text);
    return $text ?: 'n-a';
}