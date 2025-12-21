<?php
require "../config/database.php";
if (isset($_GET['id_produit']) && is_numeric($_GET['id_produit'])) {
    $id_product = (int) $_GET['id_produit'];
} else {
    die("ID de produit invalide.");
}
$product_details = get_prod_by_id($db, $id_product);


$title = $product_details['titre'] . " - " . $product_details['ville'];
$description = $product_details['description'];

$date_depart = explode(" ", $product_details['date_depart'])[0];
$date_arrivee = explode(" ", $product_details['date_arrivee'])[0];
$date_salle = "Du $date_depart au $date_arrivee";

$photo = strtolower($product_details['photo']);
$capacite = $product_details['capacite'];
$prix = $product_details['prix'];
$cp = $product_details['cp'];

$ville = $product_details['ville'];
$adresse = $product_details['adresse'];
$pays = $product_details['pays'];
$etat = $product_details['etat'];
?>