<?php require "public/inc/menu_func.php" ?>

<nav class="menu">
    <?= nav_menu("Acceuil", "index.php"); ?>
    <?= nav_menu("reservation", "reservation.php"); ?>
    <?= nav_menu("recherche", "recherche.php"); ?>
    <?= nav_menu("connexion", "connexion.php"); ?>
    <?= nav_menu("inscription", "inscription.php"); ?>
</nav>