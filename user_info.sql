-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2025 at 11:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `valid_password` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `contact_number`, `valid_password`, `profile_image`) VALUES
(1, 'Admin 1', 'ma.altheabhea.daza@gmail.com', '9703497121', 'admin123', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1745046621/admin_profiles/hdrgn1ioqwdsn1m3pkwt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bookingform1`
--

CREATE TABLE `bookingform1` (
  `id` int(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `full_address` varchar(200) NOT NULL,
  `contact_number` bigint(50) NOT NULL,
  `bookingpreference` varchar(100) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `event_date_start` varchar(100) NOT NULL,
  `event_date_end` varchar(100) NOT NULL,
  `event_time_start` varchar(100) NOT NULL,
  `event_time_end` varchar(100) NOT NULL,
  `others` varchar(200) NOT NULL,
  `bookingtime` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform1`
--

INSERT INTO `bookingform1` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `bookingpreference`, `reason`, `event_date_start`, `event_date_end`, `event_time_start`, `event_time_end`, `others`, `bookingtime`, `status`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Meeting Office', 'Meeting', '2024-05-31', '2024-05-31', '13:00', '17:00', 'N/A', '2024-05-14 19:14:44', 'pending'),
(2, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Rotonda', 'Others', '2024-05-01', '2024-05-01', '17:00', '23:00', 'Date with Maki', '2024-05-15 17:41:59', 'pending'),
(3, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', 'Brgy. Balugo uno Albuera Leyte', 9453218768, 'Meeting Office', 'Meeting', '2024-05-27', '2024-05-27', '10:00', '00:00', 'N/A', '2024-05-18 11:09:26', 'pending'),
(4, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'City Hall', 'Event', '2024-06-15', '2024-06-15', '16:00', '22:00', 'n/a', '2024-05-18 21:03:45', 'pending'),
(5, 'Zayn Malik', 'zaynmalik@gmail.com', 'San Andres St. Poblacion Albuera Leyte', 9123456789, 'Rotonda', 'Others', '2024-07-27', '2024-07-27', '18:00', '23:59', 'Concert', '2024-05-19 16:53:44', 'pending'),
(9, 'vice Ganda', 'example@gmail.com', 'Brgy Albuera Leyte', 9876543210, 'Meeting Office', 'Meeting', '2024-05-06', '2024-05-06', '16:00', '18:00', 'N/A', '2024-05-23 08:57:43', 'pending'),
(10, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Villa Leyson, Bacayan Cebu City', 9785643421, 'Formation Building', 'Event', '2024-04-30', '2024-04-30', '22:23', '23:29', 'N/A', '2024-05-26 12:23:18', 'pending'),
(11, 'Ma. Althea Bhea Daza', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Meeting Office', 'Meeting', '2025-04-19', '2025-04-20', '18:17', '18:18', 'N/A', '2025-04-19 11:18:19', 'pending'),
(14, 'Test User', 'altheadaza934@gmail.com', '', 0, 'Community Hall A', 'Test Booking', '2025-04-19', '2025-04-19', '14:00:00', '16:00:00', '', '0000-00-00 00:00:00', 'pending'),
(15, 'Test User', 'altheadaza934@gmail.com', '', 0, 'Community Hall A', 'Test Booking', '2025-04-19', '2025-04-19', '14:00:00', '16:00:00', '', '0000-00-00 00:00:00', 'pending'),
(16, 'Ma. Althea Bhea Daza', 'ma.altheabhea.daza@gmail.com', 'Tokyo, Japan', 9703497121, 'Meeting Office', 'Meeting', '2025-04-19', '2025-04-20', '18:30', '18:30', 'unta naay aircon', '2025-04-19 12:00:01', 'pending'),
(17, 'Ma. Althea Bhea Daza', 'ma.altheabhea.daza@gmail.com', 'Tokyo, Japan', 9703497121, 'Formation Building', 'Event', '2025-04-19', '2025-04-20', '19:00', '19:00', 'unta lagi naay aircon samoka', '2025-04-19 12:06:48', 'pending'),
(19, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Plaza', 'Event', '2025-06-13', '2025-06-13', '20:47', '23:53', 'N/A', '2025-06-04 21:47:51', 'approved'),
(20, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Center', 'Activity', '2025-06-29', '2025-06-29', '10:00', '13:00', 'N/A', '2025-06-04 22:11:24', 'approved'),
(21, 'Almackie Andrew Bangalao', 'almackie101@gmail.com', 'Albuera Leyte', 9677017482, 'Meeting Office', 'Meeting', '2025-06-06', '2025-06-06', '19:00', '22:00', 'N/A', '2025-06-06 08:11:44', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `bookingform2`
--

CREATE TABLE `bookingform2` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `full_address` varchar(200) NOT NULL,
  `contact_number` bigint(50) NOT NULL,
  `bookingpreference` varchar(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `book_date_start` varchar(200) NOT NULL,
  `book_date_end` varchar(200) NOT NULL,
  `book_time_start` varchar(200) NOT NULL,
  `book_time_end` varchar(200) NOT NULL,
  `sport_equipment` varchar(200) NOT NULL,
  `others` varchar(200) NOT NULL,
  `bookingtime` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform2`
--

INSERT INTO `bookingform2` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `bookingpreference`, `reason`, `book_date_start`, `book_date_end`, `book_time_start`, `book_time_end`, `sport_equipment`, `others`, `bookingtime`, `status`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Billiard', 'Game', '2024-05-17', '2024-05-17', '08:00', '22:00', 'N/A', 'N/A', '2024-05-14 19:33:36', 'pending'),
(2, 'Reyna Marie G. Boyboy', 'reynamarieboyboy@gmail.com', 'Brgy. Cayag Ang Albuera Leyte', 9564428767, 'Swimming Pool', 'Practice', '2024-06-01', '2024-06-01', '13:00', '17:00', 'N/A', 'N/A', '2024-05-15 17:46:40', 'pending'),
(3, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', 'Brgy. Balugo uno Albuera Leyte', 9873246123, 'Gymnasium', 'Practice', '2024-05-26', '2024-05-26', '15:00', '17:00', 'N/A', 'N/A', '2024-05-15 17:48:11', 'pending'),
(4, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Sport Equipments', 'Practice', '2024-05-11', '2024-05-11', '08:00', '12:00', '2 Badminton', 'N/A', '2024-05-15 17:50:04', 'pending'),
(5, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Swimming Pool', 'Practice', '2024-06-24', '2024-06-24', '08:00', '10:00', 'n/a', 'n/a', '2024-05-18 21:00:41', 'pending'),
(6, 'Stephanie Angel Nudalo', 'stephanieangelnudalo@gmail.com', 'Brgy. Cambalading Albuera Leyte', 9998887777, 'Volleyball Court', 'Practice', '2024-10-30', '2024-10-30', '05:00', '09:00', '2 Volleyball ', 'N/A', '2024-05-21 09:02:08', 'pending'),
(7, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Table Tennis', 'Practice', '2024-04-29', '2024-04-29', '10:38', '11:53', 'N/A', 'N/A', '2024-05-26 12:36:58', 'pending'),
(8, 'Alteya', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Volleyball Court', 'Practice', '2025-04-20', '2025-04-21', '06:27', '18:27', 'N/A', 'N/A', '2025-04-19 11:27:43', 'declined'),
(11, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Swimming Pool', 'Practice', '2025-06-30', '2025-06-30', '08:12', '20:12', 'N/A', 'N/A', '2025-06-03 21:12:40', 'declined'),
(12, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Swimming Pool', 'Practice', '2025-06-30', '2025-06-30', '08:12', '20:12', 'N/A', 'N/A', '2025-06-03 21:16:18', 'approved'),
(13, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Volleyball Court', 'Activity', '2025-06-11', '2025-06-11', '15:19', '19:19', 'N/A', 'N/A', '2025-06-03 21:20:06', 'approved'),
(14, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Field/Oval', 'Event', '2025-06-17', '2025-06-17', '15:19', '19:19', 'N/A', 'N/A', '2025-06-03 21:24:16', 'pending'),
(15, 'Almackie Andrew Bangalao', 'almackie101@gmail.com', 'Albuera Leyte', 9677017482, 'Basketball Court', 'Game', '2025-06-06', '2025-06-06', '18:30', '22:30', 'N/A', 'N/A', '2025-06-06 08:13:24', 'declined');

-- --------------------------------------------------------

--
-- Table structure for table `bookingform3`
--

CREATE TABLE `bookingform3` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `full_address` varchar(200) NOT NULL,
  `contact_number` bigint(50) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `pick_up_date` varchar(100) NOT NULL,
  `pick_up_time` varchar(100) NOT NULL,
  `destination` varchar(200) NOT NULL,
  `days_use` varchar(500) NOT NULL,
  `others` varchar(200) NOT NULL,
  `bookingtime` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform3`
--

INSERT INTO `bookingform3` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `vehicle_type`, `reason`, `pick_up_date`, `pick_up_time`, `destination`, `days_use`, `others`, `bookingtime`, `status`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Bus', 'Travel', '2024-06-01', '04:00', 'Agas-Agas Bridge', '1', 'N/A', '2024-05-15 02:00:43', 'pending'),
(2, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Van', 'Travel', '2024-06-08', '05:00', 'Canigao Island', '3', 'N/A', '2024-05-16 00:12:46', 'pending'),
(3, 'Ruby Tinunga', 'rubytinunga@gmail.com', 'Brgy. Maybog Albuera Leyte', 9453218768, 'Pick-Up', 'Travel', '2024-06-02', '08:00', 'Maasin City', '1', 'N/A', '2024-05-16 00:14:06', 'pending'),
(4, 'Jenica Tayab', 'jenicatayab@gmail.com', 'Brgy. Tabgas Albuera Leyte', 9487219672, 'Multicab', 'Community Service', '2024-05-27', '10:00', 'Ormoc City', '1', 'N/A', '2024-05-16 00:15:26', 'pending'),
(5, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Van', 'Gathering', '2024-06-07', '10:00', 'Baybay City', '1', 'n/a', '2024-05-19 03:02:34', 'pending'),
(6, 'Mark Lindon Serato', 'marklindonserato@gmail.com', 'Brgy. Wangag Albuera Leyte', 9223336666, 'Trycycle', 'Team Building', '2024-06-04', '04:00', 'Cebu City', '12', 'N/A', '2024-05-21 14:33:03', 'pending'),
(7, 'Ma. Althea Bhea Daza', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Van', 'Travel', '2025-04-19', '18:34', 'Manila', '1', 'N/A', '2025-04-19 17:34:40', 'pending'),
(8, 'Tirzo Batumbakal', 'apuyatirzocharles@gmail.com', 'Latina, Leyte', 9703497121, 'Van', 'Travel', '2025-04-19', '18:30', 'North Korea', '7', 'N/A', '2025-04-19 17:57:41', 'pending'),
(9, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Potpot', 'Travel', '2025-06-18', '03:02', 'Agas-Agas Bridge', '2', 'N/A', '2025-06-04 03:03:12', 'declined'),
(10, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', 'Albuera Leyte', 9677017482, 'Trycycle', 'Travel Event', '2025-06-13', '09:00', 'Baybay City', '2', 'N/A', '2025-06-05 03:00:50', 'approved'),
(11, 'Almackie Andrew Bangalao', 'almackie101@gmail.com', 'Albuera Leyte', 9677017482, 'Multicab', 'Gathering', '2025-06-06', '15:00', 'Albuera Leyte', '1', 'N/A', '2025-06-06 14:14:11', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `booking_preferences1`
--

CREATE TABLE `booking_preferences1` (
  `id` int(11) NOT NULL,
  `preference` varchar(500) NOT NULL,
  `per_hour` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_preferences1`
--

INSERT INTO `booking_preferences1` (`id`, `preference`, `per_hour`) VALUES
(1, 'City Hall', 7000),
(2, 'Center', 2000),
(3, 'Meeting Office', 600),
(4, 'Rotonda', 100),
(5, 'Plaza', 5000),
(15, 'Formation Building', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `booking_preferences2`
--

CREATE TABLE `booking_preferences2` (
  `id` int(11) NOT NULL,
  `preference` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_preferences2`
--

INSERT INTO `booking_preferences2` (`id`, `preference`) VALUES
(1, 'Basketball Court'),
(2, 'Gymnasium'),
(3, 'Field/Oval'),
(4, 'Swimming Pool'),
(5, 'Tennis Court'),
(6, 'Volleyball Court'),
(7, 'Billiard'),
(8, 'Sport Equipments'),
(17, 'Table Tennis');

-- --------------------------------------------------------

--
-- Table structure for table `booking_preferences3`
--

CREATE TABLE `booking_preferences3` (
  `id` int(11) NOT NULL,
  `preference` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_preferences3`
--

INSERT INTO `booking_preferences3` (`id`, `preference`) VALUES
(1, 'Bus'),
(2, 'Van'),
(3, 'Truck'),
(4, 'Multicab'),
(5, 'Pick-up'),
(6, 'Trycycle'),
(7, 'Potpot'),
(8, 'Jeep'),
(17, 'Bike');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `messages` varchar(5000) NOT NULL,
  `time_sent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `fullname`, `email`, `messages`, `time_sent`) VALUES
(1, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'pwede ko makigstorya sa admin aning websit kay rag daghan kaayung kuwang og need i improve ba, nag kayamokat lang ang agi', '2024-05-19 02:22:17'),
(2, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', 'Unta na lihok na sa admin akong gi book kay i report jud nako og wala pa ba', '2024-05-19 02:53:13'),
(3, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'Akong anak moy admin ang website, perpek kaayu para nako. maong kong kinsay mo check ani ayaw intawn hagbunga, although di ni perpek para nimo pero ay lang sad hatagig 2 ako anak HAHAHAHA', '2024-05-19 22:43:58'),
(4, 'vice Ganda', 'example@gmail.com', 'asadsadasdsadsa', '2024-05-23 15:05:47'),
(5, 'Almackie Andrew Bangalao', 'almackie101@gmail.com', 'wala ra', '2025-06-05 16:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `full_address` varchar(200) NOT NULL,
  `valid_password` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `contact_number`, `full_address`, `valid_password`, `profile_image`) VALUES
(1, 'Almackie Andrew J. Bangalao', 'Almackie2227@gmail.com', '9677017482', 'Poblacion, Albuera Leyte', '$2y$10$JkahhkewjvWdUxxKuSpSK.AqcxAzgnfnfiHETIJOVIF3Svn6Ew/.C', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1749139431/user_profiles/lfmzlwb1vcptocfx7dwr.jpg'),
(2, 'Almackie Andrew Bangalao', 'almackie101@gmail.com', '9677017482', 'Albuera Leyte', '$2y$10$CFsir7B5TTnjKKjd7tRO0eAqZ5XXs180DGF082cCxo467xA15vHdW', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1749190197/user_profiles/gfliqafgcbbe4bydmiy9.jpg'),
(3, 'Almackie Andrew Bangalao', 'almackieandrew.bangalao@gmail.com', '9677017482', 'Albuera Leyte', '$2y$10$A22WB4T7Ru/fl/HkwIMkU.9lwM5c/3ggK5CSWhVpZFo2XiduR0rAa', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1749289223/user_profiles/eonwv5tha7k5uud0q7bz.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookingform1`
--
ALTER TABLE `bookingform1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookingform2`
--
ALTER TABLE `bookingform2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookingform3`
--
ALTER TABLE `bookingform3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_preferences1`
--
ALTER TABLE `booking_preferences1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_preferences2`
--
ALTER TABLE `booking_preferences2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_preferences3`
--
ALTER TABLE `booking_preferences3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookingform1`
--
ALTER TABLE `bookingform1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bookingform2`
--
ALTER TABLE `bookingform2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bookingform3`
--
ALTER TABLE `bookingform3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `booking_preferences1`
--
ALTER TABLE `booking_preferences1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `booking_preferences2`
--
ALTER TABLE `booking_preferences2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `booking_preferences3`
--
ALTER TABLE `booking_preferences3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
