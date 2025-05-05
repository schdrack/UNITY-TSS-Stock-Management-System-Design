-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 02:16 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `productin`
--

CREATE TABLE `productin` (
  `ProductIn_id` int(11) NOT NULL,
  `PCode` int(11) NOT NULL,
  `prIn_Date` date NOT NULL,
  `prIn_Quantity` int(11) NOT NULL,
  `prIn_Unit_Price` decimal(10,2) NOT NULL,
  `prIn_TotalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productin`
--

INSERT INTO `productin` (`ProductIn_id`, `PCode`, `prIn_Date`, `prIn_Quantity`, `prIn_Unit_Price`, `prIn_TotalPrice`) VALUES
(2, 3, '2025-05-05', 2, '200000.00', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `productout`
--

CREATE TABLE `productout` (
  `ProductOut_id` int(11) NOT NULL,
  `PCode` int(11) NOT NULL,
  `prOut_Date` date NOT NULL,
  `prOut_Quantity` int(11) NOT NULL,
  `prOut_unit_Price` decimal(10,2) NOT NULL,
  `prOut_TotalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `PCode` int(11) NOT NULL,
  `PName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PCode`, `PName`) VALUES
(3, 'computer hp'),
(4, 'Lenovo'),
(5, 'Head phone'),
(6, 'Samsang'),
(8, 'Router devices');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`) VALUES
(1, 'admin', '$2y$10$WzJCKYA5OV1HwcGQX9kksuXlptXiT1gT9QPl6cWzoVA4gBYl1SYK2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productin`
--
ALTER TABLE `productin`
  ADD PRIMARY KEY (`ProductIn_id`),
  ADD KEY `PCode` (`PCode`);

--
-- Indexes for table `productout`
--
ALTER TABLE `productout`
  ADD PRIMARY KEY (`ProductOut_id`),
  ADD KEY `PCode` (`PCode`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PCode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productin`
--
ALTER TABLE `productin`
  MODIFY `ProductIn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productout`
--
ALTER TABLE `productout`
  MODIFY `ProductOut_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `PCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productin`
--
ALTER TABLE `productin`
  ADD CONSTRAINT `productin_ibfk_1` FOREIGN KEY (`PCode`) REFERENCES `products` (`PCode`) ON DELETE CASCADE;

--
-- Constraints for table `productout`
--
ALTER TABLE `productout`
  ADD CONSTRAINT `productout_ibfk_1` FOREIGN KEY (`PCode`) REFERENCES `products` (`PCode`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
