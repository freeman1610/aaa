-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2022 a las 08:30:57
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `la_garra_predefensa`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `consulta_bitacora` (IN `idusuarioB` INT(11), IN `fecha_inicioB` DATE, IN `fecha_finB` DATE)  BEGIN

SELECT DATE(b.fecha_mov) as fecha, u.nombre as usuario, b.operacion, b.host, b.hora_mov as hora, b.tabla_mov FROM bitacora b INNER JOIN usuario u ON b.idusuario=u.idusuario WHERE DATE(b.fecha_mov)>=fecha_inicioB AND DATE(b.fecha_mov)<=fecha_finB AND b.idusuario=idusuarioB;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `desac_articulo` (IN `operacionB` VARCHAR(20), IN `idusuarioB` INT(11), IN `hostB` VARCHAR(40), IN `fecha_movB` DATE, IN `hora_movB` TIME, IN `tabla_movB` VARCHAR(40))  BEGIN

 INSERT INTO bitacora (operacion,idusuario,host,fecha_mov,hora_mov, tabla_mov) VALUES (operacionB,idusuarioB,hostB,fecha_movB,hora_movB, tabla_movB);
 
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `editar_articulo` (IN `idarticuloA` INT(11), IN `idcategoriaA` INT(11), IN `codigoA` VARCHAR(50), IN `nombreA` VARCHAR(100), IN `descripcionA` VARCHAR(256), IN `imagenA` VARCHAR(50))  BEGIN

UPDATE articulo SET idcategoria=idcategoriaA,codigo=codigoA, nombre=nombreA,descripcion=descripcionA,imagen=imagenA WHERE idarticulo=idarticuloA;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_articulo` (`idcategoriaA` INT(11), `codigoA` VARCHAR(50), `nombreA` VARCHAR(100), `descripcionA` VARCHAR(256), `imagenA` VARCHAR(50), `idusuarioA` INT(11), `condicionA` TINYINT(4))  BEGIN

INSERT INTO articulo (idcategoria,codigo,nombre,descripcion,imagen,idusuario,condicion)
VALUES (idcategoriaA,codigoA,nombreA,descripcionA,imagenA,idusuarioA,condicionA);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listarallasistencia` ()  BEGIN
SELECT a.idasistencia,a.num_documento,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellido,d.nombre as departamento FROM asistencia a INNER JOIN usuario u INNER JOIN departamento d ON u.iddepartamento=d.iddepartamento WHERE a.num_documento=u.num_documento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listaregreso` ()  BEGIN

SELECT v.idegreso,DATE(v.fecha_hora) as fecha,u.idusuario,u.nombre as usuario,v.total_egreso,v.estado FROM egreso v INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER BY v.idegreso DESC;
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listaringreso` ()  BEGIN

SELECT i.idingreso,DATE(i.fecha_hora) as fecha,u.idusuario,u.nombre as usuario, i.total_compra,i.estado FROM ingreso i INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso DESC;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listaruserasistencia` (IN `idusuarioU` INT(11))  BEGIN

SELECT a.idasistencia,a.num_documento,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellido,d.nombre as departamento FROM asistencia a INNER JOIN usuario u INNER JOIN departamento d ON u.iddepartamento=d.iddepartamento WHERE a.num_documento=u.num_documento AND u.idusuario=idusuarioU;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_art` ()  BEGIN

SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_asistenciaD` (IN `num_documentoU` VARCHAR(20), IN `fecha_inicioB` DATE, IN `fecha_finB` DATE)  BEGIN
SELECT a.idasistencia,a.num_documento,a.fecha_hora,a.tipo,a.fecha,u.nombre,u.apellido FROM asistencia a INNER JOIN usuario u ON  a.num_documento=u.num_documento WHERE DATE(a.fecha)>=fecha_inicioB AND DATE(a.fecha)<=fecha_finB AND a.num_documento=num_documentoU;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_ingr_art` ()  BEGIN
 
 SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1';
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_vent_art` ()  BEGIN

SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_compra FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_egreso,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1';
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mostrar_art` (IN `idarticuloB` INT(11))  BEGIN

SELECT * FROM articulo WHERE idarticulo=idarticuloB;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `idalmacen` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idalmacen`, `idusuario`, `codigo`, `marca`, `nombre`, `stock`, `descripcion`, `created_at`, `updated_at`) VALUES
(46, 1, '21312', 'Listo', 'XD', 22, 'fff', '2022-09-13 00:00:00', '2022-09-20 19:48:54'),
(47, 21, '321222', 'Ya Funciona', 'dasda', 213, 'dasdad', '2022-09-14 06:59:39', '2022-09-20 19:49:17'),
(48, 1, '123554', 'Goodyear', 'Caucho', 4, 'Ring 20', '2022-09-20 00:57:59', '2022-09-20 00:57:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_nomina`
--

