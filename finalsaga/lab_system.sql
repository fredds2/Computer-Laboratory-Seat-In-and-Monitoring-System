-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 02:50 PM
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
-- Database: `lab_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(3, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `student_id`, `lab_id`, `message`) VALUES
(3, 1, 1, 'dasdsadsa'),
(4, 1, 1, 'dadsdasaaaaaaaa'),
(6, 4, 1, 'dadsdasaaaaaaaa'),
(7, 1, 1, 'hi'),
(8, 1, 1, 'hi'),
(9, 1, 1, 'hi'),
(10, 1, 1, 'hi'),
(11, 1, 1, 'hi'),
(12, 1, 1, 'hi'),
(13, 1, 1, 'hi'),
(14, 1, 1, 'hi'),
(15, 1, 1, 'hi'),
(16, 1, 1, 'hi'),
(17, 3, 1, 'dasdsadasdasdas');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `instructor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `year_level`, `instructor_name`) VALUES
(1, 'A', '1st Year', 'wellness'),
(2, 'B', '1st Year', 'wellness'),
(3, 'A', '2nd Year', 'Jimeeeeeeeeeee'),
(7, 'A', '3rd Year', 'asdasd'),
(8, 'B', '3rd Year', 'sdafdtgsf');

-- --------------------------------------------------------

--
-- Table structure for table `computer_labs`
--

CREATE TABLE `computer_labs` (
  `lab_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `total_computers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `computer_labs`
--

INSERT INTO `computer_labs` (`lab_id`, `name`, `total_computers`) VALUES
(1, 'ComLab 1', 20),
(2, 'ComLab 2', 18);

-- --------------------------------------------------------

--
-- Table structure for table `lab_seats`
--

CREATE TABLE `lab_seats` (
  `seat_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `computer_number` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_seats`
--

INSERT INTO `lab_seats` (`seat_id`, `lab_id`, `computer_number`, `student_id`) VALUES
(22, 1, 1, 2),
(42, 1, 1, 7),
(23, 1, 2, 1),
(27, 1, 3, 7),
(30, 1, 6, 4),
(47, 1, 10, 3),
(20, 2, 1, 1),
(24, 2, 2, 2),
(45, 2, 2, 3),
(44, 2, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `email` varchar(100) NOT NULL,
  `year_level` enum('1st Year','2nd Year','3rd Year') NOT NULL,
  `class` enum('A','B') NOT NULL,
  `last_active` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `password`, `gender`, `email`, `year_level`, `class`, `last_active`) VALUES
(1, 'Jimwell', '123123', 'Male', 'ds@gmail.com', '1st Year', 'A', '2025-12-18 19:43:54'),
(2, 'Jimwellz', '123', 'Male', 'dws@gmail.com', '1st Year', 'A', '2025-12-18 19:50:47'),
(3, 'Jimwellzz', '123123', 'Male', 'dwws@gmail.com', '1st Year', 'B', '2025-12-18 21:29:42'),
(4, 'Jimwellzda', '123', 'Male', 'dwdas@gmail.com', '1st Year', 'A', '2025-12-17 21:42:38'),
(6, 'asd', '123', 'Male', 'asd@gamil.com', '3rd Year', 'A', '2025-12-18 19:35:10'),
(7, 'dasdfas', '123', 'Male', 'adasasd@gamil.com', '2nd Year', 'A', '2025-12-18 19:37:49'),
(8, 'asddad', '123', 'Male', 'adasdasdasd@gamil.com', '3rd Year', 'A', '2025-12-18 21:00:11'),
(9, 'dasfg', '123', 'Female', 'asdsfggggd@gamil.com', '3rd Year', 'A', '2025-12-18 21:08:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `computer_labs`
--
ALTER TABLE `computer_labs`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `lab_seats`
--
ALTER TABLE `lab_seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD UNIQUE KEY `unique_seat_per_class` (`lab_id`,`computer_number`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `computer_labs`
--
ALTER TABLE `computer_labs`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lab_seats`
--
ALTER TABLE `lab_seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `computer_labs` (`lab_id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_seats`
--
ALTER TABLE `lab_seats`
  ADD CONSTRAINT `lab_seats_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `computer_labs` (`lab_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_seats_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
