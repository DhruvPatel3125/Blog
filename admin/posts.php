<?php
require_once __DIR__ . '/../config/config.php';
require_login();

// Fetch posts
$stmt = db()->query('SELECT id, title, slug, created_at FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll();

$page_title = 'Manage Posts';
require __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="mb-0">Posts</h1>
  <a class="btn btn-primary" href="<?= e($BASE_URL) ?>/admin/post_new.php">New Post</a>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Title</th>
      <th>Slug</th>
      <th>Published</th>
      <th style="width:160px"></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($posts as $post): ?>
    <tr>
      <td><?= e($post['title']) ?></td>
      <td><?= e($post['slug']) ?></td>
      <td><?= e(date('M d, Y', strtotime($post['created_at']))) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= e($BASE_URL) ?>/admin/post_edit.php?id=<?= (int)$post['id'] ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= e($BASE_URL) ?>/admin/post_delete.php?id=<?= (int)$post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php require __DIR__ . '/../includes/footer.php'; ?>