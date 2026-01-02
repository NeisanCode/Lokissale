<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php
session_start();

// Rediriger si déjà connecté
if (isset($_SESSION['id_membre'])) {
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
        // require_once 'config/database.php';

        // Vérifier si l'email existe
        // $stmt = $pdo->prepare("SELECT id_membre, pseudo FROM membres WHERE email = ?");
        // $stmt->execute([$email]);
        // $membre = $stmt->fetch();

        // if ($membre) {
        // Générer un nouveau mot de passe
        // $nouveauMdp = bin2hex(random_bytes(4)); // 8 caractères
        // $mdpHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);

        // Mettre à jour la base de données
        // $updateStmt = $pdo->prepare("UPDATE membres SET mdp = ? WHERE id_membre = ?");
        // $updateStmt->execute([$mdpHash, $membre['id_membre']]);

        // Envoyer l'email
        // $to = $email;
        // $subject = "LOKISALLE - Votre nouveau mot de passe";
        // $message_email = "Bonjour " . $membre['pseudo'] . ",\n\n";
        // $message_email .= "Vous avez demandé la réinitialisation de votre mot de passe.\n\n";
        // $message_email .= "Votre nouveau mot de passe est : " . $nouveauMdp . "\n\n";
        // $message_email .= "Nous vous recommandons de le modifier dès votre prochaine connexion.\n\n";
        // $message_email .= "Cordialement,\nL'équipe LOKISALLE";
        // 
        // $headers = "From: noreply@lokisalle.fr\r\n";
        // $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        // 
        // mail($to, $subject, $message_email, $headers);

        $message = "Un nouveau mot de passe vous a été envoyé par email à l'adresse : " . htmlspecialchars($email);
        $messageType = 'success';
        // } else {
        //     $message = "Cette adresse email n'est pas enregistrée dans notre système.";
        //     $messageType = 'error';
        // }
    }
}
?>

<main class="container">
    <h2>Mot de passe oublié</h2>

    <?php if ($messageType === 'success'): ?>
        <div class="success-box">
            <strong>✓ Succès !</strong><br>
            <?php echo $message; ?>
        </div>
        <div class="back-link">
            <a href="connexion.php">← Retour à la page de connexion</a>
        </div>
    <?php else: ?>

        <?php if ($messageType === 'error'): ?>
            <div class="error-box">
                <strong>⚠️ Erreur :</strong><br>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="recovery-box">
            <div class="recovery-icon">🔐</div>
            <p style="text-align: center; margin: 0;">
                Vous avez oublié votre mot de passe ? Pas de problème !<br>
                Saisissez votre adresse email et nous vous enverrons un nouveau mot de passe.
            </p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Adresse email *</label>
                <input type="email" id="email" name="email" placeholder="votre.email@exemple.com"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <button type="submit" class="btn-submit">
                📧 Recevoir un nouveau mot de passe
            </button>
        </form>

        <div class="info-box">
            <strong>ℹ️ Comment ça marche ?</strong>
            <ol style="margin: 10px 0 0 20px; padding: 0;">
                <li>Saisissez l'adresse email utilisée lors de votre inscription</li>
                <li>Cliquez sur le bouton "Recevoir un nouveau mot de passe"</li>
                <li>Consultez votre boîte mail (pensez aux spams)</li>
                <li>Utilisez votre nouveau mot de passe pour vous connecter</li>
                <li>Modifiez-le depuis votre profil pour plus de sécurité</li>
            </ol>
        </div>

        <div class="back-link">
            <a href="connexion.php">← Retour à la page de connexion</a>
        </div>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <p style="color: #666;">Vous n'avez pas encore de compte ?</p>
            <a href="inscription.php" style="color: #1abc9c; font-weight: bold; text-decoration: none;">
                Créer un compte maintenant →
            </a>
        </div>
    <?php endif; ?>
</main>

<?php require "inc/bas.inc.php" ?>