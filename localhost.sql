-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `votacion` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `votacion`;

DROP TABLE IF EXISTS `candidatos`;
CREATE TABLE `candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `candidatos` (`id`, `nombre`) VALUES
(1,	'Tomas Jerónimo Mesa'),
(2,	'Angeline Carmona'),
(3,	' Bairon Rojas chaverra'),
(4,	'Maria Alejandra Osorio Higuita'),
(5,	' Sury Marleny Montoya'),
(6,	'Lizeth Orozco arboleda'),
(0,	'Voto en Blanco..'),
(7,	'Hosmani Pineda');

DROP TABLE IF EXISTS `votos`;
CREATE TABLE `votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidato_id` (`candidato_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE DATABASE `votoscontraloria` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `votoscontraloria`;

DROP TABLE IF EXISTS `candidatos`;
CREATE TABLE `candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `candidatos` (`id`, `nombre`) VALUES
(1,	'Luis Felipe Rua Palacio'),
(2,	'Johan Alexis Ciro'),
(3,	'Breiner Andres porras'),
(4,	'Any Yamile Brand'),
(5,	'Deisy Giraldo'),
(6,	'Victoria mesa Morales'),
(7,	'Voto en Blanco');

DROP TABLE IF EXISTS `votos`;
CREATE TABLE `votos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidato_id` (`candidato_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- 2025-07-25 19:26:43
