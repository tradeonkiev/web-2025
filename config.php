<?php
$host = 'localhost';
$dbname = 'blog';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmtUsers = $pdo->query("SELECT * FROM user");

    while ($user = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
        echo "<h2>Пользователь: {$user['username']} ({$user['email']})</h2>";

        $stmtPosts = $pdo->prepare("SELECT * FROM post WHERE user_id = ?");
        $stmtPosts->execute([$user['id']]);

        $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

        if (count($posts) > 0) {
            echo "<ul>";
            foreach ($posts as $post) {
                echo "<li><strong>{$post['title']}</strong><br>{$post['subtitle']}<br><em>{$post['posted_at']}</em></li>";
            }
            echo "</ul>";
        } else {
            echo "<p><em>Нет постов</em></p>";
        }
    }

} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
