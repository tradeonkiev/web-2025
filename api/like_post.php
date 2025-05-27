<?php
require_once __DIR__ . '/../db_connection.php';
require_once __DIR__ . '/auth.php';


$user = authBySession($pdo);
$userId = array_key_exists('id', $user)? $user['id'] : 1;
$postId = $_POST['post_id'] ?? 1;

if (!$userId || !$postId) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid post_id or user_id']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$postId, $userId]);

    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        $action = 'removed';
    } else {
        $stmt = $pdo->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
        $stmt->execute([$postId, $userId]);
        $action = 'added';
    }
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM post_likes WHERE post_id = ?");
    $stmt->execute([$postId]);
    $likes = (int)$stmt->fetchColumn();

    echo json_encode([
        'status' => 'success',
        'action' => $action,
        'likes' => $likes
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB Error: ' . $e->getMessage()]);
}
