<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <!-- Formulaire d'inscription -->
    <section class="inscription">
        <h2>Créer un nouveau compte</h2>
        <form id="formInscription">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required minlength="3">

            <label for="prenoms">Prénoms</label>
            <input type="text" id="prenoms" name="prenoms" required minlength="3">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" required>
                <option value="">-- Choisir --</option>
                <option value="m">Homme</option>
                <option value="f">Femme</option>
            </select>

            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" required>

            <button type="submit">Créer mon compte</button>
            <p id="message"></p>
        </form>
    </section>

    <!-- Section bienvenue -->
    <section class="bienvenue">
        <h3>Bienvenue sur LOKISALLE</h3>
        <p>Site de location de salles pour entreprises et particuliers.</p>
    </section>
</main>
<?php require "inc/bas.inc.php" ?>