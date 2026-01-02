<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <!-- Formulaire de connexion -->
    <section class="connexion">
        <h2>Connexion</h2>
        <p>Connectez-vous pour accéder à votre compte LOKISALLE.</p>

        <form id="formConnexion" method="POST" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre email">

            <label for="motdepasse">Mot de passe</label>
            <input type="password" id="motdepasse" name="mdp" required minlength="6" placeholder="Votre mot de passe">

            <button type="submit">Se connecter</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require "config/db.php"; // Connexion à la base de données
        
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $sql = "SELECT * FROM membre WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $membre = $stmt->fetch();

            if (!$membre) {
                echo "<p style='color:red; text-align:center;'>Aucun compte trouvé pour cet email.</p>";
            } elseif ($mdp !== $membre['mdp']) {
                echo "<p style='color:red; text-align:center;'>Mot de passe incorrect.</p>";
            } else {
                $_SESSION['membre'] = $membre;
                echo "<p style='color:green; text-align:center;'>Connexion réussie. Bienvenue " . htmlspecialchars($membre['pseudo']) . " !</p>";
                echo '<p style="text-align:center;"><a href="dashboard.php">Aller au tableau de bord</a></p>';
            }
        }
        ?>

        <p style="text-align:center; margin-top:15px;">
            Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
        </p>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>