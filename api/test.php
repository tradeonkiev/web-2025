<?php
require_once __DIR__ . '/../db_connection.php';
require_once __DIR__ . '/auth.php';

$user = authBySession($pdo);
print_r($user); 
if (array_key_exists('error', $user)) {
    echo $user['error'];
} else {
    echo htmlspecialchars($user['username']) . "!";
}
?>
