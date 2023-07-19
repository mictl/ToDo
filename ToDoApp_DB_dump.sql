-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: todo_db
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.22.04.2

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
                                               `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
                                               `executed_at` datetime DEFAULT NULL,
                                               `execution_time` int DEFAULT NULL,
                                               PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES ('DoctrineMigrations\\Version20230718155652','2023-07-18 17:57:36',73),('DoctrineMigrations\\Version20230718161438','2023-07-18 18:14:47',49),('DoctrineMigrations\\Version20230718164548','2023-07-18 18:46:03',301),('DoctrineMigrations\\Version20230718180946','2023-07-18 20:10:27',324),('DoctrineMigrations\\Version20230719100242','2023-07-19 12:13:29',197);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priority`
--

DROP TABLE IF EXISTS `priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `priority` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `code` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priority`
--

LOCK TABLES `priority` WRITE;
/*!40000 ALTER TABLE `priority` DISABLE KEYS */;
INSERT INTO `priority` (`id`, `code`, `name`) VALUES (1,'now','Sofort'),(2,'urgent','Dringend'),(3,'normal','Normal'),(4,'sometime','Irgendwann');
/*!40000 ALTER TABLE `priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `name`) VALUES (1,'angelegt'),(2,'begonnen'),(3,'erledigt'),(4,'storniert');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `status_id` int NOT NULL,
                        `parent_id` int DEFAULT NULL,
                        `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `project` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `text` longtext COLLATE utf8mb4_unicode_ci,
                        `priority_id` int NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `IDX_527EDB256BF700BD` (`status_id`),
                        KEY `IDX_527EDB25727ACA70` (`parent_id`),
                        KEY `IDX_527EDB25497B19F9` (`priority_id`),
                        CONSTRAINT `FK_527EDB25497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`),
                        CONSTRAINT `FK_527EDB256BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
                        CONSTRAINT `FK_527EDB25727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `status_id`, `parent_id`, `title`, `project`, `text`, `priority_id`) VALUES (7,1,NULL,'Kunde anrufen','ABC 1234','Hat mehrmals angerufen und bittet um dringenden Rückruf',1),(8,2,NULL,'Konzept schreiben','P12345667','Zusammenfassung der Vorgehensweise auf ca. 2-4 Seiten.',3),(9,1,NULL,'Lastenheft prüfen','A12345','Gegenlesen des Lastenhefts auf eventuelle Fehler oder Ungenauigkeiten',2),(10,1,8,'Meilensteine festlegen','P12345667','Welche Zwischenschritte, in welcher Abfolge, mit welchen Beteiligten, zu welchen Terminen',4),(11,2,NULL,'Funktion getBasketProducts() ergänzen','SHOP XY','Zukünftig sollen dort auch die jeweiligen Produktbild in Thumbnail-Größe mit übergeben werden.',2);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-19 21:31:03
