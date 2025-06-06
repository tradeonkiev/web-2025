<?php
require_once 'db_connection.php'; 
require_once 'api/auth.php';

$userId = isset($_GET['id'])? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
$session = authBySession($pdo);
if (!$userId && array_key_exists('id', $session)){
    $userId = $session['id'];
}
if (!$userId || $userId <= 0) {
    header("Location: /home.php");
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            id,
            username AS name,
            email,
            avatar_path AS avatar,
            (SELECT COUNT(*) FROM post WHERE user_id = user.id) AS posts_count
        FROM 
            user 
        WHERE 
            id = ?
    ");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: /home.php");
        exit;
    }

    $user['description'] = 'Привет! Я ' . $user['name'] . '. Добро пожаловать на мою страницу!';

    $stmt = $pdo->prepare("
        SELECT 
            id,
            content,
            posted_at
        FROM 
            post 
        WHERE 
            user_id = ?
        ORDER BY 
            posted_at DESC
    ");
    $stmt->execute([$userId]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("DBASE error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="profile/styles.css" />
        <title>Profile - <?= htmlspecialchars($user['name']) ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap"
            rel="stylesheet"
        />
    </head>
    <body>
        <div class="navigation">
            <div class="nav-item">
                <img src="asset/menu_home.png" alt="Home" />
            </div>
            <div class="nav-item">
                <img src="asset/menu_user.png" alt="Profile" />
            </div>
            <div class="nav-item">
                <img src="asset/menu_plus.png" alt="Plus" />
            </div>
        </div>
        <div class="wrapper">
            <?php include 'profile/profile_template.php'; ?>
            <div class="userposts">
                <?php foreach ($posts as $post): ?>
                    <?php include 'profile/post_template.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>