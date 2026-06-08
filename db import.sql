-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el9.remi
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pon 08. čen 2026, 13:36
-- Verze serveru: 8.0.45
-- Verze PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `danadaki`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `deceased`
--

CREATE TABLE `deceased` (
  `birth_number` varchar(11) NOT NULL,
  `date_of_death` date NOT NULL,
  `burial_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vypisuji data pro tabulku `deceased`
--

INSERT INTO `deceased` (`birth_number`, `date_of_death`, `burial_date`) VALUES
('698756/1234', '2026-05-24', NULL),
('881116/3698', '2023-08-20', '2026-05-25');

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `deceased_full`
-- (Vlastní pohled viz níže)
--
CREATE TABLE `deceased_full` (
`birth_number` varchar(11)
,`date_of_death` date
,`burial_date` date
,`birth_date` date
,`gender` char(1)
,`name` varchar(100)
,`surname` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktura tabulky `employee`
--

CREATE TABLE `employee` (
  `birth_number` varchar(11) NOT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `salary` int DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vypisuji data pro tabulku `employee`
--

INSERT INTO `employee` (`birth_number`, `job_title`, `salary`, `password`) VALUES
('066010/6789', 'Coroner', 30000, '92af500734102f7e8b69a38a437f5b40'),
('890710/6666', 'Grave digger intern', 23000, 'b504fe50ce6bc95266f2af963cd31673');

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `employee_full`
-- (Vlastní pohled viz níže)
--
CREATE TABLE `employee_full` (
`birth_number` varchar(11)
,`job_title` varchar(100)
,`salary` int
,`password` varchar(255)
,`birth_date` date
,`gender` char(1)
,`name` varchar(100)
,`surname` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktura tabulky `person`
--

CREATE TABLE `person` (
  `birth_number` varchar(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL
) ;

--
-- Vypisuji data pro tabulku `person`
--

INSERT INTO `person` (`birth_number`, `birth_date`, `gender`, `name`, `surname`) VALUES
('015815/1234', '2001-08-15', 'F', 'Andrea', 'Danadakis'),
('066010/6789', '2006-10-13', 'F', 'Wednesday', 'Addams'),
('123456/6666', '2002-08-02', 'X', 'Kira', 'Elsayne'),
('698756/1234', '2003-12-26', 'M', 'Doug', 'Elsayne'),
('881116/3698', '1988-11-16', 'M', 'Johnny', 'Silverhand'),
('890710/6666', '1989-07-10', 'M', 'Tomas', 'Bican');

-- --------------------------------------------------------

--
-- Struktura tabulky `relative`
--

CREATE TABLE `relative` (
  `birth_number` varchar(11) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vypisuji data pro tabulku `relative`
--

INSERT INTO `relative` (`birth_number`, `phone_number`, `password`) VALUES
('015815/1234', '+420 123 456 789', '098f6bcd4621d373cade4e832627b4f6'),
('123456/6666', '+61 897 562 236', '06d80eb0c50b49a509b49f2424e8c805');

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `relative_full`
-- (Vlastní pohled viz níže)
--
CREATE TABLE `relative_full` (
`birth_number` varchar(11)
,`phone_number` varchar(100)
,`password` varchar(255)
,`birth_date` date
,`gender` char(1)
,`name` varchar(100)
,`surname` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktura tabulky `remains_management_right`
--

CREATE TABLE `remains_management_right` (
  `relative_birth_number` varchar(11) NOT NULL,
  `deceased_birth_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vypisuji data pro tabulku `remains_management_right`
--

INSERT INTO `remains_management_right` (`relative_birth_number`, `deceased_birth_number`) VALUES
('123456/6666', '698756/1234'),
('015815/1234', '881116/3698');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `deceased`
--
ALTER TABLE `deceased`
  ADD PRIMARY KEY (`birth_number`);

--
-- Indexy pro tabulku `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`birth_number`);

--
-- Indexy pro tabulku `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`birth_number`);

--
-- Indexy pro tabulku `relative`
--
ALTER TABLE `relative`
  ADD PRIMARY KEY (`birth_number`);

--
-- Indexy pro tabulku `remains_management_right`
--
ALTER TABLE `remains_management_right`
  ADD PRIMARY KEY (`relative_birth_number`,`deceased_birth_number`),
  ADD KEY `deceased_birth_number` (`deceased_birth_number`);

-- --------------------------------------------------------

--
-- Struktura pro pohled `deceased_full`
--
DROP TABLE IF EXISTS `deceased_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`danadaki`@`localhost` SQL SECURITY DEFINER VIEW `deceased_full`  AS SELECT `deceased`.`birth_number` AS `birth_number`, `deceased`.`date_of_death` AS `date_of_death`, `deceased`.`burial_date` AS `burial_date`, `person`.`birth_date` AS `birth_date`, `person`.`gender` AS `gender`, `person`.`name` AS `name`, `person`.`surname` AS `surname` FROM (`deceased` left join `person` on((`deceased`.`birth_number` = `person`.`birth_number`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `employee_full`
--
DROP TABLE IF EXISTS `employee_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`danadaki`@`localhost` SQL SECURITY DEFINER VIEW `employee_full`  AS SELECT `employee`.`birth_number` AS `birth_number`, `employee`.`job_title` AS `job_title`, `employee`.`salary` AS `salary`, `employee`.`password` AS `password`, `person`.`birth_date` AS `birth_date`, `person`.`gender` AS `gender`, `person`.`name` AS `name`, `person`.`surname` AS `surname` FROM (`employee` left join `person` on((`employee`.`birth_number` = `person`.`birth_number`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `relative_full`
--
DROP TABLE IF EXISTS `relative_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`danadaki`@`localhost` SQL SECURITY DEFINER VIEW `relative_full`  AS SELECT `relative`.`birth_number` AS `birth_number`, `relative`.`phone_number` AS `phone_number`, `relative`.`password` AS `password`, `person`.`birth_date` AS `birth_date`, `person`.`gender` AS `gender`, `person`.`name` AS `name`, `person`.`surname` AS `surname` FROM (`relative` left join `person` on((`relative`.`birth_number` = `person`.`birth_number`))) ;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `deceased`
--
ALTER TABLE `deceased`
  ADD CONSTRAINT `deceased_ibfk_1` FOREIGN KEY (`birth_number`) REFERENCES `person` (`birth_number`);

--
-- Omezení pro tabulku `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`birth_number`) REFERENCES `person` (`birth_number`);

--
-- Omezení pro tabulku `relative`
--
ALTER TABLE `relative`
  ADD CONSTRAINT `relative_ibfk_1` FOREIGN KEY (`birth_number`) REFERENCES `person` (`birth_number`);

--
-- Omezení pro tabulku `remains_management_right`
--
ALTER TABLE `remains_management_right`
  ADD CONSTRAINT `remains_management_right_FK_1` FOREIGN KEY (`relative_birth_number`) REFERENCES `relative` (`birth_number`),
  ADD CONSTRAINT `remains_management_right_ibfk_1` FOREIGN KEY (`relative_birth_number`) REFERENCES `relative` (`birth_number`),
  ADD CONSTRAINT `remains_management_right_ibfk_2` FOREIGN KEY (`deceased_birth_number`) REFERENCES `deceased` (`birth_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
