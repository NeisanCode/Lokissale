<?php
// deconnexion_avec_confirmation.php
require "session.php";

// Vérifier si la déconnexion a été confirmée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_deconnexion'])) {
    // Stocker le pseudo pour le message
    $pseudo = isset($_SESSION["membre"]['pseudo']) ? $_SESSION["membre"]['pseudo'] : '';

    // Détruire la session
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    // Rediriger vers la page d'accueil
    header('Location: home.php?deconnexion=success&pseudo=' . urlencode($pseudo));
    exit();
}

// Si on arrive sur cette page sans confirmation, afficher la page de confirmation
?>