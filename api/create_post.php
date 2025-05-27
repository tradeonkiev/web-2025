<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connection.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error()) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid JSON data']));
}

$requiredFields = ['user_id', 'content'];
foreach ($requiredFields as $field) {
    if (!isset($input[$field])) {
        http_response_code(400);
        die(json_encode(['error' => "Field $field is required"]));
    }
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("
        INSERT INTO post (user_id, content) 
        VALUES (:user_id, :content)
    ");
    
    $stmt->execute([
        ':user_id' => $input['user_id'],
        ':content' => $input['content']
    ]);
    
    $postId = $pdo->lastInsertId();
    $images = $input['images'] ?? [];
    $savedImages = [];

    if (!empty($images)) {
        $imageStmt = $pdo->prepare("
            INSERT INTO post_images (post_id, image_name, position) 
            VALUES (:post_id, :image_name, :position)
        ");



        foreach ($images as $position => $imageName) {
            $imageStmt->execute([
                ':post_id' => $postId,
                ':image_name' => $imageName,
                ':position' => $position + 1
            ]);
            $savedImages[] = [
                'name' => $imageName,
                'position' => $position + 1
            ];
        }
    }

    $pdo->commit();

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'post_id' => $postId,
        'images' => $savedImages
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}