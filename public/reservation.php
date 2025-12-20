<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php require "../backend/salle.php" ?>

<main class="container-large">
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Nos offres de location de salles</h2>
        <p>Découvrez toutes nos salles disponibles à la réservation pour vos événements professionnels et privés.</p>
    </section>

    <!-- Affichage des offres -->
    <section class="offres" style="margin-top:40px;">
        <h3>Salles disponibles</h3>
        <?php
        /* 🔹 TRAITEMENT PHP À FAIRE
           Récupérer tous les produits disponibles :
           - date_arrivee >= date du jour
           - etat = 0 (réservable)
           - Jointure entre les tables produits et salles
           - Requête SQL :

           SELECT p.*, s.* 
           FROM produit p 
           INNER JOIN salle s ON p.id_salle = s.id_salle 
           WHERE p.date_arrivee >= CURDATE() 
           AND p.etat = 0 
           ORDER BY p.date_arrivee ASC

           Puis boucle pour afficher chaque produit
        */

        // SI AUCUN PRODUIT DISPONIBLE
        // echo "<p style='text-align:center;'>Aucune offre disponible pour le moment.</p>"; 
        ?>

        <div class="offres-grid">
            <!-- Exemple d'offre 1 -->
            <!-- <article class="offre-card">
                <img src="assets/images/salle4.jpg" alt="Salle Cézanne Paris">
                <div class="offre-content">
                    <h4>Salle Cézanne – Paris</h4>
                    <p>Salle moderne idéale pour réunions professionnelles et séminaires d'entreprise.</p>
                    <p><strong>Capacité :</strong> 20 personnes</p>
                    <p><strong>Ville :</strong> Paris (75015)</p>
                    <p><strong>Dates :</strong> Du 22/01/2026 au 27/01/2026</p>
                    <p><strong>Prix :</strong> 550 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter pour réserver</a>
                        <a href="reservation_details.php?id_produit=1">Voir détails</a>
                    </div>
                </div>
            </article> -->

            <!-- Exemple d'offre 2 -->
            <!-- <article class="offre-card">
                <img src="assets/images/salle5.jpg" alt="Salle Mozart Lyon">
                <div class="offre-content">
                    <h4>Salle Mozart – Lyon</h4>
                    <p>Salle spacieuse parfaite pour formations, workshops et événements culturels.</p>
                    <p><strong>Capacité :</strong> 30 personnes</p>
                    <p><strong>Ville :</strong> Lyon (69002)</p>
                    <p><strong>Dates :</strong> Du 29/01/2026 au 03/02/2026</p>
                    <p><strong>Prix :</strong> 380 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter pour réserver</a>
                        <a href="reservation_details.php?id_produit=2">Voir détails</a>
                    </div>
                </div>
            </article> -->

            <!-- Exemple d'offre 3 -->
            <!-- <article class="offre-card">
                <img src="assets/images/salle6.jpg" alt="Salle Picasso Marseille">
                <div class="offre-content">
                    <h4>Salle Picasso – Marseille</h4>
                    <p>Espace lumineux avec vue sur mer, idéal pour conférences et présentations.</p>
                    <p><strong>Capacité :</strong> 50 personnes</p>
                    <p><strong>Ville :</strong> Marseille (13001)</p>
                    <p><strong>Dates :</strong> Du 15/02/2026 au 20/02/2026</p>
                    <p><strong>Prix :</strong> 720 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter pour réserver</a>
                        <a href="reservation_details.php?id_produit=3">Voir détails</a>
                    </div>
                </div>
            </article> -->

            <!-- Exemple d'offre 4 -->
            <!-- <article class="offre-card">
                <img src="images/salles/salle-paris2.jpg" alt="Salle Van Gogh Paris">
                <div class="offre-content">
                    <h4>Salle Van Gogh – Paris</h4>
                    <p>Salle élégante au cœur de Paris, équipée des dernières technologies.</p>
                    <p><strong>Capacité :</strong> 15 personnes</p>
                    <p><strong>Ville :</strong> Paris (75008)</p>
                    <p><strong>Dates :</strong> Du 10/02/2026 au 12/02/2026</p>
                    <p><strong>Prix :</strong> 450 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter pour réserver</a>
                        <a href="reservation_details.php?id_produit=4">Voir détails</a>
                    </div>
                </div>
            </article> -->

            <!-- Si l'utilisateur est connecté, remplacer le lien "Se connecter" par -->
            <!-- <a href="panier.php?id_produit=X">Ajouter au panier</a> -->

            <!-- Ajouter d'autres offres dynamiquement via PHP -->
            <?= get_salles(); ?>
        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>