<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/recherche.php"; // Inclure la logique de traitement
require "../backend/salle.php";
?>

<main class="container-large">
    <!-- Présentation -->
    <section class="bienvenue">
        <h2>Rechercher une salle disponible</h2>
        <p>Utilisez le formulaire ci-dessous pour rechercher une salle disponible selon vos dates de réservation.</p>
    </section>

    <!-- Formulaire de recherche -->
    <section class="recherche-form">
        <form method="GET" action="">
            <label for="date_arrivee">Date d'arrivée</label>
            <input type="date" id="date_arrivee" name="date_arrivee"
                value="<?= isset($_GET['date_arrivee']) ? htmlspecialchars($_GET['date_arrivee']) : '' ?>">

            <label for="date_depart">Date de départ</label>
            <input type="date" id="date_depart" name="date_depart"
                value="<?= isset($_GET['date_depart']) ? htmlspecialchars($_GET['date_depart']) : '' ?>">
            <label for="name">Nom</label>

            <input type="text" name="titre" placeholder="Recherche par nom">

            <button type="submit">Rechercher</button>
        </form>
    </section>

    <!-- Résultats de recherche -->
    <section class="offres" style="margin-top:40px;">
        <h3>Résultats de la recherche</h3>

        <div class="offres-grid">
            <?php foreach ($salles as $salle): ?>
                <?= createOfferRoom(
                    $salle["photo"],
                    $salle["titre"],
                    $salle["ville"],
                    $salle["description"],
                    $date_depart,
                    $date_arrivee,
                    $salle["capacite"],
                    $salle["prix"],
                    $salle["id_produit"]
                ) ?>
            <?php endforeach; ?>
        </div>


        <?php if ($message): ?>
            <div style="padding: 10px; border-radius: 5px; margin:20px 0; text-align: center; 
                <?= $message_type === 'error' ? 'background-color: #f8d7da; color: #721c24;' : "" ?>
                <?= $message_type === 'success' ? 'background-color: #d4edda; color: #155724;' : "" ?>">
                <?= $message ?>
            </div>

        <?php endif; ?>
    </section>
</main>

<?php require "inc/bas.inc.php"; ?>