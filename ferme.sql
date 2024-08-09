-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 09:01 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ferme`
--

-- --------------------------------------------------------

--
-- Table structure for table `aliment`
--

CREATE TABLE `aliment` (
  `id_aliment` varchar(23) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Nombre` int(60) NOT NULL,
  `PU` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aliment`
--

INSERT INTO `aliment` (`id_aliment`, `Nom`, `Description`, `Nombre`, `PU`) VALUES
('Alim-son -0-2024', 'son de riz', 'ok ', 27, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `animaux`
--

CREATE TABLE `animaux` (
  `id_animal` varchar(20) NOT NULL,
  `prod_litre` int(20) NOT NULL,
  `EtatDesante` varchar(10) NOT NULL,
  `Type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animaux`
--

INSERT INTO `animaux` (`id_animal`, `prod_litre`, `EtatDesante`, `Type`) VALUES
('C-1-2024', 23, 'BienPortan', 'Chevre'),
('M-0-2024', 0, 'BienPortan', 'Mouton'),
('V--2024', 23, 'BienPortan', 'Vache'),
('V-1-2024', 23, 'BienPortan', 'Vache'),
('V-2-2024', 0, 'Malade', 'Vache'),
('V-3-2024', 0, 'Malade', 'Vache');

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `id_compte` varchar(30) NOT NULL,
  `Location` varchar(30) NOT NULL,
  `solde` int(20) NOT NULL,
  `Type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `operation`
--

CREATE TABLE `operation` (
  `id_operation` varchar(62) NOT NULL,
  `Description` varchar(63) NOT NULL,
  `montant` int(20) NOT NULL,
  `compte` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `personne`
--

CREATE TABLE `personne` (
  `id_personnel` varchar(26) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `profil` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `personne`
--

INSERT INTO `personne` (`id_personnel`, `Nom`, `prenom`, `phone`, `email`, `profil`) VALUES
('-1-2024', 'Brice Berry', 'Irumva', '65191235', 'irumvabric@gmail.com', '1'),
('1-2-2024', 'Brice Berry', 'Irumva', '65191235', 'irumvabric@gmail.com', '3'),
('1-3-2024', 'Brice Berry', 'Irumva', '65191235', 'irumvabric@gmail.com', '4'),
('V-4-2024', 'Brice Berry', 'Irumva', '65191235', 'irumvabric@gmail.com', '2');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Description` varchar(23) NOT NULL,
  `Nombre` int(20) NOT NULL,
  `PU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `Nom`, `Description`, `Nombre`, `PU`) VALUES
('Prod-son -0-2024', 'son de riz', 'ok ', 27, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id_profil` varchar(25) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Privileges` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id_profil`, `Nom`, `Privileges`) VALUES
('1', 'Veterinaire', 'Animaux'),
('2', 'Comptable', 'Finances'),
('3', 'Stock', 'Stock'),
('4', 'Admin', 'Systeme');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(11) NOT NULL,
  `id_personne` varchar(60) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `profil` varchar(12) DEFAULT NULL,
  `fonction` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `id_personne`, `username`, `password`, `profil`, `fonction`) VALUES
(1, 'V-4-2024', 'comptable', '1234', '2', 'Gerer Finance'),
(4, '-1-2024', 'veterinaire', '1234', '1', 'Gerer animaux Malade'),
(6, '1-3-2024', 'admin', '1234', '4', 'Gerer le personnel'),
(99, '1-2-2024', 'stock', '1234', '3', 'Gerer le stock');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aliment`
--
ALTER TABLE `aliment`
  ADD PRIMARY KEY (`id_aliment`);

--
-- Indexes for table `animaux`
--
ALTER TABLE `animaux`
  ADD PRIMARY KEY (`id_animal`);

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`);

--
-- Indexes for table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id_operation`),
  ADD KEY `compteconstraint` (`compte`);

--
-- Indexes for table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`id_personnel`),
  ADD KEY `profilconstraint` (`profil`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `personneconstraint` (`id_personne`),
  ADD KEY `profileconstraint` (`profil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `compteconstraint` FOREIGN KEY (`compte`) REFERENCES `compte` (`id_compte`);

--
-- Constraints for table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `profilconstraint` FOREIGN KEY (`profil`) REFERENCES `profil` (`id_profil`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `personneconstraint` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personnel`),
  ADD CONSTRAINT `profileconstraint` FOREIGN KEY (`profil`) REFERENCES `profil` (`id_profil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
