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
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
  `grade` enum('A','B','C','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userID` int NOT NULL,
  `restoID` int NOT NULL,
  PRIMARY KEY (`inspectionID`),
  KEY `inspection_ibfk_1` (`userID`),
  KEY `inspection_ibfk_2` (`restoID`),
  CONSTRAINT `inspection_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `inspection_ibfk_2` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspections`
--

LOCK TABLES `inspections` WRITE;
/*!40000 ALTER TABLE `inspections` DISABLE KEYS */;
INSERT INTO `inspections` VALUES (1,'2026-07-14','A','July 2026',6,4),(2,'2026-01-13','B','January 2026',6,4),(3,'2026-01-25','C','February 2026',6,4),(4,'2026-08-13','F','August 20266',6,4),(5,'2023-03-10','A','Routine Inspection - Clean and compliant',3,1),(6,'2023-05-18','B','Minor temperature issues noted',4,2),(7,'2023-08-22','C','Multiple non-critical violations found',5,3),(8,'2023-11-14','A','Follow-up inspection passed',6,4),(9,'2024-01-15','A','Excellent sanitation practices',3,1),(10,'2024-02-28','F','Severe pest issues present',4,2),(11,'2024-04-10','B','Improvement seen from last year',5,3),(12,'2024-06-19','A','Quarterly check passed',6,4),(13,'2024-07-05','C','Storage temperature warnings',6,8),(14,'2024-09-12','A','Fully compliant',4,9),(15,'2024-11-03','B','Handwashing station issues',5,10),(16,'2024-12-18','A','End of year review clear',6,11),(17,'2025-01-20','A','Annual audit completed',3,1),(18,'2025-02-14','B','Cross-contamination risk noted',4,2),(19,'2025-03-25','A','Clean storage area',5,3),(20,'2025-05-08','C','Restroom maintenance required',6,4),(21,'2025-06-15','F','Repeated bare-hand contact',6,8),(22,'2025-07-19','A','Re-inspection cleared',6,8),(23,'2025-09-02','A','Routine compliance verified',4,9),(24,'2025-10-11','B','Equipment sanitation warning',5,10),(25,'2025-11-20','A','Great food storage management',6,11),(26,'2025-12-05','C','Proper labeling missing',3,12),(27,'2026-02-18','A','February check passed',3,1),(28,'2026-03-12','A','First quarter routine check',4,2),(29,'2026-04-05','B','Minor kitchen grease buildup',5,3),(30,'2026-05-22','A','Mid-year audit satisfactory',6,4),(31,'2026-06-11','F','Severe infestation detected',6,8);
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
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contactNo` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Reviewed','Dismissed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `restoID` int NOT NULL,
  `requirementCode` int NOT NULL,
  PRIMARY KEY (`reportID`),
  KEY `report_ibfk_1` (`restoID`),
  KEY `report_ibfk_2` (`requirementCode`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`),
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`requirementCode`) REFERENCES `requirements` (`requirementCode`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,NULL,NULL,NULL,NULL,'Restroom floors were dirty and lacked soap dispensers.','Pending','2026-07-13 16:13:48',1,15),(2,NULL,NULL,NULL,NULL,'Food was observed being handled without gloves.','Reviewed','2026-07-14 17:33:07',2,2),(3,NULL,NULL,NULL,NULL,'Several cockroaches were seen near the kitchen area.','Reviewed','2026-07-15 10:39:31',3,7),(4,NULL,NULL,NULL,NULL,'Several cockroaches were seen near the kitchen area.','Reviewed','2026-07-14 14:39:31',4,7),(5,NULL,NULL,NULL,NULL,'Food was observed being handled without gloves.','Pending','2026-07-13 16:13:48',7,2),(6,NULL,NULL,NULL,NULL,'ayuq na mag isip ng desc.','Pending','2026-07-14 15:51:55',7,9),(7,NULL,NULL,NULL,NULL,'ayuq na mag isip ng desc.','Pending','2026-07-14 15:51:55',1,11),(8,NULL,NULL,NULL,NULL,'ayuq na mag isip ng desc.','Pending','2026-07-14 15:52:20',5,3),(9,NULL,NULL,NULL,NULL,'ayuq na mag isip ng desc.','Dismissed','2026-07-14 15:52:20',3,12),(10,NULL,NULL,NULL,NULL,'ayuq na mag isip ng desc.','Pending','2026-07-14 15:52:20',4,12),(11,'john.doe@gmail.com','John','Doe','09123456781','Expired ingredients found in stock room.','Reviewed','2023-04-10 01:30:00',1,8),(12,'jane.smith@gmail.com','Jane','Smith','09123456782','Food was served cold.','Dismissed','2023-08-15 06:20:00',3,6),(13,'alex.cruz@gmail.com','Alex','Cruz','09123456783','Saw flies inside the display case.','Reviewed','2024-03-01 03:10:00',2,7),(14,'carla.mendoza@gmail.com','Carla','Mendoza','09123456789','Unwashed vegetables being prepared.','Pending','2024-05-12 00:45:00',4,1),(15,'mark.reyes@gmail.com','Mark','Reyes','09123456784','Staff without hairnets or aprons.','Reviewed','2024-08-20 08:05:00',8,13),(16,'louis.tan@gmail.com','Louis','Tan','09123456790','Grease dropping from exhaust hoods.','Reviewed','2025-02-10 05:15:00',10,16),(17,'sarah.conner@gmail.com','Sarah','Conner','09123456785','No soap or paper towels in the bathroom.','Pending','2025-05-18 02:00:00',4,15),(18,'robert.lim@gmail.com','Robert','Lim','09123456791','Cockroach seen near the dining table.','Pending','2025-09-09 11:30:00',8,7),(19,'david.gomez@gmail.com','David','Gomez','09123456786','Undercooked chicken served.','Dismissed','2025-11-01 04:40:00',12,3),(20,'maria.santos@gmail.com','Maria','Santos','09123456787','Employees handling money then food without washing hands.','Pending','2026-02-14 03:22:10',4,5),(21,'elena.delarosa@gmail.com','Elena','Dela Rosa','09123456792','Lack of allergen warnings on buffet section.','Pending','2026-03-20 07:45:00',4,17),(22,'paul.walker@gmail.com','Paul','Walker','09123456788','Trash cans overflowing near kitchen entrance.','Pending','2026-05-04 02:11:00',4,11),(23,'grace.alonso@gmail.com','Grace','Alonso','09123456793','Raw beef stored directly above vegetables.','Pending','2026-06-18 08:30:00',4,1);
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
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category` enum('Sanitation','Food Safety','Equipment','Pest Control','Equipment','Personnel','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `severityLvl` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contactNo` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `maps` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `districtID` int NOT NULL,
  PRIMARY KEY (`restoID`),
  KEY `restaurant_ibfk_1` (`districtID`),
  CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,123456,'Jollibee Quiapo','Quiapo, Manila','09171234567',NULL,'Jollibee_Quiapo.png',1,1),(2,234567,'Hilltop Café','Baguio City, Benguet','09181234567',NULL,'Hilltop_Cafe.png',1,2),(3,345678,'Vigan Heritage Restaurant','Vigan City, Ilocos Sur','09191234567',NULL,'Vigan_Heritage.png',1,3),(4,456789,'Cagayan Valley Grill','Tuguegarao City, Cagayan','09201234567',NULL,'Cagayan_Valley.png',1,4),(5,567891,'Kapampangan Kitchen','San Fernando, Pampanga','09211234567',NULL,'Kapampangan_Kitchen.png',1,5),(6,678912,'Lipa Food House','Lipa City, Batangas','09221234567',NULL,'Lipa_Food.png',1,6),(7,789123,'Wendy\'s Taft','Taft, Manila','09231234567',NULL,'Wendys_Taft.png',1,1),(8,890123,'Baguio Craft Brewery','Ben Palispis Hwy, Baguio','09241234567',NULL,'Baguio_Craft.png',1,2),(9,901234,'Hidden Garden ','Vigan City, Ilocos Sur','09251234567',NULL,'Hidden_Garden.png',1,3),(10,112233,'Lalays Panciteria','Tuguegarao City, Cagayan','09261234567',NULL,'Lalays.png',1,4),(11,223344,'Aling Lucing','Angeles, Pampanga','09271234567',NULL,'Aling_Lucing.png',1,5),(12,334455,'Cabezera Ridge View','Tagaytay, Cavite','09281234567',NULL,'Cabezera_Ridge.png',1,6);
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
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `districtID` int DEFAULT NULL,
  `role` enum('Admin','Inspector') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `loginAttempt` int NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
