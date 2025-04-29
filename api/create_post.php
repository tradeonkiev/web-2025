<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../db_connection.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Method not allowed']));
}

$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error()) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid JSON data']));
}

$requiredFields = ['user_id', 'title', 'content', 'image'];
foreach ($requiredFields as $field) {
    if (!array_key_exists($field, $input)) {
        http_response_code(400);
        die(json_encode(['error' => "Field $field is required"]));
    }
}


try {
    $stmt = $pdo->prepare("
        INSERT INTO post (user_id, title, subtitle, content, image_path) 
        VALUES (:user_id, :title, :subtitle, :content, :image_path)
    ");

    $stmt->execute([
        ':user_id' => $input['user_id'],
        ':title' => $input['title'],
        ':subtitle' => $input['subtitle'] ?? null,
        ':content' => $input['content'],
        ':image_path' => "/images/" . $input['image']
    ]);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'post_id' => $pdo->lastInsertId(),
        'image_path' => "/images/" . $input['image']
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' =>  $e->getMessage()]);
}
?>