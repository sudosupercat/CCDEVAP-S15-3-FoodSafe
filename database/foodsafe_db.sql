-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jul 12, 2026 at 11:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodsafe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `districtID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`districtID`, `name`) VALUES
(1, 'National Capital Region (NCR)'),
(2, 'Cordillera Administrative Region (CAR)'),
(3, 'Region I - Ilocos Region'),
(4, 'Region II - Cagayan Valley'),
(5, 'Region III - Central Luzon'),
(6, 'Region IV-A - CALABARZON'),
(7, 'Region IV-B - MIMAROPA'),
(8, 'Region V - Bicol Region'),
(9, 'Region VI - Western Visayas'),
(10, 'Region VII - Central Visayas'),
(11, 'Region VIII - Eastern Visayas'),
(12, 'Region IX - Zamboanga Peninsula'),
(13, 'Region X - Northern Mindanao'),
(14, 'Region XI - Davao Region'),
(15, 'Region XII - SOCCSKSARGEN'),
(16, 'Region XIII - Caraga'),
(17, 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)');

-- --------------------------------------------------------

--
-- Table structure for table `inspections`
--

CREATE TABLE `inspections` (
  `inspectionID` int(11) NOT NULL,
  `inspectionDate` date NOT NULL,
  `score` float NOT NULL,
  `grade` enum('Pass','Fail') NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `restoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportID` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `contactNo` varchar(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('Pending','Reviewed','Dismissed') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `restoID` int(11) NOT NULL,
  `requirementCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `requirementCode` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` enum('Sanitation','Food Safety','Equipment','Pest Control','Equipment','Personnel','') NOT NULL,
  `severityLvl` enum('1','2','3','4','5') NOT NULL,
  `standardFine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`requirementCode`, `title`, `description`, `category`, `severityLvl`, `standardFine`) VALUES
(1, 'Cross-contamination', 'Food items are contaminated through contact with raw food, dirty utensils, or unsanitary surfaces.', 'Food Safety', '5', 5000),
(2, 'Bare-Hand Contact with Ready to Eat Food', 'Employees handle ready-to-eat food with bare hands instead of using gloves or utensils.', 'Food Safety', '4', 3000),
(3, 'Improper Cooking Temperatures', 'Food is not cooked to the minimum safe internal temperature.', 'Food Safety', '5', 5000),
(4, 'Failure to Rapidly Cool or Reheat Foods', 'Food is not cooled or reheated within the required time and temperature limits.', 'Food Safety', '4', 3000),
(5, 'Poor Handwashing Practices', 'Employees fail to wash hands properly or at required times.', 'Sanitation', '4', 3000),
(6, 'Improper Food Storage Temperatures', 'Cold or hot food is stored outside the required temperature range.', 'Food Safety', '5', 5000),
(7, 'Pest Infestation', 'Evidence of rodents, insects, or other pests is present in the establishment.', 'Pest Control', '5', 10000),
(8, 'Expired Food Items', 'Expired food products are stored, displayed, or served.', 'Food Safety', '4', 3000),
(9, 'Dirty Kitchen Equipment', 'Kitchen equipment is not cleaned and sanitized properly.', 'Equipment', '3', 2000),
(10, 'Improper Dishwashing Techniques', 'Utensils and dishes are not washed, rinsed, and sanitized correctly.', 'Sanitation', '3', 2000),
(11, 'Cluttered or Dirty Floors', 'Floors are dirty, cluttered, or present slipping hazards.', 'Sanitation', '2', 1000),
(12, 'Inadequate Food Protection', 'Food is left uncovered or exposed to contamination.', 'Food Safety', '4', 3000),
(13, 'Improper Employee Hygiene', 'Employees fail to maintain proper personal cleanliness or wear appropriate protective clothing.', 'Personnel', '4', 3000),
(14, 'Unapproved Food Resources', 'Food is obtained from suppliers or sources not approved by regulatory authorities.', 'Food Safety', '5', 5000),
(15, 'Unclean Restrooms', 'Restroom facilities are unsanitary or lack soap, water, or tissue.', 'Sanitation', '2', 1000),
(16, 'Grease Buildup in Exhaust Systems', 'Exhaust hoods and ventilation systems contain excessive grease buildup.', 'Equipment', '3', 2500),
(17, 'Failure to Properly Label Allergens', 'Food products are not properly labeled with allergen information.', 'Food Safety', '5', 5000),
(18, 'Inadequate Training for Employees', 'Employees have not received the required food safety and sanitation training.', 'Personnel', '3', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restoID` int(11) NOT NULL,
  `licenseNo` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contactNo` varchar(11) NOT NULL,
  `maps` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `districtID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restoID`, `licenseNo`, `name`, `address`, `contactNo`, `maps`, `image`, `status`, `districtID`) VALUES
