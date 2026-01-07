<?php
require_once 'inc.php';
$pdo = get_db();
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php'); exit;
    }else{ $error = 'Login gagal.'; }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Login</h2>
  <?php if($error) echo '<p class="err">'.htmlspecialchars($error).'</p>'; ?>
  <form method="post">
    <label>Username<br><input name="username"></label><br>
    <label>Password<br><input type="password" name="password"></label><br>
    <button type="submit">Login</button>
  </form>
  <p><a href="register.php">Belum punya akun? Daftar</a></p>
</body>
</html>
