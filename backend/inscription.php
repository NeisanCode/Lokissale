<?php
require "../config/database.php"; // Connexion à la base de données

$message = '';
$message_type = ''; // 'error' ou 'success'
$membre_inscrit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo = trim($_POST['pseudo']);
    $nom = trim($_POST['nom']);
    $prenoms = trim($_POST['prenoms']);
    $email = trim($_POST['email']);
    $mdp = $_POST['mdp'];
    $sexe = $_POST['sexe'];
    $ville = trim($_POST['ville']);

    // Vérifier si le compte existe déjà
    $sql = "SELECT * FROM membre WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $membre = $stmt->fetch();

    if ($membre) {
        $message = "Ce compte existe déjà. Veuillez vous connecter.";
        $message_type = 'error';
    } else {
        // Inscription : ajouter dans la BD
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        $sql = "INSERT INTO membre (pseudo, nom, prenoms, email, mdp, sexe, ville, statut)
                VALUES (:pseudo, :nom, :prenoms, :email, :mdp, :sexe, :ville, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'pseudo' => $pseudo,
            'nom' => $nom,
            'prenoms' => $prenoms,
            'email' => $email,
            'mdp' => $mdp_hash,
            'sexe' => $sexe,
            'ville' => $ville
        ]);

        // Créer la session
        $_SESSION['membre'] = [
            'pseudo' => $pseudo,
            'nom' => $nom,
            'prenoms' => $prenoms,
            'email' => $email,
            'sexe' => $sexe,
            'ville' => $ville
        ];

        $membre_inscrit = $_SESSION['membre'];
        $message = "Inscription réussie. Bienvenue " . htmlspecialchars($pseudo) . " !";
        $message_type = 'success';
    }
}
?>