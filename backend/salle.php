<?php
require "../config/database.php";
function create_offer_salle(
    string $photo,
    string $info_title,
    string $infoville,
    string $info_description,
    string $info_date_depart,
    string $info_date_arrivee,
    int $info_capacity,
    float $info_price,
    int $info_id
) {

    $title = "$info_title - $infoville";
    $date_depart = explode(" ", $info_date_depart)[0];
    $date_arrivee = explode(" ", $info_date_depart)[0];
    $date_salle = "Du $date_depart au $date_arrivee";
    return <<<HTML
        <article class="offre-card">
            <img src="assets/images/{$photo}" alt="{$info_title}">

            <div class="offre-content">
                <h4>{$info_title}</h4>
                <p class="description-tronquee">{$info_description}</p>
                <p><strong>Date :</strong> {$date_salle}</p>
                <p><strong>Capacité :</strong> {$info_capacity} personnes</p>
                <p><strong>Prix :</strong> {$info_price} €</p>

                <div class="offre-actions">
                    <a href="reservation_details.php?id_produit={$info_id}">Voir détails</a>
                    <a href="connexion.php">Se connecter</a>
                </div>
            </div>
        </article>
    HTML;
}
function get_salles(?int $limit = null): string
{
    global $db;
    $products = get_latest_products_per_room($db, $limit);
    $html = "";
    foreach ($products as $product) {
        $html .= create_offer_salle(
            $product['photo'],
            $product['titre'],
            $product['ville'],
            $product['description'],
            $product['date_depart'],
            $product['date_arrivee'],
            $product['capacite'],
            $product['prix'],
            $product['id_produit']
        );
    }
    return $html;
}
function last_three_offers(): string
{
    $limit = 3;
    return get_salles($limit);
}
?>