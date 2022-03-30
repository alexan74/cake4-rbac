-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.26 - MySQL Community Server (GPL)
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `relacion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_archivos_uploads` (`upload_id`),
  CONSTRAINT `FK_archivos_uploads` FOREIGN KEY (`upload_id`) REFERENCES `uploads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.archivos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.configuracion: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` (`id`, `clave`, `valor`) VALUES
	(2, 'captcha', 'No'),
	(4, 'noLDAP', 'No'),
	(5, 'oculto', 'No');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.correo
CREATE TABLE IF NOT EXISTS `correo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `from` int(11) DEFAULT NULL,
  `asunto` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mensaje` longtext COLLATE utf8_spanish_ci,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `from` (`from`),
  CONSTRAINT `FK_correo_rbac_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `rbac_usuarios` (`id`),
  CONSTRAINT `FK_correo_rbac_usuarios_2` FOREIGN KEY (`from`) REFERENCES `rbac_usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.correo: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `correo` DISABLE KEYS */;
/*!40000 ALTER TABLE `correo` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.ejemplos
CREATE TABLE IF NOT EXISTS `ejemplos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permiso` varchar(250) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '0',
  `captcha` tinyint(4) DEFAULT NULL,
  `contrasenia` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.permisos_virtual_hosts: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `permisos_virtual_hosts` DISABLE KEYS */;
INSERT INTO `permisos_virtual_hosts` (`id`, `permiso`, `url`, `activo`, `captcha`, `contrasenia`) VALUES
	(1, 'solo_lectura', '/homel/index', 0, NULL, NULL),
	(2, 'carga_publica', NULL, 0, NULL, NULL),
	(3, 'carga_login_publica', NULL, 0, 1, 1),
	(4, 'carga_login_interna', NULL, 0, 0, 0),
	(5, 'carga_administracion', NULL, 1, 1, 1);
