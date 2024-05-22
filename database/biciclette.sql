-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 23, 2024 alle 00:41
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

--
-- Dump dei dati per la tabella `cartecredito`
--

INSERT INTO `cartecredito` (`ID`, `Titolare`, `NumeroCarta`, `Scadenza`, `CVV`) VALUES
(3, 'Luca Bertiato', 'fa1d3eb08a879de9', '12/25', 'be8'),
(5, 'Pippo', '0fff460dde6c581f', '12/25', '03c');

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
  `IDindirizzo` int(11) NOT NULL,
  `IDcarta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`ID`, `email`, `username`, `password`, `nome`, `cognome`, `IDindirizzo`, `IDcarta`) VALUES
(2, 'mariorossi@gmail.com', 'marioo', '0cc175b9c0f1b6a831c399e269772661', 'Mario', 'Rossi', 30, NULL),
(3, 'pippo@gmail.com', 'pippo', '0cc175b9c0f1b6a831c399e269772661', 'Pippo', 'Pluto', 34, 5),
(4, 'lucabertiato@gmail.com', 'luca', '4124bc0a9335c27f086f24ba207a4912', 'Luca', 'Bertiato', 35, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `ID` int(11) NOT NULL,
  `Via` varchar(64) NOT NULL,
  `NumeroCivico` int(11) NOT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `indirizzi`
--

INSERT INTO `indirizzi` (`ID`, `Via`, `NumeroCivico`, `lat`, `lon`) VALUES
(29, 'Via Milano', 8, NULL, NULL),
(30, 'Via Como', 85, NULL, NULL),
(34, 'Via Santa Caterina Da Siena', 7, NULL, NULL),
(35, 'Via Milano', 4, NULL, NULL),
(38, 'Via Como', 10, 45.6772639, 9.1917183),
(39, 'Viale Varese', 25, 45.6989952, 8.980146),
(40, 'Via Giuseppe Brambilla', 1, 45.8133349, 9.0883878),
(41, 'Via Milano', 10, 45.808184, 9.083636),
(42, 'Via Giuseppe Garibaldi', 20, 45.811748, 9.084683),
(43, 'Via Armando Diaz', 5, 45.812387, 9.082945),
(44, 'Via Vitani', 15, 45.814059, 9.083493),
(45, 'Via Borgo Vico', 22, 45.809868, 9.072041),
(46, 'Via Giulio Rubini', 4, 45.8117961, 9.0766464);

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
-- Dump dei dati per la tabella `stazione`
--

INSERT INTO `stazione` (`ID`, `Nome`, `NumeroSlot`, `IDindirizzo`) VALUES
(3, 'Brambilla', 12, 40),
(5, 'Stazione Garibaldi', 15, 40),
(6, 'Stazione Diaz', 8, 41),
(7, 'Stazione Vitani', 10, 42),
(8, 'Stazione Borgo Vico', 20, 43),
(9, 'Stazione Volta', 18, 44),
(10, 'Stazione San Fermo', 20, 45),
(11, 'Stazione Stadio', 12, 46);

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
  ADD UNIQUE KEY `Nome` (`Nome`),
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `clienti`
--
ALTER TABLE `clienti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `operazione`
--
ALTER TABLE `operazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `stazione`
--
ALTER TABLE `stazione`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
