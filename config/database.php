<?php
$user = "dev";
$pass = "password123";
try {
    $pdo = new PDO("mysql:host=localhost:3306;dbname=lokissale;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}




?>