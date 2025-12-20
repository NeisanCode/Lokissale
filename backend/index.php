<?php
require "../config/database.php";
function create_offer_salle(
    string $photo,
    string $info_title,
    string $info_description,
    string $info_date,
    int $info_capacity,
    float $info_price,
    int $info_id
) {
    return <<<HTML
        <article class="offre-card">
            <img src="assets/images/{$photo}" alt="{$info_title}">

            <div class="offre-content">
                <h4>{$info_title}</h4>
                <p>{$info_description}</p>
                <p><strong>Date :</strong> {$info_date}</p>
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
function create_salle_options(array $salles): array
{
    $new_array = [];
    foreach ($salles as $salle) {
        $title = $salle['titre'] . " - " . $salle['ville'];
        $date_depart = explode(" ", $salle['date_depart'])[0];
        $date_arrivee = explode(" ", $salle['date_arrivee'])[0];
        $date_salle = "Du $date_depart au $date_arrivee";
        $new_array[] = [
            "titre" => $title,
            "description" => $salle['description'],
            "date_salle" => $date_salle,
            "photo" => strtolower($salle['photo']),
            "capacite" => $salle['capacite'],
            "prix" => $salle['prix'],
            "id_produit" => $salle['id_produit']
        ];
    }
    return $new_array;

}
function last_three_offers(): string
{
    $connected_db = get_data_from_database();
    $offers = create_salle_options($connected_db);
    $html = "";
    foreach ($offers as $offer) {
        $html .= create_offer_salle(
            $offer['photo'],
            $offer['titre'],
            $offer['description'],
            $offer['date_salle'],
            $offer['capacite'],
            $offer['prix'],
            $offer['id_produit']
        );
    }
    return $html;

}
?>