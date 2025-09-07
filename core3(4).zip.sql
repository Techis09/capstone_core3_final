-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2025 at 10:20 AM
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
-- Database: `core3`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Sheen', 'Sheen@gmail.com', '$2y$10$okbzIzRiKlMWewReh4C9k.0T5JRxq5vBBxOIyKgZLlpVULm0sKFPq', 'user', '2025-08-30 08:49:34'),
(2, '123', '1232@gmail.com', '$2y$10$Ey7IfXrF0vbSzDuB7FM/buIjipzWLy9dIS96y1dbfZEJlN5e1.Knu', 'admin', '2025-08-30 09:28:17'),
(5, 'qwe', 'qwe@gmail.com', '$2y$10$NvgLCM4xvG06..jOcZA.F.EvxrhtEK26trY.PfQ5nUugqIA9wKFDe', 'user', '2025-08-30 09:43:31'),
(13, '00000', 'justinelusung11@gmail.com', '$2y$10$Fz82lkBPCZDmdXbWzlJj4uPbT30tzOubRcpeKu3FLGmscQeNnlBsK', 'admin', '2025-08-30 19:04:58'),
(14, 'erer', 'eree@gmail.com', '$2y$10$5R2N7.b8ABCV3uMUcwtiweXsmlFgt7b8F73yIfT.uc1UpWCeZ0Chm', 'user', '2025-09-01 19:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity`
--

CREATE TABLE `admin_activity` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `module` varchar(100) NOT NULL,
  `activity` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity`
--

INSERT INTO `admin_activity` (`id`, `date`, `module`, `activity`, `status`) VALUES
(3, '2025-09-01 19:02:00', 'CRM', 'Added new customer: nemon (nemon.corp)', 'Success'),
(5, '2025-09-01 19:09:26', 'CRM', 'Deleted customer: bhrruuu4 (PIHAN4)', 'Success'),
(6, '2025-09-01 19:09:47', 'CRM', 'Updated customer: TJK (DJK)', 'Success'),
(7, '2025-09-01 19:22:26', 'CRM', 'Added new customer: neee (neee.corp)', 'Success'),
(8, '2025-09-01 19:58:12', 'CRM', 'Updated customer: neee (neee.corp)', 'Success'),
(9, '2025-09-01 19:58:27', 'CRM', 'Deleted customer: dsad (PKG)', 'Success'),
(10, '2025-09-01 19:59:02', 'CRM', 'Added new customer: santa (santa)', 'Success'),
(11, '2025-09-01 20:01:53', 'CRM', 'Updated customer: Pota (Pota.corp)', 'Success'),
(12, '2025-09-01 20:01:55', 'CRM', 'Updated customer: Pota (Pota.corp)', 'Success'),
(13, '2025-09-01 20:03:42', 'CRM', 'Updated customer: tryt (try.corp342)', 'Success'),
(14, '2025-09-01 20:18:21', 'CRM', 'Updated customer ID 89 → nemon (nemon.corp)', 'Success'),
(15, '2025-09-01 20:18:23', 'CRM', 'Updated customer ID 92 → santa (santa)', 'Success'),
(16, '2025-09-01 23:48:10', 'CRM', 'Deleted customer: 123 (123)', 'Success'),
(17, '2025-09-02 00:10:39', 'CRM', 'Added new customer: tr (tr)', 'Success'),
(18, '2025-09-02 00:10:53', 'CRM', 'Updated customer ID 3: tr (tr)', 'Success'),
(19, '2025-09-02 00:16:23', 'CSM', 'Added new contract: tr - tr', 'Success'),
(20, '2025-09-02 00:17:24', 'CSM', 'Added new contract: tru - tru', 'Success'),
(21, '2025-09-02 00:20:30', 'CSM', 'Added new contract: 786876876 - gygyh', 'Success'),
(22, '2025-09-02 00:40:48', 'E-Documentation', 'Uploaded document: try', 'Pending Review'),
(23, '2025-09-02 00:41:35', 'E-Documentation', 'Edited document: try', 'Pending Review'),
(24, '2025-09-02 00:41:46', 'E-Documentation', 'Deleted document: try', 'Deleted'),
(25, '2025-09-02 03:38:55', 'CRM', 'Updated customer: tr (tr)', 'Success'),
(26, '2025-09-02 03:39:22', 'CRM', 'Added new customer: try (try)', 'Success'),
(27, '2025-09-02 03:39:41', 'CRM', 'Deleted customer: tr (tr)', 'Success'),
(28, '2025-09-02 03:40:56', 'CSM', 'Added new contract: 22052118321 - ulet', 'Success'),
(29, '2025-09-02 03:41:46', 'E-Documentation', 'Uploaded document: 123wqe', 'Pending Review'),
(30, '2025-09-02 03:42:01', 'E-Documentation', 'Edited document: 123wqe', 'Expired'),
(31, '2025-09-02 03:42:55', 'E-Documentation', 'Deleted document: qwee', 'Deleted'),
(32, '2025-09-02 03:44:12', 'E-Documentation', 'Deleted document: w1231', 'Deleted'),
(33, '2025-09-02 16:17:47', 'CRM', 'Updated customer: try (try)', 'Success'),
(34, '2025-09-02 16:31:38', 'CRM', 'Deleted customer: try (try)', 'Success'),
(35, '2025-09-02 17:40:07', 'CSM', 'Added new contract: 873485783478 - Roy', 'Success'),
(36, '2025-09-02 18:01:57', 'CSM', 'Added new contract: 878346573 - All G', 'Success'),
(37, '2025-09-02 18:03:03', 'CRM', 'Added new customer: ALLG (ALLG)', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `crm`
--

CREATE TABLE `crm` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` enum('Active','Prospect','Inactive') DEFAULT 'Prospect',
  `last_contract` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crm`
--

INSERT INTO `crm` (`id`, `customer_name`, `company`, `email`, `phone`, `status`, `last_contract`) VALUES
(5, 'ALLG', 'ALLG', 'ALLG@gmail.com', '909878747', 'Active', '2025-09-02 10:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `csm`
--

CREATE TABLE `csm` (
  `id` int(11) NOT NULL,
  `contract_id` varchar(50) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Expired','Pending') NOT NULL,
  `sla_compliance` enum('Compliant','Non-Compliant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `csm`
--

INSERT INTO `csm` (`id`, `contract_id`, `client_name`, `start_date`, `end_date`, `status`, `sla_compliance`) VALUES
(55, '873485783478', 'Roy', '2025-09-02', '2025-09-10', 'Active', 'Compliant'),
(56, '878346573', 'All G', '2025-09-02', '2025-09-23', 'Expired', 'Compliant');

-- --------------------------------------------------------

--
-- Table structure for table `e_doc`
--

CREATE TABLE `e_doc` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `doc_type` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uploaded_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending Review'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `e_doc`
--

INSERT INTO `e_doc` (`id`, `title`, `doc_type`, `filename`, `uploaded_on`, `status`) VALUES
(5, 'sadasd', 'Bill of Lading', 'COR.pdf', '2025-08-26 09:55:10', 'Compliant'),
(11, '123wqe', 'Compliance Certificate', 'user.php', '2025-09-01 19:41:46', 'Expired');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `data_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_activity`
--
ALTER TABLE `admin_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm`
--
ALTER TABLE `crm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `csm`
--
ALTER TABLE `csm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_doc`
--
ALTER TABLE `e_doc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_activity`
--
ALTER TABLE `admin_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `crm`
--
ALTER TABLE `crm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `csm`
--
ALTER TABLE `csm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `e_doc`
--
ALTER TABLE `e_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
