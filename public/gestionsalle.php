<?php require_once '../backend/gestionsalle.php'; ?>
<main class="admin-container">
    <h2>🏢 Gestion des salles</h2>

    <?php if ($message): ?>
        <div class="<?= $messageType === 'success' ? 'success-message' : 'error-message' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <button onclick="toggleForm('add')">➕ Ajouter</button>
    <button onclick="toggleForm('list')">📋 Liste</button>

    <!-- FORMULAIRE -->
    <div id="formAdd">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editMode ? 'edit' : 'add' ?>">
            <?php if ($editMode): ?>
                <input type="hidden" name="id_salle" value="<?= $salleToEdit['id_salle'] ?>">
            <?php endif; ?>

            <input type="text" name="titre" value="<?= $editMode ? htmlspecialchars($salleToEdit['titre']) : '' ?>"
                placeholder="Titre" required>

            <button type="submit">✅ Enregistrer</button>
        </form>
    </div>

    <!-- TABLE -->
    <div id="tableList">
        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($salles as $salle): ?>
                <tr>
                    <td><?= $salle['id_salle'] ?></td>
                    <td><?= htmlspecialchars($salle['titre']) ?></td>
                    <td>
                        <a href="?action=edit&id=<?= $salle['id_salle'] ?>">✏️</a>
                        <a href="?action=delete&id=<?= $salle['id_salle'] ?>"
                            onclick="return confirm('Supprimer ?')">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</main>

<script>
    function toggleForm(type) {
        document.getElementById('formAdd').style.display = type === 'add' ? 'block' : 'none';
        document.getElementById('tableList').style.display = type === 'list' ? 'block' : 'none';
    }
</script>