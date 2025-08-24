<?php
require_once __DIR__ . '/../config/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? e($page_title) . ' | ' : '' ?>My PHP Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link href="<?= e($BASE_URL) ?>/assets/css/styles.css?v=<?= filemtime(__DIR__ . '/../assets/css/styles.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= e($BASE_URL) ?>/index.php">My PHP Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?= e($BASE_URL) ?>/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e($BASE_URL) ?>/admin/posts.php">Admin</a></li>
        <li class="nav-item ms-lg-3">
          <button class="btn btn-ghost btn-sm" id="themeToggle" type="button" aria-label="Toggle theme">Theme</button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container flash-stack">
  <?php if ($msg = get_flash('success')): ?>
    <div class="alert alert-success"><?= e($msg) ?></div>
  <?php endif; ?>
  <?php if ($msg = get_flash('error')): ?>
    <div class="alert alert-danger"><?= e($msg) ?></div>
  <?php endif; ?>