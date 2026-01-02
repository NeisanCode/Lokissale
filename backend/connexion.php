<?php
require_once "../config/connexion.php"; // Ta connexion BDD
require_once "session.php";            // Doit contenir session_start()

$message = '';
$message_type = '';
$membre_connecte = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    // Ton traitement existant
    $membre = checkUser($email);

    if (!$membre) {
        $message = "Aucun compte trouvé pour cet email.";
        $message_type = 'error';
    } elseif (!password_verify($mdp, $membre['mdp'])) {
        $message = "Mot de passe incorrect.";
        $message_type = 'error';
    } else {
        $_SESSION['membre'] = $membre;
        $membre_connecte = $membre;
        $message = "Connexion réussie. Bienvenue " . htmlspecialchars($membre['pseudo']) . " !";
        $message_type = 'success';

        // Optionnel : redirection automatique après 2 secondes
        header("Refresh: 1; url=profil.php");
    }
}
