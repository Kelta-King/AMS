-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2020 at 07:27 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendence_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `sub_id` int(11) DEFAULT NULL,
  `a_date` date DEFAULT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `PorA` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`sub_id`, `a_date`, `stu_id`, `PorA`) VALUES
(1, '2020-04-24', 3, '1'),
(1, '2020-04-24', 8, '1'),
(4, '2020-04-24', 3, '0'),
(4, '2020-04-24', 8, '1'),
(1, '2020-04-25', 3, '0'),
(1, '2020-04-25', 8, '0'),
(4, '2020-04-25', 3, '1'),
(4, '2020-04-25', 8, '1'),
(5, '2020-04-26', 3, '1'),
(5, '2020-04-26', 8, '1'),
(6, '2020-04-24', 3, '1'),
(6, '2020-04-24', 8, '1'),
(6, '2020-04-24', 14, '0'),
(1, '2020-04-25', 14, '1'),
(4, '2020-04-25', 14, '0');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`s_id`, `s_name`) VALUES
(1, 'Maths'),
(4, 'Science'),
(5, 'English'),
(6, 'Sanskrit'),
(7, 'Biology');

-- --------------------------------------------------------

--
-- Table structure for table `sub_teacher`
--

CREATE TABLE `sub_teacher` (
  `t_id` int(11) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_teacher`
--

INSERT INTO `sub_teacher` (`t_id`, `s_id`) VALUES
(2, 1),
(2, 4),
(2, 7),
(12, 1),
(12, 4),
(12, 5),
(15, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `RollNo` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_type` enum('student','teacher','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `RollNo`, `Name`, `password`, `account_type`) VALUES
(1, 111111, 'adminKelta', '$2y$12$YxyMDBL8m79KDwoR7cN9ne9JYOGadDCLgjdRwK/WFwBLuEycAWfSG', 'admin'),
(2, 9000001, 'Devand Sharma', '$2y$12$iTwPyMKFwTsyEbO/wn4pSuTnyVCAnsW6bu3WYnTgMTmDyqcFZL8p6', 'teacher'),
(3, 8000001, 'YOman', '$2y$12$atmsqaIi4Cn98Ar5UD/fY.iG74ABDBoUXu0tz5s6gLmD4BYLFMaba', 'student'),
(8, 9000003, 'De Sharma', '9000003', 'student'),
(12, 201852018, 'Kelta hh', '$2y$12$F6VopLWHoaN3gKYQDLevtOjYSFeTqVEnwGr0UdDuLwPTwLfMk9xQm', 'teacher'),
(14, 999999, 'Kelta Man', '$2y$12$TlajXib6ecGzoziRV5m2ke3H0U3rYSDulIEKjWvfzPhqn17W1jFEu', 'student'),
(15, 201852017, 'Yo Man', '$2y$12$B3bKvFbncqgzgGZcpdPeSuHQiH8BSCLSyT.KZsDnVmPHId8GUTeT2', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD UNIQUE KEY `stu_sub` (`sub_id`,`a_date`,`stu_id`),
  ADD KEY `stu` (`stu_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `sub_teacher`
--
ALTER TABLE `sub_teacher`
  ADD UNIQUE KEY `st_constraint` (`t_id`,`s_id`),
  ADD KEY `subjects` (`s_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `userId` (`RollNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `stu` FOREIGN KEY (`stu_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub` FOREIGN KEY (`sub_id`) REFERENCES `subjects` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_teacher`
--
ALTER TABLE `sub_teacher`
  ADD CONSTRAINT `subjects` FOREIGN KEY (`s_id`) REFERENCES `subjects` (`s_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher` FOREIGN KEY (`t_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
