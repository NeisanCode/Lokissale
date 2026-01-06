<footer class="footer">
    <p>© LOKISALLE | </p>
    <nav>
        <a href="mentions.php">Mentions légales</a> |
        <a href="cgv.php">CGV</a> |
        <a href="plan.php">plan du site</a> |
        <a href="#" onclick="window.print()">Imprimer</a> |
        <a href="newsletter.php">s'inscire à la newsletter</a> |
        <a href="contact.php">contact</a> |
    </nav>
</footer>

<script>
    // Sélection du body et du menu
    const body = document.querySelector('body');
    const menu = document.querySelector('.menu');
    const menuToggle = document.querySelector('.menu-toggle');

    // Quand on clique sur le body
    body.addEventListener('click', (e) => {
        // Si le clic n'est pas sur le menu ou sur le bouton hamburger
        if (!menu.contains(e.target) && !menuToggle.contains(e.target)) {
            menu.classList.remove('active-menu');
        }
    });
</script>
</body>

</html>