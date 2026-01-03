<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/gestionsalle.php";
?>

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
                                <img src="assets/images/<?php echo htmlspecialchars($salle['photo']); ?>"
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


<?php require "inc/bas.inc.php" ?>