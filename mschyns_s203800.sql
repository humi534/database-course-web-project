-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 jan. 2022 à 14:10
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mschyns_s203800`
--

-- --------------------------------------------------------

--
-- Structure de la table `aircraft`
--

DROP TABLE IF EXISTS `aircraft`;
CREATE TABLE IF NOT EXISTS `aircraft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_aircraft_type` varchar(255) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fuel_level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_aircraft_type` (`name_aircraft_type`),
  KEY `name_aircraft_type` (`name_aircraft_type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aircraft`
--

INSERT INTO `aircraft` (`id`, `name_aircraft_type`, `purchase_date`, `fuel_level`) VALUES
(2, 'B747', '2021-11-01 13:53:20', 0),
(3, 'B747', '2021-11-01 13:53:20', 0),
(4, 'B737', '2021-11-01 13:51:43', 0),
(5, 'B737', '2021-11-01 13:51:43', 0);

-- --------------------------------------------------------

--
-- Structure de la table `aircraft_movement`
--

DROP TABLE IF EXISTS `aircraft_movement`;
CREATE TABLE IF NOT EXISTS `aircraft_movement` (
  `id_aircraft` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aircraft`,`date`),
  KEY `id_aircraft` (`id_aircraft`),
  KEY `id_aircraft_2` (`id_aircraft`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aircraft_movement`
--

INSERT INTO `aircraft_movement` (`id_aircraft`, `latitude`, `longitude`, `date`) VALUES
(2, 50.6353, 5.428798, '2021-11-21 23:00:00'),
(2, 50.631663, 5.428548, '2021-11-22 23:00:00'),
(3, 50.6353, 5.428798, '2021-11-21 23:00:00'),
(3, 50.631663, 5.429659, '2021-11-22 23:00:00'),
(4, 50.632569, 5.428548, '2021-11-21 23:00:00'),
(4, 50.631663, 5.429659, '2021-11-22 23:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `aircraft_type`
--

DROP TABLE IF EXISTS `aircraft_type`;
CREATE TABLE IF NOT EXISTS `aircraft_type` (
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `max_fuel_level` int(11) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `aircraft_type`
--

INSERT INTO `aircraft_type` (`name`, `capacity`, `max_fuel_level`) VALUES
('B737', 20000, 0),
('B747', 80000, 0);

-- --------------------------------------------------------

--
-- Structure de la table `airport`
--

DROP TABLE IF EXISTS `airport`;
CREATE TABLE IF NOT EXISTS `airport` (
  `IATA` varchar(3) NOT NULL COMMENT '3 letters id',
  `long_name` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `altitude` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  PRIMARY KEY (`IATA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `airport`
--

INSERT INTO `airport` (`IATA`, `long_name`, `latitude`, `longitude`, `altitude`, `country`, `timezone`) VALUES
('CDG', 'Paris Charles de Gaulle Airport', 490036, 23255, 119, 'France', 'UTC+1'),
('LGG', 'Liege Airport', 503811, 52634, 201, 'Belgium', 'UTC+1');

-- --------------------------------------------------------

--
-- Structure de la table `flight`
--

DROP TABLE IF EXISTS `flight`;
CREATE TABLE IF NOT EXISTS `flight` (
  `id` int(11) NOT NULL,
  `id_aircraft` int(11) NOT NULL,
  `airport_departure` varchar(3) NOT NULL,
  `airport_arrival` varchar(3) NOT NULL,
  `scheduled_departure_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `observed_departure_time` timestamp NULL DEFAULT NULL,
  `scheduled_arrival_time` timestamp NULL DEFAULT NULL,
  `observed_arrival_time` timestamp NULL DEFAULT NULL,
  `id_gate` varchar(255) NOT NULL,
  `load_plan` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `airport_departure` (`airport_departure`),
  KEY `airport_arrival` (`airport_arrival`),
  KEY `id_aircraft` (`id_aircraft`),
  KEY `id_gate` (`id_gate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `flight`
--

INSERT INTO `flight` (`id`, `id_aircraft`, `airport_departure`, `airport_arrival`, `scheduled_departure_time`, `observed_departure_time`, `scheduled_arrival_time`, `observed_arrival_time`, `id_gate`, `load_plan`) VALUES
(0, 3, 'CDG', 'LGG', '2021-12-18 12:15:06', '2021-11-22 14:15:34', '2021-11-22 23:00:00', '2021-11-24 08:36:56', '2', 1),
(1, 3, 'CDG', 'LGG', '2021-12-18 12:15:10', '2021-11-03 19:04:53', '2021-11-11 17:14:00', '2021-11-11 17:20:30', '1', 11),
(2, 4, 'LGG', 'CDG', '2021-12-18 12:15:14', '2021-11-03 20:16:54', '2021-11-13 22:16:54', '2021-11-13 22:16:54', '2', 13),
(3, 3, 'CDG', 'LGG', '2021-12-18 12:15:20', '2021-11-22 09:32:00', '2021-11-29 23:00:00', NULL, '2', 14);

-- --------------------------------------------------------

--
-- Structure de la table `flight_vehicle`
--

DROP TABLE IF EXISTS `flight_vehicle`;
CREATE TABLE IF NOT EXISTS `flight_vehicle` (
  `id_flight` int(11) NOT NULL,
  `immatriculation_vehicle` varchar(255) NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_flight`,`immatriculation_vehicle`),
  KEY `immatriculation_vehicule` (`immatriculation_vehicle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `flight_vehicle`
--

INSERT INTO `flight_vehicle` (`id_flight`, `immatriculation_vehicle`, `start_date`, `end_date`) VALUES
(0, '1234567', '2021-11-24 09:35:22', '2021-11-24 08:35:22'),
(0, 'Dolly2', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'Dolly3', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'Dolly4', '2021-11-24 09:35:22', '2021-11-24 08:35:22'),
(0, 'DollySwissport1', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'DollySwissport11', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'DollySwissport12', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'DollySwissport2', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'DollySwissport3', '2021-11-24 06:35:22', '2021-11-24 07:35:22'),
(0, 'DollySwissport4', '2021-11-24 06:35:22', '2021-11-24 07:35:22');

-- --------------------------------------------------------

--
-- Structure de la table `gate`
--

DROP TABLE IF EXISTS `gate`;
CREATE TABLE IF NOT EXISTS `gate` (
  `id` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gate`
--

INSERT INTO `gate` (`id`, `latitude`, `longitude`) VALUES
(' M2', 50.6326, 5.44177),
(' M3', 50.6323, 5.44125),
('1', 50.6443, 5.46052),
('11', 50.6489, 5.46719),
('110', 50.6346, 5.42575),
('112', 50.6349, 5.42691),
('114', 50.6352, 5.42819),
('116', 50.6354, 5.42916),
('118', 50.6356, 5.43011),
('12', 50.6482, 5.4662),
('120', 50.636, 5.43088),
('122', 50.6365, 5.43178),
('124', 50.637, 5.4325),
('126', 50.6375, 5.43323),
('128', 50.6379, 5.43396),
('13', 50.6482, 5.46644),
('14', 50.6476, 5.46552),
('15', 50.647, 5.46412),
('16', 50.6469, 5.4639),
('17', 50.6464, 5.46349),
('18', 50.6462, 5.46312),
('19', 50.6459, 5.46271),
('2', 50.6439, 5.45964),
('20', 50.6456, 5.46225),
('21', 50.6454, 5.46182),
('22', 50.6451, 5.46132),
('23', 50.6449, 5.46099),
('24', 50.6445, 5.46073),
('25', 50.6442, 5.46031),
('26', 50.644, 5.45989),
('27', 50.6438, 5.45929),
('28', 50.6435, 5.45888),
('29', 50.6432, 5.45851),
('29A', 50.6434, 5.45829),
('29B', 50.6433, 5.45844),
('29C', 50.6432, 5.45859),
('29D', 50.6431, 5.45874),
('30', 50.6454, 5.46217),
('31', 50.6449, 5.46124),
('32', 50.6444, 5.46054),
('33', 50.6441, 5.45991),
('34', 50.6437, 5.45938),
('35', 50.6434, 5.45879),
('4', 50.6342, 5.44401),
('40', 50.643, 5.4581),
('40A', 50.6431, 5.4579),
('40B', 50.643, 5.4581),
('40C', 50.6428, 5.4583),
('41', 50.6426, 5.45751),
('41B', 50.6427, 5.45763),
('42', 50.6423, 5.45694),
('42B', 50.6424, 5.45723),
('42C', 50.6422, 5.45683),
('43', 50.6419, 5.45644),
('43B', 50.6419, 5.45642),
('43E', 50.6418, 5.45661),
('44', 50.6415, 5.45594),
('45', 50.641, 5.45531),
('46', 50.6405, 5.45458),
('50', 50.6401, 5.45388),
('50E', 50.6399, 5.45368),
('51', 50.6398, 5.45333),
('51E', 50.6396, 5.45311),
('52', 50.6395, 5.45279),
('53', 50.6391, 5.45224),
('53E', 50.6391, 5.45238),
('54', 50.6388, 5.45169),
('55', 50.6384, 5.45115),
('56', 50.638, 5.45064),
('57', 50.6376, 5.4501),
('58', 50.6374, 5.44951),
('59', 50.637, 5.44895),
('60', 50.6367, 5.4484),
('60E', 50.6365, 5.44813),
('61', 50.6362, 5.44793),
('62', 50.6359, 5.44738),
('62E', 50.6361, 5.44742),
('63', 50.6355, 5.4467),
('DEIC', 50.6453, 5.46082),
('G1', 50.6343, 5.44745),
('G10', 50.6348, 5.44488),
('G2', 50.6345, 5.4471),
('G3', 50.6347, 5.44675),
('G4', 50.6351, 5.44615),
('G5', 50.6354, 5.44577),
('G6', 50.6338, 5.44646),
('G7', 50.634, 5.44611),
('G8', 50.6342, 5.44576),
('G9', 50.6345, 5.44526),
('H11', 50.6334, 5.44529),
('H12', 50.6337, 5.44487),
('H13', 50.634, 5.44442),
('H14', 50.6342, 5.44401),
('HANG', 50.6324, 5.4429),
('K11', 50.6334, 5.44529),
('K12', 50.6337, 5.44487),
('K13', 50.634, 5.44442),
('L15', 50.6329, 5.44423),
('L16', 50.6331, 5.44388),
('L17', 50.6333, 5.44341),
('L18', 50.6336, 5.443),
('L19', 50.6338, 5.44269),
('M1', 50.633, 5.44229),
('M4', 50.6321, 5.44074);

-- --------------------------------------------------------

--
-- Structure de la table `good`
--

DROP TABLE IF EXISTS `good`;
CREATE TABLE IF NOT EXISTS `good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_flight` int(11) NOT NULL,
  `id_ULD` int(11) NOT NULL,
  `ULD_position` int(11) NOT NULL,
  `secure` tinyint(1) NOT NULL,
  `weight` float NOT NULL,
  `label_tag` varchar(255) NOT NULL,
  `airport_final_destination` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_flight` (`id_flight`),
  KEY `id_ULD` (`id_ULD`),
  KEY `final_destination` (`airport_final_destination`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `good`
--

INSERT INTO `good` (`id`, `id_flight`, `id_ULD`, `ULD_position`, `secure`, `weight`, `label_tag`, `airport_final_destination`) VALUES
(1, 1, 3, 1, 0, 2000.5, 'equipment', 'LGG'),
(2, 1, 3, 5, 0, 18000, 'technologies', 'LGG'),
(3, 1, 3, 7, 0, 2000, 'medical', 'LGG'),
(4, 1, 3, 11, 1, 6540.99, 'medical', 'LGG'),
(5, 1, 3, 12, 0, 12660, 'medical', 'LGG');

-- --------------------------------------------------------

--
-- Structure de la table `load_plan`
--

DROP TABLE IF EXISTS `load_plan`;
CREATE TABLE IF NOT EXISTS `load_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_flight` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_flight` (`id_flight`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` timestamp NULL DEFAULT NULL,
  `aircraft_id` int(11) NOT NULL,
  `status` enum('not yet started','warning','in progress','completed') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aircraft_id` (`aircraft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`id`, `start_date`, `end_date`, `aircraft_id`, `status`) VALUES
(7, '2021-09-27 08:05:00', '2021-09-28 08:05:00', 4, 'completed'),
(33, '2021-10-07 13:09:57', '2021-10-07 15:09:57', 3, 'not yet started'),
(45, '2021-10-06 12:36:02', NULL, 3, 'warning'),
(64, '2021-10-07 13:09:33', '2022-10-07 13:09:57', 5, 'in progress'),
(70, '2021-11-07 14:09:33', NULL, 3, 'not yet started'),
(71, '2021-10-13 06:35:14', '2021-10-17 13:09:57', 3, 'completed'),
(72, '2021-10-10 22:00:00', '2021-10-12 13:09:57', 3, 'warning'),
(73, '2021-10-13 06:35:27', NULL, 3, 'in progress'),
(74, '2021-11-02 06:16:00', NULL, 2, 'not yet started');

-- --------------------------------------------------------

--
-- Structure de la table `uld`
--

DROP TABLE IF EXISTS `uld`;
CREATE TABLE IF NOT EXISTS `uld` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  `empty_weight` int(11) NOT NULL,
  `max_gross_weight` int(10) NOT NULL,
  `volume` float NOT NULL COMMENT 'in cubic meter',
  `aircraft_type` varchar(255) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `name` (`name`),
  KEY `aircraft_type` (`aircraft_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `uld`
--

INSERT INTO `uld` (`code`, `name`, `length`, `width`, `height`, `empty_weight`, `max_gross_weight`, `volume`, `aircraft_type`) VALUES
(3, 'AAY', 3.18, 2.24, 1.99, 221, 6033, 12.2, 'B737'),
(4, 'AAY', 3.18, 2.24, 1.99, 221, 6033, 12.2, 'B747'),
(5, 'AAK', 125, 88, 62, 204, 5000, 9.2, 'B737'),
(6, 'AAK', 125, 88, 62, 204, 5000, 9.2, 'B747');

-- --------------------------------------------------------

--
-- Structure de la table `uld_movement`
--

DROP TABLE IF EXISTS `uld_movement`;
CREATE TABLE IF NOT EXISTS `uld_movement` (
  `id_ULD` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ULD`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `uld_movement`
--

INSERT INTO `uld_movement` (`id_ULD`, `latitude`, `longitude`, `date`) VALUES
(3, 50.635184, 5.428148, '2022-01-04 23:00:00'),
(3, 50.635174, 5.428548, '2022-01-05 00:00:00'),
(4, 50.641663, 5.439659, '2022-01-04 23:00:00'),
(4, 50.641663, 5.429659, '2022-01-05 00:00:00'),
(5, 50.6353, 5.428798, '2022-01-04 23:00:00'),
(5, 50.6353211, 5.428798, '2022-01-05 00:00:00'),
(6, 50.632569, 5.422797, '2022-01-04 23:00:00'),
(6, 50.632569, 5.422797, '2022-01-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `immatriculation_number` varchar(255) NOT NULL,
  `type` enum('dolly','other','GPU','lavatory-service','high loader','speed loader','refueling','push back','fire truck','toilet car','main deck loader') NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`immatriculation_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicle`
--

INSERT INTO `vehicle` (`immatriculation_number`, `type`, `purchase_date`) VALUES
('1234567', 'refueling', '2021-11-01 21:00:00'),
('1458742', 'lavatory-service', '2021-11-17 08:00:00'),
('2345678', 'speed loader', '2021-11-03 21:00:00'),
('2346125', 'toilet car', '2021-11-08 21:00:00'),
('2459886', 'high loader', '2021-11-17 08:00:00'),
('3456789', 'push back', '2021-11-01 21:00:00'),
('3468527', 'other', '2021-11-06 21:00:00'),
('7641253', 'other', '2021-11-07 21:00:00'),
('7654321', 'GPU', '2021-11-02 21:00:00'),
('7982513', 'fire truck', '2021-11-14 21:00:00'),
('8765432', 'high loader', '2021-11-01 21:00:00'),
('9876543', 'speed loader', '2021-11-06 21:00:00'),
('Dolly2', 'dolly', '2021-12-01 09:32:45'),
('Dolly3', 'dolly', '2021-12-01 09:32:45'),
('Dolly4', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport1', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport10', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport11', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport12', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport13', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport14', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport15', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport16', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport17', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport18', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport19', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport2', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport20', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport21', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport22', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport23', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport24', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport3', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport4', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport5', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport6', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport7', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport8', 'dolly', '2021-12-01 09:32:45'),
('DollySwissport9', 'dolly', '2021-12-01 09:32:45');

-- --------------------------------------------------------

--
-- Structure de la table `vehicle_movement`
--

DROP TABLE IF EXISTS `vehicle_movement`;
CREATE TABLE IF NOT EXISTS `vehicle_movement` (
  `immatriculation_vehicle` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`immatriculation_vehicle`,`date`),
  KEY `id_vehicle` (`immatriculation_vehicle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicle_movement`
--

INSERT INTO `vehicle_movement` (`immatriculation_vehicle`, `latitude`, `longitude`, `date`) VALUES
('1234567', 50.63237458, 5.44386801, '2022-01-04 23:00:00'),
('Dolly2', 50.63867501, 5.42386801, '2022-01-05 10:00:00'),
('Dolly2', 50.63226445, 5.42201214, '2022-01-05 11:00:00'),
('Dolly2', 50.63237458, 5.43386801, '2022-01-05 12:00:00');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `aircraft`
--
ALTER TABLE `aircraft`
  ADD CONSTRAINT `FK_aircraft_to_aircraft_type` FOREIGN KEY (`name_aircraft_type`) REFERENCES `aircraft_type` (`name`);

--
-- Contraintes pour la table `aircraft_movement`
--
ALTER TABLE `aircraft_movement`
  ADD CONSTRAINT `aircraft_movement_ibfk_1` FOREIGN KEY (`id_aircraft`) REFERENCES `aircraft` (`id`);

--
-- Contraintes pour la table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_5` FOREIGN KEY (`airport_departure`) REFERENCES `airport` (`IATA`),
  ADD CONSTRAINT `flight_ibfk_6` FOREIGN KEY (`airport_arrival`) REFERENCES `airport` (`IATA`),
  ADD CONSTRAINT `flight_ibfk_7` FOREIGN KEY (`id_aircraft`) REFERENCES `aircraft` (`id`),
  ADD CONSTRAINT `flight_ibfk_8` FOREIGN KEY (`id_gate`) REFERENCES `gate` (`id`);

--
-- Contraintes pour la table `flight_vehicle`
--
ALTER TABLE `flight_vehicle`
  ADD CONSTRAINT `flight_vehicle_ibfk_1` FOREIGN KEY (`immatriculation_vehicle`) REFERENCES `vehicle` (`immatriculation_number`),
  ADD CONSTRAINT `flight_vehicle_ibfk_2` FOREIGN KEY (`id_flight`) REFERENCES `flight` (`id`);

--
-- Contraintes pour la table `good`
--
ALTER TABLE `good`
  ADD CONSTRAINT `good_ibfk_1` FOREIGN KEY (`id_flight`) REFERENCES `flight` (`id`),
  ADD CONSTRAINT `good_ibfk_2` FOREIGN KEY (`id_ULD`) REFERENCES `uld` (`code`),
  ADD CONSTRAINT `good_ibfk_3` FOREIGN KEY (`airport_final_destination`) REFERENCES `airport` (`IATA`);

--
-- Contraintes pour la table `load_plan`
--
ALTER TABLE `load_plan`
  ADD CONSTRAINT `load_plan_ibfk_1` FOREIGN KEY (`id_flight`) REFERENCES `flight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft` (`id`);

--
-- Contraintes pour la table `uld`
--
ALTER TABLE `uld`
  ADD CONSTRAINT `ULD_ibfk_1` FOREIGN KEY (`aircraft_type`) REFERENCES `aircraft_type` (`name`);

--
-- Contraintes pour la table `uld_movement`
--
ALTER TABLE `uld_movement`
  ADD CONSTRAINT `ULD_movement_ibfk_1` FOREIGN KEY (`id_ULD`) REFERENCES `uld` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicle_movement`
--
ALTER TABLE `vehicle_movement`
  ADD CONSTRAINT `vehicle_movement_ibfk_1` FOREIGN KEY (`immatriculation_vehicle`) REFERENCES `vehicle` (`immatriculation_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
