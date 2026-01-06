# Documentation du Projet - Site Web de Location de Salles (LOKISALLE)

---

## 📋 Présentation du Projet

Ce projet consiste en la réalisation d’un site web complet pour une entreprise fictive de location de salles de réunion nommée **LOKISALLE**.  
Le site permet :

- **Aux visiteurs** de découvrir l’entreprise, consulter les salles disponibles, s’inscrire.
- **Aux membres** de réserver des salles, noter et commenter, gérer leur profil.
- **Aux administrateurs** de gérer salles, produits, membres, commandes, avis, promotions, statistiques et newsletter.

Le projet a été développé dans le cadre d’un TP universitaire (ESGAE 2025-2026) avec les technologies **PHP/MySQL**, **HTML/CSS** et une architecture modulaire.

---

## 🛠️ Installation et Configuration

### Prérequis

- Windows 10 ou supérieur
- PHP 8.x (téléchargeable sur [php.net](https://www.php.net/downloads.php))
- MySQL 8.x (MariaDB accepté)
- Un SGBD tel que phpMyAdmin, MySQL Workbench ou DBeaver
- Un terminal (CMD, PowerShell, Git Bash)

---

### Étape 1 : Installer PHP

1. Téléchargez PHP depuis [php.net](https://www.php.net/downloads.php)
2. Dézippez dans `C:\php`
3. Ajoutez `C:\php` aux variables d’environnement `PATH`
4. Vérifiez l’installation :

   ```cmd
   php -v
   ```

---

### Étape 2 : Cloner ou copier le projet

Placez le dossier du projet dans un répertoire accessible (ex: `C:\wamp\www\LOKISALLE`).

---

### Étape 3 : Configurer la base de données

1. Créez une base MySQL nommée `lokisalle` (ou autre).
2. Modifiez `config/database.php` avec vos identifiants :

   ```php
   $user = "root";
   $pass = "";
   $host = "localhost";
   $port = "3306";
   $dbname = "lokisalle";
   ```

3. Importez le schéma SQL :
   - Ouvrez votre SGBD
   - Importez `sql/script.sql`
   - (Optionnel) Consultez `sql/membre.sql` pour les comptes de test (mots de passe chiffrés en base)

---

### Étape 4 : Démarrer le serveur PHP

Dans le terminal, placez-vous à la racine du projet et lancez :

```cmd
php -S localhost:3000
```

---

### Étape 5 : Accéder au site

Ouvrez votre navigateur et allez sur :

```
http://localhost:3000
```

---

## 📁 Structure du projet

```
.
├── backend/          # Scripts backend (traitements, gestion admin)
├── config/           # Fichiers de configuration (connexion DB)
├── public/           # Pages accessibles aux utilisateurs
│   ├── assets/       # Images, polices
│   ├── inc/          # Inclusions communes (menu, header, footer)
│   └── *.php         # Pages frontales (accueil, réservation, etc.)
├── sql/              # Fichiers SQL pour la base
├── static/           # Feuilles de style CSS
└── index.php         Point d’entrée
```

---

## 🔐 Comptes de test (après import SQL)

| Rôle        | Email          | Mot de passe |
|-------------|----------------|--------------|
| Membre      | <test@test.fr>   | test         |
| Admin       | <admin@admin.fr> | admin        |

---

## ✅ Fonctionnalités principales

### Front-office

- **Accueil** : Présentation + dernières offres
- **Réservation** : Liste complète des salles disponibles
- **Recherche** : Filtrage par date
- **Détail produit** : Fiche complète + avis + suggestions
- **Inscription / Connexion** : Gestion de compte
- **Panier** : Réservation avec TVA + codes promo
- **Profil** : Infos personnelles + historique commandes
- **Contact** : Formulaire de message
- **Newsletter** : Abonnement (réservé aux membres)

### Back-office (admin uniquement)

- **Gestion salles** : CRUD complet
- **Gestion produits** : Ajout/modif/suppression des offres
- **Gestion membres** : Liste + suppression + création admin
- **Gestion commandes** : Consultation + chiffre d’affaires
- **Gestion avis** : Modération des commentaires
- **Gestion codes promo** : Création et association
- **Statistiques** : Top salles, membres, ventes
- **Newsletter** : Envoi groupé aux abonnés

---

## 🧪 Tests recommandés (conformité cahier des charges)

- Inscription double newsletter
- Réservation sur dates passées
- Sécurité : injection URL, accès non autorisé
- Cohérence données : suppression membre/salle → impact commandes/avis
- Chevauchement de produits sur mêmes dates
- Responsive design
- Compatibilité navigateurs

---

## ⚠️ Remarques importantes

- Le site utilise des sessions PHP pour la gestion des connexions
- Les mots de passe sont hachés (`password_hash`)
- Les dates sont gérées au format `Y-m-d`
- La TVA est fixée à 20%
- Les images sont libres de droits (mention légale incluse)
- **Ne pas utiliser en production** (TP pédagogique)

---

## 📞 Support

Pour toute question, vérifiez :

- La configuration de la base dans `config/database.php`
- L’import du fichier `sql/script.sql`
- Les logs PHP (erreurs affichées dans le terminal)

---

**Réalisé par :** Groupe de 5 étudiants - ESGAE 2025-2026  
**Encadrant :** KIGOMA Ornel, Ingénieur Informaticien

**Site Officiel :** [Lokissale](https://lokissale.infinityfree.me/?i=1)
