<?php
require_once "../config/database.php";
require_once "../backend/salle.php";
require_once "../backend/utils.php";



if (isset($_GET['id_produit']) && is_numeric($_GET['id_produit'])) {
    $id_product = (int) $_GET['id_produit'];
} else {
    echo "Un problème est survenu.";
    die("ID de produit invalide.");
}
[
    "produit" => $product,
    "avis" => $avis,
    "similar" => $offers
] = get_prod_details($db, $id_product);

// ---salle details variables
$title = $product['titre'];
$description = $product['description'];


$photo = strtolower($product['photo']);
$capacite = $product['capacite'];
$cp = $product['cp'];

$ville = $product['ville'];
$adresse = $product['adresse'];
$pays = $product['pays'];

// ---product details variables
$prix = $product['prix'];
$titre_page = "$title - $ville";

$prix_ht = number_format((float) $prix, 2, '.', '');
$prix_ttc = number_format((float) ($prix * 1.2), 2, '.', ''); // TVA à 20%

$date_depart = explode(" ", $product['date_depart'])[0];
$date_arrivee = explode(" ", $product['date_arrivee'])[0];
[$date_arrivee, $date_depart] = [style_date($date_arrivee), style_date($date_depart)];

$date_salle = "Du $date_depart au $date_arrivee";
function get_rate(): string
{
    global $avis;
    if (count($avis) === 0) {
        return <<<HTML
              <article class="avis-item">
            <div class="avis-header">
                <strong class="avis-auteur">Aucun avis disponible</strong>
            </div>
        </article>;
        HTML;
    }

    $html = "";
    foreach ($avis as $a) {
        $star_note = str_repeat("⭐", (int) $a['avis_note']) . " ({$a['avis_note']}/5)";
        $avis_date_formatted = date("d/m/Y", strtotime($a['avis_date']));
        $comment = nl2br(htmlspecialchars($a['commentaire']));
        $fullname = htmlspecialchars($a['membre_prenom'] . " " . $a['membre_nom']);
        $html .= <<<HTML
        <article class="avis-item">
            <div class="avis-header">
                <strong class="avis-auteur">{$fullname}</strong>
                <span class="avis-note">$star_note</span>
                <span class="avis-date">$avis_date_formatted</span>
            </div>
            <p class="avis-commentaire">
                {$comment}
            </p>
        </article>
        HTML;
    }
    return $html;
}

function get_similar_offers(): string
{
    global $offers;
    $html = "";
    foreach ($offers as $offer) {
        $html .= create_offer_salle(
            $offer['photo'],
            $offer['titre'],
            $offer['ville'],
            $offer['description'],
            $offer['date_depart'],
            $offer['date_arrivee'],
            $offer['capacite'],
            $offer['prix'],
            $offer['id_produit']
        );
        ;
    }
    return $html;
}


