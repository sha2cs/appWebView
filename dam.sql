-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2024 a las 15:32:49
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
-- Base de datos: `dam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_atencion`
--

CREATE TABLE `estado_atencion` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_atencion`
--

INSERT INTO `estado_atencion` (`id_estado`, `estado`) VALUES
(1, 'ATENCIÓN EN ESPERA '),
(2, 'ATENCIÓN EN PROCESÓ '),
(4, 'ATENDIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_tipoDocumento` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `documento` int(11) NOT NULL,
  `edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `id_estado`, `id_tipoDocumento`, `nombres`, `apellidos`, `documento`, `edad`) VALUES
(1, 4, 1, 'kevin enrique', 'tique sanabria', 1005221629, 23),
(3, 4, 1, 'sebastian', 'paes', 1128464014, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposdocumentos`
--

CREATE TABLE `tiposdocumentos` (
  `id_tipoDocumento` int(11) NOT NULL,
  `glosa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposdocumentos`
--

INSERT INTO `tiposdocumentos` (`id_tipoDocumento`, `glosa`) VALUES
(1, 'CEDULA DE CIUDADANÍA '),
(2, 'TARGETA  DE IDENTIDAD'),
(3, 'CEDULA DE EXTRANJERIA'),
(4, 'REGISTRO CIVIL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado_atencion`
--
ALTER TABLE `estado_atencion`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `pacientes_tiposdocumentos_FK` (`id_tipoDocumento`),
  ADD KEY `pacientes_estado_atencion_FK` (`id_estado`);

--
-- Indices de la tabla `tiposdocumentos`
--
ALTER TABLE `tiposdocumentos`
  ADD PRIMARY KEY (`id_tipoDocumento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estado_atencion`
--
ALTER TABLE `estado_atencion`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiposdocumentos`
--
ALTER TABLE `tiposdocumentos`
  MODIFY `id_tipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_estado_atencion_FK` FOREIGN KEY (`id_estado`) REFERENCES `estado_atencion` (`id_estado`),
  ADD CONSTRAINT `pacientes_tiposdocumentos_FK` FOREIGN KEY (`id_tipoDocumento`) REFERENCES `tiposdocumentos` (`id_tipoDocumento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
