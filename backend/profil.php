<?php
require_once "../config/database.php";
require_once "session.php";
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['membre']['id_membre'])) {
    echo '<script>
            alert("Vous devez vous connecter pour accéder à votre profil.");
            window.location.href = "connexion.php";
        </script>';
    exit();
}

$message = '';
$messageType = '';

// Récupérer les informations du membre depuis la session ou la base de données
$stmt = $pdo->prepare("SELECT * FROM membre WHERE id_membre = ?");
$stmt->execute([$_SESSION["membre"]['id_membre']]);
$membre = $stmt->fetch();


// Traitement de la mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $pseudo = trim($_POST['pseudo']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $sexe = $_POST['sexe'];
    $ville = trim($_POST['ville']);
    $cp = trim($_POST['cp']);
    $adresse = trim($_POST['adresse']);
    $nouveauMdp = trim($_POST['nouveau_mdp'] ?? '');
    $confirmMdp = trim($_POST['confirm_mdp'] ?? '');

    // Validations
    if (empty($pseudo) || empty($nom) || empty($prenom) || empty($email)) {
        $message = "Tous les champs obligatoires doivent être remplis.";
        $messageType = 'error';
    } elseif (strlen($pseudo) < 3) {
        $message = "Le pseudo doit contenir au moins 3 caractères.";
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email n'est pas valide.";
        $messageType = 'error';
    } elseif (!empty($nouveauMdp) && strlen($nouveauMdp) < 3) {
        $message = "Le mot de passe doit contenir au moins 3 caractères.";
        $messageType = 'error';
    } elseif (!empty($nouveauMdp) && $nouveauMdp !== $confirmMdp) {
        $message = "Les mots de passe ne correspondent pas.";
        $messageType = 'error';
    } else {
        // Mise à jour dans la base de données
        $sql = "UPDATE membre SET pseudo = ?, nom = ?, prenom = ?, email = ?, sexe = ?, ville = ?, cp = ?, adresse = ?";
        $params = [$pseudo, $nom, $prenom, $email, $sexe, $ville, $cp, $adresse];

        // Si nouveau mot de passe
        if (!empty($nouveauMdp)) {
            $sql .= ", mdp = ?";
            $params[] = password_hash($nouveauMdp, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id_membre = ?";
        $params[] = $_SESSION["membre"]['id_membre'];

        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            // Mettre à jour la session
            $_SESSION["membre"]['pseudo'] = $pseudo;
            $_SESSION["membre"]['nom'] = $nom;
            $_SESSION["membre"]['prenom'] = $prenom;
            $_SESSION["membre"]['email'] = $email;

            $message = "Vos informations ont été mises à jour avec succès !";
            $messageType = 'success';
        } else {
            $message = "Erreur lors de la mise à jour.";
            $messageType = 'error';
        }

        // Pour la démo
        $message = "Vos informations ont été mises à jour avec succès !";
        $messageType = 'success';

        // Mettre à jour les données affichées
        $membre['pseudo'] = $pseudo;
        $membre['nom'] = $nom;
        $membre['prenom'] = $prenom;
        $membre['email'] = $email;
        $membre['sexe'] = $sexe;
        $membre['ville'] = $ville;
        $membre['cp'] = $cp;
        $membre['adresse'] = $adresse;
    }
}

// Récupérer les commandes du membre
$stmtCommandes = $pdo->prepare("-- sql
    SELECT c.*, COUNT(dc.id_produit) as nb_produits 
    FROM commande c
    LEFT JOIN details_commande dc ON c.id_commande = dc.id_commande
    WHERE c.id_membre = ?
    GROUP BY c.id_commande
    ORDER BY c.date DESC
");
$stmtCommandes->execute([$membre['id_membre']]);
$commandes = $stmtCommandes->fetchAll();
$totalCommandes = count($commandes);
$totalDepense = array_sum(array_column($commandes, 'montant'));
?>