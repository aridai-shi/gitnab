-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Paź 2022, 14:57
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gitnab`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `repo` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `branches`
--

INSERT INTO `branches` (`id`, `repo`, `name`) VALUES
(1, 1, 'CherryHelper_main'),
(2, 2, 'CoolNewGame_main'),
(3, 3, 'godot-engine_main'),
(4, 4, 'godot-docs_main'),
(5, 5, 'OneShot_main'),
(6, 6, 'SuperMarcoBros_main'),
(7, 7, 'DashlessHelper_main'),
(8, 8, 'IWANTMONEY_main'),
(9, 9, 'EmaHelper_main'),
(10, 10, 'GodotSlopePhysics_main'),
(11, 5, 'oneshot_solstice'),
(12, 5, 'oneshot_solstice_cedrics_branch'),
(13, 1, 'my_suggestions_for_cherry_helper_marco'),
(14, 3, 'godot_4.0'),
(15, 3, 'backport_features_to_3'),
(16, 8, 'IWM_fork_aridai');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `commits`
--

CREATE TABLE `commits` (
  `id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` text DEFAULT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `commits`
--

INSERT INTO `commits` (`id`, `branch`, `title`, `description`, `author`) VALUES
(1, 1, 'Initial commit', NULL, 1),
(2, 11, 'Began writing WM backdoor', 'TODO:\r\n- Finish writing WM backdoor\r\n- Establish alternative connections between locations\r\n- Create failsafes for Rue, Cedric and Proto\r\n- Find method to circumvent the \'one shot\' restriction', 7),
(3, 2, 'Initial commit', NULL, 1),
(4, 2, 'Tried adding enemies', 'TODO:\r\n- fix the dang enemiesssssss', 1),
(5, 2, 'asrdfasfsdfvxcvxcvcxd', NULL, 1),
(6, 6, 'began making game!', NULL, 5),
(7, 7, 'Initial commit', NULL, 1),
(8, 7, 'fixed ari\'s mess', NULL, 8),
(9, 11, 'Finished writing WM backdoor', 'TODO:\r\n- Establish alternative connections between locations\r\n- Create failsafes for Rue, Cedric and Proto\r\n- Find method to circumvent the \'one shot\' restriction', 7),
(10, 10, 'Initial commit', NULL, 1),
(11, 12, 'Established Proto failsafe', NULL, 11),
(12, 12, 'Wrote additional code for Maize', NULL, 11),
(13, 12, 'Established Rue failsafe', NULL, 11);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pull_requests`
--

