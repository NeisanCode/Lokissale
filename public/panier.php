<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require '../backend/panier.php';
?>
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
                style="display: inline-block; margin-top: 20px; text-decoration: none; color:white;">
                Voir les offres disponibles
            </a>
        </div>
    <?php else: ?>
        <!-- Produits dans le panier -->
        <div class="cart-items">
            <?php foreach ($produitsCart as $produit): ?>
                <div class="cart-item">
                    <img src="assets/images/<?php echo htmlspecialchars($produit['photo']); ?>"
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
<?php require "inc/bas.inc.php" ?>