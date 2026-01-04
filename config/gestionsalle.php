<?php

function add_room(PDO $pdo, $pays, $ville, $adresse, $cp, $titre, $description, $photo, $capacite, $categorie)
{
    $stmt = $pdo->prepare("INSERT INTO salle (
        pays, 
        ville, 
        adresse,
        cp,
        titre,
        description,
        photo,
        capacite,
        categorie
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    "
    );
    $res = $stmt->execute([$pays, $ville, $adresse, $cp, $titre, $description, $photo, $capacite, $categorie]);
    return $res;
}

function get_room(PDO $pdo)
{
    $stmt = $pdo->query("SELECT * FROM salle ORDER BY id_salle DESC");
    return $stmt->fetchAll();
}

function update_room(PDO $pdo, int $id_salle, array $values)
{
    $fields = [];
    foreach ($values as $colonne => $value) {
        $fields[] = "$colonne = ?";
    }
    $sql = "UPDATE salle SET " . implode(',', $fields) . " WHERE id_salle=?";
    print($sql);
    $update_values = array_values($values);
    $update_values[] = $id_salle;

    $tmt = $pdo->prepare($sql);
    return $tmt->execute($update_values);

}

function count_prod(PDO $pdo, int $id_salle)
{
    // Vérifier les dépendances (produits, avis associés)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produit WHERE id_salle = ?");
    $stmt->execute([$id_salle]);
    $produitsCount = $stmt->fetchColumn();
    return $produitsCount;
}

function delete_room(PDO $pdo, int $id_salle)
{
    $pdo->prepare("DELETE FROM avis WHERE id_salle = ?")->execute([$id_salle]);
    // Supprimer la salle
    $stmt = $pdo->prepare("DELETE FROM salle WHERE id_salle = ?");
    $res = $stmt->execute([$id_salle]);
    return $res;
}

function get_photo(PDO $pdo, int $id_salle)
{
    $tmt = $pdo->prepare("SELECT photo FROM salle WHERE id_salle=?");
    $tmt->execute([$id_salle]);
    $photo = $tmt->fetch();
    return $photo["photo"];
}
