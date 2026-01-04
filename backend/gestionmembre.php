<?php
require_once '../config/database.php';
require_once '../config/gestionmembre.php';
require_once 'session.php';

// ===== VÉRIFICATION ADMINISTRATEUR =====
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    header('Location: index.php');
    exit();
}

$message = '';
$messageType = '';

// ===== TRAITEMENT SUPPRESSION MEMBRE =====
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idMembre = (int) $_GET['id'];

    // Vérifier qu'on ne supprime pas son propre compte
    if ($idMembre === $_SESSION['id_membre']) {
        $message = "Vous ne pouvez pas supprimer votre propre compte.";
        $messageType = 'error';
    } else {
        // Supprimer en cascade

        // 1. Supprimer de la newsletter
        $pdo->prepare("DELETE FROM newsletter WHERE id_membre = ?")->execute([$idMembre]);

        // 2. Supprimer les avis
        $pdo->prepare("DELETE FROM avis WHERE id_membre = ?")->execute([$idMembre]);

        // 3. Supprimer les détails de commandes
        $stmtCommandes = $pdo->prepare("SELECT id_commande FROM commande WHERE id_membre = ?");
        $stmtCommandes->execute([$idMembre]);
        $commandes = $stmtCommandes->fetchAll(PDO::FETCH_COLUMN);

        foreach ($commandes as $idCommande) {
            $pdo->prepare("DELETE FROM details_commande WHERE id_commande = ?")->execute([$idCommande]);
        }

        // 4. Supprimer les commandes
        $pdo->prepare("DELETE FROM commande WHERE id_membre = ?")->execute([$idMembre]);

        // 5. Supprimer le membre
        $stmt = $pdo->prepare("DELETE FROM membre WHERE id_membre = ?");
        if ($stmt->execute([$idMembre])) {
            $message = "Membre supprimé avec succès ! Toutes ses données associées ont été effacées.";
            $messageType = 'success';
        } else {
            $message = "Erreur lors de la suppression du membre.";
            $messageType = 'error';
        }

        // Pour la démo
        // $message = "Membre supprimé avec succès ! Toutes ses données associées (commandes, avis, newsletter) ont été effacées.";
        // $messageType = 'success';
    }
}

// ===== TRAITEMENT CRÉATION ADMIN =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_admin') {
    $pseudo = trim($_POST['pseudo']);
    $mdp = trim($_POST['mdp']);
    $confirmMdp = trim($_POST['confirm_mdp']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $sexe = $_POST['sexe'];
    $ville = trim($_POST['ville']);
    $cp = trim($_POST['cp']);
    $adresse = trim($_POST['adresse']);

    // Validations
    if (empty($pseudo) || empty($mdp) || empty($nom) || empty($prenom) || empty($email)) {
        $message = "Tous les champs marqués d'un astérisque (*) sont obligatoires.";
        $messageType = 'error';
    } elseif (strlen($pseudo) < 3) {
        $message = "Le pseudo doit contenir au moins 3 caractères.";
        $messageType = 'error';
    } elseif (strlen($mdp) < 3) {
        $message = "Le mot de passe doit contenir au moins 3 caractères.";
        $messageType = 'error';
    } elseif ($mdp !== $confirmMdp) {
        $message = "Les mots de passe ne correspondent pas.";
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email n'est pas valide.";
        $messageType = 'error';
    } else {
        // Vérifier si le pseudo ou email existe déjà
        // require_once 'config/database.php';
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM membre WHERE pseudo = ? OR email = ?");
        $stmt->execute([$pseudo, $email]);
        $existe = $stmt->fetchColumn() > 0;

        if ($existe) {
            $message = "Ce pseudo ou email est déjà utilisé.";
            $messageType = 'error';
        } else {
            // Créer le compte administrateur
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse, statut) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

            if ($stmt->execute([$pseudo, $mdpHash, $nom, $prenom, $email, $sexe, $ville, $cp, $adresse])) {
                $message = "Compte administrateur créé avec succès !";
                $messageType = 'success';
            } else {
                $message = "Erreur lors de la création du compte.";
                $messageType = 'error';
            }

            // Pour la démo
            $message = "Compte administrateur créé avec succès ! L'utilisateur peut maintenant se connecter.";
            $messageType = 'success';
        }
    }
}

// ===== RÉCUPÉRATION DES MEMBRES =====
$stmt = $pdo->query("SELECT * FROM membre ORDER BY statut DESC, id_membre DESC");
$membres = $stmt->fetchAll();

// // Données de démonstration
// $membres = [
//     [
//         'id_membre' => 1,
//         'pseudo' => 'admin_lokisalle',
//         'nom' => 'Admin',
//         'prenom' => 'Super',
//         'email' => 'admin@lokisalle.fr',
//         'sexe' => 'm',
//         'ville' => 'Paris',
//         'cp' => '75001',
//         'adresse' => '300 Boulevard de Vaugirard',
//         'statut' => 1
//     ],
//     [
//         'id_membre' => 2,
//         'pseudo' => 'john_doe',
//         'nom' => 'Doe',
//         'prenom' => 'John',
//         'email' => 'john.doe@example.com',
//         'sexe' => 'm',
//         'ville' => 'Lyon',
//         'cp' => '69002',
//         'adresse' => '25 Rue de la République',
//         'statut' => 0
//     ],
//     [
//         'id_membre' => 3,
//         'pseudo' => 'marie_martin',
//         'nom' => 'Martin',
//         'prenom' => 'Marie',
//         'email' => 'marie.martin@example.com',
//         'sexe' => 'f',
//         'ville' => 'Marseille',
//         'cp' => '13001',
//         'adresse' => '10 Avenue du Prado',
//         'statut' => 0
//     ],
//     [
//         'id_membre' => 4,
//         'pseudo' => 'pierre_durand',
//         'nom' => 'Durand',
//         'prenom' => 'Pierre',
//         'email' => 'pierre.durand@example.com',
//         'sexe' => 'm',
//         'ville' => 'Paris',
//         'cp' => '75015',
//         'adresse' => '45 Rue Lecourbe',
//         'statut' => 0
//     ]
// ];

// Statistiques
$totalMembres = count($membres);
$totalAdmins = count(array_filter($membres, function ($m) {
    return $m['statut'] == 1;
}));
$totalUtilisateurs = $totalMembres - $totalAdmins;
?>