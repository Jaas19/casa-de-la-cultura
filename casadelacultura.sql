-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2026 a las 18:09:08
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
-- Base de datos: `casadelacultura`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Activa',
  `important` tinyint(1) NOT NULL DEFAULT 0,
  `starting_date` date NOT NULL,
  `ending_date` date DEFAULT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `name`, `status`, `important`, `starting_date`, `ending_date`, `starting_time`, `ending_time`, `created_at`, `updated_at`) VALUES
(1, 2, 'Concierto 3', 'Suspendida', 0, '2025-10-26', '2025-10-26', '20:27:18', '21:31:18', NULL, '2025-12-10 17:46:35'),
(3, 2, 'Concierto de Año Nuevo', 'Pospuesta', 0, '2026-02-14', '2026-02-15', '21:00:00', '02:00:00', NULL, '2025-11-06 15:32:05'),
(4, 2, 'Fiesta en la casa de la cultura', 'Completada', 0, '2025-11-13', '2025-11-14', '23:30:00', '03:30:00', '2025-10-31 18:40:36', '2025-10-31 21:00:08'),
(5, 2, 'Fiesta en la casa de la cultura', 'Suspendida', 0, '2025-11-13', '2025-11-14', '23:30:00', '03:30:00', '2025-10-31 18:41:08', '2025-10-31 18:41:08'),
(6, 2, 'Fiesta en la casa de la cultura', 'Suspendida', 0, '2025-11-13', '2025-11-14', '23:30:00', '03:30:00', '2025-10-31 18:41:15', '2025-10-31 18:41:15'),
(8, 2, 'Fiesta Longeva en la Casa de la Cultura', 'En Espera', 0, '2025-12-21', '2025-12-12', '21:21:00', '12:12:00', '2025-11-07 17:34:46', '2026-01-15 17:40:32'),
(9, 2, 'Fiesta Navideña', 'En Espera', 0, '2025-12-18', '2025-12-19', '12:00:00', '17:00:00', '2025-11-07 21:22:52', '2026-01-15 17:40:32'),
(10, 2, 'Fiesta', 'En Espera', 1, '2025-12-04', '2025-12-04', '02:00:00', '03:00:00', '2025-12-04 20:35:39', '2026-01-15 17:40:32'),
(11, 2, 'Fiesta 2', 'En Espera', 1, '2025-12-05', '2025-12-07', '07:00:00', '07:00:00', '2025-12-04 21:14:22', '2026-01-15 17:40:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_dates`
--

CREATE TABLE `activity_dates` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activity_dates`
--

INSERT INTO `activity_dates` (`id`, `activity_id`, `date`, `updated_at`, `created_at`) VALUES
(3, 8, '2025-02-21', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(4, 8, '2025-11-21', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(5, 9, '2025-12-18', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(6, 9, '2025-12-19', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(43, 1, '2025-10-26', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(44, 1, '2025-10-30', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(45, 1, '2025-10-31', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(46, 1, '2025-10-31', '2025-12-10 23:48:17', '2025-12-10 23:48:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_goods`
--

CREATE TABLE `activity_goods` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `quantity_requested` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activity_goods`
--

INSERT INTO `activity_goods` (`id`, `activity_id`, `good_id`, `quantity_requested`, `updated_at`, `created_at`) VALUES
(2, 8, 17, 1, '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(3, 8, 4, 1, '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(4, 9, 2, 1, '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(5, 9, 3, 1, '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(22, 1, 1, 2, '2025-12-10 23:48:17', '2025-12-10 23:48:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_hours`
--

CREATE TABLE `activity_hours` (
  `id` int(11) NOT NULL,
  `date_id` int(11) NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activity_hours`
--

INSERT INTO `activity_hours` (`id`, `date_id`, `starting_time`, `ending_time`, `updated_at`, `created_at`) VALUES
(4, 3, '12:12:00', '12:12:00', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(5, 3, '12:12:00', '21:21:00', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(6, 4, '12:12:00', '12:12:00', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(7, 5, '12:00:00', '17:00:00', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(8, 6, '13:00:00', '17:00:00', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(66, 43, '21:27:00', '21:30:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(67, 43, '21:31:00', '21:31:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(68, 43, '23:00:00', '00:00:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(69, 44, '14:52:00', '14:55:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(70, 45, '10:00:00', '10:30:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17'),
(71, 46, '12:00:00', '13:00:00', '2025-12-10 23:48:17', '2025-12-10 23:48:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_people`
--

CREATE TABLE `activity_people` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `activity_people`
--

INSERT INTO `activity_people` (`id`, `activity_id`, `name`, `updated_at`, `created_at`) VALUES
(2, 8, 'Gerardo', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(3, 8, 'Odalys', '2025-11-07 17:34:46', '2025-11-07 17:34:46'),
(4, 9, 'Mario', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(5, 9, 'Héctor', '2025-11-07 21:22:52', '2025-11-07 21:22:52'),
(22, 1, 'Gerardo 2', '2025-12-10 23:48:17', '2025-12-10 23:48:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistances`
--

CREATE TABLE `assistances` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistance_people`
--

CREATE TABLE `assistance_people` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `assistance_people`
--

INSERT INTO `assistance_people` (`id`, `user_id`, `person_id`, `status`, `updated_at`, `created_at`) VALUES
(1, 2, 1, 1, '2025-11-21 02:18:47', NULL),
(5, 2, 2, 0, '2025-11-28 01:58:34', NULL),
(6, 2, 3, 0, '2025-11-28 01:58:34', NULL),
(7, 2, 4, 0, '2025-11-21 02:40:42', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-academiademusica@gmail.com|127.0.0.1', 'i:1;', 1764953290),
('laravel-cache-academiademusica@gmail.com|127.0.0.1:timer', 'i:1764953290;', 1764953290);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `classes_activities`
--

CREATE TABLE `classes_activities` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `administrator_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `available_amount` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `goods`
--

INSERT INTO `goods` (`id`, `inventory_id`, `name`, `description`, `photo`, `available_amount`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Silla', 'Silla de plástico para la biblioteca', NULL, 0, '', '2026-01-16 00:41:20', NULL),
(2, 2, 'Piano', 'Tiene 88 teclas', NULL, 0, 'inactive', '2025-10-28 00:59:54', NULL),
(3, 2, 'Guitarra', 'Tiene 6 cuerdas', NULL, 1, '', NULL, NULL),
(4, 2, 'Mesa', 'No es solo un mueble; es un monumento doméstico, una extensión horizontal del hogar donde el tiempo parece condensarse. Es una imponente mesa de comedor, rectangular y de proporciones generosas, capaz de acoger sin esfuerzo a diez o doce comensales. Su ma', NULL, 1, '', NULL, NULL),
(5, 2, 'Mesa2', 'No es solo un mueble; es un monumento doméstico, una extensión horizontal del hogar donde el tiempo parece condensarse. Es una imponente mesa de comedor, rectangular y de proporciones generosas, capaz de acoger sin esfuerzo a diez o doce comensales. Su ma', NULL, 1, '', NULL, NULL),
(6, 2, 'Mesa3', 'No es solo un mueble; es un monumento doméstico, una extensión horizontal del hogar donde el tiempo parece condensarse. Es una imponente mesa de comedor, rectangular y de proporciones generosas, capaz de acoger sin esfuerzo a diez o doce comensales. Su ma', NULL, 1, '', NULL, NULL),
(7, 2, 'Mesa4', 'No es solo un mueble; es un monumento doméstico, una extensión horizontal del hogar donde el tiempo parece condensarse. Es una imponente mesa de comedor, rectangular y de proporciones generosas, capaz de acoger sin esfuerzo a diez o doce comensales. Su ma', NULL, 1, '', NULL, NULL),
(8, 2, 'Mesa5', 'No es solo un mueble; es un monumento doméstico, una extensión horizontal del hogar donde el tiempo parece condensarse. Es una imponente mesa de comedor, rectangular y de proporciones generosas, capaz de acoger sin esfuerzo a diez o doce comensales. Su ma', NULL, 1, '', NULL, NULL),
(13, 2, 'Cuatro', 'Tiene 4 cuerdas', NULL, 1, 'active', '2025-10-28 00:54:45', '2025-10-28 00:54:45'),
(17, 2, 'Cuatro', 'Tiene 4 cuerdas', NULL, 2, 'active', '2025-10-28 01:06:30', '2025-10-28 01:00:07'),
(18, 2, 'Arpa', 'Posee muchas cuerdas', NULL, 1, 'active', '2025-10-28 01:06:55', '2025-10-28 01:06:55'),
(20, 1, 'Puf Modular de Lana Tejida', 'Cómodo', NULL, 0, 'inactive', '2025-11-08 00:58:43', '2025-11-07 23:26:28'),
(21, 11, 'Guitarra', 'Tiene 6 cuerdas', NULL, 0, 'active', '2025-11-08 01:01:13', '2025-11-08 01:00:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `good__attributes`
--

CREATE TABLE `good__attributes` (
  `id` int(11) NOT NULL,
  `id_good` int(11) NOT NULL,
  `id_key` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `good__attributes`
--

INSERT INTO `good__attributes` (`id`, `id_good`, `id_key`, `value`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 'Rojo', NULL, NULL),
(2, 1, 2, '4', NULL, NULL),
(3, 9, 1, 'Rojo', '2025-10-26 04:07:33', '2025-10-26 04:07:33'),
(4, 10, 1, 'Rojo', '2025-10-26 04:08:50', '2025-10-26 04:08:50'),
(5, 11, 1, 'Rojo', '2025-10-26 04:09:16', '2025-10-26 04:09:16'),
(7, 20, 1, 'Marrón', '2025-11-07 23:26:28', '2025-11-07 23:26:28'),
(8, 21, 5, '6', '2025-11-08 01:00:59', '2025-11-08 01:00:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

CREATE TABLE `inventories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventories`
--

INSERT INTO `inventories` (`id`, `user_id`, `name`, `updated_at`, `created_at`) VALUES
(1, 2, 'Casa de la Cultura', '2025-10-31 23:48:11', NULL),
(2, 2, 'Academia', NULL, NULL),
(10, 2, 'Inventario', '2025-11-01 02:11:47', '2025-11-01 02:11:47'),
(11, 2, 'Cuerdas', '2025-11-08 01:20:45', '2025-11-08 01:00:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_attributes`
--

CREATE TABLE `inventory_attributes` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `key_name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventory_attributes`
--

INSERT INTO `inventory_attributes` (`id`, `inventory_id`, `key_name`, `updated_at`, `created_at`) VALUES
(1, 1, 'Color', NULL, NULL),
(3, 10, 'Código', '2025-11-01 02:11:47', '2025-11-01 02:11:47'),
(4, 10, 'Color', '2025-11-01 02:11:47', '2025-11-01 02:11:47'),
(5, 11, 'Cuerdas', '2025-11-08 01:00:36', '2025-11-08 01:00:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `loan_date` date NOT NULL,
  `retrieval_date` date NOT NULL,
  `quantity_requested` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'given',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `loans`
--

INSERT INTO `loans` (`id`, `good_id`, `person_id`, `user_id`, `loan_date`, `retrieval_date`, `quantity_requested`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 2, '2026-01-16', '2026-01-23', 1, 'returned', '2026-01-16 00:41:20', '2026-01-15 21:12:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movements`
--

CREATE TABLE `movements` (
  `id` int(11) NOT NULL,
  `good_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movements`
--

INSERT INTO `movements` (`id`, `good_id`, `inventory_id`, `user_id`, `quantity`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, 'deposit', '2025-10-24 23:49:33', '2025-10-24 23:49:33'),
(2, 2, 2, 2, 1, 'deposit', '2025-10-24 23:51:07', '2025-10-24 23:51:07'),
(3, 2, 2, 2, 1, 'deposit', '2025-10-24 23:54:15', '2025-10-24 23:54:15'),
(4, 2, 2, 2, 1, 'deposit', '2025-10-25 01:21:59', '2025-10-25 01:21:59'),
(5, 2, 2, 2, 1, 'retire', '2025-10-25 01:28:50', '2025-10-25 01:28:50'),
(6, 2, 2, 2, 1, 'retire', '2025-10-25 01:29:04', '2025-10-25 01:29:04'),
(7, 2, 2, 2, 1, 'retire', '2025-10-25 01:29:20', '2025-10-25 01:29:20'),
(8, 2, 2, 2, 2, 'deposit', '2025-10-25 01:29:50', '2025-10-25 01:29:50'),
(9, 2, 2, 2, 1, 'deposit', '2025-10-25 01:31:39', '2025-10-25 01:31:39'),
(10, 2, 2, 2, 1, 'deposit', '2025-10-25 01:31:43', '2025-10-25 01:31:43'),
(11, 2, 2, 2, 3, 'retire', '2025-10-25 01:31:48', '2025-10-25 01:31:48'),
(12, 2, 2, 2, 1, 'deposit', '2025-10-25 01:35:55', '2025-10-25 01:35:55'),
(13, 2, 2, 2, 1, 'deposit', '2025-10-25 01:36:07', '2025-10-25 01:36:07'),
(14, 2, 2, 2, 1, 'retire', '2025-10-25 01:36:11', '2025-10-25 01:36:11'),
(15, 1, 1, 2, 2, 'deposit', '2025-10-25 01:39:22', '2025-10-25 01:39:22'),
(16, 1, 1, 2, 1, 'deposit', '2025-10-25 01:39:37', '2025-10-25 01:39:37'),
(17, 2, 2, 2, 1, 'deposit', '2025-10-25 03:07:27', '2025-10-25 03:07:27'),
(18, 2, 2, 2, 1, 'retire', '2025-10-25 03:07:32', '2025-10-25 03:07:32'),
(19, 2, 2, 2, 1, 'retire', '2025-10-28 00:48:56', '2025-10-28 00:48:56'),
(20, 2, 2, 2, 1, 'deposit', '2025-10-28 00:49:04', '2025-10-28 00:49:04'),
(21, 2, 2, 2, 1, 'retire', '2025-10-28 00:53:29', '2025-10-28 00:53:29'),
(22, 2, 2, 2, 1, 'deposit', '2025-10-28 00:53:43', '2025-10-28 00:53:43'),
(23, 2, 2, 2, 1, 'deposit', '2025-10-28 00:53:44', '2025-10-28 00:53:44'),
(24, 2, 2, 2, 1, 'deposit', '2025-10-28 00:53:44', '2025-10-28 00:53:44'),
(25, 2, 2, 2, 3, 'retire', '2025-10-28 00:54:22', '2025-10-28 00:54:22'),
(26, 2, 2, 2, 1, 'deposit', '2025-10-28 00:54:29', '2025-10-28 00:54:29'),
(27, 2, 2, 2, 1, 'deposit', '2025-10-28 00:59:47', '2025-10-28 00:59:47'),
(28, 2, 2, 2, 2, 'retire', '2025-10-28 00:59:54', '2025-10-28 00:59:54'),
(29, 17, 2, 2, 1, 'retire', '2025-10-28 01:06:27', '2025-10-28 01:06:27'),
(30, 17, 2, 2, 2, 'deposit', '2025-10-28 01:06:30', '2025-10-28 01:06:30'),
(31, 20, 1, 2, 1, 'retire', '2025-11-07 23:26:47', '2025-11-07 23:26:47'),
(32, 1, 1, 2, 2, 'retire', '2025-11-07 23:29:53', '2025-11-07 23:29:53'),
(33, 21, 11, 2, 4, 'deposit', '2025-11-08 01:01:09', '2025-11-08 01:01:09'),
(34, 21, 11, 2, 5, 'retire', '2025-11-08 01:01:13', '2025-11-08 01:01:13'),
(35, 1, 1, 2, 0, 'deposit', '2026-01-16 00:39:16', '2026-01-16 00:39:16'),
(36, 1, 1, 2, 1, 'retire', '2026-01-16 00:41:15', '2026-01-16 00:41:15'),
(37, 1, 1, 2, 1, 'deposit', '2026-01-16 00:41:20', '2026-01-16 00:41:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `sex` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `position_id`, `name`, `lastname`, `dni`, `sex`, `image`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gerardo', 'Hernandez', '13193476', 'Masculino', NULL, '0424-4195956', 'active', NULL, '2025-11-15 03:26:27'),
(2, 2, 'Elizabeth', 'Rossell', '15946171', 'Femenino', NULL, '0412-4716489', 'active', NULL, '2025-11-15 03:13:02'),
(3, 1, 'Ernesto', 'Pérez', '21471348', 'Masculino', 'persons/m8zHiUKSwIy9BdZtGYs9XHPrI9GePYAXIRoknLX5.png', '0412-4455411', 'active', '2025-11-14 01:26:05', '2025-11-21 02:21:22'),
(4, 1, 'Lucas', 'Pérez', '15174613', 'Masculino', NULL, '0416-4641471', 'active', '2025-11-15 03:27:19', '2025-11-21 02:41:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `positions`
--

INSERT INTO `positions` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1, 'Coordinador', NULL, NULL),
(2, 'Directora', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LBcXsaUGsscklH1hyCIAzs1wipKQD2gwruxiC81h', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMEN1ZWpJbjEzTEJBNEhjUjE4TmxkUjJmb3R3NXJCWFZ4TGZ1NmUxYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768509744),
('zcr4HHmdgkqwqR5hNGT9wDDRmpp1N0hhsj4u387G', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVcyR1NGa3dNMmV0OHkzbGlDRzJIRVRBYWh1clI1cFRRTzJLTzFMZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9jYXNhZGVsYWN1bHR1cmEuc2lzdGVtYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768583270);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `next_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Gerardo', 'academiademusicacfmc@gmail.com', NULL, '$2y$12$9/JtLokM8LvXQW.FT.0oHuzhQvHLax4DJSdWJhXUhJtKjIm7lGcQi', 1, NULL, '2025-10-18 00:25:09', '2025-10-18 00:25:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `activity_dates`
--
ALTER TABLE `activity_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indices de la tabla `activity_goods`
--
ALTER TABLE `activity_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `good_id` (`good_id`);

--
-- Indices de la tabla `activity_hours`
--
ALTER TABLE `activity_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_id` (`date_id`);

--
-- Indices de la tabla `activity_people`
--
ALTER TABLE `activity_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`name`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indices de la tabla `assistances`
--
ALTER TABLE `assistances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `assistance_people`
--
ALTER TABLE `assistance_people`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discipline_id` (`discipline_id`);

--
-- Indices de la tabla `classes_activities`
--
ALTER TABLE `classes_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indices de la tabla `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrator_id` (`administrator_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indices de la tabla `good__attributes`
--
ALTER TABLE `good__attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventory_attributes`
--
ALTER TABLE `inventory_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `activity_dates`
--
ALTER TABLE `activity_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `activity_goods`
--
ALTER TABLE `activity_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `activity_hours`
--
ALTER TABLE `activity_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `activity_people`
--
ALTER TABLE `activity_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `assistances`
--
ALTER TABLE `assistances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `assistance_people`
--
ALTER TABLE `assistance_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `classes_activities`
--
ALTER TABLE `classes_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `good__attributes`
--
ALTER TABLE `good__attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `inventory_attributes`
--
ALTER TABLE `inventory_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activity_dates`
--
ALTER TABLE `activity_dates`
  ADD CONSTRAINT `activity_dates_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);

--
-- Filtros para la tabla `activity_goods`
--
ALTER TABLE `activity_goods`
  ADD CONSTRAINT `activity_goods_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `activity_goods_ibfk_2` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`);

--
-- Filtros para la tabla `activity_hours`
--
ALTER TABLE `activity_hours`
  ADD CONSTRAINT `activity_hours_ibfk_1` FOREIGN KEY (`date_id`) REFERENCES `activity_dates` (`id`);

--
-- Filtros para la tabla `activity_people`
--
ALTER TABLE `activity_people`
  ADD CONSTRAINT `activity_people_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);

--
-- Filtros para la tabla `assistances`
--
ALTER TABLE `assistances`
  ADD CONSTRAINT `assistances_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `assistances_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Filtros para la tabla `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`);

--
-- Filtros para la tabla `classes_activities`
--
ALTER TABLE `classes_activities`
  ADD CONSTRAINT `classes_activities_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `classes_activities_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`);

--
-- Filtros para la tabla `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `disciplines_ibfk_1` FOREIGN KEY (`administrator_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`);

--
-- Filtros para la tabla `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`),
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `loans_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `movements_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`),
  ADD CONSTRAINT `movements_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `movements_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `roles_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `roles_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
