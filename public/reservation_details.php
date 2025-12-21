<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php require "../backend/product.php" ?>


<main class="container-large">
    <!-- Détails de la salle -->
    <section class="details-salle">
        <div class="details-grid">
            <!-- Image principale -->
            <div class="details-image">
                <img src="assets/images/<?= $photo ?>" alt="<?= $title ?>">
            </div>

            <!-- Informations principales -->
            <div class="details-info">
                <h2><?= $titre_page ?></h2>
                <p class="details-description">
                    <?= $description ?>
                </p>

                <div class="details-specs">
                    <p><strong>📍 Ville :</strong> <?= $ville ?> - <?= $cp ?></p>
                    <p><strong>👥 Capacité :</strong> <?= $capacite ?> personnes</p>
                    <p><strong>🏷️ Catégorie :</strong> Professionnelle</p>
                    <p><strong>📅 Dates :</strong> <?= $date_salle ?></p>
                    <p><strong>💰 Prix HT :</strong> <?= $prix_ht; ?> €</p>
                    <p><strong>💳 Prix TTC :</strong> <span class="prix-ttc"><?= $prix_ttc; ?> €</span></p>
                </div>

                <!-- Bouton d'ajout au panier -->
                <div class="details-actions">
                    <?php
                    // SI L'UTILISATEUR EST CONNECTÉ (membre ou admin)
                    // if(isset($_SESSION['membre'])) {
                    ?>
                    <!-- <a href="panier.php?id_produit=<?php echo $id_produit; ?>" class="btn-panier">Ajouter au panier</a> -->
                    <?php
                    // } else {
                    ?>
                    <p class="connexion-required">⚠️ Veuillez-vous <a href="inscription.php">inscrire</a> ou vous <a
                            href="connexion.php">connecter</a> pour pouvoir effectuer une réservation.</p>
                    <?php
                    // }
                    ?>
                </div>
            </div>
        </div>

        <!-- Informations complémentaires -->
        <div class="details-complementaires">
            <h3>📋 Informations complémentaires</h3>
            <p><strong>Adresse :</strong> <?= $adresse ?>, <?= $cp ?> <?= $ville ?>, <?= $pays ?></p>
            <!-- <p><strong>Équipements :</strong> Vidéoprojecteur, Paper board, Wifi, Climatisation, Machine à café</p> -->
            <!-- <p><strong>Accès :</strong> Métro ligne 12, station Vaugirard. Parking disponible à proximité.</p> -->
            <!-- <p><strong>Services inclus :</strong> Ménage, Support technique, Accueil personnalisé</p> -->

            <!-- Plan d'accès (optionnel) -->
            <div class="plan-acces">
                <h4>🗺️ Plan d'accès</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2626.2!2d2.3059!3d48.8387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDjCsDUwJzE5LjMiTiAywrAxOCcyMS4yIkU!5e0!3m2!1sfr!2sfr!4v1234567890"
                    width="100%" height="300" style="border:0; border-radius: 5px; margin-top: 10px;" allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Section Avis et Commentaires -->
    <section class="avis-section">
        <h3>💬 Avis et commentaires</h3>

        <?php
        /* 🔹 TRAITEMENT PHP À FAIRE
           1. Récupérer tous les avis pour cette salle :

           SELECT a.*, m.pseudo 
           FROM avis a 
           INNER JOIN membre m ON a.id_membre = m.id_membre 
           WHERE a.id_salle = ? 
           ORDER BY a.date DESC

           2. Afficher chaque avis avec pseudo, date, note et commentaire
        */
        ?>

        <!-- Liste des avis existants -->
        <div class="avis-liste">
            <!-- Exemple d'avis 1 -->
            <article class="avis-item">
                <div class="avis-header">
                    <strong class="avis-auteur">Jean_Dupont</strong>
                    <span class="avis-note">⭐⭐⭐⭐⭐ (5/5)</span>
                    <span class="avis-date">15/12/2025</span>
                </div>
                <p class="avis-commentaire">
                    Excellente salle, très bien équipée et idéalement située.
                    L'équipe est professionnelle et réactive. Je recommande vivement !
                </p>
            </article>

            <!-- Exemple d'avis 2 -->
            <article class="avis-item">
                <div class="avis-header">
                    <strong class="avis-auteur">Marie_Martin</strong>
                    <span class="avis-note">⭐⭐⭐⭐ (4/5)</span>
                    <span class="avis-date">10/12/2025</span>
                </div>
                <p class="avis-commentaire">
                    Très bonne salle pour nos séminaires. Seul bémol : le parking un peu cher.
                </p>
            </article>

            <!-- Exemple d'avis 3 -->
            <article class="avis-item">
                <div class="avis-header">
                    <strong class="avis-auteur">Pierre_Leroy</strong>
                    <span class="avis-note">⭐⭐⭐⭐⭐ (5/5)</span>
                    <span class="avis-date">05/12/2025</span>
                </div>
                <p class="avis-commentaire">
                    Parfait pour notre événement d'entreprise. Espace modulable et lumineux.
                </p>
            </article>
        </div>

        <!-- Formulaire d'ajout d'avis -->
        <div class="avis-formulaire">
            <?php
            // SI L'UTILISATEUR N'EST PAS CONNECTÉ
            // if(!isset($_SESSION['membre'])) {
            ?>
            <p class="info-connexion">ℹ️ Il faut être connecté pour pouvoir déposer des commentaires.</p>
            <?php
            // } elseif (/* l'utilisateur a déjà commenté cette salle */) {
            ?>
            <!-- <p class="info-merci">✅ Merci pour votre contribution !</p> -->
            <?php
            // } else {
            ?>
            <h4>Laisser votre avis</h4>
            <form method="post" action="">
                <label for="note">Note (sur 5) :</label>
                <select name="note" id="note" required>
                    <option value="">Attribuer une note</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                    <option value="4">⭐⭐⭐⭐ (4/5)</option>
                    <option value="3">⭐⭐⭐ (3/5)</option>
                    <option value="2">⭐⭐ (2/5)</option>
                    <option value="1">⭐ (1/5)</option>
                </select>

                <label for="commentaire">Votre commentaire :</label>
                <textarea name="commentaire" id="commentaire" rows="5" required
                    placeholder="Partagez votre expérience..."></textarea>

                <button type="submit" name="ajouter_avis">Publier mon avis</button>
            </form>
            <?php
            // }
            ?>
        </div>
    </section>

    <!-- Suggestions de produits similaires -->
    <section class="suggestions">
        <h3>🔍 Produits similaires</h3>
        <p style="text-align:center; margin-bottom:20px;">
            Découvrez d'autres salles disponibles dans la même ville et aux dates proches
        </p>

        <?php
        /* 🔹 TRAITEMENT PHP À FAIRE
           Rechercher des produits similaires :
           - Même ville que la salle actuelle
           - Dates proches (+-7 jours)
           - etat = 0
           - LIMIT 3
        */
        ?>

        <div class="offres-grid">
            <!-- Suggestion 1 -->
            <article class="offre-card">
                <img src="images/salles/salle-paris3.jpg" alt="Salle Van Gogh Paris">
                <div class="offre-content">
                    <h4>Salle Van Gogh – Paris</h4>
                    <p>Salle élégante au cœur de Paris.</p>
                    <p><strong>Capacité :</strong> 15 personnes</p>
                    <p><strong>Dates :</strong> Du 25/01/2026 au 28/01/2026</p>
                    <p><strong>Prix :</strong> 450 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter</a>
                        <a href="reservation_details.php?id_produit=4">Voir détails</a>
                    </div>
                </div>
            </article>

            <!-- Suggestion 2 -->
            <article class="offre-card">
                <img src="images/salles/salle-paris3.jpg" alt="Salle Monet Paris">
                <div class="offre-content">
                    <h4>Salle Monet – Paris</h4>
                    <p>Espace convivial pour petites réunions.</p>
                    <p><strong>Capacité :</strong> 12 personnes</p>
                    <p><strong>Dates :</strong> Du 20/01/2026 au 24/01/2026</p>
                    <p><strong>Prix :</strong> 380 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter</a>
                        <a href="reservation_details.php?id_produit=5">Voir détails</a>
                    </div>
                </div>
            </article>

            <!-- Suggestion 3 -->
            <article class="offre-card">
                <img src="assets/images/salle2.jpg" alt="Salle Renoir Paris">
                <div class="offre-content">
                    <h4>Salle Renoir – Paris</h4>
                    <p>Grande salle pour événements.</p>
                    <p><strong>Capacité :</strong> 40 personnes</p>
                    <p><strong>Dates :</strong> Du 28/01/2026 au 02/02/2026</p>
                    <p><strong>Prix :</strong> 820 € HT</p>
                    <div class="offre-actions">
                        <a href="connexion.php">Se connecter</a>
                        <a href="reservation_details.php?id_produit=6">Voir détails</a>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>