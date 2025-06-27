-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2025 a las 19:10:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recursosdb`
--
DROP DATABASE IF EXISTS `recursosdb`;
CREATE DATABASE IF NOT EXISTS `recursosdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `recursosdb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia` (
  `id_asistencia` INT(11) NOT NULL,
  `id_empleados` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `horaEntrada` TIME NOT NULL,
  `horaSalida` TIME NOT NULL,
  `nro_legajo` INT(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `id_empleados`, `fecha`, `horaEntrada`, `horaSalida`, `nro_legajo`) VALUES
(2, 0, '2025-05-30', '14:58:15.000000', '19:47:14.000000', 6372),
(3, 0, '2025-05-30', '19:57:10.000000', '00:00:00.000000', 1111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id_empleados` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `nro_legajo` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rol` enum('empleado','admin') NOT NULL DEFAULT 'empleado',
  `codigo_barras` varchar(100) DEFAULT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleados`, `nombre`, `apellido`, `dni`, `nro_legajo`, `telefono`, `email`, `rol`, `codigo_barras`, `clave`) VALUES
(10, 'Miguel Angel', 'Sanchez', '22645780', '6372', '01127554663', 'miguesanz11@gmail.com', 'empleado', '6372', '$2y$10$2IGR/pw7f/my/CCEZnrpqewLHeWI0wFfTu1HI9Grj48Yw/9PIPGA.'),
(11, 'milton', 'gauna', '44889025', '1111', '01167543213', 'miltonsg3@gmail.com', 'empleado', '1111', '$2y$10$9Ym6U8ymUmEBIBNYpCKo9OjW2SEzNZY5iWdIVupiKc.YMxfhWdb/W'),
(12, 'rosa', 'cordoba', '22622414', '3731', '1150584534', 'rosacordoba.cr@gmail.com', 'empleado', '3731', '$2y$10$eOS9ofoJIyGBLjAVvg2KEOn.Yqwzp4ufiRKNBStRqg7Tcy189TCNO'),
(13, 'gonzalo', 'guiñazu', '36982270', '1502', '1168610643', 'gonzaloguiniazu@gmail.com', 'empleado', '1502', '$2y$10$CDP7figxpQusIUykfnodEOCPhGkxdqfHv3JkIu8TDny.hHMvF.o9q'),
(14, 'maxi', 'bonifacio', '31680301', '51', '11654789', 'maximilianofransolini@gmail.com', 'empleado', '51', '$2y$10$df9wNBn4sIBULmqStk61Au3kCegRIApuJ1/LxBtixwZqtITZKaA9G'),
(15, 'rocio', 'avalos', '', '43', '1131325955', NULL, 'empleado', NULL, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleados`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `nro_legajo` (`nro_legajo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
