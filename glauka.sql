-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-08-2026 a las 01:42:21
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
-- Base de datos: `glauka`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adaptations`
--

CREATE TABLE `adaptations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `adaptations`
--

INSERT INTO `adaptations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Auditiva', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(2, 'Móvil', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(3, 'Visual', '2026-08-02 07:01:44', '2026-08-02 07:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adaptation_obra`
--

CREATE TABLE `adaptation_obra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adaptation_id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `adaptation_obra`
--

INSERT INTO `adaptation_obra` (`id`, `adaptation_id`, `obra_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `productor_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `announcements`
--

INSERT INTO `announcements` (`id`, `productor_id`, `title`, `content`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Casting abierto para nueva obra', 'Estamos buscando actores y actrices para una nueva producción. Los interesados pueden venir al teatro Colón el dia 10 de agosto a las 15hs.', '2026-09-01 04:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(2, 1, 'Encuentro de grupos teatrales', 'El próximo sábado realizaremos una reunión abierta para productores y elencos independientes. Nos encontraremos en plaza de Mayo este Lunes, de 9 a 15hs.', '2026-08-17 04:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `performance_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `emails_virtuales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emails_virtuales`)),
  `stock_alert_sent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `genres`
--

INSERT INTO `genres` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Drama', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(2, 'Comedia', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(3, 'Tragedia', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(4, 'Musical', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(5, 'Ópera', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(6, 'Suspenso', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(7, 'Monólogo', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(8, 'Tragicomedia', '2026-08-02 07:01:44', '2026-08-02 07:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genre_obra`
--

CREATE TABLE `genre_obra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `genre_obra`
--

INSERT INTO `genre_obra` (`id`, `genre_id`, `obra_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 4, 1, NULL, NULL),
(4, 1, 2, NULL, NULL),
(5, 4, 2, NULL, NULL),
(6, 4, 3, NULL, NULL),
(7, 7, 3, NULL, NULL),
(8, 1, 4, NULL, NULL),
(9, 2, 4, NULL, NULL);

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
-- Estructura de tabla para la tabla `labels`
--

