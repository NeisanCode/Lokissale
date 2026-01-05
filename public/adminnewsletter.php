<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/adminnewsletter.php";
?>
<main class="container-large">
    <section class="newsletter-admin">
        <h2>> Envoyer la newsletter</h2>

        <div class="newsletter-stats">
            <p>Nombre d'abonnés à la newsletter : <span
                    id="nb-abonnes"><?php echo isset($nb_abonnes) ? $nb_abonnes : '0'; ?></span>.</p>
        </div>

        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="message error"><?php echo $_SESSION['erreur'];
            unset($_SESSION['erreur']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['succes'])): ?>
            <div class="message success"><?php echo $_SESSION['succes'];
            unset($_SESSION['succes']); ?></div>
        <?php endif; ?>

        <form id="form-newsletter" class="newsletter-form" method="POST" action="traitement_newsletter.php">
            <div class="form-group">
                <label for="expediteur">Expéditeur :</label>
                <input type="email" id="expediteur" name="expediteur" value="contact@lokisalle.fr" required>
            </div>

            <div class="form-group">
                <label for="sujet">Sujet :</label>
                <input type="text" id="sujet" name="sujet" placeholder="Sujet de la newsletter" required>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea id="message" name="message" rows="10" placeholder="Rédigez le contenu de votre newsletter..."
                    required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-envoyer">Envoyer la newsletter aux membres</button>
                <button type="button" class="btn-preview" onclick="previewNewsletter()">Aperçu</button>
                <button type="reset" class="btn-reset">Effacer</button>
            </div>
        </form>

        <!-- Section d'aperçu -->
        <div id="preview-section" class="preview-section" style="display: none;">
            <h3>Aperçu de la newsletter</h3>
            <div class="preview-content">
                <h4 id="preview-sujet"></h4>
                <div id="preview-message"></div>
                <p class="preview-footer">Cet email vous a été envoyé par LOKISALLE. Pour vous désabonner, <a
                        href="#">cliquez ici</a>.</p>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <p>● LOKISALLE | </p>
    <nav>
        <a href="mentions.php">Mentions légales</a>
        <a href="cgv.php">CGV</a>
        <a href="plan.php">plan du site</a>
        <a href="#" onclick="window.print()">Imprimer</a>
        <a href="newsletter.php">s'inscrire à la newsletter</a>
        <a href="contact.php">contact</a>
    </nav>
</footer>

<script>
    // Vérification que l'utilisateur est administrateur
    document.addEventListener('DOMContentLoaded', function () {
        // Récupération du nombre d'abonnés (simulation)
        fetchNombreAbonnes();
    });

    function fetchNombreAbonnes() {
        // En réalité, cela ferait un appel à un script PHP
        // Pour l'exemple, nous gardons la valeur affichée par PHP
    }

    function previewNewsletter() {
        const sujet = document.getElementById('sujet').value;
        const message = document.getElementById('message').value;

        if (!sujet || !message) {
            alert('Veuillez remplir le sujet et le message avant de prévisualiser.');
            return;
        }

        document.getElementById('preview-sujet').textContent = sujet;
        document.getElementById('preview-message').innerHTML = message.replace(/\n/g, '<br>');

        document.getElementById('preview-section').style.display = 'block';

        // Scroll vers l'aperçu
        document.getElementById('preview-section').scrollIntoView({ behavior: 'smooth' });
    }

    function deconnexion() {
        if (confirm('Voulez-vous vraiment vous déconnecter ?')) {
            window.location.href = 'deconnexion.php';
        }
    }

    // Gestion de la soumission du formulaire
    document.getElementById('form-newsletter').addEventListener('submit', function (e) {
        const sujet = document.getElementById('sujet').value;
        const message = document.getElementById('message').value;

        if (!sujet || !message) {
            alert('Veuillez remplir tous les champs.');
            e.preventDefault();
            return;
        }

        if (!confirm('Êtes-vous sûr de vouloir envoyer cette newsletter à tous les abonnés ?')) {
            e.preventDefault();
            return;
        }
    });
</script>

<?php require "inc/bas.inc.php"; ?>