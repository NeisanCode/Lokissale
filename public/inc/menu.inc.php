<?php
require "inc/menu_func.php";
require_once "../backend/session.php"; ?>


<nav class="menu">
    <?= nav_menu("Acceuil", "index.php"); ?>
    <?= nav_menu("Reservation", "reservation.php"); ?>
    <?= nav_menu("Recherche", "recherche.php"); ?>
    <?= nav_menu("Connexion", "connexion.php"); ?>
    <?= nav_menu("Inscription", "inscription.php"); ?>
</nav>