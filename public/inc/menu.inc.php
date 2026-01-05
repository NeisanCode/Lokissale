<?php
require "inc/menu_func.php";
require_once "../backend/session.php"; ?>


<nav class="menu">
    <?= nav_menu("Acceuil", "home.php"); ?>
    <?= nav_menu("Reservation", "reservation.php"); ?>
    <?= nav_menu("Recherche", "recherche.php"); ?>

    <?php if (isset($_SESSION["membre"]) && ($_SESSION["membre"]["id_membre"]) && $_SESSION["membre"]["statut"] == 1): ?>
        <?= nav_menu("Salle", "gestionsalle.php"); ?>
        <?= nav_menu("Membre", "gestionmembre.php"); ?>
        <?= nav_menu("Produit", "gestionprod.php"); ?>
        <?= nav_menu("Avis", "gestionavis.php"); ?>
        <?= nav_menu("Promo", "gestionpromo.php"); ?>
        <?= nav_menu("Profil", "profil.php"); ?>


    <?php elseif (isset($_SESSION["membre"]) && ($_SESSION["membre"]["id_membre"]) && $_SESSION["membre"]["statut"] == 0): ?>
        <?= nav_menu("Profil", "profil.php"); ?>
        <?= nav_menu("Panier", "panier.php"); ?>


    <?php else: ?>
        <?= nav_menu("Connexion", "connexion.php"); ?>
        <?= nav_menu("Inscription", "inscription.php"); ?>
    <?php endif; ?>

</nav>