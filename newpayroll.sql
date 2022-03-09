-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2022 at 10:12 AM
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
(342, 1003, 168.467, 10027.6, 0, 0, 12, 214.283, 0, 450, 200, 350, 50, 0, 0, 10241.9, 1050, 9191.92, '2022/02/02', '2022/02/25', 'released', 'March 2, 2022 02:59:50 PM', '2022-03-09 01:09:21'),
(343, 1004, 24.0667, 1432.52, 0, 0, 0, 0, 0, 450, 200, 350, 50, 0, 0, 1432.52, 1050, 382.52, '2022/03/01', '2022/03/02', 'released', 'March 2, 2022 04:07:08 PM', '2022-03-09 01:09:41'),
(344, 1002, 35.1333, 2091.24, 12, 714.276, 0, 0, 0, 450, 200, 350, 50, 0, 0, 2805.52, 1050, 1755.52, '2022/01/01', '2022/01/03', 'released', 'March 2, 2022 04:07:15 PM', '2022-03-09 01:09:48');

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

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `empId`, `date`, `amount`) VALUES
(41, 1001, 'March 9, 2022', 1000);

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

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`log`, `empId`, `sss`, `philhealth`, `pagibig`, `cashbond`, `date`) VALUES
(21, 1004, 3150, 2450, 1400, 350, '2022-03-09 01:09:41'),
(22, 1003, 4500, 3500, 2000, 500, '2022-03-09 01:09:21'),
(23, 1002, 2700, 2100, 1200, 300, '2022-03-09 01:09:48');

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
(62, '1002', 'Mcdo Baesa', '08:56:00 AM', '8:00:00 PM', '2022/01/01', '2022/01/01', 'Baesa, Quezon City', 'Late', 'paid', 'true'),
(65, '1002', 'Mcdo Baesa', '07:56:00 AM', '8:00:00 PM', '2022/01/02', '2022/01/02', 'Baesa Quezon City', 'Ontime', 'paid', 'true'),
(66, '1002', 'Mcdo Baesa', '8:00:00 AM', '8:00:00 PM', '2022/01/03', '2022/01/03', 'Baesa, Quezon City', 'ontime', 'paid', 'true'),
(68, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/02', '2022/02/02', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(69, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/03', '2022/02/03', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(70, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/04', '2022/02/04', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(71, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/05', '2022/02/05', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(72, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/06', '2022/02/06', '', 'ontime', 'paid', 'true'),
(73, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/07', '2022/02/07', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(74, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/08', '2022/02/08', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(75, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/09', '2022/02/09', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(76, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/10', '2022/02/10', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(77, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/11', '2022/02/11', 'Sauyo High', 'ontime', 'paid', 'true'),
(78, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/12', '2022/02/12', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(79, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/13', '2022/02/13', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(80, '1003', 'Sauyo High', '8:00:00 AM', '8:00:00 PM', '2022/02/14', '2022/02/14', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(81, '1003', 'Sauyo High', '07:56:00 AM', '8:00:00 PM', '2022/02/25', '2022/02/25', 'Sauyo, QC', 'ontime', 'paid', 'true'),
(83, '1004', 'Mcdo Holy Spirit', '8:00 AM', '8:00 PM', '2022/03/01', '2022/03/01', 'Holy Spirit QC', 'Ontime', 'paid', NULL),
(84, '1004', 'Mcdo Holy Spirit', '7:56 AM', '8:00 PM', '2022/03/02', '2022/03/02', 'Holy Spirit QC', 'Ontime', 'paid', NULL);

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

--
-- Dumping data for table `generated_salary`
--

INSERT INTO `generated_salary` (`log`, `emp_id`, `location`, `rate_hour`, `date`, `hours_duty`, `regular_holiday`, `special_holiday`, `day_late`, `hrs_late`, `day_absent`, `hours_absent`, `no_of_work`, `sss`, `pagibig`, `philhealth`, `cashbond`, `vale`, `thirteenmonth`, `total_hours`, `regular_pay`, `regular_holiday_pay`, `special_holiday_pay`, `absent_pay`, `total_deduction`, `total_gross`, `total_netpay`, `dateandtime_created`) VALUES
(114, '1001', 'Jollibee Paso de blas', 59, '2022/03/02', 12, 12, 24, 2, 2, NULL, NULL, 14, 300, 200, 100, 100, 100, 0, 168, 9912, 708, 424.8, NULL, 919.046, 11044.8, 10125.8, '10:36:02 PM');

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
(20, 'New Year’s Eve', 'December 30, 2022', 'Special Holiday');

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

--
-- Dumping data for table `salary_report`
--

INSERT INTO `salary_report` (`id`, `empId`, `january`, `february`, `march`, `april`, `may`, `june`, `july`, `august`, `september`, `october`, `november`, `december`) VALUES
(5, '1003', NULL, 9191.92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '1004', NULL, NULL, 382.52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '1002', 1755.52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `expiration_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(460, 8, 'Red minecraft', 'login', '11:58:25 AM', '2022/02/28'),
(461, 8, 'Red minecraft', 'Add Automated Salary', '12:02:22 PM', '2022/02/28'),
(462, 8, 'Red minecraft', 'Add Automated Salary', '12:02:40 PM', '2022/02/28'),
(463, 8, 'Red minecraft', 'Delete Automated Salary', '12:05:09 PM', '2022/02/28'),
(464, 8, 'Red minecraft', 'Delete Automated Salary', '12:05:12 PM', '2022/02/28'),
(465, 8, 'Red minecraft', 'Add Automated Salary', '12:05:15 PM', '2022/02/28'),
(466, 8, 'Red minecraft', 'Delete Automated Salary', '12:06:02 PM', '2022/02/28'),
(467, 8, 'Red minecraft', 'login', '06:02:19 PM', '2022/02/28'),
(468, 8, 'Red minecraft', 'Add Automated Salary', '06:08:44 PM', '2022/02/28'),
(469, 8, 'Red minecraft', 'Delete Automated Salary', '06:10:59 PM', '2022/02/28'),
(470, 8, 'Red minecraft', 'Add Automated Salary', '06:11:01 PM', '2022/02/28'),
(471, 8, 'Red minecraft', 'Released Salary', '06:51:52 PM', '2022/02/28'),
(472, 8, 'Red minecraft', 'Add Cash Advance', '07:18:09 PM', '2022/02/28'),
(473, 8, 'Red minecraft', 'Add Cash Advance', '07:18:23 PM', '2022/02/28'),
(474, 8, 'Red minecraft', 'Delete Automated Salary', '07:19:57 PM', '2022/02/28'),
(475, 8, 'Red minecraft', 'Add Automated Salary', '07:20:03 PM', '2022/02/28'),
(476, 8, 'Red minecraft', 'Delete Automated Salary', '07:21:50 PM', '2022/02/28'),
(477, 8, 'Red minecraft', 'Add Automated Salary', '07:21:52 PM', '2022/02/28'),
(478, 8, 'Red minecraft', 'Delete Automated Salary', '07:22:26 PM', '2022/02/28'),
(479, 8, 'Red minecraft', 'Add Automated Salary', '07:22:28 PM', '2022/02/28'),
(480, 8, 'Red minecraft', 'Delete Automated Salary', '07:22:51 PM', '2022/02/28'),
(481, 8, 'Red minecraft', 'Add Automated Salary', '07:22:52 PM', '2022/02/28'),
(482, 8, 'Red minecraft', 'Delete Automated Salary', '07:23:05 PM', '2022/02/28'),
(483, 8, 'Red minecraft', 'Add Automated Salary', '07:24:28 PM', '2022/02/28'),
(484, 8, 'Red minecraft', 'Delete Automated Salary', '07:24:37 PM', '2022/02/28'),
(485, 8, 'Red minecraft', 'Add Automated Salary', '07:24:38 PM', '2022/02/28'),
(486, 8, 'Red minecraft', 'Delete Automated Salary', '07:27:20 PM', '2022/02/28'),
(487, 8, 'Red minecraft', 'Add Automated Salary', '07:27:22 PM', '2022/02/28'),
(488, 8, 'Red minecraft', 'Released Salary', '07:27:29 PM', '2022/02/28'),
(489, 8, 'Red minecraft', 'Released Salary', '12:02:38 AM', '2022/03/01'),
(490, 8, 'Red minecraft', 'Delete Automated Salary', '01:14:34 AM', '2022/03/01'),
(491, 8, 'Red minecraft', 'Add Automated Salary', '01:14:57 AM', '2022/03/01'),
(492, 8, 'Red minecraft', 'Released Salary', '01:18:31 AM', '2022/03/01'),
(493, 8, 'Red minecraft', 'Delete Automated Salary', '01:32:52 AM', '2022/03/01'),
(494, 8, 'Red minecraft', 'Delete Automated Salary', '01:32:55 AM', '2022/03/01'),
(495, 8, 'Red minecraft', 'Add Automated Salary', '01:32:57 AM', '2022/03/01'),
(496, 8, 'Red minecraft', 'Add Automated Salary', '01:33:07 AM', '2022/03/01'),
(497, 8, 'Red minecraft', 'Add Automated Salary', '01:33:11 AM', '2022/03/01'),
(498, 8, 'Red minecraft', 'Add Automated Salary', '01:34:07 AM', '2022/03/01'),
(499, 8, 'Red minecraft', 'Released Salary', '01:37:42 AM', '2022/03/01'),
(500, 8, 'Red minecraft', 'Delete Automated Salary', '01:37:49 AM', '2022/03/01'),
(501, 8, 'Red minecraft', 'Delete Automated Salary', '01:47:34 AM', '2022/03/01'),
(502, 8, 'Red minecraft', 'Add Automated Salary', '01:47:37 AM', '2022/03/01'),
(503, 8, 'Red minecraft', 'Delete Automated Salary', '01:47:55 AM', '2022/03/01'),
(504, 8, 'Red minecraft', 'Add Cash Advance', '01:48:04 AM', '2022/03/01'),
(505, 8, 'Red minecraft', 'Add Automated Salary', '01:48:16 AM', '2022/03/01'),
(506, 8, 'Red minecraft', 'Add Automated Salary', '01:48:42 AM', '2022/03/01'),
(507, 8, 'Red minecraft', 'Released Salary', '01:50:49 AM', '2022/03/01'),
(508, 8, 'Red minecraft', 'Released Salary', '01:58:21 AM', '2022/03/01'),
(509, 8, 'Red minecraft', 'Released Salary', '01:58:53 AM', '2022/03/01'),
(510, 8, 'Red minecraft', 'Released Salary', '02:02:49 AM', '2022/03/01'),
(511, 8, 'Red minecraft', 'Released Salary', '02:31:42 AM', '2022/03/01'),
(512, 8, 'Red minecraft', 'Released Salary', '02:38:40 AM', '2022/03/01'),
(513, 8, 'Red minecraft', 'login', '10:08:01 AM', '2022/03/01'),
(514, 8, 'Red minecraft', 'Released Salary', '04:55:59 PM', '2022/03/01'),
(515, 8, 'Red minecraft', 'Released Salary', '04:56:08 PM', '2022/03/01'),
(516, 8, 'Red minecraft', 'Released Salary', '04:56:15 PM', '2022/03/01'),
(517, 8, 'Red minecraft', 'Released Salary', '05:20:32 PM', '2022/03/01'),
(518, 8, 'Red minecraft', 'Released Salary', '05:26:55 PM', '2022/03/01'),
(519, 8, 'Red minecraft', 'Released Salary', '05:31:02 PM', '2022/03/01'),
(520, 8, 'Red minecraft', 'Released Salary', '05:32:40 PM', '2022/03/01'),
(521, 8, 'Red minecraft', 'Released Salary', '05:33:44 PM', '2022/03/01'),
(522, 8, 'Red minecraft', 'Released Salary', '05:35:26 PM', '2022/03/01'),
(523, 8, 'Red minecraft', 'Released Salary', '05:50:40 PM', '2022/03/01'),
(524, 8, 'Red minecraft', 'Released Salary', '05:52:57 PM', '2022/03/01'),
(525, 8, 'Red minecraft', 'Released Salary', '05:53:45 PM', '2022/03/01'),
(526, 8, 'Red minecraft', 'Released Salary', '05:54:19 PM', '2022/03/01'),
(527, 8, 'Red minecraft', 'Released Salary', '05:55:04 PM', '2022/03/01'),
(528, 8, 'Red minecraft', 'Released Salary', '05:56:39 PM', '2022/03/01'),
(529, 8, 'Red minecraft', 'Released Salary', '05:56:47 PM', '2022/03/01'),
(530, 8, 'Red minecraft', 'Released Salary', '05:57:12 PM', '2022/03/01'),
(531, 8, 'Red minecraft', 'Released Salary', '05:57:38 PM', '2022/03/01'),
(532, 8, 'Red minecraft', 'Released Salary', '05:57:54 PM', '2022/03/01'),
(533, 8, 'Red minecraft', 'Released Salary', '05:59:11 PM', '2022/03/01'),
(534, 8, 'Red minecraft', 'Released Salary', '05:59:24 PM', '2022/03/01'),
(535, 8, 'Red minecraft', 'Released Salary', '05:59:43 PM', '2022/03/01'),
(536, 8, 'Red minecraft', 'Delete Cash Advance', '05:59:58 PM', '2022/03/01'),
(537, 8, 'Red minecraft', 'Delete Automated Salary', '06:00:03 PM', '2022/03/01'),
(538, 8, 'Red minecraft', 'Add Automated Salary', '06:00:06 PM', '2022/03/01'),
(539, 8, 'Red minecraft', 'Released Salary', '06:00:12 PM', '2022/03/01'),
(540, 8, 'Red minecraft', 'Delete Automated Salary', '06:02:30 PM', '2022/03/01'),
(541, 8, 'Red minecraft', 'Delete Automated Salary', '06:02:32 PM', '2022/03/01'),
(542, 8, 'Red minecraft', 'Delete Automated Salary', '06:02:34 PM', '2022/03/01'),
(543, 8, 'Red minecraft', 'Delete Automated Salary', '06:02:38 PM', '2022/03/01'),
(544, 8, 'Red minecraft', 'Add Automated Salary', '06:03:03 PM', '2022/03/01'),
(545, 8, 'Red minecraft', 'Add Automated Salary', '06:03:06 PM', '2022/03/01'),
(546, 8, 'Red minecraft', 'Add Automated Salary', '06:03:10 PM', '2022/03/01'),
(547, 8, 'Red minecraft', 'Released Salary', '06:05:08 PM', '2022/03/01'),
(548, 8, 'Red minecraft', 'Released Salary', '06:05:20 PM', '2022/03/01'),
(549, 8, 'Red minecraft', 'Released Salary', '06:05:33 PM', '2022/03/01'),
(550, 8, 'Red minecraft', 'login', '12:43:15 AM', '2022/03/02'),
(551, 8, 'Red minecraft', 'login', '01:29:59 AM', '2022/03/02'),
(552, 8, 'Red minecraft', 'Delete Automated Salary', '02:59:55 AM', '2022/03/02'),
(553, 8, 'Red minecraft', 'Delete Automated Salary', '02:59:57 AM', '2022/03/02'),
(554, 8, 'Red minecraft', 'Delete Automated Salary', '02:59:59 AM', '2022/03/02'),
(555, 8, 'Red minecraft', 'Add Automated Salary', '03:05:07 AM', '2022/03/02'),
(556, 8, 'Red minecraft', 'Add Automated Salary', '03:05:07 AM', '2022/03/02'),
(557, 8, 'Red minecraft', 'Add Automated Salary', '03:05:07 AM', '2022/03/02'),
(558, 8, 'Red minecraft', 'Add Automated Salary', '03:05:07 AM', '2022/03/02'),
(559, 8, 'Red minecraft', 'Add Automated Salary', '03:05:07 AM', '2022/03/02'),
(560, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(561, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(562, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(563, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(564, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(565, 8, 'Red minecraft', 'Add Automated Salary', '03:05:08 AM', '2022/03/02'),
(566, 8, 'Red minecraft', 'Add Automated Salary', '03:05:09 AM', '2022/03/02'),
(567, 8, 'Red minecraft', 'Delete Automated Salary', '03:05:16 AM', '2022/03/02'),
(568, 8, 'Red minecraft', 'Delete Automated Salary', '03:05:19 AM', '2022/03/02'),
(569, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(570, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(571, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(572, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(573, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(574, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(575, 8, 'Red minecraft', 'Add Automated Salary', '03:06:12 AM', '2022/03/02'),
(576, 8, 'Red minecraft', 'Add Automated Salary', '03:06:13 AM', '2022/03/02'),
(577, 8, 'Red minecraft', 'Add Automated Salary', '03:06:13 AM', '2022/03/02'),
(578, 8, 'Red minecraft', 'Add Automated Salary', '03:06:13 AM', '2022/03/02'),
(579, 8, 'Red minecraft', 'Add Automated Salary', '03:06:13 AM', '2022/03/02'),
(580, 8, 'Red minecraft', 'Add Automated Salary', '03:06:13 AM', '2022/03/02'),
(581, 8, 'Red minecraft', 'Add Automated Salary', '03:22:05 AM', '2022/03/02'),
(582, 8, 'Red minecraft', 'Add Automated Salary', '03:23:38 AM', '2022/03/02'),
(583, 8, 'Red minecraft', 'Add Automated Salary', '03:29:43 AM', '2022/03/02'),
(584, 8, 'Red minecraft', 'Add Automated Salary', '03:29:50 AM', '2022/03/02'),
(585, 8, 'Red minecraft', 'Delete Automated Salary', '03:29:52 AM', '2022/03/02'),
(586, 8, 'Red minecraft', 'Delete Automated Salary', '03:29:54 AM', '2022/03/02'),
(587, 8, 'Red minecraft', 'Delete Automated Salary', '03:29:56 AM', '2022/03/02'),
(588, 8, 'Red minecraft', 'Released Salary', '03:30:00 AM', '2022/03/02'),
(589, 8, 'Red minecraft', 'Add Automated Salary', '03:37:41 AM', '2022/03/02'),
(590, 8, 'Red minecraft', 'Add Automated Salary', '03:37:43 AM', '2022/03/02'),
(591, 8, 'Red minecraft', 'Add Cash Advance', '03:41:26 AM', '2022/03/02'),
(592, 8, 'Red minecraft', 'Delete Cash Advance', '03:41:36 AM', '2022/03/02'),
(593, 8, 'Red minecraft', 'Add Automated Salary', '03:45:40 AM', '2022/03/02'),
(594, 8, 'Red minecraft', 'Add Automated Salary', '03:45:43 AM', '2022/03/02'),
(595, 8, 'Red minecraft', 'Add Automated Salary', '03:45:47 AM', '2022/03/02'),
(596, 8, 'Red minecraft', 'Add Automated Salary', '03:45:49 AM', '2022/03/02'),
(597, 8, 'Red minecraft', 'login', '01:25:39 PM', '2022/03/02'),
(598, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:23 PM', '2022/03/02'),
(599, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:25 PM', '2022/03/02'),
(600, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:27 PM', '2022/03/02'),
(601, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:30 PM', '2022/03/02'),
(602, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:32 PM', '2022/03/02'),
(603, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:34 PM', '2022/03/02'),
(604, 8, 'Red minecraft', 'Delete Automated Salary', '02:30:36 PM', '2022/03/02'),
(605, 8, 'Red minecraft', 'Add Automated Salary', '02:59:50 PM', '2022/03/02'),
(606, 8, 'Red minecraft', 'Add Automated Salary', '04:07:08 PM', '2022/03/02'),
(607, 8, 'Red minecraft', 'Add Automated Salary', '04:07:15 PM', '2022/03/02'),
(608, 8, 'Red minecraft', 'Add Salary', '09:49:22 PM', '2022/03/02'),
(609, 8, 'Red minecraft', 'Add Salary', '09:53:07 PM', '2022/03/02'),
(610, 8, 'Red minecraft', 'Edit Salary', '09:56:34 PM', '2022/03/02'),
(611, 8, 'Red minecraft', 'Edit Salary', '09:58:12 PM', '2022/03/02'),
(612, 8, 'Red minecraft', 'Edit Salary', '09:58:28 PM', '2022/03/02'),
(613, 8, 'Red minecraft', 'Edit Salary', '09:59:41 PM', '2022/03/02'),
(614, 8, 'Red minecraft', 'Edit Salary', '10:01:17 PM', '2022/03/02'),
(615, 8, 'Red minecraft', 'Edit Salary', '10:02:35 PM', '2022/03/02'),
(616, 8, 'Red minecraft', 'Edit Salary', '10:05:18 PM', '2022/03/02'),
(617, 8, 'Red minecraft', 'Edit Salary', '10:06:46 PM', '2022/03/02'),
(618, 8, 'Red minecraft', 'Edit Salary', '10:10:16 PM', '2022/03/02'),
(619, 8, 'Red minecraft', 'Delete Salary', '10:11:19 PM', '2022/03/02'),
(620, 8, 'Red minecraft', 'Add Salary', '10:12:03 PM', '2022/03/02'),
(621, 8, 'Red minecraft', 'Delete Salary', '10:13:39 PM', '2022/03/02'),
(622, 8, 'Red minecraft', 'Add Salary', '10:14:04 PM', '2022/03/02'),
(623, 8, 'Red minecraft', 'Delete Salary', '10:19:45 PM', '2022/03/02'),
(624, 8, 'Red minecraft', 'Add Salary', '10:20:20 PM', '2022/03/02'),
(625, 8, 'Red minecraft', 'Delete Salary', '10:27:06 PM', '2022/03/02'),
(626, 8, 'Red minecraft', 'Delete Salary', '10:27:08 PM', '2022/03/02'),
(627, 8, 'Red minecraft', 'Add Salary', '10:29:05 PM', '2022/03/02'),
(628, 8, 'Red minecraft', 'Edit Salary', '10:30:10 PM', '2022/03/02'),
(629, 8, 'Red minecraft', 'Edit Salary', '10:36:02 PM', '2022/03/02'),
(630, 8, 'Red minecraft', 'login', '10:41:10 AM', '2022/03/09'),
(631, 8, 'Red minecraft', 'login', '10:44:09 AM', '2022/03/09'),
(632, 8, 'Red minecraft', 'Add Cash Advance', '12:41:14 PM', '2022/03/09'),
(633, 8, 'Red minecraft', 'Released Salary', '03:02:44 PM', '2022/03/09'),
(634, 8, 'Red minecraft', 'Released Salary', '03:08:21 PM', '2022/03/09'),
(635, 8, 'Red minecraft', 'Released Salary', '03:22:26 PM', '2022/03/09'),
(636, 8, 'Red minecraft', 'Released Salary', '04:57:45 PM', '2022/03/09'),
(637, 8, 'Red minecraft', 'Released Salary', '05:00:29 PM', '2022/03/09'),
(638, 8, 'Red minecraft', 'Released Salary', '05:03:33 PM', '2022/03/09'),
(639, 8, 'Red minecraft', 'Released Salary', '05:05:13 PM', '2022/03/09'),
(640, 8, 'Red minecraft', 'Released Salary', '05:06:23 PM', '2022/03/09'),
(641, 8, 'Red minecraft', 'Released Salary', '05:06:34 PM', '2022/03/09'),
(642, 8, 'Red minecraft', 'Released Salary', '05:06:39 PM', '2022/03/09'),
(643, 8, 'Red minecraft', 'Released Salary', '05:08:18 PM', '2022/03/09'),
(644, 8, 'Red minecraft', 'Released Salary', '05:08:25 PM', '2022/03/09'),
(645, 8, 'Red minecraft', 'Released Salary', '05:08:31 PM', '2022/03/09'),
(646, 8, 'Red minecraft', 'Released Salary', '05:09:21 PM', '2022/03/09'),
(647, 8, 'Red minecraft', 'Released Salary', '05:09:41 PM', '2022/03/09'),
(648, 8, 'Red minecraft', 'Released Salary', '05:09:49 PM', '2022/03/09');

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
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

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
  MODIFY `log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `secretary_log`
--
ALTER TABLE `secretary_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=649;

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
