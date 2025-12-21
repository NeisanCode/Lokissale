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

function get_product_details(PDO $db, int $id_product): array
{
    $stmt = $db->prepare(
        "SELECT 
                p.prix,
                p.date_depart,
                p.date_arrivee,
                s.*,
                a.note,
                a.commentaire,
                a.date,
                m.nom,
                m.prenom
                FROM produit p
                LEFT JOIN salle s ON p.id_salle = s.id_salle
                LEFT JOIN avis a ON a.id_salle = s.id_salle
                LEFT JOIN membre m ON m.id_membre = a.id_membre
                WHERE id_produit = :id_produit;
            "
    );
    $stmt->execute(['id_produit' => $id_product]);
    $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt === false) {
        die("Produit non trouvé.");
    }
    return $stmt;
}

print_r(get_product_details($db, 1));
