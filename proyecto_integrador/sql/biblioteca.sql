-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-11-2026 a las 04:28:38
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

CREATE DATABASE IF NOT EXISTS biblioteca CHARACTER SET utf8mb4;

USE biblioteca;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

DROP TABLE IF EXISTS `libros`;
CREATE TABLE IF NOT EXISTS `libros` (
  `id_libro` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `genero` varchar(60) NOT NULL,
  `anio` int NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_libro`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `autor`, `genero`, `anio`, `estado`, `id_usuario`) VALUES
(1, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 1967, 'Leyendo', 1),
(3, 'Dune', 'Frank Herbert', 'Ciencia ficción', 1965, 'Pendiente', 2),
(4, 'El principito', 'Antoine de Saint-Exupéry', 'Fábula', 1943, 'Leyendo', 2),
(5, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 1967, 'Terminado', 2),
(6, 'Los juegos del hambre', 'Suzanne Collins', 'Ciencia Ficción', 2008, 'Pendiente', 2),
(7, '1984', 'George Orwell', 'Distopía', 1949, 'Leyendo', 2),
(8, 'La sombra del viento', 'Carlos Ruiz Zafón', 'Misterio', 2001, 'Pendiente', 2),
(9, 'El señor de los anillos', 'J.R.R. Tolkien', 'Fantasía', 1954, 'Pendiente', 2),
(10, 'El problema de los tres cuerpos', 'Cixin Liu', 'Ciencia Ficción', 2008, 'Pendiente', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `telefono`, `password_hash`, `rol`) VALUES
(1, 'Pablo', 'adminpablo@gmail.com', '3311223344', '$2y$10$enItirQivRgeqcdH0QH7U.Ry1IOvlxs2NZxYfiUxHv9GebiY1kt3i', 'administrador'),
(2, 'Usuario1', 'usuario1@gmail.com', '3300000000', '$2y$10$Z8uisk8H4hbO5rcgKrNjFuZil0ulSbSa68.lVg/sCgvJ6EWyBLIcS', 'usuario'),
(3, 'Usuario2', 'usuario2@gmail.com', '3311111111', '$2y$10$AeE/Sxj8QwAo6nbXwmazsOl26dN9LaYXtYvI7gfwx6tjDDk3F/fNa', 'usuario');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
