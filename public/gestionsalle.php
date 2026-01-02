<?php
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['id_membre']) || $_SESSION['statut'] != 1) {
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

// Traitement de l'ajout de salle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    // Récupérer et valider les données
    $pays = trim($_POST['pays']);
    $ville = trim($_POST['ville']);
    $adresse = trim($_POST['adresse']);
    $cp = trim($_POST['cp']);
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $capacite = (int) $_POST['capacite'];
    $categorie = $_POST['categorie'];

    // Traiter l'upload de l'image
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadDir = 'assets/images/';
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $uploadDir . $fileName;

        // Vérifier le type de fichier
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            // if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            //     $photo = $targetFile;
            // }
            $photo = 'assets/images/salle_exemple.jpg'; // Pour la démo
        }
    }

    // Insérer dans la base de données
    // require_once 'config/database.php';
    // $stmt = $pdo->prepare("INSERT INTO salle (pays, ville, adresse, cp, titre, description, photo, capacite, categorie) 
    //                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // if ($stmt->execute([$pays, $ville, $adresse, $cp, $titre, $description, $photo, $capacite, $categorie])) {
    //     $message = "Salle ajoutée avec succès !";
    //     $messageType = 'success';
    // } else {
    //     $message = "Erreur lors de l'ajout de la salle.";
    //     $messageType = 'error';
    // }

    $message = "Salle ajoutée avec succès !";
    $messageType = 'success';
}

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $idSalle = (int) $_POST['id_salle'];
    // Traiter la mise à jour...
    $message = "Salle modifiée avec succès !";
    $messageType = 'success';
}

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idSalle = (int) $_GET['id'];

    // Vérifier les dépendances (produits, avis associés)
    // require_once 'config/database.php';
    // $stmt = $pdo->prepare("SELECT COUNT(*) FROM produit WHERE id_salle = ?");
    // $stmt->execute([$idSalle]);
    // $produitsCount = $stmt->fetchColumn();

    // if ($produitsCount > 0) {
    //     $message = "Impossible de supprimer cette salle car elle est associée à des produits.";
    //     $messageType = 'error';
    // } else {
    //     // Supprimer les avis associés
    //     $pdo->prepare("DELETE FROM avis WHERE id_salle = ?")->execute([$idSalle]);
    //     
    //     // Supprimer la salle
    //     $stmt = $pdo->prepare("DELETE FROM salle WHERE id_salle = ?");
    //     if ($stmt->execute([$idSalle])) {
    //         $message = "Salle supprimée avec succès !";
    //         $messageType = 'success';
    //     }
    // }

    $message = "Salle supprimée avec succès ! Les avis associés ont également été supprimés.";
    $messageType = 'success';
}

// Récupérer les salles
$salles = [];
// require_once 'config/database.php';
// $stmt = $pdo->query("SELECT * FROM salle ORDER BY id_salle DESC");
// $salles = $stmt->fetchAll();

// Données de démonstration
$salles = [
    [
        'id_salle' => 1,
        'pays' => 'France',
        'ville' => 'Paris',
        'adresse' => '10 Rue de la Paix',
        'cp' => '75002',
        'titre' => 'Salle Cézanne',
        'description' => 'Salle moderne idéale pour réunions professionnelles',
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
        'description' => 'Salle spacieuse pour formations et séminaires',
        'photo' => 'assets/images/salle2.jpg',
        'capacite' => 30,
        'categorie' => 'Premium'
    ]
];

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



<!-- <nav class="menu">
        <a href='index.php'>Accueil</a>
        <a href='gestion_salles.php' class='active'>Salles</a>
        <a href='gestion_produits.php'>Produits</a>
        <a href='gestion_membres.php'>Membres</a>
        <a href='gestion_commandes.php'>Commandes</a>
        <a href='gestion_avis.php'>Avis</a>
        <a href='gestion_promos.php'>Promos</a>
        <a href='statistiques.php'>Statistiques</a>
        <a href='envoi_newsletter.php'>Newsletter</a>
        <a href='#'>Déconnexion</a>
    </nav> -->

