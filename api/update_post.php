<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    die(json_encode(['error' => 'Missing post ID']));
}

$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error()) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid JSON']));
}

$requiredFields = ['content'];
foreach ($requiredFields as $field) {
    if (!isset($input[$field])) {
        http_response_code(400);
        die(json_encode(['error' => "Field $field is required"]));
    }
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("UPDATE post SET content = :content WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        ':id' => $id,
        ':user_id' => $_SESSION['user_id'],
        ':content' => $input['content']
    ]);

    $pdo->prepare("DELETE FROM post_images WHERE post_id = :id")->execute([':id' => $id]);

    $images = $input['images'] ?? [];
    $imageStmt = $pdo->prepare("INSERT INTO post_images (post_id, image_name, position) VALUES (:post_id, :image_name, :position)");

    foreach ($images as $position => $imageName) {
        $imageStmt->execute([
            ':post_id' => $id,
            ':image_name' => $imageName,
            ':position' => $position + 1
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'post_id' => $id]);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}