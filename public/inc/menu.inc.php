<?php
require "inc/menu_func.php";
require_once "../backend/session.php"; ?>


<nav class="menu">
    <?= nav_menu("Acceuil", "index.php"); ?>
    <?= nav_menu("Reservation", "reservation.php"); ?>
    <?= nav_menu("Recherche", "recherche.php"); ?>

    <?php if (isset($_SESSION["membre"]) && ($_SESSION["membre"]["id_membre"]) && $_SESSION["membre"]["statut"] == 1): ?>
        <?= nav_menu("gestion-salle", "gestionsalle.php"); ?>


    <?php elseif (isset($_SESSION["membre"]) && ($_SESSION["membre"]["id_membre"]) && $_SESSION["membre"]["statut"] == 0): ?>
        <?= nav_menu("Votre profil", "profil.php"); ?>
        <?= nav_menu("Votre panier", "panier.php"); ?>


    <?php else: ?>
        <?= nav_menu("Connexion", "connexion.php"); ?>
        <?= nav_menu("Inscription", "inscription.php"); ?>
    <?php endif; ?>

</nav>