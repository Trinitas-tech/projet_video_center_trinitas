-- MySQL dump 10.13  Distrib 9.1.0, for Win64 (x86_64)
--
-- Host: localhost    Database: video_center_trinitas_db
-- ------------------------------------------------------
-- Server version	9.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20260819174644','2026-08-19 17:47:19',39),('DoctrineMigrations\\Version20260819203421','2026-08-19 20:35:28',76),('DoctrineMigrations\\Version20260820100000','2026-08-20 08:28:38',85),('DoctrineMigrations\\Version20260820082838','2026-08-20 08:28:50',82);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` VALUES (1,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:167:\\\"http://127.0.0.1:8765/verify/email?expires=1787233082&signature=9vl0hm8SUAwejwVPht2%2BpRhZbw0iK%2Bn7teHAoKYSVR0%3D&token=OFmJF3ZZA7eBhyOqxSfS8GYPw1q0py8ZBSA726XLdR8%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:5;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:27:\\\"no-reply@video-center.local\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:13:\\\"Vidéo Center\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:19:\\\"nouveau@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:29:\\\"Confirmez votre adresse email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}','[]','default','2026-08-20 08:38:03','2026-08-20 08:38:03',NULL);
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `requested_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
INSERT INTO `reset_password_request` VALUES (1,'5e7TTkwBTlaxepLVJBQL','DO9ajx7KMUP7EENtNTm7nmLmwABr56HEHN1lII6PZNM=','2026-08-20 09:10:01','2026-08-20 10:10:01',5);
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_verified` tinyint NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'trinitas@cfitech.be','[]','$2y$13$YZVb3LKQQpFHbJl3NROK0udLLTsy1zRx6e8.QfGqnXtOe77O2xn/q','Trinitas','Ntirampeba','2026-08-20 08:35:38','2026-08-20 08:35:38',1,NULL),(5,'jean.dupont@example.com','[]','$2y$13$58mM/vHDh27gPCVWG2w.wuwyNsaXg2kOUkyAYob92jzQagOlDQftS','Jean','Dupont','2026-08-20 08:35:39','2026-08-20 08:35:39',1,NULL),(6,'marie.martin@example.com','[]','$2y$13$K6k/wDhLpo2g3jDE2835MumsZNi79f0M5J4/64ceqcjiIt.1Ijpdu','Marie','Martin','2026-08-20 08:35:39','2026-08-20 08:37:50',1,'avatar-test-6a86bcde2358e458794786.png'),(7,'paul.durand@example.com','[]','$2y$13$jQgGjB4vI.XFJJgs2ei1E.WU7ixy5aODkJVc4cM.iHMPFfxml6y0W','Paul','Durand','2026-08-20 08:35:39','2026-08-20 08:35:39',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  `premium_video` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29AA6432A76ED395` (`user_id`),
  CONSTRAINT `FK_7CC7DA2CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (3,'Ngwiza','https://www.youtube.com/watch?v=ho_IGrAkUSs','Première vidéo de mon propre site Vidéo Center.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(4,'NGWIZA - Ballet Royal du Burundi','https://www.youtube.com/watch?v=ho_IGrAkUSs','Performance du Ballet Royal du Burundi, remix BGM du chant traditionnel Ngwiza.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(5,'Never Gonna Give You Up','https://www.youtube.com/watch?v=dQw4w9WgXcQ','Le clip culte de Rick Astley qui a marqué toute une génération.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(6,'Gangnam Style','https://www.youtube.com/watch?v=9bZkp7q19f0','Le phénomène mondial de PSY qui a battu tous les records de vues.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(7,'Despacito','https://www.youtube.com/watch?v=kJQP7kiw5Fk','Luis Fonsi et Daddy Yankee dans le tube latino le plus écouté au monde.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(8,'Shape of You','https://www.youtube.com/watch?v=JGwWNGJdvx8','Ed Sheeran avec son hit incontournable de l\'année 2017.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(9,'See You Again','https://www.youtube.com/watch?v=RgKAFK5djSk','Wiz Khalifa et Charlie Puth pour l\'hommage émouvant de Fast and Furious 7.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(10,'Uptown Funk','https://www.youtube.com/watch?v=OPf0YbXqDm0','Mark Ronson et Bruno Mars dans un clip funky plein d\'énergie.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,0),(11,'Roar','https://www.youtube.com/watch?v=CevxZvSJLk8','Katy Perry dans la jungle avec ce clip spectaculaire et coloré.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(12,'Counting Stars','https://www.youtube.com/watch?v=hT_nvWreIhg','OneRepublic et leur titre entraînant devenu un classique moderne.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(13,'Hello','https://www.youtube.com/watch?v=YQHsXMglC9A','Adele fait son grand retour avec cette ballade puissante et émouvante.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(14,'Sugar','https://www.youtube.com/watch?v=09R8_2nJtjg','Maroon 5 s\'invite par surprise dans des mariages à travers ce clip.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(15,'Bohemian Rhapsody','https://www.youtube.com/watch?v=fJ9rUzIMcZQ','Le chef-d\'œuvre intemporel de Queen, une œuvre unique en son genre.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(16,'Blank Space','https://www.youtube.com/watch?v=e-ORhEE9VVg','Taylor Swift dans un manoir somptueux pour ce clip devenu iconique.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(17,'Waka Waka','https://www.youtube.com/watch?v=pRpeEdMmmQ0','Shakira et l\'hymne officiel de la Coupe du Monde 2010 en Afrique du Sud.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(18,'Radioactive','https://www.youtube.com/watch?v=ktvTqknDobU','Imagine Dragons dans un clip sombre et mystérieux plein de surprises.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(19,'Faded','https://www.youtube.com/watch?v=60ItHLz5WEA','Alan Walker et son titre électro mélancolique connu dans le monde entier.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(20,'Thinking Out Loud','https://www.youtube.com/watch?v=lp-EO5I60KA','Ed Sheeran danse dans cette ballade romantique pleine de douceur.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(21,'Perfect','https://www.youtube.com/watch?v=2Vv-BfVoq4g','La déclaration d\'amour d\'Ed Sheeran dans un décor enneigé magnifique.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1),(22,'Take On Me','https://www.youtube.com/watch?v=djV11Xbc914','Le clip d\'animation révolutionnaire de A-ha, un classique des années 80.','2026-08-20 08:35:39','2026-08-20 08:35:39',4,1);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-21 13:07:03

