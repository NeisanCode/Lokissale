<?php
require_once '../config/database.php';
require_once 'session.php';

// ===== VÉRIFICATION ADMINISTRATEUR =====
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    header('Location: index.php');
    exit();
}

$message = '';
$messageType = '';

// ===== TRAITEMENT SUPPRESSION AVIS =====
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idAvis = (int) $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM avis WHERE id_avis = ?");
    if ($stmt->execute([$idAvis])) {
        $message = "Avis supprimé avec succès !";
        $messageType = 'success';
    } else {
        $message = "Erreur lors de la suppression de l'avis.";
        $messageType = 'error';
    }


}

// ===== RÉCUPÉRATION DES AVIS =====
$stmt = $pdo->query("
    SELECT a.*, m.pseudo, m.prenom, m.nom, s.titre as salle_titre, s.ville
    FROM avis a
    JOIN membre m ON a.id_membre = m.id_membre
    JOIN salle s ON a.id_salle = s.id_salle
    ORDER BY a.date DESC
");
$avis = $stmt->fetchAll();

// ===== STATISTIQUES =====
$totalAvis = count($avis);
$moyenneNotes = $totalAvis > 0 ? array_sum(array_column($avis, 'note')) / $totalAvis : 0;
$avis5Etoiles = count(array_filter($avis, function ($a) {
    return $a['note'] == 5; }));
$avis4Etoiles = count(array_filter($avis, function ($a) {
    return $a['note'] == 4; }));
$avis3Etoiles = count(array_filter($avis, function ($a) {
    return $a['note'] == 3; }));
$avis2Etoiles = count(array_filter($avis, function ($a) {
    return $a['note'] == 2; }));
$avis1Etoile = count(array_filter($avis, function ($a) {
    return $a['note'] == 1; }));

// Filtrage par note
$filtreNote = isset($_GET['filtre']) ? (int) $_GET['filtre'] : 0;
if ($filtreNote > 0) {
    $avis = array_filter($avis, function ($a) use ($filtreNote) {
        return $a['note'] == $filtreNote;
    });
}

// Filtrage par salle
$filtreSalle = isset($_GET['salle']) ? (int) $_GET['salle'] : 0;
if ($filtreSalle > 0) {
    $avis = array_filter($avis, function ($a) use ($filtreSalle) {
        return $a['id_salle'] == $filtreSalle;
    });
}
?>