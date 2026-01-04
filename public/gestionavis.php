<?php require "inc/haut.inc.php" ?>
<?php require "inc/menu.inc.php" ?>
<?php require "../backend/gestionavis.php" ?>

<main class="admin-container">
    <!-- En-tête admin -->
    <div class="admin-header">
        <h2>⭐ Gestion des Avis</h2>
        <p style="margin: 10px 0 0 0;">Modérez les commentaires et notations laissés par les membres</p>
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
            <div class="stat-value"><?php echo $totalAvis; ?></div>
            <div class="stat-label">Total Avis</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #f39c12;">
                <?php echo number_format($moyenneNotes, 1, ',', ' '); ?>/5
            </div>
            <div class="stat-label">Note Moyenne</div>
        </div>
        <div class="stat-card">
            <div class="star-rating">★★★★★</div>
            <div class="stat-value" style="font-size: 20px; color: #27ae60;"><?php echo $avis5Etoiles; ?></div>
            <div class="stat-label">5 étoiles</div>
        </div>
        <div class="stat-card">
            <div class="star-rating">★★★★☆</div>
            <div class="stat-value" style="font-size: 20px; color: #3498db;"><?php echo $avis4Etoiles; ?></div>
            <div class="stat-label">4 étoiles</div>
        </div>
        <div class="stat-card">
            <div class="star-rating">★★★☆☆</div>
            <div class="stat-value" style="font-size: 20px; color: #f39c12;"><?php echo $avis3Etoiles; ?></div>
            <div class="stat-label">3 étoiles</div>
        </div>
        <div class="stat-card">
            <div class="star-rating">★★☆☆☆</div>
            <div class="stat-value" style="font-size: 20px; color: #e67e22;"><?php echo $avis2Etoiles; ?></div>
            <div class="stat-label">2 étoiles</div>
        </div>
        <div class="stat-card">
            <div class="star-rating">★☆☆☆☆</div>
            <div class="stat-value" style="font-size: 20px; color: #e74c3c;"><?php echo $avis1Etoile; ?></div>
            <div class="stat-label">1 étoile</div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-container">
        <div class="filters-header">🔍 Filtrer les avis :</div>
        <div class="filters-row">
            <a href="?" class="filter-button <?php echo $filtreNote == 0 ? 'active' : ''; ?>">
                Tous les avis <span class="count"><?php echo $totalAvis; ?></span>
            </a>
            <a href="?filtre=5" class="filter-button <?php echo $filtreNote == 5 ? 'active' : ''; ?>">
                ⭐⭐⭐⭐⭐ <span class="count"><?php echo $avis5Etoiles; ?></span>
            </a>
            <a href="?filtre=4" class="filter-button <?php echo $filtreNote == 4 ? 'active' : ''; ?>">
                ⭐⭐⭐⭐ <span class="count"><?php echo $avis4Etoiles; ?></span>
            </a>
            <a href="?filtre=3" class="filter-button <?php echo $filtreNote == 3 ? 'active' : ''; ?>">
                ⭐⭐⭐ <span class="count"><?php echo $avis3Etoiles; ?></span>
            </a>
            <a href="?filtre=2" class="filter-button <?php echo $filtreNote == 2 ? 'active' : ''; ?>">
                ⭐⭐ <span class="count"><?php echo $avis2Etoiles; ?></span>
            </a>
            <a href="?filtre=1" class="filter-button <?php echo $filtreNote == 1 ? 'active' : ''; ?>">
                ⭐ <span class="count"><?php echo $avis1Etoile; ?></span>
            </a>
        </div>
    </div>

    <!-- Liste des avis -->
    <?php if (empty($avis)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">💬</div>
            <h3>Aucun avis
                <?php echo $filtreNote > 0 ? 'avec ' . $filtreNote . ' étoile' . ($filtreNote > 1 ? 's' : '') : 'disponible'; ?>
            </h3>
            <p>Les membres n'ont pas encore laissé d'avis sur les salles.</p>
        </div>
    <?php else: ?>
        <div class="avis-container">
            <?php foreach ($avis as $item): ?>
                <div class="avis-card">
                    <div class="avis-header">
                        <div class="avis-author">
                            <div class="author-name">
                                <?php echo htmlspecialchars($item['prenom'] . ' ' . $item['nom']); ?>
                            </div>
                            <div class="author-pseudo">
                                @<?php echo htmlspecialchars($item['pseudo']); ?>
                            </div>
                            <div class="avis-salle">
                                🏢 <strong><?php echo htmlspecialchars($item['salle_titre']); ?></strong>
                                - <?php echo htmlspecialchars($item['ville']); ?>
                            </div>
                        </div>
                        <div class="avis-rating">
                            <div class="rating-stars">
                                <?php
                                $note = $item['note'];
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $note ? '★' : '☆';
                                }
                                ?>
                            </div>
                            <div class="rating-number"><?php echo $note; ?>/5</div>
                        </div>
                    </div>

                    <div class="avis-content">
                        <?php echo nl2br(htmlspecialchars($item['commentaire'])); ?>
                    </div>

                    <div class="avis-footer">
                        <div class="avis-date">
                            📅 Publié le <?php echo date('d/m/Y à H:i', strtotime($item['date'])); ?>
                        </div>
                        <button
                            onclick="deleteAvis(<?php echo $item['id_avis']; ?>, '<?php echo htmlspecialchars($item['pseudo']); ?>')"
                            class="btn-delete">
                            ❌ Supprimer l'avis
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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
    function deleteAvis(id, pseudo) {
        if (confirm('⚠️ ATTENTION !\n\nVous êtes sur le point de supprimer l\'avis de : @' + pseudo + '\n\nCette action est IRRÉVERSIBLE !\n\nVoulez-vous vraiment continuer ?')) {
            window.location.href = '?action=delete&id=' + id;
        }
    }
</script>
<?php require "inc/bas.inc.php" ?>