/*!40000 ALTER TABLE `permisos_virtual_hosts` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_acciones
CREATE TABLE IF NOT EXISTS `rbac_acciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `solo_lectura` int(11) DEFAULT NULL,
  `carga_publica` int(11) DEFAULT NULL,
  `carga_login_publica` int(11) DEFAULT NULL,
  `carga_login_interna` int(11) DEFAULT NULL,
  `carga_administracion` int(11) DEFAULT NULL,
  `heredado` int(11) DEFAULT NULL,
  `oculto` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_acciones: ~45 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
INSERT INTO `rbac_acciones` (`id`, `controller`, `action`, `solo_lectura`, `carga_publica`, `carga_login_publica`, `carga_login_interna`, `carga_administracion`, `heredado`, `oculto`) VALUES
	(1, 'RbacUsuarios', 'index', 0, 0, 0, 0, 1, 1, 0),
	(2, 'RbacUsuarios', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(3, 'RbacUsuarios', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(4, 'RbacUsuarios', 'eliminar', 0, 0, 0, 0, 1, 1, 0),
	(14, 'RbacPerfiles', 'index', 0, 0, 0, 0, 1, 1, 0),
	(15, 'RbacPerfiles', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(16, 'RbacPerfiles', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(17, 'RbacPerfiles', 'eliminar', 0, 0, 0, 0, 1, 1, 0),
	(19, 'RbacAcciones', 'index', 0, 0, 0, 0, 1, 1, 0),
	(5, 'RbacUsuarios', 'autocompleteLdap', 0, 0, 0, 0, 1, 1, 1),
	(6, 'RbacUsuarios', 'validarLoginLdap', 0, 0, 0, 0, 1, 1, 1),
	(7, 'RbacUsuarios', 'validarLoginDB', 0, 0, 0, 0, 1, 1, 1),
	(8, 'RbacUsuarios', 'login', 1, 0, 1, 1, 1, 1, 1),
	(9, 'RbacUsuarios', 'changePass', 0, 0, 1, 1, 1, 1, 0),
	(10, 'RbacUsuarios', 'cambiarPerfil', 1, 1, 1, 1, 1, 1, 0),
	(23, 'Configuraciones', 'index', 0, 0, 0, 0, 1, 1, 0),
	(24, 'Configuraciones', 'editar', 0, 0, 0, 0, 1, 1, 0),
	(11, 'RbacUsuarios', 'recuperar', 0, 0, 1, 1, 1, 1, 0),
	(12, 'RbacUsuarios', 'recuperarPass', 0, 0, 1, 1, 1, 1, 0),
	(20, 'RbacAcciones', 'switchAccion', 0, 0, 0, 0, 1, 1, 0),
	(33, 'Pages', '_null', 0, 0, 0, 0, 0, 0, 0),
	(21, 'RbacAcciones', 'eliminar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(22, 'RbacAcciones', 'sincronizar', 0, 0, 0, 1, 1, 1, 0),
	(18, 'RbacPerfiles', 'getAccionesByVirtualHost', 0, 0, 0, 0, 1, 1, 0),
	(34, 'Pages', 'display', 0, 1, 0, 0, 0, 0, 0),
	(26, 'RbacPermisos', 'index', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(27, 'RbacPermisos', 'agregar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(28, 'RbacPermisos', 'editar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(29, 'RbacPermisos', 'eliminar', NULL, NULL, NULL, NULL, 1, NULL, 0),
	(13, 'RbacUsuarios', 'cambiarEntorno', 1, 1, 1, 1, 1, 1, 0),
	(35, 'Pages', 'ditic', 0, 1, 0, 0, 0, 0, 0),
	(30, 'RbacPermisos', 'actualizarCaptcha', 0, 0, 0, 0, 1, 1, 1),
	(31, 'RbacPermisos', 'actualizarContrasenia', 0, 0, 0, 0, 1, 1, 1),
	(32, 'RbacPermisos', 'actualizarURL', 0, 0, 0, 0, 1, 1, 1),
	(36, 'Usuarios', 'agregar', 0, 0, 1, 1, 1, 1, 1),
	(37, 'Usuarios', 'editar', 0, 0, 1, 1, 1, 1, 1),
	(38, 'Usuarios', 'eliminar', 0, 0, 1, 1, 1, 1, 1),
	(39, 'Usuarios', 'changePass', 0, 0, 1, 1, 1, 1, 1),
	(40, 'Usuarios', '_null', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(41, 'Usuarios', 'index', NULL, NULL, NULL, 1, 1, NULL, 1),
	(42, 'Admin', '_null', NULL, NULL, NULL, 1, 1, NULL, 1),
	(43, 'Admin', 'index', NULL, NULL, NULL, 1, 1, NULL, 1),
	(25, 'Configuraciones', 'agregar', 0, 0, 0, 0, 1, 1, 0),
	(46, 'Ejemplos', '_null', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(47, 'Ejemplos', 'index', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(48, 'Ejemplos', 'ver', NULL, NULL, NULL, NULL, 1, NULL, 1),
	(44, 'Home', 'index', NULL, 1, NULL, NULL, 1, NULL, 1),
	(45, 'Home', '_null', NULL, 1, NULL, NULL, 1, NULL, 1);
/*!40000 ALTER TABLE `rbac_acciones` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_acciones_rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_acciones_rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rbac_accion_id` int(11) NOT NULL,
  `rbac_perfil_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`rbac_accion_id`,`rbac_perfil_id`),
  KEY `fk_ap_accion_idx` (`rbac_accion_id`),
  KEY `fk_ap_perfil_idx` (`rbac_perfil_id`),
  CONSTRAINT `fk_acion` FOREIGN KEY (`rbac_accion_id`) REFERENCES `rbac_acciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_perfil` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2798 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_acciones_rbac_perfiles: ~89 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_acciones_rbac_perfiles` (`id`, `rbac_accion_id`, `rbac_perfil_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 1),
	(4, 4, 1),
	(5, 5, 3),
	(6, 5, 4),
	(7, 5, 5),
	(8, 6, 3),
	(9, 6, 4),
	(10, 6, 5),
	(11, 7, 3),
	(12, 7, 4),
	(13, 7, 5),
	(14, 8, 3),
	(15, 8, 4),
	(16, 8, 5),
	(17, 9, 1),
	(18, 9, 2),
	(19, 9, 3),
	(20, 9, 4),
	(21, 9, 5),
	(22, 10, 1),
	(23, 10, 2),
	(24, 10, 3),
	(25, 10, 4),
	(26, 10, 5),
	(27, 11, 1),
	(28, 11, 3),
	(29, 11, 4),
	(30, 12, 1),
	(31, 12, 4),
	(32, 12, 3),
	(33, 13, 1),
	(34, 13, 2),
	(35, 13, 3),
	(36, 13, 4),
	(37, 14, 1),
	(38, 14, 2),
	(39, 15, 1),
	(40, 15, 2),
	(41, 16, 1),
	(42, 16, 2),
	(43, 17, 1),
	(44, 17, 2),
	(45, 18, 1),
	(46, 18, 2),
	(47, 19, 1),
	(48, 19, 2),
	(49, 20, 1),
	(50, 21, 1),
	(51, 21, 2),
	(52, 22, 1),
	(53, 22, 2),
	(54, 23, 1),
	(55, 24, 3),
	(56, 24, 1),
	(57, 26, 1),
	(58, 27, 1),
	(59, 28, 1),
	(60, 29, 1),
	(61, 30, 1),
	(62, 31, 1),
	(63, 32, 1),
	(64, 34, 1),
	(65, 35, 1),
	(66, 36, 3),
	(67, 36, 1),
	(68, 36, 2),
	(69, 36, 4),
	(70, 37, 1),
	(71, 37, 2),
	(72, 37, 3),
	(73, 37, 5),
	(74, 38, 3),
	(75, 38, 1),
	(76, 39, 3),
	(77, 39, 1),
	(78, 39, 2),
	(79, 41, 1),
	(80, 41, 2),
	(81, 43, 1),
	(82, 43, 2),
	(83, 43, 5),
	(84, 25, 1),
	(85, 47, 1),
	(86, 48, 1),
	(87, 44, 1);
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `es_default` varchar(1) DEFAULT NULL,
  `usa_area_representacion` binary(1) DEFAULT NULL,
  `permiso_virtual_host_id` int(11) DEFAULT NULL,
  `accion_default_id` int(11) DEFAULT NULL,
  `perfil_publico` tinyint(4) DEFAULT NULL,
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
	(1, 'Desarrollador', '1', _binary 0x31, 5, 130, 0),
	(2, 'Adminsitrador', '0', _binary 0x31, 5, 130, 1),
	(3, 'Perfil Carga Publica', '0', _binary 0x31, 3, 107, 1),
	(4, 'Perfil Carga Interna', '0', _binary 0x31, 4, 107, 1),
	(5, 'Usuario', '0', _binary 0x31, 4, 130, 1);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_perfiles_rbac_usuarios
CREATE TABLE IF NOT EXISTS `rbac_perfiles_rbac_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rbac_perfil_id` int(11) NOT NULL,
  `rbac_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`rbac_usuario_id`,`rbac_perfil_id`),
  KEY `fk_rbac_perfil_has_rbac_usuario_rbac_usuario1_idx` (`rbac_usuario_id`),
  KEY `fk_rbac_perfil_has_rbac_usuario_rbac_perfil1_idx` (`rbac_perfil_id`),
  CONSTRAINT `rbac_perfiles_rbac_usuarios_ibfk_3` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `rbac_perfiles_rbac_usuarios_ibfk_4` FOREIGN KEY (`rbac_usuario_id`) REFERENCES `rbac_usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=457 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_perfiles_rbac_usuarios: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_perfiles_rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_perfiles_rbac_usuarios` (`id`, `rbac_perfil_id`, `rbac_usuario_id`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 5, 1);
/*!40000 ALTER TABLE `rbac_perfiles_rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_token
CREATE TABLE IF NOT EXISTS `rbac_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.rbac_token: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
INSERT INTO `rbac_token` (`id`, `token`, `usuario_id`, `created`, `modified`, `validez`) VALUES
	(1, 'kCB4fXSypr16vODROyeYvYG9', 17, NULL, NULL, 30000000);
/*!40000 ALTER TABLE `rbac_token` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.rbac_usuarios
CREATE TABLE IF NOT EXISTS `rbac_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(120) CHARACTER SET utf8 NOT NULL,
  `nombre` text CHARACTER SET utf8,
  `apellido` text CHARACTER SET utf8,
  `correo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valida_ldap` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `password` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `seed` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `perfil_default_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`usuario`),
  KEY `fk_perfil_default` (`perfil_default_id`),
  CONSTRAINT `fk_perfil_default` FOREIGN KEY (`perfil_default_id`) REFERENCES `rbac_perfiles` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla cake4_rbac.rbac_usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_usuarios` (`id`, `usuario`, `nombre`, `apellido`, `correo`, `valida_ldap`, `password`, `seed`, `created`, `modified`, `perfil_default_id`) VALUES
	(1, 'alex', 'Alejandro.', 'Gajate', 'alexan74@gmail.com', '0', '26d5de2243e1981371f2c487be82b417d4e17b1f168b7952d85abc742cd1d608', '', '2014-07-15 20:06:32', '2022-03-25 13:12:31', 1);
/*!40000 ALTER TABLE `rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla cake4_rbac.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(65) NOT NULL,
  `nombre_original` varchar(64) NOT NULL,
  `hash_archivo` varchar(64) NOT NULL,
  `hash_llave` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla cake4_rbac.uploads: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
