<?php 
require "inc/haut.inc.php";
require "inc/menu.inc.php"; 
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