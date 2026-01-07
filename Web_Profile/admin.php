<?php
require_once 'inc.php';
require_login();
$me = current_user();
if($me['role'] !== 'admin'){ echo 'Access denied'; exit; }
$pdo = get_db();
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $pdo->prepare('DELETE FROM portfolios WHERE user_id=?')->execute([$id]);
    $pdo->prepare('DELETE FROM users WHERE id=?')->execute([$id]);
}
$users = $pdo->query('SELECT * FROM users ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Admin - Manage Users</h2>
  <table>
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['username']); ?></td>
        <td><?php echo htmlspecialchars($u['role']); ?></td>
        <td><a href="admin.php?delete=<?php echo $u['id']; ?>" onclick="return confirm('Hapus?')">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
