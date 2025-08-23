<?php
require_once __DIR__ . '/../config/config.php';
require_login();

$title = '';
$excerpt = '';
$content = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        set_flash('error', 'Title and content are required.');
    } else {
        $slug = slugify($title);

        // Ensure unique slug
        $i = 1; $base = $slug;
        while (true) {
            $stmt = db()->prepare('SELECT COUNT(*) FROM posts WHERE slug = ?');
            $stmt->execute([$slug]);
            if ($stmt->fetchColumn() == 0) break;
            $i++; $slug = $base . '-' . $i;
        }

        // Handle image upload
        $imagePath = null;
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

        $stmt = db()->prepare('INSERT INTO posts(title, slug, image_path, excerpt, content, created_at) VALUES(?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$title, $slug, $imagePath, $excerpt, $content]);
        set_flash('success', 'Post created.');
        redirect('/admin/posts.php');
    }
}

$page_title = 'New Post';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="mb-3">New Post</h1>
<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" class="form-control" name="title" value="<?= e($title) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Featured Image</label>
    <input type="file" class="form-control" name="image" accept="image/*">
  </div>
  <div class="mb-3">
    <label class="form-label">Excerpt</label>
    <textarea class="form-control" name="excerpt" rows="2"><?= e($excerpt) ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Content</label>
    <textarea class="form-control" name="content" rows="10" required><?= e($content) ?></textarea>
  </div>
  <button class="btn btn-primary">Create</button>
  <a class="btn btn-outline-secondary" href="<?= e($BASE_URL) ?>/admin/posts.php">Cancel</a>
</form>
<?php require __DIR__ . '/../includes/footer.php'; ?>