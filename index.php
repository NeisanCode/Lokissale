<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOKISALLE - Présentation</title>
    <link rel="stylesheet" href="./static/presentation.css">
</head>

<body>
    <div class="card">
        <h1>LOKISALLE</h1>
        <p class="subtitle">Location de salles en ligne</p>

        <p>Ce site a été développé dans le cadre d'un projet pédagogique sur le développement web avec PHP et MySQL.</p>

        <p>Il simule une plateforme de location de salles avec un système complet de réservation, gestion des membres et
            administration.</p>

        <a href="/public/home.php" class="btn">Accéder au site</a>
        <div class="main-container">
            <div class="teacher-section">
                <h3>Professeur</h3>
                <li>
                    <span class="teacher-name">Kigoma Ornel</span>
                </li>
            </div>
            <!-- Section des étudiants -->
            <div class="students-section">
                <h3>Équipe de développement</h3>
                <ul class="students-list">
                    <li>
                        <span class="student-number">1</span>
                        <span class="student-name">PONGUI Nathan Mignon Bonheur</span>
                    </li>
                    <li>
                        <span class="student-number">2</span>
                        <span class="student-name">TSOLO Reine Esther Bénicia</span>
                    </li>
                    <li>
                        <span class="student-number">3</span>
                        <span class="student-name">DONGOU Rafic Lamourdi Dubois</span>
                    </li>
                    <li>
                        <span class="student-number">4</span>
                        <span class="student-name">OLANDZOBO Soleil LeBlanc</span>
                    </li>
                    <li>
                        <span class="student-number">5</span>
                        <span class="student-name">OKONGO Ewhowké Fidèle Hénock</span>
                    </li>
                </ul>
            </div>
        </div>


        <div class="note">
            <strong>Information :</strong> Ce site est une démonstration et n'a pas de but commercial. Toutes les
            données sont factices.
        </div>

        <div class="footer">
            Projet étudiant - ESGAE 2025-2026
        </div>
    </div>

    <script>
        // Animation simple pour l'apparition des éléments
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.card > *');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 * index);
            });

            // Animation pour les étudiants
            const students = document.querySelectorAll('.students-list li');
            students.forEach((student, index) => {
                student.style.opacity = '0';
                student.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    student.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    student.style.opacity = '1';
                    student.style.transform = 'translateX(0)';
                }, 300 + (100 * index));
            });
        });
    </script>
</body>

</html>