<main class="admin-container">
    <div class="admin-header">
        <h2 style="margin: 0;">🏢 Gestion des Salles</h2>
        <p style="margin: 10px 0 0 0;">Ajoutez, modifiez ou supprimez les salles disponibles à la location</p>
    </div>

    <?php if ($message): ?>
        <div class="<?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Actions principales -->
    <div class="admin-actions">
        <button class="btn-admin btn-add" onclick="toggleForm('add')">
            ➕ Ajouter une salle
        </button>
        <button class="btn-admin btn-list" onclick="toggleForm('list')">
            📋 Afficher les salles
        </button>
    </div>

    <!-- Formulaire d'ajout/modification -->
    <div class="form-container" id="formAdd">
        <h3><?php echo $editMode ? '✏️ Modifier la salle' : '➕ Ajouter une nouvelle salle'; ?></h3>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo $editMode ? 'edit' : 'add'; ?>">
            <?php if ($editMode): ?>
                <input type="hidden" name="id_salle" value="<?php echo $salleToEdit['id_salle']; ?>">
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="pays">Pays <span class="required">*</span></label>
                    <input type="text" id="pays" name="pays"
                        value="<?php echo $editMode ? htmlspecialchars($salleToEdit['pays']) : 'France'; ?>" required>
                </div>

                <div class="form-group">
                    <label for="ville">Ville <span class="required">*</span></label>
                    <select id="ville" name="ville" required>
                        <option value="">-- Choisir --</option>
                        <option value="Paris" <?php echo ($editMode && $salleToEdit['ville'] === 'Paris') ? 'selected' : ''; ?>>Paris</option>
                        <option value="Lyon" <?php echo ($editMode && $salleToEdit['ville'] === 'Lyon') ? 'selected' : ''; ?>>Lyon</option>
                        <option value="Marseille" <?php echo ($editMode && $salleToEdit['ville'] === 'Marseille') ? 'selected' : ''; ?>>Marseille</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="adresse">Adresse <span class="required">*</span></label>
                    <input type="text" id="adresse" name="adresse"
                        value="<?php echo $editMode ? htmlspecialchars($salleToEdit['adresse']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="cp">Code Postal <span class="required">*</span></label>
                    <input type="text" id="cp" name="cp" maxlength="5"
                        value="<?php echo $editMode ? htmlspecialchars($salleToEdit['cp']) : ''; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="titre">Titre de la salle <span class="required">*</span></label>
                <input type="text" id="titre" name="titre"
                    value="<?php echo $editMode ? htmlspecialchars($salleToEdit['titre']) : ''; ?>"
                    placeholder="Ex: Salle Cézanne" required>
            </div>

            <div class="form-group">
                <label for="description">Description <span class="required">*</span></label>
                <textarea id="description" name="description"
                    required><?php echo $editMode ? htmlspecialchars($salleToEdit['description']) : ''; ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="capacite">Capacité (personnes) <span class="required">*</span></label>
                    <input type="number" id="capacite" name="capacite" min="1" max="999"
                        value="<?php echo $editMode ? $salleToEdit['capacite'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="categorie">Catégorie <span class="required">*</span></label>
                    <select id="categorie" name="categorie" required>
                        <option value="">-- Choisir --</option>
                        <option value="Standard" <?php echo ($editMode && $salleToEdit['categorie'] === 'Standard') ? 'selected' : ''; ?>>Standard</option>
                        <option value="Premium" <?php echo ($editMode && $salleToEdit['categorie'] === 'Premium') ? 'selected' : ''; ?>>Premium</option>
                        <option value="VIP" <?php echo ($editMode && $salleToEdit['categorie'] === 'VIP') ? 'selected' : ''; ?>>VIP</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Photo de la salle
                    <?php echo $editMode ? '' : '<span class="required">*</span>'; ?></label>
                <input type="file" id="photo" name="photo" accept="image/*" <?php echo $editMode ? '' : 'required'; ?>>
                <?php if ($editMode && $salleToEdit['photo']): ?>
                    <p style="margin-top: 10px; color: #666;">Photo actuelle :
                        <?php echo basename($salleToEdit['photo']); ?>
                    </p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">
                <?php echo $editMode ? '✅ Enregistrer les modifications' : '✅ Ajouter la salle'; ?>
            </button>
        </form>
    </div>

    <!-- Tableau des salles -->
    <div class="table-container" id="tableList">
        <?php if (empty($salles)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🏢</div>
                <h3>Aucune salle enregistrée</h3>
                <p>Commencez par ajouter votre première salle</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Titre</th>
                        <th>Ville</th>
                        <th>Adresse</th>
                        <th>CP</th>
                        <th>Capacité</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salles as $salle): ?>
                        <tr>
                            <td><?php echo $salle['id_salle']; ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($salle['photo']); ?>"
                                    alt="<?php echo htmlspecialchars($salle['titre']); ?>" class="salle-image">
                            </td>
                            <td><strong><?php echo htmlspecialchars($salle['titre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($salle['ville']); ?></td>
                            <td><?php echo htmlspecialchars($salle['adresse']); ?></td>
                            <td><?php echo htmlspecialchars($salle['cp']); ?></td>
                            <td><?php echo $salle['capacite']; ?> pers.</td>
                            <td><?php echo htmlspecialchars($salle['categorie']); ?></td>
                            <td style="white-space: nowrap;">
                                <a href="?action=edit&id=<?php echo $salle['id_salle']; ?>" class="btn-action btn-edit">✏️
                                    Modifier</a>
                                <button onclick="deleteSalle(<?php echo $salle['id_salle']; ?>)"
                                    class="btn-action btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>


<script>
    function toggleForm(type) {
        const formAdd = document.getElementById('formAdd');
        const tableList = document.getElementById('tableList');

        if (type === 'add') {
            formAdd.classList.add('active');
            tableList.classList.remove('active');
        } else {
            formAdd.classList.remove('active');
            tableList.classList.add('active');
        }
    }

    function deleteSalle(id) {
        if (confirm('⚠️ ATTENTION !\n\nLa suppression de cette salle entraînera :\n- Suppression de tous les avis associés\n- Impossibilité de supprimer si des produits sont liés\n\nVoulez-vous vraiment continuer ?')) {
            window.location.href = '?action=delete&id=' + id;
        }
    }

    // Afficher le formulaire si en mode édition
    <?php if ($editMode): ?>
        toggleForm('add');
    <?php endif; ?>
</script>