INSERT INTO `users` VALUES (2,'marinel_llaguno@admin.com','$2y$10$2G7C.icwqiAAr2lPm7jPnOrhHQ2hJmyA8HoI7PaArysYAhd0ON0Sa','Marinel','Llaguno',NULL,'Admin',0,'2026-07-15 09:55:23',1,0),(3,'matthew_lucas@inspector.com','$2y$10$DjhP9EW/F5shjj/DzcjjhOxFMmy.0aqU0/VdnGgkax5Y/sZPegpky','Matthew','Lucas',1,'Inspector',0,'2026-07-15 07:02:36',1,0),(4,'miguel_monterola@inspector.com','$2y$10$VOEvLW4JZpkJPuMhmAtvmuVzGNIzoHs/2aXWWb1KYtPWotWe8z4zO','Miguel','Monterola',2,'Inspector',0,'2026-07-15 10:06:37',1,0),(5,'clarisse_nazario@inspector.com','$2y$10$s3Hq.m3R0OVqMtWXQaHJK.ti3CQZjRhhri7/b3/dxYeJcf5hY4uxO','Clar','Nazario',3,'Inspector',0,'2026-07-15 10:09:40',1,0),(6,'andrea_prestoza@inspector.com','$2y$10$VZbdQpAAe8mBFO7kwkJXS.tUxY2bZqfIODI8BDT5HNN.gSGzXnTSW','Andrea','Prestoza',4,'Inspector',0,'2026-07-15 10:25:39',1,0),(7,'efia_danso@islay.com','$2y$10$LE.w/HRsldmdypAf9MAB4OcRQXA6e7ivbRczFJsUdEYA27Y5U.q1W','Efia','Astra',5,'Inspector',0,'2026-07-14 17:16:59',0,1),(8,'erik_torsten@inspector.com','$2y$10$I.CuuMiRZEP6/VK2.gPfRub3FSZI2sd7DsfPZgrESUNntXMjx1mmu','Erik','Torsten',4,'Inspector',0,'2026-07-14 17:16:59',1,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `violations`
--

LOCK TABLES `violations` WRITE;
/*!40000 ALTER TABLE `violations` DISABLE KEYS */;
INSERT INTO `violations` VALUES (1,4,2),(2,1,1),(3,4,17),(4,4,18),(5,4,15),(6,4,15),(7,4,18),(8,4,15),(9,6,6),(10,7,5),(11,7,11),(12,10,7),(13,10,15),(14,11,9),(15,13,6),(16,13,12),(17,15,5),(18,18,1),(19,20,15),(20,21,2),(21,21,7),(22,21,13),(23,24,9),(24,26,17),(25,29,16),(26,31,7),(27,31,8),(28,31,15);
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

-- Dump completed on 2026-08-04 23:00:27
