<?php
require_once "../config/connexion.php";

$message = '';
$message_type = ''; // 'error' ou 'success'
$membre_connecte = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $mdp = $_POST['motdepasse'];

    // Vérifier si l'utilisateur existe
    $membre = checkUser($email);


    if (!$membre) {
        $message = "Aucun compte trouvé pour cet email.";
        $message_type = 'error';
    } elseif (password_verify($mdp, $membre['mdp'])) {
        $message = "Mot de passe incorrect.";
        $message_type = 'error';
    } else {
        $_SESSION['membre'] = $membre;
        $membre_connecte = $membre;
        $message = "Connexion réussie. Bienvenue " . htmlspecialchars($membre['pseudo']) . " !";
        $message_type = 'success';
    }
}
?>