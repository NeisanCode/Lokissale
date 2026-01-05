<?php
require_once '../config/database.php';
require_once 'session.php';

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    header('Location: index.php');
    exit();
}

// ===== RÉCUPÉRATION DES STATISTIQUES =====

// --- STATISTIQUES MEMBRES ---
$stmtMembres = $pdo->query("SELECT COUNT(*) as total, 
                            SUM(CASE WHEN statut = 1 THEN 1 ELSE 0 END) as admins,
                            SUM(CASE WHEN statut = 0 THEN 1 ELSE 0 END) as users
                            FROM membre");
$statsMembres = $stmtMembres->fetch();


// --- STATISTIQUES SALLES ---
$stmtSalles = $pdo->query("SELECT COUNT(*) as total,
                          COUNT(DISTINCT ville) as villes,
                          AVG(capacite) as capacite_moyenne
                          FROM salle");
$statsSalles = $stmtSalles->fetch();


// Répartition par ville
$stmtVilles = $pdo->query("SELECT ville, COUNT(*) as nb FROM salle GROUP BY ville ORDER BY nb DESC");
$sallesParVille = $stmtVilles->fetchAll();

$sallesParVille = [
    ['ville' => 'Paris', 'nb' => 6],
    ['ville' => 'Lyon', 'nb' => 4],
    ['ville' => 'Marseille', 'nb' => 2]
];

// --- STATISTIQUES PRODUITS ---
$stmtProduits = $pdo->query("SELECT COUNT(*) as total,
                             SUM(CASE WHEN etat = 0 THEN 1 ELSE 0 END) as disponibles,
                             SUM(CASE WHEN etat = 1 THEN 1 ELSE 0 END) as reserves
                             FROM produit");
$statsProduits = $stmtProduits->fetch();


// --- STATISTIQUES COMMANDES ---
$stmtCommandes = $pdo->query("SELECT COUNT(*) as total,
                              SUM(montant) as ca_total,
                              AVG(montant) as panier_moyen,
                              MIN(montant) as montant_min,
                              MAX(montant) as montant_max
                              FROM commande");
$statsCommandes = $stmtCommandes->fetch();


// Commandes par mois (6 derniers mois)
$stmtCommandesMois = $pdo->query("
    SELECT DATE_FORMAT(date, '%Y-%m') as mois, 
           COUNT(*) as nb_commandes,
           SUM(montant) as ca
    FROM commande 
    WHERE date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(date, '%Y-%m')
    ORDER BY mois
");
$commandesParMois = $stmtCommandesMois->fetchAll();

// Top 5 clients
$stmtTopClients = $pdo->query("
    SELECT m.pseudo, m.prenom, m.nom, 
           COUNT(c.id_commande) as nb_commandes,
           SUM(c.montant) as total_depense
    FROM membre m
    JOIN commande c ON m.id_membre = c.id_membre
    GROUP BY m.id_membre
    ORDER BY total_depense DESC
    LIMIT 5
");
$topClients = $stmtTopClients->fetchAll();


// --- STATISTIQUES AVIS ---
$stmtAvis = $pdo->query("SELECT COUNT(*) as total,
                        AVG(note) as moyenne,
                        SUM(CASE WHEN note = 5 THEN 1 ELSE 0 END) as note5,
                        SUM(CASE WHEN note = 4 THEN 1 ELSE 0 END) as note4,
                        SUM(CASE WHEN note = 3 THEN 1 ELSE 0 END) as note3,
                        SUM(CASE WHEN note = 2 THEN 1 ELSE 0 END) as note2,
                        SUM(CASE WHEN note = 1 THEN 1 ELSE 0 END) as note1
                        FROM avis");
$statsAvis = $stmtAvis->fetch();

// Salles les mieux notées
$stmtTopSalles = $pdo->query("
    SELECT s.titre, s.ville, 
           COUNT(a.id_avis) as nb_avis,
           AVG(a.note) as note_moyenne
    FROM salle s
    JOIN avis a ON s.id_salle = a.id_salle
    GROUP BY s.id_salle
    HAVING nb_avis >= 2
    ORDER BY note_moyenne DESC
    LIMIT 5
");
$topSalles = $stmtTopSalles->fetchAll();

// --- STATISTIQUES CODES PROMO ---
$stmtPromos = $pdo->query("SELECT COUNT(*) as total FROM promotion");
$statsPromos = $stmtPromos->fetch();

$statsPromos = ['total' => 6];

// --- NEWSLETTER ---
$stmtNewsletter = $pdo->query("SELECT COUNT(*) as total FROM newsletter");
$statsNewsletter = $stmtNewsletter->fetch();


// Variable pour l'affichage
$statView = isset($_GET['view']) ? $_GET['view'] : 'all';
?>