CREATE TABLE `asignacion_nomina` (
  `id_asignacion` int(11) NOT NULL,
  `id_nomina` int(11) NOT NULL,
  `dias_lab` int(11) UNSIGNED NOT NULL,
  `pagos_diasLab` double(7,2) UNSIGNED NOT NULL,
  `dias_libres` int(11) UNSIGNED NOT NULL,
  `pagos_DiaLib` double(7,2) UNSIGNED NOT NULL,
  `horas_extra_diurna` int(11) UNSIGNED NOT NULL,
  `pago_hr_extraD` double(7,2) UNSIGNED NOT NULL,
  `horas_extra_noc` int(11) UNSIGNED NOT NULL,
  `pago_hr_extra_noc` double(7,2) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignacion_nomina`
--

INSERT INTO `asignacion_nomina` (`id_asignacion`, `id_nomina`, `dias_lab`, `pagos_diasLab`, `dias_libres`, `pagos_DiaLib`, `horas_extra_diurna`, `pago_hr_extraD`, `horas_extra_noc`, `pago_hr_extra_noc`, `created_at`, `updated_at`) VALUES
(1, 70, 20, 120.00, 6, 36.00, 5, 5.62, 2, 2.70, '2022-09-06 23:23:38', '2022-09-06 23:23:38'),
(2, 71, 20, 120.00, 6, 36.00, 10, 11.25, 5, 6.75, '2022-09-09 12:25:14', '2022-09-09 12:25:14'),
(4, 73, 25, 316.67, 5, 63.33, 14, 33.25, 6, 17.10, '2022-09-11 03:16:43', '2022-09-11 03:16:43'),
(5, 74, 23, 291.33, 7, 88.67, 0, 0.00, 0, 0.00, '2022-09-12 22:56:43', '2022-09-12 22:56:43'),
(6, 75, 20, 253.33, 10, 126.67, 4, 9.50, 5, 14.25, '2022-09-17 22:28:35', '2022-09-17 22:28:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `idbitacora` int(11) NOT NULL,
  `operacion` varchar(20) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `host` varchar(30) NOT NULL,
  `fecha_mov` date DEFAULT NULL,
  `hora_mov` time DEFAULT NULL,
  `tabla_mov` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`idbitacora`, `operacion`, `idusuario`, `host`, `fecha_mov`, `hora_mov`, `tabla_mov`) VALUES
(372, 'ACTUALIZAR', 1, 'localhost', '2022-07-12', '05:56:25', 'usuario -> idusuario: 1'),
(373, 'ELIMINAR', 1, 'localhost', '2022-07-12', '05:59:51', 'departamento -> iddepartamento: 6'),
(374, 'ACTUALIZAR', 1, 'localhost', '2022-07-12', '06:14:01', 'usuario -> idusuario: 1'),
(375, 'ELIMINAR', 1, 'localhost', '2022-07-12', '08:44:34', 'empleado -> id_empleado: 1'),
(376, 'DESACTIVAR', 1, 'localhost', '2022-07-12', '08:57:08', 'usuario -> idusuario: 16'),
(377, 'ELIMINAR', 1, 'localhost', '2022-07-12', '08:57:12', 'usuario -> idusuario: 16'),
(378, 'INSERTAR', 1, 'localhost', '2022-07-12', '08:59:26', 'usuario -> idusuario: 18'),
(379, 'ELIMINAR', 1, 'localhost', '2022-07-12', '09:10:07', 'empleado -> id_empleado: 4'),
(380, 'ELIMINAR', 1, 'localhost', '2022-07-13', '09:23:38', 'departamento -> iddepartamento: 5'),
(381, 'ACTUALIZAR', 1, 'localhost', '2022-07-13', '09:24:07', 'departamento -> iddepartamento: 1'),
(382, 'ACTUALIZAR', 1, 'localhost', '2022-07-13', '09:24:27', 'departamento -> iddepartamento: 1'),
(383, 'DESACTIVAR', 1, 'localhost', '2022-07-13', '09:24:50', 'usuario -> idusuario: 18'),
(384, 'ELIMINAR', 1, 'localhost', '2022-07-13', '09:24:53', 'usuario -> idusuario: 18'),
(385, 'INSERTAR', 1, 'localhost', '2022-07-13', '09:26:32', 'articulo ->  idarticulo: 25'),
(386, 'INSERTAR', 1, 'localhost', '2022-07-13', '09:31:55', 'articulo ->  idarticulo: 26'),
(387, 'INSERTAR', 1, 'localhost', '2022-07-13', '09:41:24', 'ingreso ->  idingreso: 18'),
(388, 'INSERTAR', 1, 'localhost', '2022-07-13', '09:43:20', 'egreso ->  idegreso13'),
(389, 'INSERTAR', 1, 'localhost', '2022-07-13', '09:59:14', 'egreso ->  idegreso14'),
(390, 'INSERTAR', 1, 'localhost', '2022-07-14', '05:30:51', 'egreso ->  idegreso15'),
(391, 'ACTUALIZAR', 1, 'localhost', '2022-07-14', '07:07:23', 'usuario -> idusuario: 1'),
(392, 'ACTUALIZAR', 1, 'localhost', '2022-07-14', '07:10:09', 'usuario -> idusuario: 1'),
(393, 'ACTUALIZAR', 1, 'localhost', '2022-07-14', '07:10:32', 'departamento -> iddepartamento: 1'),
(394, 'ACTUALIZAR', 1, 'localhost', '2022-07-14', '07:10:38', 'departamento -> iddepartamento: 1'),
(395, 'DESACTIVAR', 1, 'localhost', '2022-07-14', '07:13:52', 'categoria -> idcategoria: 1'),
(396, 'DESACTIVAR', 1, 'localhost', '2022-07-14', '07:14:23', 'articulo -> idarticulo: 26'),
(397, 'ACTIVAR', 1, 'localhost', '2022-07-14', '07:15:19', 'categoria -> idcategoria: 1'),
(398, 'ELIMINAR', 1, 'localhost', '2022-07-14', '07:15:33', 'categoria -> idcategoria: 2'),
(399, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:28:34', 'articulo ->  idarticulo: 27'),
(400, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:29:18', 'articulo ->  idarticulo: 28'),
(401, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:36:12', 'articulo -> idarticulo: 28'),
(402, 'ACTIVAR', 1, 'localhost', '2022-07-15', '06:36:28', 'articulo -> idarticulo: 26'),
(403, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:38:13', 'articulo ->  idarticulo: 29'),
(404, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:42:00', 'articulo ->  idarticulo: 30'),
(405, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:42:47', 'articulo ->  idarticulo: 31'),
(406, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:42:53', 'articulo -> idarticulo: 30'),
(407, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:42:57', 'articulo -> idarticulo: 31'),
(408, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:43:00', 'articulo -> idarticulo: 29'),
(409, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:43:03', 'articulo -> idarticulo: 27'),
(410, 'INSERTAR', 1, 'localhost', '2022-07-15', '06:49:36', 'articulo ->  idarticulo: 32'),
(411, 'ELIMINAR', 1, 'localhost', '2022-07-15', '06:49:44', 'articulo -> idarticulo: 32'),
(412, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:39:00', 'articulo ->  idarticulo: 33'),
(413, 'ELIMINAR', 1, 'localhost', '2022-07-16', '03:39:05', 'articulo -> idarticulo: 33'),
(414, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:45:55', 'ingreso ->  idingreso: 19'),
(415, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:46:16', 'ingreso ->  idingreso: 20'),
(416, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:50:11', 'ingreso ->  idingreso: 21'),
(417, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:50:27', 'ingreso ->  idingreso: 22'),
(418, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:55:13', 'ingreso ->  idingreso: 23'),
(419, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:55:22', 'ingreso ->  idingreso: 24'),
(420, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:56:54', 'ingreso ->  idingreso: 25'),
(421, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:57:00', 'ingreso ->  idingreso: 26'),
(422, 'INSERTAR', 1, 'localhost', '2022-07-16', '03:57:51', 'ingreso ->  idingreso: 27'),
(423, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:06:32', 'ingreso ->  idingreso: 28'),
(424, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:06:39', 'ingreso ->  idingreso: 29'),
(425, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:06:59', 'ingreso ->  idingreso: 30'),
(426, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:08:34', 'ingreso ->  idingreso: 31'),
(427, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:08:59', 'ingreso ->  idingreso: 32'),
(429, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:38:15', 'ingreso ->  idingreso: 34'),
(431, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:39:37', 'ingreso ->  idingreso: 36'),
(432, 'INSERTAR', 1, 'localhost', '2022-07-16', '04:40:53', 'ingreso ->  idingreso: 37'),
(433, 'INSERTAR', 1, 'localhost', '2022-07-16', '05:02:23', 'usuario -> idusuario: 19'),
(434, 'INSERTAR', 1, 'localhost', '2022-07-16', '05:04:02', 'usuario -> idusuario: 20'),
(435, 'DESACTIVAR', 1, 'localhost', '2022-07-16', '05:04:06', 'usuario -> idusuario: 20'),
(436, 'ELIMINAR', 1, 'localhost', '2022-07-16', '05:04:12', 'usuario -> idusuario: 20'),
(437, 'DESACTIVAR', 1, 'localhost', '2022-07-16', '05:04:16', 'usuario -> idusuario: 19'),
(438, 'ELIMINAR', 1, 'localhost', '2022-07-16', '05:04:20', 'usuario -> idusuario: 19'),
(439, 'ELIMINAR', 1, 'localhost', '2022-07-16', '05:11:19', 'empleado -> id_empleado: 6'),
(440, 'INSERTAR', 1, 'localhost', '2022-07-16', '05:17:26', 'egreso ->  idegreso16'),
(441, 'INSERTAR', 1, 'localhost', '2022-07-21', '00:45:50', 'usuario -> idusuario: 21'),
(442, 'INSERTAR', 1, 'localhost', '2022-07-21', '00:49:01', 'usuario -> idusuario: 22'),
(443, 'ACTUALIZAR', 1, 'localhost', '2022-07-21', '09:51:00', 'usuario -> idusuario: 1'),
(444, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '06:59:14', 'usuario -> idusuario: 1'),
(445, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '09:29:47', 'usuario -> idusuario: 21'),
(446, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '09:33:32', 'usuario -> idusuario: 22'),
(447, 'INSERTAR', 1, 'localhost', '2022-07-22', '10:21:03', 'usuario -> idusuario: 23'),
(448, 'DESACTIVAR', 1, 'localhost', '2022-07-22', '10:21:44', 'usuario -> idusuario: 23'),
(449, 'ELIMINAR', 1, 'localhost', '2022-07-22', '10:21:52', 'usuario -> idusuario: 23'),
(450, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '20:57:21', 'usuario -> idusuario: 1'),
(451, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:12:55', 'usuario -> idusuario: 1'),
(452, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:18:24', 'usuario -> idusuario: 1'),
(453, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:20:06', 'usuario -> idusuario: 1'),
(454, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:22:01', 'usuario -> idusuario: 1'),
(455, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:23:10', 'usuario -> idusuario: 1'),
(456, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:23:18', 'usuario -> idusuario: 1'),
(457, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:23:26', 'usuario -> idusuario: 1'),
(458, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:23:51', 'usuario -> idusuario: 1'),
(459, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:30:36', 'usuario -> idusuario: 1'),
(460, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:31:34', 'usuario -> idusuario: 1'),
(461, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:31:47', 'usuario -> idusuario: 1'),
(462, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:31:58', 'usuario -> idusuario: 1'),
(463, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:32:23', 'usuario -> idusuario: 1'),
(464, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:33:56', 'usuario -> idusuario: 1'),
(465, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:34:50', 'usuario -> idusuario: 1'),
(466, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:38:16', 'usuario -> idusuario: 1'),
(467, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:40:04', 'usuario -> idusuario: 1'),
(468, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:41:42', 'usuario -> idusuario: 1'),
(469, 'ACTUALIZAR', 1, 'localhost', '2022-07-22', '21:43:44', 'usuario -> idusuario: 1'),
(470, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '01:44:49', 'usuario -> idusuario: 1'),
(471, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '01:45:06', 'usuario -> idusuario: 1'),
(472, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '01:45:24', 'usuario -> idusuario: 1'),
(473, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '03:19:29', 'usuario -> idusuario: 1'),
(474, 'ELIMINAR', 1, 'localhost', '2022-07-23', '04:29:28', 'empleado -> id_empleado: 8'),
(475, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:31:33', 'empleado -> id_empleado: 5'),
(476, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:31:54', 'usuario -> idusuario: 1'),
(477, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:36:55', 'usuario -> idusuario: 22'),
(478, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:39:33', 'usuario -> idusuario: 22'),
(479, 'INSERTAR', 1, 'localhost', '2022-07-23', '04:40:27', 'usuario -> idusuario: 24'),
(480, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:42:23', 'empleado -> id_empleado: 9'),
(481, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:42:38', 'empleado -> id_empleado: 9'),
(482, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '04:43:32', 'empleado -> id_empleado: 9'),
(483, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '05:37:39', 'empleado -> id_empleado: 5'),
(484, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '05:37:53', 'empleado -> id_empleado: 5'),
(485, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '05:38:00', 'empleado -> id_empleado: 5'),
(486, 'INSERTAR', 1, 'localhost', '2022-07-23', '06:06:33', 'departamento ->  iddepartamento: 9'),
(487, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '06:06:43', 'departamento -> iddepartamento: 9'),
(488, 'ELIMINAR', 1, 'localhost', '2022-07-23', '06:06:46', 'departamento -> iddepartamento: 9'),
(489, 'DESACTIVAR', 1, 'localhost', '2022-07-23', '06:07:08', 'departamento -> iddepartamento: 8'),
(490, 'ACTIVAR', 1, 'localhost', '2022-07-23', '06:07:11', 'departamento -> iddepartamento: 8'),
(491, 'DESACTIVAR', 1, 'localhost', '2022-07-23', '06:07:16', 'departamento -> iddepartamento: 8'),
(492, 'ACTIVAR', 1, 'localhost', '2022-07-23', '06:07:37', 'departamento -> iddepartamento: 8'),
(493, 'INSERTAR', 1, 'localhost', '2022-07-23', '06:42:58', 'departamento ->  iddepartamento: 10'),
(494, 'ELIMINAR', 1, 'localhost', '2022-07-23', '06:43:01', 'departamento -> iddepartamento: 10'),
(495, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:28:44', 'articulo -> idarticulo: 25'),
(496, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:28:51', 'articulo -> idarticulo: 25'),
(497, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:29:06', 'articulo -> idarticulo: 25'),
(498, 'INSERTAR', 1, 'localhost', '2022-07-23', '09:30:33', 'articulo ->  idarticulo: 34'),
(499, 'ELIMINAR', 1, 'localhost', '2022-07-23', '09:30:56', 'articulo -> idarticulo: 34'),
(500, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:40:20', 'articulo -> idarticulo: 26'),
(501, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:41:00', 'articulo -> idarticulo: 26'),
(502, 'INSERTAR', 1, 'localhost', '2022-07-23', '09:46:58', 'articulo ->  idarticulo: 35'),
(503, 'INSERTAR', 1, 'localhost', '2022-07-23', '09:59:07', 'categoria ->  idcategoria: 5'),
(504, 'ACTUALIZAR', 1, 'localhost', '2022-07-23', '09:59:14', 'categoria -> idcategoria: 5'),
(505, 'ELIMINAR', 1, 'localhost', '2022-07-23', '09:59:16', 'categoria -> idcategoria: 5'),
(506, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '08:38:50', 'categoria -> idcategoria: 1'),
(507, 'INSERTAR', 1, 'localhost', '2022-07-24', '08:38:56', 'categoria ->  idcategoria: 6'),
(508, 'DESACTIVAR', 1, 'localhost', '2022-07-24', '08:39:01', 'categoria -> idcategoria: 6'),
(509, 'ACTIVAR', 1, 'localhost', '2022-07-24', '08:39:05', 'categoria -> idcategoria: 6'),
(510, 'ELIMINAR', 1, 'localhost', '2022-07-24', '08:39:09', 'categoria -> idcategoria: 6'),
(512, 'INSERTAR', 1, 'localhost', '2022-07-24', '10:59:47', 'ingreso ->  idingreso: 39'),
(513, 'INSERTAR', 1, 'localhost', '2022-07-24', '11:23:21', 'egreso ->  idegreso17'),
(514, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '13:32:52', 'usuario -> idusuario: 1'),
(515, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '13:33:10', 'usuario -> idusuario: 1'),
(516, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:01:08', 'usuario -> idusuario: 1'),
(517, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:02:43', 'usuario -> idusuario: 1'),
(518, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:30:09', 'usuario -> idusuario: 1'),
(519, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:45:38', 'usuario -> idusuario: 1'),
(520, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:48:26', 'usuario -> idusuario: 1'),
(521, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:49:32', 'usuario -> idusuario: 1'),
(522, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:50:12', 'usuario -> idusuario: 1'),
(523, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:50:17', 'usuario -> idusuario: 1'),
(524, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:50:22', 'usuario -> idusuario: 1'),
(525, 'Editar_Passwd', 1, 'localhost', '2022-07-24', '14:50:42', 'usuario -> idusuario: 1'),
(526, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:52:50', 'usuario -> idusuario: 1'),
(527, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:52:53', 'usuario -> idusuario: 1'),
(528, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:54:45', 'usuario -> idusuario: 1'),
(529, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:54:52', 'usuario -> idusuario: 1'),
(530, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:55:58', 'usuario -> idusuario: 1'),
(531, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:56:02', 'usuario -> idusuario: 1'),
(532, 'ACTUALIZAR', 1, 'localhost', '2022-07-24', '14:56:05', 'usuario -> idusuario: 1'),
(533, 'Editar_Passwd', 1, 'localhost', '2022-07-24', '14:56:17', 'usuario -> idusuario: 1'),
(534, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:14:57', 'chutos -> id_chutos: '),
(535, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:15:04', 'chutos -> id_chutos: '),
(536, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:21:54', 'chutos -> id_chutos: '),
(537, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:22:05', 'chutos -> id_chutos: '),
(538, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '14:32:23', 'chutos -> id_chutos: 7'),
(539, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '14:32:34', 'chutos -> id_chutos: 7'),
(540, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:32:40', 'chutos -> id_chutos: 12'),
(541, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:32:43', 'chutos -> id_chutos: 11'),
(542, 'ELIMINAR', 1, 'localhost', '2022-07-26', '14:32:47', 'chutos -> id_chutos: 10'),
(543, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '14:33:42', 'chutos -> id_chutos: 7'),
(544, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '14:37:49', 'chutos -> id_chutos: 8'),
(545, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '15:05:20', 'cavas -> id_cavas: 10'),
(546, 'ELIMINAR', 1, 'localhost', '2022-07-26', '15:50:50', 'fletes -> id_fletes: 10'),
(547, 'ELIMINAR', 1, 'localhost', '2022-07-26', '15:55:54', 'fletes -> id_fletes: 13'),
(548, 'ELIMINAR', 1, 'localhost', '2022-07-26', '15:55:58', 'fletes -> id_fletes: 12'),
(549, 'ELIMINAR', 1, 'localhost', '2022-07-26', '15:56:01', 'fletes -> id_fletes: 14'),
(550, 'ELIMINAR', 1, 'localhost', '2022-07-26', '15:56:05', 'fletes -> id_fletes: 11'),
(551, 'ACTUALIZAR', 1, 'localhost', '2022-07-26', '16:08:07', 'usuario -> idusuario: 21'),
(552, 'ACTUALIZAR', 21, 'localhost', '2022-07-26', '16:08:43', 'usuario -> idusuario: 21'),
(553, 'ACTUALIZAR', 21, 'localhost', '2022-07-26', '16:08:49', 'usuario -> idusuario: 21'),
(554, 'ACTUALIZAR', 21, 'localhost', '2022-07-26', '16:09:50', 'usuario -> idusuario: 21'),
(555, 'ACTUALIZAR', 21, 'localhost', '2022-07-26', '16:13:20', 'usuario -> idusuario: 21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cavas`
--

CREATE TABLE `cavas` (
  `cava_id` int(11) NOT NULL,
  `cava_idusuario` int(11) NOT NULL,
  `cava_placa` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `cava_modelo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cava_marca` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cava_estado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cava_fechacreacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cavas`
--

INSERT INTO `cavas` (`cava_id`, `cava_idusuario`, `cava_placa`, `cava_modelo`, `cava_marca`, `cava_estado`, `cava_fechacreacion`) VALUES
(10, 1, '000AA3', 'GANDOLA 15M', 'VOLSKVAGEN', 'ACTIVO', '2022-07-26 14:47:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chutos`
--

CREATE TABLE `chutos` (
  `chuto_id` int(11) NOT NULL,
  `chuto_idusuario` int(11) NOT NULL,
  `chuto_placa` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `chuto_modelo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `chuto_marca` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `chuto_estado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `chuto_fechacreacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `chutos`
--

INSERT INTO `chutos` (`chuto_id`, `chuto_idusuario`, `chuto_placa`, `chuto_modelo`, `chuto_marca`, `chuto_estado`, `chuto_fechacreacion`) VALUES
(6, 21, '0A-DAA0', '350', 'FORD', 'TALLER', '2022-07-24 14:59:49'),
(7, 21, '044ADA33', 'F-750', 'FORD', 'ACTIVO', '2022-07-24 15:20:47'),
(8, 21, 'DDD32', 'F-450', 'FORD', 'ACTIVO', '2022-07-24 15:31:15'),
(9, 21, 'C455AA', 'SUPER DUTY', 'FORD', 'ACTIVO', '2022-07-24 15:33:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deduccion_nomina`
--

CREATE TABLE `deduccion_nomina` (
  `id_deduccion` int(11) NOT NULL,
  `id_nomina` int(11) NOT NULL,
  `sso` double(6,2) NOT NULL COMMENT 'Seguro Social Obligatorio',
  `paro_forzoso` double(6,2) NOT NULL,
  `lph` double(6,2) NOT NULL COMMENT 'Ley de Politica Habitacional',
  `subtotal` double(7,2) NOT NULL COMMENT 'SubTotal de Deducciones',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deduccion_nomina`
--

INSERT INTO `deduccion_nomina` (`id_deduccion`, `id_nomina`, `sso`, `paro_forzoso`, `lph`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 70, 6.65, 0.83, 1.80, 9.28, '2022-09-06 23:23:38', '2022-09-06 23:23:38'),
(2, 71, 6.65, 0.83, 1.80, 9.28, '2022-09-09 12:25:14', '2022-09-09 12:25:14'),
(4, 73, 14.03, 1.75, 3.80, 19.58, '2022-09-11 03:16:43', '2022-09-11 03:16:43'),
(5, 74, 14.03, 1.75, 3.80, 19.58, '2022-09-12 22:56:43', '2022-09-12 22:56:43'),
(6, 75, 14.03, 1.75, 3.80, 19.58, '2022-09-17 22:28:35', '2022-09-17 22:28:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `idusuario` int(11) NOT NULL,
  `estadod` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`iddepartamento`, `nombre`, `descripcion`, `created_at`, `updated_at`, `idusuario`, `estadod`) VALUES
(1, 'DEPARTAMENTO ADMINISTRATIVO', 'ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA', '2020-10-31 15:25:45', '2022-09-20 21:40:27', 1, 1),
(7, 'DEPARTAMENTO DE SISTEMA', 'ENCARGADOS DEL SOPORTE TÉCNICO', '2020-11-01 12:11:58', '2022-09-20 21:40:27', 1, 1),
(8, 'DEPARTAMENTO DE TRANSPORTE', 'ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ', '2022-07-08 07:38:14', '2022-09-20 21:40:27', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_emp` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `fecha_nac` date NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_emp`, `nombre`, `apellido`, `tipo_documento`, `cedula`, `fecha_nac`, `iddepartamento`, `cargo`, `telefono`, `direccion`, `fecha_ingreso`, `created_at`, `updated_at`) VALUES
(5, 'José', 'Gonzalez', 'Cedula', '29256689', '2000-07-05', 7, 'Sistema', '(416) 658-8998', 'San Josecito', '2022-07-11', '2022-08-25 13:21:17', '2022-08-26 13:35:08'),
(9, 'Gabriel', 'Montilva', 'Cedula', '30159951', '2000-07-05', 1, 'Apoyo', '(424) 782-9126', 'Vega de Aza', '2019-08-25', '2022-08-25 13:21:17', '2022-08-27 00:27:27'),
(10, 'Jose', 'P', 'Cedula', '1115564', '2001-10-16', 1, 'dadasd', '(111) 111-1111', 'adasd', '2022-05-15', '2022-08-25 19:52:25', '2022-08-26 13:34:33'),
(12, 'Pedro', 'Perez', 'RIF', '2313', '0123-03-12', 1, '3123', '(424) 763-3369', 'Caracas', '0123-03-12', '2022-09-05 20:16:21', '2022-09-05 20:16:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fletes`
--

CREATE TABLE `fletes` (
  `flete_id` int(11) NOT NULL,
  `flete_idusuario` int(11) NOT NULL,
  `flete_destino` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `flete_kilometros` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `flete_valor_en_carga` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `flete_valor_sin_carga` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `flete_fechacreacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fletes`
--

INSERT INTO `fletes` (`flete_id`, `flete_idusuario`, `flete_destino`, `flete_kilometros`, `flete_valor_en_carga`, `flete_valor_sin_carga`, `flete_fechacreacion`) VALUES
(15, 1, 'BARINAS', '100', '15.000.000', '2.000.000', '2022-07-26 15:56:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_nomina`
--

CREATE TABLE `pago_nomina` (
  `id_nomina` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `salario_mensual` double(8,2) UNSIGNED NOT NULL,
  `tipo_nomina` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mensual / Quincenal',
  `inicio_pago` date DEFAULT NULL COMMENT 'Fecha de pago Desde',
  `fin_pago` date DEFAULT NULL COMMENT 'Fecha de pago Hasta',
  `total_asignaciones` double(8,2) UNSIGNED NOT NULL,
  `total_deducciones` double(8,2) NOT NULL,
  `total_pago` double(8,2) UNSIGNED NOT NULL,
  `fecha_nomina` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago_nomina`
--

INSERT INTO `pago_nomina` (`id_nomina`, `id_empleado`, `id_usuario`, `salario_mensual`, `tipo_nomina`, `inicio_pago`, `fin_pago`, `total_asignaciones`, `total_deducciones`, `total_pago`, `fecha_nomina`, `created_at`, `updated_at`) VALUES
(70, 5, 1, 180.00, 'mensual', '2022-10-01', '2022-10-31', 164.33, 9.28, 155.05, '2022-09-06 23:23:38', '2022-09-06 23:23:38', '2022-09-06 23:23:38'),
(71, 5, 1, 180.00, 'mensual', '2022-06-01', '2022-07-01', 174.00, 9.28, 164.72, '2022-09-09 12:25:14', '2022-09-09 12:25:14', '2022-09-09 12:25:14'),
(73, 12, 1, 380.00, 'Mensual', '2022-10-01', '2022-10-31', 430.35, 19.58, 410.77, '2022-09-11 03:16:43', '2022-09-11 03:16:43', '2022-09-11 03:16:43'),
(74, 9, 1, 380.00, 'Mensual', '2022-09-01', '2022-10-01', 380.00, 19.58, 360.42, '2022-09-12 22:56:42', '2022-09-12 22:56:42', '2022-09-12 22:56:42'),
(75, 12, 1, 380.00, 'Mensual', '2022-10-01', '2022-10-31', 403.75, 19.58, 384.17, '2022-09-17 22:28:35', '2022-09-17 22:28:35', '2022-09-17 22:28:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Egresos'),
(5, 'Acceso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_log`
--

CREATE TABLE `registros_log` (
  `idregistros_log` int(11) NOT NULL,
  `operacion` varchar(20) DEFAULT NULL,
  `DatosAnteriores` varchar(800) NOT NULL,
  `fecha_mov` date DEFAULT NULL,
  `hora_mov` time DEFAULT NULL,
  `tabla_mov` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `registros_log`
--

INSERT INTO `registros_log` (`idregistros_log`, `operacion`, `DatosAnteriores`, `fecha_mov`, `hora_mov`, `tabla_mov`) VALUES
(338, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-14', '07:07:22', 'usuario --->\r\n\r\nidusuario-> 1'),
(339, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Márquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-14', '07:10:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(340, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO ADMINISTRATIVO---\r\nDescripcion: --> ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA', '2022-07-14', '07:10:32', 'departamento --> iddepartamento: 1'),
(341, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO ADMINISTRATIVOS---\r\nDescripcion: --> ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA', '2022-07-14', '07:10:38', 'departamento --> iddepartamento: 1'),
(342, 'ACTUALIZAR\r\n', 'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración', '2022-07-14', '07:13:52', 'categoria --> idcategoria: 1'),
(343, 'ACTUALIZAR\r\n', 'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración', '2022-07-14', '07:15:19', 'categoria --> idcategoria: 1'),
(344, 'ELIMINAR\r\n', 'Nombre_Cat: Accesorios de Sistemas\r\n --> Descripcion: Todo lo Relacionado con cualquier accesorio Tecnologico', '2022-07-14', '07:15:33', 'categoria --> idcategoria: 2'),
(345, 'ACTUALIZAR', 'nombre: s\r\napellido: s\r\nnum_documento: 1\r\nlogin: aaaa', '2022-07-16', '05:04:06', 'usuario --->\r\n\r\nidusuario-> 20'),
(346, 'ELIMINAR', 'nombre: s\r\napellido: s\r\nnum_documento: 1\r\nlogin: aaaa', '2022-07-16', '05:04:12', 'usuario --->\r\n\r\nidusuario-> 20'),
(347, 'ACTUALIZAR', 'nombre: \r\napellido: \r\nnum_documento: \r\nlogin: ', '2022-07-16', '05:04:16', 'usuario --->\r\n\r\nidusuario-> 19'),
(348, 'ELIMINAR', 'nombre: \r\napellido: \r\nnum_documento: \r\nlogin: ', '2022-07-16', '05:04:20', 'usuario --->\r\n\r\nidusuario-> 19'),
(349, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-21', '09:50:59', 'usuario --->\r\n\r\nidusuario-> 1'),
(350, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '06:41:37', 'usuario --->\r\n\r\nidusuario-> 1'),
(351, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-22', '06:41:43', 'usuario --->\r\n\r\nidusuario-> 21'),
(352, 'ACTUALIZAR', 'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar', '2022-07-22', '06:41:46', 'usuario --->\r\n\r\nidusuario-> 22'),
(353, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '06:59:14', 'usuario --->\r\n\r\nidusuario-> 1'),
(354, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-22', '09:29:47', 'usuario --->\r\n\r\nidusuario-> 21'),
(355, 'ACTUALIZAR', 'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar', '2022-07-22', '09:33:32', 'usuario --->\r\n\r\nidusuario-> 22'),
(356, 'ACTUALIZAR', 'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30134587\r\nlogin: gabriel', '2022-07-22', '10:21:44', 'usuario --->\r\n\r\nidusuario-> 23'),
(357, 'ELIMINAR', 'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30134587\r\nlogin: gabriel', '2022-07-22', '10:21:51', 'usuario --->\r\n\r\nidusuario-> 23'),
(358, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '20:57:21', 'usuario --->\r\n\r\nidusuario-> 1'),
(359, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Márquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:12:55', 'usuario --->\r\n\r\nidusuario-> 1'),
(360, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:18:24', 'usuario --->\r\n\r\nidusuario-> 1'),
(361, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:20:06', 'usuario --->\r\n\r\nidusuario-> 1'),
(362, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:22:01', 'usuario --->\r\n\r\nidusuario-> 1'),
(363, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:23:10', 'usuario --->\r\n\r\nidusuario-> 1'),
(364, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:23:18', 'usuario --->\r\n\r\nidusuario-> 1'),
(365, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:23:26', 'usuario --->\r\n\r\nidusuario-> 1'),
(366, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:23:51', 'usuario --->\r\n\r\nidusuario-> 1'),
(367, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:30:36', 'usuario --->\r\n\r\nidusuario-> 1'),
(368, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:31:33', 'usuario --->\r\n\r\nidusuario-> 1'),
(369, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:31:47', 'usuario --->\r\n\r\nidusuario-> 1'),
(370, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:31:58', 'usuario --->\r\n\r\nidusuario-> 1'),
(371, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:32:22', 'usuario --->\r\n\r\nidusuario-> 1'),
(372, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:33:56', 'usuario --->\r\n\r\nidusuario-> 1'),
(373, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:34:50', 'usuario --->\r\n\r\nidusuario-> 1'),
(374, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:38:15', 'usuario --->\r\n\r\nidusuario-> 1'),
(375, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:40:03', 'usuario --->\r\n\r\nidusuario-> 1'),
(376, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:41:42', 'usuario --->\r\n\r\nidusuario-> 1'),
(377, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-22', '21:43:44', 'usuario --->\r\n\r\nidusuario-> 1'),
(378, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-23', '01:44:49', 'usuario --->\r\n\r\nidusuario-> 1'),
(379, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-23', '01:45:06', 'usuario --->\r\n\r\nidusuario-> 1'),
(380, 'ACTUALIZAR', 'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-23', '01:45:24', 'usuario --->\r\n\r\nidusuario-> 1'),
(381, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-23', '03:19:29', 'usuario --->\r\n\r\nidusuario-> 1'),
(382, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-23', '04:31:54', 'usuario --->\r\n\r\nidusuario-> 1'),
(383, 'ACTUALIZAR', 'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar', '2022-07-23', '04:36:55', 'usuario --->\r\n\r\nidusuario-> 22'),
(384, 'ACTUALIZAR', 'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar', '2022-07-23', '04:39:33', 'usuario --->\r\n\r\nidusuario-> 22'),
(386, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO DE PRUEBAS---\r\nDescripcion: --> DEPARTAMENTO ENCARGADO DE LAS PRUEBAS', '2022-07-23', '06:06:43', 'departamento --> iddepartamento: 9'),
(387, 'ELIMINAR', 'Nombre_Departamento: DEPARTAMENTO DE PRUEBAS---\r\n --> Descripcion: DEPARTAMENTO ENCARGADO DE LAS PRUEBA', '2022-07-23', '06:06:46', 'departamento --> iddepartamento: 9'),
(388, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ', '2022-07-23', '06:07:07', 'departamento --> iddepartamento: 8'),
(389, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ', '2022-07-23', '06:07:11', 'departamento --> iddepartamento: 8'),
(390, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ', '2022-07-23', '06:07:16', 'departamento --> iddepartamento: 8'),
(391, 'ACTUALIZAR', 'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ', '2022-07-23', '06:07:36', 'departamento --> iddepartamento: 8'),
(392, 'ELIMINAR', 'Nombre_Departamento: SSSSS---\r\n --> Descripcion: SSSSSSS', '2022-07-23', '06:43:01', 'departamento --> iddepartamento: 10'),
(393, 'ACTUALIZAR\r\n', 'Nombre_Cat: AAAAAA\r\n --> Descripcion: SSSSSSS', '2022-07-23', '09:59:14', 'categoria --> idcategoria: 5'),
(394, 'ACTUALIZAR\r\n', 'Nombre_Cat: S\r\n --> Descripcion: SSSSSSS', '2022-07-23', '09:59:14', 'categoria --> idcategoria: 5'),
(395, 'ELIMINAR\r\n', 'Nombre_Cat: S\r\n --> Descripcion: SSSSSSS', '2022-07-23', '09:59:16', 'categoria --> idcategoria: 5'),
(396, 'ACTUALIZAR\r\n', 'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración', '2022-07-24', '08:38:50', 'categoria --> idcategoria: 1'),
(397, 'ACTUALIZAR\r\n', 'Nombre_Cat: ARTICULO DE OFICINA\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración', '2022-07-24', '08:38:50', 'categoria --> idcategoria: 1'),
(398, 'ACTUALIZAR\r\n', 'Nombre_Cat: DD\r\n --> Descripcion: DDDDD', '2022-07-24', '08:39:01', 'categoria --> idcategoria: 6'),
(399, 'ACTUALIZAR\r\n', 'Nombre_Cat: DD\r\n --> Descripcion: DDDDD', '2022-07-24', '08:39:05', 'categoria --> idcategoria: 6'),
(400, 'ELIMINAR\r\n', 'Nombre_Cat: DD\r\n --> Descripcion: DDDDD', '2022-07-24', '08:39:08', 'categoria --> idcategoria: 6'),
(401, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '13:32:52', 'usuario --->\r\n\r\nidusuario-> 1'),
(402, 'ACTUALIZAR', 'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '13:33:10', 'usuario --->\r\n\r\nidusuario-> 1'),
(403, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:01:08', 'usuario --->\r\n\r\nidusuario-> 1'),
(404, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:02:43', 'usuario --->\r\n\r\nidusuario-> 1'),
(405, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:30:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(406, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:45:38', 'usuario --->\r\n\r\nidusuario-> 1'),
(407, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:48:26', 'usuario --->\r\n\r\nidusuario-> 1'),
(408, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:49:32', 'usuario --->\r\n\r\nidusuario-> 1'),
(409, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:50:11', 'usuario --->\r\n\r\nidusuario-> 1'),
(410, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:50:17', 'usuario --->\r\n\r\nidusuario-> 1'),
(411, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:50:22', 'usuario --->\r\n\r\nidusuario-> 1'),
(412, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:50:42', 'usuario --->\r\n\r\nidusuario-> 1'),
(413, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:52:50', 'usuario --->\r\n\r\nidusuario-> 1'),
(414, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:52:53', 'usuario --->\r\n\r\nidusuario-> 1'),
(415, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:54:45', 'usuario --->\r\n\r\nidusuario-> 1'),
(416, 'ACTUALIZAR', 'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:54:52', 'usuario --->\r\n\r\nidusuario-> 1'),
(417, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:55:58', 'usuario --->\r\n\r\nidusuario-> 1'),
(418, 'ACTUALIZAR', 'nombre: Islender Denilso\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:56:02', 'usuario --->\r\n\r\nidusuario-> 1'),
(419, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:56:05', 'usuario --->\r\n\r\nidusuario-> 1'),
(420, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-07-24', '14:56:17', 'usuario --->\r\n\r\nidusuario-> 1'),
(421, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-26', '16:08:07', 'usuario --->\r\n\r\nidusuario-> 21'),
(422, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-26', '16:08:42', 'usuario --->\r\n\r\nidusuario-> 21'),
(423, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-26', '16:08:49', 'usuario --->\r\n\r\nidusuario-> 21'),
(424, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-26', '16:09:50', 'usuario --->\r\n\r\nidusuario-> 21'),
(425, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-07-26', '16:13:20', 'usuario --->\r\n\r\nidusuario-> 21'),
(426, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-17', '23:22:37', 'usuario --->\r\n\r\nidusuario-> 1'),
(427, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-17', '23:23:25', 'usuario --->\r\n\r\nidusuario-> 1'),
(428, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '17:59:11', 'usuario --->\r\n\r\nidusuario-> 1'),
(429, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '18:01:57', 'usuario --->\r\n\r\nidusuario-> 1'),
(430, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '18:02:07', 'usuario --->\r\n\r\nidusuario-> 1'),
(431, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '18:03:27', 'usuario --->\r\n\r\nidusuario-> 1'),
(432, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '18:04:44', 'usuario --->\r\n\r\nidusuario-> 1'),
(433, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '18:04:51', 'usuario --->\r\n\r\nidusuario-> 1'),
(434, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:11:27', 'usuario --->\r\n\r\nidusuario-> 1'),
(435, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:12:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(436, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:22:28', 'usuario --->\r\n\r\nidusuario-> 1'),
(437, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:23:45', 'usuario --->\r\n\r\nidusuario-> 1'),
(438, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:27:51', 'usuario --->\r\n\r\nidusuario-> 1'),
(439, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:28:00', 'usuario --->\r\n\r\nidusuario-> 1'),
(440, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:28:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(441, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:28:16', 'usuario --->\r\n\r\nidusuario-> 1'),
(442, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:30:42', 'usuario --->\r\n\r\nidusuario-> 1'),
(443, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:31:30', 'usuario --->\r\n\r\nidusuario-> 1'),
(444, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:34:56', 'usuario --->\r\n\r\nidusuario-> 1'),
(445, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:35:10', 'usuario --->\r\n\r\nidusuario-> 1'),
(446, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:35:49', 'usuario --->\r\n\r\nidusuario-> 1'),
(447, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '21:39:11', 'usuario --->\r\n\r\nidusuario-> 1'),
(448, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-20', '22:51:50', 'usuario --->\r\n\r\nidusuario-> 1'),
(449, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '11:57:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(450, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '11:57:31', 'usuario --->\r\n\r\nidusuario-> 1'),
(451, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '11:58:39', 'usuario --->\r\n\r\nidusuario-> 1'),
(452, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:00:11', 'usuario --->\r\n\r\nidusuario-> 1'),
(453, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:00:27', 'usuario --->\r\n\r\nidusuario-> 1'),
(454, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:00:51', 'usuario --->\r\n\r\nidusuario-> 1'),
(455, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:01:04', 'usuario --->\r\n\r\nidusuario-> 1'),
(456, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:01:40', 'usuario --->\r\n\r\nidusuario-> 1'),
(457, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:02:37', 'usuario --->\r\n\r\nidusuario-> 1'),
(458, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:03:01', 'usuario --->\r\n\r\nidusuario-> 1'),
(459, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:04:42', 'usuario --->\r\n\r\nidusuario-> 1'),
(460, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-21', '12:05:09', 'usuario --->\r\n\r\nidusuario-> 1'),
(461, 'ACTUALIZAR', 'nombre: Prueba Laravel\r\napellido: 1.0\r\nnum_documento: 111111\r\nlogin: prueba', '2022-08-22', '18:54:15', 'usuario --->\r\n\r\nidusuario-> 25'),
(462, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-22', '19:49:07', 'usuario --->\r\n\r\nidusuario-> 1'),
(463, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-22', '19:56:57', 'usuario --->\r\n\r\nidusuario-> 1'),
(464, 'ACTUALIZAR', 'nombre: Prueba Laravel\r\napellido: 1.0\r\nnum_documento: 111111\r\nlogin: prueba', '2022-08-22', '21:30:38', 'usuario --->\r\n\r\nidusuario-> 25'),
(465, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-08-22', '21:33:27', 'usuario --->\r\n\r\nidusuario-> 21'),
(466, 'ACTUALIZAR', 'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar', '2022-08-22', '21:36:27', 'usuario --->\r\n\r\nidusuario-> 22'),
(467, 'ACTUALIZAR', 'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriel', '2022-08-22', '21:36:32', 'usuario --->\r\n\r\nidusuario-> 24'),
(468, 'ACTUALIZAR', 'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose', '2022-08-22', '21:37:03', 'usuario --->\r\n\r\nidusuario-> 21'),
(474, 'ACTUALIZAR', 'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriel', '2022-08-22', '23:15:45', 'usuario --->\r\n\r\nidusuario-> 24'),
(475, 'ACTUALIZAR', 'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriels', '2022-08-22', '23:15:56', 'usuario --->\r\n\r\nidusuario-> 24'),
(482, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '15:02:15', 'usuario --->\r\n\r\nidusuario-> 1'),
(483, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '15:02:33', 'usuario --->\r\n\r\nidusuario-> 1'),
(484, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '17:21:39', 'usuario --->\r\n\r\nidusuario-> 1'),
(485, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '17:24:55', 'usuario --->\r\n\r\nidusuario-> 1'),
(486, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '17:25:04', 'usuario --->\r\n\r\nidusuario-> 1'),
(487, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-23', '17:26:08', 'usuario --->\r\n\r\nidusuario-> 1'),
(488, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:13:15', 'usuario --->\r\n\r\nidusuario-> 28'),
(489, 'ACTUALIZAR', 'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros', '2022-08-24', '20:16:29', 'usuario --->\r\n\r\nidusuario-> 27'),
(490, 'ACTUALIZAR', 'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros', '2022-08-24', '20:16:34', 'usuario --->\r\n\r\nidusuario-> 27'),
(491, 'ACTUALIZAR', 'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros', '2022-08-24', '20:17:15', 'usuario --->\r\n\r\nidusuario-> 27'),
(492, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:48:06', 'usuario --->\r\n\r\nidusuario-> 28'),
(493, 'ACTUALIZAR', 'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros', '2022-08-24', '20:48:17', 'usuario --->\r\n\r\nidusuario-> 27'),
(494, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:51:16', 'usuario --->\r\n\r\nidusuario-> 28'),
(495, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:52:44', 'usuario --->\r\n\r\nidusuario-> 28'),
(496, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:52:47', 'usuario --->\r\n\r\nidusuario-> 28'),
(497, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:53:18', 'usuario --->\r\n\r\nidusuario-> 28'),
(498, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:53:26', 'usuario --->\r\n\r\nidusuario-> 28'),
(499, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:54:50', 'usuario --->\r\n\r\nidusuario-> 28'),
(500, 'ACTUALIZAR', 'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro', '2022-08-24', '20:54:53', 'usuario --->\r\n\r\nidusuario-> 28'),
(501, 'ACTUALIZAR', 'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 444866622\r\nlogin: borrarss', '2022-08-24', '21:09:11', 'usuario --->\r\n\r\nidusuario-> 33'),
(502, 'ELIMINAR', 'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 444866622\r\nlogin: borrarss', '2022-08-24', '21:09:17', 'usuario --->\r\n\r\nidusuario-> 33'),
(503, 'ACTUALIZAR', 'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 4448666\r\nlogin: borrar', '2022-08-24', '21:09:29', 'usuario --->\r\n\r\nidusuario-> 29'),
(504, 'ELIMINAR', 'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 4448666\r\nlogin: borrar', '2022-08-24', '21:09:34', 'usuario --->\r\n\r\nidusuario-> 29'),
(505, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-25', '20:51:25', 'usuario --->\r\n\r\nidusuario-> 1'),
(506, 'ACTUALIZAR', 'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin', '2022-08-26', '12:41:30', 'usuario --->\r\n\r\nidusuario-> 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salario_base`
--

CREATE TABLE `salario_base` (
  `salario_base_id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `salario` varchar(15) NOT NULL COMMENT 'Aqui se puede trabajar en base al salario base, y deducciones de los pagos, el id numero uno de esta tabla va hacer el principal para el salario base',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salario_base`
--

INSERT INTO `salario_base` (`salario_base_id`, `id_usuario`, `salario`, `created_at`, `updated_at`) VALUES
(1, 1, '380', '2022-09-03 23:11:54', '2022-09-11 03:11:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sueldos`
--

CREATE TABLE `sueldos` (
  `id_sueldos` int(11) NOT NULL,
  `sueldo_base` double(8,2) UNSIGNED NOT NULL,
  `fecha_sueldo` date NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sueldos`
--

INSERT INTO `sueldos` (`id_sueldos`, `sueldo_base`, `fecha_sueldo`, `estado`) VALUES
(5, 136544.34, '2022-09-04', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idtipousuario` int(11) NOT NULL,
  `nombre_t` varchar(45) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `idusuario` varchar(45) COLLATE utf8_bin NOT NULL,
  `estadot` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idtipousuario`, `nombre_t`, `descripcion`, `created_at`, `idusuario`, `estadot`, `updated_at`) VALUES
(1, 'ADMINISTRADOR', 'CON PRIVILEGIOS DE GESTIONAR TODO EL SISTEMA', '2020-10-31 15:27:02', '1', 1, '2022-08-24 23:02:29'),
(5, 'DEPOSITARIO', 'ENCARGADOS DEL INVENTARIO DE LA INSTITUCIÓN', '2020-11-01 12:15:17', '1', 1, '2022-08-24 23:02:29'),
(7, 'SISTEMAS', 'ENCARGADO DEL SISTEMA Y TIENE PRIVILEGIOS SIMILARES AL ADMINISTRADOR', '2020-11-01 12:09:09', '1', 1, '2022-08-24 23:02:29'),
(8, 'CHOFER', 'ENCARGADOS DE HACER USO DEL TRANSPORTE DE LA EMPRESA', '2022-07-08 07:40:38', '1', 1, '2022-08-24 23:02:29'),
(9, 'ADMINISTRATIVO', 'NOMINAS, VIAJESss', '2022-07-22 13:50:00', '1', 1, '2022-08-24 23:37:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `idtipousuario` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `idtipousuario`, `iddepartamento`, `password`, `remember_token`, `imagen`, `condicion`, `created_at`, `updated_at`) VALUES
(1, 'Islender Denilson', 'Montilva Marquez', 'Cedula', '28195178', 'San Josecito', '(424) 765-0285', 'islenderdenilson@gmail.com', 'ADMINISTRADOR', 'admin', 1, 1, '$2y$10$mRR/J9g.SPg2XaBfrftS7.65COnn1HPS8wxeLlNMF9T0HBWZ9aaBm', '', '1661283153-1635476098.png', 1, '2022-08-17 13:06:32', '2022-08-26 13:11:30'),
(21, 'Jose Manuel', 'Gonzalez', 'RIF', '30145587', 'San Josecito', '(424) 777-7777', 'joseinvestigue@gmail.com', 'Sistema', 'jose', 9, 1, '8df6a5a36dd94925883e78879c6a3721af43d6880c3da6c53ed47234f665047c', '', '1661220207-3123.jpg', 1, '2022-08-17 13:06:32', '2022-08-22 22:07:03'),
(22, 'Cesar', 'Colmenares', 'Cedula', '28195144', 'La E.................---', '(424) 589-6552', 'cesarcolmenares@gmail.com', 'Administrativos', 'Cesar', 5, 1, '63d1a75b61a05d3c76c840449a47f888c81260982cb8a7dd7b5ea9aaa7c63539', '', 'user_icon_default.png', 1, '2022-08-17 13:06:32', '2022-08-17 13:06:32'),
(24, 'Gabriel', 'Montilva', 'Cedula', '30159951', 'Vega de Aza', '(424) 765-0285', 'gmontilva@gmail.com', 'APOYO', 'gabriel', 1, 7, '142b1770f7426daaf0a03c03afbc3fe6c023de163a31b5d87517cf78d16dffdb', '', 'user_icon_default.png', 1, '2022-08-17 13:06:32', '2022-08-22 23:45:56'),
(25, 'Prueba Laravel', '1.0', 'Cedula', '111111', 'asdadad', '(063) 052-____', 'asdad@gmail.com', 'aaa', 'prueba', 1, 1, '123', '', '1661220038-lagarra.png', 1, '2022-08-17 14:10:51', '2022-08-22 22:00:38'),
(26, 'aa', 'aaa', 'Cedula', '222321', 'aaaa', '(323) 232-323_', 'aa@aa.caa', 'adasd', 'pruebasss', 1, 1, '$2y$10$nkKnqJOOGsyrD5k4CC1V2OfLQpJ4mN3ydv3e65p1ejHYoQhjOPY.G', 'NULL', 'user_icon_default.png', 1, '2022-08-24 00:42:25', '2022-08-24 00:42:25'),
(27, 'Pedro', 'Perez', 'Cedula', '1115564', 'Caracas', '(424) 744-6555', 'pedro@g.com', 'Analista', 'pedros', 1, 7, '$2y$10$sZbPFfde/LBtjLcKRc8TTO1xwOMHk4/Snb2IZq1WbxZvKgv6MWCsm', '3UH3V1oJRoBWgjjuPAOVLA2wLSoF2zxnWuCw3xZqI48LpMWFZswRNxAY8tYS', 'user_icon_default.png', 1, '2022-08-24 00:44:52', '2022-08-24 21:18:17'),
(28, 'aaa', 'Perez', 'Cedula', '3333', 'Caracasaa', '(111) 445-____', 'asas@a.com', 'addd', 'otro', 1, 1, '$2y$10$Ff5jWHS53WwgQ7/Fll.J4.rW8HXuVg.hleL26pcT18jzEAnc9ktQW', 'NULL', 'user_icon_default.png', 0, '2022-08-24 13:59:36', '2022-08-24 21:24:53'),
(34, 'asdsad', 'asdda', 'Cedula', '231231', '3123123sd', '(123) 123-123_', 'nnn@dad.com', 'adsdada', 'aaa', 1, 1, '$2y$10$cRmDx87wNhZPy.mcTH8/wePcqqMeOol9jhxzYK1FUUBN8DOk/zsoK', 'NULL', 'user_icon_default.png', 1, '2022-08-25 22:55:06', '2022-08-25 22:55:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(1310, 22, 1),
(1311, 22, 2),
(1312, 22, 3),
(1313, 22, 4),
(1314, 22, 5),
(1386, 1, 1),
(1387, 1, 2),
(1388, 1, 3),
(1389, 1, 4),
(1390, 1, 5),
(1399, 25, 1),
(1400, 25, 2),
(1401, 25, 3),
(1402, 25, 4),
(1403, 25, 5),
(1409, 21, 1),
(1410, 21, 2),
(1411, 21, 3),
(1412, 21, 4),
(1413, 21, 5),
(1414, 24, 1),
(1415, 24, 3),
(1416, 24, 5),
(1417, 28, 1),
(1418, 28, 2),
(1419, 28, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idalmacen`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `fk_articulo_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `asignacion_nomina`
--
ALTER TABLE `asignacion_nomina`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `asignacion_nomina_ibfk_2` (`id_nomina`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`idbitacora`),
  ADD KEY `fk_usuario_bitacora_idx` (`idusuario`);

--
-- Indices de la tabla `cavas`
--
ALTER TABLE `cavas`
  ADD PRIMARY KEY (`cava_id`),
  ADD KEY `camiones_ibfk_1` (`cava_idusuario`);

--
-- Indices de la tabla `chutos`
--
ALTER TABLE `chutos`
  ADD PRIMARY KEY (`chuto_id`),
  ADD KEY `camiones_ibfk_1` (`chuto_idusuario`);

--
-- Indices de la tabla `deduccion_nomina`
--
ALTER TABLE `deduccion_nomina`
  ADD PRIMARY KEY (`id_deduccion`),
  ADD KEY `deduccion_nomina_ibfk_1` (`id_nomina`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_emp`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`),
  ADD KEY `fk_empleado_departamento_idx` (`iddepartamento`);

--
-- Indices de la tabla `fletes`
--
ALTER TABLE `fletes`
  ADD PRIMARY KEY (`flete_id`),
  ADD KEY `camiones_ibfk_1` (`flete_idusuario`);

--
-- Indices de la tabla `pago_nomina`
--
ALTER TABLE `pago_nomina`
  ADD PRIMARY KEY (`id_nomina`),
  ADD KEY `pago_nomina_ibfk_1` (`id_empleado`),
  ADD KEY `pago_nomina_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `registros_log`
--
ALTER TABLE `registros_log`
  ADD PRIMARY KEY (`idregistros_log`);

--
-- Indices de la tabla `salario_base`
--
ALTER TABLE `salario_base`
  ADD PRIMARY KEY (`salario_base_id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  ADD PRIMARY KEY (`id_sueldos`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idtipousuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`),
  ADD UNIQUE KEY `num_documento` (`num_documento`),
  ADD KEY `fk_usuario_tipousuario_idx` (`idtipousuario`),
  ADD KEY `fk_usuario_departamento_idx` (`iddepartamento`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_u_permiso_usuario_idx` (`idusuario`),
  ADD KEY `fk_usuario_permiso_idx` (`idpermiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idalmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `asignacion_nomina`
--
ALTER TABLE `asignacion_nomina`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `idbitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=556;

--
-- AUTO_INCREMENT de la tabla `cavas`
--
ALTER TABLE `cavas`
  MODIFY `cava_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `chutos`
--
ALTER TABLE `chutos`
  MODIFY `chuto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `deduccion_nomina`
--
ALTER TABLE `deduccion_nomina`
  MODIFY `id_deduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `fletes`
--
ALTER TABLE `fletes`
  MODIFY `flete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `pago_nomina`
--
ALTER TABLE `pago_nomina`
  MODIFY `id_nomina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `registros_log`
--
ALTER TABLE `registros_log`
  MODIFY `idregistros_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=507;

--
-- AUTO_INCREMENT de la tabla `salario_base`
--
ALTER TABLE `salario_base`
  MODIFY `salario_base_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  MODIFY `id_sueldos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idtipousuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1420;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignacion_nomina`
--
ALTER TABLE `asignacion_nomina`
  ADD CONSTRAINT `asignacion_nomina_ibfk_2` FOREIGN KEY (`id_nomina`) REFERENCES `pago_nomina` (`id_nomina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_bitacora_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cavas`
--
ALTER TABLE `cavas`
  ADD CONSTRAINT `cavas_ibfk_1` FOREIGN KEY (`cava_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `chutos`
--
ALTER TABLE `chutos`
  ADD CONSTRAINT `chutos_ibfk_1` FOREIGN KEY (`chuto_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `deduccion_nomina`
--
ALTER TABLE `deduccion_nomina`
  ADD CONSTRAINT `deduccion_nomina_ibfk_1` FOREIGN KEY (`id_nomina`) REFERENCES `pago_nomina` (`id_nomina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_departamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fletes`
--
ALTER TABLE `fletes`
  ADD CONSTRAINT `fletes_ibfk_1` FOREIGN KEY (`flete_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago_nomina`
--
ALTER TABLE `pago_nomina`
  ADD CONSTRAINT `pago_nomina_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_emp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_nomina_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salario_base`
--
ALTER TABLE `salario_base`
  ADD CONSTRAINT `salario_base_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_departamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_tipousuario` FOREIGN KEY (`idtipousuario`) REFERENCES `tipousuario` (`idtipousuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_u_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
