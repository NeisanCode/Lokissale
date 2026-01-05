<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>

<main class="container">
    <h2>Plan du Site</h2>
    <p style="margin-bottom: 30px; color: #555;">
        Retrouvez ci-dessous l'organisation complète du site LOKISALLE pour faciliter votre navigation.
    </p>

    <!-- Pages Principales -->
    <div class="plan-section">
        <h3>Pages Principales</h3>
        <ul>
            <li><a href="home.php">Accueil</a> - Présentation de LOKISALLE et dernières offres</li>
            <li><a href="reservation.php">Réservation</a> - Catalogue complet de nos offres disponibles</li>
            <li><a href="recherche.php">Recherche</a> - Rechercher une salle par date</li>
            <li><a href="reservation_details.php">Détails d'une réservation</a> - Fiche détaillée d'une salle</li>
        </ul>
    </div>

    <!-- Espace Visiteur -->
    <div class="plan-section">
        <h3>Espace Visiteur</h3>
        <ul>
            <li><a href="connexion.php">Connexion</a> - Se connecter à son compte membre</li>
            <li><a href="inscription.php">Inscription</a> - Créer un nouveau compte</li>
            <li><a href="motdepasseperdu.php">Mot de passe oublié</a> - Récupération de mot de passe</li>
            <li><a href="contact.php">Contact</a> - Formulaire de contact</li>
        </ul>
    </div>

    <!-- Espace Membre -->
    <div class="plan-section">
        <h3>Espace Membre</h3>
        <ul>
            <li><a href="profil.php">Mon Profil</a> - Gestion des informations personnelles et historique</li>
            <li><a href="panier.php">Mon Panier</a> - Panier de réservations</li>
            <li><a href="newsletter.php">Newsletter</a> - Inscription à la newsletter</li>
            <li>Déconnexion - Se déconnecter de son compte</li>
        </ul>
    </div>

    <!-- Espace Administrateur -->
    <div class="plan-section">
        <h3>Espace Administrateur (Back-Office)</h3>
        <ul>
            <li><a href="gestion_salles.php">Gestion des Salles</a> - Ajouter, modifier, supprimer des salles</li>
            <li><a href="gestion_produits.php">Gestion des Produits</a> - Ajouter, modifier, supprimer des offres</li>
            <li><a href="gestion_membres.php">Gestion des Membres</a> - Administration des comptes utilisateurs</li>
            <li><a href="gestion_commandes.php">Gestion des Commandes</a> - Consultation des réservations</li>
            <li><a href="gestion_avis.php">Gestion des Avis</a> - Modération des commentaires</li>
            <li><a href="gestion_promos.php">Gestion des Promotions</a> - Codes promotionnels</li>
            <li><a href="statistiques.php">Statistiques</a> - Rapports et analyses</li>
            <li><a href="envoi_newsletter.php">Envoi Newsletter</a> - Diffusion d'informations aux abonnés</li>
        </ul>
    </div>

    <!-- Pages Légales et Informations -->
    <div class="plan-section">
        <h3>Pages Légales et Informations</h3>
        <ul>
            <li><a href="mentions.php">Mentions Légales</a> - Informations légales du site</li>
            <li><a href="cgv.php">Conditions Générales de Vente</a> - CGV applicables</li>
            <li><a href="plan.php">Plan du Site</a> - Architecture du site (page actuelle)</li>
        </ul>
    </div>

    <!-- Fonctionnalités -->
    <div class="plan-section">
        <h3>Fonctionnalités Transversales</h3>
        <ul>
            <li>Impression de page - Disponible sur toutes les pages</li>
            <li>Menu dynamique - Adapté selon le statut (visiteur, membre, administrateur)</li>
            <li>Système de notation et avis - Sur les fiches détaillées des salles</li>
            <li>Codes promotionnels - Applicables lors du paiement</li>
            <li>Génération de factures PDF - Après validation de commande</li>
        </ul>
    </div>

    <!-- Zones Géographiques -->
    <div class="plan-section">
        <h3>Nos Zones Géographiques</h3>
        <ul>
            <li>Paris - Plusieurs salles disponibles</li>
            <li>Lyon - Plusieurs salles disponibles</li>
            <li>Marseille - Plusieurs salles disponibles</li>
        </ul>
    </div>

    <p style="margin-top: 30px; padding: 15px; background: #ecf0f1; border-radius: 5px; text-align: center;">
        <strong>Note :</strong> Certaines pages nécessitent une connexion pour y accéder.<br>
        Les pages d'administration sont réservées aux administrateurs du site.
    </p>
</main>
<?php require "inc/bas.inc.php" ?>