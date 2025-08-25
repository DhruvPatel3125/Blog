<?php
require_once __DIR__ . '/config/config.php';

// Pagination params
$perPage = 9; // 3 columns per row
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

// Search term
$q = trim((string)($_GET['q'] ?? ''));
$like = '%' . $q . '%';

// Build base query parts
$where = '';
$params = [];
if ($q !== '') {
    $where = 'WHERE title LIKE :q OR content LIKE :q';
    $params[':q'] = $like;
}

// Count total
$countSql = "SELECT COUNT(*) FROM posts $where";
$stmt = db()->prepare($countSql);
$stmt->execute($params);
$total = (int)$stmt->fetchColumn();
$totalPages = max(1, (int)ceil($total / $perPage));

// Fetch page
$listSql = "SELECT id, title, slug, image_path, created_at, excerpt
            FROM posts
            $where
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset";
$stmt = db()->prepare($listSql);
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

$page_title = 'Home';
require __DIR__ . '/includes/header.php';
?>

<h1 class="mb-4">Latest Posts</h1>
<?php if ($q !== ''): ?>
  <p class="text-muted">Results for "<?= e($q) ?>" (<?= e($total) ?>)</p>
<?php endif; ?>

<?php if (!$posts): ?>
  <div class="alert alert-info">No posts found.</div>
<?php endif; ?>

<div class="row g-4">
  <?php foreach ($posts as $post): ?>
    <div class="col-md-4">
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
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php if ($totalPages > 1): ?>
<nav aria-label="Posts pagination" class="mt-4">
  <ul class="pagination justify-content-center">
    <?php 
      $queryBase = $q !== '' ? '&q=' . urlencode($q) : '';
      $prevDisabled = $page <= 1 ? ' disabled' : '';
      $nextDisabled = $page >= $totalPages ? ' disabled' : '';
    ?>
    <li class="page-item<?= $prevDisabled ?>">
      <a class="page-link" href="<?= e($BASE_URL) ?>/index.php?page=<?= max(1, $page - 1) ?><?= $queryBase ?>" tabindex="-1">Previous</a>
    </li>

    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <li class="page-item <?= $p === $page ? 'active' : '' ?>">
        <a class="page-link" href="<?= e($BASE_URL) ?>/index.php?page=<?= $p ?><?= $queryBase ?>"><?= $p ?></a>
      </li>
    <?php endfor; ?>

    <li class="page-item<?= $nextDisabled ?>">
      <a class="page-link" href="<?= e($BASE_URL) ?>/index.php?page=<?= min($totalPages, $page + 1) ?><?= $queryBase ?>">Next</a>
    </li>
  </ul>
</nav>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>