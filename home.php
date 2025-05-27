<?php
require_once 'db_connection.php';
require_once 'api/auth.php';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

try {
    $sql = "
        SELECT 
            p.*,
            u.username AS user_name,
            u.avatar_path AS user_avatar,
            (SELECT COUNT(*) FROM post_images WHERE post_id = p.id) AS image_count,
            (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) AS likes
        FROM 
            post p
        JOIN user u ON p.user_id = u.id
        ORDER BY 
            posted_at DESC
    ";

    if ($userId > 0) {
        $sql .= " WHERE p.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
    } else {
        $stmt = $pdo->query($sql);
    }
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($posts as &$post) {
        $stmt = $pdo->prepare("SELECT image_name FROM post_images WHERE post_id = ? ORDER BY position");
        $stmt->execute([$post['id']]);
        $post['images'] = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $post['timestamp'] = strtotime($post['posted_at']) * 1000;
    }
    
    unset($post);

    $user = authBySession($pdo);
    $currentUserId = array_key_exists('id', $user)? $user['id'] : 1;

    $likedStmt = $pdo->prepare("SELECT post_id FROM post_likes WHERE user_id = ?");
    $likedStmt->execute([$currentUserId]);
    $likedPosts = array_column($likedStmt->fetchAll(PDO::FETCH_ASSOC), 'post_id');

    foreach ($posts as &$post) {
        $post['user_liked'] = in_array($post['id'], $likedPosts);
    }

} catch(PDOException $e) {
    die("DBASE error: " . $e->getMessage());
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
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet" />
    <script defer src="js/slider.js"></script>
    <script defer src="js/modal.js"></script>
    <script defer src="js/post-expand.js"></script>
    <script defer src="js/likes.js"></script>
</head>
<body>
    <div class="navigation">
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_home.png" alt="Home" onclick="redirectToPage('/home')"/>
        </div>
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_user.png" alt="Profile" onclick="redirectToPage('/profile?id=1')"/>
        </div>
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_plus.png" alt="Plus" onclick="redirectToPage('/home')"/>
        </div>
    </div>
    
    <div class="wrapper">
        <div class="posts">
            <?php foreach ($posts as $post): 
                include 'home/post_template.php';?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div id="imageModal" class="modal">
        <div class="modal__content">
            <span class="modal__close">&times;</span>
            <div class="modal__slider">
                <div class="modal-slides__container"></div>
                <div class="slider__controls">
                    <button class="slider__button modal__button modal__button--next">&lt;</button>
                    <button class="slider__button modal__button modal__button--prev">&gt;</button>
                </div>
            </div>
            <div class="modal__counter">1 из 3</div>
        </div>
    </div>
</body>
</html>

<!-- todo переделать картинку для загрузки -->