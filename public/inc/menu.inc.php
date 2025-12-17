<?php
function nav_menu(string $title, string $filename): string
{
    $classname = "";
    if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
        $classname .= "active";
    }
    return "<a href='$filename' class='$classname'>$title</a> ";
}
?>

<nav class="menu">
    <?php
    nav_menu("Acceuil", "index.php");
    nav_menu("reservation", "reservation.php");
    nav_menu("recherche", "recherche.php");
    nav_menu("connexion", "connexion.php");
    nav_menu("inscription", "inscription.php");

    ?>
</nav>