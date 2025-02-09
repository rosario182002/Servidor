-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 08-02-2025 a las 21:06:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cerveceria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `formato` varchar(100) DEFAULT NULL,
  `tamaño` varchar(50) DEFAULT NULL,
  `alergenos` text DEFAULT NULL,
  `fecha_consumo` date DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL CHECK (`precio` >= 0),
  `imagen` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `denominacion`, `marca`, `tipo`, `formato`, `tamaño`, `alergenos`, `fecha_consumo`, `precio`, `imagen`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 'Heineken', 'Heineken', 'LAGER', 'Botella', 'Tercio', 'Sin Alérgenos', '2024-12-31', 1.50, 'imagenes/heineken.png', 'Refrescante', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(2, 'Mahou Clásica', 'Mahou', 'LAGER', 'Lata', 'Tercio', 'Gluten', '2024-11-30', 1.20, 'imagenes/mahou-clasica.png', 'Sabor suave', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(3, 'Damm Estrella', 'Damm', 'LAGER', 'Lata', 'Botellín', 'Gluten', '2024-10-31', 1.00, 'imagenes/dam estrella.jpg', 'Ideal para tapear', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(4, 'Estrella Galicia', 'Estrella Galicia', 'LAGER', 'Botella', 'Tercio', 'Gluten', '2025-01-31', 1.80, 'imagenes/estrella-galicia.jpg', 'Sabor intenso', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(5, 'Alhambra Reserva', 'Alhambra', 'RUBIA', 'Botella', 'Tercio', 'Gluten', '2024-12-31', 2.00, 'imagenes/alhambra-reserva.png', 'Aroma a lúpulo', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(6, 'Cruzcampo', 'Cruzcampo', 'LAGER', 'Lata', 'Botellín', 'Gluten', '2024-09-30', 0.90, 'imagenes/cruzcampo.jpg', 'Ligera', '2025-02-08 19:02:59', '2025-02-08 19:43:32'),
(7, 'IPA Artesana', 'Cerveza Artesana', 'PALE ALE', 'Botella', 'Tercio', 'Gluten', '2024-11-30', 2.50, 'imagenes/IPA-artesana.jpg', 'Amarga', '2025-02-08 19:02:59', '2025-02-08 19:43:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL CHECK (`age` >= 0),
  `role` enum('normal','admin') NOT NULL DEFAULT 'normal',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `name`, `password`, `age`, `role`, `created_at`, `updated_at`) VALUES
(0, 'rosariodelgmor@gmail.com', 'rosario', '$2y$10$BF1U7WVhY6LEE/9kEwx9feRUn0NGdax8nlq8viF9jNgG9yPHJ1Rx6', NULL, 'normal', '2025-02-08 18:29:07', '2025-02-08 18:29:07'),
(0, 'admin@example.com', 'Administrador', '$2y$10$o6wGv.f6R6F5V51y7Wq.o07bYmGg0v/W897J1n.v4K3C8i/g6Y16', NULL, 'admin', '2025-02-08 18:42:16', '2025-02-08 19:58:33'),
(0, 'antonio@correo.com', 'Antonio', '$2y$10$3u0YQtuwu3ML6MOTDAoPJeYdAaqQRnO2XENRNyzXJLFKxAEPieJPy', NULL, 'normal', '2025-02-08 20:05:23', '2025-02-08 20:05:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
