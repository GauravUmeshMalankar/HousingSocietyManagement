-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 03:03 PM
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
-- Database: `housingsociety`
--

-- --------------------------------------------------------


--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_subject` varchar(255) NOT NULL,
  `announcement_text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_subject`, `announcement_text`, `created_at`) VALUES
('Annual General Meeting', 'The AGM is scheduled for April 15, 2025, at 6 PM in the clubhouse.', '2025-03-10 02:30:00'),
('Water Supply Maintenance', 'Water supply will be interrupted on March 12, 2025, from 10 AM to 4 PM.', '2025-03-08 04:45:00'),
('Society Festival Celebration', 'Join us for the Holi celebration on March 25, 2025, at the central park.', '2025-03-05 07:00:00'),
('Security Upgrade', 'New CCTV cameras will be installed at all entry points starting March 20, 2025.', '2025-03-07 04:15:00'),
('Gym Renovation', 'The gym will remain closed for maintenance from March 18 to March 25, 2025.', '2025-03-06 05:50:00'),
('Parking Allocation Update', 'Residents must update their vehicle details before March 30, 2025.', '2025-03-09 08:30:00'),
('Monthly Maintenance Due', 'Please clear your maintenance dues by March 31, 2025, to avoid penalties.', '2025-03-01 09:40:00'),
('Fire Safety Drill', 'A fire safety drill will be conducted on March 22, 2025, at 11 AM.', '2025-03-04 11:15:00'),
('Community Clean-Up Drive', 'Join us for a clean-up drive on March 16, 2025, from 8 AM to 12 PM.', '2025-03-03 02:00:00'),
('Clubhouse Booking Rules', 'Residents must book the clubhouse at least 7 days in advance.', '2025-03-02 12:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `committeemaster`
--

CREATE TABLE `committeemaster` (
  `CID` int(11) NOT NULL,
  `MID` int(11) NOT NULL,
  `MName` varchar(100) NOT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `AadharNo` varchar(12) DEFAULT NULL,
  `Designation` varchar(50) DEFAULT NULL,
  `ADate` date DEFAULT NULL,
  `DDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committeemaster`
--

INSERT INTO `committeemaster` (`CID`, `MID`, `MName`, `ContactNo`, `AadharNo`, `Designation`, `ADate`, `DDate`) VALUES
(1, 3, 'Vijay Tambe', '9876543212', '345678901234', 'Chairman', '2021-01-01', '2025-12-31'),
(2, 2, 'Palav Narayan', '9876543211', '234567890123', 'Secretary', '2021-01-01', '2025-12-31'),
(3, 1, 'Pranali Nevage', '9876543210', '123456789012', 'Tresaury', '2021-01-01', '2025-12-31'),
(4, 8, 'Lalit Nahar', '9876543217', '890123456789', 'Manager', '2022-01-01', '2026-12-31'),
(5, 10, 'Anita Joshi', '9876543219', '012345678901', 'Supervisor', '2023-01-01', '2026-12-31'),
(6, 17, 'Arun Iyer', '9876543226', '712345678908', 'Member', '2020-06-01', '2028-06-01'),
(7, 5, 'Jitendra Dubey', '9876543214', '567890123456', 'Member', '2020-06-01', '2028-06-01'),
(8, 18, 'Monica Saxena', '9876543227', '812345678909', 'Member', '2020-06-01', '2028-06-01'),
(9, 6, 'Sunita Reddy', '9876543215', '678901234567', 'Member', '2020-06-01', '2028-06-01'),
(10, 19, 'Ramesh Chandra', '9876543228', '912345678910', 'Member', '2020-06-01', '2028-06-01'),
(11, 7, 'Vikram Patel', '9876543216', '789012345678', 'Member', '2020-06-01', '2028-06-01'),
(12, 20, 'Pooja Narang', '9876543229', '101234567891', 'Member', '2020-06-01', '2028-06-01'),
(13, 9, 'Sandeep Malhotra', '9876543218', '901234567890', 'Member', '2020-06-01', '2028-06-01'),
(14, 21, 'Vivek Bhardwaj', '9876543230', '102234567892', 'Member', '2020-06-01', '2028-06-01'),
(15, 11, 'Kunal Deshmukh', '9876543220', '112345678902', 'Member', '2020-06-01', '2028-06-01'),
(16, 22, 'Geeta Soni', '9876543231', '103234567893', 'Member', '2020-06-01', '2028-06-01'),
(17, 12, 'Sonia Khanna', '9876543221', '212345678903', 'Member', '2020-06-01', '2028-06-01'),
(18, 23, 'Harish Shetty', '9876543232', '104234567894', 'Member', '2020-06-01', '2028-06-01'),
(19, 13, 'Yashwant Rao', '9876543222', '312345678904', 'Member', '2020-06-01', '2028-06-01'),
(20, 24, 'Anjali Menon', '9876543233', '105234567895', 'Member', '2020-06-01', '2028-06-01'),
(21, 14, 'Deepa Bhat', '9876543223', '412345678905', 'Member', '2020-06-01', '2028-06-01'),
(22, 15, 'Tarun Mehta', '9876543224', '512345678906', 'Member', '2020-06-01', '2028-06-01'),
(23, 16, 'Laxman Varak', '9876543225', '612345678907', 'Member', '2020-06-01', '2028-06-01'),
(24, 4, 'Anjali Parab', '9876543213', '456789012345', 'Member', '2020-06-01', '2028-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `complaint_type` enum('billing','service','technical','other') NOT NULL,
  `message` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `name`, `email`, `phone`, `complaint_type`, `message`, `submission_date`) VALUES
(1, 'Gaurav Malankar', 'user1@gmail.com', '95463875525', 'technical', 'CONTACT ME', '2025-03-03 05:42:48'),
(2, 'User2', 'user2@gmail.com', '95463875525', 'other', 'Not Working!!!', '2025-03-03 05:43:26'),
(3, 'User2', 'user2@gmail.com', '95463875525', 'other', 'Not Working!!!', '2025-03-03 05:44:00'),
(4, 'User2', 'user2@gmail.com', '95463875525', 'other', 'Not Working!!!', '2025-03-03 05:44:25');

-- --------------------------------------------------------

--
-- Table structure for table `electiondetails`
--

CREATE TABLE `electiondetails` (
  `EID` int(11) NOT NULL,
  `EDate` date NOT NULL,
  `NSecreatary` varchar(100) NOT NULL,
  `Chairman` varchar(100) DEFAULT NULL,
  `PStartDate` date DEFAULT NULL,
  `PEndDate` date DEFAULT NULL,
  `EPosition` varchar(50) NOT NULL,
  `CMembers` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `electiondetails`
--

INSERT INTO `electiondetails` (`EID`, `EDate`, `NSecreatary`, `Chairman`, `PStartDate`, `PEndDate`, `EPosition`, `CMembers`) VALUES
(1, '2020-06-01', 'Palav Narayan', 'Vijay Tambe', '2020-07-01', '2020-07-16', 'Chairman', '12'),
(2, '2021-05-10', 'Palav Narayan', 'Vijay Tambe', '2021-06-01', '2021-06-15', 'Secretary', '15'),
(3, '2022-04-15', 'Palav Narayan', 'Vijay Tambe', '2022-05-01', '2022-05-20', 'Treasurer', '18'),
(4, '2023-03-20', 'Palav Narayan', 'Pranali Nevage', '2023-04-01', '2023-04-18', 'Manager', '22'),
(5, '2024-02-25', 'Palav Narayan', 'Pranali Nevage', '2024-03-01', '2024-03-17', 'Supervisor', '24');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_title`, `event_description`, `event_date`, `created_at`) VALUES
(1, 'holi', '25 march', '2025-03-25', '2025-03-10 11:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `feedback_type` enum('Comment','Suggestion','Question') NOT NULL,
  `feedback_message` text NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `submission_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `feedback_type`, `feedback_message`, `first_name`, `last_name`, `email`, `submission_date`) VALUES
(1, 'Comment', 'Very Good Site', 'Gaurav', 'Malankar', 'user1@gmail.com', '2025-03-03 12:02:34'),
(2, 'Comment', 'Very Good Site', 'Gaurav', 'Malankar', 'user1@gmail.com', '2025-03-03 12:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `FID` int(11) NOT NULL,
  `MID` int(11) NOT NULL,
  `MName` varchar(255) NOT NULL,
  `FAmount` decimal(10,2) NOT NULL,
  `Details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fine`
--

INSERT INTO `fine` (`FID`, `MID`, `MName`, `FAmount`, `Details`) VALUES
(1, 5, 'Jitendra Dubey', 1000.00, 'Exceeding water usage limit'),
(2, 12, 'Sonia Khanna', 750.00, 'Unauthorized parking'),
(3, 20, 'Pooja Narang', 500.00, 'Improper garbage disposal'),
(4, 17, 'Arun Iyer', 600.00, 'Damage to common property'),
(5, 22, 'Geeta Soni', 500.00, 'Improper garbage disposal'),
(6, 9, 'Sandeep Malhotra', 550.00, 'Unpaid society dues'),
(7, 14, 'Deepa Bhat', 350.00, 'Failure to attend society meetings'),
(8, 24, 'Anjali Menon', 1000.00, 'Exceeding water usage limit'),
(9, 16, 'Laxman Varak', 850.00, 'Misuse of parking area'),
(10, 7, 'Vikram Patel', 250.00, 'Late maintenance payment');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `BNo` int(11) NOT NULL,
  `BDate` date NOT NULL,
  `MID` int(11) NOT NULL,
  `MName` varchar(255) NOT NULL,
  `SDate` date NOT NULL,
  `EDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `BDetails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`BNo`, `BDate`, `MID`, `MName`, `SDate`, `EDate`, `Amount`, `BDetails`) VALUES
(1, '2024-10-02', 1, 'Pranali Nevage', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(2, '2024-10-04', 2, 'Palav Narayan', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(3, '2024-10-06', 3, 'Vijay Tambe', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(4, '2024-10-08', 4, 'Anjali Parab', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(5, '2024-10-10', 5, 'Jitendra Dubey', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(6, '2024-10-12', 6, 'Sunita Reddy', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(7, '2024-10-14', 7, 'Vikram Patel', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(8, '2024-10-16', 8, 'Lalit Nahar', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(9, '2024-10-18', 9, 'Sandeep Malhotra', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(10, '2024-10-20', 10, 'Anita Joshi', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(11, '2024-10-03', 11, 'Kunal Deshmukh', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(12, '2024-10-05', 12, 'Sonia Khanna', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(13, '2024-10-07', 13, 'Yashwant Rao', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(14, '2024-10-09', 14, 'Deepa Bhat', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(15, '2024-10-11', 15, 'Tarun Mehta', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(16, '2024-10-13', 16, 'Laxman Varak', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(17, '2024-10-15', 17, 'Arun Iyer', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(18, '2024-10-17', 18, 'Monica Saxena', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(19, '2024-10-19', 19, 'Ramesh Chandra', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(20, '2024-10-21', 20, 'Pooja Narang', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(21, '2024-10-22', 21, 'Vivek Bhardwaj', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(22, '2024-10-23', 22, 'Geeta Soni', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(23, '2024-10-24', 23, 'Harish Shetty', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(24, '2024-10-25', 24, 'Anjali Menon', '2024-10-01', '2024-10-31', 1640.00, 'October'),
(25, '2024-11-01', 1, 'Pranali Nevage', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(26, '2024-11-02', 2, 'Palav Narayan', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(27, '2024-11-03', 3, 'Vijay Tambe', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(28, '2024-11-04', 4, 'Anjali Parab', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(29, '2024-11-05', 5, 'Jitendra Dubey', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(30, '2024-11-06', 6, 'Sunita Reddy', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(31, '2024-11-07', 7, 'Vikram Patel', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(32, '2024-11-08', 8, 'Lalit Nahar', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(33, '2024-11-09', 9, 'Sandeep Malhotra', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(34, '2024-11-10', 10, 'Anita Joshi', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(35, '2024-11-11', 11, 'Kunal Deshmukh', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(36, '2024-11-12', 12, 'Sonia Khanna', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(37, '2024-11-13', 13, 'Yashwant Rao', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(38, '2024-11-14', 14, 'Deepa Bhat', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(39, '2024-11-15', 15, 'Tarun Mehta', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(40, '2024-11-16', 16, 'Laxman Varak', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(41, '2024-11-17', 17, 'Arun Iyer', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(42, '2024-11-18', 18, 'Monica Saxena', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(43, '2024-11-19', 19, 'Ramesh Chandra', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(44, '2024-11-20', 20, 'Pooja Narang', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(45, '2024-11-21', 21, 'Vivek Bhardwaj', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(46, '2024-11-22', 22, 'Geeta Soni', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(47, '2024-11-23', 23, 'Harish Shetty', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(48, '2024-11-24', 24, 'Anjali Menon', '2024-11-01', '2024-11-30', 1640.00, 'November'),
(49, '2024-12-01', 12, 'Sonia Khanna', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(50, '2024-12-02', 5, 'Jitendra Dubey', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(51, '2024-12-03', 18, 'Monica Saxena', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(52, '2024-12-04', 8, 'Lalit Nahar', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(53, '2024-12-05', 21, 'Vivek Bhardwaj', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(54, '2024-12-06', 3, 'Vijay Tambe', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(55, '2024-12-07', 9, 'Sandeep Malhotra', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(56, '2024-12-08', 16, 'Laxman Varak', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(57, '2024-12-09', 24, 'Anjali Menon', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(58, '2024-12-10', 1, 'Pranali Nevage', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(59, '2024-12-11', 6, 'Sunita Reddy', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(60, '2024-12-12', 19, 'Ramesh Chandra', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(61, '2024-12-13', 10, 'Anita Joshi', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(62, '2024-12-14', 7, 'Vikram Patel', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(63, '2024-12-15', 2, 'Palav Narayan', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(64, '2024-12-16', 20, 'Pooja Narang', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(65, '2024-12-17', 14, 'Deepa Bhat', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(66, '2024-12-18', 11, 'Kunal Deshmukh', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(67, '2024-12-19', 4, 'Anjali Parab', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(68, '2024-12-20', 13, 'Yashwant Rao', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(69, '2024-12-21', 22, 'Geeta Soni', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(70, '2024-12-22', 17, 'Arun Iyer', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(71, '2024-12-23', 23, 'Harish Shetty', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(72, '2024-12-24', 15, 'Tarun Mehta', '2024-12-01', '2024-12-31', 1640.00, 'December'),
(73, '2025-01-01', 9, 'Sandeep Malhotra', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(74, '2025-01-02', 14, 'Deepa Bhat', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(75, '2025-01-03', 22, 'Geeta Soni', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(76, '2025-01-04', 4, 'Anjali Parab', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(77, '2025-01-05', 10, 'Anita Joshi', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(78, '2025-01-06', 18, 'Monica Saxena', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(79, '2025-01-07', 1, 'Pranali Nevage', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(80, '2025-01-08', 21, 'Vivek Bhardwaj', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(81, '2025-01-09', 7, 'Vikram Patel', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(82, '2025-01-10', 3, 'Vijay Tambe', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(83, '2025-01-11', 23, 'Harish Shetty', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(84, '2025-01-12', 6, 'Sunita Reddy', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(85, '2025-01-13', 16, 'Laxman Varak', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(86, '2025-01-14', 13, 'Yashwant Rao', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(87, '2025-01-15', 5, 'Jitendra Dubey', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(88, '2025-01-16', 17, 'Arun Iyer', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(89, '2025-01-17', 19, 'Ramesh Chandra', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(90, '2025-01-18', 24, 'Anjali Menon', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(91, '2025-01-19', 2, 'Palav Narayan', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(92, '2025-01-20', 8, 'Lalit Nahar', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(93, '2025-01-21', 11, 'Kunal Deshmukh', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(94, '2025-01-22', 15, 'Tarun Mehta', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(95, '2025-01-23', 12, 'Sonia Khanna', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(96, '2025-01-24', 20, 'Pooja Narang', '2025-01-01', '2025-01-31', 1640.00, 'January'),
(97, '2025-02-01', 20, 'Pooja Narang', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(98, '2025-02-02', 11, 'Kunal Deshmukh', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(99, '2025-02-03', 8, 'Lalit Nahar', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(100, '2025-02-04', 14, 'Deepa Bhat', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(101, '2025-02-05', 23, 'Harish Shetty', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(102, '2025-02-06', 12, 'Sonia Khanna', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(103, '2025-02-07', 17, 'Arun Iyer', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(104, '2025-02-08', 3, 'Vijay Tambe', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(105, '2025-02-09', 2, 'Palav Narayan', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(106, '2025-02-10', 24, 'Anjali Menon', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(107, '2025-02-11', 9, 'Sandeep Malhotra', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(108, '2025-02-12', 19, 'Ramesh Chandra', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(109, '2025-02-13', 16, 'Laxman Varak', '2025-02-01', '2025-02-28', 1640.00, 'February'),
(110, '2025-02-14', 22, 'Geeta Soni', '2025-02-01', '2025-02-28', 1640.00, 'February');

-- --------------------------------------------------------

--
-- Table structure for table `membermaster`
--

CREATE TABLE `membermaster` (
  `MID` int(11) NOT NULL,
  `MName` varchar(100) NOT NULL,
  `AadharNo` varchar(12) DEFAULT NULL,
  `FlatNo` varchar(10) DEFAULT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `AreaSqFeet` decimal(10,2) DEFAULT NULL,
  `RegID` varchar(50) DEFAULT NULL,
  `RegDate` date DEFAULT NULL,
  `CheckedBy` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membermaster`
--

INSERT INTO `membermaster` (`MID`, `MName`, `AadharNo`, `FlatNo`, `ContactNo`, `Email`, `AreaSqFeet`, `RegID`, `RegDate`, `CheckedBy`) VALUES
(1, 'Pranali Nevage', '123456789012', '101', '9876543210', 'pranalinevage@gmail.com', 1200.50, 'REG001', '2020-03-01', 'Manager'),
(2, 'Palav Narayan', '234567890123', '102', '9876543211', 'palavnarayan@gmail.com', 1300.75, 'REG002', '2018-02-14', 'Manager'),
(3, 'Vijay Tambe', '345678901234', '103', '9876543212', 'vijaytambe@gmail.com', 1100.25, 'REG003', '2017-06-08', 'Manager'),
(4, 'Anjali Parab', '456789012345', '104', '9876543213', 'anjaliparab@gmail.com', 1250.00, 'REG004', '2020-04-16', 'Supervisor'),
(5, 'Jitendra Dubey', '567890123456', '201', '9876543214', 'jitendradubey@gmail.com', 1400.60, 'REG005', '2024-03-05', 'Manager'),
(6, 'Sunita Reddy', '678901234567', '202', '9876543215', 'sunitareddy@gmail.com', 1350.80, 'REG006', '2024-03-06', 'Manager'),
(7, 'Vikram Patel', '789012345678', '203', '9876543216', 'vikrampatel@gmail.com', 1280.45, 'REG007', '2024-03-07', 'Manager'),
(8, 'Lalit Nahar', '890123456789', '204', '9876543217', 'lalitnahar@gmail.com', 1500.90, 'REG008', '2019-09-20', 'Supervisor'),
(9, 'Sandeep Malhotra', '901234567890', '301', '9876543218', 'sandeepmalhotra@gmail.com', 1325.60, 'REG009', '2024-03-09', 'Manager'),
(10, 'Anita Joshi', '012345678901', '302', '9876543219', 'anitajoshi@gmail.com', 1450.75, 'REG010', '2022-08-17', 'Supervisor'),
(11, 'Kunal Deshmukh', '112345678902', '303', '9876543220', 'kunaldeshmukh@gmail.com', 1375.20, 'REG011', '2024-03-11', 'Manager'),
(12, 'Sonia Khanna', '212345678903', '304', '9876543221', 'soniakhanna@gmail.com', 1230.85, 'REG012', '2024-03-12', 'Supervisor'),
(13, 'Yashwant Rao', '312345678904', '401', '9876543222', 'yashwantrao@gmail.com', 1400.30, 'REG013', '2024-03-13', 'Manager'),
(14, 'Deepa Bhat', '412345678905', '402', '9876543223', 'deepabhat@gmail.com', 1330.10, 'REG014', '2024-03-14', 'Manager'),
(15, 'Tarun Mehta', '512345678906', '403', '9876543224', 'tarunmehta@gmail.com', 1200.50, 'REG015', '2024-03-15', 'Manager'),
(16, 'Laxman Varak', '612345678907', '404', '9876543225', 'laxmanvarak@gmail.com', 1455.90, 'REG016', '2024-03-16', 'Supervisor'),
(17, 'Arun Iyer', '712345678908', '501', '9876543226', 'aruniyer@gmail.com', 1380.25, 'REG017', '2024-03-17', 'Manager'),
(18, 'Monica Saxena', '812345678909', '502', '9876543227', 'monicasaxena@gmail.com', 1265.75, 'REG018', '2024-03-18', 'Manager'),
(19, 'Ramesh Chandra', '912345678910', '503', '9876543228', 'rameshchandra@gmail.com', 1345.60, 'REG019', '2024-03-19', 'Manager'),
(20, 'Pooja Narang', '101234567891', '504', '9876543229', 'poojanarang@gmail.com', 1290.40, 'REG020', '2024-03-20', 'Supervisor'),
(21, 'Vivek Bhardwaj', '102234567892', '601', '9876543230', 'vivekbhardwaj@gmail.com', 1505.80, 'REG021', '2024-03-21', 'Manager'),
(22, 'Geeta Soni', '103234567893', '602', '9876543231', 'geetasoni@gmail.com', 1395.30, 'REG022', '2024-03-22', 'Manager'),
(23, 'Harish Shetty', '104234567894', '603', '9876543232', 'harishshetty@gmail.com', 1255.75, 'REG023', '2024-03-23', 'Manager'),
(24, 'Anjali Menon', '105234567895', '604', '9876543233', 'anjalimenon@gmail.com', 1450.60, 'REG024', '2024-03-24', 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `monthlymeeting`
--

CREATE TABLE `monthlymeeting` (
  `MeetID` int(11) NOT NULL,
  `MDate` date NOT NULL,
  `NDate` date NOT NULL,
  `NoticeIssuedBy` varchar(255) NOT NULL,
  `Designation` varchar(100) NOT NULL,
  `AgendaPhotoPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monthlymeeting`
--

INSERT INTO `monthlymeeting` (`MeetID`, `MDate`, `NDate`, `NoticeIssuedBy`, `Designation`, `AgendaPhotoPath`) VALUES
(1, '2024-03-05', '2024-04-05', 'Vijay Tambe', 'Budget Planning', 'uploads/agenda_march.jpg'),
(2, '2024-04-07', '2024-05-07', 'Palav Narayan', 'Maintenance Review', 'uploads/agenda_april.jpg'),
(3, '2024-05-10', '2024-06-10', 'Pranali Nevage', 'Security Concerns', 'uploads/agenda_may.jpg'),
(4, '2024-06-12', '2024-07-12', 'Lalit Nahar', 'Community Event Planning', 'uploads/agenda_june.jpg'),
(5, '2024-07-15', '2024-08-15', 'Anita Joshi', 'Annual Report Discussion', 'uploads/agenda_july.jpg'),
(6, '2024-08-18', '2024-09-18', 'Vijay Tambe', 'New Member Inductions', 'uploads/agenda_august.jpg'),
(7, '2024-09-20', '2024-10-20', 'Palav Narayan', 'Fire Safety Drill Planning', 'uploads/agenda_september.jpg'),
(8, '2024-10-22', '2024-11-22', 'Pranali Nevage', 'Festival Preparation', 'uploads/agenda_october.jpg'),
(9, '2024-11-25', '2024-12-25', 'Lalit Nahar', 'Infrastructure Upgrades', 'uploads/agenda_november.jpg'),
(10, '2024-12-28', '2025-01-28', 'Anita Joshi', 'Year-End Financial Review', 'uploads/agenda_december.jpg'),
(11, '2025-01-30', '2025-02-28', 'Vijay Tambe', 'Waste Management Discussion', 'uploads/agenda_january.jpg'),
(12, '2025-02-25', '2025-03-25', 'Palav Narayan', 'Parking Space Allocation', 'uploads/agenda_february.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` enum('admin','user') NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$P5ArodD9Ggp7T9upRxrzAOOj87nQSrW8UwEOKRYnD7F8bWKgVo.0.', '2025-03-03 15:04:47'),
(2, 'user', 'user1', 'user1@gmail.com', '$2y$10$ld5VNwoJ.kvktfK66wVQPeGeFXWlbjnvf9Z6jhqW4uDcrBZWjjFqm', '2025-03-03 15:45:11'),
(3, 'admin', 'Admin1', 'admin1@gmail.com', '$2y$10$0DStSFForHlX.ulcgogmvu9wuCB.kvCBtG8NX9PT0c5nx7Es/X/4C', '2025-03-06 14:53:21'),
(4, 'admin', 'Mob', 'mobpyscho438@gmail.com', '$2y$10$08JcSJ8/LISZ6trCt270COCWZLeVnuqI7l19c2N4jcdDJKlRT0Eia', '2025-03-08 11:22:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `committeemaster`
--
ALTER TABLE `committeemaster`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `MID` (`MID`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electiondetails`
--
ALTER TABLE `electiondetails`
  ADD PRIMARY KEY (`EID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fine`
--
ALTER TABLE `fine`
  ADD PRIMARY KEY (`FID`),
  ADD KEY `MID` (`MID`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`BNo`),
  ADD KEY `MID` (`MID`);

--
-- Indexes for table `membermaster`
--
ALTER TABLE `membermaster`
  ADD PRIMARY KEY (`MID`);

--
-- Indexes for table `monthlymeeting`
--
ALTER TABLE `monthlymeeting`
  ADD PRIMARY KEY (`MeetID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `committeemaster`
--
ALTER TABLE `committeemaster`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `electiondetails`
--
ALTER TABLE `electiondetails`
  MODIFY `EID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fine`
--
ALTER TABLE `fine`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `BNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `membermaster`
--
ALTER TABLE `membermaster`
  MODIFY `MID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `monthlymeeting`
--
ALTER TABLE `monthlymeeting`
  MODIFY `MeetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `committeemaster`
--
ALTER TABLE `committeemaster`
  ADD CONSTRAINT `committeemaster_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `membermaster` (`MID`);

--
-- Constraints for table `fine`
--
ALTER TABLE `fine`
  ADD CONSTRAINT `fine_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `membermaster` (`MID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `membermaster` (`MID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
