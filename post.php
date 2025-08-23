<?php
require_once __DIR__ . '/config/config.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    redirect('/index.php');
}

$stmt = db()->prepare('SELECT id, title, slug, image_path, content, created_at FROM posts WHERE slug = ? LIMIT 1');
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    set_flash('error', 'Post not found');
    redirect('/index.php');
}

$page_title = $post['title'];
require __DIR__ . '/includes/header.php';
?>

<article class="mb-4">
  <h1><?= e($post['title']) ?></h1>
  <?php if (!empty($post['image_path'])): ?>
    <img src="<?= e($BASE_URL . $post['image_path']) ?>" alt="<?= e($post['title']) ?>" class="img-fluid mb-3">
  <?php endif; ?>
  <div class="text-muted mb-3">Published <?= e(date('M d, Y', strtotime($post['created_at']))) ?></div>
  <div><?= nl2br(e($post['content'])) ?></div>
</article>

<a class="btn btn-outline-secondary" href="<?= e($BASE_URL) ?>/index.php">Back</a>

<?php require __DIR__ . '/includes/footer.php'; ?>