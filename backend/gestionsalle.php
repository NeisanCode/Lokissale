<?php
require 'session.php';

if (!isset($_SESSION['membre']['id_membre']) || $_SESSION['membre']['statut'] != 1) {
    echo '<script>
        alert("Accès refusé. Page réservée aux administrateurs.");
        window.location.href = "../index.php";
    </script>';
    exit;
}

$message = '';
$messageType = '';
$editMode = false;
$salleToEdit = null;

/* =========================
   DONNÉES (démo ou DB)
========================= */
$salles = [
    [
        'id_salle' => 1,
        'pays' => 'France',
        'ville' => 'Paris',
        'adresse' => '10 Rue de la Paix',
        'cp' => '75002',
        'titre' => 'Salle Cézanne',
        'description' => 'Salle moderne idéale pour réunions',
        'photo' => 'assets/images/salle1.jpg',
        'capacite' => 20,
        'categorie' => 'Standard'
    ],
    [
        'id_salle' => 2,
        'pays' => 'France',
        'ville' => 'Lyon',
        'adresse' => '25 Avenue du Commerce',
        'cp' => '69002',
        'titre' => 'Salle Mozart',
        'description' => 'Salle pour séminaires',
        'photo' => 'assets/images/salle2.jpg',
        'capacite' => 30,
        'categorie' => 'Premium'
    ]
];

/* =========================
   AJOUT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $message = "Salle ajoutée avec succès !";
    $messageType = 'success';
}

/* =========================
   MODIFICATION
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
    $message = "Salle modifiée avec succès !";
    $messageType = 'success';
}

/* =========================
   SUPPRESSION
========================= */
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $message = "Salle supprimée avec succès !";
    $messageType = 'success';
}

/* =========================
   MODE ÉDITION
========================= */
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'edit') {
    $editMode = true;
    foreach ($salles as $salle) {
        if ($salle['id_salle'] == (int) $_GET['id']) {
            $salleToEdit = $salle;
            break;
        }
    }
}
