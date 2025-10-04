-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2025 a las 01:28:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sist_gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_medicos`
--

CREATE TABLE `equipos_medicos` (
  `id` int(11) NOT NULL,
  `numero_activo` varchar(50) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `codigo_ubicacion` varchar(50) DEFAULT NULL,
  `codigo_responsable` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos_medicos`
--

INSERT INTO `equipos_medicos` (`id`, `numero_activo`, `marca`, `modelo`, `codigo_ubicacion`, `codigo_responsable`) VALUES
(1, 'E3001', 'SIEMENS', 'X-Ray 5000', 'U1004', 'R2001'),
(2, 'E3002', 'Philips', 'Monitor Cardíaco MX700', 'U1002', 'R2002'),
(7, 'E3004', 'Medtronic', 'Analizador Hematologico BC-3600', 'U1003', 'R2004'),
(8, 'E3003', 'Dräger', 'IntelliVue MX700', 'U1003', 'R2003'),
(9, 'E3005', 'Mindray', 'BeneHeart D3', 'U1002', 'R2004');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id` int(11) NOT NULL,
  `codigo_asignado` varchar(50) NOT NULL,
  `documento_identidad` varchar(50) NOT NULL,
  `nombre_apellidos` varchar(150) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id`, `codigo_asignado`, `documento_identidad`, `nombre_apellidos`, `cargo`, `telefono`) VALUES
(1, 'R2001', '1012345678', 'Juan Pérez López', 'Especialista', '3101112233'),
(2, 'R2002', '1098765432', 'María Gómez Ruiz', 'Auxiliar', '3102223344'),
(3, 'R2003', '1122334455', 'Carlos Rodríguez Méndez', 'Secretaria', '3103334455'),
(4, 'R2004', '1155667788', 'Laura Martínez Díaz', 'Especialista', '3104445566');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(11) NOT NULL,
  `codigo_asignado` varchar(50) NOT NULL,
  `nombre_ubicacion` varchar(100) NOT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `codigo_asignado`, `nombre_ubicacion`, `ubicacion`, `telefono`) VALUES
(1, 'U1001', 'Pediatría', 'Piso 3 - Ala Norte', '3001234567'),
(2, 'U1002', 'Urgencias', 'Piso 1 - Ala Sur', '3009876543'),
(3, 'U1003', 'Laboratorio', 'Piso 2 - Ala Este', '3005551212'),
(4, 'U1004', 'Radiología', 'Piso 4 - Ala Oeste', '3006667777');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos_medicos`
--
ALTER TABLE `equipos_medicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos_medicos`
--
ALTER TABLE `equipos_medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
