-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 16, 2024 at 05:35 AM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bluehous_bluehouse`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminNames`, `AdminPhone`, `AdminPass`, `AdminStatus`, `AdminDateCreated`) VALUES
(1, 'RUTIJANA Phocus', '0789232145', '1bdf6f479e535fba87636d21c4bf901a', 1, '2024-01-07 10:18:32');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerFname`, `CustomerLname`, `CustomerPhone`, `CustomerStatus`, `CustomerRecordedDate`) VALUES
(2, 'Odile', 'Ishimwe', '0788633578', 1, '2024-01-22 00:23:50'),
(8, 'Gilberte', 'Uwineza', '0786310197', 1, '2024-02-05 01:30:08'),
(9, 'uwisanze', 'hebert', '0782769236', 1, '2024-02-05 22:38:27'),
(10, 'igor Fabrice', 'mutabazi', '0786891331', 1, '2024-02-05 22:40:33'),
(12, 'mugisha', 'alain', '0783350228', 1, '2024-02-05 22:47:50'),
(13, 'fideli ', 'dushimana', '0788407925', 1, '2024-02-05 22:54:58'),
(14, 'Ngirumukiza', 'sage', '0789850928', 1, '2024-02-05 23:17:38'),
(15, 'SIBAFO', 'grace', '0786860225', 1, '2024-02-05 23:48:17'),
(16, 'Eboutou', 'paule', '0781020877', 1, '2024-02-05 23:50:15'),
(17, 'ntuyahera', 'Fred', '0786007857', 1, '2024-02-06 18:43:38'),
(18, 'twizeyimana', 'inyasi', '0784839053', 1, '2024-02-06 19:08:23'),
(19, 'murindwa', 'beni', '0787940795', 1, '2024-02-06 19:26:44'),
(20, 'kazumuhire', 'consolee', '0786073406', 1, '2024-02-08 23:44:10'),
(21, 'mugisha', 'christian', '0788240325', 1, '2024-02-08 23:56:03'),
(22, 'nahimana', 'esperance', '0792417105', 1, '2024-02-09 00:04:28'),
(23, 'malama  gift                  ', 'marcos', '0791958326  ', 1, '2024-02-09 01:13:37'),
(24, 'muhizi', 'yves', '0787635510', 1, '2024-02-09 01:36:27'),
(25, 'niyomucamanza', 'sosthne', '0788818528', 1, '2024-02-09 01:39:52'),
(26, 'Ngirumukiza', 'Sage', '0789850978', 1, '2024-02-10 02:17:53'),
(27, 'Kevin', 'Nkusi Ndandari', '0782307152', 1, '2024-02-14 01:56:54'),
(28, 'Xue', 'Lian', '0787473641', 1, '2024-02-14 01:59:41'),
(29, 'Ishemezwe', 'Ingrid', '0791920305', 1, '2024-02-14 02:01:55'),
(30, 'Ikoraneza', 'Laura', '0799370429', 1, '2024-02-14 02:11:02'),
(31, 'Igor', 'Mazimpaka', '0787329719', 1, '2024-02-14 14:00:33'),
(32, 'Ekanga', 'Agnima', '0792403095', 1, '2024-02-15 00:09:40'),
(33, 'Audrey', 'Vyizigiro', '0781541525', 1, '2024-02-20 01:30:17'),
(34, 'Miracle ', 'Munyandinda', '0781709772', 1, '2024-02-20 01:33:42'),
(35, 'Phyllis ', 'Njoki Macharia', '0789868441', 1, '2024-02-20 01:39:37'),
(36, 'Gasamagera', 'Gilbert', '0789209472', 1, '2024-02-20 18:24:22'),
(37, 'Bassam', 'Cyuzuzo', '0784251435', 1, '2024-02-22 00:26:07'),
(38, 'Ruzvidzo', 'Marshal Anesu', '0791904113', 1, '2024-02-22 00:29:18'),
(39, 'Chakala Sipho', 'Tremorio', '0793220345', 1, '2024-02-22 17:47:59'),
(40, 'margarito', 'lopez', '0791958311', 1, '2024-02-23 00:11:21'),
(41, 'Nolween joussikyria ', 'anael', '0793811128', 1, '2024-02-23 00:37:39'),
(42, 'Eric', 'Nsengiyumva', '0782039904', 1, '2024-02-25 02:03:25'),
(43, 'Balinda', 'penine Tumukunde', '0785093424', 1, '2024-02-25 02:12:29'),
(44, 'brice querey  ', 'mutoni', '0784649291', 1, '2024-02-25 23:37:41'),
(45, 'Mbyayingabo', 'Tresor', '0790003315', 1, '2024-02-27 02:07:44'),
(46, 'Osman Sebrina', 'Mohammed', '0791430263', 1, '2024-02-27 23:14:54'),
(47, 'Nguema ', 'David Jacques', '0792403179', 1, '2024-02-27 23:17:26'),
(48, 'gahima', 'cenrad', '0792400510', 1, '2024-03-05 01:04:38'),
(49, 'habishuti', 'irankunda', '0786256628', 1, '2024-03-07 02:06:23'),
(50, 'angelique', 'ishimwe', '0784906816', 1, '2024-03-07 02:24:35'),
(51, 'sheriff', 'mohammedy', '0792403060', 1, '2024-03-07 02:50:46'),
(52, 'Apoh', 'Prince', '0794089760', 1, '2024-03-08 19:04:33'),
(53, 'gisagara', 'emmauel', '0788324054', 1, '2024-03-11 10:07:44'),
(54, 'margarito', 'lopeze', '079079195831', 1, '2024-03-11 10:13:05'),
(55, 'udahemuka', 'jomo didier', '0788290000', 1, '2024-03-11 16:49:32'),
(56, 'mamo blen', 'amanuel', '0784385552', 1, '2024-03-13 00:06:42'),
(57, 'chibundu precious', 'mozia', '0793224038', 1, '2024-03-13 13:11:25'),
(58, 'vestine', 'nyiraneza', '0788640995', 1, '2024-03-19 13:46:22'),
(59, 'ndzon', 'nelvie', '0791345870', 1, '2024-03-19 13:50:14'),
(60, 'umutoni', 'flora', '0789487765', 1, '2024-03-21 14:24:10'),
(61, 'hubert', 'uwisanze', '0782269236', 1, '2024-03-26 23:23:55'),
(62, 'muhimpundu', 'raissa', '0791904052', 1, '2024-03-27 00:04:09'),
(63, 'ntwari', 'david', '0791386352', 1, '2024-04-04 22:44:33'),
(64, 'mukansanzabaganwa', 'emma-marie', '0783201488', 1, '2024-04-05 00:31:29'),
(65, 'mukangarambe', 'clodette', '0785295412', 1, '2024-04-05 00:38:56'),
(66, 'cyimenyi', 'grace', '0788809545', 1, '2024-04-08 21:44:07'),
(67, 'fiorence', 'louis', '0792401717', 1, '2024-04-10 23:20:34'),
(68, 'wizeye', 'brian collins', '0782386351', 1, '2024-04-13 00:35:27'),
(69, 'habarurema', 'eric', '0788653139', 1, '2024-04-13 00:39:42'),
(70, 'MWIZERWA', 'DONATH', '0788205071', 1, '2024-04-13 21:09:52'),
(71, 'IGIRANEZA', 'GRACE', '0781350105', 1, '2024-04-13 23:05:53'),
(72, 'ANNICK', 'UMURERWA', '0783462488', 1, '2024-04-13 23:40:46'),
(73, 'Anastasie', 'Bambuzimpamvu', '0783607096', 1, '2024-04-15 23:07:25'),
(74, 'Grace ', 'Nyirasinamenye', '0788687137', 1, '2024-04-15 23:09:07'),
(75, 'fidel', 'Kayitasirwa', '0788865786', 1, '2024-04-15 23:28:17'),
(77, 'Larrin ', 'Abeh Abeh', '0794095220', 1, '2024-04-15 23:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_subscriptions`
--

