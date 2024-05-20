-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 20, 2024 alle 08:59
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biciclette`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`ID`, `email`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Struttura della tabella `bici`
--

CREATE TABLE `bici` (
  `ID` int(11) NOT NULL,
  `KMtotali` int(11) NOT NULL,
  `tagRFID` varchar(16) NOT NULL,
  `gps` varchar(16) NOT NULL,
  `stato` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `cartecredito`
--

CREATE TABLE `cartecredito` (
  `ID` int(11) NOT NULL,
  `Titolare` varchar(64) NOT NULL,
  `NumeroCarta` char(16) NOT NULL,
  `Scadenza` char(5) NOT NULL,
  `CVV` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE `clienti` (
  `ID` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `codiceTessera` char(16) NOT NULL,
  `IDindirizzo` int(11) NOT NULL,
  `IDcarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `ID` int(11) NOT NULL,
  `Via` varchar(64) NOT NULL,
  `NumeroCivico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzi`
--

INSERT INTO `indirizzi` (`ID`, `Via`, `NumeroCivico`) VALUES
(1, 'Via Volta', 10),
(2, 'Via Garibaldi', 23),
(3, 'Viale Cavallotti', 18),
(4, 'Via Coloniola', 56),
(5, 'Via Balestra', 92),
(6, 'Via Belvedere', 7),
(7, 'Via Cavour', 12),
(8, 'Via Plinio', 24),
(9, 'Viale Lecco', 3),
(10, 'Via Manzoni', 21),
(11, 'Via Pascoli', 8),
(12, 'Via Dante', 34),
(13, 'Via Mazzini', 11),
(14, 'Via Machiavelli', 25),
(15, 'Via Leonardo da Vinci', 19),
(16, 'Via Boccaccio', 58),
(17, 'Via Rosmini', 96),
(18, 'Via Rovelli', 77),
(19, 'Via Cesare Cantù', 12),
(20, 'Via Giuseppe Verdi', 32),
(21, 'Via Pertini', 41),
(22, 'Via Montessori', 7),
(23, 'Via Fratelli Cairoli', 15),
(24, 'Via Carducci', 27),
(25, 'Via Confalonieri', 38),
(26, 'Via Tasso', 12),
(27, 'Via Vittorio Emanuele', 22),
(28, 'Via Brambilla', 59);

-- --------------------------------------------------------

--
-- Struttura della tabella `operazione`
--

CREATE TABLE `operazione` (
  `ID` int(11) NOT NULL,
  `tipo` enum('Noleggio','Riconsegna') NOT NULL,
  `dataora` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `KMpercorsi` int(11) DEFAULT NULL,
  `IDbici` int(11) NOT NULL,
  `IDcliente` int(11) NOT NULL,
  `IDstazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `stazione`
--

CREATE TABLE `stazione` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(32) NOT NULL,
  `NumeroSlot` int(11) NOT NULL,
  `IDindirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indici per le tabelle `bici`
--
ALTER TABLE `bici`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `tagRFID` (`tagRFID`),
  ADD UNIQUE KEY `gps` (`gps`);

--
-- Indici per le tabelle `cartecredito`
--
ALTER TABLE `cartecredito`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `NumeroCarta` (`NumeroCarta`);

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `codiceTessera` (`codiceTessera`),
  ADD KEY `IDindirizzo` (`IDindirizzo`),
  ADD KEY `IDcarta` (`IDcarta`);

--
-- Indici per le tabelle `indirizzi`
--
ALTER TABLE `indirizzi`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `operazione`
--
ALTER TABLE `operazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDbici` (`IDbici`),
  ADD KEY `IDcliente` (`IDcliente`),
  ADD KEY `IDstazione` (`IDstazione`);

--
-- Indici per le tabelle `stazione`
--
ALTER TABLE `stazione`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDindirizzo` (`IDindirizzo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `bici`
--
ALTER TABLE `bici`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cartecredito`
--
ALTER TABLE `cartecredito`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `clienti`
--
ALTER TABLE `clienti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT per la tabella `operazione`
--
ALTER TABLE `operazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `stazione`
--
ALTER TABLE `stazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bici`
--
ALTER TABLE `bici`
  ADD CONSTRAINT `bici_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `operazione` (`IDbici`);

--
-- Limiti per la tabella `clienti`
--
ALTER TABLE `clienti`
  ADD CONSTRAINT `clienti_ibfk_1` FOREIGN KEY (`IDindirizzo`) REFERENCES `indirizzi` (`ID`),
  ADD CONSTRAINT `clienti_ibfk_2` FOREIGN KEY (`IDcarta`) REFERENCES `cartecredito` (`ID`);

--
-- Limiti per la tabella `operazione`
--
ALTER TABLE `operazione`
  ADD CONSTRAINT `operazione_ibfk_1` FOREIGN KEY (`IDcliente`) REFERENCES `clienti` (`ID`),
  ADD CONSTRAINT `operazione_ibfk_2` FOREIGN KEY (`IDstazione`) REFERENCES `stazione` (`ID`);

--
-- Limiti per la tabella `stazione`
--
ALTER TABLE `stazione`
  ADD CONSTRAINT `stazione_ibfk_1` FOREIGN KEY (`IDindirizzo`) REFERENCES `indirizzi` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
