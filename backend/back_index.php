<?php
$host = "localhost:3306";
$dbname = "lokissale";
$user = "lokissale";
$password = "lokissale";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // --- CODE POUR AFFICHER LE RÉSULTAT ---

    // 1. On lance la requête
    $requete = $pdo->query("SELECT * FROM salle");

    // 2. On boucle sur chaque ligne trouvée
    while ($ligne = $requete->fetch()) {
        // 3. On affiche la colonne souhaitée avec echo
        echo "Donnée : " . $ligne['titre'] . "\n";
    }

    // --------------------------------------

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$salles = [
    //traitement
];


$salles = [
    $salle1 => [$nom => "", $prix => "", $capacité => "", $description => ""],
    $salle2 => [$nom => "", $prix => "", $capacité => "", $description => ""],
    $salle3 => [$nom => "", $prix => "", $capacité => "", $description => ""],
    $salle4 => [$nom => "", $prix => "", $capacité => "", $description => ""],
]



    ?>