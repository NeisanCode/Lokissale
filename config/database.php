<?php
$user = "root";
$pass = "";
try {
    $db = new PDO("mysql:host=localhost:3306;dbname=lokissale;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function get_data_from_database(PDO $db, ?int $limit = null): array
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

function get_prod_by_id(PDO $db, int $id_product): array{
    $stmt = $db->prepare(
        "SELECT * FROM produit AS p
                JOIN salle AS s ON p.id_produit = s.id_salle
                WHERE p.id_produit = :id_produit;"
    );
    $stmt->execute(['id_produit' => $id_product]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>