-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         8.0.22 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla cake4_rbac.archivos
CREATE TABLE IF NOT EXISTS `archivos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `upload_id` int DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int unsigned DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `relacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_archivos_uploads` (`upload_id`),
  CONSTRAINT `FK_archivos_uploads` FOREIGN KEY (`upload_id`) REFERENCES `uploads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.archivos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.configuracion: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` (`id`, `clave`, `valor`) VALUES
	(1, 'Mostrar Captcha', 'No'),
	(2, 'Mostrar LDAP', 'Si');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.ejemplos
CREATE TABLE IF NOT EXISTS `ejemplos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.ejemplos: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `ejemplos` DISABLE KEYS */;
INSERT INTO `ejemplos` (`id`, `titulo`, `descripcion`, `created`, `modified`) VALUES
	(1, 'dfgfsdg', 'dfgsdfg dfsgdf sgdfg sdf', '2022-02-21 17:18:12', '2022-02-21 17:18:12'),
	(2, 'vhtrn juh', 'n jtytbesfbjftb', '2022-02-21 17:18:22', '2022-02-21 17:18:22'),
	(3, 'yturnu', 'fgvyasecresct', '2022-02-21 17:18:39', '2022-02-21 17:18:39'),
	(4, 'uyoto', 'dzgvrytrbytdr', '2022-02-21 17:18:47', '2022-02-21 17:18:47'),
	(5, 'asearewr', 'dsrtysrbtr', '2022-02-21 17:18:58', '2022-02-21 17:18:58'),
	(6, 'uittreb hjtr', 'rtrtsdf', '2022-02-21 17:19:06', '2022-02-21 17:19:06'),
	(7, 'aerewr', 'bndfytery', '2022-02-21 17:19:14', '2022-02-21 17:19:14'),
	(8, 'hntyubytrdyv', 'trdertxgwet', '2022-02-21 17:19:21', '2022-02-21 17:19:21'),
	(9, 'juiunytit', 'tvryecrey', '2022-02-21 17:19:29', '2022-02-21 17:19:29'),
	(10, 'jhktryut', 'bhjyt', '2022-02-21 17:19:40', '2022-02-21 17:19:40'),
	(11, 'tfrytrunhtdr', 'trvytryhtrb y jy', '2022-02-21 17:19:48', '2022-02-21 17:19:48'),
	(12, 'ertrebvnc', 'vbchfghewreiuyiy', '2022-02-21 17:19:58', '2022-02-21 17:19:58');
/*!40000 ALTER TABLE `ejemplos` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.permisos_virtual_hosts
CREATE TABLE IF NOT EXISTS `permisos_virtual_hosts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `permiso` varchar(250) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `activo` tinyint DEFAULT '0',
  `captcha` tinyint DEFAULT NULL,
  `contrasenia` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.permisos_virtual_hosts: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `permisos_virtual_hosts` DISABLE KEYS */;
INSERT INTO `permisos_virtual_hosts` (`id`, `permiso`, `url`, `activo`, `captcha`, `contrasenia`) VALUES
	(1, 'solo_lectura', '/home/index', 0, NULL, NULL),
	(2, 'carga_publica', '/home/index', 0, NULL, NULL),
	(3, 'carga_login_publica', '/home/index', 0, 1, 1),
	(4, 'carga_login_interna', NULL, 0, 1, 1),
	(5, 'carga_administracion', NULL, 1, 1, 1);
