<?php
require_once '../config/database.php';
require_once 'session.php';

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    header('Location: index.php');
    exit();
}


$message = '';
$messageType = '';

// ===== TRAITEMENT AJOUT CODE PROMO =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $codePromo = strtoupper(trim($_POST['code_promo']));
    $reduction = (int) $_POST['reduction'];

    // Validations
    if (empty($codePromo)) {
        $message = "Le code promo est obligatoire.";
        $messageType = 'error';
    } elseif (strlen($codePromo) > 6) {
        $message = "Le code promo ne peut pas dépasser 6 caractères.";
        $messageType = 'error';
    } elseif ($reduction <= 0 || $reduction > 100) {
        $message = "La réduction doit être comprise entre 1 et 100%.";
        $messageType = 'error';
    } else {
        // Vérifier si le code existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM promotion WHERE code_promo = ?");
        $stmt->execute([$codePromo]);
        $existe = $stmt->fetchColumn() > 0;

        if ($existe) {
            $message = "Ce code promo existe déjà.";
            $messageType = 'error';
        } else {
            // Insérer le code promo
            $stmt = $pdo->prepare("INSERT INTO promotion (code_promo, reduction) VALUES (?, ?)");
            if ($stmt->execute([$codePromo, $reduction])) {
                $message = "Code promo créé avec succès !";
                $messageType = 'success';
            } else {
                $message = "Erreur lors de la création du code promo.";
                $messageType = 'error';
            }

            // Pour la démo
            // $message = "Code promo « $codePromo » créé avec succès ! Réduction de $reduction% applicable.";
//    $messageType = 'success';
            // }
        }
    }


}
// ===== TRAITEMENT SUPPRESSION CODE PROMO =====
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {

    $idPromo = (int) $_GET['id'];

    // Vérifier si le code promo est utilisé dans des produits
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produit WHERE id_promotion = ?");
    $stmt->execute([$idPromo]);
    $nbProduits = $stmt->fetchColumn();

    if ($nbProduits > 0) {
        // Mettre à jour les produits associés (retirer le code promo)
        $pdo->prepare("UPDATE produit SET id_promotion = NULL WHERE id_promotion = ?")->execute([$idPromo]);
    }

    // Supprimer le code promo
    $stmt = $pdo->prepare("DELETE FROM promotion WHERE id_promotion = ?");
    if ($stmt->execute([$idPromo])) {
        $message = "Code promo supprimé avec succès !";
        if ($nbProduits > 0) {
            $message .= " Les produits associés ($nbProduits) ont été mis à jour.";
        }
        $messageType = 'success';
    } else {
        $message = "Erreur lors de la suppression du code promo.";
        $messageType = 'error';
    }
}
// ===== RÉCUPÉRATION DES CODES PROMO =====
$stmt = $pdo->query("
    SELECT p.*, COUNT(pr.id_produit) as nb_produits
    FROM promotion p
    LEFT JOIN produit pr ON p.id_promotion = pr.id_promotion
    GROUP BY p.id_promotion
    ORDER BY p.id_promotion DESC
");
$promos = $stmt->fetchAll();



// Statistiques
$totalPromos = count($promos);
$promosActifs = count(array_filter($promos, function ($p) {
    return $p['nb_produits'] > 0;
}));
$promosInactifs = $totalPromos - $promosActifs;
$reductionMoyenne = $totalPromos > 0 ? array_sum(array_column($promos, 'reduction')) / $totalPromos : 0;


?>