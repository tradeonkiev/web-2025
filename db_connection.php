<?php
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch(PDOException $e) {
    die("DBASE error: " . $e->getMessage());
}
?>