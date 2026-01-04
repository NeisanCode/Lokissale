<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/gestionmembre.php";
?>

<main class="admin-container">
    <!-- En-tête admin -->
    <div class="admin-header">
        <h2>👥 Gestion des Membres</h2>
        <p style="margin: 10px 0 0 0;">Gérez les comptes utilisateurs et créez de nouveaux administrateurs</p>
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
            <div class="stat-value"><?php echo $totalMembres; ?></div>
            <div class="stat-label">Total Membres</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #f39c12;"><?php echo $totalAdmins; ?></div>
            <div class="stat-label">Administrateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #3498db;"><?php echo $totalUtilisateurs; ?></div>
            <div class="stat-label">Utilisateurs</div>
        </div>
    </div>

    <!-- Action principale -->
    <div class="admin-actions">
        <button class="btn-admin" onclick="toggleForm()">
            ➕ Créer un compte administrateur
        </button>
    </div>

    <!-- Formulaire création admin -->
    <div class="form-container" id="formCreate">
        <div class="form-header">
            <h3>👤 Créer un nouveau compte administrateur</h3>
            <button class="btn-close" onclick="toggleForm()">×</button>
        </div>

        <div class="info-box">
            <strong>ℹ️ Information :</strong> Le compte créé aura les droits d'administrateur (statut = 1) et pourra
            accéder au back-office.
        </div>

        <form method="POST">
            <input type="hidden" name="action" value="create_admin">

            <div class="form-row">
                <div class="form-group">
                    <label for="pseudo">Pseudo <span class="required">*</span></label>
                    <input type="text" id="pseudo" name="pseudo" minlength="3" placeholder="Minimum 3 caractères"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="admin@lokisalle.fr" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mdp">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="mdp" name="mdp" minlength="3" placeholder="Minimum 3 caractères"
                        required>
                </div>
                <div class="form-group">
                    <label for="confirm_mdp">Confirmer mot de passe <span class="required">*</span></label>
                    <input type="password" id="confirm_mdp" name="confirm_mdp" placeholder="Confirmer le mot de passe"
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom <span class="required">*</span></label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom <span class="required">*</span></label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="sexe">Sexe <span class="required">*</span></label>
                    <select id="sexe" name="sexe" required>
                        <option value="">-- Choisir --</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Feminin">Féminin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cp">Code postal <span class="required">*</span></label>
                    <input type="text" id="cp" name="cp" maxlength="5" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ville">Ville <span class="required">*</span></label>
                    <input type="text" id="ville" name="ville" required>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse <span class="required">*</span></label>
                    <input type="text" id="adresse" name="adresse" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                ✅ Créer le compte administrateur
            </button>
        </form>
    </div>

    <!-- Tableau des membres -->
    <div class="table-container">
        <div class="table-header">
            <h3>📋 Liste des membres (<?php echo $totalMembres; ?>)</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Sexe</th>
                    <th>Ville</th>
                    <th>CP</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($membres as $membre): ?>
                    <tr>
                        <td><strong>#<?php echo $membre['id_membre']; ?></strong></td>
                        <td><?php echo htmlspecialchars($membre['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?></td>
                        <td><?php echo htmlspecialchars($membre['email']); ?></td>
                        <td><?php echo $membre['sexe'] === 'f' ? '👩 F' : '👨 M'; ?></td>
                        <td><?php echo htmlspecialchars($membre['ville']); ?></td>
                        <td><?php echo htmlspecialchars($membre['cp']); ?></td>
                        <td>
                            <?php if ($membre['statut'] == 1): ?>
                                <span class="badge badge-admin">⭐ Admin</span>
                            <?php else: ?>
                                <span class="badge badge-user">👤 Membre</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($membre['id_membre'] === $_SESSION['id_membre']): ?>
                                <button class="btn-delete" disabled title="Vous ne pouvez pas supprimer votre propre compte">
                                    🔒 Protégé
                                </button>
                            <?php else: ?>
                                <button class="btn-delete"
                                    onclick="deleteMembre(<?php echo $membre['id_membre']; ?>, '<?php echo htmlspecialchars($membre['pseudo']); ?>')">
                                    ❌ Supprimer
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- ========================================
         FOOTER
         ======================================== -->
<footer class="footer">
    <p>© LOKISALLE - Administration | </p>
    <nav>
        <a href="mentions.php">Mentions légales</a> |
        <a href="cgv.php">CGV</a>
    </nav>
</footer>

<!-- ========================================
         JAVASCRIPT
         ======================================== -->
<script>
    function toggleForm() {
        const form = document.getElementById('formCreate');
        form.classList.toggle('active');

        // Scroll vers le formulaire si ouvert
        if (form.classList.contains('active')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function deleteMembre(id, pseudo) {
        if (confirm('⚠️ ATTENTION !\n\nVous êtes sur le point de supprimer le membre : ' + pseudo + '\n\nCette action entraînera :\n- Suppression de toutes ses commandes\n- Suppression de tous ses avis\n- Désinscription de la newsletter\n- Suppression définitive du compte\n\nCette action est IRRÉVERSIBLE !\n\nVoulez-vous vraiment continuer ?')) {
            window.location.href = '?action=delete&id=' + id;
        }
    }

    // Validation du formulaire
    document.querySelector('#formCreate form')?.addEventListener('submit', function (e) {
        const mdp = document.getElementById('mdp').value;
        const confirmMdp = document.getElementById('confirm_mdp').value;

        if (mdp !== confirmMdp) {
            e.preventDefault();
            alert('⚠️ Les mots de passe ne correspondent pas !');
            return false;
        }
    });
</script>

<?php
require "inc/bas.inc.php";
?>