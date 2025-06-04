<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connection.php';

session_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Missing ID']));
}

$stmt = $pdo->prepare('SELECT * FROM post WHERE id = :id AND user_id = :user_id');
$stmt->execute(
    [
        ':id' => $id,
        ':user_id' => $_SESSION['user_id']
    ]
);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    http_response_code(404);
    die(json_encode(['success' => false, 'error' => 'Post not found']));
}



$imageStmt = $pdo->prepare('SELECT image_name, position FROM post_images WHERE post_id = :id ORDER BY position');
$imageStmt->execute([':id' => $id]);
$images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'id' => $post['id'],
    'content' => $post['content'],
    'images' => $images
]);
