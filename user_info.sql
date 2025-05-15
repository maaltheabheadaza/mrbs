-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 12:30 PM
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
(0, 'Admin 1', 'ma.altheabhea.daza@gmail.com', '9703497121', 'admin123', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1745046621/admin_profiles/hdrgn1ioqwdsn1m3pkwt.jpg');

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
  `bookingtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform1`
--

INSERT INTO `bookingform1` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `bookingpreference`, `reason`, `event_date_start`, `event_date_end`, `event_time_start`, `event_time_end`, `others`, `bookingtime`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Meeting Office', 'Meeting', '2024-05-31', '2024-05-31', '13:00', '17:00', 'N/A', '2024-05-14 19:14:44'),
(2, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Rotonda', 'Others', '2024-05-01', '2024-05-01', '17:00', '23:00', 'Date with Maki', '2024-05-15 17:41:59'),
(3, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', 'Brgy. Balugo uno Albuera Leyte', 9453218768, 'Meeting Office', 'Meeting', '2024-05-27', '2024-05-27', '10:00', '00:00', 'N/A', '2024-05-18 11:09:26'),
(4, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'City Hall', 'Event', '2024-06-15', '2024-06-15', '16:00', '22:00', 'n/a', '2024-05-18 21:03:45'),
(5, 'Zayn Malik', 'zaynmalik@gmail.com', 'San Andres St. Poblacion Albuera Leyte', 9123456789, 'Rotonda', 'Others', '2024-07-27', '2024-07-27', '18:00', '23:59', 'Concert', '2024-05-19 16:53:44'),
(9, 'vice Ganda', 'example@gmail.com', 'Brgy Albuera Leyte', 9876543210, 'Meeting Office', 'Meeting', '2024-05-06', '2024-05-06', '16:00', '18:00', 'N/A', '2024-05-23 08:57:43'),
(10, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Villa Leyson, Bacayan Cebu City', 9785643421, 'Formation Building', 'Event', '2024-04-30', '2024-04-30', '22:23', '23:29', 'N/A', '2024-05-26 12:23:18'),
(11, 'Ma. Althea Bhea Daza', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Meeting Office', 'Meeting', '2025-04-19', '2025-04-20', '18:17', '18:18', 'N/A', '2025-04-19 11:18:19'),
(14, 'Test User', 'altheadaza934@gmail.com', '', 0, 'Community Hall A', 'Test Booking', '2025-04-19', '2025-04-19', '14:00:00', '16:00:00', '', '0000-00-00 00:00:00'),
(15, 'Test User', 'altheadaza934@gmail.com', '', 0, 'Community Hall A', 'Test Booking', '2025-04-19', '2025-04-19', '14:00:00', '16:00:00', '', '0000-00-00 00:00:00'),
(16, 'Ma. Althea Bhea Daza', 'ma.altheabhea.daza@gmail.com', 'Tokyo, Japan', 9703497121, 'Meeting Office', 'Meeting', '2025-04-19', '2025-04-20', '18:30', '18:30', 'unta naay aircon', '2025-04-19 12:00:01'),
(17, 'Ma. Althea Bhea Daza', 'ma.altheabhea.daza@gmail.com', 'Tokyo, Japan', 9703497121, 'Formation Building', 'Event', '2025-04-19', '2025-04-20', '19:00', '19:00', 'unta lagi naay aircon samoka', '2025-04-19 12:06:48');

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
  `bookingtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform2`
--

INSERT INTO `bookingform2` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `bookingpreference`, `reason`, `book_date_start`, `book_date_end`, `book_time_start`, `book_time_end`, `sport_equipment`, `others`, `bookingtime`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Billiard', 'Game', '2024-05-17', '2024-05-17', '08:00', '22:00', 'N/A', 'N/A', '2024-05-14 19:33:36'),
(2, 'Reyna Marie G. Boyboy', 'reynamarieboyboy@gmail.com', 'Brgy. Cayag Ang Albuera Leyte', 9564428767, 'Swimming Pool', 'Practice', '2024-06-01', '2024-06-01', '13:00', '17:00', 'N/A', 'N/A', '2024-05-15 17:46:40'),
(3, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', 'Brgy. Balugo uno Albuera Leyte', 9873246123, 'Gymnasium', 'Practice', '2024-05-26', '2024-05-26', '15:00', '17:00', 'N/A', 'N/A', '2024-05-15 17:48:11'),
(4, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Sport Equipments', 'Practice', '2024-05-11', '2024-05-11', '08:00', '12:00', '2 Badminton', 'N/A', '2024-05-15 17:50:04'),
(5, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Swimming Pool', 'Practice', '2024-06-24', '2024-06-24', '08:00', '10:00', 'n/a', 'n/a', '2024-05-18 21:00:41'),
(6, 'Stephanie Angel Nudalo', 'stephanieangelnudalo@gmail.com', 'Brgy. Cambalading Albuera Leyte', 9998887777, 'Volleyball Court', 'Practice', '2024-10-30', '2024-10-30', '05:00', '09:00', '2 Volleyball ', 'N/A', '2024-05-21 09:02:08'),
(7, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Table Tennis', 'Practice', '2024-04-29', '2024-04-29', '10:38', '11:53', 'N/A', 'N/A', '2024-05-26 12:36:58'),
(8, 'Alteya', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Volleyball Court', 'Practice', '2025-04-20', '2025-04-21', '06:27', '18:27', 'N/A', 'N/A', '2025-04-19 11:27:43'),
(9, 'Tirzo Charles Apuya', 'apuyatirzocharles@gmail.com', 'Latina, Leyte', 9703497121, 'Gymnasium', 'Event', '2025-04-20', '2025-04-21', '18:10', '18:10', 'N/A', 'UNTA NAAY AIRCON SHIBAL ALIMOOT KAAYO', '2025-04-19 12:11:28');

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
  `bookingtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingform3`
--

INSERT INTO `bookingform3` (`id`, `fullname`, `email`, `full_address`, `contact_number`, `vehicle_type`, `reason`, `pick_up_date`, `pick_up_time`, `destination`, `days_use`, `others`, `bookingtime`) VALUES
(1, 'Tirzo Charles Apuya', 'tirzocharlesapuya@gmail.com', 'Brgy. Seguinon Albuera Leyte', 9785643421, 'Bus', 'Travel', '2024-06-01', '04:00', 'Agas-Agas Bridge', '1', 'N/A', '2024-05-15 02:00:43'),
(2, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', 'Poblacion, Albuera Leyte', 9664669061, 'Van', 'Travel', '2024-06-08', '05:00', 'Canigao Island', '3', 'N/A', '2024-05-16 00:12:46'),
(3, 'Ruby Tinunga', 'rubytinunga@gmail.com', 'Brgy. Maybog Albuera Leyte', 9453218768, 'Pick-Up', 'Travel', '2024-06-02', '08:00', 'Maasin City', '1', 'N/A', '2024-05-16 00:14:06'),
(4, 'Jenica Tayab', 'jenicatayab@gmail.com', 'Brgy. Tabgas Albuera Leyte', 9487219672, 'Multicab', 'Community Service', '2024-05-27', '10:00', 'Ormoc City', '1', 'N/A', '2024-05-16 00:15:26'),
(5, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', 'San Jose St. Poblacion Albuera Leyte', 9876543210, 'Van', 'Gathering', '2024-06-07', '10:00', 'Baybay City', '1', 'n/a', '2024-05-19 03:02:34'),
(6, 'Mark Lindon Serato', 'marklindonserato@gmail.com', 'Brgy. Wangag Albuera Leyte', 9223336666, 'Trycycle', 'Team Building', '2024-06-04', '04:00', 'Cebu City', '12', 'N/A', '2024-05-21 14:33:03'),
(7, 'Ma. Althea Bhea Daza', 'altheadaza934@gmail.com', 'Tokyo, Japan', 9703497121, 'Van', 'Travel', '2025-04-19', '18:34', 'Manila', '1', 'N/A', '2025-04-19 17:34:40'),
(8, 'Tirzo Batumbakal', 'apuyatirzocharles@gmail.com', 'Latina, Leyte', 9703497121, 'Van', 'Travel', '2025-04-19', '18:30', 'North Korea', '7', 'N/A', '2025-04-19 17:57:41');

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
(4, 'vice Ganda', 'example@gmail.com', 'asadsadasdsadsa', '2024-05-23 15:05:47');

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
(1, 'Maria Daniel Lois B. Gian', 'mariadaniellois@gmail.com', '9664669061', 'Poblacion, Albuera Leyte', 'Loisgwapa143', NULL),
(2, 'Tirzo Charles Apuya', 'apuyatirzocharles@gmail.com', '9785643421', 'Brgy. Seguinon Albuera Leyte', 'tirzomaot123', NULL),
(3, 'Ma. Althea Bhea Daza', 'maaltheabheadaza@gmail.com', '9565243514', 'Brgy. Damulaan Albuera Leyte', 'altheagwapa123', NULL),
(4, 'Reyna Marie G. Boyboy', 'reynamarieboyboy@gmail.com', '9873246123', 'Brgy. Cayag Ang Albuera Leyte', 'reynagwapa123', NULL),
(5, 'Annie Rose Fernandez', 'annierosefernandez@gmail.com', '9453218768', 'Brgy. Balugo uno Albuera Leyte', 'anniegwapa123', NULL),
(6, 'Ruby Tinunga', 'rubytinunga@gmail.com', '9487219672', 'Brgy. Maybog Albuera Leyte', 'rubygwapa123', NULL),
(7, 'Jenica Tayab', 'jenicatayab@gmail.com', '9128757391', 'Brgy. Tabgas Albuera Leyte', 'jenicagwapa123', NULL),
(8, 'Donna Isabel J. Bangalao', 'donnaisabel@gmail.com', '9876543210', 'San Jose St. Poblacion Albuera Leyte', 'donnagwapa123', NULL),
(10, 'Arthur Nery', 'arthurnery@gmail.com', '9561234321', 'Brgy. Soob Albuera Leyte', 'arthurlami123', NULL),
(11, 'Stephanie Angel Nudalo', 'stephanieangelnudalo@gmail.com', '9998887777', 'Brgy. Cambalading Albuera Leyte', 'stephaniemaot123', NULL),
(16, 'vice Ganda', 'example@gmail.com', '987654321', 'Brgy Albuera Leyte', '12345', NULL),
(17, 'Alteya', 'altheadaza934@gmail.com', '9703497121', 'Tokyo, Japan', 'altiya123', 'https://res.cloudinary.com/dpojmjbwd/image/upload/v1744708133/user_profiles/iej7vcke1fgvqkzdhlqq.jpg');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `bookingform1`
--
ALTER TABLE `bookingform1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bookingform2`
--
ALTER TABLE `bookingform2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookingform3`
--
ALTER TABLE `bookingform3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
