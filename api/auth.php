<?php
function authBySession(PDO $pdo): array {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        return ['error' => 'Unauthorized: No active session'];
    }

    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        return ['error' => 'User not found.'];
    }

    return $user;
}
?>
