<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php require "../backend/salle.php" ?>
<?php require_once "../config/database.php" ?>


<main class="container-large">
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Bienvenue sur LOKISALLE</h2>

        <p>
            LOKISALLE est spécialisée dans la location de salles pour réunions,
            séminaires, formations et événements professionnels ou privés.
        </p>

        <p>
            Présente à Paris, Lyon et Marseille, notre plateforme vous permet
            de réserver facilement des salles modernes et entièrement équipées.
        </p>
    </section>

    <!-- Offres -->
    <section class="offres">
        <h3>Nos 3 dernières offres</h3>

        <div class="offres-grid">
            <?= last_three_offers($pdo); ?>
        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>