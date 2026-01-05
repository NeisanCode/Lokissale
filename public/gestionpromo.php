<?php 
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/gestionpromo.php"
?>
<main class="admin-container">
    <!-- En-tête admin -->
    <div class="admin-header">
        <h2>🎁 Gestion des Codes Promo</h2>
        <p style="margin: 10px 0 0 0;">Créez et gérez les codes promotionnels pour les newsletters</p>
    </div>

    <!-- Messages -->
    <?php if ($message): ?>
        <div class="<?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
            <strong><?php echo $messageType === 'success' ? '✓' : '⚠️'; ?></strong>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?php echo $totalPromos; ?></div>
            <div class="stat-label">Total Codes Promo</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #27ae60;"><?php echo $promosActifs; ?></div>
            <div class="stat-label">Codes Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #e74c3c;"><?php echo $promosInactifs; ?></div>
            <div class="stat-label">Codes Inactifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #f39c12;"><?php echo number_format($reductionMoyenne, 0); ?>%
            </div>
            <div class="stat-label">Réduction Moyenne</div>
        </div>
    </div>

    <!-- Actions principales -->
    <div class="admin-actions">
        <button class="btn-admin btn-add" onclick="toggleForm('add')">
            ➕ Ajouter un code promo
        </button>
        <button class="btn-admin btn-list" onclick="toggleForm('list')">
            📋 Afficher les codes promo
        </button>
    </div>

    <!-- Formulaire ajout -->
    <div class="form-container" id="formAdd">
        <div class="form-header">
            <h3>➕ Créer un nouveau code promo</h3>
        </div>

        <div class="info-box">
            <strong>ℹ️ Information :</strong> Les codes promo créés peuvent être associés aux produits et diffusés
            via la newsletter.
            Un code promo peut être utilisé sur plusieurs produits simultanément.
        </div>

        <form method="POST">
            <input type="hidden" name="action" value="add">

            <div class="form-row">
                <div class="form-group">
                    <label for="code_promo">Code Promo <span class="required">*</span></label>
                    <input type="text" id="code_promo" name="code_promo" maxlength="6" placeholder="Ex: PROMO10"
                        style="text-transform: uppercase;" required>
                    <small style="color: #7f8c8d;">Maximum 6 caractères (converti en majuscules)</small>
                </div>
                <div class="form-group">
                    <label for="reduction">Réduction (%) <span class="required">*</span></label>
                    <input type="number" id="reduction" name="reduction" min="1" max="100" placeholder="Ex: 15"
                        required>
                    <small style="color: #7f8c8d;">Entre 1 et 100%</small>
                </div>
            </div>

            <div class="promo-preview" id="promoPreview" style="display: none;">
                <p style="margin: 0 0 10px 0; color: #7f8c8d;">Aperçu du code promo :</p>
                <div class="promo-preview-code" id="previewCode">PROMO10</div>
                <div class="promo-preview-reduction" id="previewReduction">-10%</div>
            </div>

            <button type="submit" class="btn-submit">
                ✅ Créer le code promo
            </button>
        </form>
    </div>

    <!-- Tableau des codes promo -->
    <div class="table-container" id="tableList">
        <?php if (empty($promos)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎁</div>
                <h3>Aucun code promo enregistré</h3>
                <p>Commencez par créer votre premier code promotionnel</p>
            </div>
        <?php else: ?>
            <div class="table-header">
                <h3>📋 Liste des codes promo (<?php echo $totalPromos; ?>)</h3>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code Promo</th>
                        <th>Réduction</th>
                        <th>Produits Associés</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promos as $promo): ?>
                        <tr>
                            <td><strong>#<?php echo $promo['id_promotion']; ?></strong></td>
                            <td>
                                <span class="promo-code">
                                    <?php echo htmlspecialchars($promo['code_promo']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="reduction-badge">
                                    -<?php echo $promo['reduction']; ?>%
                                </span>
                            </td>
                            <td>
                                <strong><?php echo $promo['nb_produits']; ?></strong>
                                produit<?php echo $promo['nb_produits'] > 1 ? 's' : ''; ?>
                            </td>
                            <td>
                                <?php if ($promo['nb_produits'] > 0): ?>
                                    <span class="badge badge-actif">✓ Actif</span>
                                <?php else: ?>
                                    <span class="badge badge-inactif">○ Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button
                                    onclick="deletePromo(<?php echo $promo['id_promotion']; ?>, '<?php echo htmlspecialchars($promo['code_promo']); ?>', <?php echo $promo['nb_produits']; ?>)"
                                    class="btn-delete">
                                    🗑️ Supprimer
                                </button>
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

    function deletePromo(id, code, nbProduits) {
        let message = '⚠️ ATTENTION !\n\nVous êtes sur le point de supprimer le code promo : ' + code + '\n\n';

        if (nbProduits > 0) {
            message += 'Ce code est actuellement associé à ' + nbProduits + ' produit' + (nbProduits > 1 ? 's' : '') + '.\n';
            message += 'Ces produits seront mis à jour et n\'auront plus de code promo.\n\n';
        }

        message += 'Cette action est IRRÉVERSIBLE !\n\nVoulez-vous vraiment continuer ?';

        if (confirm(message)) {
            window.location.href = '?action=delete&id=' + id;
        }
    }

    // Aperçu en temps réel du code promo
    const codeInput = document.getElementById('code_promo');
    const reductionInput = document.getElementById('reduction');
    const preview = document.getElementById('promoPreview');
    const previewCode = document.getElementById('previewCode');
    const previewReduction = document.getElementById('previewReduction');

    function updatePreview() {
        const code = codeInput.value.toUpperCase();
        const reduction = reductionInput.value;

        if (code && reduction) {
            previewCode.textContent = code;
            previewReduction.textContent = '-' + reduction + '%';
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    codeInput?.addEventListener('input', updatePreview);
    reductionInput?.addEventListener('input', updatePreview);

    // Validation du formulaire
    document.querySelector('#formAdd form')?.addEventListener('submit', function (e) {
        const reduction = parseInt(document.getElementById('reduction').value);

        if (reduction < 1 || reduction > 100) {
            e.preventDefault();
            alert('⚠️ La réduction doit être comprise entre 1 et 100% !');
            return false;
        }
    });
</script>
<?php require "inc/bas.inc.php" ?>