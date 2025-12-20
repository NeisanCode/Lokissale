<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container-large">
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Bienvenue sur LOKISALLE</h2>

        <p>
            LOKISALLE est spécialisée dans la location de salles pour réunions,
            séminaires, formations et événements professionnels ou privés.
        </p>

        <p>
            Présente à Paris, Lyon et Marseille, notre plateforme vous permet
            de réserver facilement des salles modernes et entièrement équipées.
        </p>
    </section>

    <!-- Offres -->
    <section class="offres">
        <h>Nos 3 dernières offres</h>

        <div class="offres-grid">

            <article class="offre-card">
                <img src="assets/images/salle1.jpg" alt="Salle Cézanne Paris">

                <div class="offre-content">
                    <h4>Salle Cézanne – Paris</h4>
                    <p>Salle moderne idéale pour réunions professionnelles.</p>
                    <p><strong>Date :</strong> </p>
                    <p><strong>Capacité :</strong> 20 personnes</p>
                    <p><strong>Prix :</strong> 550 €</p>

                    <div class="offre-actions">
                        <a href="reservation_details.php?id_produit=1">Voir détails</a>
                        <a href="connexion.php">Se connecter</a>
                    </div>
                </div>
            </article>

            <article class="offre-card">
                <img src="assets/images/salle2.jpg" alt="Salle Mozart Lyon">

                <div class="offre-content">
                    <h4>Salle Mozart – Lyon</h4>
                    <p>Salle spacieuse pour formations et séminaires.</p>
                    <p><strong>Date :</strong> </p>
                    <p><strong>Capacité :</strong> 30 personnes</p>
                    <p><strong>Prix :</strong> 620 €</p>

                    <div class="offre-actions">
                        <a href="reservation_details.php?id_produit=2">Voir détails</a>
                        <a href="connexion.php">Se connecter</a>
                    </div>
                </div>
            </article>

            <article class="offre-card">
                <img src="assets/images/salle3.jpg" alt="Salle Picasso Marseille">

                <div class="offre-content">
                    <h4>Salle Picasso – Marseille</h4>
                    <p>Salle élégante pour événements d’entreprise.</p>
                    <p><strong>Date :</strong> </p>
                    <p><strong>Capacité :</strong> 15 personnes</p>
                    <p><strong>Prix :</strong> 450 €</p>

                    <div class="offre-actions">
                        <a href="reservation_details.php?id_produit=3">Voir détails</a>
                        <a href="connexion.php">Se connecter</a>
                    </div>
                </div>
            </article>

        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>