-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: foodsafe_db
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `districtID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`districtID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,'National Capital Region (NCR)'),(2,'Cordillera Administrative Region (CAR)'),(3,'Region I - Ilocos Region'),(4,'Region II - Cagayan Valley'),(5,'Region III - Central Luzon'),(6,'Region IV-A - CALABARZON'),(7,'Region IV-B - MIMAROPA'),(8,'Region V - Bicol Region'),(9,'Region VI - Western Visayas'),(10,'Region VII - Central Visayas'),(11,'Region VIII - Eastern Visayas'),(12,'Region IX - Zamboanga Peninsula'),(13,'Region X - Northern Mindanao'),(14,'Region XI - Davao Region'),(15,'Region XII - SOCCSKSARGEN'),(16,'Region XIII - Caraga'),(17,'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspections`
--

DROP TABLE IF EXISTS `inspections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspections` (
  `inspectionID` int NOT NULL AUTO_INCREMENT,
  `inspectionDate` date NOT NULL,
  `score` float NOT NULL,
  `grade` enum('Pass','Fail') COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userID` int NOT NULL,
  `restoID` int NOT NULL,
  PRIMARY KEY (`inspectionID`),
  KEY `inspection_ibfk_1` (`userID`),
  KEY `inspection_ibfk_2` (`restoID`),
  CONSTRAINT `inspection_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `inspection_ibfk_2` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspections`
--

LOCK TABLES `inspections` WRITE;
/*!40000 ALTER TABLE `inspections` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `reportID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contactNo` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Reviewed','Dismissed') COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `restoID` int NOT NULL,
  `requirementCode` int NOT NULL,
  PRIMARY KEY (`reportID`),
  KEY `report_ibfk_1` (`restoID`),
  KEY `report_ibfk_2` (`requirementCode`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`),
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`requirementCode`) REFERENCES `requirements` (`requirementCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requirements` (
  `requirementCode` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` enum('Sanitation','Food Safety','Equipment','Pest Control','Equipment','Personnel','') COLLATE utf8mb4_general_ci NOT NULL,
  `severityLvl` enum('1','2','3','4','5') COLLATE utf8mb4_general_ci NOT NULL,
  `standardFine` int NOT NULL,
  PRIMARY KEY (`requirementCode`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirements`
--

LOCK TABLES `requirements` WRITE;
/*!40000 ALTER TABLE `requirements` DISABLE KEYS */;
INSERT INTO `requirements` VALUES (1,'Cross-contamination','Food items are contaminated through contact with raw food, dirty utensils, or unsanitary surfaces.','Food Safety','5',5000),(2,'Bare-Hand Contact with Ready to Eat Food','Employees handle ready-to-eat food with bare hands instead of using gloves or utensils.','Food Safety','4',3000),(3,'Improper Cooking Temperatures','Food is not cooked to the minimum safe internal temperature.','Food Safety','5',5000),(4,'Failure to Rapidly Cool or Reheat Foods','Food is not cooled or reheated within the required time and temperature limits.','Food Safety','4',3000),(5,'Poor Handwashing Practices','Employees fail to wash hands properly or at required times.','Sanitation','4',3000),(6,'Improper Food Storage Temperatures','Cold or hot food is stored outside the required temperature range.','Food Safety','5',5000),(7,'Pest Infestation','Evidence of rodents, insects, or other pests is present in the establishment.','Pest Control','5',10000),(8,'Expired Food Items','Expired food products are stored, displayed, or served.','Food Safety','4',3000),(9,'Dirty Kitchen Equipment','Kitchen equipment is not cleaned and sanitized properly.','Equipment','3',2000),(10,'Improper Dishwashing Techniques','Utensils and dishes are not washed, rinsed, and sanitized correctly.','Sanitation','3',2000),(11,'Cluttered or Dirty Floors','Floors are dirty, cluttered, or present slipping hazards.','Sanitation','2',1000),(12,'Inadequate Food Protection','Food is left uncovered or exposed to contamination.','Food Safety','4',3000),(13,'Improper Employee Hygiene','Employees fail to maintain proper personal cleanliness or wear appropriate protective clothing.','Personnel','4',3000),(14,'Unapproved Food Resources','Food is obtained from suppliers or sources not approved by regulatory authorities.','Food Safety','5',5000),(15,'Unclean Restrooms','Restroom facilities are unsanitary or lack soap, water, or tissue.','Sanitation','2',1000),(16,'Grease Buildup in Exhaust Systems','Exhaust hoods and ventilation systems contain excessive grease buildup.','Equipment','3',2500),(17,'Failure to Properly Label Allergens','Food products are not properly labeled with allergen information.','Food Safety','5',5000),(18,'Inadequate Training for Employees','Employees have not received the required food safety and sanitation training.','Personnel','3',2000);
/*!40000 ALTER TABLE `requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `restaurants` (
  `restoID` int NOT NULL AUTO_INCREMENT,
  `licenseNo` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contactNo` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `maps` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `districtID` int NOT NULL,
  PRIMARY KEY (`restoID`),
  KEY `restaurant_ibfk_1` (`districtID`),
  CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,123456,'Jollibee Quiapo','Quiapo, Manila','09171234567',NULL,'Jollibee_Quiapo.png',1,1),(2,234567,'Hilltop Café','Baguio City, Benguet','09181234567',NULL,'Hilltop_Cafe.png',1,2),(3,345678,'Vigan Heritage Restaurant','Vigan City, Ilocos Sur','09191234567',NULL,'Vigan_Heritage.png',1,3),(4,456789,'Cagayan Valley Grill','Tuguegarao City, Cagayan','09201234567',NULL,'Cagayan_Valley.png',1,4),(5,567891,'Kapampangan Kitchen','San Fernando, Pampanga','09211234567',NULL,'Kapampangan_Kitchen.png',1,5),(6,678912,'Lipa Food House','Lipa City, Batangas','09221234567',NULL,'Lipa_Food.png',1,6);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `districtID` int DEFAULT NULL,
  `role` enum('Admin','Inspector') COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `deleteFlag` tinyint(1) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `user_ibfk_1` (`districtID`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'marinel_llaguno@admin.com','$2y$10$PIWF4LCCZT/zeZPxJTLvQuAmJWzK6CqTAh3p9ddF9qX1WtovkEYe6','Marinel','Llaguno',NULL,'Admin','2026-07-14 14:25:36',1,0),(3,'matthew_lucas@inspector.com','$2y$10$u4uMQ.PUtl1ER56QG.iCzOMLwkMgYPFX5CT6qjo5sKK0Oxhd.iPje','Matthew','Lucas',1,'Inspector','2026-07-14 14:25:36',1,0),(4,'miguel_monterola@inspector.com','$2y$10$IkGxxYLWkG885eqG3Xc6JOmdohcA9KQVP/3MVw2Nb4AuQoQDqBWGO','Miguel','Monterola',2,'Inspector','2026-07-14 14:25:36',1,0),(5,'clarisse_nazario@inspector.com','$2y$10$U8t9hIpfdWpSlUt1G63mtuClEr78.rn/.VnwT3A1AvQjceJaw9qdK','Clarisse','Nazario',3,'Inspector','2026-07-14 14:25:36',1,0),(6,'andrea_prestoza@inspector.com','$2y$10$ItXnKjsBCmWD.EjfhAc.N.Np2ZFtUOQyxFsGYAjeGMc6E3rkwTlcm','Andrea','Prestoza',4,'Inspector','2026-07-14 14:25:36',1,0),(7,'efia_danso@inspector.com','$2y$10$jzVyBbnk4a3i30RxqcL3KuYwtYH.KnzFKq2OoNigc0QaAAceATfI.','Efia','Danso',5,'Inspector','2026-07-14 14:25:36',0,0),(8,'erik_torsten@inspector.com','$2y$10$bxH3fr1WHIai4jaat.fnTuIOiETHADmvSb8sEhvYbAF5PA1bJaWBC','Erik','Torsten',6,'Inspector','2026-07-14 14:25:36',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `violations`
--

DROP TABLE IF EXISTS `violations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `violations` (
  `violationID` int NOT NULL AUTO_INCREMENT,
  `inspectionID` int NOT NULL,
  `requirementCode` int NOT NULL,
  PRIMARY KEY (`violationID`),
  KEY `violation_ibfk_1` (`inspectionID`),
  KEY `violation_ibfk_2` (`requirementCode`),
  CONSTRAINT `violation_ibfk_1` FOREIGN KEY (`inspectionID`) REFERENCES `inspections` (`inspectionID`),
  CONSTRAINT `violation_ibfk_2` FOREIGN KEY (`requirementCode`) REFERENCES `requirements` (`requirementCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `violations`
--

LOCK TABLES `violations` WRITE;
/*!40000 ALTER TABLE `violations` DISABLE KEYS */;
/*!40000 ALTER TABLE `violations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-14 22:29:50
