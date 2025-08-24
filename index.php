<?php
require_once __DIR__ . '/config/config.php';

// Fetch latest posts
$stmt = db()->prepare('SELECT id, title, slug, image_path, created_at, excerpt FROM posts ORDER BY created_at DESC LIMIT 20');
$stmt->execute();
$posts = $stmt->fetchAll();

$page_title = 'Home';
require __DIR__ . '/includes/header.php';
?>

<h1 class="mb-4">Latest Posts</h1>
<?php if (!$posts): ?>
  <div class="alert alert-info">No posts yet.</div>
<?php endif; ?>

<div class="row g-4">
  <?php foreach ($posts as $post): ?>
    <div class="col-md-4"> <!-- Changed from col-md-6 to col-md-4 -->
      <div class="card h-100">
        <?php if (!empty($post['image_path'])): ?>
          <img src="<?= e($BASE_URL . $post['image_path']) ?>"
            class="card-img-top"
            alt="<?= e($post['title']) ?>">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title">
            <a href="<?= e($BASE_URL) ?>/post.php?slug=<?= e($post['slug']) ?>" class="text-decoration-none">
              <?= e($post['title']) ?>
            </a>
          </h5>

          <!-- <div class="text-muted small mb-2">
            Published <?= e(date('M d, Y', strtotime($post['created_at']))) ?>
          </div> -->
          <!-- <p class="card-text"><?= e($post['excerpt'] ?? '') ?></p> -->
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>