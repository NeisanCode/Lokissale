<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <!-- Formulaire de connexion -->
    <section class="connexion">
        <h2>Connexion</h2>
        <p>Connectez-vous pour accéder à votre compte LOKISALLE.</p>

        <form id="formConnexion">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre email">

            <label for="motdepasse">Mot de passe</label>
            <input type="password" id="motdepasse" name="motdepasse" required minlength="6" placeholder="Votre mot de passe">

            <button type="submit">Se connecter</button>
            <p id="messageConnexion"></p>
        </form>

        <p style="text-align:center; margin-top:15px;">
            Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
        </p>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>
