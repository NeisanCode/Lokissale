<?php 
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/gestionstat.php" 
?>

<main class="admin-container">
    <!-- En-tête admin -->
    <div class="admin-header">
        <h2>📊 Statistiques Globales</h2>
        <p style="margin: 10px 0 0 0;">Tableau de bord et analyses complètes de LOKISALLE</p>
    </div>

    <!-- Menu de sélection -->
    <div class="stats-menu">
        <a href="?view=all" class="stats-menu-btn <?php echo $statView === 'all' ? 'active' : ''; ?>">
            📈 Vue d'ensemble
        </a>
        <a href="?view=membres" class="stats-menu-btn <?php echo $statView === 'membres' ? 'active' : ''; ?>">
            👥 Membres
        </a>
        <a href="?view=commandes" class="stats-menu-btn <?php echo $statView === 'commandes' ? 'active' : ''; ?>">
            💰 Chiffre d'affaires
        </a>
    </div>

    <!-- VUE D'ENSEMBLE -->
    <div class="stats-section <?php echo $statView === 'all' ? 'active' : ''; ?>">
        <h3 style="margin-bottom: 20px; color: #2c3e50;">📊 Statistiques Générales</h3>

        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon">👥</div>
                <div class="stat-value"><?php echo $statsMembres['total']; ?></div>
                <div class="stat-label">Membres Inscrits</div>
            </div>

            <div class="stat-card" style="border-left-color: #9b59b6;">
                <div class="stat-icon">🏢</div>
                <div class="stat-value"><?php echo $statsSalles['total']; ?></div>
                <div class="stat-label">Salles Disponibles</div>
            </div>

            <div class="stat-card" style="border-left-color: #1abc9c;">
                <div class="stat-icon">📦</div>
                <div class="stat-value"><?php echo $statsProduits['total']; ?></div>
                <div class="stat-label">Produits Créés</div>
            </div>

            <div class="stat-card" style="border-left-color: #f39c12;">
                <div class="stat-icon">🛒</div>
                <div class="stat-value"><?php echo $statsCommandes['total']; ?></div>
                <div class="stat-label">Commandes Totales</div>
            </div>

            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-icon">💶</div>
                <div class="stat-value"><?php echo number_format($statsCommandes['ca_total'], 0, ',', ' '); ?> €
                </div>
                <div class="stat-label">Chiffre d'Affaires</div>
            </div>

            <div class="stat-card" style="border-left-color: #e67e22;">
                <div class="stat-icon">⭐</div>
                <div class="stat-value"><?php echo number_format($statsAvis['moyenne'], 1); ?>/5</div>
                <div class="stat-label">Note Moyenne</div>
            </div>

            <div class="stat-card" style="border-left-color: #e74c3c;">
                <div class="stat-icon">🎁</div>
                <div class="stat-value"><?php echo $statsPromos['total']; ?></div>
                <div class="stat-label">Codes Promo</div>
            </div>

            <div class="stat-card" style="border-left-color: #16a085;">
                <div class="stat-icon">📧</div>
                <div class="stat-value"><?php echo $statsNewsletter['total']; ?></div>
                <div class="stat-label">Abonnés Newsletter</div>
            </div>
        </div>

        <!-- Graphiques en deux colonnes -->
        <div class="two-columns">
            <!-- Salles par ville -->
            <div class="chart-container">
                <div class="chart-title">🏙️ Répartition des salles par ville</div>
                <div class="bar-chart">
                    <?php
                    $maxSalles = max(array_column($sallesParVille, 'nb'));
                    foreach ($sallesParVille as $item):
                        $percentage = ($item['nb'] / $maxSalles) * 100;
                        ?>
                        <div class="bar-item">
                            <div class="bar-label"><?php echo $item['ville']; ?></div>
                            <div class="bar-visual" style="width: <?php echo $percentage; ?>%;">
                                <span class="bar-value"><?php echo $item['nb']; ?>
                                    salle<?php echo $item['nb'] > 1 ? 's' : ''; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Répartition avis -->
            <div class="chart-container">
                <div class="chart-title">⭐ Répartition des notes (<?php echo $statsAvis['total']; ?> avis)</div>
                <div>
                    <?php
                    $notes = [
                        5 => $statsAvis['note5'],
                        4 => $statsAvis['note4'],
                        3 => $statsAvis['note3'],
                        2 => $statsAvis['note2'],
                        1 => $statsAvis['note1']
                    ];
                    foreach ($notes as $note => $count):
                        $percentage = $statsAvis['total'] > 0 ? ($count / $statsAvis['total']) * 100 : 0;
                        ?>
                        <div class="progress-ring">
                            <span
                                style="width: 80px; font-weight: bold;"><?php echo str_repeat('★', $note) . str_repeat('☆', 5 - $note); ?></span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                            </div>
                            <span style="min-width: 60px; text-align: right; font-weight: bold;"><?php echo $count; ?>
                                (<?php echo number_format($percentage, 0); ?>%)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Top salles -->
        <div class="table-container">
            <div class="table-header">
                <h3>🏆 Top 5 des salles les mieux notées</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Salle</th>
                        <th>Ville</th>
                        <th>Nombre d'avis</th>
                        <th>Note Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topSalles as $index => $salle): ?>
                        <tr>
                            <td>
                                <span class="rank-badge rank-<?php echo $index < 3 ? ($index + 1) : 'other'; ?>">
                                    <?php echo $index + 1; ?>
                                </span>
                            </td>
                            <td><strong><?php echo htmlspecialchars($salle['titre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($salle['ville']); ?></td>
                            <td><?php echo $salle['nb_avis']; ?> avis</td>
                            <td>
                                <span class="star-rating">
                                    <?php
                                    $note = round($salle['note_moyenne']);
                                    echo str_repeat('★', $note) . str_repeat('☆', 5 - $note);
                                    ?>
                                </span>
                                <strong><?php echo number_format($salle['note_moyenne'], 1); ?>/5</strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- VUE MEMBRES -->
    <div class="stats-section <?php echo $statView === 'membres' ? 'active' : ''; ?>">
        <h3 style="margin-bottom: 20px; color: #2c3e50;">👥 Statistiques Membres</h3>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value"><?php echo $statsMembres['total']; ?></div>
                <div class="stat-label">Total Membres</div>
            </div>

            <div class="stat-card" style="border-left-color: #f39c12;">
                <div class="stat-icon">⭐</div>
                <div class="stat-value"><?php echo $statsMembres['admins']; ?></div>
                <div class="stat-label">Administrateurs</div>
            </div>

            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon">👤</div>
                <div class="stat-value"><?php echo $statsMembres['users']; ?></div>
                <div class="stat-label">Utilisateurs</div>
            </div>

            <div class="stat-card" style="border-left-color: #16a085;">
                <div class="stat-icon">📧</div>
                <div class="stat-value"><?php echo $statsNewsletter['total']; ?></div>
                <div class="stat-label">Abonnés Newsletter</div>
            </div>
        </div>

        <!-- Top clients -->
        <div class="table-container">
            <div class="table-header">
                <h3>🏆 Top 5 des meilleurs clients</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Pseudo</th>
                        <th>Nom Complet</th>
                        <th>Commandes</th>
                        <th>Total Dépensé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topClients as $index => $client): ?>
                        <tr>
                            <td>
                                <span class="rank-badge rank-<?php echo $index < 3 ? ($index + 1) : 'other'; ?>">
                                    <?php echo $index + 1; ?>
                                </span>
                            </td>
                            <td><strong>@<?php echo htmlspecialchars($client['pseudo']); ?></strong></td>
                            <td><?php echo htmlspecialchars($client['prenom'] . ' ' . $client['nom']); ?></td>
                            <td><?php echo $client['nb_commandes']; ?>
                                commande<?php echo $client['nb_commandes'] > 1 ? 's' : ''; ?></td>
                            <td><strong><?php echo number_format($client['total_depense'], 0, ',', ' '); ?> €</strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- VUE CHIFFRE D'AFFAIRES -->
    <div class="stats-section <?php echo $statView === 'commandes' ? 'active' : ''; ?>">
        <h3 style="margin-bottom: 20px; color: #2c3e50;">💰 Statistiques Chiffre d'Affaires</h3>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🛒</div>
                <div class="stat-value"><?php echo $statsCommandes['total']; ?></div>
                <div class="stat-label">Total Commandes</div>
            </div>

            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-icon">💶</div>
                <div class="stat-value"><?php echo number_format($statsCommandes['ca_total'], 0, ',', ' '); ?> €
                </div>
                <div class="stat-label">CA Total</div>
            </div>

            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon">📊</div>
                <div class="stat-value"><?php echo number_format($statsCommandes['panier_moyen'], 0, ',', ' '); ?> €
                </div>
                <div class="stat-label">Panier Moyen</div>
            </div>

            <div class="stat-card" style="border-left-color: #e67e22;">
                <div class="stat-icon">📈</div>
                <div class="stat-value"><?php echo number_format($statsCommandes['montant_max'], 0, ',', ' '); ?> €
                </div>
                <div class="stat-label">Commande Max</div>
            </div>
        </div>

        <!-- Évolution CA -->
        <div class="chart-container">
            <div class="chart-title">📈 Évolution du chiffre d'affaires (6 derniers mois)</div>
            <div class="bar-chart">
                <?php
                $maxCA = max(array_column($commandesParMois, 'ca'));
                foreach ($commandesParMois as $item):
                    $percentage = ($item['ca'] / $maxCA) * 100;
                    $moisFormate = date('M Y', strtotime($item['mois'] . '-01'));
                    ?>
                    <div class="bar-item">
                        <div class="bar-label"><?php echo $moisFormate; ?></div>
                        <div class="bar-visual"
                            style="width: <?php echo $percentage; ?>%; background: linear-gradient(90deg, #27ae60 0%, #229954 100%);">
                            <span class="bar-value"><?php echo number_format($item['ca'], 0, ',', ' '); ?> €
                                (<?php echo $item['nb_commandes']; ?> cmd)</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Détails -->
        <div class="two-columns">
            <div class="chart-container">
                <div class="chart-title">📊 Détails des commandes</div>
                <div style="line-height: 2;">
                    <p><strong>Total des commandes :</strong> <?php echo $statsCommandes['total']; ?></p>
                    <p><strong>Chiffre d'affaires total :</strong>
                        <?php echo number_format($statsCommandes['ca_total'], 2, ',', ' '); ?> €</p>
                    <p><strong>Panier moyen :</strong>
                        <?php echo number_format($statsCommandes['panier_moyen'], 2, ',', ' '); ?> €</p>
                    <p><strong>Commande minimale :</strong>
                        <?php echo number_format($statsCommandes['montant_min'], 2, ',', ' '); ?> €</p>
                    <p><strong>Commande maximale :</strong>
                        <?php echo number_format($statsCommandes['montant_max'], 2, ',', ' '); ?> €</p>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-title">🎯 Produits</div>
                <div style="line-height: 2;">
                    <p><strong>Total produits :</strong> <?php echo $statsProduits['total']; ?></p>
                    <p><strong>Produits disponibles :</strong> <span
                            style="color: #27ae60; font-weight: bold;"><?php echo $statsProduits['disponibles']; ?></span>
                    </p>
                    <p><strong>Produits réservés :</strong> <span
                            style="color: #e74c3c; font-weight: bold;"><?php echo $statsProduits['reserves']; ?></span>
                    </p>
                    <p><strong>Taux de réservation :</strong>
                        <?php echo number_format(($statsProduits['reserves'] / $statsProduits['total']) * 100, 1); ?>%
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Animation des barres de progression au chargement
    window.addEventListener('load', function () {
        const progressBars = document.querySelectorAll('.progress-fill');
        progressBars.forEach(bar => {
            const targetWidth = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 100);
        });

        const barVisuals = document.querySelectorAll('.bar-visual');
        barVisuals.forEach(bar => {
            const targetWidth = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = targetWidth;
            }, 200);
        });
    });
</script>
<?php require "inc/bas.inc.php" ?>