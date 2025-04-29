<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Only POST method alowed']));
}

if (empty($_FILES['image'])) {
    http_response_code(400);
    die(json_encode(['error' => 'No image']));
}

$imageFile = $_FILES['image'];

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $imageFile['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    http_response_code(400);
    die(json_encode(['error' => 'оnly JPG, PNG, GIF allowed']));
}

if ($imageFile['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    die(json_encode(['error' => 'Omage size is ' . (int)($imageFile['size'] / 1024 / 1024 / 5)]));
}
$uploadDir = __DIR__ . '/../images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
$fileName = uniqid() . '.' . $extension;
$targetPath = $uploadDir . $fileName;

if (move_uploaded_file($imageFile['tmp_name'], $targetPath)) {
    $imagePath = '/images/' . $fileName;
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'image_path' => $imagePath
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save image']);
}
?>