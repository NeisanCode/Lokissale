<?php
require "inc/haut.inc.php";
require "inc/menu.inc.php";
require "../backend/deconnexion.php";
?>
<main class="container">
    <div class="deconnexion-container">
        <div class="deconnexion-icon">👋</div>
        <h2>Déconnexion</h2>
        <div class="deconnexion-message">
            <?php if (isset($_SESSION["membre"]['pseudo'])): ?>
                <p>Vous êtes connecté en tant que <span
                        class="deconnexion-pseudo"><?php echo htmlspecialchars($_SESSION["membre"]['pseudo']); ?></span>.
                </p>
            <?php endif; ?>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
        </div>

        <form method="POST" action="">
            <div class="deconnexion-buttons">
                <button type="submit" name="confirm_deconnexion" class="btn-confirm">
                    Oui, me déconnecter
                </button>
                <a href="javascript:history.back()" class="btn-cancel">
                    Non, annuler
                </a>
            </div>
        </form>

        <div class="countdown" id="countdown">
            Redirection automatique dans <span id="seconds">10</span> secondes...
        </div>
    </div>
</main>
<script>
    // Compte à rebours pour redirection automatique
    let seconds = 10;
    const countdownElement = document.getElementById('seconds');
    const countdownContainer = document.getElementById('countdown');

    const countdown = setInterval(function () {
        seconds--;
        countdownElement.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(countdown);
            // Redirection automatique vers l'accueil
            window.location.href = 'home.php';
        }
    }, 1000);

    // Annuler le compte à rebours si l'utilisateur interagit
    document.addEventListener('click', function () {
        clearInterval(countdown);
        countdownContainer.style.display = 'none';
    });
</script>
<?php require "inc/bas.inc.php" ?>