/*!40000 ALTER TABLE `permisos_virtual_hosts` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_acciones
CREATE TABLE IF NOT EXISTS `rbac_acciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `solo_lectura` int DEFAULT NULL,
  `carga_publica` int DEFAULT NULL,
  `carga_login_publica` int DEFAULT NULL,
  `carga_login_interna` int DEFAULT NULL,
  `carga_administracion` int DEFAULT NULL,
  `heredado` int DEFAULT NULL,
  `oculto` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_acciones: ~48 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
INSERT INTO `rbac_acciones` (`id`, `controller`, `action`, `solo_lectura`, `carga_publica`, `carga_login_publica`, `carga_login_interna`, `carga_administracion`, `heredado`, `oculto`) VALUES
	(1, 'RbacUsuarios', 'index', 0, 0, 0, 0, 1, 1, 0),
	(2, 'RbacUsuarios', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(3, 'RbacUsuarios', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(4, 'RbacUsuarios', 'eliminar', 0, 0, 0, 0, 1, 1, 0),
	(5, 'RbacUsuarios', 'autocompleteLdap', 0, 0, 0, 0, 1, 1, 1),
	(6, 'RbacUsuarios', 'validarLoginLdap', 0, 0, 0, 0, 1, 1, 1),
	(7, 'RbacUsuarios', 'validarLoginDB', 0, 0, 0, 0, 1, 1, 1),
	(8, 'RbacUsuarios', 'login', 1, 0, 1, 1, 1, 1, 1),
	(9, 'RbacUsuarios', 'changePass', 0, 0, 1, 1, 1, 1, 0),
	(10, 'RbacUsuarios', 'cambiarPerfil', 1, 1, 1, 1, 1, 1, 0),
	(11, 'RbacUsuarios', 'recuperar', 0, 0, 1, 1, 1, 1, 0),
	(12, 'RbacUsuarios', 'recuperarPass', 0, 1, 1, 1, 1, 1, 0),
	(13, 'RbacUsuarios', 'cambiarEntorno', 1, 1, 1, 1, 1, 1, 0),
	(14, 'RbacPerfiles', 'index', 0, 0, 0, 0, 1, 1, 0),
	(15, 'RbacPerfiles', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(16, 'RbacPerfiles', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(17, 'RbacPerfiles', 'eliminar', 0, 0, 0, 0, 1, 1, 0),
	(18, 'RbacPerfiles', 'getAccionesByVirtualHost', 0, 0, 0, 0, 1, 1, 0),
	(19, 'RbacAcciones', 'index', 0, 0, 0, 0, 1, 1, 0),
	(20, 'RbacAcciones', 'switchAccion', 0, 0, 0, 0, 1, 1, 0),
	(21, 'RbacAcciones', 'eliminar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(22, 'RbacAcciones', 'sincronizar', 0, 0, 0, 1, 1, 1, 0),
	(23, 'Configuraciones', 'index', 0, 0, 0, 0, 1, 1, 0),
	(24, 'Configuraciones', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(25, 'Configuraciones', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(26, 'RbacPermisos', 'index', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(27, 'RbacPermisos', 'agregar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(28, 'RbacPermisos', 'editar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(29, 'RbacPermisos', 'eliminar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(30, 'RbacPermisos', 'actualizarCaptcha', 0, 0, 0, 0, 1, 1, 1),
	(31, 'RbacPermisos', 'actualizarContrasenia', 0, 0, 0, 0, 1, 1, 1),
	(32, 'RbacPermisos', 'actualizarURL', 0, 0, 0, 0, 1, 1, 1),
	(33, 'Pages', '_null', 0, 0, 0, 0, 0, 0, 0),
	(34, 'Pages', 'display', 0, 1, 1, 1, 1, 0, 0),
	(35, 'Pages', 'ditic', 0, 1, 1, 1, 1, 0, 0),
	(36, 'Usuarios', 'agregar', 0, 0, 0, 1, 1, 0, 1),
	(37, 'Usuarios', 'editar', 0, 0, 0, 1, 1, 0, 1),
	(38, 'Usuarios', 'eliminar', 0, 0, 0, 1, 1, 0, 1),
	(39, 'Usuarios', 'changePass', 0, 0, 0, 1, 1, 0, 1),
	(40, 'Usuarios', '_null', NULL, NULL, NULL, 1, 1, NULL, 1),
	(41, 'Usuarios', 'index', NULL, NULL, NULL, 1, 1, NULL, 1),
	(42, 'Admin', '_null', NULL, NULL, NULL, 1, 1, NULL, 1),
	(43, 'Admin', 'index', NULL, NULL, NULL, 1, 1, NULL, 1),
	(44, 'Home', 'index', NULL, 1, 1, NULL, 1, NULL, 1),
	(45, 'Home', '_null', NULL, 1, NULL, NULL, 1, NULL, 1),
	(46, 'Ejemplos', '_null', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(47, 'Ejemplos', 'index', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(48, 'Ejemplos', 'ver', NULL, NULL, NULL, NULL, 1, NULL, 1);
/*!40000 ALTER TABLE `rbac_acciones` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_acciones_rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_acciones_rbac_perfiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rbac_accion_id` int NOT NULL,
  `rbac_perfil_id` int NOT NULL,
  PRIMARY KEY (`id`,`rbac_accion_id`,`rbac_perfil_id`),
  KEY `fk_ap_accion_idx` (`rbac_accion_id`),
  KEY `fk_ap_perfil_idx` (`rbac_perfil_id`),
  CONSTRAINT `fk_acion` FOREIGN KEY (`rbac_accion_id`) REFERENCES `rbac_acciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_perfil` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_acciones_rbac_perfiles: ~94 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_acciones_rbac_perfiles` (`id`, `rbac_accion_id`, `rbac_perfil_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1),
	(4, 4, 1),
	(5, 5, 1),
	(6, 5, 2),
	(7, 5, 3),
	(8, 5, 4),
	(9, 5, 5),
	(10, 6, 1),
	(11, 6, 2),
	(12, 6, 3),
	(13, 6, 4),
	(14, 6, 5),
	(15, 7, 1),
	(16, 7, 2),
	(17, 7, 3),
	(18, 7, 4),
	(19, 7, 5),
	(20, 8, 1),
	(21, 8, 2),
	(22, 8, 3),
	(23, 8, 4),
	(24, 8, 5),
	(25, 9, 1),
	(26, 9, 2),
	(27, 9, 3),
	(28, 9, 4),
	(29, 9, 5),
	(30, 10, 1),
	(31, 10, 2),
	(32, 10, 3),
	(33, 10, 4),
	(34, 10, 5),
	(35, 11, 1),
	(36, 11, 3),
	(37, 11, 4),
	(38, 12, 5),
	(39, 12, 4),
	(40, 12, 3),
	(41, 13, 1),
	(42, 13, 2),
	(43, 13, 3),
	(44, 13, 4),
	(45, 14, 1),
	(46, 14, 2),
	(47, 15, 1),
	(48, 15, 2),
	(49, 16, 1),
	(50, 16, 2),
	(51, 17, 1),
	(52, 17, 2),
	(53, 18, 1),
	(54, 19, 1),
	(55, 20, 1),
	(56, 22, 1),
	(57, 22, 2),
	(58, 23, 1),
	(59, 24, 3),
	(60, 24, 1),
	(61, 25, 1),
	(62, 26, 1),
	(63, 27, 1),
	(64, 28, 1),
	(65, 29, 1),
	(66, 30, 1),
	(67, 31, 1),
	(68, 32, 1),
	(69, 34, 1),
	(70, 35, 1),
	(71, 36, 3),
	(72, 36, 1),
	(73, 36, 2),
	(74, 37, 1),
	(75, 37, 2),
	(76, 37, 3),
	(77, 37, 4),
	(78, 37, 5),
	(79, 38, 1),
	(80, 38, 3),
	(81, 39, 1),
	(82, 39, 2),
	(83, 39, 3),
	(84, 39, 4),
	(85, 41, 1),
	(86, 41, 2),
	(87, 43, 1),
	(88, 43, 2),
	(89, 43, 4),
	(90, 43, 5),
	(91, 44, 1),
	(92, 44, 2),
	(93, 47, 1),
	(94, 48, 1);
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_perfiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `es_default` varchar(1) DEFAULT NULL,
  `usa_area_representacion` binary(1) DEFAULT NULL,
  `permiso_virtual_host_id` int DEFAULT NULL,
  `accion_default_id` int DEFAULT NULL,
  `perfil_publico` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`),
  KEY `rbac_perfiles_pvh` (`permiso_virtual_host_id`),
  KEY `rbac_perfiles_ra` (`accion_default_id`),
  CONSTRAINT `rbac_perfiles_pvh` FOREIGN KEY (`permiso_virtual_host_id`) REFERENCES `permisos_virtual_hosts` (`id`),
  CONSTRAINT `rbac_perfiles_ra` FOREIGN KEY (`accion_default_id`) REFERENCES `rbac_acciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_perfiles: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_perfiles` (`id`, `descripcion`, `es_default`, `usa_area_representacion`, `permiso_virtual_host_id`, `accion_default_id`, `perfil_publico`) VALUES
	(1, 'Desarrollador', '1', _binary 0x31, 5, 43, 0),
	(2, 'Adminsitrador', '0', _binary 0x31, 5, 43, 1),
	(3, 'Perfil Carga Publica', '0', _binary 0x31, 3, 44, 1),
	(4, 'Perfil Carga Interna', '0', _binary 0x31, 4, 43, 1),
	(5, 'Usuario', '0', _binary 0x31, 4, 43, 1);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_perfiles_rbac_usuarios
CREATE TABLE IF NOT EXISTS `rbac_perfiles_rbac_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rbac_perfil_id` int NOT NULL,
  `rbac_usuario_id` int NOT NULL,
  PRIMARY KEY (`id`,`rbac_usuario_id`,`rbac_perfil_id`),
  KEY `fk_rbac_perfil_has_rbac_usuario_rbac_usuario1_idx` (`rbac_usuario_id`),
  KEY `fk_rbac_perfil_has_rbac_usuario_rbac_perfil1_idx` (`rbac_perfil_id`),
  CONSTRAINT `rbac_perfiles_rbac_usuarios_ibfk_3` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `rbac_perfiles_rbac_usuarios_ibfk_4` FOREIGN KEY (`rbac_usuario_id`) REFERENCES `rbac_usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_perfiles_rbac_usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_perfiles_rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_perfiles_rbac_usuarios` (`id`, `rbac_perfil_id`, `rbac_usuario_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 5, 1),
	(4, 1, 2),
	(5, 2, 2),
	(6, 3, 2),
	(7, 4, 2),
	(8, 5, 2),
	(9, 1, 3),
	(10, 2, 3),
	(11, 5, 3),
	(12, 1, 4),
	(13, 2, 4),
	(14, 5, 4),
	(15, 1, 5),
	(16, 2, 5),
	(17, 1, 6),
	(18, 2, 6),
	(19, 1, 7),
	(20, 2, 7),
	(21, 1, 8),
	(22, 2, 8),
	(23, 1, 9),
	(24, 2, 9),
	(25, 5, 9);
/*!40000 ALTER TABLE `rbac_perfiles_rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_token
CREATE TABLE IF NOT EXISTS `rbac_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `usuario_id` int NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_token: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `rbac_token` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_usuarios
CREATE TABLE IF NOT EXISTS `rbac_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `apellido` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `correo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valida_ldap` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `seed` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `perfil_default_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`usuario`),
  KEY `fk_perfil_default` (`perfil_default_id`),
  CONSTRAINT `fk_perfil_default` FOREIGN KEY (`perfil_default_id`) REFERENCES `rbac_perfiles` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.rbac_usuarios: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_usuarios` (`id`, `usuario`, `nombre`, `apellido`, `correo`, `valida_ldap`, `password`, `seed`, `created`, `modified`, `perfil_default_id`) VALUES
	(1, 'alex', 'Alejandro', 'Gajate', 'alexan_kid@hotmail.com', '0', '26d5de2243e1981371f2c487be82b417d4e17b1f168b7952d85abc742cd1d608', '', '2014-07-15 20:06:32', '2022-03-30 13:54:35', 1),
	(2, 'tjg', 'Alejandro Ariel ', 'Gajate', 'tjg@mrecic.gov.ar', '1', '', '1377e22fd81057b3e65aefd5fc634b64', '2022-03-30 13:55:14', '2022-03-30 13:55:14', 1),
	(3, 'pyp', 'Damian Pablo ', 'Palopoli', 'pyp@mrecic.gov.ar', '1', '', '0070d23b06b1486a538c0eaa45dd167a', '2022-03-30 14:05:55', '2022-03-30 14:05:55', 1),
	(4, 'wsb', 'Walter Sebastián ', 'Bustelo', 'wsb@mrecic.gov.ar', '1', '', '56db57b4db0a6fcb7f9e0c0b504f6472', '2022-03-30 14:06:45', '2022-03-30 14:06:45', 1),
	(5, 'fzq', 'Rocío Ayelén ', 'Fernández', 'fzq@mrecic.gov.ar', '1', '', '1e65040d77567934e4ffed55c656a3cc', '2022-03-30 14:07:31', '2022-03-30 14:07:31', 1),
	(6, 'djb', 'Juan Pablo ', 'Dellagnolo', 'djb@mrecic.gov.ar', '1', '', '2a27b8144ac02f67687f76782a3b5d8f', '2022-03-30 14:08:43', '2022-03-30 14:08:43', 1),
	(7, 'qya', 'Alejandro Oscar ', 'Carnero', 'qya@mrecic.gov.ar', '1', '', '486c0401c56bf7ec2daa9eba58907da9', '2022-03-30 14:09:19', '2022-03-30 14:09:19', 1),
	(8, 'ufd', 'Facundo ', 'Musil', 'ufd@mrecic.gov.ar', '1', '', 'ebe922af8d4560c73368a88eeac07d16', '2022-03-30 14:10:13', '2022-03-30 14:10:13', 1),
	(9, 'abc', 'Alejandra Beatriz ', 'Campana', 'abc@mrecic.gov.ar', '1', '', '74627b65e6e6a4c21e06809b8e02114a', '2022-03-30 14:11:29', '2022-03-30 14:11:29', 1);
/*!40000 ALTER TABLE `rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(65) NOT NULL,
  `nombre_original` varchar(64) NOT NULL,
  `hash_archivo` varchar(64) NOT NULL,
  `hash_llave` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_by` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.uploads: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
