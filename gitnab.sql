-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2022 at 02:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gitnab`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `repo` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `repo`, `name`) VALUES
(1, 1, 'TEEST_main'),
(2, 1, 'new_branch');

-- --------------------------------------------------------

--
-- Table structure for table `commits`
--

CREATE TABLE `commits` (
  `id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` text DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commits`
--

INSERT INTO `commits` (`id`, `branch`, `title`, `description`, `changes`, `author`) VALUES
(1, 1, 'Initial commit', NULL, NULL, 6),
(2, 2, 'added stuff', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pull_requests`
--

CREATE TABLE `pull_requests` (
  `id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` mediumtext NOT NULL,
  `merge_with` int(11) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pull_requests`
--

INSERT INTO `pull_requests` (`id`, `branch`, `author`, `title`, `description`, `merge_with`, `resolved`) VALUES
(1, 2, 1, 'Merge my content pls!', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `repos`
--

CREATE TABLE `repos` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repos`
--

INSERT INTO `repos` (`id`, `author`, `title`, `description`) VALUES
(1, 6, 'TEEST', '');

--
-- Triggers `repos`
--
DELIMITER $$
CREATE TRIGGER `MAIN_AUTO` AFTER INSERT ON `repos` FOR EACH ROW INSERT INTO `branches` (`id`, `repo`, `name`) VALUES (NULL, NEW.id, CONCAT(NEW.title, '_main'))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `pass`) VALUES
(1, 'aridaishi', 'Temporal314'),
(2, 'EmaBelotti', 'Est1cazz1'),
(3, 'HokusPokus', 'CZARY_MARY2022'),
(4, 'uczen_tesla', 'Asaasa12'),
(5, 'THHK', 'SUPER-DUPER-F4KE-TYPE'),
(6, 'Nyanners', 'ColdSteel4Lyfe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `REPO` (`repo`);

--
-- Indexes for table `commits`
--
ALTER TABLE `commits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AUTHOR` (`author`),
  ADD KEY `BRANCH` (`branch`) USING BTREE;

--
-- Indexes for table `pull_requests`
--
ALTER TABLE `pull_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `MERGE` (`merge_with`),
  ADD KEY `BRANCH` (`branch`),
  ADD KEY `AUTHOR` (`author`) USING BTREE;

--
-- Indexes for table `repos`
--
ALTER TABLE `repos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AUTHOR` (`author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commits`
--
ALTER TABLE `commits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pull_requests`
--
ALTER TABLE `pull_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repos`
--
ALTER TABLE `repos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`repo`) REFERENCES `repos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commits`
--
ALTER TABLE `commits`
  ADD CONSTRAINT `commits_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commits_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pull_requests`
--
ALTER TABLE `pull_requests`
  ADD CONSTRAINT `pull_requests_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pull_requests_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pull_requests_ibfk_3` FOREIGN KEY (`merge_with`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repos`
--
ALTER TABLE `repos`
  ADD CONSTRAINT `repos_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
