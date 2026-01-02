<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/connexion.php";
?>

<main class="container">
    <section class="connexion">
        <h2>Connexion</h2>
        <p>Connectez-vous pour accéder à votre compte LOKISALLE.</p>

        <?php if ($message): ?>
            <div
                style="padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; 
                <?= $message_type === 'error' ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #d4edda; color: #155724;' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($_SESSION['membre'])): ?>
            <form method="POST" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" autocomplete="username" required placeholder="Votre email"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required minlength="6"
                    placeholder="Votre mot de passe">

                <button type="submit">Se connecter</button>
            </form>
            <p style="text-align:center; margin-top:15px;">
                Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
            </p>
        <?php else: ?>
            <p style="text-align:center;">
                Vous êtes déjà connecté. <br>
                <a href="profil.php" class="btn">Aller à mon profil</a>
            </p>
        <?php endif; ?>

    </section>
</main>

<?php require "inc/bas.inc.php" ?>