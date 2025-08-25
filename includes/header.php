<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title ?? 'Blog') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Edu+NSW+ACT+Cursive:wght@400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:wght@500&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Existing CSS -->
    <link rel="stylesheet" href="<?= e($BASE_URL) ?>/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for sun/moon icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= e($BASE_URL) ?>/assets/css/styles.css?v=<?= filemtime(__DIR__ . '/../assets/css/styles.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="<?= e($BASE_URL) ?>/index.php">My PHP Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse w-100" id="nav">
      <form class="d-flex mx-lg-auto my-3 my-lg-0 order-lg-2" role="search" method="get" action="<?= e($BASE_URL) ?>/index.php">
        <input class="form-control me-2" type="search" placeholder="Search posts..." aria-label="Search" name="q" value="<?= e($_GET['q'] ?? '') ?>">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>
      <ul class="navbar-nav ms-lg-auto align-items-lg-center gap-lg-2 order-lg-3">
        <li class="nav-item"><a class="nav-link" href="<?= e($BASE_URL) ?>/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e($BASE_URL) ?>/admin/posts.php">Admin</a></li>
        <li class="nav-item ms-lg-3">
          <button class="btn btn-ghost btn-sm d-inline-flex align-items-center gap-2" id="themeToggle" type="button" aria-label="Toggle theme">
            <i class="fa-solid fa-moon" id="iconMoon" aria-hidden="true"></i>
            <i class="fa-solid fa-sun d-none" id="iconSun" aria-hidden="true"></i>
            <span class="visually-hidden">Toggle theme</span>
          </button>
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