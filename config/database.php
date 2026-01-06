<?php
// $user = "dev";
// $pass = "password123";
// $host = "localhost";
// $port = "3306";
// $dbname="lokissale";
$user = "if0_40833342";
$pass = "Tc6UQq02ZuZm";
$host = "sql100.infinityfree.com";
$port = "3306";
$dbname="if0_40833342_lokissale_db";
try {
    $pdo = new PDO("mysql:host=$host:$port;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}




?>