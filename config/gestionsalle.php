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

function update_room(PDO $pdo, int $id_salle, string $name): bool
{
    $stmt = $pdo->prepare(
        "UPDATE salle SET name = :name WHERE id_salle = :id"
    );
    return $stmt->execute([
        'name' => $name,
        'id' => $id_salle
    ]);
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


