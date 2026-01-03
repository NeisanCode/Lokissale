<?php
require_once "session.php";
require_once '../config/database.php';

// Vérifier si l'utilisateur est connecté
$isConnected = isset($_SESSION['membre']["id_membre"]);
$isSubscribed = false;
$message = '';

if ($isConnected) {
    // Connexion à la base de données

    // Vérifier si déjà abonné
    $stmt = $pdo->prepare("SELECT * FROM newsletter WHERE id_membre = ?");
    $stmt->execute([$_SESSION['membre']['id_membre']]);
    $isSubscribed = $stmt->rowCount() > 0;

    // Traitement de l'inscription
    if (isset($_POST['subscribe']) && !$isSubscribed) {
        // Insérer dans la table newsletter
        $stmt = $pdo->prepare("INSERT INTO newsletter (id_membre) VALUES (?)");
        if ($stmt->execute([$_SESSION['membre']['id_membre']])) {
            $message = 'success';
            $isSubscribed = true;
        }
        // Pour la démo
        $message = 'success';
        $isSubscribed = true;
    }

    // Traitement de la désinscription
    if (isset($_POST['unsubscribe']) && $isSubscribed) {
        // Supprimer de la table newsletter
        $stmt = $pdo->prepare("DELETE FROM newsletter WHERE id_membre = ?");
        if ($stmt->execute([$_SESSION['membre']['id_membre']])) {
            $message = 'unsubscribed';
            $isSubscribed = false;
        }
    }
}
?>