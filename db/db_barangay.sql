-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 03:32 PM
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
-- Database: `db_barangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

CREATE TABLE `forget_password` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `temp_key` varchar(200) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `forget_password`
--

INSERT INTO `forget_password` (`id`, `email`, `temp_key`, `created`) VALUES
(0, 'casubhalucky5@gmail.com', '800378', '2024-12-04 11:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity`
--

CREATE TABLE `tblactivity` (
  `id` int(11) NOT NULL,
  `dateofactivity` date NOT NULL,
  `activity` text NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `archive` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblactivity`
--

INSERT INTO `tblactivity` (`id`, `dateofactivity`, `activity`, `description`, `image`, `archive`) VALUES
(14, '2024-10-28', 'Ayuda', 'Distribution of ayuda for fisherman', '1730191689375login-bg.png', 0),
(15, '2024-10-31', 'Election', 'Election of officers', '1730369075356home-bg.png', 1),
(18, '2024-11-06', 'Meeting', 'Meeting', '1731924052023qr_code (4).jpg', 1),
(19, '2024-12-05', 'Cleaning', 'Cleaning of Lawa', '1734278397349unmute.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblactivityphoto`
--

CREATE TABLE `tblactivityphoto` (
  `id` int(11) NOT NULL,
  `activityid` int(11) NOT NULL,
  `filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblactivityphoto`
--

INSERT INTO `tblactivityphoto` (`id`, `activityid`, `filename`) VALUES
(18, 7, '1485255503893ChibiMaker.jpg'),
(19, 7, '1485255504014dental.jpg'),
(20, 7, '1485255504108images.jpg'),
(21, 8, '1485255608251dfxfxfxdfxfxfxdf.png'),
(22, 8, '1485255608315easy-nail-art-designs-for-beginners-youtube.jpg'),
(23, 8, '1485255608404Easy-Winter-Nail-Art-Tutorials-2013-2014-For-Beginners-Learners-10.jpg'),
(24, 8, '1485255608513motherboard.png'),
(25, 9, '148525575293111041019_1012143402147589_9043399646875097729_n.jpg'),
(26, 9, '1485255753089bg.PNG'),
(32, 10, '148526764905211041019_1012143402147589_9043399646875097729_n.jpg'),
(33, 10, '1485267649364bg.PNG'),
(34, 10, '1485267649563motherboard.png'),
(35, 10, '14855301764078196186971_2237f161bd_b.jpg'),
(36, 10, '1485530481111bicycle-1280x720.jpg'),
(38, 11, '1485530620716user2.jpg'),
(39, 10, '1730188518268login-bg.jfif'),
(40, 12, '1730188541680login-bg.png'),
(41, 13, '1730188952155paper.jfif'),
(42, 13, '1730188973025idpic.png'),
(43, 13, '1730189118956bfarmc-sinalhan-logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `logdate` datetime NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`id`, `user`, `logdate`, `action`) VALUES
(2, 'asd', '2017-01-04 00:00:00', 'Added Resident namedjayjay, asd asd'),
(3, 'asd', '2017-01-04 19:13:40', 'Update Resident named Sample1, User1 Brgy1'),
(4, 'sad', '2017-01-05 13:22:10', 'Update Official named eliezer a. vacalares, jr.'),
(7, 'sad', '2017-01-05 13:54:40', 'Update Household Number 1'),
(8, 'sad', '2017-01-05 14:00:08', 'Update Blotter Request sda, as das'),
(9, 'sad', '2017-01-05 14:15:39', 'Update Clearance with clearance number of 123131'),
(10, 'sad', '2017-01-05 14:25:03', 'Update Permit with business name of asda'),
(11, 'sad', '2017-01-05 14:25:25', 'Update Resident named Sample1, User1 Brgy1'),
(12, 'Administrator', '2017-01-24 16:32:40', 'Added Permit with business name of hahaha'),
(13, 'Administrator', '2017-01-24 16:35:41', 'Added Clearance with clearance number of 123'),
(14, 'Administrator', '2017-01-24 18:43:35', 'Added Activity sad'),
(15, 'Administrator', '2017-01-24 18:45:49', 'Added Activity qwe'),
(16, 'Administrator', '2017-01-24 18:46:20', 'Added Activity ss'),
(17, 'Administrator', '2017-01-24 18:47:39', 'Added Activity e'),
(18, 'Administrator', '2017-01-24 18:55:20', 'Added Activity activity'),
(19, 'Administrator', '2017-01-24 18:58:23', 'Added Activity Activity'),
(20, 'Administrator', '2017-01-24 19:00:07', 'Added Activity activity'),
(21, 'Administrator', '2017-01-24 19:02:32', 'Added Activity Activity'),
(22, 'Administrator', '2017-01-24 19:04:54', 'Added Activity activity'),
(23, 'Administrator', '2017-01-24 19:08:40', 'Update Activity activity'),
(24, 'Administrator', '2017-01-27 23:23:40', 'Added Activity teets'),
(25, 'Administrator', '2017-01-27 23:24:14', 'Update Resident named Sample1, User1 Brgy1'),
(26, 'Administrator', '2017-01-27 23:25:10', 'Update Resident named sda, as das'),
(27, 'Administrator', '2017-01-30 10:45:13', 'Added Resident named 2, 2 2'),
(28, 'Administrator', '2017-01-30 10:45:54', 'Added Resident named 2, 2 2'),
(29, 'Administrator', '2017-02-06 08:58:23', 'Update Resident named sda, as das'),
(30, 'Administrator', '2017-02-06 09:00:14', 'Update Resident named sda, as das'),
(31, 'Administrator', '2017-02-06 09:03:57', 'Added Household Number 2'),
(32, 'Administrator', '2017-02-06 09:04:25', 'Added Household Number 2'),
(33, 'Administrator', '2024-10-19 22:07:05', 'Update Official named Sergio Delos Santos'),
(34, 'Administrator', '2024-10-19 22:09:16', 'Update Resident named Lina , C. Delos Santos'),
(35, 'Administrator', '2024-10-19 22:23:01', 'Update Zone number '),
(36, 'Administrator', '2024-10-19 22:42:20', 'Added Resident named Casubha, Lucky Mendoza'),
(37, 'Administrator', '2024-10-22 13:13:06', 'Update Staff with name of staff'),
(38, 'Administrator', '2024-10-22 17:05:23', 'Update Activity Cleaning'),
(39, 'Administrator', '2024-10-22 20:46:16', 'Added Official named Dela Cruz, Juan D.'),
(40, 'Administrator', '2024-10-22 20:46:36', 'Added Official named Dela Cruz, Juan D.'),
(41, 'Administrator', '2024-10-22 20:49:27', 'Added Official named Dela Cruz, Juan D.'),
(42, 'Administrator', '2024-10-22 20:51:39', 'Added Official named Dela Cruz, Juan D.'),
(43, 'Administrator', '2024-10-22 21:14:48', 'Added Resident named Dela Cruz, Juan Algabre'),
(44, 'Administrator', '2024-10-22 21:19:05', 'Added Resident named Dela Cruz, Juan Algabre'),
(45, 'Administrator', '2024-10-22 21:19:39', 'Added Resident named Dela Cruz, Juan Algabre'),
(46, 'Administrator', '2024-10-22 21:20:53', 'Added Resident named Dela Cruz, Juan Algabre'),
(47, 'Administrator', '2024-10-22 21:22:05', 'Added Resident named Dela Cruz, Juan Algabre'),
(48, 'Administrator', '2024-10-22 21:28:57', 'Added Resident named Dela Cruz, Juan Algabre'),
(49, 'Administrator', '2024-10-22 21:31:01', 'Added Resident named Dela Cruz, Juan Algabre'),
(50, 'Administrator', '2024-10-22 21:38:15', 'Updated Resident named Dela Cruz, Juan Algabre'),
(51, 'Administrator', '2024-10-22 21:45:52', 'Added Resident named Casubha, Kim Mendoza'),
(52, 'Administrator', '2024-10-22 21:47:11', 'Added Resident named Casubha, Kim Mendoza'),
(53, 'administrator', '2024-10-25 16:06:04', 'Added Resident named Casubha, Lucky  Mendoza'),
(54, 'administrator', '2024-10-25 16:29:39', 'Added Resident named Dela Cruz, Juan Algabre'),
(55, 'administrator', '2024-10-25 16:34:36', 'Added Resident named Juan, Zofia Zurita'),
(56, 'administrator', '2024-10-25 16:38:10', 'Added Resident named Par, Era Dane'),
(57, 'administrator', '2024-10-25 16:48:32', 'Added Resident named Almodovar, Kurt Eqe'),
(58, 'administrator', '2024-10-25 17:28:26', 'Added Official named Delos Santos, Sergio'),
(59, 'administrator', '2024-10-25 17:41:05', 'Added Resident named Gonzales, Isaac juju'),
(60, 'administrator', '2024-10-25 17:42:14', 'Added Resident named Taa, Criza jeje'),
(61, 'administrator', '2024-10-25 18:01:12', 'Updated Resident named Casubha, Kim Mendoza'),
(62, 'administrator', '2024-10-25 18:01:33', 'Updated Resident named Casubha, Kim Mendoza'),
(63, 'administrator', '2024-10-25 18:02:09', 'Update Official named Dela Cruz, Juan C.'),
(64, 'administrator', '2024-10-25 18:02:19', 'Updated Resident named Casubha, Kim Asthley Mendoza'),
(65, 'administrator', '2024-10-25 18:09:29', 'Updated Resident named Casubha, Kim Mendoza'),
(66, 'administrator', '2024-10-25 18:13:21', 'Updated Resident named Casubha, Kim Mendoza'),
(67, 'administrator', '2024-10-25 18:14:02', 'Updated Resident named Juan, Zofia Zurita'),
(68, 'administrator', '2024-10-25 18:20:26', 'Updated Resident named Casubha, Kim Mendoza'),
(69, 'administrator', '2024-10-25 18:21:33', 'Updated Resident named Casubha, Kim Mendoza'),
(70, 'administrator', '2024-10-25 18:23:17', 'Added Resident named aa, aq qq'),
(71, 'administrator', '2024-10-25 18:29:02', 'Added Resident named Cruz, Iner Santos'),
(72, 'administrator', '2024-10-25 18:29:38', 'Updated Resident named Casubha, Kim Mendoza'),
(73, 'administrator', '2024-10-25 18:36:19', 'Updated Resident named Casubha, Lucky Star Mendoza'),
(74, 'administrator', '2024-10-25 18:41:45', 'Updated Resident named Casubha, Kim Asthley Mendoza'),
(75, 'administrator', '2024-10-25 18:41:57', 'Update Official named Dela Cruz, Juan C.'),
(76, 'staff', '2024-10-25 18:42:50', 'Updated Resident named Casubha, Kim Mendoza'),
(77, 'staff', '2024-10-25 18:43:12', 'Updated Resident named Casubha, Kim Mendoza'),
(78, 'staff', '2024-10-25 18:43:37', 'Added Resident named bat, bat bat'),
(79, 'staff', '2024-10-25 18:45:47', 'Added Resident named bat, bat bat'),
(80, 'staff', '2024-10-25 18:50:25', 'Updated Resident named bat, bat bat'),
(81, 'administrator', '2024-10-25 18:55:03', 'Updated Resident named Casubha, Kim Mendoza'),
(82, 'administrator', '2024-10-25 18:55:44', 'Updated Resident named Casubha, Kim Mendoza'),
(83, 'administrator', '2024-10-25 18:56:35', 'Updated Resident named Casubha, Kim Mendoza'),
(84, 'administrator', '2024-10-25 18:58:40', 'Updated Resident named Casubha, Kim Mendoza'),
(85, 'administrator', '2024-10-25 19:01:37', 'Updated Resident named Dela Cruz, Kim Mendoza'),
(86, 'administrator', '2024-10-25 19:05:57', 'Updated Resident named Casubha, Kim Mendoza'),
(87, 'administrator', '2024-10-25 19:06:09', 'Updated Resident named Casubha, Kim Mendoza'),
(88, 'administrator', '2024-10-25 19:11:59', 'Updated Resident named Casubha, Kima Mendoza'),
(89, 'administrator', '2024-10-26 15:37:37', 'Updated Resident named Casubha, Kim Mendoza'),
(90, 'administrator', '2024-10-26 15:41:52', 'Update Resident named Casubha, Kim Mendoza'),
(91, 'administrator', '2024-10-26 15:42:05', 'Update Resident named Casubha, Kim Mendoza'),
(92, 'administrator', '2024-10-26 15:42:53', 'Updated Resident named Casubha, Kim Mendoza'),
(93, 'administrator', '2024-10-26 15:54:59', 'Update Resident named Casubha, Kim Mendoza'),
(94, 'administrator', '2024-10-26 15:55:12', 'Update Resident named Casubha, Kim Mendoza'),
(95, 'administrator', '2024-10-26 15:57:57', 'Update Resident named Casubha, Kima Mendoza'),
(96, 'administrator', '2024-10-26 16:00:18', 'Update Resident named Casubha, Kima Mendoza'),
(97, 'administrator', '2024-10-26 16:01:32', 'Update Resident named Casubha, Kim Mendoza'),
(98, 'administrator', '2024-10-26 16:01:43', 'Update Resident named Casubha, Kima Mendoza'),
(99, 'administrator', '2024-10-26 16:03:08', 'Update Resident named Casubha, Kima Mendoza'),
(100, 'administrator', '2024-10-26 16:03:18', 'Update Resident named Casubha, Kim Mendoza'),
(101, 'administrator', '2024-10-26 16:03:29', 'Update Resident named Juan, Zofia Zurita'),
(102, 'administrator', '2024-10-26 16:03:57', 'Update Resident named Casubha, Kim Mendoza'),
(103, 'administrator', '2024-10-26 16:04:06', 'Update Resident named Casubha, Kima Mendoza'),
(104, 'administrator', '2024-10-26 16:05:56', 'Update Resident named Casubha, Kim Mendozaaaa'),
(105, 'administrator', '2024-10-26 16:06:45', 'Update Resident named Casubha, Kim Mendoza'),
(106, 'administrator', '2024-10-26 16:07:08', 'Updated Resident named Casubha, Ashley Mendoza'),
(107, 'administrator', '2024-10-26 16:07:50', 'Updated Resident named Casubha, Kima Mendoza'),
(108, 'administrator', '2024-10-26 16:08:18', 'Updated Resident named Casubha, Kim Mendoza'),
(109, 'administrator', '2024-10-26 16:11:51', 'Updated Resident named Casubha, Kim Mendoza'),
(110, 'administrator', '2024-10-26 16:12:31', 'Updated Resident named Casubha, Ashley Mendoza'),
(111, 'administrator', '2024-10-26 17:31:39', 'Added Resident named Dela Cruz, Lina Casubha'),
(112, 'administrator', '2024-10-26 17:32:27', 'Updated Resident named Taa, Criza mendoza'),
(113, 'administrator', '2024-10-27 23:58:51', 'Added Resident named Amarante, Juan Taa'),
(114, 'administrator', '2024-10-28 00:02:06', 'Updated Resident named Amarante, Juan Taa'),
(115, 'administrator', '2024-10-28 00:06:29', 'Updated Resident named Amarante, Juan Danilo'),
(116, 'administrator', '2024-10-28 01:19:19', 'Updated Resident named Dela Cruz, Lina Casubha'),
(117, 'administrator', '2024-10-28 01:19:27', 'Updated Resident named Casubha, Ashley Mendoza'),
(118, 'administrator', '2024-10-28 01:19:34', 'Updated Resident named Par, Era Dane'),
(119, 'administrator', '2024-10-28 01:19:41', 'Updated Resident named Juan, Zofia Zurita'),
(120, 'administrator', '2024-10-29 15:55:41', 'Added Activity cleaning'),
(121, 'administrator', '2024-10-29 16:02:32', 'Added Activity Ayuda'),
(122, 'administrator', '2024-10-29 16:08:38', 'Updated Activity cleaning'),
(123, 'administrator', '2024-10-29 16:09:38', 'Updated Activity cleaning'),
(124, 'administrator', '2024-10-29 16:09:46', 'Updated Activity cleaning'),
(125, 'administrator', '2024-10-29 16:12:27', 'Updated Activity cleaning'),
(126, 'administrator', '2024-10-29 16:40:57', 'Updated Activity cleaning'),
(127, 'administrator', '2024-10-29 16:43:13', 'Updated Activity cleaning'),
(128, 'administrator', '2024-10-29 16:47:31', 'Added Activity Ayuda'),
(129, 'administrator', '2024-10-29 16:48:09', 'Updated Activity Ayuda'),
(130, 'administrator', '2024-10-29 17:04:52', 'Updated Resident named Juan, Zofia Zurita'),
(131, 'administrator', '2024-10-29 17:05:08', 'Updated Resident named Par, Era Dane'),
(132, 'administrator', '2024-10-29 21:49:48', 'Updated Resident named Juan, Zofia Dennise Zurita'),
(133, 'administrator', '2024-10-29 22:25:27', 'Updated Resident named Juan, Zofia Dennise Zurita'),
(134, 'administrator', '2024-10-30 23:15:01', 'Updated Resident named Juan, Zofia Dennise Zurita'),
(135, 'administrator', '2024-10-31 12:36:27', 'Added Official named Delos Santos, Sergio'),
(136, 'administrator', '2024-10-31 12:46:50', 'Added Official named Delos Santos, Sergio'),
(137, 'staff', '2024-10-31 12:53:18', 'Updated Resident named Par, Era Dane'),
(138, 'administrator', '2024-10-31 14:15:04', 'Added Official named Juan, Isaac'),
(139, 'administrator', '2024-10-31 14:15:13', 'Update Official named Juan, Isaac'),
(140, 'administrator', '2024-10-31 17:33:12', 'Updated Resident named Amarante, Juan Danilo'),
(141, 'administrator', '2024-10-31 17:35:07', 'Added Resident named Padilla, Alden Barbara'),
(142, 'administrator', '2024-10-31 17:35:38', 'Updated Resident named Padilla, Alden Barbara'),
(143, 'administrator', '2024-10-31 17:40:59', 'Added Resident named Duterte, Sara hehe'),
(144, 'administrator', '2024-10-31 17:41:07', 'Updated Resident named Duterte, Sara hehe'),
(145, 'administrator', '2024-10-31 17:41:50', 'Updated Resident named Amarante, Juan Danilo'),
(146, 'administrator', '2024-10-31 17:43:18', 'Added Resident named Duterte, digong hehe'),
(147, 'administrator', '2024-10-31 17:43:26', 'Updated Resident named Duterte, digong hehe'),
(148, 'administrator', '2024-10-31 17:46:56', 'Updated Resident named Casubha, Ashley Mendoza'),
(149, 'administrator', '2024-10-31 17:47:34', 'Update Official named Dela Cruz, Juan C.'),
(150, 'administrator', '2024-10-31 17:49:39', 'Updated Resident named Juan, Zofia Dennise Zurita'),
(151, 'administrator', '2024-10-31 17:49:49', 'Updated Resident named Juan, Zofia Zurita'),
(152, 'administrator', '2024-10-31 17:52:16', 'Updated Resident named Juan, Zofiaa Zurita'),
(153, 'administrator', '2024-10-31 17:52:46', 'Updated Resident named Casubha, Ashley Mendoza'),
(154, 'administrator', '2024-10-31 17:52:58', 'Update Official named Dela Cruz, Juan C.'),
(155, 'administrator', '2024-10-31 17:56:07', 'Update Official named Dela Cruz, Juan C.'),
(156, 'administrator', '2024-10-31 18:04:35', 'Added Activity Election'),
(157, 'administrator', '2024-10-31 18:04:41', 'Updated Activity Election'),
(158, 'administrator', '2024-10-31 21:07:12', 'Updated Resident named Casubha, Ashley Mendoza'),
(159, 'administrator', '2024-10-31 23:04:05', 'Added Official named Padilla, Alden'),
(160, 'administrator', '2024-10-31 23:09:01', 'Added Official named Barreto, leon'),
(161, 'administrator', '2024-10-31 23:09:30', 'Update Official named Barreto, leon'),
(162, 'administrator', '2024-11-03 22:08:16', 'Updated Resident named Juan, Zofia Zurita'),
(163, 'administrator', '2024-11-07 21:41:13', 'Added Resident named Barroso, Lauriene Nofuente'),
(164, 'administrator', '2024-11-07 21:42:41', 'Added Resident named Dela Cruz, Juan  Pepito'),
(165, 'administrator', '2024-11-07 21:59:41', 'Updated Resident named Duterte, Sara hehe'),
(166, 'administrator', '2024-11-07 21:59:50', 'Updated Resident named Duterte, digong hehe'),
(167, 'administrator', '2024-11-07 22:00:08', 'Updated Resident named Casubha, Ashley Mendoza'),
(168, 'administrator', '2024-11-08 13:24:58', 'Added Zone number '),
(169, 'administrator', '2024-11-08 14:30:06', 'Updated Resident named Juan, Zofia Zurita'),
(170, 'administrator', '2024-11-08 14:31:00', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(171, 'administrator', '2024-11-08 14:31:07', 'Updated Resident named Duterte, Sara hehe'),
(172, 'administrator', '2024-11-08 14:31:15', 'Updated Resident named Casubha, Ashley Mendoza'),
(173, 'administrator', '2024-11-08 14:31:21', 'Updated Resident named Barroso, Lauriene Nofuente'),
(174, 'administrator', '2024-11-08 14:31:29', 'Updated Resident named Duterte, digong hehe'),
(175, 'administrator', '2024-11-08 14:45:02', 'Updated Resident named Juan, Zofia Zurita'),
(176, 'administrator', '2024-11-08 14:45:25', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(177, 'administrator', '2024-11-08 14:45:32', 'Updated Resident named Juan, Zofia Zurita'),
(178, 'administrator', '2024-11-08 15:09:25', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(179, 'administrator', '2024-11-08 15:09:31', 'Updated Resident named Juan, Zofia Zurita'),
(180, 'administrator', '2024-11-08 15:09:43', 'Updated Resident named Juan, Zofia Zurita'),
(181, 'administrator', '2024-11-08 15:09:49', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(182, 'administrator', '2024-11-08 15:11:31', 'Updated Resident named Juan, Zofia Zurita'),
(183, 'administrator', '2024-11-08 15:12:19', 'Updated Resident named Juan, Zofia Zurita'),
(184, 'administrator', '2024-11-08 15:13:10', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(185, 'administrator', '2024-11-08 15:15:05', 'Updated Resident named Dela Cruz, Juan  Pepito'),
(186, 'administrator', '2024-11-08 15:15:13', 'Updated Resident named Juan, Zofia Zurita'),
(187, 'administrator', '2024-11-08 15:16:26', 'Added Resident named Casubha, Lucky Star M.'),
(188, 'staff', '2024-11-08 15:51:24', 'Updated Resident named Dela Cruz, Juan  Pepita'),
(189, 'administrator', '2024-11-08 17:36:40', 'Added Resident named wdwjn, msjcnj nscjnqj'),
(190, 'administrator', '2024-11-08 17:36:50', 'Updated Resident named wdwjn, msjcnj nscjnqj'),
(191, 'administrator', '2024-11-10 14:56:08', 'Updated Members named Dela Cruz, Juan  Pepita'),
(192, 'administrator', '2024-11-10 16:50:47', 'Added Members named Manaloto, Pepito juje'),
(193, 'administrator', '2024-11-10 17:02:24', 'Updated Member named Dela Cruz, Juan  Pepita'),
(194, 'administrator', '2024-11-10 17:08:11', 'Updated Member named Manaloto, Pepito juje'),
(195, 'administrator', '2024-11-10 17:08:47', 'Updated Member named Duterte, digong hehe'),
(196, 'administrator', '2024-11-10 17:09:20', 'Updated Member named Dela Cruz, Juan  Pepita'),
(197, 'administrator', '2024-11-10 20:57:22', 'Added Official named Naag, Gracia'),
(198, 'administrator', '2024-11-10 20:57:31', 'Update Official named Dela Cruz, Juan C.'),
(199, 'staff', '2024-11-12 22:57:07', 'Added Official named '),
(200, 'administrator', '2024-11-13 22:05:22', 'Added Activity '),
(201, 'administrator', '2024-11-13 22:05:41', 'Added Activity '),
(202, 'administrator', '2024-11-13 22:09:44', 'Added Official named Padilla, Alden'),
(203, 'administrator', '2024-11-13 22:11:42', 'Update Official named Padilla, Alden'),
(204, 'administrator', '2024-11-13 22:13:24', 'Added Official named Padilla, Alden'),
(205, 'administrator', '2024-11-13 23:54:26', 'Added Member named ,  '),
(206, 'administrator', '2024-11-14 00:13:15', 'Added Official named Almodovar, Kurt'),
(207, 'administrator', '2024-11-15 19:19:59', 'Added Official named Casubha,Lucky Star'),
(208, 'administrator', '2024-11-16 19:53:48', 'Updated Activity Ayuda'),
(209, 'administrator', '2024-11-16 20:12:52', 'Update Official named Casubha,Lucky Star'),
(210, 'administrator', '2024-11-16 20:13:47', 'Update Official named Casubha,Lucky Star'),
(211, 'administrator', '2024-11-16 20:14:06', 'Update Official named Casubha,Lucky Star'),
(212, 'administrator', '2024-11-16 20:14:51', 'Updated Member named Manaloto, Pepito Maku'),
(213, 'administrator', '2024-11-16 21:38:01', 'Update Official named Alvares, Juanito'),
(214, 'administrator', '2024-11-16 21:38:53', 'Update Official named Bato, Max'),
(215, 'administrator', '2024-11-16 21:39:10', 'Update Official named Padilla, Mark'),
(216, 'administrator', '2024-11-16 21:45:57', 'Update Official named Isagon, Giean'),
(217, 'administrator', '2024-11-16 21:47:10', 'Updated Member named Dimagiba, Rosalinda Cruz'),
(218, 'administrator', '2024-11-16 21:47:38', 'Updated Member named Ravena, Kiefer Muwey'),
(219, 'administrator', '2024-11-16 21:48:17', 'Updated Member named Dela Cruz, Jessy Mendoza'),
(220, 'administrator', '2024-11-16 21:49:04', 'Updated Member named Garcia, Betty Licando'),
(221, 'staff', '2024-11-16 21:58:07', 'Updated Activity Ayuda'),
(222, 'administrator', '2024-11-17 19:12:19', 'Updated Member named Dela Cruz, Jessy Mendoza'),
(223, 'administrator', '2024-11-17 19:13:04', 'Updated Member named Dela Cruz, Jessy Mendoza'),
(224, 'administrator', '2024-11-17 19:13:16', 'Updated Member named Garcia, Betty Rose Licando'),
(225, 'staff', '2024-11-18 17:51:09', 'Added Official named Casubha, Inorio'),
(226, 'staff', '2024-11-18 17:58:29', 'Added Member named Casubha, Nelia Mendoza'),
(227, 'staff', '2024-11-18 18:00:52', 'Added Activity Meeint'),
(228, 'staff', '2024-11-18 18:01:05', 'Updated Activity Meeting'),
(229, 'administrator', '2024-11-18 18:06:16', 'Updated Member named Casubha, Lucky Star M.'),
(230, 'administrator', '2024-11-18 18:07:54', 'Added Member named Casubha, Lucky Star Mendoza'),
(231, 'administrator', '2024-11-18 18:08:27', 'Updated Member named Casubha, Lucky Star Mendoza'),
(232, 'administrator', '2024-11-18 18:08:58', 'Updated Member named Casubha, Lucky Star Mendoza'),
(233, 'administrator', '2024-11-18 18:13:57', 'Updated Member named Dela Cruz, Jessy Mendoza'),
(234, 'administrator', '2024-11-20 21:25:11', 'Added Member named Ravema, Kiefer Muwey'),
(235, 'administrator', '2024-11-20 21:25:33', 'Updated Member named Ravena, Kiefer Muwey'),
(236, 'administrator', '2024-11-20 21:27:41', 'Added Member named Dimagiba, Rosalinda Cruz'),
(237, 'administrator', '2024-11-20 21:28:37', 'Added Member named Dimagiba, Rosalinda Cruz'),
(238, 'administrator', '2024-11-20 21:33:38', 'Added Official named Padilla, Mark'),
(239, 'administrator', '2024-11-20 21:34:27', 'Added Official named Padilla, Mark'),
(240, 'administrator', '2024-11-20 21:35:33', 'Added Official named Padilla, Mark'),
(241, 'administrator', '2024-11-20 21:36:37', 'Added Official named Padilla, Mark'),
(242, 'administrator', '2024-11-20 21:38:14', 'Added Official named Padilla, Mark'),
(243, 'administrator', '2024-11-20 21:40:55', 'Added Official named Padilla, Mark'),
(244, 'administrator', '2024-11-20 21:43:18', 'Added Official named Padilla, Mark'),
(245, 'administrator', '2024-11-20 21:45:32', 'Added Official named Padilla, Mark'),
(246, 'administrator', '2024-11-20 21:47:21', 'Added Official named Buyhe, John '),
(247, 'administrator', '2024-11-20 21:48:13', 'Added Member named Dimagiba, Rosalinda Cruz'),
(248, 'administrator', '2024-11-20 21:49:05', 'Added Member named Gonzales, Hanna Mahil'),
(249, 'administrator', '2024-11-20 21:51:25', 'Added Member named Taa, Criza Mendoza'),
(250, 'administrator', '2024-11-20 21:54:17', 'Added Official named Isagon, Giean'),
(251, 'administrator', '2024-11-20 22:39:00', 'Updated Activity Ayuda'),
(252, 'administrator', '2024-11-22 20:09:13', 'Updated Member named Gonzales, Hanna Mahil'),
(253, 'administrator', '2024-11-22 20:15:28', 'Updated Member named Gonzales, Hanna Mahil'),
(254, 'bfarmcadmin', '2024-11-22 20:17:14', 'Update Official named Padilla, Mark'),
(255, 'bfarmcadmin', '2024-11-22 20:19:40', 'Updated Member named Gonzales, Hanna Mahil'),
(256, 'lucky123', '2024-11-22 20:23:18', 'Updated Activity Ayuda'),
(257, 'lucky123', '2024-11-22 20:24:07', 'Added Official named Fornal, Jeruh'),
(258, 'zofia123', '2024-11-22 20:30:44', 'Updated Member named Taa, Criza Mendoza'),
(259, 'jade123', '2024-11-22 20:32:09', 'Updated Member named Ravena, Kiefer Muwey'),
(260, 'bfarmcadmin', '2024-11-22 20:33:32', 'Updated Activity Ayuda'),
(261, 'bfarmcadmin', '2024-11-22 20:34:08', 'Update Official named Karikitan, John '),
(262, 'bfarmcadmin', '2024-11-25 00:38:45', 'Added Member named Naag, Gracia Menil'),
(263, 'bfarmcadmin', '2024-11-27 22:08:27', 'Added Official named Dictado, Jerrick'),
(264, 'bfarmcadmin', '2024-11-27 22:45:27', 'Update Official named Dela Cruz, Juan C.'),
(265, 'bfarmcadmin', '2024-12-04 17:12:30', 'Added Member named Amarante, Anselmo Carait'),
(266, 'bfarmcadmin', '2024-12-04 17:17:32', 'Updated Member named Amarante, Anselmo Carait'),
(267, 'bfarmcadmin', '2024-12-04 17:18:51', 'Added Member named Amarante, Anselmo Carait'),
(268, 'bfarmcadmin', '2024-12-04 17:19:12', 'Updated Member named Amarante, Anselmo Carait'),
(269, 'bfarmcadmin', '2024-12-04 17:20:17', 'Updated Member named Gonzales, Hanna Mahil'),
(270, 'bfarmcadmin', '2024-12-04 17:27:01', 'Updated Member named Gonzales, Hanna Mahil'),
(271, 'bfarmcadmin', '2024-12-04 17:27:26', 'Updated Member named Amarante, Anselmo Carait'),
(272, 'bfarmcadmin', '2024-12-04 17:28:27', 'Updated Member named Ravena, Kiefer Muwey'),
(273, 'bfarmcadmin', '2024-12-04 17:28:39', 'Updated Member named Dela Cruz, Jessy Mendoza'),
(274, 'bfarmcadmin', '2024-12-04 17:28:51', 'Updated Member named Garcia, Betty Rose Licando'),
(275, 'bfarmcadmin', '2024-12-04 18:28:01', 'Updated Member named Amarante, Anselmo Carait'),
(276, 'bfarmcadmin', '2024-12-04 18:49:20', 'Updated Member named Amoranto, Mae Bato'),
(277, 'bfarmcadmin', '2024-12-04 18:50:51', 'Updated Member named Amarante, Cris Carait'),
(278, 'bfarmcstaff', '2024-12-06 22:14:12', 'Update Official named Isagon, Giean'),
(279, 'bfarmcstaff', '2024-12-06 22:14:24', 'Updated Member named Taa, Criza Mendoza'),
(280, 'bfarmcadmin', '2024-12-15 23:59:57', 'Added Activity Cleaning'),
(281, 'bfarmcadmin', '2024-12-16 00:00:06', 'Updated Activity Cleaning'),
(282, 'bfarmcadmin', '2024-12-16 00:00:54', 'Added Official named hehe'),
(283, 'bfarmcadmin', '2024-12-20 22:24:38', 'Added Official named Lucky Star Mendoza Casubha'),
(284, 'bfarmcadmin', '2024-12-20 22:28:35', 'Added Member named Casubha, Inorio Cruz');

-- --------------------------------------------------------

--
-- Table structure for table `tblofficial`
--

CREATE TABLE `tblofficial` (
  `id` int(11) NOT NULL,
  `sPosition` varchar(50) NOT NULL,
  `completeName` text NOT NULL,
  `pcontact` varchar(20) NOT NULL,
  `paddress` text NOT NULL,
  `termStart` date NOT NULL,
  `termEnd` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `archive` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblofficial`
--

INSERT INTO `tblofficial` (`id`, `sPosition`, `completeName`, `pcontact`, `paddress`, `termStart`, `termEnd`, `status`, `archive`) VALUES
(12, 'President', 'Dela Cruz, Juan C.', '09236781913', 'Purok 2 Sinalhan', '2024-10-16', '2024-11-08', 'End Term', 0),
(15, 'Vice President', 'Delos Santos, Sergio', '09901789111', '647 Purok 2 Sinalhan', '2023-03-01', '2024-11-09', 'Ongoing Term', 1),
(17, 'Public Relations Officer', 'Padilla, Mark', '099087618912', 'Purok 2 Sinalhan', '2024-09-29', '2024-10-31', 'Ongoing Term', 0),
(18, 'Sergeant at Arms', 'Barreto, leon', '09097618171', 'Purok 6', '2023-02-14', '2024-11-09', 'Ongoing Term', 1),
(19, 'Vice President', 'Bato, Max', '09907817161', 'Purok 4, Sinalhan', '2023-04-05', '2025-03-11', 'Ongoing Term', 0),
(20, 'President', 'Isagon, Giean', '09236781914', 'Purok  5 Sinalhan', '2023-01-30', '2024-02-05', 'Ongoing Term', 1),
(22, 'Treasurer', 'Almodovar, Kurt', '09128798171', 'Purok 2 Sinalhan', '2024-10-29', '2024-12-04', 'End Term', 0),
(23, 'Public Relations Officer', 'Alvares, Juanito', '09198789181', 'Purok 6 Sinalhan', '2023-02-08', '2024-11-26', 'Ongoing Term', 0),
(24, 'Vice President', 'Casubha, Inorio', '09121289181', 'Purok  6 Sinalhan', '2023-01-31', '2024-12-06', 'Ongoing Term', 1),
(25, 'Sergeant at Arms', 'Karikitan, John ', '09198987181', 'Purok 2 Sinalhan', '2023-01-01', '2025-01-20', 'Ongoing Term', 0),
(26, 'Sergeant at Arms', 'Fornal, Jeruh', '09908718191', 'Purok 2 Sinalhan', '2021-12-27', '2024-12-07', 'Ongoing Term', 0),
(27, 'Secretary', 'Dictado, Jerrick', '09907618171', 'Purok 2 Sinalhan', '2023-05-09', '2025-05-09', 'Ongoing Term', 0),
(28, 'Secretary', 'hehe', '09198918191', 'Purok 1', '2024-12-01', '2025-01-11', 'Ongoing Term', 1),
(29, 'President', 'Lucky Star Mendoza Casubha', '09817776517', 'Purok 2 Sinalhan', '2024-12-01', '2025-01-11', 'Ongoing Term', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblresident`
--

CREATE TABLE `tblresident` (
  `id` int(11) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `barangay` varchar(120) NOT NULL,
  `zone` varchar(5) NOT NULL,
  `hnumber` int(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `cpnumber` varchar(15) DEFAULT NULL,
  `type` text NOT NULL,
  `image` text NOT NULL,
  `archive` tinyint(1) DEFAULT 0,
  `has_boat` varchar(4) DEFAULT '0',
  `boat_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblresident`
--

INSERT INTO `tblresident` (`id`, `lname`, `fname`, `mname`, `bdate`, `age`, `barangay`, `zone`, `hnumber`, `gender`, `cpnumber`, `type`, `image`, `archive`, `has_boat`, `boat_number`) VALUES
(19, 'Dela Cruz', 'Jessy', 'Mendoza', '1994-02-05', 30, 'Sinalhan', '5', 655, 'Female', '09909876181', 'Fisherman', '1730049567353_idpic.png', 1, 'No', ''),
(22, 'Ravena', 'Kiefer', 'Muwey', '1976-02-10', 48, 'Sinalhan', '3', 509, 'Male', '09817776517', 'Fisherman', '1730049581675_idpic.png', 0, 'Yes', '2024-008'),
(33, 'Duterte', 'Sara', 'hehe', '2013-01-29', 11, 'Sinalhan', '3', 1212, 'Female', '09213218191', 'Fisherman', '1730367659245_idpic.png', 1, '0', NULL),
(34, 'Dimagiba', 'Rosalinda', 'Cruz', '2003-06-09', 21, 'Sinalhan', '4', 1212, 'Female', '09213218191', 'Fish Vendor', '1730367798984_idpic.png', 1, '0', NULL),
(35, 'Garcia', 'Betty Rose', 'Licando', '1995-03-09', 29, 'Sinalhan', '6', 123, 'Female', '09908767181', 'Fisherman', '1730986873397_idpic.png', 0, 'Yes', '2024-011'),
(36, 'Dela Cruz', 'Juan ', 'Pepita', '1963-06-04', 61, 'Sinalhan', '1', 521, 'Male', '09213218191', 'Fisherman', '1730986961660_idpic.png', 1, '0', NULL),
(38, 'wdwjn', 'msjcnj', 'nscjnqj', '2009-06-09', 15, 'Sinalhan', '2', 121, 'Female', '09817776517', 'Fisherman', '1731058610372_idpic.png', 1, '0', NULL),
(39, 'Manaloto', 'Pepito', 'Maku', '1984-02-08', 40, 'Sinalhan', '1', 121, 'Male', '09817776517', 'Fisherman', '1731228647385_idpic.png', 1, '0', NULL),
(41, 'Casubha', 'Nelia', 'Mendoza', '2012-02-06', 12, 'Sinalhan', '3', 411, 'Female', '09817776517', 'Fish Vendor', '1731923909368_idpic.png', 1, '0', NULL),
(44, 'Gonzales', 'Hanna', 'Mahil', '1989-06-14', 35, 'Sinalhan', '1', 579, 'Female', '09817776517', 'Fisherman', '1732110545916_idpic.png', 1, 'Yes', '2024-010'),
(45, 'Taa', 'Criza', 'Mendoza', '1978-03-25', 46, 'Sinalhan', '2', 578, 'Female', '09817776517', 'Fish Vendor', '1732110685232_idpic.png', 0, '', ''),
(46, 'Amoranto', 'Mae', 'Bato', '2003-11-27', 21, 'Sinalhan', '1', 578, 'Female', '09817776517', 'Fish Vendor', '1732466325203_idpic.png', 0, '', ''),
(48, 'Amarante', 'Cris', 'Carait', '1986-07-17', 38, 'Sinalhan', '2', 121, 'Male', '09817776517', 'Fisherman', '1733303931683_idpic.png', 0, 'Yes', '2024-009'),
(49, 'Casubha', 'Inorio', 'Cruz', '1978-02-07', 46, 'Sinalhan', '2', 231, 'Male', '09876891011', 'Fish Vendor', '1734704915113_idpic.png', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `archive` tinyint(1) DEFAULT 0,
  `temp_key` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `role`, `archive`, `temp_key`) VALUES
(25, '', '', '', 'bfarmcadmin', '$2y$10$oYcZKJiFMwiZQsosB4AywuEuMLXu44YYRuYBQotGYXTgWOtRgWQKm', 'administrator', 0, ''),
(26, 'bfarmc', 'staff', 'bfarmc@gmail.com', 'bfarmcstaff', '$2y$10$2RTvmE2TN86SoYwcu.3QsugLky0ZIWuz9GrUzJzOTZli1ROJToiQ.', 'staff', 0, ''),
(28, 'lucky', 'casubha', 'casubhalucky5@gmail.com', 'lucky123', '$2y$10$CZs0AneaACUUnp//rDOoaelVbyD9dNumJoxfUMP849jlHclN/zB3q', 'staff', 0, ''),
(29, 'Zofia', 'Juan', 'zofiaj', 'zofia123', '$2y$10$k81637iRQLHy17ckMiNwoe4ruYiggdr6IHJ6M58BCmE0ELlzUXPCi', 'staff', 0, ''),
(30, 'jade', 'barroso', 'jade@gmail.com', 'jade123', '$2y$10$hXbg3cAYHA8QWX5WELF2FuVKvsA6ixBWdsDn8WYl4CC02DYpALiQO', 'staff', 0, ''),
(31, 'gracia', 'naag', 'gracia@gmail.com', 'gracia123', '$2y$10$Sv3dJQGRnMFFZIoFiQ21GuIgomsudCf9anxmgiMBN35uqGWK0i3nu', 'staff', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tblzone`
--

CREATE TABLE `tblzone` (
  `id` int(5) NOT NULL,
  `zone` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblzone`
--

INSERT INTO `tblzone` (`id`, `zone`, `username`, `password`) VALUES
(2, '5', 'Sergio', 'Sergio123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblactivity`
--
ALTER TABLE `tblactivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblactivityphoto`
--
ALTER TABLE `tblactivityphoto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbllogs`
--
ALTER TABLE `tbllogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblofficial`
--
ALTER TABLE `tblofficial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblresident`
--
ALTER TABLE `tblresident`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblzone`
--
ALTER TABLE `tblzone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblactivity`
--
ALTER TABLE `tblactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblactivityphoto`
--
ALTER TABLE `tblactivityphoto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbllogs`
--
ALTER TABLE `tbllogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT for table `tblofficial`
--
ALTER TABLE `tblofficial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tblresident`
--
ALTER TABLE `tblresident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
