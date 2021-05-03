-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para laravel
CREATE DATABASE IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `laravel`;

-- Volcando estructura para tabla laravel.bitacora
CREATE TABLE IF NOT EXISTS `bitacora` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` smallint(5) unsigned NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tipoAccion` enum('Login','Editar','Eliminar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabla` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.bitacora: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
REPLACE INTO `bitacora` (`id`, `idUsuario`, `ip`, `tipoAccion`, `descripcion`, `tabla`, `created_at`, `updated_at`) VALUES
	(1, 3, '127.0.0.1', 'Login', '{"Acción":"Inicio de sesión","Nick":"juanAdmin"}', 'users', '2021-05-03 16:52:07', '2021-05-03 16:52:07'),
	(2, 4, '127.0.0.1', 'Login', '{"Acción":"Inicio de sesión","Nick":"juanBasico"}', 'users', '2021-05-03 16:53:21', '2021-05-03 16:53:21'),
	(3, 3, '127.0.0.1', 'Login', '{"Acción":"Inicio de sesión","Nick":"juanAdmin"}', 'users', '2021-05-03 16:53:33', '2021-05-03 16:53:33'),
	(4, 3, '127.0.0.1', 'Login', '{"Acción":"Inicio de sesión","Nick":"juanAdmin"}', 'users', '2021-05-03 17:15:24', '2021-05-03 17:15:24');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;

-- Volcando estructura para tabla laravel.costos
CREATE TABLE IF NOT EXISTS `costos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.costos: ~25 rows (aproximadamente)
/*!40000 ALTER TABLE `costos` DISABLE KEYS */;
REPLACE INTO `costos` (`id`, `descripcion`, `costo`, `fecha`, `bloqueado`, `eliminado`, `created_at`, `updated_at`) VALUES
	(1, 'Enim nulla itaque temporibus rerum dolor rem. Quod excepturi voluptas et labore non non assumenda.', '72.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(2, 'Magnam et reprehenderit repellat est. Aut repellendus nesciunt alias.', '67.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(3, 'Nam totam autem voluptas velit enim. Dicta laboriosam esse optio dolores sapiente.', '22.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(4, 'Quibusdam deleniti voluptatibus ea minus. Ut ullam eaque fuga eligendi aut qui exercitationem.', '30.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(5, 'Ipsum sint tenetur accusantium consequatur. Quo dolorum ut tempore voluptatem enim dolorem labore.', '65.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(6, 'Iusto ullam a quas qui dolor. Ut iste est sapiente corporis. Nisi ab vitae et est sint non.', '80.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:55', '2021-05-03 16:48:55'),
	(7, 'Minima vel nostrum delectus. Ut iure voluptatum cum. Harum blanditiis aut cumque ut.', '15.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(8, 'Aut dolorem ut quia molestiae qui consequatur alias. Maiores dicta et rerum tempore maiores vero.', '99.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(9, 'Praesentium dignissimos alias repudiandae ut velit quasi. Velit expedita consequatur quasi qui.', '42.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(10, 'Et ipsum consequatur et qui consectetur. Veniam architecto quo dolor.', '93.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(11, 'Ab amet eum quibusdam quos rerum exercitationem. Eius eligendi beatae quod.', '91.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(12, 'Aut at corrupti dolores illum. Est sed sit et consequatur.', '20.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:56', '2021-05-03 16:48:56'),
	(13, 'Necessitatibus impedit ipsa est ut nobis voluptatibus ut. Est laboriosam nostrum saepe minima ipsa.', '37.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(14, 'Occaecati quos reprehenderit velit dolor. Eaque aut consectetur similique atque quibusdam id eum.', '39.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(15, 'Et dolores in expedita. Dolorem vel cum rerum ut. Sed ea ex repellendus.', '60.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(16, 'Quo repudiandae labore quas maiores qui sed. Occaecati ullam beatae pariatur et.', '36.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(17, 'Ut architecto qui quos earum. Praesentium error id saepe.', '12.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(18, 'Consequatur et enim exercitationem reiciendis. Corporis aut et praesentium.', '71.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:57', '2021-05-03 16:48:57'),
	(19, 'Hic omnis sed quo. Eveniet maiores aliquam et sit. A dolores assumenda vitae quis consequatur et.', '95.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(20, 'Omnis nisi est aperiam. Eum quibusdam veritatis eveniet adipisci quo aut veniam.', '67.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(21, 'Impedit itaque molestias atque quaerat. Dolore et enim explicabo repellat.', '52.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(22, 'Minus dolorem error non voluptas. Sit quos fugit dolore aliquam. Velit repudiandae quis commodi.', '82.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(23, 'Fugiat culpa quas aut eos nam autem. Veritatis sed omnis ea minima quis.', '28.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(24, 'Tenetur debitis fuga voluptatem quo. Dicta ut porro iusto.', '7.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:58', '2021-05-03 16:48:58'),
	(25, 'Doloribus expedita et impedit numquam sunt. Delectus accusamus atque ipsa dolorem.', '88.00', '2021-05-03 16:48:55', 0, 0, '2021-05-03 16:48:59', '2021-05-03 16:48:59');
/*!40000 ALTER TABLE `costos` ENABLE KEYS */;

-- Volcando estructura para tabla laravel.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla laravel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.migrations: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2021_04_18_230025_create_costos_table', 1),
	(5, '2021_05_02_170753_create_bitacora_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla laravel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla laravel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nick` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `rol` enum('ROL_BASICO','ROL_ADMINISTRADOR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('MASCULINO','FEMENINO','OTRO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nick_unique` (`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel.users: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `nick`, `email`, `password`, `bloqueado`, `eliminado`, `rol`, `genero`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Iván Saavedra', 'usuario19', 'izan.magana@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 0, 'ROL_BASICO', 'OTRO', 'aj7fl08N3A', '2021-05-03 16:48:54', '2021-05-03 16:48:54'),
	(2, 'Jon Valladares', 'usuario8Editado', 'laureano.rafael@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 0, 'ROL_BASICO', 'FEMENINO', '2tNLxvyijI', '2021-05-03 16:48:54', '2021-05-03 18:16:55'),
	(3, 'JuanMX', 'juanAdmin', 'juanadmin@mail.com', '$2y$10$OD4Hp80.5bmWBUF8JJc9ZO2mqynUTkwJRY8DHneI8w0txrTNrSefy', 0, 0, 'ROL_ADMINISTRADOR', 'MASCULINO', NULL, NULL, NULL),
	(4, 'JuanBasico', 'juanBasico', 'juanbasico@mail.com', '$2y$10$D3A4H7WvUGvIFnw2qA0XDO9j./mbGn1bRy7jPUGo98rWB6ISpKZMK', 0, 0, 'ROL_BASICO', 'MASCULINO', NULL, NULL, NULL),
	(5, '', 'juanUno', '', '$2y$10$xUACPly1ESnABdQg93/fbuAsqRUhqvv9nHYWOV6V0tSzhwJBY1Zoy', 0, 0, 'ROL_ADMINISTRADOR', 'OTRO', NULL, '2021-05-03 17:30:48', '2021-05-03 17:30:48'),
	(6, '', 'juanDos', '', '$2y$10$PmDcngTsWeQTKrRqLqfHAuvJ74/4TXBW17qX47vg8D2u5jZIw6B3S', 0, 0, 'ROL_BASICO', 'FEMENINO', NULL, '2021-05-03 17:31:08', '2021-05-03 17:31:08'),
	(7, '', 'juanTres', '', '$2y$10$Hfj9px8yUfH./OchOu5GNOEVZfVI6m.hOseUS78Dep.Lf7fvCOt4S', 0, 0, 'ROL_BASICO', 'MASCULINO', NULL, '2021-05-03 17:31:33', '2021-05-03 17:31:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
