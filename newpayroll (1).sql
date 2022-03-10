-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2022 at 10:19 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newpayroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `columnName` varchar(100) DEFAULT NULL,
  `beforeValue` varchar(255) DEFAULT NULL,
  `afterValue` varchar(255) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `name`, `action`, `columnName`, `beforeValue`, `afterValue`, `time`, `date`) VALUES
(19, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:10:22am', '2022/01/29'),
(20, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:19:49am', '2022/01/29'),
(21, 'Francis Ilacad', 'login', NULL, NULL, NULL, '02:06:40pm', '2022/01/29'),
(22, 'Francis Ilacad', 'login', NULL, NULL, NULL, '03:45:29pm', '2022/01/29'),
(23, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:45:58pm', '2022/01/29'),
(24, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:48:28pm', '2022/01/29'),
(25, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '03:51:05pm', '2022/01/29'),
(26, 'Francis Ilacad', 'login', NULL, NULL, NULL, '05:53:33am', '2022/01/30'),
(27, 'Francis Ilacad', 'login', NULL, NULL, NULL, '06:23:49am', '2022/01/30'),
(28, 'Francis Ilacad', 'Add Secretary', NULL, NULL, NULL, '06:24:32am', '2022/01/30'),
(29, 'Francis Ilacad', 'login', NULL, NULL, NULL, '07:56:57am', '2022/01/30'),
(30, 'Francis Ilacad', 'login', NULL, NULL, NULL, '09:16:38am', '2022/01/30'),
(31, 'Francis Ilacad', 'login', NULL, NULL, NULL, '10:19:01am', '2022/01/30'),
(32, 'Francis Ilacad', 'login', NULL, NULL, NULL, '03:05:20 PM', '2022/01/30'),
(33, 'cho ureta', 'login', NULL, NULL, NULL, '03:13:34 PM', '2022/01/30'),
(34, 'Francis Ilacad', 'login', NULL, NULL, NULL, '10:59:07 AM', '2022/01/31');

-- --------------------------------------------------------

--
-- Table structure for table `automatic_generated_salary`
--

CREATE TABLE `automatic_generated_salary` (
  `log` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `total_hours` float DEFAULT NULL,
  `standard_pay` float DEFAULT NULL,
  `regular_holiday` int(11) DEFAULT NULL,
  `regular_holiday_pay` float DEFAULT NULL,
  `special_holiday` int(11) DEFAULT NULL,
  `special_holiday_pay` float DEFAULT NULL,
  `thirteenmonth` float DEFAULT NULL,
  `sss` float DEFAULT NULL,
  `pagibig` float DEFAULT NULL,
  `philhealth` float DEFAULT NULL,
  `cashbond` float DEFAULT NULL,
  `vale` float DEFAULT NULL,
  `total_hours_late` int(11) DEFAULT NULL,
  `total_gross` float DEFAULT NULL,
  `total_deduction` float DEFAULT NULL,
  `total_netpay` float DEFAULT NULL,
  `start` varchar(50) DEFAULT NULL,
  `end` varchar(50) DEFAULT NULL,
  `for_release` varchar(20) DEFAULT NULL,
  `date_created` varchar(50) DEFAULT NULL,
  `date_released` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `automatic_generated_salary`
--

INSERT INTO `automatic_generated_salary` (`log`, `emp_id`, `total_hours`, `standard_pay`, `regular_holiday`, `regular_holiday_pay`, `special_holiday`, `special_holiday_pay`, `thirteenmonth`, `sss`, `pagibig`, `philhealth`, `cashbond`, `vale`, `total_hours_late`, `total_gross`, `total_deduction`, `total_netpay`, `start`, `end`, `for_release`, `date_created`, `date_released`) VALUES
(456, 1002, 35.1333, 2091.24, 0, 0, 12, 214.283, 0, 450, 200, 350, 50, 0, 0, 2305.52, 1050, 1255.52, '2022/02/01', '2022/01/03', 'For Release', 'March 11, 2022 04:03:57 AM', NULL),
(457, 1002, 35.1333, 2091.24, 24, 1428.55, 0, 0, 0, 450, 200, 350, 50, 0, 0, 3519.79, 1050, 2469.79, '2022/12/30', '2022/01/03', 'For Release', 'March 11, 2022 04:10:02 AM', NULL),
(458, 1001, 117.283, 6981.06, 0, 0, 0, 0, 0, 450, 200, 350, 50, 0, 2, 6981.06, 1050, 5931.06, '2022/03/01', '2022/03/10', 'For Release', 'March 11, 2022 04:13:31 AM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `empId` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `hired_guards` varchar(100) NOT NULL,
  `cpnumber` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comp_location` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `position0` varchar(100) NOT NULL,
  `price0` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `shifts` varchar(100) NOT NULL,
  `shifts_span` varchar(100) NOT NULL,
  `day_start` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `hired_guards`, `cpnumber`, `email`, `comp_location`, `longitude`, `latitude`, `type`, `position0`, `price0`, `date`, `shifts`, `shifts_span`, `day_start`) VALUES
(1, 'Mcdo', '', '09123456789', 'mcdo@gmail.com', 'Tandang Sora', '123', '123', 'Manual', 'Officer in Chief', '56.0', 'February 4, 2022', 'Day', '8', '6:00:00 AM');

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `log` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `sss` float NOT NULL,
  `philhealth` float NOT NULL,
  `pagibig` float NOT NULL,
  `cashbond` float NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `deduction` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `duty` int(11) DEFAULT NULL,
  `cutoff` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction`, `position`, `duty`, `cutoff`, `amount`) VALUES
(46, 'SSS', 'Security Officer', 8, 'Bi-weekly', 300),
(47, 'SSS', 'Security Officer', 12, 'Bi-weekly', 450),
(48, 'Pagibig', 'Security Officer', 8, 'Bi-weekly', 133),
(49, 'Pagibig', 'Security Officer', 12, 'Bi-weekly', 200),
(50, 'Philhealth', 'Security Officer', 8, 'Bi-weekly', 233),
(51, 'Philhealth', 'Security Officer', 12, 'Bi-weekly', 350),
(52, 'SSS', 'OIC', 8, 'Bi-weekly', 338),
(53, 'SSS', 'OIC', 12, 'Bi-weekly', 507),
(54, 'Pagibig', 'OIC', 8, 'Bi-weekly', 150),
(55, 'Pagibig', 'OIC', 12, 'Bi-weekly', 226),
(56, 'Philhealth', 'OIC', 8, 'Bi-weekly', 263),
(57, 'Philhealth', 'OIC', 12, 'Bi-weekly', 395);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `empId` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `cpnumber` varchar(13) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `ratesperDay` varchar(11) NOT NULL,
  `watType` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `access` varchar(100) DEFAULT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `timer` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `empId`, `firstname`, `lastname`, `cpnumber`, `address`, `position`, `ratesperDay`, `watType`, `email`, `password`, `access`, `availability`, `timer`, `time`, `date`) VALUES
(1, '1001', 'Arnel', 'Garcia', '09878678652', 'Nagkaisang Nayon', 'Security Officer', '59.523', 'Automatic', 'ag@gmail.com', 'ag123', 'employee', 'Unavailable', NULL, NULL, NULL),
(2, '1002', 'Salvador', 'Macaraeg', '09123245672', 'San Bartolome, Novaliches Quezon City', 'Security Officer', '59.523', 'Automatic', 'sm@gmail.com', 'sm123', 'Employee', 'Unavailable', '', NULL, NULL),
(3, '1003', 'Norman', 'Capugan', '09898787656', 'Sangandaan Quezon City', 'Security Officer', '59.523', 'Automatic', 'nc@gmail.com', 'nc123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(4, '1004', 'Jayson', 'Malones', '09456738746', 'Holy Spirit, Quezon City', 'Security Officer', '59.523', 'Automatic', 'jm@gmail.com', 'jm123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(5, '1005', 'Guilbert', 'Panes', '09874563742', 'Litex, Quezon City', 'Security Officer', '59.523', 'Automatic', 'gp@gmail.com', 'gp123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(6, '1006', 'Gerry', 'Yape', '09826447463', 'Commonwealth, Quezon City', 'Security Officer', '59.523', 'Automatic', 'gy@gmail.com', 'gy123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(7, '1007', 'Rolando', 'Naciso', '09812374653', 'Batasan, Quezon City', 'Security Officer', '59.523', 'Automatic', 'rn@gmail.com', 'rn123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(8, '1008', 'Joseph', 'Ligsanan', '09123456789', 'Munoz, Quezon City', 'Security Officer', '59.523', 'Automatic', 'jl@gmail.com', 'jl123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(9, '1009', 'Rolly', 'Bustarde', '09897865234', 'Sampaloc, Manila City', 'Security Officer', '59.523', 'Automatic', 'rb@gmail.com', 'rb123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(10, '1010', 'Arce', 'Gole', '09898978787', 'Bataan st, Manila City', 'Security Officer', '59.523', 'Automatic', 'ag@gmail.com', 'ag123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(11, '1011', 'Nelson', 'Decastro', '09897856782', 'Balic Balic, Manila City', 'Security Officer', '59.523', 'Automatic', 'nd@gmail.com', 'nd123', 'Employee', 'Unavailable', NULL, NULL, NULL),
(12, '1012', 'Kennet', 'Murillo', '09896723546', 'Bagbaguin, Caloocan City', 'Security Officer', '59.523', 'Automatic', 'km@gmail.com', 'km123', 'Employee', 'Unavailable', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance`
--

CREATE TABLE `emp_attendance` (
  `id` int(11) NOT NULL,
  `empId` varchar(50) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `timeIn` varchar(20) DEFAULT NULL,
  `timeOut` varchar(20) DEFAULT NULL,
  `datetimeIn` varchar(100) DEFAULT NULL,
  `datetimeOut` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `salary_status` varchar(50) NOT NULL,
  `login_session` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_attendance`
--

INSERT INTO `emp_attendance` (`id`, `empId`, `company`, `timeIn`, `timeOut`, `datetimeIn`, `datetimeOut`, `location`, `status`, `salary_status`, `login_session`) VALUES
(62, '1002', 'Mcdo Baesa', '08:56:00 AM', '8:00:00 PM', '2022/01/01', '2022/01/01', 'Baesa, Quezon City', 'Late', 'unpaid', 'true'),
(65, '1002', 'Mcdo Baesa', '07:56:00 AM', '8:00:00 PM', '2022/01/02', '2022/01/02', 'Baesa Quezon City', 'Ontime', 'unpaid', 'true'),
(66, '1002', 'Mcdo Baesa', '8:00:00 AM', '8:00:00 PM', '2022/01/03', '2022/01/03', 'Baesa, Quezon City', 'ontime', 'unpaid', 'true'),
(68, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/02', '2022/02/02', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(69, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/03', '2022/02/03', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(70, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/04', '2022/02/04', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(71, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/05', '2022/02/05', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(72, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/06', '2022/02/06', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(73, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/07', '2022/02/07', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(74, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/08', '2022/02/08', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(75, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/09', '2022/02/09', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(76, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/10', '2022/02/10', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(77, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/11', '2022/02/11', 'Sauyo High', 'ontime', 'unpaid', 'true'),
(78, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/12', '2022/02/12', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(79, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/13', '2022/02/13', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(80, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/14', '2022/02/14', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(81, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/25', '2022/02/25', 'Sauyo, QC', 'ontime', 'unpaid', 'true'),
(83, '1004', 'Mcdo Holy Spirit', '8:00 AM', '8:00 PM', '2022/03/01', '2022/03/01', 'Holy Spirit QC', 'Ontime', 'unpaid', NULL),
(84, '1004', 'Mcdo Holy Spirit', '7:56 AM', '8:00 PM', '2022/03/02', '2022/03/02', 'Holy Spirit QC', 'Ontime', 'unpaid', NULL),
(85, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/02', '2022/01/02', 'Sangandaan, QC', 'Ontime', 'unpaid', 'true'),
(86, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/03', '2022/01/03', 'Sangandaan, QC', 'Ontime', 'unpaid', 'true'),
(87, '1005', 'Jollibee, Sangandaan', '8:00 AM', '8:15 PM', '2022/01/04', '2022/01/04', 'Sangandaan, QC', 'Ontime', 'unpaid', 'true'),
(88, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/05', '2022/01/05', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(89, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/06', '2022/01/06', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(90, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/07', '2022/01/07', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(91, '1005', 'Jollibee, Sangandaan', '7:59 AM', '7:59 PM', '2022/01/08', '2022/01/08', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(92, '1005', 'Jollibee, Sangandaan', '8:00 AM', '8:00 PM', '2022/01/09', '2022/01/09', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(93, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/10', '2022/01/10', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(94, '1005', 'Jollibee, Sangandaan', '7:59 AM', '8:00 PM', '2022/01/11', '2022/01/11', 'Sangandaan, QC', 'ontime', 'unpaid', 'true'),
(95, '1001', 'QCU, San Bartolome', '7:59 AM', '8:00 PM', '2022/03/01', '2022/03/01', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(96, '1001', 'QCU, San Bartolome', '7:59 AM', '8:00 PM', '2022/03/02', '2022/03/02', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(97, '1001', 'QCU, San Bartolome', '7:59 AM', '8:00 PM', '2022/03/03', '2022/03/03', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(98, '1001', 'QCU, San Bartolome', '8:00 AM', '8:00 PM', '2022/03/04', '2022/03/04', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(99, '1001', 'QCU, San Bartolome', '7:59 AM', '7:59 PM', '2022/03/05', '2022/03/05', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(100, '1001', 'QCU, San Bartolome', '7:59 AM', '8:00 PM', '2022/03/06', '2022/03/06', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(101, '1001', 'QCU, San Bartolome', '8:00 AM', '7:59 PM', '2022/03/07', '2022/03/07', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(102, '1001', 'QCU, San Bartolome', '7:59 AM', '7:59 PM', '2022/03/08', '2022/03/08', 'San Bartolome, QC', 'ontime', 'unpaid', 'true'),
(103, '1001', 'QCU, San Bartolome', '9:23 AM', '8:00 PM', '2022/03/09', '2022/03/09', 'San Bartolome, QC', 'late', 'unpaid', 'true'),
(104, '1001', 'QCU, San Bartolome', '9:23 AM', '8:00 PM', '2022/03/10', '2022/03/10', 'San Bartolome, QC', 'late', 'unpaid', 'true'),
(105, '1002', 'Mcdo, Baesa', '8:30 AM', '8:00 PM', '2022/01/04', '2022/01/04', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(106, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/05', '2022/01/05', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(107, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/06', '2022/01/06', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(108, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/07', '2022/01/07', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(109, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/08', '2022/01/08', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(110, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/09', '2022/01/09', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(111, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/10', '2022/01/10', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(112, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/11', '2022/01/11', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(113, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/12', '2022/01/12', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(114, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/13', '2022/01/13', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(115, '1002', 'Mcdo, Baesa', '7:59 AM', '8:00 PM', '2022/01/14', '2022/01/14', 'Baesa, QC', 'ontime', 'unpaid', 'true'),
(116, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/03', '2022/03/03', 'Holy Spirit, QC', 'ontime', 'unpaid', 'true'),
(117, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/04', '2022/03/04', 'Holy Spirit, QC', 'ontime', 'unpaid', 'true'),
(118, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/05', '2022/03/05', 'Holy Spirit', 'ontime', 'unpaid', 'true'),
(119, '1004', 'Mcdo, Holy Spirit', '8:00 AM', '8:00 PM', '2022/03/06', '2022/03/06', 'Holy Spirit, QC', 'ontime', 'unp', 'true'),
(120, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/07', '2022/03/07', 'Holy Spirit', 'ontime', 'unpaid', 'true'),
(121, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/08', '2022/03/08', 'Holy Spirit, QC', 'ontime', 'unpaid', 'true'),
(122, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/09', '2022/03/09', 'Holy Spirit', 'ontime', 'unpaid', 'true'),
(123, '1004', 'Mcdo, Holy Spirit', '7:59 AM', '8:00 PM', '2022/03/10', '2022/03/10', 'Holy Spirit', 'ontime', 'unpaid', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `emp_info`
--

CREATE TABLE `emp_info` (
  `id` int(11) NOT NULL,
  `empId` varchar(255) NOT NULL,
  `companyId` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cpnumber` varchar(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL,
  `scheduleTimeIn` varchar(100) NOT NULL,
  `scheduleTimeOut` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timer` varchar(255) NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp_info`
--

INSERT INTO `emp_info` (`id`, `empId`, `companyId`, `firstname`, `lastname`, `address`, `cpnumber`, `status`, `access`, `position`, `scheduleTimeIn`, `scheduleTimeOut`, `email`, `password`, `timer`, `rate`) VALUES
(7, '1001', '1001', 'Arnel', 'Garcia', 'Sauyo', '09878765654', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'arnelgarcia@gmail.com', 'arnel123', '', 59.523),
(9, '1002', '1002', 'Salvador', 'Macaraeg', 'Baesa', '09898787654', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'sm@gmail.com', 'sm123', '', 0),
(10, '1003', '1003', 'Norman', 'Capugan', 'Sangandaan', '09263547812', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'nc@gmail.com', 'nc123', '', 0),
(11, '1004', '1004', 'Jayson', 'Malones', 'Novaliches', '09878263541', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'jm@gmail.com', 'jm123', '', 0),
(12, '1005', '1005', 'Guilbert', 'Panes', 'Nagkaisang Nayon', '09878623564', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'gp@gmail.com', 'gp123', '', 0),
(13, '1006', '1006', 'Gerry', 'Yape', 'Ugong', '09876547635', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'gy@gmail.com', 'gy123', '', 0),
(14, '1007', '1007', 'Rolando', 'Naciso', 'Gen t', '09988976235', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'rn@gmail.com', 'rn123', '', 0),
(15, '1008', '1008', 'Joseph', 'Ligsanan', 'Mulawinan', '09878765623', 'Unavailable', 'Employee', 'Security Officer', '0', '0', 'jl@gmail.com', 'jl123', '', 0),
(16, '1009', '1009', 'Rolly', 'Bustarde', 'Malabon', '09123876345', 'Unavailable', 'Employee', 'Security Officer', '', '', 'rb@gmail.com', 'rb123', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emp_schedule`
--

CREATE TABLE `emp_schedule` (
  `id` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `timeIn_schedule` varchar(255) DEFAULT NULL,
  `timeOut_schedule` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `generated_salary`
--

CREATE TABLE `generated_salary` (
  `log` int(11) NOT NULL,
  `emp_id` varchar(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rate_hour` float DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `hours_duty` float DEFAULT NULL,
  `regular_holiday` float DEFAULT NULL,
  `special_holiday` float DEFAULT NULL,
  `day_late` float DEFAULT NULL,
  `hrs_late` float DEFAULT NULL,
  `day_absent` float DEFAULT NULL,
  `hours_absent` float DEFAULT NULL,
  `no_of_work` float DEFAULT NULL,
  `sss` float DEFAULT NULL,
  `pagibig` float DEFAULT NULL,
  `philhealth` float DEFAULT NULL,
  `cashbond` float DEFAULT NULL,
  `vale` float DEFAULT NULL,
  `thirteenmonth` float DEFAULT NULL,
  `total_hours` float DEFAULT NULL,
  `regular_pay` float DEFAULT NULL,
  `regular_holiday_pay` float DEFAULT NULL,
  `special_holiday_pay` float DEFAULT NULL,
  `absent_pay` float DEFAULT NULL,
  `total_deduction` float DEFAULT NULL,
  `total_gross` float DEFAULT NULL,
  `total_netpay` float DEFAULT NULL,
  `dateandtime_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_holiday` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `date_holiday`, `type`) VALUES
(1, 'New Year’s Day ', 'January 1, 2022 ', 'Regular Holiday'),
(2, 'The Day of Valor', 'April 9, 2022', 'Regular Holiday'),
(3, 'Maundy Thursday', 'April 14, 2022', 'Regular Holiday'),
(4, 'Good Friday', 'April 15, 2022', 'Regular Holiday'),
(5, 'Labor Day', 'May 1, 2022', 'Regular Holiday'),
(6, 'Eid’l Fitr', 'May 3, 2022', 'Regular Holiday'),
(7, 'Independence Day', 'June 12, 2022', 'Regular Holiday'),
(8, 'National Heroes’ Day', 'August 29, 2022', 'Regular Holiday'),
(9, 'Bonifacio Day', 'November 30, 2022', 'Regular Holiday'),
(10, 'Christmas Day', 'December 25, 2022', 'Regular Holiday'),
(11, 'Rizal Day', 'December 30, 2022', 'Regular Holiday'),
(12, 'Chinese New Year', 'February 1, 2022', 'Special Holiday'),
(13, 'People Power Revolution', 'February 25, 2022', 'Special Holiday'),
(14, 'Black Saturday', 'April 16, 2022', 'Special Holiday'),
(15, 'Ninoy Aquino Day', 'August 21, 2022', 'Special Holiday'),
(16, 'All Saints’ Day', 'November 1, 2022', 'Special Holiday'),
(17, 'Immaculate Conception of Mary', 'December 8, 2022', 'Special Holiday'),
(18, 'All Souls’ Day', 'November 2, 2022', 'Special Holiday'),
(19, 'Christmas Eve', 'December 24, 2022', 'Special Holiday'),
(20, 'New Year’s Eve', 'December 31, 2022', 'Special Holiday');

-- --------------------------------------------------------

--
-- Table structure for table `salary_report`
--

CREATE TABLE `salary_report` (
  `id` int(11) NOT NULL,
  `empId` varchar(20) DEFAULT NULL,
  `january` float DEFAULT NULL,
  `february` float DEFAULT NULL,
  `march` float DEFAULT NULL,
  `april` float DEFAULT NULL,
  `may` float DEFAULT NULL,
  `june` float DEFAULT NULL,
  `july` float DEFAULT NULL,
  `august` float DEFAULT NULL,
  `september` float DEFAULT NULL,
  `october` float DEFAULT NULL,
  `november` float DEFAULT NULL,
  `december` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `empid` varchar(100) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `scheduleTimeIn` varchar(100) DEFAULT NULL,
  `scheduleTimeOut` varchar(100) DEFAULT NULL,
  `shift` varchar(100) DEFAULT NULL,
  `shift_span` int(11) DEFAULT NULL,
  `expiration_date` varchar(100) DEFAULT NULL,
  `date_assigned` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `empid`, `company`, `scheduleTimeIn`, `scheduleTimeOut`, `shift`, `shift_span`, `expiration_date`, `date_assigned`) VALUES
(1, '1001', 'QCU, San Bartolome', '8:00 AM', '8:00 PM', 'Day', 12, '2022/08/01', '2022-03-01'),
(2, '1002', 'Mcdo, Baesa', '8:00 AM', '8:00 PM', 'Day', 12, '2022/10/01', '2022-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `secretary`
--

CREATE TABLE `secretary` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `cpnumber` varchar(13) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `timer` varchar(50) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `access` varchar(100) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secretary`
--

INSERT INTO `secretary` (`id`, `firstname`, `lastname`, `gender`, `cpnumber`, `address`, `email`, `password`, `timer`, `admin_id`, `access`, `isDeleted`) VALUES
(2, 'megumi', 'chan', 'Male', '09097065121', 'Minecraft World', 'owshi@minecraft.com', 'fd15a131bf160018b870503a99d374a2', NULL, 1, 'secretary', NULL),
(3, 'pandesal', 'munggo', 'Female', '09060766219', 'Sauyo lang', 'herrerafrancismarianne@gmail.com', 'ad1354a5a5f27885657bd46843ddb69e', NULL, 1, 'secretary', NULL),
(6, 'itlog', 'pechay', 'Male', '09123456789', 'asd', 'johnrafaelconstantino01@gmail.com', '0b6d3310b371aa4e4122c67d7a62abf2', NULL, 1, 'secretary', NULL),
(8, 'Red', 'minecraft', 'Male', '091234556789', 'Brgy Dimahanap', 'red.jude.villanueva.cadornigara@gmail.com', '3c86ddb270471569a6b02000d54b570c', NULL, 1, 'secretary', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `secretary_log`
--

CREATE TABLE `secretary_log` (
  `id` int(11) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `time` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secretary_log`
--

INSERT INTO `secretary_log` (`id`, `sec_id`, `name`, `action`, `time`, `date`) VALUES
(658, 8, 'Red minecraft', 'Delete Automated Salary', '09:24:55 PM', '2022/03/10'),
(659, 8, 'Red minecraft', 'Delete Automated Salary', '09:24:59 PM', '2022/03/10'),
(660, 8, 'Red minecraft', 'Add Automated Salary', '09:25:56 PM', '2022/03/10'),
(661, 8, 'Red minecraft', 'Delete Automated Salary', '10:11:44 PM', '2022/03/10'),
(662, 8, 'Red minecraft', 'Add Automated Salary', '10:12:40 PM', '2022/03/10'),
(663, 8, 'Red minecraft', 'Delete Automated Salary', '10:14:21 PM', '2022/03/10'),
(664, 8, 'Red minecraft', 'Add Automated Salary', '10:14:27 PM', '2022/03/10'),
(665, 8, 'Red minecraft', 'Delete Automated Salary', '10:19:42 PM', '2022/03/10'),
(666, 8, 'Red minecraft', 'Add Automated Salary', '10:19:47 PM', '2022/03/10'),
(667, 8, 'Red minecraft', 'Delete Automated Salary', '10:23:35 PM', '2022/03/10'),
(668, 8, 'Red minecraft', 'Add Automated Salary', '10:23:38 PM', '2022/03/10'),
(669, 8, 'Red minecraft', 'Delete Automated Salary', '10:27:30 PM', '2022/03/10'),
(670, 8, 'Red minecraft', 'Add Automated Salary', '10:27:33 PM', '2022/03/10'),
(671, 8, 'Red minecraft', 'Delete Automated Salary', '10:28:06 PM', '2022/03/10'),
(672, 8, 'Red minecraft', 'Add Automated Salary', '10:28:11 PM', '2022/03/10'),
(673, 8, 'Red minecraft', 'Delete Automated Salary', '10:29:20 PM', '2022/03/10'),
(674, 8, 'Red minecraft', 'Add Automated Salary', '10:29:23 PM', '2022/03/10'),
(675, 8, 'Red minecraft', 'Delete Automated Salary', '10:52:53 PM', '2022/03/10'),
(676, 8, 'Red minecraft', 'Add Automated Salary', '10:52:57 PM', '2022/03/10'),
(677, 8, 'Red minecraft', 'Delete Automated Salary', '10:53:40 PM', '2022/03/10'),
(678, 8, 'Red minecraft', 'Add Automated Salary', '10:53:43 PM', '2022/03/10'),
(679, 8, 'Red minecraft', 'Delete Automated Salary', '10:54:33 PM', '2022/03/10'),
(680, 8, 'Red minecraft', 'Add Automated Salary', '10:54:36 PM', '2022/03/10'),
(681, 8, 'Red minecraft', 'Delete Automated Salary', '10:56:43 PM', '2022/03/10'),
(682, 8, 'Red minecraft', 'Add Automated Salary', '10:56:46 PM', '2022/03/10'),
(683, 8, 'Red minecraft', 'Delete Automated Salary', '10:59:08 PM', '2022/03/10'),
(684, 8, 'Red minecraft', 'Add Automated Salary', '10:59:13 PM', '2022/03/10'),
(685, 8, 'Red minecraft', 'Delete Automated Salary', '11:01:29 PM', '2022/03/10'),
(686, 8, 'Red minecraft', 'Add Automated Salary', '11:01:39 PM', '2022/03/10'),
(687, 8, 'Red minecraft', 'Delete Automated Salary', '11:02:28 PM', '2022/03/10'),
(688, 8, 'Red minecraft', 'Add Automated Salary', '11:02:30 PM', '2022/03/10'),
(689, 8, 'Red minecraft', 'Delete Automated Salary', '11:03:05 PM', '2022/03/10'),
(690, 8, 'Red minecraft', 'Add Automated Salary', '11:03:11 PM', '2022/03/10'),
(691, 8, 'Red minecraft', 'Delete Automated Salary', '11:03:25 PM', '2022/03/10'),
(692, 8, 'Red minecraft', 'Add Automated Salary', '11:03:27 PM', '2022/03/10'),
(693, 8, 'Red minecraft', 'Delete Automated Salary', '11:03:59 PM', '2022/03/10'),
(694, 8, 'Red minecraft', 'Add Automated Salary', '11:04:02 PM', '2022/03/10'),
(695, 8, 'Red minecraft', 'Delete Automated Salary', '11:05:21 PM', '2022/03/10'),
(696, 8, 'Red minecraft', 'Add Automated Salary', '11:05:23 PM', '2022/03/10'),
(697, 8, 'Red minecraft', 'Add Automated Salary', '11:05:32 PM', '2022/03/10'),
(698, 8, 'Red minecraft', 'Add Automated Salary', '11:05:45 PM', '2022/03/10'),
(699, 8, 'Red minecraft', 'Delete Automated Salary', '11:05:55 PM', '2022/03/10'),
(700, 8, 'Red minecraft', 'Delete Automated Salary', '11:05:59 PM', '2022/03/10'),
(701, 8, 'Red minecraft', 'Delete Automated Salary', '11:06:02 PM', '2022/03/10'),
(702, 8, 'Red minecraft', 'Add Automated Salary', '11:06:47 PM', '2022/03/10'),
(703, 8, 'Red minecraft', 'Add Automated Salary', '11:08:27 PM', '2022/03/10'),
(704, 8, 'Red minecraft', 'Add Automated Salary', '11:08:42 PM', '2022/03/10'),
(705, 8, 'Red minecraft', 'Delete Automated Salary', '11:09:12 PM', '2022/03/10'),
(706, 8, 'Red minecraft', 'Delete Automated Salary', '11:09:15 PM', '2022/03/10'),
(707, 8, 'Red minecraft', 'Delete Automated Salary', '11:09:18 PM', '2022/03/10'),
(708, 8, 'Red minecraft', 'Add Automated Salary', '11:09:23 PM', '2022/03/10'),
(709, 8, 'Red minecraft', 'Add Automated Salary', '11:09:53 PM', '2022/03/10'),
(710, 8, 'Red minecraft', 'Add Automated Salary', '11:10:55 PM', '2022/03/10'),
(711, 8, 'Red minecraft', 'Add Automated Salary', '11:11:53 PM', '2022/03/10'),
(712, 8, 'Red minecraft', 'Add Automated Salary', '11:12:40 PM', '2022/03/10'),
(713, 8, 'Red minecraft', 'Add Automated Salary', '11:13:01 PM', '2022/03/10'),
(714, 8, 'Red minecraft', 'Add Automated Salary', '11:15:09 PM', '2022/03/10'),
(715, 8, 'Red minecraft', 'Add Automated Salary', '11:15:29 PM', '2022/03/10'),
(716, 8, 'Red minecraft', 'Add Automated Salary', '11:15:58 PM', '2022/03/10'),
(717, 8, 'Red minecraft', 'Add Automated Salary', '11:16:13 PM', '2022/03/10'),
(718, 8, 'Red minecraft', 'Add Automated Salary', '11:16:42 PM', '2022/03/10'),
(719, 8, 'Red minecraft', 'Delete Automated Salary', '11:16:55 PM', '2022/03/10'),
(720, 8, 'Red minecraft', 'Delete Automated Salary', '11:16:59 PM', '2022/03/10'),
(721, 8, 'Red minecraft', 'Delete Automated Salary', '11:17:03 PM', '2022/03/10'),
(722, 8, 'Red minecraft', 'Add Automated Salary', '11:17:33 PM', '2022/03/10'),
(723, 8, 'Red minecraft', 'Add Automated Salary', '11:18:06 PM', '2022/03/10'),
(724, 8, 'Red minecraft', 'Add Automated Salary', '11:18:52 PM', '2022/03/10'),
(725, 8, 'Red minecraft', 'Add Automated Salary', '11:20:28 PM', '2022/03/10'),
(726, 8, 'Red minecraft', 'Delete Automated Salary', '11:21:12 PM', '2022/03/10'),
(727, 8, 'Red minecraft', 'Delete Automated Salary', '11:21:16 PM', '2022/03/10'),
(728, 8, 'Red minecraft', 'Delete Automated Salary', '11:21:19 PM', '2022/03/10'),
(729, 8, 'Red minecraft', 'Delete Automated Salary', '11:21:22 PM', '2022/03/10'),
(730, 8, 'Red minecraft', 'Add Automated Salary', '11:22:01 PM', '2022/03/10'),
(731, 8, 'Red minecraft', 'Add Automated Salary', '11:25:38 PM', '2022/03/10'),
(732, 8, 'Red minecraft', 'Add Automated Salary', '11:26:04 PM', '2022/03/10'),
(733, 8, 'Red minecraft', 'Add Automated Salary', '11:27:05 PM', '2022/03/10'),
(734, 8, 'Red minecraft', 'Add Automated Salary', '11:27:37 PM', '2022/03/10'),
(735, 8, 'Red minecraft', 'Add Automated Salary', '11:28:56 PM', '2022/03/10'),
(736, 8, 'Red minecraft', 'Add Automated Salary', '11:29:35 PM', '2022/03/10'),
(737, 8, 'Red minecraft', 'Add Automated Salary', '11:36:47 PM', '2022/03/10'),
(738, 8, 'Red minecraft', 'Add Automated Salary', '11:40:43 PM', '2022/03/10'),
(739, 8, 'Red minecraft', 'Add Automated Salary', '11:41:53 PM', '2022/03/10'),
(740, 8, 'Red minecraft', 'Add Automated Salary', '11:44:04 PM', '2022/03/10'),
(741, 8, 'Red minecraft', 'Add Automated Salary', '11:44:36 PM', '2022/03/10'),
(742, 8, 'Red minecraft', 'Add Automated Salary', '11:45:03 PM', '2022/03/10'),
(743, 8, 'Red minecraft', 'Add Automated Salary', '11:45:28 PM', '2022/03/10'),
(744, 8, 'Red minecraft', 'Add Automated Salary', '11:46:04 PM', '2022/03/10'),
(745, 8, 'Red minecraft', 'Add Automated Salary', '11:46:19 PM', '2022/03/10'),
(746, 8, 'Red minecraft', 'Add Automated Salary', '11:47:08 PM', '2022/03/10'),
(747, 8, 'Red minecraft', 'Add Automated Salary', '11:47:54 PM', '2022/03/10'),
(748, 8, 'Red minecraft', 'Add Automated Salary', '11:48:37 PM', '2022/03/10'),
(749, 8, 'Red minecraft', 'Add Automated Salary', '11:49:26 PM', '2022/03/10'),
(750, 8, 'Red minecraft', 'Add Automated Salary', '11:50:00 PM', '2022/03/10'),
(751, 8, 'Red minecraft', 'Add Automated Salary', '11:51:09 PM', '2022/03/10'),
(752, 8, 'Red minecraft', 'Add Automated Salary', '11:52:08 PM', '2022/03/10'),
(753, 8, 'Red minecraft', 'Add Automated Salary', '11:54:23 PM', '2022/03/10'),
(754, 8, 'Red minecraft', 'Add Automated Salary', '11:55:05 PM', '2022/03/10'),
(755, 8, 'Red minecraft', 'Add Automated Salary', '11:55:26 PM', '2022/03/10'),
(756, 8, 'Red minecraft', 'Add Automated Salary', '11:59:01 PM', '2022/03/10'),
(757, 8, 'Red minecraft', 'Add Automated Salary', '11:59:52 PM', '2022/03/10'),
(758, 8, 'Red minecraft', 'Add Automated Salary', '12:00:48 AM', '2022/03/11'),
(759, 8, 'Red minecraft', 'Add Automated Salary', '12:01:06 AM', '2022/03/11'),
(760, 8, 'Red minecraft', 'Add Automated Salary', '12:01:26 AM', '2022/03/11'),
(761, 8, 'Red minecraft', 'Add Automated Salary', '12:06:38 AM', '2022/03/11'),
(762, 8, 'Red minecraft', 'Add Automated Salary', '12:07:41 AM', '2022/03/11'),
(763, 8, 'Red minecraft', 'Add Automated Salary', '12:07:58 AM', '2022/03/11'),
(764, 8, 'Red minecraft', 'Add Automated Salary', '12:08:31 AM', '2022/03/11'),
(765, 8, 'Red minecraft', 'Add Automated Salary', '12:08:52 AM', '2022/03/11'),
(766, 8, 'Red minecraft', 'Add Automated Salary', '12:09:03 AM', '2022/03/11'),
(767, 8, 'Red minecraft', 'Add Automated Salary', '12:10:05 AM', '2022/03/11'),
(768, 8, 'Red minecraft', 'Add Automated Salary', '12:11:09 AM', '2022/03/11'),
(769, 8, 'Red minecraft', 'Add Automated Salary', '12:11:49 AM', '2022/03/11'),
(770, 8, 'Red minecraft', 'Add Automated Salary', '12:17:31 AM', '2022/03/11'),
(771, 8, 'Red minecraft', 'Add Automated Salary', '12:18:30 AM', '2022/03/11'),
(772, 8, 'Red minecraft', 'Add Automated Salary', '12:18:43 AM', '2022/03/11'),
(773, 8, 'Red minecraft', 'Add Automated Salary', '12:19:55 AM', '2022/03/11'),
(774, 8, 'Red minecraft', 'Add Automated Salary', '12:20:18 AM', '2022/03/11'),
(775, 8, 'Red minecraft', 'Add Automated Salary', '12:22:09 AM', '2022/03/11'),
(776, 8, 'Red minecraft', 'Add Automated Salary', '12:22:40 AM', '2022/03/11'),
(777, 8, 'Red minecraft', 'Add Automated Salary', '12:23:51 AM', '2022/03/11'),
(778, 8, 'Red minecraft', 'Add Automated Salary', '12:25:34 AM', '2022/03/11'),
(779, 8, 'Red minecraft', 'Add Automated Salary', '12:28:23 AM', '2022/03/11'),
(780, 8, 'Red minecraft', 'Add Automated Salary', '12:52:58 AM', '2022/03/11'),
(781, 8, 'Red minecraft', 'Delete Automated Salary', '12:54:04 AM', '2022/03/11'),
(782, 8, 'Red minecraft', 'Delete Automated Salary', '12:54:07 AM', '2022/03/11'),
(783, 8, 'Red minecraft', 'login', '01:05:31 AM', '2022/03/11'),
(784, 8, 'Red minecraft', 'login', '01:13:46 AM', '2022/03/11'),
(785, 8, 'Red minecraft', 'login', '01:44:00 AM', '2022/03/11'),
(786, 8, 'Red minecraft', 'login', '02:14:57 AM', '2022/03/11'),
(787, 8, 'Red minecraft', 'login', '02:15:27 AM', '2022/03/11'),
(788, 8, 'Red minecraft', 'login', '02:16:48 AM', '2022/03/11'),
(789, 8, 'Red minecraft', 'Add Automated Salary', '02:26:02 AM', '2022/03/11'),
(790, 8, 'Red minecraft', 'Released Salary', '02:27:04 AM', '2022/03/11'),
(791, 8, 'Red minecraft', 'Add Automated Salary', '02:57:40 AM', '2022/03/11'),
(792, 8, 'Red minecraft', 'Add Automated Salary', '03:09:16 AM', '2022/03/11'),
(793, 8, 'Red minecraft', 'Add Automated Salary', '03:11:42 AM', '2022/03/11'),
(794, 8, 'Red minecraft', 'Add Automated Salary', '03:12:24 AM', '2022/03/11'),
(795, 8, 'Red minecraft', 'Add Automated Salary', '03:17:24 AM', '2022/03/11'),
(796, 8, 'Red minecraft', 'Add Automated Salary', '03:22:15 AM', '2022/03/11'),
(797, 8, 'Red minecraft', 'Add Automated Salary', '03:25:40 AM', '2022/03/11'),
(798, 8, 'Red minecraft', 'Add Automated Salary', '03:27:05 AM', '2022/03/11'),
(799, 8, 'Red minecraft', 'Add Automated Salary', '03:35:27 AM', '2022/03/11'),
(800, 8, 'Red minecraft', 'Add Automated Salary', '03:38:07 AM', '2022/03/11'),
(801, 8, 'Red minecraft', 'Add Automated Salary', '03:45:46 AM', '2022/03/11'),
(802, 8, 'Red minecraft', 'Add Automated Salary', '03:46:41 AM', '2022/03/11'),
(803, 8, 'Red minecraft', 'Add Automated Salary', '03:47:12 AM', '2022/03/11'),
(804, 8, 'Red minecraft', 'Add Automated Salary', '03:52:36 AM', '2022/03/11'),
(805, 8, 'Red minecraft', 'Add Automated Salary', '03:56:03 AM', '2022/03/11'),
(806, 8, 'Red minecraft', 'Add Automated Salary', '03:57:42 AM', '2022/03/11'),
(807, 8, 'Red minecraft', 'Add Automated Salary', '04:00:32 AM', '2022/03/11'),
(808, 8, 'Red minecraft', 'Add Automated Salary', '04:01:20 AM', '2022/03/11'),
(809, 8, 'Red minecraft', 'Add Automated Salary', '04:01:34 AM', '2022/03/11'),
(810, 8, 'Red minecraft', 'Add Automated Salary', '04:02:09 AM', '2022/03/11'),
(811, 8, 'Red minecraft', 'Add Automated Salary', '04:03:57 AM', '2022/03/11'),
(812, 8, 'Red minecraft', 'Add Automated Salary', '04:10:02 AM', '2022/03/11'),
(813, 8, 'Red minecraft', 'Add Automated Salary', '04:13:31 AM', '2022/03/11');

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `timer` varchar(100) DEFAULT NULL,
  `access` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`id`, `firstname`, `lastname`, `username`, `password`, `timer`, `access`) VALUES
(1, 'Francis', 'Ilacad', 'DammiDoe123@gmail.com', '172eee54aa664e9dd0536b063796e54e', 'NULL', 'super administrator'),
(2, 'cho', 'ureta', 'uretamarycho@gmail.com', 'a9e09a27007f8e8bad58d68c3f2fa4de', 'NULL', 'super administrator');

-- --------------------------------------------------------

--
-- Table structure for table `unavailable_guards`
--

CREATE TABLE `unavailable_guards` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unavailable_guards`
--

INSERT INTO `unavailable_guards` (`id`, `employee_id`, `company_id`, `year`, `month`, `day`, `date`) VALUES
(1, 1, 1, '', '', '', 'February 4, 2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `automatic_generated_salary`
--
ALTER TABLE `automatic_generated_salary`
  ADD PRIMARY KEY (`log`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`log`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empId` (`empId`);

--
-- Indexes for table `emp_info`
--
ALTER TABLE `emp_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`empId`);

--
-- Indexes for table `emp_schedule`
--
ALTER TABLE `emp_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generated_salary`
--
ALTER TABLE `generated_salary`
  ADD PRIMARY KEY (`log`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_report`
--
ALTER TABLE `salary_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `empid` (`empid`);

--
-- Indexes for table `secretary`
--
ALTER TABLE `secretary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `secretary_log`
--
ALTER TABLE `secretary_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sec_id` (`sec_id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unavailable_guards`
--
ALTER TABLE `unavailable_guards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `automatic_generated_salary`
--
ALTER TABLE `automatic_generated_salary`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `emp_attendance`
--
ALTER TABLE `emp_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `emp_schedule`
--
ALTER TABLE `emp_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generated_salary`
--
ALTER TABLE `generated_salary`
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `salary_report`
--
ALTER TABLE `salary_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `secretary_log`
--
ALTER TABLE `secretary_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=814;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unavailable_guards`
--
ALTER TABLE `unavailable_guards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `secretary`
--
ALTER TABLE `secretary`
  ADD CONSTRAINT `secretary_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `super_admin` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `secretary_log`
--
ALTER TABLE `secretary_log`
  ADD CONSTRAINT `secretary_log_ibfk_1` FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
