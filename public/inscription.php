<?php

require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/inscription.php"; // Inclure la logique de traitement
?>

<main class="container">
    <!-- Formulaire d'inscription -->
    <section class="inscription">
        <h2>Créer un nouveau compte</h2>
        <form method="POST" action="">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required minlength="3" placeholder="Votre pseudo"
                value="<?= isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '' ?>">

            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required minlength="3" placeholder="Votre nom"
                value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">

            <label for="prenoms">Prénoms</label>
            <input type="text" id="prenoms" name="prenoms" required minlength="3" placeholder="Vos prénoms"
                value="<?= isset($_POST['prenoms']) ? htmlspecialchars($_POST['prenoms']) : '' ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre email"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" required minlength="6" placeholder="Votre mot de passe">

            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" required>
                <option value="m" <?= (isset($_POST['sexe']) && $_POST['sexe'] === 'm') ? 'selected' : 'selected' ?>>Homme
                </option>
                <option value="f" <?= (isset($_POST['sexe']) && $_POST['sexe'] === 'f') ? 'selected' : '' ?>>Femme</option>
            </select>

            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" required placeholder="Votre ville"
                value="<?= isset($_POST['ville']) ? htmlspecialchars($_POST['ville']) : '' ?>">

            <button type="submit">Créer mon compte</button>
        </form>

        <?php if ($message): ?>
            <p style="<?= $message_type === 'error' ? 'color:red;' : 'color:green;' ?> text-align:center; margin-top:15px;">
                <?= $message ?>
            </p>
        <?php endif; ?>

        <?php if ($message_type === 'error' && strpos($message, 'existe déjà') !== false): ?>
            <p style="text-align:center;">
                <a href="connexion.php">Se connecter</a>
            </p>
        <?php endif; ?>

        <?php if ($membre_inscrit): ?>
            <p style="text-align:center;">
                <a href="dashboard.php">Aller au tableau de bord</a>
            </p>
        <?php endif; ?>

        <p style="text-align:center; margin-top:15px;">
            Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a>
        </p>
    </section>

    <!-- Section bienvenue -->
    <section class="bienvenue">
        <h3>Bienvenue sur LOKISALLE</h3>
        <p>Site de location de salles pour entreprises et particuliers.</p>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>