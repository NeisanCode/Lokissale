<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_membre'])) {
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
if (isset($_POST['code_promo'])) {
    $codePromo = trim($_POST['code_promo']);
    // Vérifier le code promo dans la base de données
    // Pour la démo, on simule une réduction de 10%
    if ($codePromo === 'PROMO10') {
        $reductionAppliquee = 10;
        $message = "Code promo appliqué ! Vous bénéficiez de 10% de réduction.";
        $messageType = 'success';
    } else {
        $message = "Code promo invalide ou non applicable à ces produits.";
        $messageType = 'error';
    }
}

// Récupérer les produits du panier depuis la base de données
// Pour la démo, on simule des données
$produitsCart = [];
if (!empty($_SESSION['panier'])) {
    // require_once 'config/database.php';
    // $ids = implode(',', $_SESSION['panier']);
    // $stmt = $pdo->query("SELECT p.*, s.titre, s.ville, s.photo 
    //                      FROM produit p 
    //                      JOIN salle s ON p.id_salle = s.id_salle 
    //                      WHERE p.id_produit IN ($ids)");
    // $produitsCart = $stmt->fetchAll();

    // Données de démonstration
    $produitsCart = [
        [
            'id_produit' => 11,
            'titre' => 'Salle Debussy',
            'ville' => 'Paris',
            'date_arrivee' => '2025-06-20',
            'date_depart' => '2025-06-22',
            'prix' => 620,
            'photo' => 'assets/images/debussy.jpg',
            'capacite' => 45
        ]
    ];
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
?>


<!-- <nav class="menu">
        <a href='index.php'>Accueil</a>
        <a href='reservation.php'>Réservation</a>
        <a href='recherche.php'>Recherche</a>
        <a href='profil.php'>Mon Profil</a>
        <a href='panier.php' class='active'>Panier</a>
        <a href='#'>Se déconnecter</a>
    </nav> -->

<main class="panier-container">
    <h2>Mon Panier</h2>

    <?php if ($messageType === 'success'): ?>
        <div
            style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0; color: #155724;">
            <?php echo $message; ?>
        </div>
    <?php elseif ($messageType === 'error'): ?>
        <div class="error-box">
            <?php echo $message; ?>
        </div>
    <?php elseif ($messageType === 'warning'): ?>
        <div class="warning-box">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($produitsCart)): ?>
        <!-- Panier vide -->
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h3>Votre panier est vide</h3>
            <p>Découvrez nos offres et commencez à réserver vos salles !</p>
            <a href="reservation.php" class="btn-pay"
                style="display: inline-block; margin-top: 20px; text-decoration: none;">
                Voir les offres disponibles
            </a>
        </div>
    <?php else: ?>
        <!-- Produits dans le panier -->
        <div class="cart-items">
            <?php foreach ($produitsCart as $produit): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($produit['photo']); ?>"
                        alt="<?php echo htmlspecialchars($produit['titre']); ?>" class="cart-item-image">

                    <div class="cart-item-details">
                        <div class="cart-item-title"><?php echo htmlspecialchars($produit['titre']); ?></div>
                        <div class="cart-item-info">
                            📍 <?php echo htmlspecialchars($produit['ville']); ?>
                        </div>
                        <div class="cart-item-info">
                            📅 Du <?php echo date('d/m/Y', strtotime($produit['date_arrivee'])); ?>
                            au <?php echo date('d/m/Y', strtotime($produit['date_depart'])); ?>
                        </div>
                        <div class="cart-item-info">
                            👥 Capacité : <?php echo $produit['capacite']; ?> personnes
                        </div>
                        <div class="cart-item-price">
                            <?php echo number_format($produit['prix'], 0, ',', ' '); ?> €
                        </div>
                    </div>

                    <a href="?action=remove&id_produit=<?php echo $produit['id_produit']; ?>" class="btn-remove"
                        title="Retirer du panier"
                        onclick="return confirm('Êtes-vous sûr de vouloir retirer ce produit ?');">×</a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Code promo -->
        <form method="POST" class="promo-section <?php echo $reductionAppliquee > 0 ? 'promo-applied' : ''; ?>">
            <strong>🎁 Code promotionnel</strong>
            <?php if ($reductionAppliquee > 0): ?>
                <p style="margin: 10px 0 0 0;">
                    Code "<?php echo htmlspecialchars($codePromo); ?>" appliqué :
                    -<?php echo $reductionAppliquee; ?>%
                    (<?php echo number_format($reduction, 2, ',', ' '); ?> € d'économie)
                </p>
            <?php else: ?>
                <div class="promo-input-group">
                    <input type="text" name="code_promo" placeholder="Entrez votre code promo"
                        value="<?php echo htmlspecialchars($codePromo); ?>">
                    <button type="submit" class="btn-apply-promo">Appliquer</button>
                </div>
            <?php endif; ?>
        </form>

        <!-- Récapitulatif -->
        <div class="cart-summary">
            <h3 style="margin-top: 0;">Récapitulatif</h3>

            <div class="summary-row">
                <span>Sous-total HT :</span>
                <span><?php echo number_format($sousTotal, 2, ',', ' '); ?> €</span>
            </div>

            <?php if ($reduction > 0): ?>
                <div class="summary-row" style="color: #27ae60;">
                    <span>Réduction (<?php echo $reductionAppliquee; ?>%) :</span>
                    <span>-<?php echo number_format($reduction, 2, ',', ' '); ?> €</span>
                </div>
            <?php endif; ?>

            <div class="summary-row">
                <span>TVA (20%) :</span>
                <span><?php echo number_format($tva, 2, ',', ' '); ?> €</span>
            </div>

            <div class="summary-row total">
                <span>Total TTC :</span>
                <span><?php echo number_format($total, 2, ',', ' '); ?> €</span>
            </div>

            <!-- CGV -->
            <div class="cgv-checkbox">
                <input type="checkbox" id="cgv" name="cgv" required>
                <label for="cgv">
                    J'accepte les <a href="cgv.php" target="_blank" style="color: #1abc9c; font-weight: bold;">Conditions
                        Générales de Vente</a> <span style="color: #e74c3c;">*</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="cart-actions">
                <a href="?action=clear" class="btn-action btn-clear"
                    style="text-decoration: none; text-align: center; line-height: 1.5;"
                    onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                    🗑️ Vider le panier
                </a>
                <button type="button" class="btn-action btn-pay" id="btnPay">
                    💳 Procéder au paiement
                </button>
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
    // Validation du paiement
    document.getElementById('btnPay')?.addEventListener('click', function () {
        const cgvCheckbox = document.getElementById('cgv');

        if (!cgvCheckbox.checked) {
            alert('Vous devez accepter les Conditions Générales de Vente pour continuer.');
            return;
        }

        // Ici, traiter le paiement
        // Pour la démo, on simule le paiement
        if (confirm('Confirmer le paiement de <?php echo number_format($total, 2, ',', ' '); ?> € ?')) {
            alert('Paiement effectué avec succès ! Un email de confirmation vous a été envoyé.');
            window.location.href = 'profil.php';
        }
    });
</script>