<?php
require_once "database.php"; // Connexion à la base de données
function checkUser(string $email)
{
    global $pdo;
    $sql = "SELECT * FROM membre WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}
