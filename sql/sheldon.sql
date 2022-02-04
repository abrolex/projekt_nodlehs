-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Feb 2022 um 10:59
-- Server Version: 5.6.13
-- PHP-Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `sheldon`
--
CREATE DATABASE IF NOT EXISTS `sheldon` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sheldon`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `asset`
--

CREATE TABLE IF NOT EXISTS `asset` (
  `asset_id` int(255) NOT NULL AUTO_INCREMENT,
  `asset_type_id` int(255) NOT NULL,
  `asset_vendor_id` int(255) NOT NULL,
  `asset_model_id` int(255) NOT NULL,
  `asset_serial` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`asset_id`),
  UNIQUE KEY `asset_serial` (`asset_serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `asset`
--

INSERT INTO `asset` (`asset_id`, `asset_type_id`, `asset_vendor_id`, `asset_model_id`, `asset_serial`) VALUES
(1, 2, 2, 5, '1428LZ0LBB68'),
(2, 2, 2, 3, '2049LZ54GPJ9'),
(3, 4, 1, 8, '5CG812560Z'),
(4, 4, 1, 8, '5CG8125KY7'),
(5, 4, 1, 8, '5CG8125KLP'),
(6, 4, 1, 8, '5CG8125NLC'),
(7, 4, 1, 8, '5CG8125PLW'),
(8, 3, 13, 10, 'Q72W947AAAAAC0139'),
(9, 3, 13, 10, 'Q72W947AAAAAC0255'),
(10, 3, 13, 10, 'Q72W947AAAAAC0140');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `model`
--

CREATE TABLE IF NOT EXISTS `model` (
  `model_id` int(255) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `model_name` (`model_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `model`
--

INSERT INTO `model` (`model_id`, `model_name`) VALUES
(7, 'A 415'),
(5, 'B525'),
(3, 'C925e'),
(10, 'EH-416'),
(9, 'EliteBook 840G6'),
(1, 'EliteDisplay E231'),
(2, 'EliteDisplay E232'),
(8, 'ProBook 640G2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `type_id` int(255) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `type`
--

INSERT INTO `type` (`type_id`, `type_name`) VALUES
(3, 'Beamer'),
(7, 'Drucker'),
(4, 'Laptop'),
(1, 'Monitor'),
(2, 'Webcam'),
(5, 'Wlan-Repeater');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `vendor_id` int(255) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`vendor_id`),
  UNIQUE KEY `vendor_name` (`vendor_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`) VALUES
(14, 'Casio'),
(16, 'Gigaset'),
(1, 'HP'),
(2, 'Logitech'),
(13, 'Optoma'),
(11, 'Panasonic'),
(12, 'TP-Link');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
