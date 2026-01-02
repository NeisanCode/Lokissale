<?php require_once 'database.php';

function getAvaibleRoom($date_arrivee, $date_depart)
{
    global $pdo;
    $sql = "SELECT p.id_produit, s.titre, s.description, s.capacite, s.photo, s.ville, p.prix
                FROM produit p
                JOIN salle s ON p.id_salle = s.id_salle
                WHERE p.etat = 0
                  AND NOT (p.date_depart < :date_arrivee OR p.date_arrivee > :date_depart)
                ORDER BY s.titre ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'date_arrivee' => $date_arrivee,
        'date_depart' => $date_depart
    ]);
    $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $stmt;
}

?>