-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 06:42:23
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
  time_zone = "+00:00";
  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;
--
  -- Base de datos: `la_garra_predefensa`
  --
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `almacen`
  --
INSERT INTO
  `almacen` (
    `idalmacen`,
    `idusuario`,
    `codigo`,
    `marca`,
    `nombre`,
    `stock`,
    `descripcion`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    46,
    1,
    '21312',
    'Listo',
    'XD',
    22,
    'fff',
    '2022-09-13 00:00:00',
    '2022-09-20 19:48:54'
  ),
  (
    47,
    21,
    '321222',
    'Ya Funciona',
    'dasda',
    213,
    'dasdad',
    '2022-09-14 06:59:39',
    '2022-09-20 19:49:17'
  ),
  (
    48,
    1,
    '123554',
    'Goodyear',
    'Caucho',
    4,
    'Ring 20',
    '2022-09-20 00:57:59',
    '2022-09-20 00:57:59'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `asignacion_nomina`
  --
  CREATE TABLE `asignacion_nomina` (
    `id_asignacion` int(11) NOT NULL,
    `id_nomina` int(11) NOT NULL,
    `dias_lab` int(11) UNSIGNED NOT NULL,
    `pagos_diasLab` double(7, 2) UNSIGNED NOT NULL,
    `dias_libres` int(11) UNSIGNED NOT NULL,
    `pagos_DiaLib` double(7, 2) UNSIGNED NOT NULL,
    `horas_extra_diurna` int(11) UNSIGNED NOT NULL,
    `pago_hr_extraD` double(7, 2) UNSIGNED NOT NULL,
    `horas_extra_noc` int(11) UNSIGNED NOT NULL,
    `pago_hr_extra_noc` double(7, 2) UNSIGNED NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
  -- Volcado de datos para la tabla `asignacion_nomina`
  --
INSERT INTO
  `asignacion_nomina` (
    `id_asignacion`,
    `id_nomina`,
    `dias_lab`,
    `pagos_diasLab`,
    `dias_libres`,
    `pagos_DiaLib`,
    `horas_extra_diurna`,
    `pago_hr_extraD`,
    `horas_extra_noc`,
    `pago_hr_extra_noc`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    70,
    20,
    120.00,
    6,
    36.00,
    5,
    5.62,
    2,
    2.70,
    '2022-09-06 23:23:38',
    '2022-09-06 23:23:38'
  ),
  (
    2,
    71,
    20,
    120.00,
    6,
    36.00,
    10,
    11.25,
    5,
    6.75,
    '2022-09-09 12:25:14',
    '2022-09-09 12:25:14'
  ),
  (
    4,
    73,
    25,
    316.67,
    5,
    63.33,
    14,
    33.25,
    6,
    17.10,
    '2022-09-11 03:16:43',
    '2022-09-11 03:16:43'
  ),
  (
    5,
    74,
    23,
    291.33,
    7,
    88.67,
    0,
    0.00,
    0,
    0.00,
    '2022-09-12 22:56:43',
    '2022-09-12 22:56:43'
  ),
  (
    6,
    75,
    20,
    253.33,
    10,
    126.67,
    4,
    9.50,
    5,
    14.25,
    '2022-09-17 22:28:35',
    '2022-09-17 22:28:35'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `audits`
  --
  CREATE TABLE `audits` (
    `id` bigint(20) UNSIGNED NOT NULL,
    `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `auditable_id` bigint(20) UNSIGNED NOT NULL,
    `old_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `new_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
  -- Volcado de datos para la tabla `audits`
  --
INSERT INTO
  `audits` (
    `id`,
    `user_type`,
    `user_id`,
    `event`,
    `auditable_type`,
    `auditable_id`,
    `old_values`,
    `new_values`,
    `url`,
    `ip_address`,
    `user_agent`,
    `tags`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    5,
    'App\\Models\\Usuario',
    1,
    'created',
    'App\\Models\\Usuario',
    37,
    '[]',
    '{\"nombre\":\"prueba\",\"apellido\":\"123123\",\"tipo_documento\":\"Cedula\",\"num_documento\":\"213123213\",\"direccion\":\"adadad\",\"telefono\":\"(323) 232-323_\",\"email\":\"13123123@fsdfs.com\",\"cargo\":\"123312312\",\"login\":\"12312gda\",\"idtipousuario\":\"1\",\"iddepartamento\":\"1\",\"password\":\"$2y$10$pES\\/Wrbfrkji.CrRWbBYl.T68Ia.h7WlhzFKHqa477ZuHB.Q5Ddhq\",\"remember_token\":\"NULL\",\"imagen\":\"user_icon_default.png\",\"condicion\":\"1\",\"idusuario\":37}',
    'http://localhost/primera%20prueba%20git/laGarra1/public/crear_usuario?apellido_a=123123&cargo_a=123312312&clave_a=123123213&direccion_a=adadad&email_a=13123123%40fsdfs.com&iddepartamento_a=1&idtipousuario_a=1&login_a=12312gda&nombre_a=prueba&num_documento_a=213123213&permiso%5B0%5D=1&permiso%5B1%5D=2&telefono_a=%28323%29%20232-323_&tipo_documento_a=Cedula',
    '::1',
    'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
    NULL,
    '2022-10-09 06:02:37',
    '2022-10-09 06:02:37'
  ),
  (
    6,
    'App\\Models\\Usuario',
    1,
    'created',
    'App\\Models\\UsuarioPermiso',
    1420,
    '[]',
    '{\"idusuario\":37,\"idpermiso\":\"1\",\"idusuario_permiso\":1420}',
    'http://localhost/primera%20prueba%20git/laGarra1/public/crear_usuario?apellido_a=123123&cargo_a=123312312&clave_a=123123213&direccion_a=adadad&email_a=13123123%40fsdfs.com&iddepartamento_a=1&idtipousuario_a=1&login_a=12312gda&nombre_a=prueba&num_documento_a=213123213&permiso%5B0%5D=1&permiso%5B1%5D=2&telefono_a=%28323%29%20232-323_&tipo_documento_a=Cedula',
    '::1',
    'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
    NULL,
    '2022-10-09 06:02:37',
    '2022-10-09 06:02:37'
  ),
  (
    7,
    'App\\Models\\Usuario',
    1,
    'created',
    'App\\Models\\UsuarioPermiso',
    1421,
    '[]',
    '{\"idusuario\":37,\"idpermiso\":\"2\",\"idusuario_permiso\":1421}',
    'http://localhost/primera%20prueba%20git/laGarra1/public/crear_usuario?apellido_a=123123&cargo_a=123312312&clave_a=123123213&direccion_a=adadad&email_a=13123123%40fsdfs.com&iddepartamento_a=1&idtipousuario_a=1&login_a=12312gda&nombre_a=prueba&num_documento_a=213123213&permiso%5B0%5D=1&permiso%5B1%5D=2&telefono_a=%28323%29%20232-323_&tipo_documento_a=Cedula',
    '::1',
    'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
    NULL,
    '2022-10-09 06:02:37',
    '2022-10-09 06:02:37'
  ),
  (
    8,
    'App\\Models\\Usuario',
    1,
    'updated',
    'App\\Models\\Usuario',
    37,
    '{\"condicion\":1}',
    '{\"condicion\":0}',
    'http://localhost/primera%20prueba%20git/laGarra1/public/desactivar_usuario',
    '::1',
    'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
    NULL,
    '2022-10-09 06:03:34',
    '2022-10-09 06:03:34'
  ),
  (
    9,
    'App\\Models\\Usuario',
    1,
    'deleted',
    'App\\Models\\Usuario',
    37,
    '{\"idusuario\":37,\"nombre\":\"prueba\",\"apellido\":\"123123\",\"tipo_documento\":\"Cedula\",\"num_documento\":\"213123213\",\"direccion\":\"adadad\",\"telefono\":\"(323) 232-323_\",\"email\":\"13123123@fsdfs.com\",\"cargo\":\"123312312\",\"login\":\"12312gda\",\"idtipousuario\":1,\"iddepartamento\":1,\"password\":\"$2y$10$pES\\/Wrbfrkji.CrRWbBYl.T68Ia.h7WlhzFKHqa477ZuHB.Q5Ddhq\",\"remember_token\":\"NULL\",\"imagen\":\"user_icon_default.png\",\"condicion\":0}',
    '[]',
    'http://localhost/primera%20prueba%20git/laGarra1/public/eliminar_usuario',
    '::1',
    'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
    NULL,
    '2022-10-09 06:03:52',
    '2022-10-09 06:03:52'
  );
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
    `cava_asignada` int(11) NOT NULL DEFAULT 0 COMMENT '0 sin asignar, 1 asignado',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;
--
  -- Volcado de datos para la tabla `cavas`
  --
INSERT INTO
  `cavas` (
    `cava_id`,
    `cava_idusuario`,
    `cava_placa`,
    `cava_modelo`,
    `cava_marca`,
    `cava_estado`,
    `cava_asignada`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    10,
    1,
    '000AA3',
    'GANDOLA 15M',
    'VOLSKVAGEN',
    'ACTIVO',
    1,
    '2022-07-26 14:47:29',
    '2022-10-05 23:20:06'
  ),
  (
    11,
    1,
    'DDDa',
    'dadad',
    '21313',
    'ACTIVO',
    1,
    '2022-09-21 21:24:56',
    '2022-10-07 01:43:31'
  ),
  (
    12,
    1,
    'elmen123',
    'Grande',
    'Nose',
    'ACTIVO',
    0,
    '2022-09-24 20:56:43',
    '2022-09-30 20:43:33'
  ),
  (
    13,
    1,
    '147ACAD',
    'Volock',
    'Carga',
    'ACTIVO',
    1,
    '2022-09-27 00:41:13',
    '2022-10-06 21:53:08'
  ),
  (
    14,
    1,
    '233648',
    '44-6',
    'ColCo',
    'ACTIVO',
    0,
    '2022-09-27 00:41:46',
    '2022-09-30 20:43:05'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `choferes`
  --
  CREATE TABLE `choferes` (
    `chofer_id` int(11) NOT NULL,
    `chofer_idempleado` int(11) NOT NULL,
    `chofer_estado` int(11) NOT NULL DEFAULT 0 COMMENT '0 Disponible, 1 asignado',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Volcado de datos para la tabla `choferes`
  --
INSERT INTO
  `choferes` (
    `chofer_id`,
    `chofer_idempleado`,
    `chofer_estado`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    8,
    14,
    1,
    '2022-09-23 22:45:50',
    '2022-10-07 01:43:31'
  ),
  (
    9,
    10,
    0,
    '2022-09-23 22:46:13',
    '2022-10-04 19:12:10'
  ),
  (
    10,
    12,
    1,
    '2022-09-24 20:56:09',
    '2022-10-06 21:53:08'
  ),
  (
    11,
    19,
    0,
    '2022-09-27 00:39:07',
    '2022-09-30 20:43:05'
  ),
  (
    12,
    20,
    1,
    '2022-09-27 00:40:02',
    '2022-10-05 23:20:06'
  );
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
    `chuto_asignado` int(11) NOT NULL DEFAULT 0 COMMENT '0 sin asignar, 1 asignado',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;
--
  -- Volcado de datos para la tabla `chutos`
  --
INSERT INTO
  `chutos` (
    `chuto_id`,
    `chuto_idusuario`,
    `chuto_placa`,
    `chuto_modelo`,
    `chuto_marca`,
    `chuto_estado`,
    `chuto_asignado`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    6,
    21,
    '0A-DAA0',
    '350',
    'FORD',
    'ACTIVO',
    1,
    '2022-07-24 14:59:49',
    '2022-10-07 01:43:31'
  ),
  (
    7,
    21,
    '044ADA33',
    'F-750',
    'FORD',
    'ACTIVO',
    1,
    '2022-07-24 15:20:47',
    '2022-10-06 21:53:08'
  ),
  (
    8,
    21,
    'DDD32',
    'F-450',
    'FORD',
    'ACTIVO',
    1,
    '2022-07-24 15:31:15',
    '2022-10-05 23:20:06'
  ),
  (
    9,
    21,
    'C455AA',
    'SUPER DUTY',
    'FORD',
    'ACTIVO',
    0,
    '2022-07-24 15:33:41',
    '2022-10-03 00:49:53'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `deduccion_nomina`
  --
  CREATE TABLE `deduccion_nomina` (
    `id_deduccion` int(11) NOT NULL,
    `id_nomina` int(11) NOT NULL,
    `sso` double(6, 2) NOT NULL COMMENT 'Seguro Social Obligatorio',
    `paro_forzoso` double(6, 2) NOT NULL,
    `lph` double(6, 2) NOT NULL COMMENT 'Ley de Politica Habitacional',
    `subtotal` double(7, 2) NOT NULL COMMENT 'SubTotal de Deducciones',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
  -- Volcado de datos para la tabla `deduccion_nomina`
  --
INSERT INTO
  `deduccion_nomina` (
    `id_deduccion`,
    `id_nomina`,
    `sso`,
    `paro_forzoso`,
    `lph`,
    `subtotal`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    70,
    6.65,
    0.83,
    1.80,
    9.28,
    '2022-09-06 23:23:38',
    '2022-09-06 23:23:38'
  ),
  (
    2,
    71,
    6.65,
    0.83,
    1.80,
    9.28,
    '2022-09-09 12:25:14',
    '2022-09-09 12:25:14'
  ),
  (
    4,
    73,
    14.03,
    1.75,
    3.80,
    19.58,
    '2022-09-11 03:16:43',
    '2022-09-11 03:16:43'
  ),
  (
    5,
    74,
    14.03,
    1.75,
    3.80,
    19.58,
    '2022-09-12 22:56:43',
    '2022-09-12 22:56:43'
  ),
  (
    6,
    75,
    14.03,
    1.75,
    3.80,
    19.58,
    '2022-09-17 22:28:35',
    '2022-09-17 22:28:35'
  );
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;
--
  -- Volcado de datos para la tabla `departamento`
  --
INSERT INTO
  `departamento` (
    `iddepartamento`,
    `nombre`,
    `descripcion`,
    `created_at`,
    `updated_at`,
    `idusuario`,
    `estadod`
  )
VALUES
  (
    1,
    'DEPARTAMENTO ADMINISTRATIVO',
    'ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA',
    '2020-10-31 15:25:45',
    '2022-09-20 21:40:27',
    1,
    1
  ),
  (
    7,
    'DEPARTAMENTO DE SISTEMA',
    'ENCARGADOS DEL SOPORTE TÉCNICO',
    '2020-11-01 12:11:58',
    '2022-09-20 21:40:27',
    1,
    1
  ),
  (
    8,
    'DEPARTAMENTO DE TRANSPORTE',
    'ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ',
    '2022-07-08 07:38:14',
    '2022-09-20 21:40:27',
    1,
    1
  );
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `empleado`
  --
INSERT INTO
  `empleado` (
    `id_emp`,
    `nombre`,
    `apellido`,
    `tipo_documento`,
    `cedula`,
    `fecha_nac`,
    `iddepartamento`,
    `cargo`,
    `telefono`,
    `direccion`,
    `fecha_ingreso`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    5,
    'José',
    'Gonzalez',
    'RIF',
    '29256689',
    '2000-07-05',
    7,
    'Sistema',
    '(416) 658-8998',
    'San Josecito',
    '2022-07-11',
    '2022-08-25 13:21:17',
    '2022-09-21 19:09:36'
  ),
  (
    9,
    'Gabriel',
    'Montilva',
    'Cedula',
    '30159951',
    '2000-07-05',
    1,
    'Apoyo',
    '(424) 782-9126',
    'Vega de Aza',
    '2019-08-25',
    '2022-08-25 13:21:17',
    '2022-08-27 00:27:27'
  ),
  (
    10,
    'Jose',
    'P',
    'Cedula',
    '1115564',
    '2001-10-16',
    8,
    'dadasd',
    '(111) 111-1111',
    'adasd',
    '2022-05-15',
    '2022-08-25 19:52:25',
    '2022-09-23 22:46:13'
  ),
  (
    12,
    'Pedro',
    'Perez',
    'Cedula',
    '2313',
    '0123-03-12',
    8,
    '3123',
    '(424) 763-3369',
    'Caracas',
    '0123-03-12',
    '2022-09-05 20:16:21',
    '2022-09-24 20:56:09'
  ),
  (
    14,
    'otro xd',
    'mas',
    'Cedula',
    '1232134311',
    '2000-10-18',
    8,
    'alguno',
    '(222) 222-2222',
    'algun lugar',
    '2018-08-15',
    '2022-09-21 19:24:56',
    '2022-09-23 22:36:19'
  ),
  (
    19,
    'Luis',
    'Lopez',
    'Cedula',
    '27444564',
    '2000-02-10',
    8,
    'Chofer',
    '(111) 111-1111',
    'Casita',
    '2018-05-15',
    '2022-09-27 00:39:07',
    '2022-09-27 00:39:07'
  ),
  (
    20,
    'Pablo',
    'Perez',
    'Cedula',
    '14556784',
    '1974-02-10',
    8,
    'Chofer',
    '(111) 111-1111',
    'Casita',
    '2016-05-15',
    '2022-09-27 00:40:02',
    '2022-09-27 00:40:02'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `estados`
  --
  CREATE TABLE `estados` (
    `id_estado` int(11) NOT NULL,
    `estado` varchar(250) NOT NULL,
    `iso_3166-2` varchar(4) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `estados`
  --
INSERT INTO
  `estados` (`id_estado`, `estado`, `iso_3166-2`)
VALUES
  (1, 'Amazonas', 'VE-X'),
  (2, 'Anzoátegui', 'VE-B'),
  (3, 'Apure', 'VE-C'),
  (4, 'Aragua', 'VE-D'),
  (5, 'Barinas', 'VE-E'),
  (6, 'Bolívar', 'VE-F'),
  (7, 'Carabobo', 'VE-G'),
  (8, 'Cojedes', 'VE-H'),
  (9, 'Delta Amacuro', 'VE-Y'),
  (10, 'Falcón', 'VE-I'),
  (11, 'Guárico', 'VE-J'),
  (12, 'Lara', 'VE-K'),
  (13, 'Mérida', 'VE-L'),
  (14, 'Miranda', 'VE-M'),
  (15, 'Monagas', 'VE-N'),
  (16, 'Nueva Esparta', 'VE-O'),
  (17, 'Portuguesa', 'VE-P'),
  (18, 'Sucre', 'VE-R'),
  (19, 'Táchira', 'VE-S'),
  (20, 'Trujillo', 'VE-T'),
  (21, 'La Guaira', 'VE-W'),
  (22, 'Yaracuy', 'VE-U'),
  (23, 'Zulia', 'VE-V'),
  (24, 'Distrito Capital', 'VE-A');
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `fletes`
  --
  CREATE TABLE `fletes` (
    `flete_id` int(11) NOT NULL,
    `flete_idusuario` int(11) NOT NULL,
    `flete_codigo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
    `flete_destino_estado` int(11) NOT NULL,
    `flete_destino_municipio` int(11) NOT NULL,
    `flete_destino_parroquia` int(11) NOT NULL,
    `flete_kilometros` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
    `flete_valor_en_carga` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
    `flete_valor_sin_carga` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
    `flete_estado` int(11) NOT NULL DEFAULT 0 COMMENT 'Se refiere si ha sido asignado a un viaje o no, 0 para no, 1 para si, 2 si ha sido completado',
    `flete_tipo` int(11) NOT NULL DEFAULT 0 COMMENT 'Si es de ida(1) o de retorno(2), 0 sin asignar',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;
--
  -- Volcado de datos para la tabla `fletes`
  --
INSERT INTO
  `fletes` (
    `flete_id`,
    `flete_idusuario`,
    `flete_codigo`,
    `flete_destino_estado`,
    `flete_destino_municipio`,
    `flete_destino_parroquia`,
    `flete_kilometros`,
    `flete_valor_en_carga`,
    `flete_valor_sin_carga`,
    `flete_estado`,
    `flete_tipo`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    15,
    1,
    'FLETE-22092022-1',
    2,
    3,
    3,
    '100.111',
    '200.000',
    '50.000',
    2,
    1,
    '2022-07-26 15:56:35',
    '2022-09-30 20:43:33'
  ),
  (
    16,
    1,
    'flete2',
    1,
    1,
    5,
    '130.1',
    '15.000',
    '5.000',
    2,
    2,
    '2022-09-24 19:46:07',
    '2022-10-03 16:43:40'
  ),
  (
    17,
    1,
    'flete3',
    12,
    144,
    458,
    '800',
    '30.000',
    '10.000',
    2,
    1,
    '2022-09-24 19:55:46',
    '2022-10-02 19:21:18'
  ),
  (
    18,
    1,
    '123',
    1,
    2,
    7,
    '123',
    '23.333',
    '213.123',
    2,
    1,
    '2022-09-26 22:37:51',
    '2022-10-03 16:43:40'
  ),
  (
    19,
    1,
    'flete23',
    4,
    52,
    150,
    '16541',
    '15.000',
    '5.000',
    2,
    1,
    '2022-09-27 00:35:57',
    '2022-10-03 00:44:45'
  ),
  (
    20,
    1,
    'flete-44',
    6,
    73,
    244,
    '1500',
    '60.000',
    '4.000',
    2,
    2,
    '2022-09-27 00:36:43',
    '2022-10-03 00:44:45'
  ),
  (
    21,
    1,
    '12467',
    15,
    268,
    695,
    '100',
    '14.000',
    '4.000',
    2,
    1,
    '2022-09-27 00:37:12',
    '2022-09-30 20:43:05'
  ),
  (
    22,
    1,
    '12478',
    3,
    29,
    82,
    '300',
    '50.000',
    '10.000',
    2,
    2,
    '2022-09-27 00:37:44',
    '2022-09-30 20:43:05'
  ),
  (
    23,
    1,
    'flelte03102022',
    13,
    190,
    557,
    '100',
    '14.890',
    '4.350',
    2,
    1,
    '2022-10-03 00:47:13',
    '2022-10-03 00:49:53'
  ),
  (
    24,
    1,
    'flete03102022-2',
    19,
    363,
    873,
    '100',
    '12.680',
    '4.250',
    2,
    2,
    '2022-10-03 00:48:16',
    '2022-10-03 00:49:53'
  ),
  (
    25,
    1,
    'flete03102022-1',
    8,
    92,
    296,
    '200',
    '30.000',
    '10.000',
    2,
    1,
    '2022-10-03 16:53:58',
    '2022-10-03 16:57:30'
  ),
  (
    26,
    1,
    'flete03102022-3',
    19,
    363,
    871,
    '200',
    '15.000',
    '5.000',
    2,
    2,
    '2022-10-03 16:55:02',
    '2022-10-03 16:57:30'
  ),
  (
    27,
    1,
    '555',
    13,
    184,
    538,
    '11',
    '30.000',
    '10.000',
    2,
    1,
    '2022-10-04 19:09:40',
    '2022-10-04 19:12:10'
  ),
  (
    28,
    1,
    'pruebaa|',
    3,
    30,
    87,
    '123',
    '22.223',
    '4.441',
    2,
    2,
    '2022-10-05 22:04:56',
    '2022-10-05 22:06:03'
  ),
  (
    29,
    1,
    'otraprueba',
    12,
    149,
    490,
    '111',
    '200.000',
    '10.000',
    2,
    1,
    '2022-10-05 22:54:37',
    '2022-10-05 22:55:56'
  ),
  (
    30,
    1,
    'comprobante',
    20,
    378,
    926,
    '1231',
    '10.000',
    '1.000',
    1,
    1,
    '2022-10-05 23:19:06',
    '2022-10-05 23:20:06'
  ),
  (
    31,
    1,
    'codprueba1',
    11,
    139,
    445,
    '150',
    '20.000',
    '5.000',
    1,
    1,
    '2022-10-06 21:52:06',
    '2022-10-06 21:53:08'
  ),
  (
    32,
    1,
    'xddd',
    11,
    141,
    450,
    '133',
    '20.000',
    '3.000',
    1,
    1,
    '2022-10-06 22:02:50',
    '2022-10-07 01:43:31'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `migrations`
  --
  CREATE TABLE `migrations` (
    `id` int(10) UNSIGNED NOT NULL,
    `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `batch` int(11) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
  -- Volcado de datos para la tabla `migrations`
  --
INSERT INTO
  `migrations` (`id`, `migration`, `batch`)
VALUES
  (
    1,
    '2019_12_14_000001_create_personal_access_tokens_table',
    1
  ),
  (2, '2022_10_07_013753_create_audits_table', 1);
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `municipios`
  --
  CREATE TABLE `municipios` (
    `id_municipio` int(11) NOT NULL,
    `id_estado` int(11) NOT NULL,
    `municipio` varchar(100) NOT NULL,
    `coordenada` varchar(50) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `municipios`
  --
INSERT INTO
  `municipios` (
    `id_municipio`,
    `id_estado`,
    `municipio`,
    `coordenada`
  )
VALUES
  (
    1,
    1,
    'Alto Orinoco',
    '2.772138301595359, -64.21117363707513'
  ),
  (2, 1, 'Atabapo', ''),
  (3, 1, 'Atures', ''),
  (4, 1, 'Autana', ''),
  (5, 1, 'Manapiare', ''),
  (6, 1, 'Maroa', ''),
  (7, 1, 'Río Negro', ''),
  (8, 2, 'Anaco', ''),
  (9, 2, 'Aragua', ''),
  (10, 2, 'Manuel Ezequiel Bruzual', ''),
  (11, 2, 'Diego Bautista Urbaneja', ''),
  (12, 2, 'Fernando Peñalver', ''),
  (13, 2, 'Francisco Del Carmen Carvajal', ''),
  (14, 2, 'General Sir Arthur McGregor', ''),
  (15, 2, 'Guanta', ''),
  (16, 2, 'Independencia', ''),
  (17, 2, 'José Gregorio Monagas', ''),
  (18, 2, 'Juan Antonio Sotillo', ''),
  (19, 2, 'Juan Manuel Cajigal', ''),
  (20, 2, 'Libertad', ''),
  (21, 2, 'Francisco de Miranda', ''),
  (22, 2, 'Pedro María Freites', ''),
  (23, 2, 'Píritu', ''),
  (24, 2, 'San José de Guanipa', ''),
  (25, 2, 'San Juan de Capistrano', ''),
  (26, 2, 'Santa Ana', ''),
  (27, 2, 'Simón Bolívar', ''),
  (28, 2, 'Simón Rodríguez', ''),
  (29, 3, 'Achaguas', ''),
  (30, 3, 'Biruaca', ''),
  (31, 3, 'Muñóz', ''),
  (32, 3, 'Páez', ''),
  (33, 3, 'Pedro Camejo', ''),
  (34, 3, 'Rómulo Gallegos', ''),
  (35, 3, 'San Fernando', ''),
  (36, 4, 'Atanasio Girardot', ''),
  (37, 4, 'Bolívar', ''),
  (38, 4, 'Camatagua', ''),
  (39, 4, 'Francisco Linares Alcántara', ''),
  (40, 4, 'José Ángel Lamas', ''),
  (41, 4, 'José Félix Ribas', ''),
  (42, 4, 'José Rafael Revenga', ''),
  (43, 4, 'Libertador', ''),
  (44, 4, 'Mario Briceño Iragorry', ''),
  (45, 4, 'Ocumare de la Costa de Oro', ''),
  (46, 4, 'San Casimiro', ''),
  (47, 4, 'San Sebastián', ''),
  (48, 4, 'Santiago Mariño', ''),
  (49, 4, 'Santos Michelena', ''),
  (50, 4, 'Sucre', ''),
  (51, 4, 'Tovar', ''),
  (52, 4, 'Urdaneta', ''),
  (53, 4, 'Zamora', ''),
  (54, 5, 'Alberto Arvelo Torrealba', ''),
  (55, 5, 'Andrés Eloy Blanco', ''),
  (56, 5, 'Antonio José de Sucre', ''),
  (57, 5, 'Arismendi', ''),
  (58, 5, 'Barinas', ''),
  (59, 5, 'Bolívar', ''),
  (60, 5, 'Cruz Paredes', ''),
  (61, 5, 'Ezequiel Zamora', ''),
  (62, 5, 'Obispos', ''),
  (63, 5, 'Pedraza', ''),
  (64, 5, 'Rojas', ''),
  (65, 5, 'Sosa', ''),
  (66, 6, 'Caroní', ''),
  (67, 6, 'Cedeño', ''),
  (68, 6, 'El Callao', ''),
  (69, 6, 'Gran Sabana', ''),
  (70, 6, 'Heres', ''),
  (71, 6, 'Piar', ''),
  (72, 6, 'Angostura (Raúl Leoni)', ''),
  (73, 6, 'Roscio', ''),
  (74, 6, 'Sifontes', ''),
  (75, 6, 'Sucre', ''),
  (76, 6, 'Padre Pedro Chien', ''),
  (77, 7, 'Bejuma', ''),
  (78, 7, 'Carlos Arvelo', ''),
  (79, 7, 'Diego Ibarra', ''),
  (80, 7, 'Guacara', ''),
  (81, 7, 'Juan José Mora', ''),
  (82, 7, 'Libertador', ''),
  (83, 7, 'Los Guayos', ''),
  (84, 7, 'Miranda', ''),
  (85, 7, 'Montalbán', ''),
  (86, 7, 'Naguanagua', ''),
  (87, 7, 'Puerto Cabello', ''),
  (88, 7, 'San Diego', ''),
  (89, 7, 'San Joaquín', ''),
  (90, 7, 'Valencia', ''),
  (91, 8, 'Anzoátegui', ''),
  (92, 8, 'Tinaquillo', ''),
  (93, 8, 'Girardot', ''),
  (94, 8, 'Lima Blanco', ''),
  (95, 8, 'Pao de San Juan Bautista', ''),
  (96, 8, 'Ricaurte', ''),
  (97, 8, 'Rómulo Gallegos', ''),
  (98, 8, 'San Carlos', ''),
  (99, 8, 'Tinaco', ''),
  (100, 9, 'Antonio Díaz', ''),
  (101, 9, 'Casacoima', ''),
  (102, 9, 'Pedernales', ''),
  (103, 9, 'Tucupita', ''),
  (104, 10, 'Acosta', ''),
  (105, 10, 'Bolívar', ''),
  (106, 10, 'Buchivacoa', ''),
  (107, 10, 'Cacique Manaure', ''),
  (108, 10, 'Carirubana', ''),
  (109, 10, 'Colina', ''),
  (110, 10, 'Dabajuro', ''),
  (111, 10, 'Democracia', ''),
  (112, 10, 'Falcón', ''),
  (113, 10, 'Federación', ''),
  (114, 10, 'Jacura', ''),
  (115, 10, 'José Laurencio Silva', ''),
  (116, 10, 'Los Taques', ''),
  (117, 10, 'Mauroa', ''),
  (118, 10, 'Miranda', ''),
  (119, 10, 'Monseñor Iturriza', ''),
  (120, 10, 'Palmasola', ''),
  (121, 10, 'Petit', ''),
  (122, 10, 'Píritu', ''),
  (123, 10, 'San Francisco', ''),
  (124, 10, 'Sucre', ''),
  (125, 10, 'Tocópero', ''),
  (126, 10, 'Unión', ''),
  (127, 10, 'Urumaco', ''),
  (128, 10, 'Zamora', ''),
  (129, 11, 'Camaguán', ''),
  (130, 11, 'Chaguaramas', ''),
  (131, 11, 'El Socorro', ''),
  (132, 11, 'José Félix Ribas', ''),
  (133, 11, 'José Tadeo Monagas', ''),
  (134, 11, 'Juan Germán Roscio', ''),
  (135, 11, 'Julián Mellado', ''),
  (136, 11, 'Las Mercedes', ''),
  (137, 11, 'Leonardo Infante', ''),
  (138, 11, 'Pedro Zaraza', ''),
  (139, 11, 'Ortíz', ''),
  (140, 11, 'San Gerónimo de Guayabal', ''),
  (141, 11, 'San José de Guaribe', ''),
  (142, 11, 'Santa María de Ipire', ''),
  (143, 11, 'Sebastián Francisco de Miranda', ''),
  (144, 12, 'Andrés Eloy Blanco', ''),
  (145, 12, 'Crespo', ''),
  (146, 12, 'Iribarren', ''),
  (147, 12, 'Jiménez', ''),
  (148, 12, 'Morán', ''),
  (149, 12, 'Palavecino', ''),
  (150, 12, 'Simón Planas', ''),
  (151, 12, 'Torres', ''),
  (152, 12, 'Urdaneta', ''),
  (179, 13, 'Alberto Adriani', ''),
  (180, 13, 'Andrés Bello', ''),
  (181, 13, 'Antonio Pinto Salinas', ''),
  (182, 13, 'Aricagua', ''),
  (183, 13, 'Arzobispo Chacón', ''),
  (184, 13, 'Campo Elías', ''),
  (185, 13, 'Caracciolo Parra Olmedo', ''),
  (186, 13, 'Cardenal Quintero', ''),
  (187, 13, 'Guaraque', ''),
  (188, 13, 'Julio César Salas', ''),
  (189, 13, 'Justo Briceño', ''),
  (190, 13, 'Libertador', ''),
  (191, 13, 'Miranda', ''),
  (192, 13, 'Obispo Ramos de Lora', ''),
  (193, 13, 'Padre Noguera', ''),
  (194, 13, 'Pueblo Llano', ''),
  (195, 13, 'Rangel', ''),
  (196, 13, 'Rivas Dávila', ''),
  (197, 13, 'Santos Marquina', ''),
  (198, 13, 'Sucre', ''),
  (199, 13, 'Tovar', ''),
  (200, 13, 'Tulio Febres Cordero', ''),
  (201, 13, 'Zea', ''),
  (223, 14, 'Acevedo', ''),
  (224, 14, 'Andrés Bello', ''),
  (225, 14, 'Baruta', ''),
  (226, 14, 'Brión', ''),
  (227, 14, 'Buroz', ''),
  (228, 14, 'Carrizal', ''),
  (229, 14, 'Chacao', ''),
  (230, 14, 'Cristóbal Rojas', ''),
  (231, 14, 'El Hatillo', ''),
  (232, 14, 'Guaicaipuro', ''),
  (233, 14, 'Independencia', ''),
  (234, 14, 'Lander', ''),
  (235, 14, 'Los Salias', ''),
  (236, 14, 'Páez', ''),
  (237, 14, 'Paz Castillo', ''),
  (238, 14, 'Pedro Gual', ''),
  (239, 14, 'Plaza', ''),
  (240, 14, 'Simón Bolívar', ''),
  (241, 14, 'Sucre', ''),
  (242, 14, 'Urdaneta', ''),
  (243, 14, 'Zamora', ''),
  (258, 15, 'Acosta', ''),
  (259, 15, 'Aguasay', ''),
  (260, 15, 'Bolívar', ''),
  (261, 15, 'Caripe', ''),
  (262, 15, 'Cedeño', ''),
  (263, 15, 'Ezequiel Zamora', ''),
  (264, 15, 'Libertador', ''),
  (265, 15, 'Maturín', ''),
  (266, 15, 'Piar', ''),
  (267, 15, 'Punceres', ''),
  (268, 15, 'Santa Bárbara', ''),
  (269, 15, 'Sotillo', ''),
  (270, 15, 'Uracoa', ''),
  (271, 16, 'Antolín del Campo', ''),
  (272, 16, 'Arismendi', ''),
  (273, 16, 'García', ''),
  (274, 16, 'Gómez', ''),
  (275, 16, 'Maneiro', ''),
  (276, 16, 'Marcano', ''),
  (277, 16, 'Mariño', ''),
  (278, 16, 'Península de Macanao', ''),
  (279, 16, 'Tubores', ''),
  (280, 16, 'Villalba', ''),
  (281, 16, 'Díaz', ''),
  (282, 17, 'Agua Blanca', ''),
  (283, 17, 'Araure', ''),
  (284, 17, 'Esteller', ''),
  (285, 17, 'Guanare', ''),
  (286, 17, 'Guanarito', ''),
  (287, 17, 'Monseñor José Vicente de Unda', ''),
  (288, 17, 'Ospino', ''),
  (289, 17, 'Páez', ''),
  (290, 17, 'Papelón', ''),
  (291, 17, 'San Genaro de Boconoíto', ''),
  (292, 17, 'San Rafael de Onoto', ''),
  (293, 17, 'Santa Rosalía', ''),
  (294, 17, 'Sucre', ''),
  (295, 17, 'Turén', ''),
  (296, 18, 'Andrés Eloy Blanco', ''),
  (297, 18, 'Andrés Mata', ''),
  (298, 18, 'Arismendi', ''),
  (299, 18, 'Benítez', ''),
  (300, 18, 'Bermúdez', ''),
  (301, 18, 'Bolívar', ''),
  (302, 18, 'Cajigal', ''),
  (303, 18, 'Cruz Salmerón Acosta', ''),
  (304, 18, 'Libertador', ''),
  (305, 18, 'Mariño', ''),
  (306, 18, 'Mejía', ''),
  (307, 18, 'Montes', ''),
  (308, 18, 'Ribero', ''),
  (309, 18, 'Sucre', ''),
  (310, 18, 'Valdéz', ''),
  (341, 19, 'Andrés Bello', ''),
  (342, 19, 'Antonio Rómulo Costa', ''),
  (343, 19, 'Ayacucho', ''),
  (344, 19, 'Bolívar', ''),
  (345, 19, 'Cárdenas', ''),
  (346, 19, 'Córdoba', ''),
  (347, 19, 'Fernández Feo', ''),
  (348, 19, 'Francisco de Miranda', ''),
  (349, 19, 'García de Hevia', ''),
  (350, 19, 'Guásimos', ''),
  (351, 19, 'Independencia', ''),
  (352, 19, 'Jáuregui', ''),
  (353, 19, 'José María Vargas', ''),
  (354, 19, 'Junín', ''),
  (355, 19, 'Libertad', ''),
  (356, 19, 'Libertador', ''),
  (357, 19, 'Lobatera', ''),
  (358, 19, 'Michelena', ''),
  (359, 19, 'Panamericano', ''),
  (360, 19, 'Pedro María Ureña', ''),
  (361, 19, 'Rafael Urdaneta', ''),
  (362, 19, 'Samuel Darío Maldonado', ''),
  (363, 19, 'San Cristóbal', ''),
  (364, 19, 'Seboruco', ''),
  (365, 19, 'Simón Rodríguez', ''),
  (366, 19, 'Sucre', ''),
  (367, 19, 'Torbes', ''),
  (368, 19, 'Uribante', ''),
  (369, 19, 'San Judas Tadeo', ''),
  (370, 20, 'Andrés Bello', ''),
  (371, 20, 'Boconó', ''),
  (372, 20, 'Bolívar', ''),
  (373, 20, 'Candelaria', ''),
  (374, 20, 'Carache', ''),
  (375, 20, 'Escuque', ''),
  (376, 20, 'José Felipe Márquez Cañizalez', ''),
  (377, 20, 'Juan Vicente Campos Elías', ''),
  (378, 20, 'La Ceiba', ''),
  (379, 20, 'Miranda', ''),
  (380, 20, 'Monte Carmelo', ''),
  (381, 20, 'Motatán', ''),
  (382, 20, 'Pampán', ''),
  (383, 20, 'Pampanito', ''),
  (384, 20, 'Rafael Rangel', ''),
  (385, 20, 'San Rafael de Carvajal', ''),
  (386, 20, 'Sucre', ''),
  (387, 20, 'Trujillo', ''),
  (388, 20, 'Urdaneta', ''),
  (389, 20, 'Valera', ''),
  (390, 21, 'Vargas', ''),
  (391, 22, 'Arístides Bastidas', ''),
  (392, 22, 'Bolívar', ''),
  (407, 22, 'Bruzual', ''),
  (408, 22, 'Cocorote', ''),
  (409, 22, 'Independencia', ''),
  (410, 22, 'José Antonio Páez', ''),
  (411, 22, 'La Trinidad', ''),
  (412, 22, 'Manuel Monge', ''),
  (413, 22, 'Nirgua', ''),
  (414, 22, 'Peña', ''),
  (415, 22, 'San Felipe', ''),
  (416, 22, 'Sucre', ''),
  (417, 22, 'Urachiche', ''),
  (418, 22, 'José Joaquín Veroes', ''),
  (441, 23, 'Almirante Padilla', ''),
  (442, 23, 'Baralt', ''),
  (443, 23, 'Cabimas', ''),
  (444, 23, 'Catatumbo', ''),
  (445, 23, 'Colón', ''),
  (446, 23, 'Francisco Javier Pulgar', ''),
  (447, 23, 'Páez', ''),
  (448, 23, 'Jesús Enrique Losada', ''),
  (449, 23, 'Jesús María Semprún', ''),
  (450, 23, 'La Cañada de Urdaneta', ''),
  (451, 23, 'Lagunillas', ''),
  (452, 23, 'Machiques de Perijá', ''),
  (453, 23, 'Mara', ''),
  (454, 23, 'Maracaibo', ''),
  (455, 23, 'Miranda', ''),
  (456, 23, 'Rosario de Perijá', ''),
  (457, 23, 'San Francisco', ''),
  (458, 23, 'Santa Rita', ''),
  (459, 23, 'Simón Bolívar', ''),
  (460, 23, 'Sucre', ''),
  (461, 23, 'Valmore Rodríguez', ''),
  (462, 24, 'Libertador', '');
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `nomina_choferes`
  --
  CREATE TABLE `nomina_choferes` (
    `id_nomina_chofer` int(11) NOT NULL,
    `id_chofer` int(11) NOT NULL,
    `id_viaje` int(11) NOT NULL,
    `pago_total` varchar(50) NOT NULL,
    `estado` int(11) NOT NULL DEFAULT 0 COMMENT '0 significa de que no ha sido cancelado el pago, 1 para si',
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Volcado de datos para la tabla `nomina_choferes`
  --
INSERT INTO
  `nomina_choferes` (
    `id_nomina_chofer`,
    `id_chofer`,
    `id_viaje`,
    `pago_total`,
    `estado`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    10,
    8,
    '6.000',
    1,
    '2022-10-02 19:21:19',
    '2022-10-03 16:36:32'
  ),
  (
    2,
    10,
    11,
    '12.600',
    1,
    '2022-10-03 00:44:45',
    '2022-10-03 16:38:20'
  ),
  (
    3,
    12,
    12,
    '5.426',
    1,
    '2022-10-03 00:49:53',
    '2022-10-03 16:37:36'
  ),
  (
    4,
    14,
    7,
    '38.468',
    1,
    '2022-10-03 16:43:40',
    '2022-10-03 16:44:01'
  ),
  (
    5,
    20,
    13,
    '9.000',
    1,
    '2022-10-03 16:57:31',
    '2022-10-03 16:58:14'
  ),
  (
    6,
    10,
    14,
    '6.000',
    1,
    '2022-10-04 19:12:10',
    '2022-10-04 19:13:11'
  ),
  (
    7,
    12,
    15,
    '4.000',
    1,
    '2022-10-05 22:06:03',
    '2022-10-05 22:06:16'
  ),
  (
    8,
    12,
    16,
    '0',
    0,
    '2022-10-05 22:55:56',
    '2022-10-05 22:55:56'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `pago_nomina`
  --
  CREATE TABLE `pago_nomina` (
    `id_nomina` int(11) NOT NULL,
    `id_empleado` int(11) NOT NULL,
    `id_usuario` int(11) NOT NULL,
    `salario_mensual` double(8, 2) UNSIGNED NOT NULL,
    `tipo_nomina` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mensual / Quincenal',
    `inicio_pago` date DEFAULT NULL COMMENT 'Fecha de pago Desde',
    `fin_pago` date DEFAULT NULL COMMENT 'Fecha de pago Hasta',
    `total_asignaciones` double(8, 2) UNSIGNED NOT NULL,
    `total_deducciones` double(8, 2) NOT NULL,
    `total_pago` double(8, 2) UNSIGNED NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
  -- Volcado de datos para la tabla `pago_nomina`
  --
INSERT INTO
  `pago_nomina` (
    `id_nomina`,
    `id_empleado`,
    `id_usuario`,
    `salario_mensual`,
    `tipo_nomina`,
    `inicio_pago`,
    `fin_pago`,
    `total_asignaciones`,
    `total_deducciones`,
    `total_pago`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    70,
    5,
    1,
    180.00,
    'mensual',
    '2022-10-01',
    '2022-10-31',
    164.33,
    9.28,
    155.05,
    '2022-09-06 23:23:38',
    '2022-09-06 23:23:38'
  ),
  (
    71,
    5,
    1,
    180.00,
    'mensual',
    '2022-06-01',
    '2022-07-01',
    174.00,
    9.28,
    164.72,
    '2022-09-09 12:25:14',
    '2022-09-09 12:25:14'
  ),
  (
    73,
    12,
    1,
    380.00,
    'Mensual',
    '2022-10-01',
    '2022-10-31',
    430.35,
    19.58,
    410.77,
    '2022-09-11 03:16:43',
    '2022-09-11 03:16:43'
  ),
  (
    74,
    9,
    1,
    380.00,
    'Mensual',
    '2022-09-01',
    '2022-10-01',
    380.00,
    19.58,
    360.42,
    '2022-09-12 22:56:42',
    '2022-09-12 22:56:42'
  ),
  (
    75,
    12,
    1,
    380.00,
    'Mensual',
    '2022-10-01',
    '2022-10-31',
    403.75,
    19.58,
    384.17,
    '2022-09-17 22:28:35',
    '2022-09-17 22:28:35'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `parroquias`
  --
  CREATE TABLE `parroquias` (
    `id_parroquia` int(11) NOT NULL,
    `id_municipio` int(11) NOT NULL,
    `parroquia` varchar(250) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `parroquias`
  --
INSERT INTO
  `parroquias` (`id_parroquia`, `id_municipio`, `parroquia`)
VALUES
  (1, 1, 'Alto Orinoco'),
  (2, 1, 'Huachamacare Acanaña'),
  (3, 1, 'Marawaka Toky Shamanaña'),
  (4, 1, 'Mavaka Mavaka'),
  (5, 1, 'Sierra Parima Parimabé'),
  (6, 2, 'Ucata Laja Lisa'),
  (7, 2, 'Yapacana Macuruco'),
  (8, 2, 'Caname Guarinuma'),
  (9, 3, 'Fernando Girón Tovar'),
  (10, 3, 'Luis Alberto Gómez'),
  (11, 3, 'Pahueña Limón de Parhueña'),
  (12, 3, 'Platanillal Platanillal'),
  (13, 4, 'Samariapo'),
  (14, 4, 'Sipapo'),
  (15, 4, 'Munduapo'),
  (16, 4, 'Guayapo'),
  (17, 5, 'Alto Ventuari'),
  (18, 5, 'Medio Ventuari'),
  (19, 5, 'Bajo Ventuari'),
  (20, 6, 'Victorino'),
  (21, 6, 'Comunidad'),
  (22, 7, 'Casiquiare'),
  (23, 7, 'Cocuy'),
  (24, 7, 'San Carlos de Río Negro'),
  (25, 7, 'Solano'),
  (26, 8, 'Anaco'),
  (27, 8, 'San Joaquín'),
  (28, 9, 'Cachipo'),
  (29, 9, 'Aragua de Barcelona'),
  (30, 11, 'Lechería'),
  (31, 11, 'El Morro'),
  (32, 12, 'Puerto Píritu'),
  (33, 12, 'San Miguel'),
  (34, 12, 'Sucre'),
  (35, 13, 'Valle de Guanape'),
  (36, 13, 'Santa Bárbara'),
  (37, 14, 'El Chaparro'),
  (38, 14, 'Tomás Alfaro'),
  (39, 14, 'Calatrava'),
  (40, 15, 'Guanta'),
  (41, 15, 'Chorrerón'),
  (42, 16, 'Mamo'),
  (43, 16, 'Soledad'),
  (44, 17, 'Mapire'),
  (45, 17, 'Piar'),
  (46, 17, 'Santa Clara'),
  (47, 17, 'San Diego de Cabrutica'),
  (48, 17, 'Uverito'),
  (49, 17, 'Zuata'),
  (50, 18, 'Puerto La Cruz'),
  (51, 18, 'Pozuelos'),
  (52, 19, 'Onoto'),
  (53, 19, 'San Pablo'),
  (54, 20, 'San Mateo'),
  (55, 20, 'El Carito'),
  (56, 20, 'Santa Inés'),
  (57, 20, 'La Romereña'),
  (58, 21, 'Atapirire'),
  (59, 21, 'Boca del Pao'),
  (60, 21, 'El Pao'),
  (61, 21, 'Pariaguán'),
  (62, 22, 'Cantaura'),
  (63, 22, 'Libertador'),
  (64, 22, 'Santa Rosa'),
  (65, 22, 'Urica'),
  (66, 23, 'Píritu'),
  (67, 23, 'San Francisco'),
  (68, 24, 'San José de Guanipa'),
  (69, 25, 'Boca de Uchire'),
  (70, 25, 'Boca de Chávez'),
  (71, 26, 'Pueblo Nuevo'),
  (72, 26, 'Santa Ana'),
  (73, 27, 'Bergantín'),
  (74, 27, 'Caigua'),
  (75, 27, 'El Carmen'),
  (76, 27, 'El Pilar'),
  (77, 27, 'Naricual'),
  (78, 27, 'San Crsitóbal'),
  (79, 28, 'Edmundo Barrios'),
  (80, 28, 'Miguel Otero Silva'),
  (81, 29, 'Achaguas'),
  (82, 29, 'Apurito'),
  (83, 29, 'El Yagual'),
  (84, 29, 'Guachara'),
  (85, 29, 'Mucuritas'),
  (86, 29, 'Queseras del medio'),
  (87, 30, 'Biruaca'),
  (88, 31, 'Bruzual'),
  (89, 31, 'Mantecal'),
  (90, 31, 'Quintero'),
  (91, 31, 'Rincón Hondo'),
  (92, 31, 'San Vicente'),
  (93, 32, 'Guasdualito'),
  (94, 32, 'Aramendi'),
  (95, 32, 'El Amparo'),
  (96, 32, 'San Camilo'),
  (97, 32, 'Urdaneta'),
  (98, 33, 'San Juan de Payara'),
  (99, 33, 'Codazzi'),
  (100, 33, 'Cunaviche'),
  (101, 34, 'Elorza'),
  (102, 34, 'La Trinidad'),
  (103, 35, 'San Fernando'),
  (104, 35, 'El Recreo'),
  (105, 35, 'Peñalver'),
  (106, 35, 'San Rafael de Atamaica'),
  (107, 36, 'Pedro José Ovalles'),
  (108, 36, 'Joaquín Crespo'),
  (109, 36, 'José Casanova Godoy'),
  (110, 36, 'Madre María de San José'),
  (111, 36, 'Andrés Eloy Blanco'),
  (112, 36, 'Los Tacarigua'),
  (113, 36, 'Las Delicias'),
  (114, 36, 'Choroní'),
  (115, 37, 'Bolívar'),
  (116, 38, 'Camatagua'),
  (117, 38, 'Carmen de Cura'),
  (118, 39, 'Santa Rita'),
  (119, 39, 'Francisco de Miranda'),
  (120, 39, 'Moseñor Feliciano González'),
  (121, 40, 'Santa Cruz'),
  (122, 41, 'José Félix Ribas'),
  (123, 41, 'Castor Nieves Ríos'),
  (124, 41, 'Las Guacamayas'),
  (125, 41, 'Pao de Zárate'),
  (126, 41, 'Zuata'),
  (127, 42, 'José Rafael Revenga'),
  (128, 43, 'Palo Negro'),
  (129, 43, 'San Martín de Porres'),
  (130, 44, 'El Limón'),
  (131, 44, 'Caña de Azúcar'),
  (132, 45, 'Ocumare de la Costa'),
  (133, 46, 'San Casimiro'),
  (134, 46, 'Güiripa'),
  (135, 46, 'Ollas de Caramacate'),
  (136, 46, 'Valle Morín'),
  (137, 47, 'San Sebastían'),
  (138, 48, 'Turmero'),
  (139, 48, 'Arevalo Aponte'),
  (140, 48, 'Chuao'),
  (141, 48, 'Samán de Güere'),
  (142, 48, 'Alfredo Pacheco Miranda'),
  (143, 49, 'Santos Michelena'),
  (144, 49, 'Tiara'),
  (145, 50, 'Cagua'),
  (146, 50, 'Bella Vista'),
  (147, 51, 'Tovar'),
  (148, 52, 'Urdaneta'),
  (149, 52, 'Las Peñitas'),
  (150, 52, 'San Francisco de Cara'),
  (151, 52, 'Taguay'),
  (152, 53, 'Zamora'),
  (153, 53, 'Magdaleno'),
  (154, 53, 'San Francisco de Asís'),
  (155, 53, 'Valles de Tucutunemo'),
  (156, 53, 'Augusto Mijares'),
  (157, 54, 'Sabaneta'),
  (158, 54, 'Juan Antonio Rodríguez Domínguez'),
  (159, 55, 'El Cantón'),
  (160, 55, 'Santa Cruz de Guacas'),
  (161, 55, 'Puerto Vivas'),
  (162, 56, 'Ticoporo'),
  (163, 56, 'Nicolás Pulido'),
  (164, 56, 'Andrés Bello'),
  (165, 57, 'Arismendi'),
  (166, 57, 'Guadarrama'),
  (167, 57, 'La Unión'),
  (168, 57, 'San Antonio'),
  (169, 58, 'Barinas'),
  (170, 58, 'Alberto Arvelo Larriva'),
  (171, 58, 'San Silvestre'),
  (172, 58, 'Santa Inés'),
  (173, 58, 'Santa Lucía'),
  (174, 58, 'Torumos'),
  (175, 58, 'El Carmen'),
  (176, 58, 'Rómulo Betancourt'),
  (177, 58, 'Corazón de Jesús'),
  (178, 58, 'Ramón Ignacio Méndez'),
  (179, 58, 'Alto Barinas'),
  (180, 58, 'Manuel Palacio Fajardo'),
  (181, 58, 'Juan Antonio Rodríguez Domínguez'),
  (182, 58, 'Dominga Ortiz de Páez'),
  (183, 59, 'Barinitas'),
  (184, 59, 'Altamira de Cáceres'),
  (185, 59, 'Calderas'),
  (186, 60, 'Barrancas'),
  (187, 60, 'El Socorro'),
  (188, 60, 'Mazparrito'),
  (189, 61, 'Santa Bárbara'),
  (190, 61, 'Pedro Briceño Méndez'),
  (191, 61, 'Ramón Ignacio Méndez'),
  (192, 61, 'José Ignacio del Pumar'),
  (193, 62, 'Obispos'),
  (194, 62, 'Guasimitos'),
  (195, 62, 'El Real'),
  (196, 62, 'La Luz'),
  (197, 63, 'Ciudad Bolívia'),
  (198, 63, 'José Ignacio Briceño'),
  (199, 63, 'José Félix Ribas'),
  (200, 63, 'Páez'),
  (201, 64, 'Libertad'),
  (202, 64, 'Dolores'),
  (203, 64, 'Santa Rosa'),
  (204, 64, 'Palacio Fajardo'),
  (205, 65, 'Ciudad de Nutrias'),
  (206, 65, 'El Regalo'),
  (207, 65, 'Puerto Nutrias'),
  (208, 65, 'Santa Catalina'),
  (209, 66, 'Cachamay'),
  (210, 66, 'Chirica'),
  (211, 66, 'Dalla Costa'),
  (212, 66, 'Once de Abril'),
  (213, 66, 'Simón Bolívar'),
  (214, 66, 'Unare'),
  (215, 66, 'Universidad'),
  (216, 66, 'Vista al Sol'),
  (217, 66, 'Pozo Verde'),
  (218, 66, 'Yocoima'),
  (219, 66, '5 de Julio'),
  (220, 67, 'Cedeño'),
  (221, 67, 'Altagracia'),
  (222, 67, 'Ascensión Farreras'),
  (223, 67, 'Guaniamo'),
  (224, 67, 'La Urbana'),
  (225, 67, 'Pijiguaos'),
  (226, 68, 'El Callao'),
  (227, 69, 'Gran Sabana'),
  (228, 69, 'Ikabarú'),
  (229, 70, 'Catedral'),
  (230, 70, 'Zea'),
  (231, 70, 'Orinoco'),
  (232, 70, 'José Antonio Páez'),
  (233, 70, 'Marhuanta'),
  (234, 70, 'Agua Salada'),
  (235, 70, 'Vista Hermosa'),
  (236, 70, 'La Sabanita'),
  (237, 70, 'Panapana'),
  (238, 71, 'Andrés Eloy Blanco'),
  (239, 71, 'Pedro Cova'),
  (240, 72, 'Raúl Leoni'),
  (241, 72, 'Barceloneta'),
  (242, 72, 'Santa Bárbara'),
  (243, 72, 'San Francisco'),
  (244, 73, 'Roscio'),
  (245, 73, 'Salóm'),
  (246, 74, 'Sifontes'),
  (247, 74, 'Dalla Costa'),
  (248, 74, 'San Isidro'),
  (249, 75, 'Sucre'),
  (250, 75, 'Aripao'),
  (251, 75, 'Guarataro'),
  (252, 75, 'Las Majadas'),
  (253, 75, 'Moitaco'),
  (254, 76, 'Padre Pedro Chien'),
  (255, 76, 'Río Grande'),
  (256, 77, 'Bejuma'),
  (257, 77, 'Canoabo'),
  (258, 77, 'Simón Bolívar'),
  (259, 78, 'Güigüe'),
  (260, 78, 'Carabobo'),
  (261, 78, 'Tacarigua'),
  (262, 79, 'Mariara'),
  (263, 79, 'Aguas Calientes'),
  (264, 80, 'Ciudad Alianza'),
  (265, 80, 'Guacara'),
  (266, 80, 'Yagua'),
  (267, 81, 'Morón'),
  (268, 81, 'Yagua'),
  (269, 82, 'Tocuyito'),
  (270, 82, 'Independencia'),
  (271, 83, 'Los Guayos'),
  (272, 84, 'Miranda'),
  (273, 85, 'Montalbán'),
  (274, 86, 'Naguanagua'),
  (275, 87, 'Bartolomé Salóm'),
  (276, 87, 'Democracia'),
  (277, 87, 'Fraternidad'),
  (278, 87, 'Goaigoaza'),
  (279, 87, 'Juan José Flores'),
  (280, 87, 'Unión'),
  (281, 87, 'Borburata'),
  (282, 87, 'Patanemo'),
  (283, 88, 'San Diego'),
  (284, 89, 'San Joaquín'),
  (285, 90, 'Candelaria'),
  (286, 90, 'Catedral'),
  (287, 90, 'El Socorro'),
  (288, 90, 'Miguel Peña'),
  (289, 90, 'Rafael Urdaneta'),
  (290, 90, 'San Blas'),
  (291, 90, 'San José'),
  (292, 90, 'Santa Rosa'),
  (293, 90, 'Negro Primero'),
  (294, 91, 'Cojedes'),
  (295, 91, 'Juan de Mata Suárez'),
  (296, 92, 'Tinaquillo'),
  (297, 93, 'El Baúl'),
  (298, 93, 'Sucre'),
  (299, 94, 'La Aguadita'),
  (300, 94, 'Macapo'),
  (301, 95, 'El Pao'),
  (302, 96, 'El Amparo'),
  (303, 96, 'Libertad de Cojedes'),
  (304, 97, 'Rómulo Gallegos'),
  (305, 98, 'San Carlos de Austria'),
  (306, 98, 'Juan Ángel Bravo'),
  (307, 98, 'Manuel Manrique'),
  (308, 99, 'General en Jefe José Laurencio Silva'),
  (309, 100, 'Curiapo'),
  (310, 100, 'Almirante Luis Brión'),
  (311, 100, 'Francisco Aniceto Lugo'),
  (312, 100, 'Manuel Renaud'),
  (313, 100, 'Padre Barral'),
  (314, 100, 'Santos de Abelgas'),
  (315, 101, 'Imataca'),
  (316, 101, 'Cinco de Julio'),
  (317, 101, 'Juan Bautista Arismendi'),
  (318, 101, 'Manuel Piar'),
  (319, 101, 'Rómulo Gallegos'),
  (320, 102, 'Pedernales'),
  (321, 102, 'Luis Beltrán Prieto Figueroa'),
  (322, 103, 'San José (Delta Amacuro)'),
  (323, 103, 'José Vidal Marcano'),
  (324, 103, 'Juan Millán'),
  (325, 103, 'Leonardo Ruíz Pineda'),
  (326, 103, 'Mariscal Antonio José de Sucre'),
  (327, 103, 'Monseñor Argimiro García'),
  (328, 103, 'San Rafael (Delta Amacuro)'),
  (329, 103, 'Virgen del Valle'),
  (330, 10, 'Clarines'),
  (331, 10, 'Guanape'),
  (332, 10, 'Sabana de Uchire'),
  (333, 104, 'Capadare'),
  (334, 104, 'La Pastora'),
  (335, 104, 'Libertador'),
  (336, 104, 'San Juan de los Cayos'),
  (337, 105, 'Aracua'),
  (338, 105, 'La Peña'),
  (339, 105, 'San Luis'),
  (340, 106, 'Bariro'),
  (341, 106, 'Borojó'),
  (342, 106, 'Capatárida'),
  (343, 106, 'Guajiro'),
  (344, 106, 'Seque'),
  (345, 106, 'Zazárida'),
  (346, 106, 'Valle de Eroa'),
  (347, 107, 'Cacique Manaure'),
  (348, 108, 'Norte'),
  (349, 108, 'Carirubana'),
  (350, 108, 'Santa Ana'),
  (351, 108, 'Urbana Punta Cardón'),
  (352, 109, 'La Vela de Coro'),
  (353, 109, 'Acurigua'),
  (354, 109, 'Guaibacoa'),
  (355, 109, 'Las Calderas'),
  (356, 109, 'Macoruca'),
  (357, 110, 'Dabajuro'),
  (358, 111, 'Agua Clara'),
  (359, 111, 'Avaria'),
  (360, 111, 'Pedregal'),
  (361, 111, 'Piedra Grande'),
  (362, 111, 'Purureche'),
  (363, 112, 'Adaure'),
  (364, 112, 'Adícora'),
  (365, 112, 'Baraived'),
  (366, 112, 'Buena Vista'),
  (367, 112, 'Jadacaquiva'),
  (368, 112, 'El Vínculo'),
  (369, 112, 'El Hato'),
  (370, 112, 'Moruy'),
  (371, 112, 'Pueblo Nuevo'),
  (372, 113, 'Agua Larga'),
  (373, 113, 'El Paují'),
  (374, 113, 'Independencia'),
  (375, 113, 'Mapararí'),
  (376, 114, 'Agua Linda'),
  (377, 114, 'Araurima'),
  (378, 114, 'Jacura'),
  (379, 115, 'Tucacas'),
  (380, 115, 'Boca de Aroa'),
  (381, 116, 'Los Taques'),
  (382, 116, 'Judibana'),
  (383, 117, 'Mene de Mauroa'),
  (384, 117, 'San Félix'),
  (385, 117, 'Casigua'),
  (386, 118, 'Guzmán Guillermo'),
  (387, 118, 'Mitare'),
  (388, 118, 'Río Seco'),
  (389, 118, 'Sabaneta'),
  (390, 118, 'San Antonio'),
  (391, 118, 'San Gabriel'),
  (392, 118, 'Santa Ana'),
  (393, 119, 'Boca del Tocuyo'),
  (394, 119, 'Chichiriviche'),
  (395, 119, 'Tocuyo de la Costa'),
  (396, 120, 'Palmasola'),
  (397, 121, 'Cabure'),
  (398, 121, 'Colina'),
  (399, 121, 'Curimagua'),
  (400, 122, 'San José de la Costa'),
  (401, 122, 'Píritu'),
  (402, 123, 'San Francisco'),
  (403, 124, 'Sucre'),
  (404, 124, 'Pecaya'),
  (405, 125, 'Tocópero'),
  (406, 126, 'El Charal'),
  (407, 126, 'Las Vegas del Tuy'),
  (408, 126, 'Santa Cruz de Bucaral'),
  (409, 127, 'Bruzual'),
  (410, 127, 'Urumaco'),
  (411, 128, 'Puerto Cumarebo'),
  (412, 128, 'La Ciénaga'),
  (413, 128, 'La Soledad'),
  (414, 128, 'Pueblo Cumarebo'),
  (415, 128, 'Zazárida'),
  (416, 113, 'Churuguara'),
  (417, 129, 'Camaguán'),
  (418, 129, 'Puerto Miranda'),
  (419, 129, 'Uverito'),
  (420, 130, 'Chaguaramas'),
  (421, 131, 'El Socorro'),
  (422, 132, 'Tucupido'),
  (423, 132, 'San Rafael de Laya'),
  (424, 133, 'Altagracia de Orituco'),
  (425, 133, 'San Rafael de Orituco'),
  (426, 133, 'San Francisco Javier de Lezama'),
  (427, 133, 'Paso Real de Macaira'),
  (428, 133, 'Carlos Soublette'),
  (429, 133, 'San Francisco de Macaira'),
  (430, 133, 'Libertad de Orituco'),
  (431, 134, 'Cantaclaro'),
  (432, 134, 'San Juan de los Morros'),
  (433, 134, 'Parapara'),
  (434, 135, 'El Sombrero'),
  (435, 135, 'Sosa'),
  (436, 136, 'Las Mercedes'),
  (437, 136, 'Cabruta'),
  (438, 136, 'Santa Rita de Manapire'),
  (439, 137, 'Valle de la Pascua'),
  (440, 137, 'Espino'),
  (441, 138, 'San José de Unare'),
  (442, 138, 'Zaraza'),
  (443, 139, 'San José de Tiznados'),
  (444, 139, 'San Francisco de Tiznados'),
  (445, 139, 'San Lorenzo de Tiznados'),
  (446, 139, 'Ortiz'),
  (447, 140, 'Guayabal'),
  (448, 140, 'Cazorla'),
  (449, 141, 'San José de Guaribe'),
  (450, 141, 'Uveral'),
  (451, 142, 'Santa María de Ipire'),
  (452, 142, 'Altamira'),
  (453, 143, 'El Calvario'),
  (454, 143, 'El Rastro'),
  (455, 143, 'Guardatinajas'),
  (456, 143, 'Capital Urbana Calabozo'),
  (457, 144, 'Quebrada Honda de Guache'),
  (458, 144, 'Pío Tamayo'),
  (459, 144, 'Yacambú'),
  (460, 145, 'Fréitez'),
  (461, 145, 'José María Blanco'),
  (462, 146, 'Catedral'),
  (463, 146, 'Concepción'),
  (464, 146, 'El Cují'),
  (465, 146, 'Juan de Villegas'),
  (466, 146, 'Santa Rosa'),
  (467, 146, 'Tamaca'),
  (468, 146, 'Unión'),
  (469, 146, 'Aguedo Felipe Alvarado'),
  (470, 146, 'Buena Vista'),
  (471, 146, 'Juárez'),
  (472, 147, 'Juan Bautista Rodríguez'),
  (473, 147, 'Cuara'),
  (474, 147, 'Diego de Lozada'),
  (475, 147, 'Paraíso de San José'),
  (476, 147, 'San Miguel'),
  (477, 147, 'Tintorero'),
  (478, 147, 'José Bernardo Dorante'),
  (479, 147, 'Coronel Mariano Peraza '),
  (480, 148, 'Bolívar'),
  (481, 148, 'Anzoátegui'),
  (482, 148, 'Guarico'),
  (483, 148, 'Hilario Luna y Luna'),
  (484, 148, 'Humocaro Alto'),
  (485, 148, 'Humocaro Bajo'),
  (486, 148, 'La Candelaria'),
  (487, 148, 'Morán'),
  (488, 149, 'Cabudare'),
  (489, 149, 'José Gregorio Bastidas'),
  (490, 149, 'Agua Viva'),
  (491, 150, 'Sarare'),
  (492, 150, 'Buría'),
  (493, 150, 'Gustavo Vegas León'),
  (494, 151, 'Trinidad Samuel'),
  (495, 151, 'Antonio Díaz'),
  (496, 151, 'Camacaro'),
  (497, 151, 'Castañeda'),
  (498, 151, 'Cecilio Zubillaga'),
  (499, 151, 'Chiquinquirá'),
  (500, 151, 'El Blanco'),
  (501, 151, 'Espinoza de los Monteros'),
  (502, 151, 'Lara'),
  (503, 151, 'Las Mercedes'),
  (504, 151, 'Manuel Morillo'),
  (505, 151, 'Montaña Verde'),
  (506, 151, 'Montes de Oca'),
  (507, 151, 'Torres'),
  (508, 151, 'Heriberto Arroyo'),
  (509, 151, 'Reyes Vargas'),
  (510, 151, 'Altagracia'),
  (511, 152, 'Siquisique'),
  (512, 152, 'Moroturo'),
  (513, 152, 'San Miguel'),
  (514, 152, 'Xaguas'),
  (515, 179, 'Presidente Betancourt'),
  (516, 179, 'Presidente Páez'),
  (517, 179, 'Presidente Rómulo Gallegos'),
  (518, 179, 'Gabriel Picón González'),
  (519, 179, 'Héctor Amable Mora'),
  (520, 179, 'José Nucete Sardi'),
  (521, 179, 'Pulido Méndez'),
  (522, 180, 'La Azulita'),
  (523, 181, 'Santa Cruz de Mora'),
  (524, 181, 'Mesa Bolívar'),
  (525, 181, 'Mesa de Las Palmas'),
  (526, 182, 'Aricagua'),
  (527, 182, 'San Antonio'),
  (528, 183, 'Canagua'),
  (529, 183, 'Capurí'),
  (530, 183, 'Chacantá'),
  (531, 183, 'El Molino'),
  (532, 183, 'Guaimaral'),
  (533, 183, 'Mucutuy'),
  (534, 183, 'Mucuchachí'),
  (535, 184, 'Fernández Peña'),
  (536, 184, 'Matriz'),
  (537, 184, 'Montalbán'),
  (538, 184, 'Acequias'),
  (539, 184, 'Jají'),
  (540, 184, 'La Mesa'),
  (541, 184, 'San José del Sur'),
  (542, 185, 'Tucaní'),
  (543, 185, 'Florencio Ramírez'),
  (544, 186, 'Santo Domingo'),
  (545, 186, 'Las Piedras'),
  (546, 187, 'Guaraque'),
  (547, 187, 'Mesa de Quintero'),
  (548, 187, 'Río Negro'),
  (549, 188, 'Arapuey'),
  (550, 188, 'Palmira'),
  (551, 189, 'San Cristóbal de Torondoy'),
  (552, 189, 'Torondoy'),
  (553, 190, 'Antonio Spinetti Dini'),
  (554, 190, 'Arias'),
  (555, 190, 'Caracciolo Parra Pérez'),
  (556, 190, 'Domingo Peña'),
  (557, 190, 'El Llano'),
  (558, 190, 'Gonzalo Picón Febres'),
  (559, 190, 'Jacinto Plaza'),
  (560, 190, 'Juan Rodríguez Suárez'),
  (561, 190, 'Lasso de la Vega'),
  (562, 190, 'Mariano Picón Salas'),
  (563, 190, 'Milla'),
  (564, 190, 'Osuna Rodríguez'),
  (565, 190, 'Sagrario'),
  (566, 190, 'El Morro'),
  (567, 190, 'Los Nevados'),
  (568, 191, 'Andrés Eloy Blanco'),
  (569, 191, 'La Venta'),
  (570, 191, 'Piñango'),
  (571, 191, 'Timotes'),
  (572, 192, 'Eloy Paredes'),
  (573, 192, 'San Rafael de Alcázar'),
  (574, 192, 'Santa Elena de Arenales'),
  (575, 193, 'Santa María de Caparo'),
  (576, 194, 'Pueblo Llano'),
  (577, 195, 'Cacute'),
  (578, 195, 'La Toma'),
  (579, 195, 'Mucuchíes'),
  (580, 195, 'Mucurubá'),
  (581, 195, 'San Rafael'),
  (582, 196, 'Gerónimo Maldonado'),
  (583, 196, 'Bailadores'),
  (584, 197, 'Tabay'),
  (585, 198, 'Chiguará'),
  (586, 198, 'Estánquez'),
  (587, 198, 'Lagunillas'),
  (588, 198, 'La Trampa'),
  (589, 198, 'Pueblo Nuevo del Sur'),
  (590, 198, 'San Juan'),
  (591, 199, 'El Amparo'),
  (592, 199, 'El Llano'),
  (593, 199, 'San Francisco'),
  (594, 199, 'Tovar'),
  (595, 200, 'Independencia'),
  (
    596,
    200,
    'María de la Concepción Palacios Blanco'
  ),
  (597, 200, 'Nueva Bolivia'),
  (598, 200, 'Santa Apolonia'),
  (599, 201, 'Caño El Tigre'),
  (600, 201, 'Zea'),
  (601, 223, 'Aragüita'),
  (602, 223, 'Arévalo González'),
  (603, 223, 'Capaya'),
  (604, 223, 'Caucagua'),
  (605, 223, 'Panaquire'),
  (606, 223, 'Ribas'),
  (607, 223, 'El Café'),
  (608, 223, 'Marizapa'),
  (609, 224, 'Cumbo'),
  (610, 224, 'San José de Barlovento'),
  (611, 225, 'El Cafetal'),
  (612, 225, 'Las Minas'),
  (613, 225, 'Nuestra Señora del Rosario'),
  (614, 226, 'Higuerote'),
  (615, 226, 'Curiepe'),
  (616, 226, 'Tacarigua de Brión'),
  (617, 227, 'Mamporal'),
  (618, 228, 'Carrizal'),
  (619, 229, 'Chacao'),
  (620, 230, 'Charallave'),
  (621, 230, 'Las Brisas'),
  (622, 231, 'El Hatillo'),
  (623, 232, 'Altagracia de la Montaña'),
  (624, 232, 'Cecilio Acosta'),
  (625, 232, 'Los Teques'),
  (626, 232, 'El Jarillo'),
  (627, 232, 'San Pedro'),
  (628, 232, 'Tácata'),
  (629, 232, 'Paracotos'),
  (630, 233, 'Cartanal'),
  (631, 233, 'Santa Teresa del Tuy'),
  (632, 234, 'La Democracia'),
  (633, 234, 'Ocumare del Tuy'),
  (634, 234, 'Santa Bárbara'),
  (635, 235, 'San Antonio de los Altos'),
  (636, 236, 'Río Chico'),
  (637, 236, 'El Guapo'),
  (638, 236, 'Tacarigua de la Laguna'),
  (639, 236, 'Paparo'),
  (640, 236, 'San Fernando del Guapo'),
  (641, 237, 'Santa Lucía del Tuy'),
  (642, 238, 'Cúpira'),
  (643, 238, 'Machurucuto'),
  (644, 239, 'Guarenas'),
  (645, 240, 'San Antonio de Yare'),
  (646, 240, 'San Francisco de Yare'),
  (647, 241, 'Leoncio Martínez'),
  (648, 241, 'Petare'),
  (649, 241, 'Caucagüita'),
  (650, 241, 'Filas de Mariche'),
  (651, 241, 'La Dolorita'),
  (652, 242, 'Cúa'),
  (653, 242, 'Nueva Cúa'),
  (654, 243, 'Guatire'),
  (655, 243, 'Bolívar'),
  (656, 258, 'San Antonio de Maturín'),
  (657, 258, 'San Francisco de Maturín'),
  (658, 259, 'Aguasay'),
  (659, 260, 'Caripito'),
  (660, 261, 'El Guácharo'),
  (661, 261, 'La Guanota'),
  (662, 261, 'Sabana de Piedra'),
  (663, 261, 'San Agustín'),
  (664, 261, 'Teresen'),
  (665, 261, 'Caripe'),
  (666, 262, 'Areo'),
  (667, 262, 'Capital Cedeño'),
  (668, 262, 'San Félix de Cantalicio'),
  (669, 262, 'Viento Fresco'),
  (670, 263, 'El Tejero'),
  (671, 263, 'Punta de Mata'),
  (672, 264, 'Chaguaramas'),
  (673, 264, 'Las Alhuacas'),
  (674, 264, 'Tabasca'),
  (675, 264, 'Temblador'),
  (676, 265, 'Alto de los Godos'),
  (677, 265, 'Boquerón'),
  (678, 265, 'Las Cocuizas'),
  (679, 265, 'La Cruz'),
  (680, 265, 'San Simón'),
  (681, 265, 'El Corozo'),
  (682, 265, 'El Furrial'),
  (683, 265, 'Jusepín'),
  (684, 265, 'La Pica'),
  (685, 265, 'San Vicente'),
  (686, 266, 'Aparicio'),
  (687, 266, 'Aragua de Maturín'),
  (688, 266, 'Chaguamal'),
  (689, 266, 'El Pinto'),
  (690, 266, 'Guanaguana'),
  (691, 266, 'La Toscana'),
  (692, 266, 'Taguaya'),
  (693, 267, 'Cachipo'),
  (694, 267, 'Quiriquire'),
  (695, 268, 'Santa Bárbara'),
  (696, 269, 'Barrancas'),
  (697, 269, 'Los Barrancos de Fajardo'),
  (698, 270, 'Uracoa'),
  (699, 271, 'Antolín del Campo'),
  (700, 272, 'Arismendi'),
  (701, 273, 'García'),
  (702, 273, 'Francisco Fajardo'),
  (703, 274, 'Bolívar'),
  (704, 274, 'Guevara'),
  (705, 274, 'Matasiete'),
  (706, 274, 'Santa Ana'),
  (707, 274, 'Sucre'),
  (708, 275, 'Aguirre'),
  (709, 275, 'Maneiro'),
  (710, 276, 'Adrián'),
  (711, 276, 'Juan Griego'),
  (712, 276, 'Yaguaraparo'),
  (713, 277, 'Porlamar'),
  (714, 278, 'San Francisco de Macanao'),
  (715, 278, 'Boca de Río'),
  (716, 279, 'Tubores'),
  (717, 279, 'Los Baleales'),
  (718, 280, 'Vicente Fuentes'),
  (719, 280, 'Villalba'),
  (720, 281, 'San Juan Bautista'),
  (721, 281, 'Zabala'),
  (722, 283, 'Capital Araure'),
  (723, 283, 'Río Acarigua'),
  (724, 284, 'Capital Esteller'),
  (725, 284, 'Uveral'),
  (726, 285, 'Guanare'),
  (727, 285, 'Córdoba'),
  (728, 285, 'San José de la Montaña'),
  (729, 285, 'San Juan de Guanaguanare'),
  (730, 285, 'Virgen de la Coromoto'),
  (731, 286, 'Guanarito'),
  (732, 286, 'Trinidad de la Capilla'),
  (733, 286, 'Divina Pastora'),
  (734, 287, 'Monseñor José Vicente de Unda'),
  (735, 287, 'Peña Blanca'),
  (736, 288, 'Capital Ospino'),
  (737, 288, 'Aparición'),
  (738, 288, 'La Estación'),
  (739, 289, 'Páez'),
  (740, 289, 'Payara'),
  (741, 289, 'Pimpinela'),
  (742, 289, 'Ramón Peraza'),
  (743, 290, 'Papelón'),
  (744, 290, 'Caño Delgadito'),
  (745, 291, 'San Genaro de Boconoito'),
  (746, 291, 'Antolín Tovar'),
  (747, 292, 'San Rafael de Onoto'),
  (748, 292, 'Santa Fe'),
  (749, 292, 'Thermo Morles'),
  (750, 293, 'Santa Rosalía'),
  (751, 293, 'Florida'),
  (752, 294, 'Sucre'),
  (753, 294, 'Concepción'),
  (754, 294, 'San Rafael de Palo Alzado'),
  (755, 294, 'Uvencio Antonio Velásquez'),
  (756, 294, 'San José de Saguaz'),
  (757, 294, 'Villa Rosa'),
  (758, 295, 'Turén'),
  (759, 295, 'Canelones'),
  (760, 295, 'Santa Cruz'),
  (761, 295, 'San Isidro Labrador'),
  (762, 296, 'Mariño'),
  (763, 296, 'Rómulo Gallegos'),
  (764, 297, 'San José de Aerocuar'),
  (765, 297, 'Tavera Acosta'),
  (766, 298, 'Río Caribe'),
  (767, 298, 'Antonio José de Sucre'),
  (768, 298, 'El Morro de Puerto Santo'),
  (769, 298, 'Puerto Santo'),
  (770, 298, 'San Juan de las Galdonas'),
  (771, 299, 'El Pilar'),
  (772, 299, 'El Rincón'),
  (773, 299, 'General Francisco Antonio Váquez'),
  (774, 299, 'Guaraúnos'),
  (775, 299, 'Tunapuicito'),
  (776, 299, 'Unión'),
  (777, 300, 'Santa Catalina'),
  (778, 300, 'Santa Rosa'),
  (779, 300, 'Santa Teresa'),
  (780, 300, 'Bolívar'),
  (781, 300, 'Maracapana'),
  (782, 302, 'Libertad'),
  (783, 302, 'El Paujil'),
  (784, 302, 'Yaguaraparo'),
  (785, 303, 'Cruz Salmerón Acosta'),
  (786, 303, 'Chacopata'),
  (787, 303, 'Manicuare'),
  (788, 304, 'Tunapuy'),
  (789, 304, 'Campo Elías'),
  (790, 305, 'Irapa'),
  (791, 305, 'Campo Claro'),
  (792, 305, 'Maraval'),
  (793, 305, 'San Antonio de Irapa'),
  (794, 305, 'Soro'),
  (795, 306, 'Mejía'),
  (796, 307, 'Cumanacoa'),
  (797, 307, 'Arenas'),
  (798, 307, 'Aricagua'),
  (799, 307, 'Cogollar'),
  (800, 307, 'San Fernando'),
  (801, 307, 'San Lorenzo'),
  (802, 308, 'Villa Frontado (Muelle de Cariaco)'),
  (803, 308, 'Catuaro'),
  (804, 308, 'Rendón'),
  (805, 308, 'San Cruz'),
  (806, 308, 'Santa María'),
  (807, 309, 'Altagracia'),
  (808, 309, 'Santa Inés'),
  (809, 309, 'Valentín Valiente'),
  (810, 309, 'Ayacucho'),
  (811, 309, 'San Juan'),
  (812, 309, 'Raúl Leoni'),
  (813, 309, 'Gran Mariscal'),
  (814, 310, 'Cristóbal Colón'),
  (815, 310, 'Bideau'),
  (816, 310, 'Punta de Piedras'),
  (817, 310, 'Güiria'),
  (818, 341, 'Andrés Bello'),
  (819, 342, 'Antonio Rómulo Costa'),
  (820, 343, 'Ayacucho'),
  (821, 343, 'Rivas Berti'),
  (822, 343, 'San Pedro del Río'),
  (823, 344, 'Bolívar'),
  (824, 344, 'Palotal'),
  (825, 344, 'General Juan Vicente Gómez'),
  (826, 344, 'Isaías Medina Angarita'),
  (827, 345, 'Cárdenas'),
  (828, 345, 'Amenodoro Ángel Lamus'),
  (829, 345, 'La Florida'),
  (830, 346, 'Córdoba'),
  (831, 347, 'Fernández Feo'),
  (832, 347, 'Alberto Adriani'),
  (833, 347, 'Santo Domingo'),
  (834, 348, 'Francisco de Miranda'),
  (835, 349, 'García de Hevia'),
  (836, 349, 'Boca de Grita'),
  (837, 349, 'José Antonio Páez'),
  (838, 350, 'Guásimos'),
  (839, 351, 'Independencia'),
  (840, 351, 'Juan Germán Roscio'),
  (841, 351, 'Román Cárdenas'),
  (842, 352, 'Jáuregui'),
  (843, 352, 'Emilio Constantino Guerrero'),
  (844, 352, 'Monseñor Miguel Antonio Salas'),
  (845, 353, 'José María Vargas'),
  (846, 354, 'Junín'),
  (847, 354, 'La Petrólea'),
  (848, 354, 'Quinimarí'),
  (849, 354, 'Bramón'),
  (850, 355, 'Libertad'),
  (851, 355, 'Cipriano Castro'),
  (852, 355, 'Manuel Felipe Rugeles'),
  (853, 356, 'Libertador'),
  (854, 356, 'Doradas'),
  (855, 356, 'Emeterio Ochoa'),
  (856, 356, 'San Joaquín de Navay'),
  (857, 357, 'Lobatera'),
  (858, 357, 'Constitución'),
  (859, 358, 'Michelena'),
  (860, 359, 'Panamericano'),
  (861, 359, 'La Palmita'),
  (862, 360, 'Pedro María Ureña'),
  (863, 360, 'Nueva Arcadia'),
  (864, 361, 'Delicias'),
  (865, 361, 'Pecaya'),
  (866, 362, 'Samuel Darío Maldonado'),
  (867, 362, 'Boconó'),
  (868, 362, 'Hernández'),
  (869, 363, 'La Concordia'),
  (870, 363, 'San Juan Bautista'),
  (871, 363, 'Pedro María Morantes'),
  (872, 363, 'San Sebastián'),
  (873, 363, 'Dr. Francisco Romero Lobo'),
  (874, 364, 'Seboruco'),
  (875, 365, 'Simón Rodríguez'),
  (876, 366, 'Sucre'),
  (877, 366, 'Eleazar López Contreras'),
  (878, 366, 'San Pablo'),
  (879, 367, 'Torbes'),
  (880, 368, 'Uribante'),
  (881, 368, 'Cárdenas'),
  (882, 368, 'Juan Pablo Peñalosa'),
  (883, 368, 'Potosí'),
  (884, 369, 'San Judas Tadeo'),
  (885, 370, 'Araguaney'),
  (886, 370, 'El Jaguito'),
  (887, 370, 'La Esperanza'),
  (888, 370, 'Santa Isabel'),
  (889, 371, 'Boconó'),
  (890, 371, 'El Carmen'),
  (891, 371, 'Mosquey'),
  (892, 371, 'Ayacucho'),
  (893, 371, 'Burbusay'),
  (894, 371, 'General Ribas'),
  (895, 371, 'Guaramacal'),
  (896, 371, 'Vega de Guaramacal'),
  (897, 371, 'Monseñor Jáuregui'),
  (898, 371, 'Rafael Rangel'),
  (899, 371, 'San Miguel'),
  (900, 371, 'San José'),
  (901, 372, 'Sabana Grande'),
  (902, 372, 'Cheregüé'),
  (903, 372, 'Granados'),
  (904, 373, 'Arnoldo Gabaldón'),
  (905, 373, 'Bolivia'),
  (906, 373, 'Carrillo'),
  (907, 373, 'Cegarra'),
  (908, 373, 'Chejendé'),
  (909, 373, 'Manuel Salvador Ulloa'),
  (910, 373, 'San José'),
  (911, 374, 'Carache'),
  (912, 374, 'La Concepción'),
  (913, 374, 'Cuicas'),
  (914, 374, 'Panamericana'),
  (915, 374, 'Santa Cruz'),
  (916, 375, 'Escuque'),
  (917, 375, 'La Unión'),
  (918, 375, 'Santa Rita'),
  (919, 375, 'Sabana Libre'),
  (920, 376, 'El Socorro'),
  (921, 376, 'Los Caprichos'),
  (922, 376, 'Antonio José de Sucre'),
  (923, 377, 'Campo Elías'),
  (924, 377, 'Arnoldo Gabaldón'),
  (925, 378, 'Santa Apolonia'),
  (926, 378, 'El Progreso'),
  (927, 378, 'La Ceiba'),
  (928, 378, 'Tres de Febrero'),
  (929, 379, 'El Dividive'),
  (930, 379, 'Agua Santa'),
  (931, 379, 'Agua Caliente'),
  (932, 379, 'El Cenizo'),
  (933, 379, 'Valerita'),
  (934, 380, 'Monte Carmelo'),
  (935, 380, 'Buena Vista'),
  (936, 380, 'Santa María del Horcón'),
  (937, 381, 'Motatán'),
  (938, 381, 'El Baño'),
  (939, 381, 'Jalisco'),
  (940, 382, 'Pampán'),
  (941, 382, 'Flor de Patria'),
  (942, 382, 'La Paz'),
  (943, 382, 'Santa Ana'),
  (944, 383, 'Pampanito'),
  (945, 383, 'La Concepción'),
  (946, 383, 'Pampanito II'),
  (947, 384, 'Betijoque'),
  (948, 384, 'José Gregorio Hernández'),
  (949, 384, 'La Pueblita'),
  (950, 384, 'Los Cedros'),
  (951, 385, 'Carvajal'),
  (952, 385, 'Campo Alegre'),
  (953, 385, 'Antonio Nicolás Briceño'),
  (954, 385, 'José Leonardo Suárez'),
  (955, 386, 'Sabana de Mendoza'),
  (956, 386, 'Junín'),
  (957, 386, 'Valmore Rodríguez'),
  (958, 386, 'El Paraíso'),
  (959, 387, 'Andrés Linares'),
  (960, 387, 'Chiquinquirá'),
  (961, 387, 'Cristóbal Mendoza'),
  (962, 387, 'Cruz Carrillo'),
  (963, 387, 'Matriz'),
  (964, 387, 'Monseñor Carrillo'),
  (965, 387, 'Tres Esquinas'),
  (966, 388, 'Cabimbú'),
  (967, 388, 'Jajó'),
  (968, 388, 'La Mesa de Esnujaque'),
  (969, 388, 'Santiago'),
  (970, 388, 'Tuñame'),
  (971, 388, 'La Quebrada'),
  (972, 389, 'Juan Ignacio Montilla'),
  (973, 389, 'La Beatriz'),
  (974, 389, 'La Puerta'),
  (975, 389, 'Mendoza del Valle de Momboy'),
  (976, 389, 'Mercedes Díaz'),
  (977, 389, 'San Luis'),
  (978, 390, 'Caraballeda'),
  (979, 390, 'Carayaca'),
  (980, 390, 'Carlos Soublette'),
  (981, 390, 'Caruao Chuspa'),
  (982, 390, 'Catia La Mar'),
  (983, 390, 'El Junko'),
  (984, 390, 'La Guaira'),
  (985, 390, 'Macuto'),
  (986, 390, 'Maiquetía'),
  (987, 390, 'Naiguatá'),
  (988, 390, 'Urimare'),
  (989, 391, 'Arístides Bastidas'),
  (990, 392, 'Bolívar'),
  (991, 407, 'Chivacoa'),
  (992, 407, 'Campo Elías'),
  (993, 408, 'Cocorote'),
  (994, 409, 'Independencia'),
  (995, 410, 'José Antonio Páez'),
  (996, 411, 'La Trinidad'),
  (997, 412, 'Manuel Monge'),
  (998, 413, 'Salóm'),
  (999, 413, 'Temerla'),
  (1000, 413, 'Nirgua'),
  (1001, 414, 'San Andrés'),
  (1002, 414, 'Yaritagua'),
  (1003, 415, 'San Javier'),
  (1004, 415, 'Albarico'),
  (1005, 415, 'San Felipe'),
  (1006, 416, 'Sucre'),
  (1007, 417, 'Urachiche'),
  (1008, 418, 'El Guayabo'),
  (1009, 418, 'Farriar'),
  (1010, 441, 'Isla de Toas'),
  (1011, 441, 'Monagas'),
  (1012, 442, 'San Timoteo'),
  (1013, 442, 'General Urdaneta'),
  (1014, 442, 'Libertador'),
  (1015, 442, 'Marcelino Briceño'),
  (1016, 442, 'Pueblo Nuevo'),
  (1017, 442, 'Manuel Guanipa Matos'),
  (1018, 443, 'Ambrosio'),
  (1019, 443, 'Carmen Herrera'),
  (1020, 443, 'La Rosa'),
  (1021, 443, 'Germán Ríos Linares'),
  (1022, 443, 'San Benito'),
  (1023, 443, 'Rómulo Betancourt'),
  (1024, 443, 'Jorge Hernández'),
  (1025, 443, 'Punta Gorda'),
  (1026, 443, 'Arístides Calvani'),
  (1027, 444, 'Encontrados'),
  (1028, 444, 'Udón Pérez'),
  (1029, 445, 'Moralito'),
  (1030, 445, 'San Carlos del Zulia'),
  (1031, 445, 'Santa Cruz del Zulia'),
  (1032, 445, 'Santa Bárbara'),
  (1033, 445, 'Urribarrí'),
  (1034, 446, 'Carlos Quevedo'),
  (1035, 446, 'Francisco Javier Pulgar'),
  (1036, 446, 'Simón Rodríguez'),
  (1037, 446, 'Guamo-Gavilanes'),
  (1038, 448, 'La Concepción'),
  (1039, 448, 'San José'),
  (1040, 448, 'Mariano Parra León'),
  (1041, 448, 'José Ramón Yépez'),
  (1042, 449, 'Jesús María Semprún'),
  (1043, 449, 'Barí'),
  (1044, 450, 'Concepción'),
  (1045, 450, 'Andrés Bello'),
  (1046, 450, 'Chiquinquirá'),
  (1047, 450, 'El Carmelo'),
  (1048, 450, 'Potreritos'),
  (1049, 451, 'Libertad'),
  (1050, 451, 'Alonso de Ojeda'),
  (1051, 451, 'Venezuela'),
  (1052, 451, 'Eleazar López Contreras'),
  (1053, 451, 'Campo Lara'),
  (1054, 452, 'Bartolomé de las Casas'),
  (1055, 452, 'Libertad'),
  (1056, 452, 'Río Negro'),
  (1057, 452, 'San José de Perijá'),
  (1058, 453, 'San Rafael'),
  (1059, 453, 'La Sierrita'),
  (1060, 453, 'Las Parcelas'),
  (1061, 453, 'Luis de Vicente'),
  (1062, 453, 'Monseñor Marcos Sergio Godoy'),
  (1063, 453, 'Ricaurte'),
  (1064, 453, 'Tamare'),
  (1065, 454, 'Antonio Borjas Romero'),
  (1066, 454, 'Bolívar'),
  (1067, 454, 'Cacique Mara'),
  (1068, 454, 'Carracciolo Parra Pérez'),
  (1069, 454, 'Cecilio Acosta'),
  (1070, 454, 'Cristo de Aranza'),
  (1071, 454, 'Coquivacoa'),
  (1072, 454, 'Chiquinquirá'),
  (1073, 454, 'Francisco Eugenio Bustamante'),
  (1074, 454, 'Idelfonzo Vásquez'),
  (1075, 454, 'Juana de Ávila'),
  (1076, 454, 'Luis Hurtado Higuera'),
  (1077, 454, 'Manuel Dagnino'),
  (1078, 454, 'Olegario Villalobos'),
  (1079, 454, 'Raúl Leoni'),
  (1080, 454, 'Santa Lucía'),
  (1081, 454, 'Venancio Pulgar'),
  (1082, 454, 'San Isidro'),
  (1083, 455, 'Altagracia'),
  (1084, 455, 'Faría'),
  (1085, 455, 'Ana María Campos'),
  (1086, 455, 'San Antonio'),
  (1087, 455, 'San José'),
  (1088, 456, 'Donaldo García'),
  (1089, 456, 'El Rosario'),
  (1090, 456, 'Sixto Zambrano'),
  (1091, 457, 'San Francisco'),
  (1092, 457, 'El Bajo'),
  (1093, 457, 'Domitila Flores'),
  (1094, 457, 'Francisco Ochoa'),
  (1095, 457, 'Los Cortijos'),
  (1096, 457, 'Marcial Hernández'),
  (1097, 458, 'Santa Rita'),
  (1098, 458, 'El Mene'),
  (1099, 458, 'Pedro Lucas Urribarrí'),
  (1100, 458, 'José Cenobio Urribarrí'),
  (1101, 459, 'Rafael Maria Baralt'),
  (1102, 459, 'Manuel Manrique'),
  (1103, 459, 'Rafael Urdaneta'),
  (1104, 460, 'Bobures'),
  (1105, 460, 'Gibraltar'),
  (1106, 460, 'Heras'),
  (1107, 460, 'Monseñor Arturo Álvarez'),
  (1108, 460, 'Rómulo Gallegos'),
  (1109, 460, 'El Batey'),
  (1110, 461, 'Rafael Urdaneta'),
  (1111, 461, 'La Victoria'),
  (1112, 461, 'Raúl Cuenca'),
  (1113, 447, 'Sinamaica'),
  (1114, 447, 'Alta Guajira'),
  (1115, 447, 'Elías Sánchez Rubio'),
  (1116, 447, 'Guajira'),
  (1117, 462, 'Altagracia'),
  (1118, 462, 'Antímano'),
  (1119, 462, 'Caricuao'),
  (1120, 462, 'Catedral'),
  (1121, 462, 'Coche'),
  (1122, 462, 'El Junquito'),
  (1123, 462, 'El Paraíso'),
  (1124, 462, 'El Recreo'),
  (1125, 462, 'El Valle'),
  (1126, 462, 'La Candelaria'),
  (1127, 462, 'La Pastora'),
  (1128, 462, 'La Vega'),
  (1129, 462, 'Macarao'),
  (1130, 462, 'San Agustín'),
  (1131, 462, 'San Bernardino'),
  (1132, 462, 'San José'),
  (1133, 462, 'San Juan'),
  (1134, 462, 'San Pedro'),
  (1135, 462, 'Santa Rosalía'),
  (1136, 462, 'Santa Teresa'),
  (1137, 462, 'Sucre (Catia)'),
  (1138, 462, '23 de enero');
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `permiso`
  --
  CREATE TABLE `permiso` (
    `idpermiso` int(11) NOT NULL,
    `nombre` varchar(30) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `permiso`
  --
INSERT INTO
  `permiso` (`idpermiso`, `nombre`)
VALUES
  (1, 'Escritorio'),
  (2, 'Almacen'),
  (3, 'Compras'),
  (4, 'Egresos'),
  (5, 'Acceso');
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `personal_access_tokens`
  --
  CREATE TABLE `personal_access_tokens` (
    `id` bigint(20) UNSIGNED NOT NULL,
    `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `tokenable_id` bigint(20) UNSIGNED NOT NULL,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `last_used_at` timestamp NULL DEFAULT NULL,
    `expires_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `registros_log`
  --
INSERT INTO
  `registros_log` (
    `idregistros_log`,
    `operacion`,
    `DatosAnteriores`,
    `fecha_mov`,
    `hora_mov`,
    `tabla_mov`
  )
VALUES
  (
    338,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-14',
    '07:07:22',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    339,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Márquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-14',
    '07:10:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    340,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO ADMINISTRATIVO---\r\nDescripcion: --> ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA',
    '2022-07-14',
    '07:10:32',
    'departamento --> iddepartamento: 1'
  ),
  (
    341,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO ADMINISTRATIVOS---\r\nDescripcion: --> ENCARGADOS DE ADMINISTRACIÓN DE LA EMPRESA',
    '2022-07-14',
    '07:10:38',
    'departamento --> iddepartamento: 1'
  ),
  (
    342,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración',
    '2022-07-14',
    '07:13:52',
    'categoria --> idcategoria: 1'
  ),
  (
    343,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración',
    '2022-07-14',
    '07:15:19',
    'categoria --> idcategoria: 1'
  ),
  (
    344,
    'ELIMINAR\r\n',
    'Nombre_Cat: Accesorios de Sistemas\r\n --> Descripcion: Todo lo Relacionado con cualquier accesorio Tecnologico',
    '2022-07-14',
    '07:15:33',
    'categoria --> idcategoria: 2'
  ),
  (
    345,
    'ACTUALIZAR',
    'nombre: s\r\napellido: s\r\nnum_documento: 1\r\nlogin: aaaa',
    '2022-07-16',
    '05:04:06',
    'usuario --->\r\n\r\nidusuario-> 20'
  ),
  (
    346,
    'ELIMINAR',
    'nombre: s\r\napellido: s\r\nnum_documento: 1\r\nlogin: aaaa',
    '2022-07-16',
    '05:04:12',
    'usuario --->\r\n\r\nidusuario-> 20'
  ),
  (
    347,
    'ACTUALIZAR',
    'nombre: \r\napellido: \r\nnum_documento: \r\nlogin: ',
    '2022-07-16',
    '05:04:16',
    'usuario --->\r\n\r\nidusuario-> 19'
  ),
  (
    348,
    'ELIMINAR',
    'nombre: \r\napellido: \r\nnum_documento: \r\nlogin: ',
    '2022-07-16',
    '05:04:20',
    'usuario --->\r\n\r\nidusuario-> 19'
  ),
  (
    349,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-21',
    '09:50:59',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    350,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '06:41:37',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    351,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-22',
    '06:41:43',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    352,
    'ACTUALIZAR',
    'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar',
    '2022-07-22',
    '06:41:46',
    'usuario --->\r\n\r\nidusuario-> 22'
  ),
  (
    353,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '06:59:14',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    354,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-22',
    '09:29:47',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    355,
    'ACTUALIZAR',
    'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar',
    '2022-07-22',
    '09:33:32',
    'usuario --->\r\n\r\nidusuario-> 22'
  ),
  (
    356,
    'ACTUALIZAR',
    'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30134587\r\nlogin: gabriel',
    '2022-07-22',
    '10:21:44',
    'usuario --->\r\n\r\nidusuario-> 23'
  ),
  (
    357,
    'ELIMINAR',
    'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30134587\r\nlogin: gabriel',
    '2022-07-22',
    '10:21:51',
    'usuario --->\r\n\r\nidusuario-> 23'
  ),
  (
    358,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '20:57:21',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    359,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Márquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:12:55',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    360,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:18:24',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    361,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:20:06',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    362,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:22:01',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    363,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:23:10',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    364,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:23:18',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    365,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:23:26',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    366,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:23:51',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    367,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:30:36',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    368,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:31:33',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    369,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:31:47',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    370,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:31:58',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    371,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:32:22',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    372,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:33:56',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    373,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:34:50',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    374,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:38:15',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    375,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:40:03',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    376,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:41:42',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    377,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-22',
    '21:43:44',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    378,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-23',
    '01:44:49',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    379,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-23',
    '01:45:06',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    380,
    'ACTUALIZAR',
    'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-23',
    '01:45:24',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    381,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-23',
    '03:19:29',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    382,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-23',
    '04:31:54',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    383,
    'ACTUALIZAR',
    'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar',
    '2022-07-23',
    '04:36:55',
    'usuario --->\r\n\r\nidusuario-> 22'
  ),
  (
    384,
    'ACTUALIZAR',
    'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar',
    '2022-07-23',
    '04:39:33',
    'usuario --->\r\n\r\nidusuario-> 22'
  ),
  (
    386,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO DE PRUEBAS---\r\nDescripcion: --> DEPARTAMENTO ENCARGADO DE LAS PRUEBAS',
    '2022-07-23',
    '06:06:43',
    'departamento --> iddepartamento: 9'
  ),
  (
    387,
    'ELIMINAR',
    'Nombre_Departamento: DEPARTAMENTO DE PRUEBAS---\r\n --> Descripcion: DEPARTAMENTO ENCARGADO DE LAS PRUEBA',
    '2022-07-23',
    '06:06:46',
    'departamento --> iddepartamento: 9'
  ),
  (
    388,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ',
    '2022-07-23',
    '06:07:07',
    'departamento --> iddepartamento: 8'
  ),
  (
    389,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ',
    '2022-07-23',
    '06:07:11',
    'departamento --> iddepartamento: 8'
  ),
  (
    390,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ',
    '2022-07-23',
    '06:07:16',
    'departamento --> iddepartamento: 8'
  ),
  (
    391,
    'ACTUALIZAR',
    'Nombre_Departamento: DEPARTAMENTO DE TRANSPORTE---\r\nDescripcion: --> ENCARGADOS DEL TRANSPORTE EN LA EMPRESA ',
    '2022-07-23',
    '06:07:36',
    'departamento --> iddepartamento: 8'
  ),
  (
    392,
    'ELIMINAR',
    'Nombre_Departamento: SSSSS---\r\n --> Descripcion: SSSSSSS',
    '2022-07-23',
    '06:43:01',
    'departamento --> iddepartamento: 10'
  ),
  (
    393,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: AAAAAA\r\n --> Descripcion: SSSSSSS',
    '2022-07-23',
    '09:59:14',
    'categoria --> idcategoria: 5'
  ),
  (
    394,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: S\r\n --> Descripcion: SSSSSSS',
    '2022-07-23',
    '09:59:14',
    'categoria --> idcategoria: 5'
  ),
  (
    395,
    'ELIMINAR\r\n',
    'Nombre_Cat: S\r\n --> Descripcion: SSSSSSS',
    '2022-07-23',
    '09:59:16',
    'categoria --> idcategoria: 5'
  ),
  (
    396,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: Articulos de Oficina\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración',
    '2022-07-24',
    '08:38:50',
    'categoria --> idcategoria: 1'
  ),
  (
    397,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: ARTICULO DE OFICINA\r\n --> Descripcion: Todo lo relacionado con la papeleria y herramientas usadas en el área de Administración',
    '2022-07-24',
    '08:38:50',
    'categoria --> idcategoria: 1'
  ),
  (
    398,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: DD\r\n --> Descripcion: DDDDD',
    '2022-07-24',
    '08:39:01',
    'categoria --> idcategoria: 6'
  ),
  (
    399,
    'ACTUALIZAR\r\n',
    'Nombre_Cat: DD\r\n --> Descripcion: DDDDD',
    '2022-07-24',
    '08:39:05',
    'categoria --> idcategoria: 6'
  ),
  (
    400,
    'ELIMINAR\r\n',
    'Nombre_Cat: DD\r\n --> Descripcion: DDDDD',
    '2022-07-24',
    '08:39:08',
    'categoria --> idcategoria: 6'
  ),
  (
    401,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '13:32:52',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    402,
    'ACTUALIZAR',
    'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '13:33:10',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    403,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:01:08',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    404,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:02:43',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    405,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:30:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    406,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:45:38',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    407,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:48:26',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    408,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:49:32',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    409,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:50:11',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    410,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:50:17',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    411,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:50:22',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    412,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:50:42',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    413,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:52:50',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    414,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:52:53',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    415,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:54:45',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    416,
    'ACTUALIZAR',
    'nombre: Islender\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:54:52',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    417,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:55:58',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    418,
    'ACTUALIZAR',
    'nombre: Islender Denilso\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:56:02',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    419,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:56:05',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    420,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-07-24',
    '14:56:17',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    421,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-26',
    '16:08:07',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    422,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-26',
    '16:08:42',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    423,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-26',
    '16:08:49',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    424,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-26',
    '16:09:50',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    425,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-07-26',
    '16:13:20',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    426,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-17',
    '23:22:37',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    427,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-17',
    '23:23:25',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    428,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '17:59:11',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    429,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '18:01:57',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    430,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '18:02:07',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    431,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '18:03:27',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    432,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '18:04:44',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    433,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '18:04:51',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    434,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:11:27',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    435,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:12:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    436,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:22:28',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    437,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:23:45',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    438,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:27:51',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    439,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:28:00',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    440,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:28:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    441,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:28:16',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    442,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:30:42',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    443,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:31:30',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    444,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:34:56',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    445,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:35:10',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    446,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:35:49',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    447,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '21:39:11',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    448,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-20',
    '22:51:50',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    449,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '11:57:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    450,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '11:57:31',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    451,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '11:58:39',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    452,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:00:11',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    453,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:00:27',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    454,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:00:51',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    455,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:01:04',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    456,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:01:40',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    457,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:02:37',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    458,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:03:01',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    459,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:04:42',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    460,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-21',
    '12:05:09',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    461,
    'ACTUALIZAR',
    'nombre: Prueba Laravel\r\napellido: 1.0\r\nnum_documento: 111111\r\nlogin: prueba',
    '2022-08-22',
    '18:54:15',
    'usuario --->\r\n\r\nidusuario-> 25'
  ),
  (
    462,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-22',
    '19:49:07',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    463,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-22',
    '19:56:57',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    464,
    'ACTUALIZAR',
    'nombre: Prueba Laravel\r\napellido: 1.0\r\nnum_documento: 111111\r\nlogin: prueba',
    '2022-08-22',
    '21:30:38',
    'usuario --->\r\n\r\nidusuario-> 25'
  ),
  (
    465,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-08-22',
    '21:33:27',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    466,
    'ACTUALIZAR',
    'nombre: Cesar\r\napellido: Colmenares\r\nnum_documento: 28195144\r\nlogin: Cesar',
    '2022-08-22',
    '21:36:27',
    'usuario --->\r\n\r\nidusuario-> 22'
  ),
  (
    467,
    'ACTUALIZAR',
    'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriel',
    '2022-08-22',
    '21:36:32',
    'usuario --->\r\n\r\nidusuario-> 24'
  ),
  (
    468,
    'ACTUALIZAR',
    'nombre: Jose Manuel\r\napellido: Gonzalez\r\nnum_documento: 30145587\r\nlogin: jose',
    '2022-08-22',
    '21:37:03',
    'usuario --->\r\n\r\nidusuario-> 21'
  ),
  (
    474,
    'ACTUALIZAR',
    'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriel',
    '2022-08-22',
    '23:15:45',
    'usuario --->\r\n\r\nidusuario-> 24'
  ),
  (
    475,
    'ACTUALIZAR',
    'nombre: Gabriel\r\napellido: Montilva\r\nnum_documento: 30159951\r\nlogin: gabriels',
    '2022-08-22',
    '23:15:56',
    'usuario --->\r\n\r\nidusuario-> 24'
  ),
  (
    482,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '15:02:15',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    483,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '15:02:33',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    484,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '17:21:39',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    485,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '17:24:55',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    486,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '17:25:04',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    487,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-23',
    '17:26:08',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    488,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:13:15',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    489,
    'ACTUALIZAR',
    'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros',
    '2022-08-24',
    '20:16:29',
    'usuario --->\r\n\r\nidusuario-> 27'
  ),
  (
    490,
    'ACTUALIZAR',
    'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros',
    '2022-08-24',
    '20:16:34',
    'usuario --->\r\n\r\nidusuario-> 27'
  ),
  (
    491,
    'ACTUALIZAR',
    'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros',
    '2022-08-24',
    '20:17:15',
    'usuario --->\r\n\r\nidusuario-> 27'
  ),
  (
    492,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:48:06',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    493,
    'ACTUALIZAR',
    'nombre: Pedro\r\napellido: Perez\r\nnum_documento: 1115564\r\nlogin: pedros',
    '2022-08-24',
    '20:48:17',
    'usuario --->\r\n\r\nidusuario-> 27'
  ),
  (
    494,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:51:16',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    495,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:52:44',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    496,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:52:47',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    497,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:53:18',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    498,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:53:26',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    499,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:54:50',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    500,
    'ACTUALIZAR',
    'nombre: aaa\r\napellido: Perez\r\nnum_documento: 3333\r\nlogin: otro',
    '2022-08-24',
    '20:54:53',
    'usuario --->\r\n\r\nidusuario-> 28'
  ),
  (
    501,
    'ACTUALIZAR',
    'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 444866622\r\nlogin: borrarss',
    '2022-08-24',
    '21:09:11',
    'usuario --->\r\n\r\nidusuario-> 33'
  ),
  (
    502,
    'ELIMINAR',
    'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 444866622\r\nlogin: borrarss',
    '2022-08-24',
    '21:09:17',
    'usuario --->\r\n\r\nidusuario-> 33'
  ),
  (
    503,
    'ACTUALIZAR',
    'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 4448666\r\nlogin: borrar',
    '2022-08-24',
    '21:09:29',
    'usuario --->\r\n\r\nidusuario-> 29'
  ),
  (
    504,
    'ELIMINAR',
    'nombre: dsadad\r\napellido: sdadvv\r\nnum_documento: 4448666\r\nlogin: borrar',
    '2022-08-24',
    '21:09:34',
    'usuario --->\r\n\r\nidusuario-> 29'
  ),
  (
    505,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-25',
    '20:51:25',
    'usuario --->\r\n\r\nidusuario-> 1'
  ),
  (
    506,
    'ACTUALIZAR',
    'nombre: Islender Denilson\r\napellido: Montilva Marquez\r\nnum_documento: 28195178\r\nlogin: admin',
    '2022-08-26',
    '12:41:30',
    'usuario --->\r\n\r\nidusuario-> 1'
  );
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Volcado de datos para la tabla `salario_base`
  --
INSERT INTO
  `salario_base` (
    `salario_base_id`,
    `id_usuario`,
    `salario`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    1,
    '380',
    '2022-09-03 23:11:54',
    '2022-09-11 03:11:52'
  );
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
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;
--
  -- Volcado de datos para la tabla `tipousuario`
  --
INSERT INTO
  `tipousuario` (
    `idtipousuario`,
    `nombre_t`,
    `descripcion`,
    `created_at`,
    `idusuario`,
    `estadot`,
    `updated_at`
  )
VALUES
  (
    1,
    'ADMINISTRADOR',
    'CON PRIVILEGIOS DE GESTIONAR TODO EL SISTEMA',
    '2020-10-31 15:27:02',
    '1',
    1,
    '2022-08-24 23:02:29'
  ),
  (
    5,
    'DEPOSITARIO',
    'ENCARGADOS DEL INVENTARIO DE LA INSTITUCIÓN',
    '2020-11-01 12:15:17',
    '1',
    1,
    '2022-08-24 23:02:29'
  ),
  (
    7,
    'SISTEMAS',
    'ENCARGADO DEL SISTEMA Y TIENE PRIVILEGIOS SIMILARES AL ADMINISTRADOR',
    '2020-11-01 12:09:09',
    '1',
    1,
    '2022-08-24 23:02:29'
  ),
  (
    8,
    'CHOFER',
    'ENCARGADOS DE HACER USO DEL TRANSPORTE DE LA EMPRESA',
    '2022-07-08 07:40:38',
    '1',
    1,
    '2022-08-24 23:02:29'
  ),
  (
    9,
    'ADMINISTRATIVO',
    'NOMINAS, VIAJESss',
    '2022-07-22 13:50:00',
    '1',
    1,
    '2022-08-24 23:37:20'
  );
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
    `imagen` varchar(200) NOT NULL,
    `condicion` tinyint(4) NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `usuarios`
  --
INSERT INTO
  `usuarios` (
    `idusuario`,
    `nombre`,
    `apellido`,
    `tipo_documento`,
    `num_documento`,
    `direccion`,
    `telefono`,
    `email`,
    `cargo`,
    `login`,
    `idtipousuario`,
    `iddepartamento`,
    `password`,
    `remember_token`,
    `imagen`,
    `condicion`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1,
    'Islender Denilson',
    'Montilva Marquez',
    'Cedula',
    '28195178',
    'San Josecito',
    '(424) 765-0285',
    'islenderdenilson@gmail.com',
    'ADMINISTRADOR',
    'admin',
    1,
    1,
    '$2y$10$mRR/J9g.SPg2XaBfrftS7.65COnn1HPS8wxeLlNMF9T0HBWZ9aaBm',
    '',
    '1664677526-1635476098.png',
    1,
    '2022-08-17 13:06:32',
    '2022-10-01 22:25:26'
  ),
  (
    21,
    'Jose Manuel',
    'Gonzalez',
    'RIF',
    '30145587',
    'San Josecito',
    '(424) 777-7777',
    'joseinvestigue@gmail.com',
    'Sistema',
    'jose',
    9,
    1,
    '8df6a5a36dd94925883e78879c6a3721af43d6880c3da6c53ed47234f665047c',
    '',
    '1661220207-3123.jpg',
    1,
    '2022-08-17 13:06:32',
    '2022-08-22 22:07:03'
  ),
  (
    22,
    'Cesar',
    'Colmenares',
    'Cedula',
    '28195144',
    'La E.................---',
    '(424) 589-6552',
    'cesarcolmenares@gmail.com',
    'Administrativos',
    'Cesar',
    5,
    1,
    '63d1a75b61a05d3c76c840449a47f888c81260982cb8a7dd7b5ea9aaa7c63539',
    '',
    'user_icon_default.png',
    1,
    '2022-08-17 13:06:32',
    '2022-08-17 13:06:32'
  ),
  (
    24,
    'Gabriel',
    'Montilva',
    'Cedula',
    '30159951',
    'Vega de Aza',
    '(424) 765-0285',
    'gmontilva@gmail.com',
    'APOYO',
    'gabriel',
    1,
    7,
    '142b1770f7426daaf0a03c03afbc3fe6c023de163a31b5d87517cf78d16dffdb',
    '',
    'user_icon_default.png',
    1,
    '2022-08-17 13:06:32',
    '2022-08-22 23:45:56'
  ),
  (
    25,
    'Prueba Laravel',
    '1.0',
    'Cedula',
    '111111',
    'asdadad',
    '(063) 052-____',
    'asdad@gmail.com',
    'aaa',
    'prueba',
    1,
    1,
    '123',
    '',
    '1661220038-lagarra.png',
    1,
    '2022-08-17 14:10:51',
    '2022-08-22 22:00:38'
  ),
  (
    26,
    'aa',
    'aaa',
    'Cedula',
    '222321',
    'aaaa',
    '(323) 232-323_',
    'aa@aa.caa',
    'adasd',
    'pruebasss',
    1,
    1,
    '$2y$10$nkKnqJOOGsyrD5k4CC1V2OfLQpJ4mN3ydv3e65p1ejHYoQhjOPY.G',
    'NULL',
    'user_icon_default.png',
    1,
    '2022-08-24 00:42:25',
    '2022-08-24 00:42:25'
  ),
  (
    27,
    'Pedro',
    'Perez',
    'Cedula',
    '1115564',
    'Caracas',
    '(424) 744-6555',
    'pedro@g.com',
    'Analista',
    'pedros',
    1,
    7,
    '$2y$10$sZbPFfde/LBtjLcKRc8TTO1xwOMHk4/Snb2IZq1WbxZvKgv6MWCsm',
    '3UH3V1oJRoBWgjjuPAOVLA2wLSoF2zxnWuCw3xZqI48LpMWFZswRNxAY8tYS',
    'user_icon_default.png',
    1,
    '2022-08-24 00:44:52',
    '2022-08-24 21:18:17'
  ),
  (
    28,
    'aaa',
    'Perez',
    'Cedula',
    '3333',
    'Caracasaa',
    '(111) 445-____',
    'asas@a.com',
    'addd',
    'otro',
    1,
    1,
    '$2y$10$Ff5jWHS53WwgQ7/Fll.J4.rW8HXuVg.hleL26pcT18jzEAnc9ktQW',
    'NULL',
    'user_icon_default.png',
    0,
    '2022-08-24 13:59:36',
    '2022-08-24 21:24:53'
  ),
  (
    34,
    'asdsad',
    'asdda',
    'Cedula',
    '231231',
    '3123123sd',
    '(123) 123-123_',
    'nnn@dad.com',
    'adsdada',
    'aaa',
    1,
    1,
    '$2y$10$cRmDx87wNhZPy.mcTH8/wePcqqMeOol9jhxzYK1FUUBN8DOk/zsoK',
    'NULL',
    'user_icon_default.png',
    1,
    '2022-08-25 22:55:06',
    '2022-08-25 22:55:06'
  ),
  (
    35,
    'aa',
    'dada',
    'Cedula',
    '32424',
    'Caracas',
    '(323) 232-323_',
    'aa@aa.caa',
    'adada',
    '3432',
    1,
    1,
    '$2y$10$3h1flHm5e44vHgCdHyhDYurNTypc9GrLKbShHB5DMpXBHu.WGtPoe',
    'NULL',
    'user_icon_default.png',
    1,
    '2022-10-01 20:18:46',
    '2022-10-01 20:18:46'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `usuario_permiso`
  --
  CREATE TABLE `usuario_permiso` (
    `idusuario_permiso` int(11) NOT NULL,
    `idusuario` int(11) NOT NULL,
    `idpermiso` int(11) NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
  -- Volcado de datos para la tabla `usuario_permiso`
  --
INSERT INTO
  `usuario_permiso` (
    `idusuario_permiso`,
    `idusuario`,
    `idpermiso`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    1310,
    22,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1311,
    22,
    2,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1312,
    22,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1313,
    22,
    4,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1314,
    22,
    5,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1386,
    1,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1387,
    1,
    2,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1388,
    1,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1389,
    1,
    4,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1390,
    1,
    5,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1399,
    25,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1400,
    25,
    2,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1401,
    25,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1402,
    25,
    4,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1403,
    25,
    5,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1409,
    21,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1410,
    21,
    2,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1411,
    21,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1412,
    21,
    4,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1413,
    21,
    5,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1414,
    24,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1415,
    24,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1416,
    24,
    5,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1417,
    28,
    1,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1418,
    28,
    2,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  ),
  (
    1419,
    28,
    3,
    '2022-10-09 00:22:17',
    '2022-10-09 00:22:17'
  );
-- --------------------------------------------------------
  --
  -- Estructura de tabla para la tabla `viajes`
  --
  CREATE TABLE `viajes` (
    `viajes_id` int(11) NOT NULL,
    `viajes_idusuario` int(11) NOT NULL,
    `viajes_codigo` varchar(100) NOT NULL,
    `viajes_idchofer` int(11) NOT NULL,
    `viajes_idchuto` int(11) NOT NULL,
    `viajes_idcava` int(11) NOT NULL,
    `viajes_idflete_ida` int(11) DEFAULT NULL,
    `viajes_idflete_retorno` int(11) DEFAULT NULL,
    `viajes_descripciondelacargar` varchar(200) NOT NULL,
    `viajes_dia_salida` date NOT NULL,
    `viajes_dia_retorno` date NOT NULL,
    `viajes_observaciones` varchar(200) NOT NULL,
    `viajes_estado` int(11) NOT NULL DEFAULT 0,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
  -- Volcado de datos para la tabla `viajes`
  --
INSERT INTO
  `viajes` (
    `viajes_id`,
    `viajes_idusuario`,
    `viajes_codigo`,
    `viajes_idchofer`,
    `viajes_idchuto`,
    `viajes_idcava`,
    `viajes_idflete_ida`,
    `viajes_idflete_retorno`,
    `viajes_descripciondelacargar`,
    `viajes_dia_salida`,
    `viajes_dia_retorno`,
    `viajes_observaciones`,
    `viajes_estado`,
    `created_at`,
    `updated_at`
  )
VALUES
  (
    7,
    1,
    'flete23',
    14,
    6,
    10,
    18,
    16,
    'carga',
    '2022-09-24',
    '2022-10-08',
    'adada',
    1,
    '2022-09-24 20:30:05',
    '2022-10-03 16:43:40'
  ),
  (
    8,
    1,
    'flete2',
    10,
    7,
    11,
    17,
    NULL,
    'arroz',
    '2022-09-24',
    '2022-10-01',
    'adasda',
    1,
    '2022-09-24 20:52:08',
    '2022-10-02 19:21:19'
  ),
  (
    9,
    1,
    'flete5',
    12,
    8,
    12,
    15,
    NULL,
    'Balas',
    '2022-10-01',
    '2022-10-01',
    'algo',
    1,
    '2022-09-26 01:32:15',
    '2022-09-30 20:43:33'
  ),
  (
    10,
    1,
    '12265',
    19,
    9,
    14,
    21,
    22,
    'Marimba',
    '2022-09-28',
    '2022-10-06',
    'Suerte',
    1,
    '2022-09-27 00:42:57',
    '2022-09-30 20:43:05'
  ),
  (
    11,
    1,
    'viaje03102022',
    10,
    9,
    13,
    19,
    20,
    'arroz',
    '2022-10-03',
    '2022-10-06',
    'sin manifiestos',
    1,
    '2022-10-03 00:44:36',
    '2022-10-03 00:44:45'
  ),
  (
    12,
    1,
    'viaje03102022-1',
    12,
    9,
    13,
    23,
    24,
    'Cauchos',
    '2022-10-03',
    '2022-10-07',
    '150 cauchos',
    1,
    '2022-10-03 00:49:43',
    '2022-10-03 00:49:53'
  ),
  (
    13,
    1,
    'viaje03102022-2',
    20,
    7,
    13,
    25,
    26,
    'arroz',
    '2022-10-03',
    '2022-10-06',
    '10 toneladas',
    1,
    '2022-10-03 16:56:51',
    '2022-10-03 16:57:30'
  ),
  (
    14,
    1,
    '222',
    10,
    7,
    10,
    27,
    NULL,
    'arroz',
    '2022-10-04',
    '2022-10-07',
    'sin manifiestos',
    1,
    '2022-10-04 19:11:18',
    '2022-10-04 19:12:10'
  ),
  (
    15,
    1,
    'pruebass',
    12,
    8,
    13,
    NULL,
    28,
    'zapatos',
    '2022-10-06',
    '2022-10-08',
    'sin manifiestos',
    1,
    '2022-10-05 22:05:56',
    '2022-10-05 22:06:03'
  ),
  (
    16,
    1,
    'pruebavista',
    12,
    6,
    10,
    29,
    NULL,
    'prueba',
    '2022-10-05',
    '2022-10-07',
    'suerte',
    1,
    '2022-10-05 22:55:46',
    '2022-10-05 22:55:56'
  ),
  (
    17,
    1,
    'comprobante',
    20,
    8,
    10,
    30,
    NULL,
    'arina de maiz',
    '2022-10-05',
    '2022-10-07',
    '3 toneladas de arina de maiz',
    0,
    '2022-10-05 23:20:06',
    '2022-10-05 23:20:06'
  ),
  (
    18,
    1,
    'prueba123',
    12,
    7,
    13,
    31,
    NULL,
    'carne',
    '2022-10-06',
    '2022-10-03',
    '123',
    0,
    '2022-10-06 21:53:08',
    '2022-10-06 21:53:08'
  ),
  (
    19,
    1,
    'auditoria1',
    14,
    6,
    11,
    32,
    NULL,
    '12313',
    '2022-10-07',
    '2022-10-08',
    '12313',
    0,
    '2022-10-07 01:43:31',
    '2022-10-07 01:45:06'
  );
--
  -- Índices para tablas volcadas
  --
  --
  -- Indices de la tabla `almacen`
  --
ALTER TABLE
  `almacen`
ADD
  PRIMARY KEY (`idalmacen`),
ADD
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
ADD
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
ADD
  KEY `fk_articulo_usuario_idx` (`idusuario`);
--
  -- Indices de la tabla `asignacion_nomina`
  --
ALTER TABLE
  `asignacion_nomina`
ADD
  PRIMARY KEY (`id_asignacion`),
ADD
  KEY `asignacion_nomina_ibfk_2` (`id_nomina`);
--
  -- Indices de la tabla `audits`
  --
ALTER TABLE
  `audits`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `audits_auditable_type_auditable_id_index` (`auditable_type`, `auditable_id`),
ADD
  KEY `audits_user_id_user_type_index` (`user_id`, `user_type`);
--
  -- Indices de la tabla `cavas`
  --
ALTER TABLE
  `cavas`
ADD
  PRIMARY KEY (`cava_id`),
ADD
  KEY `camiones_ibfk_1` (`cava_idusuario`),
ADD
  KEY `cava_placa` (`cava_placa`);
--
  -- Indices de la tabla `choferes`
  --
ALTER TABLE
  `choferes`
ADD
  PRIMARY KEY (`chofer_id`),
ADD
  KEY `chofer_idempleado` (`chofer_idempleado`);
--
  -- Indices de la tabla `chutos`
  --
ALTER TABLE
  `chutos`
ADD
  PRIMARY KEY (`chuto_id`),
ADD
  KEY `camiones_ibfk_1` (`chuto_idusuario`),
ADD
  KEY `chuto_placa` (`chuto_placa`);
--
  -- Indices de la tabla `deduccion_nomina`
  --
ALTER TABLE
  `deduccion_nomina`
ADD
  PRIMARY KEY (`id_deduccion`),
ADD
  KEY `deduccion_nomina_ibfk_1` (`id_nomina`);
--
  -- Indices de la tabla `departamento`
  --
ALTER TABLE
  `departamento`
ADD
  PRIMARY KEY (`iddepartamento`),
ADD
  KEY `idusuario` (`idusuario`);
--
  -- Indices de la tabla `empleado`
  --
ALTER TABLE
  `empleado`
ADD
  PRIMARY KEY (`id_emp`),
ADD
  UNIQUE KEY `cedula_UNIQUE` (`cedula`),
ADD
  KEY `fk_empleado_departamento_idx` (`iddepartamento`);
--
  -- Indices de la tabla `estados`
  --
ALTER TABLE
  `estados`
ADD
  PRIMARY KEY (`id_estado`);
--
  -- Indices de la tabla `fletes`
  --
ALTER TABLE
  `fletes`
ADD
  PRIMARY KEY (`flete_id`),
ADD
  KEY `camiones_ibfk_1` (`flete_idusuario`),
ADD
  KEY `fletes_ibfk_1` (`flete_destino_estado`),
ADD
  KEY `flete_destino_municipio` (`flete_destino_municipio`),
ADD
  KEY `flete_destino_parroquia` (`flete_destino_parroquia`),
ADD
  KEY `flete_codigo` (`flete_codigo`);
--
  -- Indices de la tabla `migrations`
  --
ALTER TABLE
  `migrations`
ADD
  PRIMARY KEY (`id`);
--
  -- Indices de la tabla `municipios`
  --
ALTER TABLE
  `municipios`
ADD
  PRIMARY KEY (`id_municipio`),
ADD
  KEY `id_estado` (`id_estado`);
--
  -- Indices de la tabla `nomina_choferes`
  --
ALTER TABLE
  `nomina_choferes`
ADD
  PRIMARY KEY (`id_nomina_chofer`),
ADD
  KEY `id_chofer` (`id_chofer`),
ADD
  KEY `id_viaje` (`id_viaje`);
--
  -- Indices de la tabla `pago_nomina`
  --
ALTER TABLE
  `pago_nomina`
ADD
  PRIMARY KEY (`id_nomina`),
ADD
  KEY `pago_nomina_ibfk_1` (`id_empleado`),
ADD
  KEY `pago_nomina_ibfk_2` (`id_usuario`);
--
  -- Indices de la tabla `parroquias`
  --
ALTER TABLE
  `parroquias`
ADD
  PRIMARY KEY (`id_parroquia`),
ADD
  KEY `id_municipio` (`id_municipio`);
--
  -- Indices de la tabla `permiso`
  --
ALTER TABLE
  `permiso`
ADD
  PRIMARY KEY (`idpermiso`);
--
  -- Indices de la tabla `personal_access_tokens`
  --
ALTER TABLE
  `personal_access_tokens`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
ADD
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`);
--
  -- Indices de la tabla `registros_log`
  --
ALTER TABLE
  `registros_log`
ADD
  PRIMARY KEY (`idregistros_log`);
--
  -- Indices de la tabla `salario_base`
  --
ALTER TABLE
  `salario_base`
ADD
  PRIMARY KEY (`salario_base_id`),
ADD
  KEY `id_usuario` (`id_usuario`);
--
  -- Indices de la tabla `tipousuario`
  --
ALTER TABLE
  `tipousuario`
ADD
  PRIMARY KEY (`idtipousuario`);
--
  -- Indices de la tabla `usuarios`
  --
ALTER TABLE
  `usuarios`
ADD
  PRIMARY KEY (`idusuario`),
ADD
  UNIQUE KEY `login_UNIQUE` (`login`),
ADD
  UNIQUE KEY `num_documento` (`num_documento`),
ADD
  KEY `fk_usuario_tipousuario_idx` (`idtipousuario`),
ADD
  KEY `fk_usuario_departamento_idx` (`iddepartamento`);
--
  -- Indices de la tabla `usuario_permiso`
  --
ALTER TABLE
  `usuario_permiso`
ADD
  PRIMARY KEY (`idusuario_permiso`),
ADD
  KEY `fk_u_permiso_usuario_idx` (`idusuario`),
ADD
  KEY `fk_usuario_permiso_idx` (`idpermiso`);
--
  -- Indices de la tabla `viajes`
  --
ALTER TABLE
  `viajes`
ADD
  PRIMARY KEY (`viajes_id`),
ADD
  KEY `viajes_idusuario` (`viajes_idusuario`),
ADD
  KEY `viajes_idchuto` (`viajes_idchuto`),
ADD
  KEY `viajes_idchofer` (`viajes_idchofer`),
ADD
  KEY `viajes_idcava` (`viajes_idcava`),
ADD
  KEY `viajes_idflete_ida` (`viajes_idflete_ida`),
ADD
  KEY `viajes_idflete_retorno` (`viajes_idflete_retorno`);
--
  -- AUTO_INCREMENT de las tablas volcadas
  --
  --
  -- AUTO_INCREMENT de la tabla `almacen`
  --
ALTER TABLE
  `almacen`
MODIFY
  `idalmacen` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 50;
--
  -- AUTO_INCREMENT de la tabla `asignacion_nomina`
  --
ALTER TABLE
  `asignacion_nomina`
MODIFY
  `id_asignacion` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;
--
  -- AUTO_INCREMENT de la tabla `audits`
  --
ALTER TABLE
  `audits`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;
--
  -- AUTO_INCREMENT de la tabla `cavas`
  --
ALTER TABLE
  `cavas`
MODIFY
  `cava_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 15;
--
  -- AUTO_INCREMENT de la tabla `choferes`
  --
ALTER TABLE
  `choferes`
MODIFY
  `chofer_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13;
--
  -- AUTO_INCREMENT de la tabla `chutos`
  --
ALTER TABLE
  `chutos`
MODIFY
  `chuto_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 14;
--
  -- AUTO_INCREMENT de la tabla `deduccion_nomina`
  --
ALTER TABLE
  `deduccion_nomina`
MODIFY
  `id_deduccion` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;
--
  -- AUTO_INCREMENT de la tabla `departamento`
  --
ALTER TABLE
  `departamento`
MODIFY
  `iddepartamento` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 12;
--
  -- AUTO_INCREMENT de la tabla `empleado`
  --
ALTER TABLE
  `empleado`
MODIFY
  `id_emp` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 21;
--
  -- AUTO_INCREMENT de la tabla `estados`
  --
ALTER TABLE
  `estados`
MODIFY
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 26;
--
  -- AUTO_INCREMENT de la tabla `fletes`
  --
ALTER TABLE
  `fletes`
MODIFY
  `flete_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 33;
--
  -- AUTO_INCREMENT de la tabla `migrations`
  --
ALTER TABLE
  `migrations`
MODIFY
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
  -- AUTO_INCREMENT de la tabla `municipios`
  --
ALTER TABLE
  `municipios`
MODIFY
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 463;
--
  -- AUTO_INCREMENT de la tabla `nomina_choferes`
  --
ALTER TABLE
  `nomina_choferes`
MODIFY
  `id_nomina_chofer` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;
--
  -- AUTO_INCREMENT de la tabla `pago_nomina`
  --
ALTER TABLE
  `pago_nomina`
MODIFY
  `id_nomina` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 76;
--
  -- AUTO_INCREMENT de la tabla `parroquias`
  --
ALTER TABLE
  `parroquias`
MODIFY
  `id_parroquia` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1139;
--
  -- AUTO_INCREMENT de la tabla `permiso`
  --
ALTER TABLE
  `permiso`
MODIFY
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7;
--
  -- AUTO_INCREMENT de la tabla `personal_access_tokens`
  --
ALTER TABLE
  `personal_access_tokens`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
  -- AUTO_INCREMENT de la tabla `registros_log`
  --
ALTER TABLE
  `registros_log`
MODIFY
  `idregistros_log` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 507;
--
  -- AUTO_INCREMENT de la tabla `salario_base`
  --
ALTER TABLE
  `salario_base`
MODIFY
  `salario_base_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
  -- AUTO_INCREMENT de la tabla `tipousuario`
  --
ALTER TABLE
  `tipousuario`
MODIFY
  `idtipousuario` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;
--
  -- AUTO_INCREMENT de la tabla `usuarios`
  --
ALTER TABLE
  `usuarios`
MODIFY
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 38;
--
  -- AUTO_INCREMENT de la tabla `usuario_permiso`
  --
ALTER TABLE
  `usuario_permiso`
MODIFY
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1422;
--
  -- AUTO_INCREMENT de la tabla `viajes`
  --
ALTER TABLE
  `viajes`
MODIFY
  `viajes_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20;
--
  -- Restricciones para tablas volcadas
  --
  --
  -- Filtros para la tabla `almacen`
  --
ALTER TABLE
  `almacen`
ADD
  CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `asignacion_nomina`
  --
ALTER TABLE
  `asignacion_nomina`
ADD
  CONSTRAINT `asignacion_nomina_ibfk_2` FOREIGN KEY (`id_nomina`) REFERENCES `pago_nomina` (`id_nomina`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `audits`
  --
ALTER TABLE
  `audits`
ADD
  CONSTRAINT `audits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Filtros para la tabla `cavas`
  --
ALTER TABLE
  `cavas`
ADD
  CONSTRAINT `cavas_ibfk_1` FOREIGN KEY (`cava_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `choferes`
  --
ALTER TABLE
  `choferes`
ADD
  CONSTRAINT `choferes_ibfk_1` FOREIGN KEY (`chofer_idempleado`) REFERENCES `empleado` (`id_emp`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `chutos`
  --
ALTER TABLE
  `chutos`
ADD
  CONSTRAINT `chutos_ibfk_1` FOREIGN KEY (`chuto_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `deduccion_nomina`
  --
ALTER TABLE
  `deduccion_nomina`
ADD
  CONSTRAINT `deduccion_nomina_ibfk_1` FOREIGN KEY (`id_nomina`) REFERENCES `pago_nomina` (`id_nomina`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `departamento`
  --
ALTER TABLE
  `departamento`
ADD
  CONSTRAINT `fk_departamento_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`);
--
  -- Filtros para la tabla `empleado`
  --
ALTER TABLE
  `empleado`
ADD
  CONSTRAINT `fk_empleado_departamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Filtros para la tabla `fletes`
  --
ALTER TABLE
  `fletes`
ADD
  CONSTRAINT `fletes_ibfk_1` FOREIGN KEY (`flete_destino_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fletes_ibfk_2` FOREIGN KEY (`flete_destino_municipio`) REFERENCES `municipios` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `fletes_ibfk_3` FOREIGN KEY (`flete_destino_parroquia`) REFERENCES `parroquias` (`id_parroquia`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `municipios`
  --
ALTER TABLE
  `municipios`
ADD
  CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `nomina_choferes`
  --
ALTER TABLE
  `nomina_choferes`
ADD
  CONSTRAINT `nomina_choferes_ibfk_1` FOREIGN KEY (`id_chofer`) REFERENCES `empleado` (`id_emp`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `nomina_choferes_ibfk_2` FOREIGN KEY (`id_viaje`) REFERENCES `viajes` (`viajes_id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `pago_nomina`
  --
ALTER TABLE
  `pago_nomina`
ADD
  CONSTRAINT `pago_nomina_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_emp`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `pago_nomina_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `parroquias`
  --
ALTER TABLE
  `parroquias`
ADD
  CONSTRAINT `parroquias_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE;
--
  -- Filtros para la tabla `salario_base`
  --
ALTER TABLE
  `salario_base`
ADD
  CONSTRAINT `salario_base_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Filtros para la tabla `usuarios`
  --
ALTER TABLE
  `usuarios`
ADD
  CONSTRAINT `fk_usuario_departamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_usuario_tipousuario` FOREIGN KEY (`idtipousuario`) REFERENCES `tipousuario` (`idtipousuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Filtros para la tabla `usuario_permiso`
  --
ALTER TABLE
  `usuario_permiso`
ADD
  CONSTRAINT `fk_u_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD
  CONSTRAINT `fk_usuario_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
  -- Filtros para la tabla `viajes`
  --
ALTER TABLE
  `viajes`
ADD
  CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`viajes_idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`viajes_idchuto`) REFERENCES `chutos` (`chuto_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `viajes_ibfk_3` FOREIGN KEY (`viajes_idchofer`) REFERENCES `empleado` (`id_emp`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `viajes_ibfk_4` FOREIGN KEY (`viajes_idcava`) REFERENCES `cavas` (`cava_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `viajes_ibfk_5` FOREIGN KEY (`viajes_idflete_ida`) REFERENCES `fletes` (`flete_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
  CONSTRAINT `viajes_ibfk_6` FOREIGN KEY (`viajes_idflete_retorno`) REFERENCES `fletes` (`flete_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;