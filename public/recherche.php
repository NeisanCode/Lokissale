<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container-large"> 
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Rechercher une salle disponible</h2>
        <p>Utilisez le formulaire ci-dessous pour rechercher une salle disponible selon vos dates de réservation.</p>
    </section> 

    <!-- Formulaire de recherche -->
    <section class="recherche-form">
        <form id="formRecherche" method="get" action="recherche.php">
            <label for="date_arrivee">Date d’arrivée</label>
            <input type="date" id="date_arrivee" name="date_arrivee" required>

            <label for="date_depart">Date de départ</label>
            <input type="date" id="date_depart" name="date_depart" required>

            <button type="submit">Rechercher</button>
        </form>
    </section> 

    <!-- Résultats de recherche -->
    <section class="offres" style="margin-top:40px;">
        <h3>Résultats de la recherche</h3>
        <?php 
        /* 🔹 TRAITEMENT PHP À FAIRE
           Vérifier si les dates sont envoyées
           Rechercher les produits disponibles :
           date_arrivee >= date sélectionnée
           date_depart <= date sélectionnée
           etat = 0
           jointure produits + salles
        */
        // SI AUCUN RÉSULTAT
        // echo "<p>Aucune salle disponible pour ces dates.</p>"; 
        ?>
        <div class="offres-grid">
            <!-- Exemple d'offre -->
            <article class="offre-card"> 
                <img src="images/salles/salle-paris.jpg" alt="Salle Cézanne Paris">
                <div class="offre-content">
                    <h4>Salle Cézanne – Paris</h4>
                    <p>Salle moderne idéale pour réunions professionnelles.</p>
                    <p><strong>Capacité :</strong> 20 personnes</p>
                    <p><strong>Prix :</strong> 550 €</p>
                    <div class="offre-actions"> 
                        <a href="connexion.php">Se connecter</a> 
                        <a href="reservation_details.php?id_produit=1">Voir détails</a> 
                    </div>
                </div>
            </article>

            <article class="offre-card"> 
                <img src="images/salles/salle-lyon.jpg" alt="Salle Mozart Lyon">
                <div class="offre-content">
                    <h4>Salle Mozart – Lyon</h4>
                    <p>Salle spacieuse pour formations et séminaires.</p>
                    <p><strong>Capacité :</strong> 30 personnes</p>
                    <p><strong>Prix :</strong> 620 €</p>
                    <div class="offre-actions"> 
                        <a href="connexion.php">Se connecter</a> 
                        <a href="reservation_details.php?id_produit=2">Voir détails</a> 
                    </div>
                </div>
            </article>

            <!-- Ajouter d'autres résultats ici -->
        </div>
    </section>
</main>

<?php require "inc/bas.inc.php" ?>
