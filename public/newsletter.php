<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="shortcut icon" href="assets/images/logo.ico">
    <title>LOKISALLE - Newsletter</title>
</head>

<body>
    <?php
    session_start();

    // Vérifier si l'utilisateur est connecté
    $isConnected = isset($_SESSION['id_membre']);
    $isSubscribed = false;
    $message = '';

    if ($isConnected) {
        // Connexion à la base de données
        // require_once 'config/database.php';
    
        // Vérifier si déjà abonné
        // $stmt = $pdo->prepare("SELECT * FROM newsletter WHERE id_membre = ?");
        // $stmt->execute([$_SESSION['id_membre']]);
        // $isSubscribed = $stmt->rowCount() > 0;
    
        // Traitement de l'inscription
        if (isset($_POST['subscribe']) && !$isSubscribed) {
            // Insérer dans la table newsletter
            // $stmt = $pdo->prepare("INSERT INTO newsletter (id_membre) VALUES (?)");
            // if ($stmt->execute([$_SESSION['id_membre']])) {
            //     $message = 'success';
            //     $isSubscribed = true;
            // }
    
            // Pour la démo
            $message = 'success';
            $isSubscribed = true;
        }

        // Traitement de la désinscription
        if (isset($_POST['unsubscribe']) && $isSubscribed) {
            // Supprimer de la table newsletter
            // $stmt = $pdo->prepare("DELETE FROM newsletter WHERE id_membre = ?");
            // if ($stmt->execute([$_SESSION['id_membre']])) {
            //     $message = 'unsubscribed';
            //     $isSubscribed = false;
            // }
        }
    }
    ?>

    <header class="header">
        <div class="logo"></div>
        <h1>LOKISALLE</h1>
        <div class="typewriter">
            <span class="text">Lokisalle — L'espace parfait, au bon moment.</span>
        </div>
    </header>

    <nav class="menu">
        <a href='index.php'>Accueil</a>
        <a href='reservation.php'>Réservation</a>
        <a href='recherche.php'>Recherche</a>
        <?php if ($isConnected): ?>
            <a href='profil.php'>Mon Profil</a>
            <a href='panier.php'>Panier</a>
            <a href='#'>Se déconnecter</a>
        <?php else: ?>
            <a href='connexion.php'>Connexion</a>
            <a href='inscription.php'>Inscription</a>
        <?php endif; ?>
    </nav>

    <main class="container newsletter-container">
        <h2>Newsletter LOKISALLE</h2>

        <?php if (!$isConnected): ?>
            <!-- Message pour les visiteurs non connectés -->
            <div class="warning-box">
                <strong>⚠️ Attention :</strong> Vous devez être membre de LOKISALLE pour vous abonner à notre newsletter.
            </div>
            <p>La newsletter est un service exclusif réservé à nos membres.</p>
            <p>
                <a href="inscription.php" class="btn-subscribe">Créer un compte</a>
                ou
                <a href="connexion.php" style="color: #1abc9c; font-weight: bold;">Se connecter</a>
            </p>

        <?php elseif ($message === 'success'): ?>
            <!-- Message de confirmation d'inscription -->
            <div class="success-box">
                <strong>✓ Félicitations !</strong> Vous êtes maintenant abonné(e) à notre newsletter.
            </div>
            <div class="newsletter-box">
                <div class="newsletter-icon">📧</div>
                <h3>Bienvenue parmi nos abonnés !</h3>
                <p>Vous recevrez désormais toutes nos actualités, offres exclusives et promotions directement dans votre
                    boîte mail.</p>
            </div>
            <form method="POST" style="margin-top: 20px;">
                <button type="submit" name="unsubscribe"
                    style="background: #e74c3c; padding: 10px 25px; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Se désabonner
                </button>
            </form>

        <?php elseif ($message === 'unsubscribed'): ?>
            <!-- Message de désinscription -->
            <div class="warning-box">
                Vous avez été désabonné(e) de notre newsletter. Vous ne recevrez plus nos communications.
            </div>
            <p>Vous pouvez vous réabonner à tout moment en revenant sur cette page.</p>

        <?php elseif ($isSubscribed): ?>
            <!-- Déjà abonné -->
            <div class="success-box">
                <strong>✓ Vous êtes déjà abonné(e)</strong> à notre newsletter.
            </div>
            <div class="newsletter-box">
                <div class="newsletter-icon">📬</div>
                <h3>Merci pour votre fidélité !</h3>
                <p>Vous recevez déjà nos actualités et promotions exclusives.</p>
            </div>
            <form method="POST" style="margin-top: 20px;">
                <button type="submit" name="unsubscribe"
                    style="background: #e74c3c; padding: 10px 25px; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Se désabonner
                </button>
            </form>

        <?php else: ?>
            <!-- Formulaire d'inscription pour membre non abonné -->
            <div class="newsletter-box">
                <div class="newsletter-icon">📬</div>
                <h3>Restez informé(e) de nos actualités !</h3>
                <p>Abonnez-vous à notre newsletter et ne manquez aucune de nos offres exclusives.</p>
            </div>

            <div class="newsletter-benefits">
                <h3>Les avantages de notre newsletter :</h3>
                <ul>
                    <li>Recevez en avant-première nos nouvelles offres de salles</li>
                    <li>Bénéficiez de promotions et codes promo exclusifs</li>
                    <li>Découvrez nos conseils pour organiser vos événements</li>
                    <li>Soyez informé(e) de l'ouverture de nouvelles salles</li>
                    <li>Accédez à des tarifs préférentiels réservés aux abonnés</li>
                </ul>
            </div>

            <form method="POST">
                <button type="submit" name="subscribe" class="btn-subscribe">
                    ✉️ S'abonner à la newsletter
                </button>
            </form>

            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                Vous pourrez vous désabonner à tout moment en un clic.
            </p>
        <?php endif; ?>

        <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            <h3>Fréquence d'envoi</h3>
            <p>Notre newsletter est envoyée 2 à 4 fois par mois, selon l'actualité de LOKISALLE.</p>
            <p style="font-size: 14px; color: #666;">
                Vos données sont protégées et ne seront jamais communiquées à des tiers.
                Conformément au RGPD, vous disposez d'un droit d'accès et de modification de vos informations.
            </p>
        </div>
    </main>

    <footer class="footer">
        <p>© LOKISALLE | </p>
        <nav>
            <a href="mentions.php">Mentions légales</a> |
            <a href="cgv.php">CGV</a> |
            <a href="plan.php">Plan du site</a> |
            <a href="#" onclick="window.print()">Imprimer</a>
        </nav>
    </footer>
</body>

</html>