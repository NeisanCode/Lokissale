<?php
require_once '../config/database.php';
require_once '../config/gestionsalle.php';
require_once 'session.php';

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION["membre"]['id_membre']) || $_SESSION["membre"]['statut'] != 1) {
    echo '<script>
            alert("Accès refusé. Cette page est réservée aux administrateurs.");
            window.location.href = "index.php";
        </script>';
    exit();
}

$message = '';
$messageType = '';
$editMode = false;
$salleToEdit = null;

function getMetaData(?PDO $pdo = null, ?int $id_salle = null)
{
    $pays = trim($_POST['pays']);
    $ville = trim($_POST['ville']);
    $adresse = trim($_POST['adresse']);
    $cp = trim($_POST['cp']);
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $capacite = (int) $_POST['capacite'];
    $categorie = $_POST['categorie'];

    // Traiter l'upload de l'image
    $photo = get_photo($pdo, $id_salle) ? isset($pdo, $id_salle) : "";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadDir = 'assets/images/';
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $uploadDir . $fileName;

        // Vérifier le type de fichier
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photo = $fileName;
            }
        }
    }
    return [
        "pays" => $pays,
        "ville" => $ville,
        "adresse" => $adresse,
        "cp" => $cp,
        "titre" => $titre,
        "description" => $description,
        "capacite" => $capacite,
        "categorie" => $categorie,
        "photo" => $photo,
        "fields" => ["pays", "ville", "adresse", "cp", "titre", "description", "capacite", "categorie", "photo"]
    ];
}
// Traitement de l'ajout de salle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $metadata = getMetaData();
    $pays = $metadata["pays"];
    $ville = $metadata["ville"];
    $adresse = $metadata["adresse"];
    $cp = $metadata["cp"];
    $titre = $metadata["titre"];
    $description = $metadata["description"];
    $capacite = $metadata["capacite"];
    $categorie = $metadata["categorie"];
    $photo = $metadata["photo"];
    // Insérer dans la base de données
    if (add_room($pdo, $pays, $ville, $adresse, $cp, $titre, $description, $photo, $capacite, $categorie)) {
        $message = "Salle ajoutée avec succès !";
        $messageType = 'success';
    } else {
        $message = "Erreur lors de l'ajout de la salle.";
        $messageType = 'error';
    }
}

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $idSalle = (int) $_POST['id_salle'];
    $metadata = getMetaData($pdo, $idSalle);
    $update_values = array_slice($metadata, 0, -1);
    $fields = $metadata["fields"];

    if (update_room($pdo, $idSalle, $update_values)) {
        $message = "Salle modifiée avec succès !";
        $messageType = 'success';
    } else {
        $message = "Erreur lors de la modification de la salle.";
        $messageType = 'error';
    }

}

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idSalle = (int) $_GET['id'];

    //Vérifier les dépendances (produits, avis associés)
    $produitsCount = count_prod($pdo, $idSalle);

    if ($produitsCount > 0) {
        $message = "Impossible de supprimer cette salle car elle est associée à des produits.";
        $messageType = 'error';
    } else {
        // Supprimer les avis associés
        if (delete_room($pdo, $idSalle)) {
            $message = "Salle supprimée avec succès !";
            $messageType = 'success';
        }
    }
    $message = "Salle supprimée avec succès ! Les avis associés ont également été supprimés.";
    $messageType = 'success';
}

// Récupérer les salles
$salles = get_room($pdo);


// Mode édition
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editMode = true;
    $idEdit = (int) $_GET['id'];
    foreach ($salles as $salle) {
        if ($salle['id_salle'] == $idEdit) {
            $salleToEdit = $salle;
            break;
        }
    }
}

?>