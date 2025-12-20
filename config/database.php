<?php
$user = "root";
$pass = "";
try {
    $count = 0;
    $db = new PDO("mysql:host=localhost:3306;dbname=lokissale", $user, $pass);
    $sql_command = "SELECT *
                    FROM produit
                    JOIN salle ON produit.id_salle = salle.id_salle
                    ORDER BY date_depart DESC
                    LIMIT 3;
    ";
    $req = $db->query($sql_command);
    foreach ($req as $row) {
        print_r($row);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}