<?php
require_once "session.php";
require_once '../config/database.php';


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["membre"]['id_membre'])) {
    // Rediriger vers la page de connexion
    echo '<script>
            alert("Vous devez vous connecter avant d\'accéder à votre panier.");
            window.location.href = "connexion.php";
        </script>';
    exit();
}

// Initialiser le panier dans la session si inexistant
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Traitement des actions
$message = '';
$messageType = '';

// Ajouter un produit au panier
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id_produit'])) {
    $idProduit = (int) $_GET['id_produit'];

    // Vérifier si le produit est déjà dans le panier
    if (in_array($idProduit, $_SESSION['panier'])) {
        $message = "Ce produit est déjà dans votre panier.";
        $messageType = 'error';
    } else {
        $_SESSION['panier'][] = $idProduit;
        $message = "Produit ajouté au panier avec succès !";
        $messageType = 'success';
    }
}

// Retirer un produit du panier
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id_produit'])) {
    $idProduit = (int) $_GET['id_produit'];
    $key = array_search($idProduit, $_SESSION['panier']);
    if ($key !== false) {
        unset($_SESSION['panier'][$key]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer
    }
}

// Vider le panier
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['panier'] = [];
    $message = "Votre panier a été vidé.";
    $messageType = 'warning';
}

// Appliquer un code promo
$codePromo = '';
$reductionAppliquee = 0;

if (!empty($_POST['code_promo'])) {
    $codePromo = trim($_POST['code_promo']);

    $stmt = $pdo->prepare("-- sql
        SELECT reduction
        FROM promotion
        WHERE code_promo = :code
    ");

    $stmt->execute([
        ':code' => $codePromo
    ]);

    $promo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($promo) {
        $reductionAppliquee = (int) $promo['reduction'];
        $message = "Code promo appliqué ! Vous bénéficiez de {$reductionAppliquee}% de réduction.";
        $messageType = 'success';
    } else {
        $message = "Code promo invalide ou expiré.";
        $messageType = 'error';
    }

}

// Récupérer les produits du panier depuis la base de données
$produitsCart = [];
if (!empty($_SESSION['panier'])) {

    $ids = implode(',', $_SESSION['panier']);
    $stmt = $pdo->query("SELECT p.*, s.titre, s.ville, s.photo , s.capacite
                         FROM produit p 
                         JOIN salle s ON p.id_salle = s.id_salle 
                         WHERE p.id_produit IN ($ids)");
    $produitsCart = $stmt->fetchAll();
}

// Calculer les totaux
$sousTotal = 0;
foreach ($produitsCart as $produit) {
    $sousTotal += $produit['prix'];
}
$reduction = ($sousTotal * $reductionAppliquee) / 100;
$sousTotal -= $reduction;
$tva = $sousTotal * 0.20;
$total = $sousTotal + $tva;

if (isset($_POST['pay'])) {
    $current_date = date('Y-m-d H:i:s');
    $membre_id = $_SESSION["membre"]["id_membre"];
    $commande = "INSERT INTO commande (id_membre, montant, `date`) VALUES (?, ?, ?) ";

    $tmt = $pdo->prepare($commande);
    foreach ($produitsCart as $prodcart) {
        $tmt->execute([$membre_id, $prodcart["prix"], $current_date]);
    }
    header("Location: profil.php");
    exit();
}
?>