<?php
$user = "root";
$pass = "";
try {
    $db = new PDO("mysql:host=localhost:3306;dbname=lokissale;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function get_latest_products_per_room(PDO $db, ?int $limit = null): array
{
    $sql_command = "SELECT 
                        *
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER (
                                PARTITION BY id_salle
                                ORDER BY date_depart DESC
                            ) AS rn
                        FROM produit
                    ) p
                    JOIN salle s ON s.id_salle = p.id_salle
                    WHERE p.rn = 1
                    ORDER BY p.date_depart DESC";

    if ($limit !== null && $limit > 0) {
        $sql_command .= " LIMIT " . intval($limit);
    }

    $stmt = $db->query($sql_command);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_prod_details(PDO $db, int $id_produit): array
{
    // Préparer la première requête (produit + salle)
    $produit_details = $db->prepare(
        "SELECT 
            p.prix,
            p.date_depart,
            p.date_arrivee,
            s.*
        FROM produit p
        LEFT JOIN salle s ON p.id_salle = s.id_salle
        WHERE p.id_produit = :id_produit;"
    );


    // Récupérer la première réponse (produit)
    $produit_details->execute([':id_produit' => $id_produit]);
    $produit = $produit_details->fetch(PDO::FETCH_ASSOC);


    // Préparer la deuxième requête (avis)
    $avis_notes = $db->prepare(
        "SELECT 
            a.note AS avis_note,
            a.commentaire,
            a.date AS avis_date,
            m.nom AS membre_nom,
            m.prenom AS membre_prenom
        FROM produit p
        LEFT JOIN salle s ON p.id_salle = s.id_salle
        LEFT JOIN avis a ON a.id_salle = s.id_salle
        LEFT JOIN membre m ON m.id_membre = a.id_membre
        WHERE p.id_produit = :id_produit;"
    );
    $date_proches = $db->prepare(
        "SELECT 
                p2.*,
                s.*,
                ABS(DATEDIFF(p2.date_arrivee, p1.date_arrivee)) as jours_difference
            FROM produit p1
            JOIN salle s1 ON p1.id_salle = s1.id_salle
            JOIN produit p2 ON p2.id_produit != p1.id_produit
            JOIN salle s ON p2.id_salle = s.id_salle
            WHERE p1.id_produit = :id_produit
            AND s.ville = s1.ville
            ORDER BY jours_difference
            LIMIT 3;"
    );

    // Récupérer tous les avis
    $avis_notes->execute([':id_produit' => $id_produit]);
    $avis = $avis_notes->fetchAll(PDO::FETCH_ASSOC);

    // Executer avec le parametre
    $date_proches->execute([':id_produit' => $id_produit]);
    $date_proches = $date_proches->fetchAll(PDO::FETCH_ASSOC);
    // Retourner un tableau combiné
    return [
        'produit' => $produit,
        'avis' => $avis,
        'similar' => $date_proches
    ];

}
?>