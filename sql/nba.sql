-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-01-2025 a las 18:49:25
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apiNba`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `usuarios` (`nombre`, `apellidos`, `password`, `email`) VALUES
('ohiane', 'irure', '876766f44f53838167ca9015b34d55fb248d8f59a41fc5365c587bfe4971503d', 'ohianeis@ejemplo.com');

--
----------------------------------------------------------------

--
--Estructura de tabla para la tabla favoritos
--

DROP TABLE IF EXISTS `favoritos`;
    CREATE TABLE IF NOT EXISTS `favoritos` (
        `player_id` int NOT NULL,
        `first_name` varchar(100) COLLATE utf8mb4_unicode_ci,
        `last_name` varchar(100) COLLATE utf8mb4_unicode_ci,
        `position` varchar(10) COLLATE utf8mb4_unicode_ci,
        `height` varchar(10) COLLATE utf8mb4_unicode_ci,
        `weight` int,
        `numeroJersey` int,
        `college` varchar(100) COLLATE utf8mb4_unicode_ci,
        `country` varchar(100) COLLATE utf8mb4_unicode_ci,
        `draft_year` int,
        `draft_round` int,
        `draft_number` int,
        `team` int,
        `id` int NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (`id`),
        UNIQUE (`player_id`)

    )ENGINE=InnoDb AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
