-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 06:41 PM
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
-- Database: `online_naručivanje_deluxe_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `id_komentara` int(50) NOT NULL,
  `id_usera` int(50) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `tekst` varchar(225) NOT NULL,
  `ID_proizvoda` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id_komentara`, `id_usera`, `naziv`, `tekst`, `ID_proizvoda`) VALUES
(158, 1, 'www', 'www', 1),
(159, 19, 'odlično', 'odlično', 1);

-- --------------------------------------------------------

--
-- Table structure for table `korpa`
--

CREATE TABLE `korpa` (
  `proizvod_id` int(30) NOT NULL,
  `kolicina` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--

CREATE TABLE `proizvodi` (
  `proizvod_id` int(11) NOT NULL,
  `naziv_proizvoda` varchar(255) NOT NULL,
  `cijena` float NOT NULL,
  `slika` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`proizvod_id`, `naziv_proizvoda`, `cijena`, `slika`) VALUES
(1, 'Hamburger', 4.99, 'slike-video/hamburger.jpg'),
(2, 'Pomfrit', 2.49, 'slike-video/pomfrit.jpg'),
(5, 'Pileći File', 8, 'slike-video/pileciFile.jpg'),
(9, 'Chicken', 3.5, 'slike-video/chicken.jpg'),
(12, 'Baklava', 3.5, 'slike-video/baklava.jpg'),
(13, 'Burek', 2.5, 'slike-video/burek.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registracija`
--

CREATE TABLE `registracija` (
  `ID` int(11) NOT NULL,
  `Ime` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `datumrod` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `id_rolovi` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registracija`
--

INSERT INTO `registracija` (`ID`, `Ime`, `email`, `username`, `datumrod`, `password`, `id_rolovi`) VALUES
(1, 'Imad', 'imad.hubljar2@gmail.com', 'Prusco', '03.05.2003', 'Prusco12345', 1),
(2, 'Amer', 'amer.delic@gmail.com', 'Picni', '2023-02-15', 'Amder', 2),
(13, 'pop', 'ghfjh@gmail.com ', 'pop', '2023-04-02', '123', 3),
(14, 'Sale', 'sale@size.ba', 'GamerBoy', '2006-06-06', '1234567', 3),
(15, 'Adis', 'adis@size.ba', 'Qadis', '2002-07-26', '1234567', 3),
(19, 'ibro ', 'ibro@gmail.com', 'brajče', '2002-10-14', 'brajče', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rolovi`
--

CREATE TABLE `rolovi` (
  `id_rolovi` int(11) NOT NULL,
  `Naziv` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolovi`
--

INSERT INTO `rolovi` (`id_rolovi`, `Naziv`) VALUES
(1, 'GAdmin'),
(2, 'Admin'),
(3, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`id_komentara`),
  ADD KEY `komentar_user` (`id_usera`),
  ADD KEY `komentar_proizvod` (`ID_proizvoda`);

--
-- Indexes for table `korpa`
--
ALTER TABLE `korpa`
  ADD PRIMARY KEY (`proizvod_id`);

--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`proizvod_id`);

--
-- Indexes for table `registracija`
--
ALTER TABLE `registracija`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_regitracija_rolovi` (`id_rolovi`);

--
-- Indexes for table `rolovi`
--
ALTER TABLE `rolovi`
  ADD PRIMARY KEY (`id_rolovi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `id_komentara` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `proizvod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `registracija`
--
ALTER TABLE `registracija`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentar_proizvod` FOREIGN KEY (`ID_proizvoda`) REFERENCES `proizvodi` (`proizvod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_user` FOREIGN KEY (`id_usera`) REFERENCES `registracija` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registracija`
--
ALTER TABLE `registracija`
  ADD CONSTRAINT `FK_regitracija_rolovi` FOREIGN KEY (`id_rolovi`) REFERENCES `rolovi` (`id_rolovi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
