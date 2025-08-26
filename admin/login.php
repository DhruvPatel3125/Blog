<?php
require_once __DIR__ . '/../config/config.php';

if (is_logged_in()) {
    redirect('/admin/posts.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = db()->prepare('SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
        ];
        set_flash('success', 'Welcome back, ' . $user['name'] . '!');
        redirect('/admin/posts.php');
    } else {
        set_flash('error', 'Invalid credentials.');
    }
}

$page_title = 'Login';
require __DIR__ . '/../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <h1 class="mb-3">Admin Login</h1>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button class="btn btn-primary">Login</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>