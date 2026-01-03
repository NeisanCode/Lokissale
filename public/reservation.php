<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php require "../backend/salle.php" ?>

<main class="container-large">
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Nos offres de location de salles</h2>
        <p>Découvrez toutes nos salles disponibles à la réservation pour vos événements professionnels et privés.</p>
    </section>

    <!-- Affichage des offres -->
    <section class="offres" style="margin-top:40px;">
        <h3>Salles disponibles</h3>
        <div class="offres-grid">
            <?= get_salles(); ?>
        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>