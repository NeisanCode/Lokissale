<?php
function get_data_from_database(): array
{
    $user = "root";
    $pass = "";
    try {

        $db = new PDO("mysql:host=localhost:3306;dbname=lokissale", $user, $pass);
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
                    ORDER BY p.date_depart DESC
                    LIMIT 3;
                    "
        ;
        $req = $db->query($sql_command);
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        return $res;

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return [];
    }
}

?>