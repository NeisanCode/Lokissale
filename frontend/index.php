<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOKISALLE - Accueil</title>
    <link rel="stylesheet" href='assets/css/style.css'>
</head>

<body>

    <header>
        <div class="container">
            <div id="logo">
                <h1>LOKISALLE</h1>
                <p>Location de salles pour vos réunions professionnelles et privées</p>
            </div>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php" class="active">Accueil</a></li>
                <li><a href="reservation.php">Réservation</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <li class="auth-links">
                    <a href="connexion.php">Se connecter</a> |
                    <a href="inscription.php">Créer un compte</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <p class="breadcrumb">>> Accueil</p>

        <section class="presentation">
            <h2>Bienvenue chez LOKISALLE</h2>
            <p>
                Spécialiste de la location de salles à Paris, Lyon et Marseille, LOKISALLE
                propose des espaces adaptés à tous vos événements : séminaires, réunions
                d'entreprises ou réceptions privées. Profitez de nos infrastructures
                modernes et modulables pour garantir le succès de vos projets.
            </p>
        </section>

        <section class="offres">
            <h3>Nos 3 dernières offres</h3>
            <div class="grid-offres">

                <article class="card">
                    <img src="assets/images/salle1.jpg" alt="Salle Paris">
                    <div class="card-content">
                        <h4>Salle Cézanne - PARIS</h4>
                        <p>Du 06/12/2025 au 10/12/2025</p>
                        <p class="price">398 € pour 25 personnes</p>
                        <a href="reservation_details.php?id_produit=1" class="btn">Voir la fiche détaillée</a>
                        <a href="connexion.php" class="link-cart">> Connectez-vous pour l'ajouter au panier</a>
                    </div>
                </article>

                <article class="card">
                    <img src="assets/images/salle2.jpg" alt="Salle Lyon">
                    <div class="card-content">
                        <h4>Salle Mozart - LYON</h4>
                        <p>Du 13/12/2025 au 17/12/2025</p>
                        <p class="price">317 € pour 20 personnes</p>
                        <a href="reservation_details.php?id_produit=2" class="btn">Voir la fiche détaillée</a>
                        <a href="connexion.php" class="link-cart">> Connectez-vous pour l'ajouter au panier</a>
                    </div>
                </article>

                <article class="card">
                    <img src="assets/images/salle3.jpg" alt="Salle Marseille">
                    <div class="card-content">
                        <h4>Salle Lumière - MARSEILLE</h4>
                        <p>Du 20/12/2025 au 23/12/2025</p>
                        <p class="price">225 € pour 20 personnes</p>
                        <a href="reservation_details.php?id_produit=3" class="btn">Voir la fiche détaillée</a>
                        <a href="connexion.php" class="link-cart">> Connectez-vous pour l'ajouter au panier</a>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-links">
                <a href="mentions.php">Mentions légales</a> |
                <a href="cgv.php">C.G.V</a> |
                <a href="plan.php">Plan du site</a> |
                <a href="#" onclick="window.print()">Imprimer la page</a>
            </div>
            <div class="footer-contact">
                <a href="newsletter.php">S'inscrire à la newsletter</a> |
                <a href="contact.php">Contact</a>
            </div>
            <p>&copy; 2025 LOKISALLE - Projet L2IG1-ESGAE</p>
        </div>
    </footer>

</body>

</html>