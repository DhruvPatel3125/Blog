<?php
require_once __DIR__ . '/../config/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) redirect('/admin/posts.php');

$stmt = db()->prepare('SELECT id, title, slug, image_path, excerpt, content FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) {
    set_flash('error', 'Post not found.');
    redirect('/admin/posts.php');
}

$title = $post['title'];
$excerpt = $post['excerpt'];
$content = $post['content'];
$imagePath = $post['image_path'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        set_flash('error', 'Title and content are required.');
    } else {
        $slug = slugify($title);
        // Keep slug unique (excluding current)
        $i = 1; $base = $slug; $candidate = $slug;
        while (true) {
            $stmt = db()->prepare('SELECT COUNT(*) FROM posts WHERE slug = ? AND id <> ?');
            $stmt->execute([$candidate, $id]);
            if ($stmt->fetchColumn() == 0) { $slug = $candidate; break; }
            $i++; $candidate = $base . '-' . $i;
        }

        // Handle new image (optional)
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/gif' => '.gif', 'image/webp' => '.webp'];
            if (isset($allowed[$_FILES['image']['type']]) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = $allowed[$_FILES['image']['type']];
                $filename = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . $ext;
                $target = __DIR__ . '/../assets/uploads/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $imagePath = '/assets/uploads/' . $filename;
                } else {
                    set_flash('error', 'Failed to save image.');
                }
            } else {
                set_flash('error', 'Invalid image type. Use JPG, PNG, GIF, or WEBP.');
            }
        }

        $stmt = db()->prepare('UPDATE posts SET title = ?, slug = ?, image_path = ?, excerpt = ?, content = ? WHERE id = ?');
        $stmt->execute([$title, $slug, $imagePath, $excerpt, $content, $id]);
        set_flash('success', 'Post updated.');
        redirect('/admin/posts.php');
    }
}

$page_title = 'Edit Post';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="mb-3">Edit Post</h1>
<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" class="form-control" name="title" value="<?= e($title) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Featured Image</label>
    <input type="file" class="form-control" name="image" accept="image/*">
    <?php if (!empty($imagePath)): ?>
      <div class="form-text">Current: <a href="<?= e($BASE_URL . $imagePath) ?>" target="_blank">View</a></div>
      <img src="<?= e($BASE_URL . $imagePath) ?>" alt="Current image" class="img-fluid mt-2" style="max-height:150px">
    <?php endif; ?>
  </div>
  <div class="mb-3">
    <label class="form-label">Excerpt</label>
    <textarea class="form-control" name="excerpt" rows="2"><?= e($excerpt) ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea class="form-control" name="content" rows="10" required><?= e($content) ?></textarea>
  </div>
  <button class="btn btn-primary">Save</button>
  <a class="btn btn-outline-secondary" href="<?= e($BASE_URL) ?>/admin/posts.php">Cancel</a>
</form>
<?php require __DIR__ . '/../includes/footer.php'; ?>