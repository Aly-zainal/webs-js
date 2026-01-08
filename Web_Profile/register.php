<?php
require_once 'inc.php';
$pdo = get_db();
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'] === 'company' ? 'company' : 'seeker';
    if(!$username || !$password){ $error = 'Isi semua field.'; }
    else{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username,password,role) VALUES (?,?,?)');
        try{
            $stmt->execute([$username,$hash,$role]);
            header('Location: login.php'); exit;
        }catch(Exception $e){ $error = 'Username sudah ada.'; }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Register</h2>
  <?php if($error) echo '<p class="err">'.htmlspecialchars($error).'</p>'; ?>
  <form method="post">
    <label>Username<br><input name="username"></label><br>
    <label>Password<br><input type="password" name="password"></label><br>
    <label>Role<br>
      <select name="role">
        <option value="seeker">Pencari Kerja</option>
        <option value="company">Perusahaan</option>
      </select>
    </label><br>
    <button type="submit">Daftar</button>
  </form>
  <p><a href="login.php">Sudah punya akun? Login</a></p>
</body>
</html>
