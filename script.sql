/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: lokissale
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `avis` (
  `id_avis` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre` int(11) DEFAULT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `note` tinyint(4) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_avis`),
  KEY `id_membre` (`id_membre`),
  KEY `id_salle` (`id_salle`),
  CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES
(1,2,1,'Salle très agréable et bien équipée.',5,'2025-12-20 17:52:35'),
(2,3,4,'Très belle salle, cadre professionnel.',4,'2025-12-20 17:52:35'),
(3,4,2,'Bonne expérience, personnel accueillant.',4,'2025-12-20 17:52:35'),
(4,5,5,'Salle très bien située, idéale pour petits groupes.',5,'2025-12-20 17:52:45'),
(5,6,6,'Grande salle, parfaite pour nos conférences.',4,'2025-12-20 17:52:45'),
(6,7,7,'Très bon rapport qualité/prix.',4,'2025-12-20 17:52:45'),
(7,8,2,'Salle agréable mais un peu bruyante.',3,'2025-12-20 17:52:45');
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `montant` int(11) DEFAULT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_membre` (`id_membre`),
  CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES
(1,550,2,'2025-12-20 17:52:35'),
(2,700,3,'2025-12-20 17:52:35'),
(3,480,5,'2025-12-20 17:52:45'),
(4,900,6,'2025-12-20 17:52:45'),
(5,620,7,'2025-12-20 17:52:45');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

--
-- Table structure for table `details_commande`
--

DROP TABLE IF EXISTS `details_commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `details_commande` (
  `id_details_commande` int(11) NOT NULL AUTO_INCREMENT,
  `id_commande` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_details_commande`),
  KEY `id_commande` (`id_commande`),
  KEY `id_produit` (`id_produit`),
  CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `details_commande`
--

/*!40000 ALTER TABLE `details_commande` DISABLE KEYS */;
INSERT INTO `details_commande` VALUES
(1,1,2),
(2,2,5),
(3,3,6),
(4,4,7),
(5,5,10);
/*!40000 ALTER TABLE `details_commande` ENABLE KEYS */;

--
-- Table structure for table `membre`
--

DROP TABLE IF EXISTS `membre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) DEFAULT NULL,
  `mdp` varchar(60) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `sexe` enum('Masculin','Feminin') DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `statut` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre`
--

/*!40000 ALTER TABLE `membre` DISABLE KEYS */;
INSERT INTO `membre` VALUES
(1,'admin','admin123','Dupont','Jean','admin@lokisalle.fr','Masculin','Paris','75015','300 Bd Vaugirard',1),
(2,'alice','alice123','Martin','Alice','alice@gmail.com','Feminin','Lyon','69003','12 rue de la République',0),
(3,'paul','paul123','Durand','Paul','paul@gmail.com','Masculin','Marseille','13001','8 rue Canebière',0),
(4,'sophie','sophie123','Lemoine','Sophie','sophie@gmail.com','Feminin','Paris','75010','22 rue Lafayette',0),
(5,'luc','luc123','Bernard','Luc','luc@gmail.com','Masculin','Lyon','69007','7 rue Victor Hugo',0),
(6,'emma','emma123','Petit','Emma','emma@gmail.com','Feminin','Paris','75012','15 rue Daumesnil',0),
(7,'nicolas','nico123','Moreau','Nicolas','nicolas@gmail.com','Masculin','Marseille','13008','40 avenue Prado',0),
(8,'claire','claire123','Roux','Claire','claire@gmail.com','Feminin','Lyon','69006','3 rue Garibaldi',0);
/*!40000 ALTER TABLE `membre` ENABLE KEYS */;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_newsletter`),
  KEY `id_membre` (`id_membre`),
  CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter`
--

/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
INSERT INTO `newsletter` VALUES
(1,2),
(2,3),
(3,4),
(4,5),
(5,6),
(6,7);
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `date_arrivee` datetime DEFAULT NULL,
  `date_depart` datetime DEFAULT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `id_promotion` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `etat` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `id_salle` (`id_salle`),
  KEY `id_promotion` (`id_promotion`),
  CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`),
  CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`id_promotion`) REFERENCES `promotion` (`id_promotion`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES
(1,'2025-02-10 09:00:00','2025-02-12 18:00:00',1,1,500,0),
(2,'2025-02-15 09:00:00','2025-02-18 18:00:00',1,NULL,550,0),
(3,'2025-03-05 09:00:00','2025-03-07 18:00:00',2,2,800,0),
(4,'2025-03-10 09:00:00','2025-03-12 18:00:00',3,NULL,600,0),
(5,'2025-04-01 09:00:00','2025-04-03 18:00:00',4,3,700,0),
(6,'2025-05-05 09:00:00','2025-05-07 18:00:00',5,NULL,450,0),
(7,'2025-05-10 09:00:00','2025-05-12 18:00:00',5,1,480,0),
(8,'2025-05-15 09:00:00','2025-05-18 18:00:00',6,2,900,0),
(9,'2025-06-01 09:00:00','2025-06-03 18:00:00',6,NULL,850,0),
(10,'2025-06-10 09:00:00','2025-06-12 18:00:00',7,3,650,0),
(11,'2025-06-20 09:00:00','2025-06-22 18:00:00',7,NULL,620,0);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion` (
  `id_promotion` int(11) NOT NULL AUTO_INCREMENT,
  `code_promo` varchar(20) DEFAULT NULL,
  `reduction` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_promotion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
INSERT INTO `promotion` VALUES
(1,'PROMO10',10),
(2,'PROMO20',20),
(3,'VIP30',30);
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `salle` (
  `id_salle` int(11) NOT NULL AUTO_INCREMENT,
  `pays` varchar(100) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salle`
--

/*!40000 ALTER TABLE `salle` DISABLE KEYS */;
INSERT INTO `salle` VALUES
(1,'France','Paris','10 rue de Rivoli','75001','Salle Cézanne','Salle moderne et lumineuse, idéale pour vos réunions professionnelles, séminaires et événements d’entreprise. Elle offre un cadre confortable et inspirant pour travailler efficacement. Équipée d’un vidéoprojecteur, système audio, wifi haut débit et climatisation.','cezanne.jpg',30),
(2,'France','Paris','25 avenue Montaigne','75008','Salle Monet','Salle baignée de lumière naturelle, parfaite pour ateliers, séminaires et rencontres professionnelles. Son ambiance calme favorise la concentration et les échanges. Dispose de vidéoprojecteur, audio performant, wifi et climatisation.','monet.jpg',50),
(3,'France','Lyon','5 place Bellecour','69002','Salle Picasso','Salle élégante et spacieuse, adaptée aux conférences, workshops et événements d’entreprise. Son design raffiné crée un environnement stimulant pour vos participants. Équipée de technologies modernes : vidéo, son, wifi et climatisation.','picasso.jpg',40),
(4,'France','Marseille','18 quai du Port','13002','Salle Mozart','Salle avec vue sur le port, idéale pour réunions et événements professionnels. L’espace lumineux et accueillant facilite la créativité et la collaboration. Moderne et équipée : vidéoprojecteur, audio, wifi haut débit et climatisation.','mozart.jpg',35),
(5,'France','Paris','8 rue Oberkampf','75011','Salle Renoir','Salle conviviale et fonctionnelle, parfaite pour réunions, formations et ateliers. Elle combine confort et modernité pour un environnement de travail agréable. Dispose de toutes les technologies nécessaires : vidéo, son, wifi et climatisation.','renoir.jpg',25),
(6,'France','Lyon','20 rue de la Part-Dieu','69003','Salle Matisse','Salle spacieuse et moderne, parfaite pour conférences, séminaires et événements d’entreprise. Son aménagement optimise le confort et la productivité. Équipée des dernières technologies : vidéoprojecteur, système audio, wifi et climatisation.','matisse.jpg',60),
(7,'France','Marseille','12 boulevard Longchamp','13001','Salle Debussy','Salle contemporaine et chaleureuse, adaptée aux réunions et événements professionnels. L’ambiance est à la fois professionnelle et accueillante. Dotée de technologies performantes : vidéo, audio, wifi et climatisation.','debussy.jpg',45);
/*!40000 ALTER TABLE `salle` ENABLE KEYS */;

--
-- Dumping routines for database 'lokissale'
--
