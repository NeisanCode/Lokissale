<?php

require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/connexion.php"; // Inclure la logique de traitement
?>

<main class="container">
    <!-- Formulaire de connexion -->
    <section class="connexion">
        <h2>Connexion</h2>
        <p>Connectez-vous pour accéder à votre compte LOKISALLE.</p>

        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre email"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

            <label for="motdepasse">Mot de passe</label>
            <input type="password" id="motdepasse" name="motdepasse" required minlength="6"
                placeholder="Votre mot de passe">

            <button type="submit">Se connecter</button>
        </form>

        <?php if ($message): ?>
            <p style="<?= $message_type === 'error' ? 'color:red;' : 'color:green;' ?> text-align:center; margin-top:15px;">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <?php if ($membre_connecte): ?>
            <p style="text-align:center;">
                <a href="dashboard.php">Aller au tableau de bord</a>
            </p>
        <?php endif; ?>

        <p style="text-align:center; margin-top:15px;">
            Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
        </p>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>