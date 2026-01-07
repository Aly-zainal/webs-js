<?php
require_once 'inc.php';
$user = current_user();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Job Portal</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Job Portal</h1>
    <nav>
      <?php if($user): ?>
        <a href="profile.php">Profile</a>
        <a href="search.php">Search</a>
        <?php if($user['role'] === 'admin'): ?><a href="admin.php">Admin</a><?php endif; ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="search.php">Search</a>
      <?php endif; ?>
    </nav>
  </header>
  <main>
    <h2>Welcome<?php if($user) echo ', '.htmlspecialchars($user['username']); ?></h2>
    <p>Platform untuk pencari kerja dan perusahaan. Gunakan menu untuk mendaftar, masuk, melihat profil, dan mencari kandidat.</p>
  </main>
</body>
</html>