CREATE TABLE `customer_subscriptions` (
  `customer_subscription_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `all_months` int(11) NOT NULL,
  `remaining_months` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT '1',
  `isDiscount` tinyint(1) NOT NULL DEFAULT 0,
  `DiscountValue` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_subscriptions`
--

INSERT INTO `customer_subscriptions` (`customer_subscription_id`, `customer_id`, `starting_date`, `ending_date`, `all_months`, `remaining_months`, `updated_date`, `status`, `isDiscount`, `DiscountValue`) VALUES
(2, 2, '2024-01-21', '2024-03-21', 2, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(3, 1, '2024-01-21', '2024-03-21', 2, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(4, 4, '2024-02-01', '2024-05-01', 3, 1, '2024-04-16 09:01:38', '1', 0, NULL),
(5, 35, '2024-02-22', '2024-03-22', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(6, 23, '2024-03-04', '2024-04-04', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(7, 50, '2024-03-06', '2024-04-06', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(8, 51, '2024-03-06', '2024-05-06', 3, 2, '2024-04-16 09:01:38', '1', 0, NULL),
(9, 15, '2024-03-11', '2024-04-11', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(10, 56, '2024-03-12', '2024-04-12', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(11, 57, '2024-03-13', '2024-04-13', 1, 0, '2024-04-16 09:01:38', '1', 0, NULL),
(12, 32, '2024-03-20', '2024-04-20', 1, 1, '2024-04-16 09:01:38', '1', 0, NULL),
(13, 31, '2024-03-26', '2024-04-26', 1, 1, '2024-04-16 09:01:38', '1', 0, NULL),
(14, 66, '2024-04-10', '2024-05-10', 1, 1, '2024-04-16 09:01:38', '1', 0, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entrances`
--

INSERT INTO `entrances` (`EntranceID`, `EntranceClient`, `EntranceType`, `EntranceInitial`, `EntranceAmount`, `EntranceRemaining`, `EntranceStatus`, `EntranceTime`) VALUES
(1, 8, 1, NULL, 20000, NULL, 1, '2024-02-04 18:42:50'),
(2, 8, 1, NULL, 20000, NULL, 1, '2024-02-04 18:43:25'),
(3, 9, 1, NULL, 25000, NULL, 1, '2024-02-05 15:39:16'),
(4, 10, 1, NULL, 25000, NULL, 1, '2024-02-05 15:40:55'),
(6, 13, 1, NULL, 2000, NULL, 1, '2024-02-05 15:55:23'),
(7, 14, 1, NULL, 3000, NULL, 1, '2024-02-05 16:18:00'),
(8, 15, 1, NULL, 20000, NULL, 1, '2024-02-05 16:48:38'),
(9, 16, 1, NULL, 20000, NULL, 1, '2024-02-05 16:50:46'),
(10, 17, 1, NULL, 20000, NULL, 1, '2024-02-06 11:57:01'),
(11, 18, 1, NULL, 15000, NULL, 1, '2024-02-06 12:11:15'),
(12, 19, 1, NULL, 20000, NULL, 1, '2024-02-06 12:42:45'),
(13, 20, 1, NULL, 25000, NULL, 1, '2024-02-08 16:46:25'),
(14, 21, 1, NULL, 3000, NULL, 1, '2024-02-08 16:58:08'),
(15, 22, 1, NULL, 15000, NULL, 1, '2024-02-08 17:05:19'),
(16, 21, 1, NULL, 20000, NULL, 1, '2024-02-08 17:45:45'),
(17, 23, 1, NULL, 15000, NULL, 1, '2024-02-08 18:14:27'),
(18, 24, 1, NULL, 3000, NULL, 1, '2024-02-08 18:37:57'),
(19, 25, 1, NULL, 3000, NULL, 1, '2024-02-08 18:40:26'),
(20, 40, 1, NULL, 15000, NULL, 1, '2024-02-22 17:13:20'),
(21, 41, 1, NULL, 20000, NULL, 1, '2024-02-22 17:38:19'),
(22, 37, 1, NULL, 25000, NULL, 1, '2024-02-22 17:51:08'),
(23, 38, 1, NULL, 20000, NULL, 1, '2024-02-22 17:54:21'),
(24, 39, 1, NULL, 15000, NULL, 1, '2024-02-22 17:56:01'),
(25, 44, 1, NULL, 25000, NULL, 1, '2024-02-25 16:39:40'),
(26, 48, 1, NULL, 25000, NULL, 1, '2024-03-04 18:17:22'),
(27, 34, 1, NULL, 25000, NULL, 1, '2024-03-06 19:03:52'),
(28, 34, 1, NULL, 25000, NULL, 1, '2024-03-06 19:03:52'),
(29, 49, 1, NULL, 20000, NULL, 1, '2024-03-06 19:10:17'),
(30, 10, 1, NULL, 25000, NULL, 1, '2024-03-06 19:28:04'),
(31, 52, 1, NULL, 20000, NULL, 1, '2024-03-08 12:05:38'),
(32, 53, 1, NULL, 20000, NULL, 1, '2024-03-11 04:08:25'),
(33, 54, 1, NULL, 25000, NULL, 1, '2024-03-11 04:13:43'),
(34, 55, 1, NULL, 20000, NULL, 1, '2024-03-11 10:50:10'),
(35, 58, 1, NULL, 15000, NULL, 1, '2024-03-19 07:47:11'),
(36, 59, 1, NULL, 15000, NULL, 1, '2024-03-19 07:51:08'),
(37, 33, 1, NULL, 20000, NULL, 1, '2024-03-21 08:20:17'),
(38, 24, 1, NULL, 20000, NULL, 1, '2024-03-21 08:22:24'),
(39, 60, 1, NULL, 25000, NULL, 1, '2024-03-21 08:28:40'),
(40, 9, 1, NULL, 25000, NULL, 1, '2024-03-26 17:25:18'),
(41, 62, 1, NULL, 25000, NULL, 1, '2024-03-26 18:06:15'),
(42, 47, 1, NULL, 15000, NULL, 1, '2024-04-04 16:41:14'),
(43, 63, 1, NULL, 20000, NULL, 1, '2024-04-04 16:45:11'),
(44, 20, 1, NULL, 25000, NULL, 1, '2024-04-04 17:05:21'),
(45, 65, 1, NULL, 20000, NULL, 1, '2024-04-04 18:39:40'),
(46, 66, 1, NULL, 25000, NULL, 1, '2024-04-08 15:48:55'),
(47, 11, 1, NULL, 9000, NULL, 1, '2024-04-10 10:27:32'),
(48, 11, 1, NULL, 5000, NULL, 1, '2024-04-10 10:28:59'),
(49, 67, 1, NULL, 15000, NULL, 1, '2024-04-10 17:24:23'),
(50, 68, 1, NULL, 25000, NULL, 1, '2024-04-12 18:36:05'),
(51, 10, 1, NULL, 25000, NULL, 1, '2024-04-12 18:37:02'),
(52, 69, 1, NULL, 25000, NULL, 1, '2024-04-12 18:41:41'),
(53, 70, 1, NULL, 20000, NULL, 1, '2024-04-13 15:11:24'),
(54, 71, 1, NULL, 20000, NULL, 1, '2024-04-13 17:10:38'),
(55, 72, 1, NULL, 15000, NULL, 1, '2024-04-13 17:41:42'),
(56, 73, 1, NULL, 20000, NULL, 1, '2024-04-15 17:07:56'),
(57, 74, 1, NULL, 20000, NULL, 1, '2024-04-15 17:09:36'),
(58, 75, 1, NULL, 25000, NULL, 1, '2024-04-15 17:28:45'),
(59, 77, 1, NULL, 20000, NULL, 1, '2024-04-15 17:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `entranceunit`
--

CREATE TABLE `entranceunit` (
  `UnitID` int(11) NOT NULL,
  `UnitValue` int(11) NOT NULL,
  `UnitStatus` int(11) NOT NULL DEFAULT 1,
  `UnitDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entranceunit`
--

INSERT INTO `entranceunit` (`UnitID`, `UnitValue`, `UnitStatus`, `UnitDate`) VALUES
(0, 20000, 1, '2024-01-21 18:19:18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`ExpenseID`, `ExpenseName`, `ExpenseDetails`, `ExpenseValue`, `ExpenseStatus`, `ExpenseDate`) VALUES
(1, 'umuriro', 'umuriro wo gukoresha', 5000, 1, '2024-01-22 00:30:33'),
(2, 'umuriro', 'work', 15000, 1, '2024-02-01 23:37:19'),
(3, 'amazi/juice', 'work', 16300, 1, '2024-02-23 01:00:06'),
(4, 'juice/amazi', 'work', 27500, 1, '2024-02-23 01:00:39'),
(5, 'umuriro', 'work', 15000, 1, '2024-02-23 01:01:49'),
(6, 'technician', 'ibikoresho', 22000, 1, '2024-02-23 01:02:45'),
(7, 'technician', 'ibikoresho', 22000, 1, '2024-02-23 01:02:46'),
(8, 'Technician', 'salary', 15000, 1, '2024-02-23 01:03:07'),
(9, 'amazi/juice', 'work', 16800, 1, '2024-02-23 01:03:38'),
(10, 'amazi/Juice', 'work', 16300, 1, '2024-02-23 01:05:33'),
(11, 'amazi\\juice', 'work', 16500, 1, '2024-02-25 22:39:31'),
(12, 'motari\\wazanye amanzi', 'ticket', 500, 1, '2024-02-25 22:46:43'),
(13, 'isabune ikoropa\\vim\\umuti wibrahure\\itorosho\\ticket', 'amasuku', 9000, 1, '2024-02-25 23:29:27'),
(14, 'amazi/juice', 'work', 16500, 1, '2024-03-05 19:06:58'),
(15, 'amazi/juice', 'work', 16500, 1, '2024-03-16 22:05:33'),
(16, 'UMURIR0', 'WORK', 30000, 1, '2024-03-20 23:54:20'),
(17, 'surie de cable7k\\transport3k/mandevre10k', 'techricien', 20000, 1, '2024-03-21 00:29:09'),
(18, 'amazi/juice', 'work', 16500, 1, '2024-03-26 23:19:07'),
(19, 'umuriro', 'work', 10000, 1, '2024-03-27 12:27:32'),
(20, 'devi yo yogusana muri gym ninzu yohepfo', 'work', 60000, 1, '2024-03-27 14:00:42'),
(21, 'amazi/juice', 'work', 16500, 1, '2024-04-04 22:31:08'),
(22, 'umuriro', 'work', 10000, 1, '2024-04-04 23:17:57'),
(23, 'amazi', 'work', 7000, 1, '2024-04-10 23:15:18'),
(24, 'umuriro', 'work', 10000, 1, '2024-04-10 23:15:59');

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
  `SubscriptionStatus` int(11) NOT NULL DEFAULT 1,
  `InitialMonths` float NOT NULL,
  `ConsumedMonths` float NOT NULL DEFAULT 0,
  `RemainingMonths` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions_transactions`
--

CREATE TABLE `subscriptions_transactions` (
  `transaction_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `subscriptions_months` int(11) NOT NULL,
  `subscriptions_start` date NOT NULL,
  `subscriptions_end` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `recorded_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions_transactions`
--

INSERT INTO `subscriptions_transactions` (`transaction_id`, `client_id`, `amount_paid`, `subscriptions_months`, `subscriptions_start`, `subscriptions_end`, `status`, `recorded_date`) VALUES
(1, 2, 25000, 1, '2024-01-21', '2024-02-21', 'active', '2024-01-21 12:24:36'),
(2, 1, 25000, 1, '2024-01-21', '2024-02-21', 'active', '2024-01-21 15:14:37'),
(3, 1, 25000, 1, '2024-02-21', '2024-03-21', 'active', '2024-01-21 15:14:50'),
(4, 4, 25000, 1, '2024-02-01', '2024-03-01', 'active', '2024-02-01 11:30:25'),
(5, 4, 25000, 1, '2024-03-01', '2024-04-01', 'active', '2024-02-01 11:44:12'),
(6, 4, 25000, 1, '2024-04-01', '2024-05-01', 'active', '2024-02-01 11:44:14'),
(7, 2, 25000, 1, '2024-02-21', '2024-03-21', 'active', '2024-02-22 12:45:33'),
(8, 35, 15000, 1, '2024-02-22', '2024-03-22', 'active', '2024-02-22 12:48:26'),
(9, 23, 20000, 1, '2024-03-04', '2024-04-04', 'active', '2024-03-04 13:34:12'),
(10, 50, 20000, 1, '2024-03-06', '2024-04-06', 'active', '2024-03-06 14:25:34'),
(11, 51, 20000, 1, '2024-03-06', '2024-04-06', 'active', '2024-03-06 14:52:15'),
(12, 15, 20000, 1, '2024-03-11', '2024-04-11', 'active', '2024-03-11 00:17:44'),
(13, 56, 20000, 1, '2024-03-12', '2024-04-12', 'active', '2024-03-12 14:07:30'),
(14, 57, 20000, 1, '2024-03-13', '2024-04-13', 'active', '2024-03-13 03:13:20'),
(15, 32, 20000, 1, '2024-03-20', '2024-04-20', 'active', '2024-03-20 11:49:49'),
(16, 31, 20000, 1, '2024-03-26', '2024-04-26', 'active', '2024-03-26 13:34:34'),
(17, 66, 25000, 1, '2024-04-10', '2024-05-10', 'active', '2024-04-10 06:57:17'),
(18, 51, 20000, 1, '2024-04-06', '2024-05-06', 'active', '2024-04-15 13:59:44'),
(29, 51, 20000, 1, '2025-03-06', '2025-04-06', 'active', '2024-04-15 15:11:42'),
(30, 51, 20000, 1, '2025-04-06', '2025-05-06', 'active', '2024-04-15 15:13:37');

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
-- Indexes for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  ADD PRIMARY KEY (`customer_subscription_id`);

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
-- Indexes for table `subscriptions_transactions`
--
ALTER TABLE `subscriptions_transactions`
  ADD PRIMARY KEY (`transaction_id`);

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
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  MODIFY `customer_subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `entrances`
--
ALTER TABLE `entrances`
  MODIFY `EntranceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscriptionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions_transactions`
--
ALTER TABLE `subscriptions_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
