<?php
// envoi_newsletter_controller.php
require_once '../config/database.php';
require_once 'session.php';

// ===== VÉRIFICATION ADMINISTRATEUR =====
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    header('Location: connexion.php');
    exit();
}

// Récupération du nombre d'abonnés à la newsletter
try {
    $requete_abonnes = $pdo->prepare("
        SELECT COUNT(*) as nb_abonnes
        FROM newsletter
    ");
    $requete_abonnes->execute();
    $resultat = $requete_abonnes->fetch(PDO::FETCH_ASSOC);
    $nb_abonnes = $resultat['nb_abonnes'];
} catch (PDOException $e) {
    $nb_abonnes = 0;
    // Vous pourriez logger l'erreur
}

