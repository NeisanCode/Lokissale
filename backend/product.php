<?php
require "../config/database.php";

if (isset($_GET['id_produit']) && is_numeric($_GET['id_produit'])) {
    $id_product = (int) $_GET['id_produit'];
} else {
    echo "Un problème est survenu.";
    die("ID de produit invalide.");
}
$product_details = get_product_details($db, $id_product);

// ---salle details variables
$title = $product_details['titre'];
$description = $product_details['description'];
$date_salle = "Du $date_depart au $date_arrivee";

$photo = strtolower($product_details['photo']);
$capacite = $product_details['capacite'];
$cp = $product_details['cp'];

$ville = $product_details['ville'];
$adresse = $product_details['adresse'];
$pays = $product_details['pays'];

// ---product details variables
$prix = $product_details['prix'];
$titre_page = "$title - $ville";
$prix_ht = number_format((float) $prix, 2, '.', '');
$prix_ttc = number_format((float) ($prix * 1.2), 2, '.', ''); // TVA à 20%

$date_depart = explode(" ", $product_details['date_depart'])[0];
$date_arrivee = explode(" ", $product_details['date_arrivee'])[0];



// ---avis details variables
$avis_note = $product_details['avis_note'];
$commentaire = $product_details['commentaire'];
$avis_date = $product_details['avis_date'];
$star_note = str_repeat("⭐", (int)$avis_note)." ($avis_note/5)";


// ---membre details variables
$membre_nom = $product_details['membre_nom'];
$membre_prenom = $product_details['membre_prenom'];
$fullname = "$membre_prenom $membre_nom";


?>