<?php
require_once 'inc.php';
$pdo = get_db();
$qskills = isset($_GET['skills'])?trim($_GET['skills']):'';
$location = isset($_GET['location'])?trim($_GET['location']):'';
$category = isset($_GET['category'])?trim($_GET['category']):'';
$params = [];
$where = "role='seeker'";
if($qskills){ $where .= " AND skills LIKE ?"; $params[] = '%'.$qskills.'%'; }
if($location){ $where .= " AND location LIKE ?"; $params[] = '%'.$location.'%'; }
if($category){ $where .= " AND category LIKE ?"; $params[] = '%'.$category.'%'; }
$stmt = $pdo->prepare('SELECT * FROM users WHERE '.$where.' ORDER BY id DESC');
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search Workers</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Filter Pencarian</h2>
  <form method="get">
    <label>Keahlian<br><input name="skills" value="<?php echo htmlspecialchars($qskills); ?>"></label><br>
    <label>Domisili<br><input name="location" value="<?php echo htmlspecialchars($location); ?>"></label><br>
    <label>Kategori<br><input name="category" value="<?php echo htmlspecialchars($category); ?>"></label><br>
    <button type="submit">Cari</button>
  </form>

  <h3>Hasil</h3>
  <?php foreach($results as $r): ?>
    <div class="card">
      <h4><?php echo htmlspecialchars($r['username']); ?></h4>
      <p><strong>Nama:</strong> <?php echo htmlspecialchars($r['name']); ?></p>
      <p><strong>Keahlian:</strong> <?php echo htmlspecialchars($r['skills']); ?></p>
      <p><strong>Domisili:</strong> <?php echo htmlspecialchars($r['location']); ?></p>
      <p><a href="profile_view.php?id=<?php echo $r['id']; ?>">Lihat Profil</a></p>
    </div>
  <?php endforeach; ?>

</body>
</html>