CREATE TABLE `pull_requests` (
  `id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` mediumtext NOT NULL,
  `merge_into` int(11) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `auto_merge` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pull_requests`
--

INSERT INTO `pull_requests` (`id`, `branch`, `author`, `title`, `description`, `merge_into`, `resolved`, `auto_merge`) VALUES
(1, 12, 11, 'Proto failsafe & Glen failsafe', 'Wrote failsafes for Proto and the Glen getting corrupted by TWM.', 11, 0, 1),
(2, 13, 5, 'Add this aridai!!!', '', 1, 0, 0),
(3, 13, 5, 'Come on, add this aridai!!!', 'Please', 1, 0, 0),
(4, 15, 10, 'Backported GPU shader improvements to 3.5', '', 3, 1, 1),
(5, 15, 10, 'Backported move_and_slide() improvements to 3.5', '', 3, 1, 1),
(6, 1, 5, 'update to latyest', '', 13, 0, 0),
(7, 13, 5, 'ari plssss', '', 1, 0, 0),
(8, 16, 1, 'Fixed buggy ads', 'You\'re welcome, Ema', 8, 0, 1),
(9, 12, 11, 'Rue failsafe', '', 11, 0, 1),
(10, 16, 1, 'Fixed broken enemies', 'hey ema try writing an actual fsm next time', 8, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `repos`
--

CREATE TABLE `repos` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `repos`
--

INSERT INTO `repos` (`id`, `author`, `title`, `description`) VALUES
(1, 1, 'CherryHelper', 'A grabbag of cool stuff for Celeste.'),
(2, 1, 'CoolNewGame', 'A cool, new game I\'m working on.'),
(3, 10, 'godot-engine', 'A next gen, open-source game engine'),
(4, 10, 'godot-docs', 'Public repository for Godot Engine\'s docummentation'),
(5, 7, 'OneShot', 'The World Machine\'s source code.'),
(6, 5, 'SuperMarcoBros', 'Totally original game! Don\'t steal!'),
(7, 8, 'DashlessHelper', 'A helper mod for the Dashless Collab \'22.'),
(8, 8, 'IWANTMONEY', 'Game to stuff with ads for mobile, idc.'),
(9, 8, 'EmaHelper', 'Walkelines and spaghetti BEWARE!'),
(10, 1, 'GodotSlopePhysics', 'someone release me from this hell please i beg you');

--
-- Wyzwalacze `repos`
--
DELIMITER $$
CREATE TRIGGER `MAIN_AUTO` AFTER INSERT ON `repos` FOR EACH ROW INSERT INTO `branches` (`id`, `repo`, `name`) VALUES (NULL, NEW.id, CONCAT(NEW.title, '_main'))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `admin`) VALUES
(1, 'aridaishi', '$2y$10$9Ql32BmUPF/P535bv2RHd.PqZ3G4T0.b2TxMmBW95tyWBZlcaQ2pi', 1),
(2, 'RedHot23', '$2y$10$IzBKUmeWG7Vjb9ZEwoMqWeYT1OKCLeNwYct3dyokMNANTK5OfmcaG', 0),
(3, 'ORany', '$2y$10$oV0ql068cQ.VwZmUB1K.fuPeBZKNY4WmFcfoVpXJTiNww.NAFfC2C', 0),
(4, 'TestUser', '$2y$10$MSRF.exIXvarlCJ9mtjfPOkva0phMY6pRs.tYmZu/SpfZSEH1kg5K', 0),
(5, 'Marco', '$2y$10$8qp1jjgqvV8otsZNpB/elu1t5UVLIGwW89vRmRhoUUn0RG4nkG82m', 0),
(6, 'Loser22', '$2y$10$qrV6c9B9L2BSblH2SVGtce4ko/.RwTGO6HBBLmQJyCSNoF33IgCYi', 0),
(7, 'TheAuthor2206', '$2y$10$vFkm1i0CmVEvh78GsDnE4OrVlIu7x.3bWiGCvj4BY7v9hCiuTqQiG', 0),
(8, 'EmaBelotti', '$2y$10$gHtEqVFcKzMAipHNSUTw4.zOeQmTWAQO5o.loO8fmNxHPDl6DoGte', 0),
(10, 'Godot', '$2y$10$WO0ej2dO.ZD7Ua3lTgqy8e95ZnrkghhrJFvTYfUJXniswR837RLVW', 0),
(11, 'Cedric', '$2y$10$65D379.qwiJL5B2hM9ah3.Ik1bItD7y4P0QKFezKQjotW0r/4Mr6C', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `REPO` (`repo`);

--
-- Indeksy dla tabeli `commits`
--
ALTER TABLE `commits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AUTHOR` (`author`),
  ADD KEY `BRANCH` (`branch`) USING BTREE;

--
-- Indeksy dla tabeli `pull_requests`
--
ALTER TABLE `pull_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BRANCH` (`branch`),
  ADD KEY `AUTHOR` (`author`) USING BTREE,
  ADD KEY `MERGE` (`merge_into`) USING BTREE;

--
-- Indeksy dla tabeli `repos`
--
ALTER TABLE `repos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AUTHOR` (`author`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `commits`
--
ALTER TABLE `commits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `pull_requests`
--
ALTER TABLE `pull_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `repos`
--
ALTER TABLE `repos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`repo`) REFERENCES `repos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `commits`
--
ALTER TABLE `commits`
  ADD CONSTRAINT `commits_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commits_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `pull_requests`
--
ALTER TABLE `pull_requests`
  ADD CONSTRAINT `pull_requests_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pull_requests_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pull_requests_ibfk_3` FOREIGN KEY (`merge_into`) REFERENCES `branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `repos`
--
ALTER TABLE `repos`
  ADD CONSTRAINT `repos_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
