<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <!-- Formulaire d'inscription -->
    <section class="inscription">
        <h2>Créer un nouveau compte</h2>
        <form method="POST" action="">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" required minlength="3" placeholder="Votre pseudo">

            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required minlength="3" placeholder="Votre nom">

            <label for="prenoms">Prénoms</label>
            <input type="text" id="prenoms" name="prenoms" required minlength="3" placeholder="Vos prénoms">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Votre email">

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" required minlength="6" placeholder="Votre mot de passe">

            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" required>
                <option value="m" selected>Homme</option>
                <option value="f">Femme</option>
            </select>

            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" required placeholder="Votre ville">

            <button type="submit">Créer mon compte</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require "config/db.php";

            $pseudo = trim($_POST['pseudo']);
            $nom = trim($_POST['nom']);
            $prenoms = trim($_POST['prenoms']);
            $email = trim($_POST['email']);
            $mdp = $_POST['mdp'];
            $sexe = $_POST['sexe'];
            $ville = trim($_POST['ville']);

            // Vérifier si le compte existe déjà
            $sql = "SELECT * FROM membre WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $membre = $stmt->fetch();

            if ($membre) {
                echo "<p style='color:red; text-align:center; margin-top:15px;'>Ce compte existe déjà. Veuillez vous connecter.</p>";
                echo '<p style="text-align:center;"><a href="connexion.php">Se connecter</a></p>';
            } else {
                // Inscription : ajouter dans la BD
                $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

                $sql = "INSERT INTO membre (pseudo, nom, prenoms, email, mdp, sexe, ville, statut)
                        VALUES (:pseudo, :nom, :prenoms, :email, :mdp, :sexe, :ville, 1)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'pseudo' => $pseudo,
                    'nom' => $nom,
                    'prenoms' => $prenoms,
                    'email' => $email,
                    'mdp' => $mdp_hash,
                    'sexe' => $sexe,
                    'ville' => $ville
                ]);

                // Créer la session et rediriger vers le dashboard
                $_SESSION['membre'] = [
                    'pseudo' => $pseudo,
                    'nom' => $nom,
                    'prenoms' => $prenoms,
                    'email' => $email,
                    'sexe' => $sexe,
                    'ville' => $ville
                ];

                echo "<p style='color:green; text-align:center; margin-top:15px;'>Inscription réussie. Bienvenue " . htmlspecialchars($pseudo) . " !</p>";
                echo '<p style="text-align:center;"><a href="dashboard.php">Aller au tableau de bord</a></p>';
            }
        }
        ?>

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