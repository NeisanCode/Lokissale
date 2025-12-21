<?php

$nana = "20";

$number = is_numeric($nana);
echo $number;

/*
/* 🔹 TRAITEMENT PHP À FAIRE
   1. Récupérer l'id_produit depuis l'URL : $_GET['id_produit']
   2. Requête SQL pour obtenir les infos du produit et de la salle :

   SELECT p.*, s.* 
   FROM produit p 
   INNER JOIN salle s ON p.id_salle = s.id_salle 
   WHERE p.id_produit = ?

   3. Vérifier si le produit existe, sinon rediriger
   4. Calculer le prix TTC (prix HT + 20% TVA)
   5. Récupérer les avis pour cette salle depuis la table avis
   6. Vérifier si l'utilisateur connecté a déjà laissé un avis pour cette salle
*/

// Exemple de données (à remplacer par vraies données)
require "../config/database.php";

// if (isset($_GET["id_produit"]) && is_numeric($_GET["id_produit"])) {
//     $id = (int) $_GET["id_produit"];
//     $salle_details = get_prod_by_id($db, $id);
// }
// else {
//     die("ID de produit invalide.");
// }



// $id_produit = isset($_GET['id_produit']) ? intval($_GET['id_produit']) : 0;
if (isset($_GET["id_produit"]) && is_numeric($_GET["id_produit"])) {
    $id = (int) $_GET["id_produit"];
    $salle_details = get_prod_by_id($db, $id);
}
echo $id;
// $prix_ht = 550;
// $prix_ttc = $prix_ht * 1.20; // +20% TVA
