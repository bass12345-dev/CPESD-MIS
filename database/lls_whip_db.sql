-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2024 at 05:13 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lls_whip_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `contractor_id` int NOT NULL,
  `contractor_name` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `province_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `city_code` varchar(255) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `barangay_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `phone_number_owner` varchar(30) DEFAULT NULL,
  `telephone_number` varchar(30) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `proprietor` varchar(255) DEFAULT NULL,
  `status` set('active','inactive') NOT NULL,
  `added_by` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`contractor_id`, `contractor_name`, `province`, `province_code`, `city`, `city_code`, `barangay`, `barangay_code`, `street`, `phone_number`, `phone_number_owner`, `telephone_number`, `email_address`, `proprietor`, `status`, `added_by`, `created_on`) VALUES
(2, 'DDS Builders', 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Villaflor', '1004209048', NULL, '09399168447', 'Engr. Robert Lamparas', NULL, 'robertlamparas@yahoo.com', 'Denny S. Sasil', 'active', 8, '2024-08-07 03:44:02'),
(3, 'SBU Builders & General Merchandise', 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Poblacion II', '1004209031', NULL, NULL, NULL, '531-1187', 'sbu.construction.supplies@gmail.com', 'William L. Siao', 'active', 8, '2024-08-07 03:46:01'),
(4, 'Lexand Construction & Development', 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, '09073574277', NULL, NULL, 'lim.alexander.1@gmail.com', 'Alexander L. Lim', 'active', 8, '2024-08-07 03:47:59'),
(5, 'Alfahad Builders & Enterprises', 'Lanao del Sur', '1903600000', 'Balindong', '1903603000', NULL, NULL, NULL, '09568804475', NULL, NULL, NULL, 'Abdul Samad P. Amod', 'active', 8, '2024-08-07 03:49:07'),
(6, 'Grace Construction Corporation', 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, 'Grace Compound, Bernad Subdivision', '09100000268', 'Bebot Boligor', '521-1540', 'graceconst@yahoo.com', 'Delwin Vince Y. Chiong', 'active', 9, '2024-08-07 03:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `extension` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `province` varchar(255) NOT NULL,
  `province_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `city` varchar(255) NOT NULL,
  `city_code` varchar(255) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `barangay_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `gender` set('male','female') NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `middle_name`, `last_name`, `extension`, `province`, `province_code`, `city`, `city_code`, `barangay`, `barangay_code`, `street`, `gender`, `contact_number`, `birthdate`, `created_on`) VALUES
(5, 'Robert', NULL, 'Mante', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:50:24'),
(6, 'Jimboy', NULL, 'Beltran', NULL, 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:51:34'),
(7, 'Felix', NULL, 'Handumon', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:52:03'),
(8, 'Harold', NULL, 'Revelo', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-02', '2024-08-08 04:52:33'),
(9, 'Joel', NULL, 'Simbajon', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:53:19'),
(10, 'Julindo', NULL, 'Paculba', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:53:46'),
(11, 'Homar', NULL, 'Yagao', NULL, 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, 'male', NULL, '2024-08-03', '2024-08-08 04:54:13'),
(12, 'Jed', NULL, 'Adaza', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Langcangan Lower', '1004209017', NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:55:02'),
(13, 'Jennifer', NULL, 'Adaza', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Langcangan Lower', '1004209017', NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:55:30'),
(14, 'Dante', NULL, 'Bitache', NULL, 'Misamis Occidental', '1004200000', 'City of Tangub', '1004215000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:55:59'),
(15, 'Kenneth', NULL, 'Revelo', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:56:31'),
(16, 'Geoffrey', NULL, 'Cabo', NULL, 'Lanao del Norte', '1003500000', 'Linamon', '1003510000', 'Poblacion', '1003510005', NULL, 'male', NULL, '2024-08-05', '2024-08-08 04:57:17'),
(17, 'Johnny', NULL, 'Luste', NULL, 'Misamis Occidental', '1004200000', 'City of Tangub', '1004215000', NULL, NULL, NULL, 'male', NULL, '2024-08-02', '2024-08-08 04:57:40'),
(18, 'Noel', NULL, 'Maturan', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:58:14'),
(19, 'Nemecio', NULL, 'Mintang', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:59:09'),
(20, 'Roy', NULL, 'Paculba', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 05:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `employment_status`
--

CREATE TABLE `employment_status` (
  `employment_status_id` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishments`
--

CREATE TABLE `establishments` (
  `establishment_id` int NOT NULL,
  `establishment_code` varchar(150) NOT NULL,
  `establishment_name` varchar(255) NOT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `telephone_number` varchar(30) DEFAULT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `authorized_personnel` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` set('active','inactive') NOT NULL,
  `added_by` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishment_employee`
--

CREATE TABLE `establishment_employee` (
  `establishment_employee_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `establishment_id` int NOT NULL,
  `position_id` int NOT NULL,
  `nature_of_employment` varchar(255) NOT NULL,
  `status_of_employment_id` int NOT NULL,
  `level_of_employment` set('rank_and_file','managerial','proprietor') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishment_monitoring`
--

CREATE TABLE `establishment_monitoring` (
  `establishment_monitoring_id` int NOT NULL,
  `establishment_id` int NOT NULL,
  `date_of_monitoring` datetime NOT NULL,
  `specific_activity` text NOT NULL,
  `annotations` text NOT NULL,
  `remarks` text,
  `monitoring_status` set('pending','approved') DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishment_monitoring_employee`
--

CREATE TABLE `establishment_monitoring_employee` (
  `estab_mon_emp_id` int NOT NULL,
  `establishment_monitoring_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int NOT NULL,
  `position` varchar(255) NOT NULL,
  `type` set('lls','whip') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position`, `type`, `created_on`) VALUES
(4, 'Laborer', 'whip', '2024-08-07 06:01:25'),
(5, 'Foreman', 'whip', '2024-08-07 06:01:28'),
(6, 'Watchman', 'whip', '2024-08-07 06:02:03'),
(7, 'Timekeeper', 'whip', '2024-08-07 06:02:07'),
(8, 'Mason', 'whip', '2024-08-07 06:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int NOT NULL,
  `contractor_id` int NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_nature_id` int NOT NULL,
  `project_cost` bigint NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_started` date NOT NULL,
  `date_completed` date DEFAULT NULL,
  `project_status` set('ongoing','completed') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `contractor_id`, `project_title`, `project_nature_id`, `project_cost`, `barangay`, `street`, `date_started`, `date_completed`, `project_status`, `created_on`) VALUES
(10, 5, 'MULTI PURPOSE BUILDING OROQUIETA CITY', 1, 123213213, 'Langcangan Proper', NULL, '2024-08-08', NULL, 'ongoing', '2024-08-08 14:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `project_employee`
--

CREATE TABLE `project_employee` (
  `project_employee_id` int NOT NULL,
  `project_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `position_id` int NOT NULL,
  `nature_of_employment` varchar(255) NOT NULL,
  `status_of_employment_id` int NOT NULL,
  `start_date` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `level_of_employment` set('rank_and_file','managerial','proprietor') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_monitoring`
--

CREATE TABLE `project_monitoring` (
  `project_monitoring_id` int NOT NULL,
  `project_id` int NOT NULL,
  `added_by` int NOT NULL,
  `date_of_monitoring` datetime NOT NULL,
  `specific_activity` text NOT NULL,
  `annotations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `monitoring_status` set('pending','approved') NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_monitoring`
--

INSERT INTO `project_monitoring` (`project_monitoring_id`, `project_id`, `added_by`, `date_of_monitoring`, `specific_activity`, `annotations`, `monitoring_status`, `remarks`, `created_on`) VALUES
(4, 10, 9, '2024-08-08 00:00:00', 'asdsadsad', 'adasd', 'pending', NULL, '2024-08-08 14:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `project_monitoring_employee`
--

CREATE TABLE `project_monitoring_employee` (
  `proj_mon_emp_id` int NOT NULL,
  `project_monitoring_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_nature`
--

CREATE TABLE `project_nature` (
  `project_nature_id` int NOT NULL,
  `project_nature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_nature`
--

INSERT INTO `project_nature` (`project_nature_id`, `project_nature`, `created_on`) VALUES
(1, 'sample', '2024-08-08 06:04:42'),
(2, 'sample 2', '2024-08-08 06:04:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`contractor_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employment_status`
--
ALTER TABLE `employment_status`
  ADD PRIMARY KEY (`employment_status_id`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`establishment_id`);

--
-- Indexes for table `establishment_employee`
--
ALTER TABLE `establishment_employee`
  ADD PRIMARY KEY (`establishment_employee_id`);

--
-- Indexes for table `establishment_monitoring`
--
ALTER TABLE `establishment_monitoring`
  ADD PRIMARY KEY (`establishment_monitoring_id`);

--
-- Indexes for table `establishment_monitoring_employee`
--
ALTER TABLE `establishment_monitoring_employee`
  ADD PRIMARY KEY (`estab_mon_emp_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_employee`
--
ALTER TABLE `project_employee`
  ADD PRIMARY KEY (`project_employee_id`);

--
-- Indexes for table `project_monitoring`
--
ALTER TABLE `project_monitoring`
  ADD PRIMARY KEY (`project_monitoring_id`);

--
-- Indexes for table `project_monitoring_employee`
--
ALTER TABLE `project_monitoring_employee`
  ADD PRIMARY KEY (`proj_mon_emp_id`);

--
-- Indexes for table `project_nature`
--
ALTER TABLE `project_nature`
  ADD PRIMARY KEY (`project_nature_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `contractor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employment_status`
--
ALTER TABLE `employment_status`
  MODIFY `employment_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `establishment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishment_employee`
--
ALTER TABLE `establishment_employee`
  MODIFY `establishment_employee_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishment_monitoring`
--
ALTER TABLE `establishment_monitoring`
  MODIFY `establishment_monitoring_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishment_monitoring_employee`
--
ALTER TABLE `establishment_monitoring_employee`
  MODIFY `estab_mon_emp_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_employee`
--
ALTER TABLE `project_employee`
  MODIFY `project_employee_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_monitoring`
--
ALTER TABLE `project_monitoring`
  MODIFY `project_monitoring_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_monitoring_employee`
--
ALTER TABLE `project_monitoring_employee`
  MODIFY `proj_mon_emp_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_nature`
--
ALTER TABLE `project_nature`
  MODIFY `project_nature_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
