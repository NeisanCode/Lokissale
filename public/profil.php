<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/profil.php"
    ?>
<main class="profil-container">
    <!-- En-tête du profil -->
    <div class="profil-header">
        <div class="profil-avatar">
            <?php echo $membre['sexe'] === 'Feminin' ? '👩' : '👨'; ?>
        </div>
        <div class="profil-info">
            <h2>Bienvenue, <?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?> !</h2>
            <p>@<?php echo htmlspecialchars($membre['pseudo']); ?> • Membre depuis 2025</p>
            <?php if ($membre['statut'] == 1): ?>
                <p style="color: #ffd700;">⭐ Administrateur</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="<?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
            <strong><?php echo $messageType === 'success' ? '✓' : '⚠️'; ?></strong>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Statistiques rapides -->
    <div class="stats-grid">
        <div class="stat-card" style="background:linear-gradient(135deg, #2c3e50, #1a252f)">
            <div class="stat-value"><?php echo $totalCommandes; ?></div>
            <div class="stat-label">Réservation<?php echo $totalCommandes > 1 ? 's' : ''; ?></div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ef3362, #dd6c84);">
            <div class="stat-value"><?php echo number_format($totalDepense, 0, ',', ' '); ?> €</div>
            <div class="stat-label">Dépensé au total</div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #7a4d3f, #5f3930);">
            <div class="stat-value">
                <?php echo $totalCommandes > 0 ? number_format($totalDepense / $totalCommandes, 0, ',', ' ') : 0; ?> €
            </div>
            <div class="stat-label">Panier moyen</div>
        </div>
    </div>

    <!-- Section Informations personnelles -->
    <div class="section-card">
        <div class="section-header">
            <h3>👤 Informations personnelles</h3>
            <button class="btn-edit" onclick="toggleEditForm()">
                ✏️ Modifier mes informations
            </button>
        </div>

        <!-- Affichage des informations -->
        <div id="infoDisplay">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Pseudo</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['pseudo']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nom complet</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Sexe</div>
                    <div class="info-value"><?php echo $membre['sexe'] === 'Feminin' ? 'Féminin' : 'Masculin'; ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Ville</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['ville']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Code postal</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['cp']); ?></div>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Adresse</div>
                    <div class="info-value"><?php echo htmlspecialchars($membre['adresse']); ?></div>
                </div>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div id="editForm" class="edit-form">
            <form method="POST">
                <input type="hidden" name="action" value="update">

                <div class="form-row">
                    <div class="form-group">
                        <label for="pseudo">Pseudo <span class="required">*</span></label>
                        <input type="text" id="pseudo" name="pseudo"
                            value="<?php echo htmlspecialchars($membre['pseudo']); ?>" minlength="3" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email"
                            value="<?php echo htmlspecialchars($membre['email']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom <span class="required">*</span></label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($membre['nom']); ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="required">*</span></label>
                        <input type="text" id="prenom" name="prenom"
                            value="<?php echo htmlspecialchars($membre['prenom']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sexe">Sexe <span class="required">*</span></label>
                        <select id="sexe" name="sexe" required>
                            <option value="m" <?php echo $membre['sexe'] === 'Masculin' ? 'selected' : ''; ?>>Masculin
                            </option>
                            <option value="f" <?php echo $membre['sexe'] === 'Feminin' ? 'selected' : ''; ?>>Féminin
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cp">Code postal <span class="required">*</span></label>
                        <input type="text" id="cp" name="cp" value="<?php echo htmlspecialchars($membre['cp']); ?>"
                            maxlength="5" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ville">Ville <span class="required">*</span></label>
                        <input type="text" id="ville" name="ville"
                            value="<?php echo htmlspecialchars($membre['ville']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse <span class="required">*</span></label>
                        <input type="text" id="adresse" name="adresse"
                            value="<?php echo htmlspecialchars($membre['adresse']); ?>" required>
                    </div>
                </div>

                <hr style="margin: 30px 0; border: 1px solid #ecf0f1;">

                <h4 style="margin-bottom: 15px; color: #2c3e50;">🔒 Changer le mot de passe (optionnel)</h4>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nouveau_mdp">Nouveau mot de passe</label>
                        <input type="password" id="nouveau_mdp" name="nouveau_mdp" minlength="3"
                            placeholder="Laisser vide pour ne pas modifier">
                    </div>
                    <div class="form-group">
                        <label for="confirm_mdp">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_mdp" name="confirm_mdp"
                            placeholder="Confirmer le nouveau mot de passe">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">✅ Enregistrer les modifications</button>
                    <button type="button" class="btn-cancel" onclick="toggleEditForm()">❌ Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Historique des commandes -->
    <div class="section-card">
        <div class="section-header">
            <h3>📦 Mes réservations</h3>
        </div>

        <?php if (empty($commandes)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h4>Aucune réservation pour le moment</h4>
                <p>Découvrez nos salles disponibles et effectuez votre première réservation !</p>
                <a href="reservation.php" class="btn-edit" style="margin-top: 15px;">
                    Voir les offres
                </a>
            </div>
        <?php else: ?>
            <table class="commandes-table">
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Produits</th>
                        <th>Montant TTC</th>
                        <th>Statut</th>
                        <th>Facture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td><strong>#<?php echo $commande['id_commande']; ?></strong></td>
                            <td><?php echo date('d/m/Y à H:i', strtotime($commande['date'])); ?></td>
                            <td><?php echo $commande['nb_produits']; ?>
                                produit<?php echo $commande['nb_produits'] > 1 ? 's' : ''; ?></td>
                            <td><strong><?php echo number_format($commande['montant'], 2, ',', ' '); ?> €</strong></td>
                            <td><span class="status-badge status-paid">✓ Payée</span></td>
                            <td>
                                <a href="facture.php?id=<?php echo $commande['id_commande']; ?>" class="btn-view-invoice"
                                    target="_blank">
                                    📄 Voir PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<script>
    function toggleEditForm() {
        const infoDisplay = document.getElementById('infoDisplay');
        const editForm = document.getElementById('editForm');

        if (editForm.classList.contains('active')) {
            editForm.classList.remove('active');
            infoDisplay.style.display = 'block';
        } else {
            editForm.classList.add('active');
            infoDisplay.style.display = 'none';
        }
    }

    // Validation du formulaire
    document.getElementById('editForm')?.querySelector('form')?.addEventListener('submit', function (e) {
        const nouveauMdp = document.getElementById('nouveau_mdp').value;
        const confirmMdp = document.getElementById('confirm_mdp').value;

        if (nouveauMdp && nouveauMdp !== confirmMdp) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas !');
            return false;
        }
    });
</script>

<?php require "inc/bas.inc.php"; ?>