-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2024 at 06:35 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bluehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminNames` varchar(55) NOT NULL,
  `AdminPhone` varchar(12) NOT NULL,
  `AdminPass` varchar(255) NOT NULL,
  `AdminStatus` int(11) NOT NULL DEFAULT 1,
  `AdminDateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminNames`, `AdminPhone`, `AdminPass`, `AdminStatus`, `AdminDateCreated`) VALUES
(1, 'RUTIJANA Phocus', '0782013955', '202cb962ac59075b964b07152d234b70', 1, '2024-01-07 10:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerFname` varchar(30) NOT NULL,
  `CustomerLname` varchar(30) NOT NULL,
  `CustomerPhone` varchar(12) NOT NULL,
  `CustomerStatus` int(11) NOT NULL DEFAULT 1,
  `CustomerRecordedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `entrances`
--

CREATE TABLE `entrances` (
  `EntranceID` int(11) NOT NULL,
  `EntranceClient` int(11) NOT NULL,
  `EntranceType` int(11) DEFAULT 1,
  `EntranceInitial` float DEFAULT NULL,
  `EntranceAmount` float DEFAULT NULL,
  `EntranceRemaining` float DEFAULT NULL,
  `EntranceStatus` int(11) NOT NULL DEFAULT 1,
  `EntranceTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `entranceunit`
--

CREATE TABLE `entranceunit` (
  `UnitID` int(11) NOT NULL,
  `UnitValue` int(11) NOT NULL,
  `UnitStatus` int(11) NOT NULL DEFAULT 1,
  `UnitDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `ExpenseID` int(11) NOT NULL,
  `ExpenseName` varchar(55) NOT NULL,
  `ExpenseDetails` longtext NOT NULL,
  `ExpenseValue` float NOT NULL,
  `ExpenseStatus` int(11) NOT NULL DEFAULT 1,
  `ExpenseDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `SubscriptionID` int(11) NOT NULL,
  `SubscriptionClient` int(11) NOT NULL,
  `SubscriptionRecordedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `SubscriptionInitAmount` float NOT NULL,
  `SubscriptionConsumedAmount` float NOT NULL DEFAULT 0,
  `SubscriptionRemainingAmount` float NOT NULL,
  `SubscriptionInitDays` int(11) NOT NULL,
  `SubscriptionConsumedDays` int(11) NOT NULL DEFAULT 0,
  `SubscriptionRemainingDays` int(11) NOT NULL,
  `SubscriptionStatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `entrances`
--
ALTER TABLE `entrances`
  ADD PRIMARY KEY (`EntranceID`),
  ADD KEY `EntranceClient` (`EntranceClient`);

--
-- Indexes for table `entranceunit`
--
ALTER TABLE `entranceunit`
  ADD PRIMARY KEY (`UnitID`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`ExpenseID`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`SubscriptionID`),
  ADD KEY `SubscriptionClient` (`SubscriptionClient`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entrances`
--
ALTER TABLE `entrances`
  MODIFY `EntranceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscriptionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entrances`
--
ALTER TABLE `entrances`
  ADD CONSTRAINT `entrances_ibfk_1` FOREIGN KEY (`EntranceClient`) REFERENCES `customers` (`CustomerID`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`SubscriptionClient`) REFERENCES `customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
