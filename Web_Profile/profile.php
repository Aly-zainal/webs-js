<?php
require_once 'inc.php';
require_login();
$pdo = get_db();
$user = current_user();
$stmt = $pdo->prepare('SELECT * FROM portfolios WHERE user_id = ?');
$stmt->execute([$user['id']]);
$ports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Profile</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Profil: <?php echo htmlspecialchars($user['username']); ?></h2>
  <p><strong>Nama:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
  <p><strong>Keahlian:</strong> <?php echo htmlspecialchars($user['skills']); ?></p>
  <p><strong>Domisili:</strong> <?php echo htmlspecialchars($user['location']); ?></p>
  <p><strong>Kategori:</strong> <?php echo htmlspecialchars($user['category']); ?></p>
  <p><a href="edit_profile.php">Edit Profil</a></p>

  <h3>Portofolio</h3>
  <div class="grid">
    <?php foreach($ports as $p):
      $f = 'uploads/' . $p['filename'];
      $ext = strtolower(pathinfo($p['filename'], PATHINFO_EXTENSION));
      if(in_array($ext,['jpg','jpeg','png','gif'])): ?>
        <div class="item"><img src="<?php echo $f; ?>" alt=""/></div>
      <?php elseif(in_array($ext,['mp4','webm'])): ?>
        <div class="item"><video controls src="<?php echo $f; ?>" width="320"></video></div>
      <?php endif; endforeach; ?>
  </div>

</body>
</html>