(1, 123456, 'Jollibee Quiapo', 'Quiapo, Manila', '09171234567', NULL, 'Jollibee_Quiapo.png', 1, 1),
(2, 234567, 'Hilltop Café', 'Baguio City, Benguet', '09181234567', NULL, 'Hilltop_Cafe.png', 1, 2),
(3, 345678, 'Vigan Heritage Restaurant', 'Vigan City, Ilocos Sur', '09191234567', NULL, 'Vigan_Heritage.png', 1, 3),
(4, 456789, 'Cagayan Valley Grill', 'Tuguegarao City, Cagayan', '09201234567', NULL, 'Cagayan_Valley.png', 1, 4),
(5, 567891, 'Kapampangan Kitchen', 'San Fernando, Pampanga', '09211234567', NULL, 'Kapampangan_Kitchen.png', 1, 5),
(6, 678912, 'Lipa Food House', 'Lipa City, Batangas', '09221234567', NULL, 'Lipa_Food.png', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `districtID` int(11) DEFAULT NULL,
  `role` enum('Admin','Inspector') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `deleteFlag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `firstName`, `lastName`, `districtID`, `role`, `createdAt`, `status`, `deleteFlag`) VALUES
(2, 'marinel_llaguno@admin.com', 'marinelllaguno', 'Marinel', 'Llaguno', NULL, 'Admin', '2026-07-12 09:44:23', 1, 0),
(3, 'matthew_lucas@inspector.com', 'matthewlucas', 'Matthew', 'Lucas', 1, 'Inspector', '2026-07-12 09:44:23', 1, 0),
(4, 'miguel_monterola@inspector.com', 'miguelmonterola', 'Miguel', 'Monterola', 2, 'Inspector', '2026-07-12 09:44:23', 1, 0),
(5, 'clarisse_nazario@inspector.com', 'clarissenazario', 'Clarisse', 'Nazario', 3, 'Inspector', '2026-07-12 09:46:55', 1, 0),
(6, 'andrea_prestoza@inspector.com', 'andreaprestoza', 'Andrea', 'Prestoza', 4, 'Inspector', '2026-07-12 09:44:23', 1, 0),
(7, 'efia_danso@inspector.com', 'efiadanso', 'Efia', 'Danso', 5, 'Inspector', '2026-07-12 09:47:48', 0, 0),
(8, 'erik_torsten@inspector.com', 'eriktorsten', 'Erik', 'Torsten', 6, 'Inspector', '2026-07-12 09:48:23', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violationID` int(11) NOT NULL,
  `inspectionID` int(11) NOT NULL,
  `requirementCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`districtID`);

--
-- Indexes for table `inspections`
--
ALTER TABLE `inspections`
  ADD PRIMARY KEY (`inspectionID`),
  ADD KEY `inspection_ibfk_1` (`userID`),
  ADD KEY `inspection_ibfk_2` (`restoID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `report_ibfk_1` (`restoID`),
  ADD KEY `report_ibfk_2` (`requirementCode`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`requirementCode`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restoID`),
  ADD KEY `restaurant_ibfk_1` (`districtID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `user_ibfk_1` (`districtID`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violationID`),
  ADD KEY `violation_ibfk_1` (`inspectionID`),
  ADD KEY `violation_ibfk_2` (`requirementCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `districtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inspections`
--
ALTER TABLE `inspections`
  MODIFY `inspectionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `requirementCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inspections`
--
ALTER TABLE `inspections`
  ADD CONSTRAINT `inspection_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `inspection_ibfk_2` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`restoID`) REFERENCES `restaurants` (`restoID`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`requirementCode`) REFERENCES `requirements` (`requirementCode`);

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`districtID`) REFERENCES `districts` (`districtID`);

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `violation_ibfk_1` FOREIGN KEY (`inspectionID`) REFERENCES `inspections` (`inspectionID`),
  ADD CONSTRAINT `violation_ibfk_2` FOREIGN KEY (`requirementCode`) REFERENCES `requirements` (`requirementCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
