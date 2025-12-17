<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <!-- Formulaire de contact -->
    <section class="contact">
        <h2>Contactez-nous</h2>
        <p>Vous avez une question ? Envoyez-nous un message et nous vous répondrons rapidement.</p>

        <form id="formContact">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required minlength="3">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="objet">Objet</label>
            <input type="text" id="objet" name="objet" required>

            <label for="message">Message</label>
            <textarea id="messageText" name="messageText" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
            <p id="messageResponse"></p>
        </form>
    </section>

    <!-- Informations de contact -->
    <section class="infos-contact">
        <h3>Nos coordonnées</h3>
        <p><strong>Adresse :</strong> 123 Rue de l’Entreprise, Kinshasa, RDC</p>
        <p><strong>Téléphone :</strong> +243 123 456 789</p>
        <p><strong>Email :</strong> contact@lokisalle.com</p>
    </section>
</main>
<?php require "inc/bas.inc.php" ?>