CREATE TABLE `labels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `labels`
--

INSERT INTO `labels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Actor/actriz', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(2, 'Director', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(3, 'Maquillista', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(4, 'Vestuarista', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(5, 'Sonidista', '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(6, 'Escenógrafo', '2026-08-02 07:01:44', '2026-08-02 07:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `label_user`
--

CREATE TABLE `label_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `label_user`
--

INSERT INTO `label_user` (`id`, `user_id`, `label_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL),
(2, 3, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_production`
--

CREATE TABLE `members_production` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `label_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `members_production`
--

INSERT INTO `members_production` (`id`, `obra_id`, `label_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Julia Tozzi', '2026-08-02 07:01:45', '2026-08-02 07:01:45'),
(2, 1, 1, 'Nico Di Pace', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(3, 1, 1, 'Sofía Morandi', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(4, 1, 1, 'Flor Anca', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(5, 1, 1, 'Martu Loyato', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(6, 1, 1, 'Rocío Caldes', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(7, 1, 2, 'Fer Dente', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(8, 1, 4, 'Caro Mandri', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(9, 1, 6, 'Gonzalo Córdoba Estévez', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(10, 2, 1, 'Jorge Rivera-Herrans', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(11, 2, 1, 'Teagan Earley', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(12, 2, 1, 'Armando Julián', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(13, 2, 1, 'Steven Dookie', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(14, 2, 2, 'Jorge Rivera-Herrans', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(15, 2, 5, 'Jorge Rivera-Herrans', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(16, 2, 5, 'J.P. Warner', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(17, 3, 1, 'Barby Goity', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(18, 3, 1, 'Silvia Cerva', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(19, 3, 1, 'Gaby Zabala', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(20, 3, 2, 'Daniela Gonzáles', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(21, 3, 5, 'Daniela Gonzáles', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(22, 3, 6, 'Gaby Zabala', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(23, 4, 1, 'Mariela Acosta', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(24, 4, 1, 'Toto Castiñeiras', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(25, 4, 1, 'Santiago Garcia Ibañez', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(26, 4, 1, 'Julia Gárriz', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(27, 4, 1, 'Julieta Laso', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(28, 4, 1, 'Mariano Torre', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(29, 4, 2, 'Toto Castiñeiras', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(30, 4, 3, 'Sofía Orsi', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(31, 4, 4, 'Daniela Taiana', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(32, 4, 5, 'Sofía Orsi', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(33, 4, 6, 'Alejandro Le Roux', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(34, 4, 6, 'Lucio Mantel', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(35, 4, 6, 'Romina Salerno', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(36, 4, 6, 'Sofía Orsi', '2026-08-02 07:01:46', '2026-08-02 07:01:46');

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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_26_062655_add_rol_uss_table', 1),
(5, '2025_10_26_063433_create_genres_table', 1),
(6, '2025_10_26_064126_create_productores_table', 1),
(7, '2025_11_02_213453_create_obras_table', 1),
(8, '2025_11_14_052025_create_tickets_table', 1),
(9, '2025_11_14_052250_create_performances_table', 1),
(10, '2025_11_14_052256_create_ticket_detalles_table', 1),
(11, '2026_02_27_184912_create_genre_obra_table', 1),
(12, '2026_03_12_054658_create_carts_table', 1),
(13, '2026_03_12_063747_create_cart_items_table', 1),
(14, '2026_05_17_204833_create_labels_table', 1),
(15, '2026_05_17_204901_create_label_user_table', 1),
(16, '2026_05_28_205200_create_productor_statistics_table', 1),
(17, '2026_06_09_205918_create_adaptations_table', 1),
(18, '2026_06_09_210017_create_adaptation_obra_table', 1),
(19, '2026_06_10_123526_create_announcements_table', 1),
(20, '2026_06_11_111540_create_ticket_entries_table', 1),
(21, '2026_06_23_230320_create_plans_table', 1),
(22, '2026_06_23_231206_add_plan_id_to_users_table', 1),
(23, '2026_06_25_213556_create_subscriptions_table', 1),
(24, '2026_06_30_010254_favorites', 1),
(25, '2026_07_05_224951_create_subscription_payments_table', 1),
(26, '2026_07_19_123233_create_members_production', 1),
(27, '2026_08_02_022233_create_refunds_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras`
--

CREATE TABLE `obras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `productor_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_obra` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `clasificacion` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `solo_compartido` tinyint(1) NOT NULL DEFAULT 0,
  `cancelado` tinyint(1) NOT NULL DEFAULT 0,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `obras`
--

INSERT INTO `obras` (`id`, `productor_id`, `nombre_obra`, `autor`, `clasificacion`, `precio`, `ubicacion`, `imagen`, `sinopsis`, `slug`, `solo_compartido`, `cancelado`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Heathers, el musical', 'Laurence O Keefe y Kevin Murphy', 'adultos', 3000.00, 'Teatro Colón', 'ShZPrhKfC7kG196e4E3WjIIfEgWMtkDF5pU3WyPn.jpg', '“Heathers: The Musical” es una comedia oscura ambientada en una escuela secundaria de los años 80. La historia sigue a Veronica Sawyer, una chica inteligente pero impopular que logra entrar al grupo más popular del colegio: las Heathers, tres chicas ricas y crueles que dominan la escuela.\n      Aunque al principio Veronica disfruta de su nueva popularidad, pronto se siente incómoda con la maldad del grupo. Entonces conoce a J.D. (Jason Dean), un chico misterioso y rebelde que desprecia el sistema escolar y la hipocresía de la sociedad.\n      Lo que empieza como una historia de amor adolescente se vuelve oscuro cuando J.D. lleva su rebeldía demasiado lejos: los dos terminan involucrados en una serie de “muertes accidentales” de estudiantes tóxicos, mientras Veronica lucha por detenerlo y recuperar el control.', 'Heathers-el-musical', 0, 0, 0, '2026-08-02 07:01:45', '2026-08-02 07:01:45'),
(2, 1, 'Epic: El Musical', 'Jorge Rivera-Herrans', 'todo publico', 2500.00, 'AJO, Calle 47 395 Centro, B1900 La Plata, Provincia de Buenos Aires', 'HIRV336VJqnDesWGDgfxI4pPtCccsyleACtk7zzC.jpg', 'Es un musical inspirado en La Odisea de Homero, que narra el épico viaje de regreso de Odiseo a Ítaca después de la Guerra de Troya. La historia se cuenta completamente a través de canciones, divididas en nueve sagas que funcionan como capítulos. A lo largo de su travesía, Odiseo enfrenta numerosos desafíos, dioses y monstruos.', 'Epic:El-Musical', 0, 0, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(3, 1, 'Encantadores', 'Daniela González', 'infantil', 3000.00, 'Teatro Colón', '7mf28dwmmAnJDNCLj8iGsellpiq2JOwIRZNwqz5m.jpg', 'Encantadores es una propuesta interactiva para bebes en Buenos Aires especialmente diseñada para niños de 0 a 3 años inclusive.\n      Un recorrido musical que los convoca a explorar, descubrir y experimentar creando un espacio de ilusión donde todo es posible.\n      A través de canciones, imágenes, colores y formas se van creando y recreando las diferentes escenas. Dentro de este marco bebés y adultos se ven implicados en una aventura ficcional. El compartir los pone en acción y les permite conectarse con los aspectos más puros de la infancia: las emociones, las acciones, la imaginación y la simbolización.\n      La obra y todo su proceso creativo han sido acompañados y asesorados por un equipo de profesionales relacionados a las ciencias de educación y psicopedagogía procurando de esta forma una propuesta artística acorde y respetuosa en relación a nuestros destinatarios.', 'Encantadores', 0, 0, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(4, 1, 'Ojo de Pombero', 'Toto Castiñeiras', 'adultos', 4000.00, 'Teatro Auditorium Centro Provincial de las Artes', 'pB6P1N8o9dRuHnGeicNRzHlELLqHeSXWxM36xrs6.jpg', '\"Pombero, agazapado en la mirada del Diablo, espera la noche del carnaval para bajar el monte y molestar a las muchachas. Esta vez, la Juana, lazo en mano, parece dispuesta a cazarlo. Lo que resta es venganza.', 'Ojo de Pombero', 0, 0, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46');

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
-- Estructura de tabla para la tabla `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `fechaObra` date NOT NULL,
  `horaObra` time NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `linkVirtual` varchar(255) DEFAULT NULL,
  `estado_pago` enum('pendiente','realizado') NOT NULL DEFAULT 'pendiente',
  `visible_admin` tinyint(1) NOT NULL DEFAULT 1,
  `cancelado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `performances`
--

INSERT INTO `performances` (`id`, `obra_id`, `fechaObra`, `horaObra`, `stock`, `linkVirtual`, `estado_pago`, `visible_admin`, `cancelado`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-11-19', '20:00:00', 20, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(2, 1, '2026-11-21', '20:00:00', 30, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(3, 2, '2026-11-23', '18:00:00', 25, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(4, 2, '2026-11-24', '14:00:00', 25, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 08:07:34'),
(5, 2, '2026-11-25', '20:00:00', 25, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(6, 3, '2026-02-28', '17:00:00', 40, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(7, 4, '2026-03-05', '19:00:00', 70, NULL, 'pendiente', 1, 0, '2026-08-02 07:01:46', '2026-08-02 07:01:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plans`
--

INSERT INTO `plans` (`id`, `nombre`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(2, 'Basic', NULL, '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(3, 'Premium user', 50.00, '2026-08-02 07:01:44', '2026-08-02 07:01:44'),
(4, 'Premium producer', 100.00, '2026-08-02 07:01:44', '2026-08-02 07:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productores`
--

CREATE TABLE `productores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name_group` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `account_holder` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `genre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productores`
--

INSERT INTO `productores` (`id`, `user_id`, `name_group`, `alias`, `account_holder`, `description`, `genre_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'Lara Florian', 'Colooo', 'florian', 'Productora de teatro independiente con más de 10 años de experiencia en la industria.', 4, '2026-08-02 07:01:45', '2026-08-02 07:41:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productor_statistics`
--

CREATE TABLE `productor_statistics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `total_revenue` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tickets` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productor_statistics`
--

INSERT INTO `productor_statistics` (`id`, `user_id`, `year`, `month`, `total_revenue`, `total_tickets`, `created_at`, `updated_at`) VALUES
(1, 2, 2025, 11, 120000.00, 340, '2026-08-02 07:01:45', '2026-08-02 07:01:45'),
(2, 2, 2025, 12, 185000.00, 510, '2026-08-02 07:01:45', '2026-08-02 07:01:45'),
(3, 2, 2026, 1, 210000.00, 620, '2026-08-02 07:01:45', '2026-08-02 07:01:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `performance_id` bigint(20) UNSIGNED DEFAULT NULL,
  `obra_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` varchar(255) NOT NULL,
  `refund_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('rSvwMgJMfJs4UZP0nJvXdNxKmGF5WyPhXXMQ2xq1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHBPWjRlcjAxMDZDaFNuc0swSDZnaGFUZ0pjRmR1dFRnZWtpb0RiQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYWdvcy1wcm9kdWN0b3JlcyI7czo1OiJyb3V0ZSI7czoyMjoiYWRtaW4ucHJvZHVjZXItcGF5bWVudCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1785658054);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `starts_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan_id`, `payment_id`, `starts_at`, `expires_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'MP000001', '2026-03-02 04:01:46', '2026-09-02 04:01:46', 'active', '2026-08-02 07:01:46', '2026-08-02 07:01:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscription_payments`
--

CREATE TABLE `subscription_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subscription_payments`
--

INSERT INTO `subscription_payments` (`id`, `subscription_id`, `payment_id`, `amount`, `payment_method`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'MP100001', 100.00, 'Mercado Pago', 'approved', '2026-03-02 07:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(2, 1, 'MP100002', 100.00, 'Mercado Pago', 'approved', '2026-04-02 07:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(3, 1, 'MP100003', 100.00, 'Mercado Pago', 'approved', '2026-05-02 07:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(4, 1, 'MP100004', 100.00, 'Mercado Pago', 'approved', '2026-06-02 07:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46'),
(5, 1, 'MP100005', 100.00, 'Mercado Pago', 'approved', '2026-07-02 07:01:46', '2026-08-02 07:01:46', '2026-08-02 07:01:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketdetalles`
--

CREATE TABLE `ticketdetalles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `obra_id` bigint(20) UNSIGNED NOT NULL,
  `performance_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_obra` varchar(255) NOT NULL,
  `es_virtual` tinyint(1) NOT NULL DEFAULT 0,
  `nombre_productor` varchar(255) NOT NULL,
  `fecha_hora_obra` datetime NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `emails_virtuales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emails_virtuales`)),
  `precio_u` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `datos_usuario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_usuario`)),
  `estado_pago` varchar(255) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `preference_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_entries`
--

CREATE TABLE `ticket_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticketdetalles_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `checked_at` timestamp NULL DEFAULT NULL,
  `checked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `nicknameUser` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `userIcon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol` varchar(255) NOT NULL DEFAULT 'user',
  `plan_id` bigint(20) UNSIGNED DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `nicknameUser`, `email`, `email_verified_at`, `userIcon`, `description`, `password`, `remember_token`, `created_at`, `updated_at`, `rol`, `plan_id`) VALUES
(1, 'Admin', NULL, 'universoglauka@gmail.com', NULL, 'GlaukaIcon.png', NULL, '$2y$12$C1TGoKVUcKu3BZcmfvup6e89EuOO0tvXtD20GYqEtNam5.FkOIeS.', NULL, '2026-08-02 07:01:45', '2026-08-02 07:01:45', 'admin', 1),
(2, 'Lara', NULL, 'laraflorian@gmail.com', NULL, 'icon2.jpg', NULL, '$2y$12$EuEH64RAPCzzoibgi.sJ8e8ufvfVvlO2.3m7ZgzD8EaVk./9AeYOa', NULL, '2026-08-02 07:01:45', '2026-08-02 07:01:45', 'producer', 4),
(3, 'May', 'May', 'may@gmail.com', NULL, 'icon1.jpg', NULL, '$2y$12$7Go7RXBbxiOU0t7f/1m4New43zMX7pG45bHOrGFtltAhEGFEfKaq6', NULL, '2026-08-02 07:01:45', '2026-08-02 07:01:45', 'user', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adaptations`
--
ALTER TABLE `adaptations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adaptations_name_unique` (`name`);

--
-- Indices de la tabla `adaptation_obra`
--
ALTER TABLE `adaptation_obra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adaptation_obra_adaptation_id_foreign` (`adaptation_id`),
  ADD KEY `adaptation_obra_obra_id_foreign` (`obra_id`);

--
-- Indices de la tabla `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_productor_id_foreign` (`productor_id`);

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
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_obra_id_foreign` (`obra_id`),
  ADD KEY `cart_items_performance_id_foreign` (`performance_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_obra_id_unique` (`user_id`,`obra_id`),
  ADD KEY `favorites_obra_id_foreign` (`obra_id`);

--
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genres_name_unique` (`name`);

--
-- Indices de la tabla `genre_obra`
--
ALTER TABLE `genre_obra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_obra_genre_id_foreign` (`genre_id`),
  ADD KEY `genre_obra_obra_id_foreign` (`obra_id`);

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
-- Indices de la tabla `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labels_name_unique` (`name`);

--
-- Indices de la tabla `label_user`
--
ALTER TABLE `label_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `label_user_user_id_foreign` (`user_id`),
  ADD KEY `label_user_label_id_foreign` (`label_id`);

--
-- Indices de la tabla `members_production`
--
ALTER TABLE `members_production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_production_obra_id_foreign` (`obra_id`),
  ADD KEY `members_production_label_id_foreign` (`label_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `obras`
--
ALTER TABLE `obras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `obras_slug_unique` (`slug`),
  ADD KEY `obras_productor_id_foreign` (`productor_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performances_obra_id_foreign` (`obra_id`);

--
-- Indices de la tabla `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productores`
--
ALTER TABLE `productores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productores_user_id_foreign` (`user_id`),
  ADD KEY `productores_genre_id_foreign` (`genre_id`);

--
-- Indices de la tabla `productor_statistics`
--
ALTER TABLE `productor_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productor_statistics_user_id_year_month_unique` (`user_id`,`year`,`month`);

--
-- Indices de la tabla `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refunds_ticket_id_foreign` (`ticket_id`),
  ADD KEY `refunds_performance_id_foreign` (`performance_id`),
  ADD KEY `refunds_obra_id_foreign` (`obra_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indices de la tabla `subscription_payments`
--
ALTER TABLE `subscription_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_payments_subscription_id_foreign` (`subscription_id`);

--
-- Indices de la tabla `ticketdetalles`
--
ALTER TABLE `ticketdetalles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticketdetalles_codigo_unique` (`codigo`),
  ADD KEY `ticketdetalles_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticketdetalles_obra_id_foreign` (`obra_id`),
  ADD KEY `ticketdetalles_performance_id_foreign` (`performance_id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_payment_id_unique` (`payment_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `ticket_entries`
--
ALTER TABLE `ticket_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_entries_codigo_unique` (`codigo`),
  ADD KEY `ticket_entries_ticketdetalles_id_foreign` (`ticketdetalles_id`),
  ADD KEY `ticket_entries_checked_by_foreign` (`checked_by`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nicknameuser_unique` (`nicknameUser`),
  ADD KEY `users_plan_id_foreign` (`plan_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adaptations`
--
ALTER TABLE `adaptations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `adaptation_obra`
--
ALTER TABLE `adaptation_obra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `genre_obra`
--
ALTER TABLE `genre_obra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `labels`
--
ALTER TABLE `labels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `label_user`
--
ALTER TABLE `label_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `members_production`
--
ALTER TABLE `members_production`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `obras`
--
ALTER TABLE `obras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productores`
--
ALTER TABLE `productores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productor_statistics`
--
ALTER TABLE `productor_statistics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subscription_payments`
--
ALTER TABLE `subscription_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ticketdetalles`
--
ALTER TABLE `ticketdetalles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_entries`
--
ALTER TABLE `ticket_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adaptation_obra`
--
ALTER TABLE `adaptation_obra`
  ADD CONSTRAINT `adaptation_obra_adaptation_id_foreign` FOREIGN KEY (`adaptation_id`) REFERENCES `adaptations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adaptation_obra_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_productor_id_foreign` FOREIGN KEY (`productor_id`) REFERENCES `productores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_performance_id_foreign` FOREIGN KEY (`performance_id`) REFERENCES `performances` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `genre_obra`
--
ALTER TABLE `genre_obra`
  ADD CONSTRAINT `genre_obra_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `genre_obra_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `label_user`
--
ALTER TABLE `label_user`
  ADD CONSTRAINT `label_user_label_id_foreign` FOREIGN KEY (`label_id`) REFERENCES `labels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `label_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `members_production`
--
ALTER TABLE `members_production`
  ADD CONSTRAINT `members_production_label_id_foreign` FOREIGN KEY (`label_id`) REFERENCES `labels` (`id`),
  ADD CONSTRAINT `members_production_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `obras`
--
ALTER TABLE `obras`
  ADD CONSTRAINT `obras_productor_id_foreign` FOREIGN KEY (`productor_id`) REFERENCES `productores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `performances`
--
ALTER TABLE `performances`
  ADD CONSTRAINT `performances_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productores`
--
ALTER TABLE `productores`
  ADD CONSTRAINT `productores_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productor_statistics`
--
ALTER TABLE `productor_statistics`
  ADD CONSTRAINT `productor_statistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `refunds_performance_id_foreign` FOREIGN KEY (`performance_id`) REFERENCES `performances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `refunds_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subscription_payments`
--
ALTER TABLE `subscription_payments`
  ADD CONSTRAINT `subscription_payments_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticketdetalles`
--
ALTER TABLE `ticketdetalles`
  ADD CONSTRAINT `ticketdetalles_obra_id_foreign` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticketdetalles_performance_id_foreign` FOREIGN KEY (`performance_id`) REFERENCES `performances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticketdetalles_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_entries`
--
ALTER TABLE `ticket_entries`
  ADD CONSTRAINT `ticket_entries_checked_by_foreign` FOREIGN KEY (`checked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_entries_ticketdetalles_id_foreign` FOREIGN KEY (`ticketdetalles_id`) REFERENCES `ticketdetalles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
