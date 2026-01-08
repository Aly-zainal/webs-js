<?php
require_once 'inc.php';
require_login();
$pdo = get_db();
$user = current_user();
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $skills = trim($_POST['skills']);
    $location = trim($_POST['location']);
    $category = trim($_POST['category']);
    $stmt = $pdo->prepare('UPDATE users SET name=?, skills=?, location=?, category=? WHERE id=?');
    $stmt->execute([$name,$skills,$location,$category,$user['id']]);
    if(!empty($_FILES['portfolio']['name'][0])){
        foreach($_FILES['portfolio']['tmp_name'] as $i => $tmp){
            if($_FILES['portfolio']['error'][$i] === 0){
                $file = ['name'=>$_FILES['portfolio']['name'][$i],'tmp_name'=>$tmp];
                $up = upload_file($file, $user['id']);
                if($up){
                    $stmt = $pdo->prepare('INSERT INTO portfolios (user_id,filename,filetype) VALUES (?,?,?)');
                    $stmt->execute([$user['id'],$up['name'],$up['ext']]);
                }
            }
        }
    }
    $msg = 'Disimpan.';
    $user = current_user();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Edit Profil</h2>
  <?php if($msg) echo '<p class="ok">'.htmlspecialchars($msg).'</p>'; ?>
  <form method="post" enctype="multipart/form-data">
    <label>Nama<br><input name="name" value="<?php echo htmlspecialchars($user['name']); ?>"></label><br>
    <label>Keahlian (pisah koma)<br><input name="skills" value="<?php echo htmlspecialchars($user['skills']); ?>"></label><br>
    <label>Domisili<br><input name="location" value="<?php echo htmlspecialchars($user['location']); ?>"></label><br>
    <label>Kategori<br><input name="category" value="<?php echo htmlspecialchars($user['category']); ?>"></label><br>
    <label>Tambah Portofolio (gambar / video)<br><input type="file" name="portfolio[]" multiple></label><br>
    <button type="submit">Simpan</button>
  </form>
  <p><a href="profile.php">Kembali ke profil</a></p>
</body>
</html>
