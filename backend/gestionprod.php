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

// ===== RÉCUPÉRATION DES SALLES POUR LE FORMULAIRE =====
// $stmtSalles = $pdo->query("SELECT id_salle, titre, ville FROM salle ORDER BY ville, titre");
// $salles = $stmtSalles->fetchAll();

// Données de démonstration des salles
$salles = [
    ['id_salle' => 1, 'titre' => 'Salle Cézanne', 'ville' => 'Paris'],
    ['id_salle' => 2, 'titre' => 'Salle Mozart', 'ville' => 'Lyon'],
    ['id_salle' => 3, 'titre' => 'Salle Picasso', 'ville' => 'Marseille'],
    ['id_salle' => 4, 'titre' => 'Salle Debussy', 'ville' => 'Paris'],
    ['id_salle' => 5, 'titre' => 'Salle Matisse', 'ville' => 'Lyon'],
];

// ===== TRAITEMENT AJOUT PRODUIT =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $dateArrivee = $_POST['date_arrivee'];
    $dateDepart = $_POST['date_depart'];
    $idSalle = (int) $_POST['id_salle'];
    $prix = (int) $_POST['prix'];
    $idPromo = !empty($_POST['id_promo']) ? (int) $_POST['id_promo'] : NULL;

    // Validations
    if (empty($dateArrivee) || empty($dateDepart) || empty($idSalle) || empty($prix)) {
        $message = "Tous les champs marqués d'un astérisque (*) sont obligatoires.";
        $messageType = 'error';
    } elseif (strtotime($dateArrivee) < strtotime(date('Y-m-d'))) {
        $message = "La date d'arrivée doit être supérieure ou égale à la date du jour.";
        $messageType = 'error';
    } elseif (strtotime($dateDepart) <= strtotime($dateArrivee)) {
        $message = "La date de départ doit être supérieure à la date d'arrivée.";
        $messageType = 'error';
    } elseif ($prix <= 0) {
        $message = "Le prix doit être supérieur à 0.";
        $messageType = 'error';
    } else {
        // Vérifier si la salle n'est pas déjà réservée sur ces dates
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM produit 
            WHERE id_salle = ? 
            AND etat = 0
            AND (
                (date_arrivee <= ? AND date_depart >= ?) OR
                (date_arrivee <= ? AND date_depart >= ?) OR
                (date_arrivee >= ? AND date_depart <= ?)
            )
        ");
        $stmt->execute([$idSalle, $dateArrivee, $dateArrivee, $dateDepart, $dateDepart, $dateArrivee, $dateDepart]);
        $conflit = $stmt->fetchColumn() > 0;

        if ($conflit) {
            $message = "Cette salle est déjà réservable sur des dates qui se chevauchent.";
            $messageType = 'error';
        } else {
        // Insérer le produit
        $stmt = $pdo->prepare("INSERT INTO produit (date_arrivee, date_depart, id_salle, prix, id_promo, etat) 
                               VALUES (?, ?, ?, ?, ?, 0)");
        if ($stmt->execute([$dateArrivee, $dateDepart, $idSalle, $prix, $idPromo])) {
            $message = "Produit ajouté avec succès !";
            $messageType = 'success';
        } else {
            $message = "Erreur lors de l'ajout du produit.";
            $messageType = 'error';
        }

        // Pour la démo
        // $message = "Produit ajouté avec succès ! La salle est maintenant réservable sur ces dates.";
        // $messageType = 'success';
        }
    }
}

