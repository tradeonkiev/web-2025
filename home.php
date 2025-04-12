<?php
require_once 'db_connection.php';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

try {
    $sql = "
        SELECT 
            p.*,
            u.username AS user_name,
            u.avatar_path AS user_avatar
        FROM 
            post p
        JOIN 
            user u ON p.user_id = u.id
    ";
    
    // Добавляем условие, если фильтруем по пользователю
    if ($userId > 0) {
        $sql .= "WHERE p.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
    } else {
        $stmt = $pdo->query($sql);
    }
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as &$post) {
        $post['timestamp'] = strtotime($post['posted_at']) * 1000;
    }
    unset($post);

} catch(PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="home/styles.css" />
        <title>Home</title>
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
                <img src="images/menu_home.png" alt="Home" onclick="redirectToPage('/home')"/>
            </div>
            <div class="nav-item">
                <img src="images/menu_user.png" alt="Profile" onclick="redirectToPage('/profile?id=1')"/>
            </div>
            <div class="nav-item">
                <img src="images/menu_plus.png" alt="Plus"  onclick="redirectToPage('/home')"/>
            </div>
        </div>
        <div class="wrapper">
            <div class="posts">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="userdata">
                            <div class="row">
                                <img src="<?= htmlspecialchars($post['user_avatar']) ?>" alt="User" class="avatar" />
                                <p class="text"><?= htmlspecialchars($post['user_name']) ?></p>
                            </div>
                            <img src="images/edit_vector.png" alt="Edit" class="edit" />
                        </div>
                        <div class="contentwrapper">
                            <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="Content" class="content" />
                            <p class="count">1/3</p>
                        </div>
                        <div class="likes">
                            <img src="images/like.png" alt="Like" />
                            <p><?= $post['likes'] ?? 0 ?></p>
                        </div>
                        <p class="content">
                            <strong><?= htmlspecialchars($post['title']) ?></strong><br>
                            <em><?= htmlspecialchars($post['subtitle']) ?></em><br>
                            <?= htmlspecialchars($post['content']) ?>
                            <span class="more">...еще</span>
                        </p>
                        <p class="time"><?= date('H:i', strtotime($post['posted_at'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    
    </body>
</html>