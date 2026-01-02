<?php require "inc/menu_func.php" ?>

<nav class="menu">
    <?= nav_menu("Acceuil", "index.php"); ?>
    <?= nav_menu("Reservation", "reservation.php"); ?>
    <?= nav_menu("Recherche", "recherche.php"); ?>
    <?= nav_menu("Connexion", "connexion.php"); ?>
    <?= nav_menu("Inscription", "inscription.php"); ?>
</nav>


<?php print_r($_SESSION); ?>