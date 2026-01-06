<?php
require_once '../config/database.php';
require_once 'session.php';


if (isset($_SESSION['membre']['id_membre'])) {
    header('Location: profil.php');
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Validation de l'email
    if (empty($email)) {
        $message = "Veuillez saisir votre adresse email.";
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email saisie n'est pas valide.";
        $messageType = 'error';
    } else {
        // Connexion à la base de données

        // Vérifier si l'email existe
        $stmt = $pdo->prepare("SELECT id_membre, pseudo FROM membre WHERE email = ?");
        $stmt->execute([$email]);
        $membre = $stmt->fetch();

        if ($membre) {
            // Générer un nouveau mot de passe
            $nouveauMdp = bin2hex(random_bytes(4)); // 8 caractères
            $mdpHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);

            // Mettre à jour la base de données
            $updateStmt = $pdo->prepare("UPDATE membre SET mdp = ? WHERE id_membre = ?");
            $updateStmt->execute([$mdpHash, $membre['id_membre']]);

            // Envoyer l'email
            $to = $email;
            $subject = "LOKISALLE - Votre nouveau mot de passe";
            $message_email = "Bonjour " . $membre['pseudo'] . ",\n\n";
            $message_email .= "Vous avez demandé la réinitialisation de votre mot de passe.\n\n";
            $message_email .= "Votre nouveau mot de passe est : " . $nouveauMdp . "\n\n";
            $message_email .= "Nous vous recommandons de le modifier dès votre prochaine connexion.\n\n";
            $message_email .= "Cordialement,\nL'équipe LOKISALLE";

            $headers = "From: noreply@lokisalle.fr\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            mail($to, $subject, $message_email, $headers);

            $message = "Un nouveau mot de passe vous a été envoyé par email à l'adresse : " . htmlspecialchars($email);
            $messageType = 'success';
        } else {
            $message = "Cette adresse email n'est pas enregistrée dans notre système.";
            $messageType = 'error';
        }
    }
}
?>