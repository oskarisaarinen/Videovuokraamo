-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18.12.2019 klo 11:46
-- Palvelimen versio: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phptesti`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `asiakas`
--

CREATE TABLE `asiakas` (
  `asiakasID` int(11) NOT NULL,
  `etunimi` varchar(100) CHARACTER SET latin1 NOT NULL,
  `sukunimi` varchar(100) CHARACTER SET latin1 NOT NULL,
  `sahkoposti` varchar(100) CHARACTER SET latin1 NOT NULL,
  `henkilotunnus` varchar(11) COLLATE utf8_bin NOT NULL,
  `lahiosoite` varchar(100) COLLATE utf8_bin NOT NULL,
  `postinumero` varchar(5) COLLATE utf8_bin NOT NULL,
  `postitoimipaikka` varchar(100) COLLATE utf8_bin NOT NULL,
  `puhelin` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Rakenne taululle `myyja`
--

CREATE TABLE `myyja` (
  `myyjaID` int(11) NOT NULL,
  `etunimi` varchar(100) NOT NULL,
  `sukunimi` varchar(100) NOT NULL,
  `lahiosoite` varchar(100) NOT NULL,
  `postinumero` varchar(5) NOT NULL,
  `postitoimipaikka` varchar(100) NOT NULL,
  `kayttajatunnus` varchar(100) NOT NULL,
  `salasana` varchar(100) NOT NULL,
  `rooli` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `myyja`
--

INSERT INTO `myyja` (`myyjaID`, `etunimi`, `sukunimi`, `lahiosoite`, `postinumero`, `postitoimipaikka`, `kayttajatunnus`, `salasana`, `rooli`) VALUES
(16, 'admin', 'admin', 'admin', '123', '123', 'admin', 'admin', 'Myyjä');

-- --------------------------------------------------------

--
-- Rakenne taululle `video`
--

CREATE TABLE `video` (
  `videoID` int(11) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `kuvaus` varchar(100) NOT NULL,
  `ikaraja` varchar(10) NOT NULL,
  `kesto` varchar(100) NOT NULL,
  `julkaisupaiva` varchar(100) NOT NULL,
  `tuotantovuosi` varchar(100) NOT NULL,
  `ohjaaja` varchar(100) NOT NULL,
  `nayttelijat` varchar(1000) NOT NULL,
  `kuva` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vedos taulusta `video`
--

INSERT INTO `video` (`videoID`, `nimi`, `genre`, `kuvaus`, `ikaraja`, `kesto`, `julkaisupaiva`, `tuotantovuosi`, `ohjaaja`, `nayttelijat`, `kuva`) VALUES
(14, 'Jurassic Park Fallen Kindom', 'Seikkailu', '', '12', '124', '26.10', '2014', 'Colin Trevorrow', 'Colin Trevorrow', 's'),
(15, 'Dumbo', 'Seikkailu', '.', '7', '111', '16.8', '2019', 'Tim Burton', 'Eva Green, Colin Farrell, Michael Keaton, Danny DeVito', 's'),
(16, 'Avengers Endgame', 'Toiminta', '.', '12', '180', '6.9', '2019', 'Anthony Russo, Joe Russo', 'Scarlett Johansson, Robert Downey Jr., Karen Gillan, Tessa Thompson, Brie Larson, Paul Rudd, Chris Evans, Chris Hemsworth, Dave Bautista', 's');

-- --------------------------------------------------------

--
-- Rakenne taululle `vuokraus`
--

CREATE TABLE `vuokraus` (
  `vuokrausID` int(11) NOT NULL,
  `asiakasID` int(11) NOT NULL,
  `vuokrauspvm` date NOT NULL,
  `palautuspvm` date NOT NULL,
  `kokonaishinta` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Rakenne taululle `vuokrausrivi`
--

CREATE TABLE `vuokrausrivi` (
  `vuokrausriviID` int(11) NOT NULL,
  `vuokrausID` int(11) NOT NULL,
  `videoID` int(11) NOT NULL,
  `hinta` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asiakas`
--
ALTER TABLE `asiakas`
  ADD PRIMARY KEY (`asiakasID`);

--
-- Indexes for table `myyja`
--
ALTER TABLE `myyja`
  ADD PRIMARY KEY (`myyjaID`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`videoID`);

--
-- Indexes for table `vuokraus`
--
ALTER TABLE `vuokraus`
  ADD PRIMARY KEY (`vuokrausID`),
  ADD KEY `asiakasID` (`asiakasID`);

--
-- Indexes for table `vuokrausrivi`
--
ALTER TABLE `vuokrausrivi`
  ADD PRIMARY KEY (`vuokrausriviID`),
  ADD KEY `vuokrausID` (`vuokrausID`),
  ADD KEY `videoID` (`videoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asiakas`
--
ALTER TABLE `asiakas`
  MODIFY `asiakasID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `myyja`
--
ALTER TABLE `myyja`
  MODIFY `myyjaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `videoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vuokraus`
--
ALTER TABLE `vuokraus`
  MODIFY `vuokrausID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vuokrausrivi`
--
ALTER TABLE `vuokrausrivi`
  MODIFY `vuokrausriviID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
