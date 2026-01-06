<?php require "inc/haut.inc.php" ;
require "inc/menu.inc.php" ;
require "../backend/gestionprod.php" ;
 ?>
    <main class="admin-container">
        <!-- En-tête admin -->
        <div class="admin-header">
            <h2>📦 Gestion des Produits</h2>
            <p style="margin: 10px 0 0 0;">Créez et gérez les offres de location de salles</p>
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
                <div class="stat-value"><?php echo $totalProduits; ?></div>
                <div class="stat-label">Total Produits</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #27ae60;"><?php echo $totalDisponibles; ?></div>
                <div class="stat-label">Disponibles</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #e74c3c;"><?php echo $totalReserves; ?></div>
                <div class="stat-label">Réservés</div>
            </div>
        </div>

        <!-- Actions principales -->
        <div class="admin-actions">
            <button class="btn-admin btn-add" onclick="toggleForm('add')">
                ➕ Ajouter un produit
            </button>
            <button class="btn-admin btn-list" onclick="toggleForm('list')">
                📋 Afficher les produits
            </button>
        </div>

        <!-- Formulaire ajout/modification -->
        <div class="form-container" id="formAdd">
            <div class="form-header">
                <h3><?php echo $editMode ? '✏️ Modifier le produit' : '➕ Ajouter un nouveau produit'; ?></h3>
            </div>

            <div class="info-box">
                <strong>ℹ️ Information :</strong> Un produit associe une salle à une période de disponibilité. 
                La même salle peut avoir plusieurs produits pour des dates différentes.
            </div>

            <form method="POST">
                <input type="hidden" name="action" value="<?php echo $editMode ? 'edit' : 'add'; ?>">
                <?php if ($editMode): ?>
                    <input type="hidden" name="id_produit" value="<?php echo $produitToEdit['id_produit']; ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_salle">Salle <span class="required">*</span></label>
                        <select id="id_salle" name="id_salle" required>
                            <option value="">-- Sélectionner une salle --</option>
                            <?php foreach ($salles as $salle): ?>
                                <option value="<?php echo $salle['id_salle']; ?>"
                                    <?php echo ($editMode && $produitToEdit['id_salle'] == $salle['id_salle']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($salle['titre'] . ' - ' . $salle['ville']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix HT (€) <span class="required">*</span></label>
                        <input type="number" id="prix" name="prix" min="1" 
                               value="<?php echo $editMode ? $produitToEdit['prix'] : ''; ?>" 
                               placeholder="500" required>
                        <small style="color: #7f8c8d;">La TVA de 20% sera ajoutée automatiquement</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_arrivee">Date d'arrivée <span class="required">*</span></label>
                        <input type="date" id="date_arrivee" name="date_arrivee" 
                               min="<?php echo date('Y-m-d'); ?>"
                               value="<?php echo $editMode ? $produitToEdit['date_arrivee'] : ''; ?>" 
                               required>
                        <small style="color: #7f8c8d;">Doit être >= à aujourd'hui</small>
                    </div>
                    <div class="form-group">
                        <label for="date_depart">Date de départ <span class="required">*</span></label>
                        <input type="date" id="date_depart" name="date_depart" 
                               min="<?php echo date('Y-m-d'); ?>"
                               value="<?php echo $editMode ? $produitToEdit['date_depart'] : ''; ?>" 
                               required>
                        <small style="color: #7f8c8d;">Doit être > date d'arrivée</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_promo">Code promo (optionnel)</label>
                    <select id="id_promo" name="id_promo">
                        <option value="">-- Aucun code promo --</option>
                        <option value="1" <?php echo ($editMode && $produitToEdit['id_promo'] == 1) ? 'selected' : ''; ?>>
                            PROMO10 - 10% de réduction
                        </option>
                        <option value="2" <?php echo ($editMode && $produitToEdit['id_promo'] == 2) ? 'selected' : ''; ?>>
                            PROMO15 - 15% de réduction
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <?php echo $editMode ? '✅ Enregistrer les modifications' : '✅ Ajouter le produit'; ?>
                </button>
            </form>
        </div>

        <!-- Tableau des produits -->
        <div class="table-container" id="tableList">
            <?php if (empty($produits)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>Aucun produit enregistré</h3>
                    <p>Commencez par ajouter votre premier produit</p>
                </div>
            <?php else: ?>
                <div class="table-header">
                    <h3>📋 Liste des produits (<?php echo $totalProduits; ?>)</h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 14px;">
                        Cliquez sur les en-têtes Date d'arrivée, Date de départ ou Prix pour trier
                    </p>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Salle</th>
                            <th>Ville</th>
                            <th class="sortable <?php echo ($orderField === 'date_arrivee') ? 'sorted-' . strtolower($orderDir) : ''; ?>" 
                                onclick="sortTable('date_arrivee', '<?php echo ($orderField === 'date_arrivee' && $orderDir === 'ASC') ? 'DESC' : 'ASC'; ?>')">
                                Date d'arrivée
                            </th>
                            <th class="sortable <?php echo ($orderField === 'date_depart') ? 'sorted-' . strtolower($orderDir) : ''; ?>" 
                                onclick="sortTable('date_depart', '<?php echo ($orderField === 'date_depart' && $orderDir === 'ASC') ? 'DESC' : 'ASC'; ?>')">
                                Date de départ
                            </th>
                            <th class="sortable <?php echo ($orderField === 'prix') ? 'sorted-' . strtolower($orderDir) : ''; ?>" 
                                onclick="sortTable('prix', '<?php echo ($orderField === 'prix' && $orderDir === 'ASC') ? 'DESC' : 'ASC'; ?>')">
                                Prix HT
                            </th>
                            <th>Prix TTC</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <?php 
                            $prixTTC = $produit['prix'] * 1.20;
                            ?>
                            <tr>
                                <td><strong>#<?php echo $produit['id_produit']; ?></strong></td>
                                <td>
                                    <img src="<?php echo htmlspecialchars($produit['photo']); ?>" 
                                         alt="<?php echo htmlspecialchars($produit['titre']); ?>" 
                                         class="produit-image">
                                </td>
                                <td><strong><?php echo htmlspecialchars($produit['titre']); ?></strong></td>
                                <td><?php echo htmlspecialchars($produit['ville']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($produit['date_arrivee'])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($produit['date_depart'])); ?></td>
                                <td><strong><?php echo number_format($produit['prix'], 0, ',', ' '); ?> €</strong></td>
                                <td><strong><?php echo number_format($prixTTC, 2, ',', ' '); ?> €</strong></td>
                                <td>
                                    <?php if ($produit['etat'] == 0): ?>
                                        <span class="badge badge-disponible">✓ Disponible</span>
                                    <?php else: ?>
                                        <span class="badge badge-reserve">✗ Réservé</span>
                                    <?php endif; ?>
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="?edit=1&id=<?php echo $produit['id_produit']; ?>" 
                                       class="btn-action btn-edit">✏️ Modifier</a>
                                    <button onclick="deleteProduit(<?php echo $produit['id_produit']; ?>, '<?php echo htmlspecialchars($produit['titre']); ?>')" 
                                            class="btn-action btn-delete">🗑️ Supprimer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>



    <!-- ========================================
         JAVASCRIPT
         ======================================== -->
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

        function deleteProduit(id, titre) {
            if (confirm('⚠️ ATTENTION !\n\nVous êtes sur le point de supprimer le produit :\n' + titre + '\n\nSi ce produit est associé à des commandes, il ne pourra pas être supprimé.\n\nVoulez-vous vraiment continuer ?')) {
                window.location.href = '?action=delete&id=' + id;
            }
        }

        function sortTable(field, dir) {
            window.location.href = '?order=' + field + '&dir=' + dir;
        }

        // Afficher le formulaire si en mode édition
        <?php if ($editMode): ?>
            toggleForm('add');
        <?php endif; ?>

        // Validation des dates
        document.querySelector('#formAdd form')?.addEventListener('submit', function(e) {
            const dateArrivee = document.getElementById('date_arrivee').value;
            const dateDepart = document.getElementById('date_depart').value;
            const today = new Date().toISOString().split('T')[0];
            
            if (dateArrivee < today) {
                e.preventDefault();
                alert('⚠️ La date d\'arrivée doit être supérieure ou égale à aujourd\'hui !');
                return false;
            }
            
            if (dateDepart <= dateArrivee) {
                e.preventDefault();
                alert('⚠️ La date de départ doit être supérieure à la date d\'arrivée !');
                return false;
            }
        });

        // Auto-ajuster la date de départ quand on change la date d'arrivée
        document.getElementById('date_arrivee')?.addEventListener('change', function() {
            const dateArrivee = new Date(this.value);
            const dateDepart = document.getElementById('date_depart');
            
            if (dateDepart.value && new Date(dateDepart.value) <= dateArrivee) {
                // Ajouter 1 jour à la date d'arrivée
                dateArrivee.setDate(dateArrivee.getDate() + 1);
                dateDepart.value = dateArrivee.toISOString().split('T')[0];
            }
        });
    </script>
<?php require "inc/bas.inc.php" ?>
