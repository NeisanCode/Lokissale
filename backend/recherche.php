<?php
require "../config/database.php";
require "../config/recherche.php";


$date_arrivee = $_GET['date_arrivee'] ?? null;
$date_depart = $_GET['date_depart'] ?? null;

$salles = [];
$message = '';
$message_type = ''; // 'error' ou 'info'

if ($date_arrivee && $date_depart) {
    // Validation des dates
    if ($date_depart < $date_arrivee) {
        $message = "La date de départ doit être postérieure à la date d'arrivée.";
        $message_type = 'error';
    } else {
        // Requête pour trouver les salles disponibles
        $salles = getAvaibleRoom($pdo, $date_arrivee, $date_depart);
        if (count($salles) === 0) {
            $message = "Aucune salle disponible pour ces dates.";
            $message_type = 'info';
        }
    }
} else {
    $message = "Veuillez sélectionner des dates pour rechercher des salles disponibles.";
    $message_type = 'info';
}
?>