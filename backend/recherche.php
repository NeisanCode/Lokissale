<?php
require "../config/database.php";
require "../config/recherche.php";


$date_arrivee = $_GET['date_arrivee'] ?? null;
$date_depart = $_GET['date_depart'] ?? null;
$nom_salle = $_GET["titre"];

$salles = [];
$message = '';
$message_type = '';

if ($date_arrivee && $date_depart) {

    // Validation des dates
    if ($date_depart < $date_arrivee) {
        $message = "La date de départ doit être postérieure à la date d'arrivée.";
        $message_type = 'error';
    } else {
        // Requête pour trouver les salles disponibles
        $salles = getAvaibleRoom($pdo, $date_arrivee, $date_depart);
        $message = "Listes des salles trouvées";
        $message_type = 'success';
        if (count($salles) === 0) {
            $message = "Aucune salle disponible pour ces dates.";
            $message_type = 'info';
        }
    }
} elseif ($nom_salle) {
    $tmt = $pdo->query("SELECT * FROM produit p JOIN salle s ON p.id_salle = s.id_salle");
    $all_salles = $tmt->fetchAll(PDO::FETCH_ASSOC);

    $titres = array_column($all_salles, "titre");
    $is_exist = array_search($nom_salle, $titres);

    if (!empty($is_exist)) {
        $salles = [$all_salles[$is_exist]];
        $message = "Listes des salles trouvées";
        $message_type = 'success';
    } elseif ($is_exist === 0) {
        $salles = [$all_salles[0]];
        $message = "Listes des salles trouvées";
        $message_type = 'success';
    } else {
        $message = "La salle <strong>$nom_salle</strong> n'existe pas veuillez réesayer de changer de nom";
        $message_type = 'error';
    }

} else {
    $message = "Veuillez sélectionner des dates pour rechercher des salles disponibles.";
    $message_type = 'info';
}
?>