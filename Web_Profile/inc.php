<?php
session_start();

function get_db(){
    $dir = __DIR__ . '/db';
    if(!is_dir($dir)) mkdir($dir, 0755, true);
    $path = $dir . '/database.sqlite';
    $pdo = new PDO('sqlite:'.$path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    init_schema($pdo);
    return $pdo;
}

function init_schema($pdo){
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT,
        role TEXT DEFAULT 'seeker',
        name TEXT,
        skills TEXT,
        location TEXT,
        category TEXT
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS portfolios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        filename TEXT,
        filetype TEXT,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");
}

function current_user(){
    if(isset($_SESSION['user_id'])){
        $pdo = get_db();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

function require_login(){
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    }
}

function upload_file($file, $user_id){
    $uploads = __DIR__ . '/uploads';
    if(!is_dir($uploads)) mkdir($uploads, 0755, true);
    $name = basename($file['name']);
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif','mp4','webm'];
    if(!in_array(strtolower($ext), $allowed)) return false;
    $new = $uploads . '/' . $user_id . '_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/','_', $name);
    if(move_uploaded_file($file['tmp_name'], $new)){
        return ['path' => $new, 'name' => basename($new), 'ext'=>$ext];
    }
    return false;
}

?>
