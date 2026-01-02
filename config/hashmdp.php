<?php
require_once "database.php";
// 2. Récupérer tous les membres
$stmt = $pdo->query("SELECT id_membre, mdp FROM membre");
$membres = $stmt->fetchAll();

echo "Début du hachage de " . count($membres) . " mots de passe...<br><br>";

// 3. Boucler et mettre à jour
$updateStmt = $pdo->prepare("UPDATE membre SET mdp = ? WHERE id_membre = ?");

foreach ($membres as $membre) {
    $id = $membre['id_membre'];
    $mdpClair = $membre['mdp'];

    // On vérifie si le mot de passe n'est pas déjà un hash (60 caractères pour BCRYPT)
    // Cela évite de re-hasher un hash si vous lancez le script deux fois.
    if (strlen($mdpClair) >= 60 && strpos($mdpClair, '$2y$') === 0) {
        echo "ID $id : Déjà haché, ignoré.<br>";
        continue;
    }

    // Hachage du mot de passe
    $mdpHashe = password_hash($mdpClair, PASSWORD_BCRYPT);

    // Mise à jour
    $updateStmt->execute([$mdpHashe, $id]);
    echo "ID $id : Succès (Ancien: $mdpClair -> Nouveau: " . substr($mdpHashe, 0, 15) . "...)<br>";
}

echo "<br>Terminé ! Tous les mots de passe sont maintenant sécurisés.";

