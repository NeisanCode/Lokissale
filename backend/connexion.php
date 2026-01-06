<?php
require_once "../config/connexion.php";
require_once "session.php";

$message = '';
$message_type = '';
$membre_connecte = null;
$forgotten=false;
// Initialisation une seule fois
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['attempts'] >= 3) {
        $message = "Trop de tentatives. Réessayez plus tard.";
        $message_type = 'error';
        $forgotten = true;

    } else {
        $email = trim($_POST['email'] ?? '');
        $mdp = $_POST['password'] ?? '';

        if ($email === '' || $mdp === '') {
            $message = "Tous les champs sont obligatoires.";
            $message_type = 'error';
        } else {

            $membre = checkUser($email);
            if (!$membre) {
                $message = "Aucun compte trouvé pour cet email.";
                $message_type = 'error';
                $_SESSION['attempts']++;
            } elseif (!password_verify($mdp, $membre['mdp'])) {
                $_SESSION['attempts']++;
                $message = "Mot de passe incorrect (" . $_SESSION['attempts'] . "/3).";
                $message_type = 'error';

            } else {
                $_SESSION['attempts'] = 0; // reset
                $_SESSION['membre'] = $membre;

                $message = "Connexion réussie. Bienvenue " . htmlspecialchars($membre['pseudo']) . " !";
                $message_type = 'success';

                header("Location: profil.php");
                exit;
            }
        }
    }
}
