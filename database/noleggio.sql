-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 29, 2024 alle 18:55
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
-- Database: `noleggio`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `biciclette`
--

CREATE TABLE `biciclette` (
  `id` int(11) NOT NULL,
  `stato` tinyint(1) NOT NULL,
  `latitudine` int(11) NOT NULL,
  `longitudine` int(11) NOT NULL,
  `kmPercorsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `cartecc`
--

CREATE TABLE `cartecc` (
  `ID` int(11) NOT NULL,
  `titolare` int(11) NOT NULL,
  `scadenza` char(7) NOT NULL,
  `cvv` char(3) NOT NULL,
  `codice` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `mail` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `idCarta` int(11) NOT NULL,
  `idIndirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzi`
--

CREATE TABLE `indirizzi` (
  `ID` int(11) NOT NULL,
  `via` varchar(32) NOT NULL,
  `numeroCivico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `operazione`
--

CREATE TABLE `operazione` (
  `ID` int(11) NOT NULL,
  `tipo` date NOT NULL,
  `dataora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idCliente` int(11) NOT NULL,
  `idBicicletta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `stazioni`
--

CREATE TABLE `stazioni` (
  `ID` int(11) NOT NULL,
  `nome` varchar(64) NOT NULL,
  `maxSlot` int(11) NOT NULL,
  `slotLiberi` int(11) NOT NULL,
  `idIndirizzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `biciclette`
--
ALTER TABLE `biciclette`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cartecc`
--
ALTER TABLE `cartecc`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `codice` (`codice`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `idCarta` (`idCarta`),
  ADD KEY `idIndirizzo` (`idIndirizzo`);

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
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idBicicletta` (`idBicicletta`);

--
-- Indici per le tabelle `stazioni`
--
ALTER TABLE `stazioni`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idIndirizzo` (`idIndirizzo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `biciclette`
--
ALTER TABLE `biciclette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cartecc`
--
ALTER TABLE `cartecc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `indirizzi`
--
ALTER TABLE `indirizzi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `stazioni`
--
ALTER TABLE `stazioni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idCarta`) REFERENCES `cartecc` (`ID`),
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`idIndirizzo`) REFERENCES `indirizzi` (`ID`);

--
-- Limiti per la tabella `operazione`
--
ALTER TABLE `operazione`
  ADD CONSTRAINT `operazione_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `operazione_ibfk_2` FOREIGN KEY (`idBicicletta`) REFERENCES `biciclette` (`id`);

--
-- Limiti per la tabella `stazioni`
--
ALTER TABLE `stazioni`
  ADD CONSTRAINT `stazioni_ibfk_1` FOREIGN KEY (`idIndirizzo`) REFERENCES `indirizzi` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
