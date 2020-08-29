-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2020 at 10:23 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryId` int NOT NULL,
  `countryName` varchar(20) NOT NULL,
  `countryImg` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryId`, `countryName`, `countryImg`) VALUES
(1, '嘉義縣', NULL),
(2, '新北市', NULL),
(3, '嘉義市', NULL),
(4, '新竹縣', NULL),
(5, '新竹市', NULL),
(6, '臺北市', NULL),
(7, '臺南市', NULL),
(8, '宜蘭縣', NULL),
(9, '苗栗縣', NULL),
(10, '雲林縣', NULL),
(11, '花蓮縣', NULL),
(12, '臺中市', NULL),
(13, '臺東縣', NULL),
(14, '桃園市', NULL),
(15, '南投縣', NULL),
(16, '高雄市', NULL),
(17, '金門縣', NULL),
(18, '屏東縣', NULL),
(19, '基隆市', NULL),
(20, '澎湖縣', NULL),
(21, '彰化縣', NULL),
(22, '連江縣', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weather36h`
--

CREATE TABLE `weather36h` (
  `weather36hId` int NOT NULL,
  `countryId` int NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `weather` varchar(20) NOT NULL,
  `minT` int NOT NULL,
  `maxT` int NOT NULL,
  `rainfall` int NOT NULL,
  `storeDate` datetime NOT NULL,
  `cicurrent` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `weather36h`
--

INSERT INTO `weather36h` (`weather36hId`, `countryId`, `startTime`, `endTime`, `weather`, `minT`, `maxT`, `rainfall`, `storeDate`, `cicurrent`) VALUES
(44, 5, '2020-08-29 18:00:00', '2020-08-30 06:00:00', '多雲短暫陣雨', 26, 28, 30, '2020-08-29 18:10:11', '舒適至悶熱'),
(66, 3, '2020-08-29 18:00:00', '2020-08-30 06:00:00', '多雲短暫陣雨', 26, 28, 30, '2020-08-29 18:10:31', '舒適至悶熱');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryId`);

--
-- Indexes for table `weather36h`
--
ALTER TABLE `weather36h`
  ADD PRIMARY KEY (`weather36hId`),
  ADD KEY `fk_countries_weather36h` (`countryId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `countryId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `weather36h`
--
ALTER TABLE `weather36h`
  MODIFY `weather36hId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `weather36h`
--
ALTER TABLE `weather36h`
  ADD CONSTRAINT `fk_countries_weather36h` FOREIGN KEY (`countryId`) REFERENCES `countries` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