// ===== TRAITEMENT MODIFICATION PRODUIT =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $idProduit = (int) $_POST['id_produit'];
    $dateArrivee = $_POST['date_arrivee'];
    $dateDepart = $_POST['date_depart'];
    $idSalle = (int) $_POST['id_salle'];
    $prix = (int) $_POST['prix'];
    $idPromo = !empty($_POST['id_promo']) ? (int) $_POST['id_promo'] : NULL;

    // Mêmes validations que pour l'ajout
    if (strtotime($dateArrivee) < strtotime(date('Y-m-d'))) {
        $message = "La date d'arrivée doit être supérieure ou égale à la date du jour.";
        $messageType = 'error';
    } elseif (strtotime($dateDepart) <= strtotime($dateArrivee)) {
        $message = "La date de départ doit être supérieure à la date d'arrivée.";
        $messageType = 'error';
    } else {
        $stmt = $pdo->prepare("UPDATE produit SET date_arrivee = ?, date_depart = ?, id_salle = ?, prix = ?, id_promotion = ? 
                               WHERE id_produit = ?");
        if ($stmt->execute([$dateArrivee, $dateDepart, $idSalle, $prix, $idPromo, $idProduit])) {
            $message = "Produit modifié avec succès !";
            $messageType = 'success';
        }

        $message = "Produit modifié avec succès !";
        $messageType = 'success';
    }
}

// ===== TRAITEMENT SUPPRESSION PRODUIT =====
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idProduit = (int) $_GET['id'];

    // Vérifier si le produit est dans des commandes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM details_commande WHERE id_produit = ?");
    $stmt->execute([$idProduit]);
    $hasCommandes = $stmt->fetchColumn() > 0;

    if ($hasCommandes) {
        $message = "Impossible de supprimer ce produit car il est associé à des commandes.";
        $messageType = 'error';
    } else {
    $stmt = $pdo->prepare("DELETE FROM produit WHERE id_produit = ?");
    if ($stmt->execute([$idProduit])) {
        $message = "Produit supprimé avec succès !";
        $messageType = 'success';
    }

    $message = "Produit supprimé avec succès !";
    $messageType = 'success';
    }
}

// ===== RÉCUPÉRATION DES PRODUITS =====
$orderBy = 'id_produit DESC';
$orderField = '';
$orderDir = 'ASC';

// Gestion du tri
if (isset($_GET['order'])) {
    $orderField = $_GET['order'];
    $orderDir = isset($_GET['dir']) && $_GET['dir'] === 'DESC' ? 'DESC' : 'ASC';

    if (in_array($orderField, ['date_arrivee', 'date_depart', 'prix'])) {
        $orderBy = "$orderField $orderDir";
    }
}

// require_once 'config/database.php';
$stmt = $pdo->query("
    SELECT p.*, s.titre, s.ville, s.photo 
    FROM produit p 
    JOIN salle s ON p.id_salle = s.id_salle 
    ORDER BY $orderBy
");
$produits = $stmt->fetchAll();


// Tri côté PHP pour la démo
if ($orderField === 'prix') {
    usort($produits, function ($a, $b) use ($orderDir) {
        return $orderDir === 'ASC' ? $a['prix'] - $b['prix'] : $b['prix'] - $a['prix'];
    });
} elseif ($orderField === 'date_arrivee') {
    usort($produits, function ($a, $b) use ($orderDir) {
        return $orderDir === 'ASC'
            ? strtotime($a['date_arrivee']) - strtotime($b['date_arrivee'])
            : strtotime($b['date_arrivee']) - strtotime($a['date_arrivee']);
    });
} elseif ($orderField === 'date_depart') {
    usort($produits, function ($a, $b) use ($orderDir) {
        return $orderDir === 'ASC'
            ? strtotime($a['date_depart']) - strtotime($b['date_depart'])
            : strtotime($b['date_depart']) - strtotime($a['date_depart']);
    });
}

// Statistiques
$totalProduits = count($produits);
$totalDisponibles = count(array_filter($produits, function ($p) {
    return $p['etat'] == 0; }));
$totalReserves = $totalProduits - $totalDisponibles;

// Mode édition
$editMode = false;
$produitToEdit = null;
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $editMode = true;
    $idEdit = (int) $_GET['id'];
    foreach ($produits as $produit) {
        if ($produit['id_produit'] == $idEdit) {
            $produitToEdit = $produit;
            break;
        }
    }
}

