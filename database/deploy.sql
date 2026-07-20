-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-07-2026 a las 01:34:46
-- Versión del servidor: 11.8.8-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u277274915_a_oliva`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activos`
--

CREATE TABLE `activos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `monto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activos`
--

INSERT INTO `activos` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Revolut', 25000.00, 1),
(3, 'Nu', 25000.00, 2),
(4, 'Yotepresto', 2000.00, 3),
(5, 'Briq', 1000.00, 4),
(6, 'Monific', 1000.00, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `titulo` varchar(180) NOT NULL,
  `slug` varchar(180) DEFAULT NULL,
  `estado` enum('borrador','publicado') NOT NULL DEFAULT 'publicado',
  `categoria` varchar(60) DEFAULT NULL,
  `fecha_pub` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `contenido` mediumtext DEFAULT NULL,
  `cover_img` varchar(160) DEFAULT NULL,
  `ref_tipo` varchar(20) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `visitas` int(11) NOT NULL DEFAULT 0,
  `orden` int(11) NOT NULL DEFAULT 0,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_categorias`
--

CREATE TABLE `blog_categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blog_categorias`
--

INSERT INTO `blog_categorias` (`id`, `nombre`) VALUES
(3, 'Actualidad'),
(4, 'Cuentos'),
(2, 'Cultura'),
(1, 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales`
--

CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL,
  `logo` varchar(160) NOT NULL,
  `alt` varchar(120) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `titulo` varchar(160) NOT NULL,
  `institucion` varchar(120) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_por_cobrar`
--

CREATE TABLE `cuentas_por_cobrar` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `monto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuentas_por_cobrar`
--

INSERT INTO `cuentas_por_cobrar` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Maye', 47200.00, 1),
(2, 'Julio', 33400.00, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curriculum_materias`
--

CREATE TABLE `curriculum_materias` (
  `id` int(11) NOT NULL,
  `mapa` enum('anahuac','unam') NOT NULL,
  `semestre` int(11) NOT NULL,
  `fila` int(11) NOT NULL DEFAULT 0,
  `codigo` varchar(20) DEFAULT NULL,
  `nombre` varchar(160) NOT NULL,
  `estado` enum('completado','cursando','desbloqueada','bloqueada') NOT NULL DEFAULT 'bloqueada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curriculum_materias`
--

INSERT INTO `curriculum_materias` (`id`, `mapa`, `semestre`, `fila`, `codigo`, `nombre`, `estado`) VALUES
(1, 'anahuac', 1, 1, 'MAT1402', 'Cálculo Diferencial', 'completado'),
(2, 'anahuac', 1, 2, 'MAT1401', 'Fundamentos de Matemáticas', 'completado'),
(3, 'anahuac', 1, 3, 'FIS1401', 'Física', 'completado'),
(4, 'anahuac', 1, 4, 'CMP1403', 'Introducción a la Computación', 'completado'),
(5, 'anahuac', 1, 5, 'CUL1411', 'Formación Universitaria A', 'completado'),
(6, 'anahuac', 1, 6, 'HUM1401', 'Ser Universitario', 'completado'),
(7, 'anahuac', 1, 7, NULL, 'Taller o Actividad Electiva', 'completado'),
(8, 'anahuac', 1, 8, NULL, 'Taller o Actividad Electiva', 'completado'),
(9, 'anahuac', 2, 1, 'MAT1403', 'Cálculo Integral', 'completado'),
(10, 'anahuac', 2, 2, 'MAT1404', 'Álgebra Lineal', 'completado'),
(11, 'anahuac', 2, 3, 'IELC1401', 'Circuitos Eléctricos', 'completado'),
(12, 'anahuac', 2, 4, 'MAT2403', 'Probabilidad y Estadística', 'completado'),
(13, 'anahuac', 2, 5, 'SIS1401', 'Algoritmos y Programación', 'completado'),
(14, 'anahuac', 2, 6, 'HUM1402', 'Antropología Fundamental', 'completado'),
(15, 'anahuac', 2, 7, NULL, 'Taller o Actividad Electiva', 'desbloqueada'),
(16, 'anahuac', 3, 1, 'MAT2401', 'Cálculo Multivariado', 'completado'),
(17, 'anahuac', 3, 2, 'MAT2410', 'Álgebra Lineal Avanzada', 'completado'),
(18, 'anahuac', 3, 3, 'SIS2401', 'Redes de Computadoras', 'completado'),
(19, 'anahuac', 3, 4, 'SIS2403', 'Bases de Datos', 'completado'),
(20, 'anahuac', 3, 5, 'SIS2402', 'Programación con Microcontroladores', 'completado'),
(21, 'anahuac', 3, 6, 'HUM1404', 'Ética', 'completado'),
(22, 'anahuac', 3, 7, 'LDR1401', 'Liderazgo y Desarrollo Personal', 'completado'),
(23, 'anahuac', 4, 1, 'MAT2402', 'Ecuaciones Diferenciales', 'completado'),
(24, 'anahuac', 4, 2, 'MAT1411', 'Matemáticas Discretas', 'completado'),
(25, 'anahuac', 4, 3, 'CMP2405', 'Arquitectura de Computadoras', 'completado'),
(26, 'anahuac', 4, 4, 'SIS2404', 'Bases de Datos Avanzadas', 'completado'),
(27, 'anahuac', 4, 5, 'SIS1402', 'Lenguajes Orientados a Objetos', 'completado'),
(28, 'anahuac', 4, 6, 'MAT2404', 'Estadística Inferencial', 'completado'),
(29, 'anahuac', 4, 7, 'HUM1405', 'Humanismo Clásico y Contemporáneo', 'completado'),
(30, 'anahuac', 4, 8, 'EMPI1401', 'Habilidades para el Emprendimiento', 'completado'),
(31, 'anahuac', 5, 1, 'SIS3401', 'Sistemas Operativos', 'completado'),
(32, 'anahuac', 5, 2, 'FIS2402', 'Física Moderna', 'completado'),
(33, 'anahuac', 5, 3, 'SIS3404', 'Implementación de Sistemas Integrados', 'completado'),
(34, 'anahuac', 5, 4, 'SIS3405', 'Estructuras de Datos', 'completado'),
(35, 'anahuac', 5, 5, 'SIS3406', 'Ingeniería de Software', 'completado'),
(36, 'anahuac', 5, 6, 'HUM1403', 'Persona y Trascendencia', 'completado'),
(37, 'anahuac', 5, 7, 'EMP1402', 'Emprendimiento e Innovación', 'desbloqueada'),
(38, 'anahuac', 5, 8, NULL, 'Asignatura Electiva Interdisciplinaria', 'completado'),
(39, 'anahuac', 6, 1, 'SIS3412', 'Desarrollo de Tecnologías de Internet', 'completado'),
(40, 'anahuac', 6, 2, 'MAT3402', 'Métodos Numéricos', 'completado'),
(41, 'anahuac', 6, 3, 'SIS3402', 'Redes Avanzadas', 'completado'),
(42, 'anahuac', 6, 4, 'SIS3409', 'Inteligencia de Negocios', 'completado'),
(43, 'anahuac', 6, 5, 'SIS3411', 'Desarrollo de Software', 'completado'),
(44, 'anahuac', 6, 6, NULL, 'MINOR 1', 'completado'),
(45, 'anahuac', 6, 7, 'LDR2401', 'Liderazgo y Equipos de Alto Desempeño', 'completado'),
(46, 'anahuac', 6, 8, NULL, 'Asignatura Electiva Interdisciplinaria', 'completado'),
(47, 'anahuac', 7, 1, 'CMP4402', 'Cómputo en la Nube', 'cursando'),
(48, 'anahuac', 7, 2, 'SIS4403', 'Seguridad Informática y Redes Forenses', 'desbloqueada'),
(49, 'anahuac', 7, 3, 'SIS3410', 'Programación para Internet', 'completado'),
(50, 'anahuac', 7, 4, 'SIS3403', 'Programación para Dispositivos Móviles', 'cursando'),
(51, 'anahuac', 7, 5, 'SIS4401', 'Inteligencia Artificial', 'completado'),
(52, 'anahuac', 7, 6, NULL, 'MINOR 2', 'completado'),
(53, 'anahuac', 7, 7, 'SIS4402', 'Calidad de Software', 'completado'),
(54, 'anahuac', 7, 8, NULL, 'Asignatura Electiva Anáhuac', 'completado'),
(55, 'anahuac', 8, 1, 'INT4409', 'Prácticum I: Ingeniería de Proyectos', 'cursando'),
(56, 'anahuac', 8, 2, 'SIS4414', 'Algoritmos de Optimización', 'completado'),
(57, 'anahuac', 8, 3, 'SIS4406', 'Gestión Estratégica de TI', 'completado'),
(58, 'anahuac', 8, 4, 'SIS4408', 'Machine Learning', 'desbloqueada'),
(59, 'anahuac', 8, 5, 'CON2402', 'Contabilidad y Costos para Ingeniería', 'completado'),
(60, 'anahuac', 8, 6, 'CUL1412', 'Formación Universitaria B', 'completado'),
(61, 'anahuac', 8, 7, NULL, 'MINOR 3', 'desbloqueada'),
(62, 'anahuac', 8, 8, NULL, 'Asignatura Electiva Interdisciplinaria', 'cursando'),
(63, 'anahuac', 9, 1, 'INT4410', 'Prácticum II: Administración de Proyectos', 'desbloqueada'),
(64, 'anahuac', 9, 2, 'SIS4413', 'Blockchain', 'cursando'),
(65, 'anahuac', 9, 3, 'CMP4404', 'Internet de las Cosas', 'cursando'),
(66, 'anahuac', 9, 4, 'SIS4412', 'Big Data', 'cursando'),
(67, 'anahuac', 9, 5, 'ING4401', 'Innovación Tecnológica', 'completado'),
(68, 'anahuac', 9, 6, NULL, 'MINOR 4', 'desbloqueada'),
(69, 'anahuac', 9, 7, 'SOC3401', 'Responsabilidad Social y Responsabilidad', 'cursando'),
(70, 'unam', 1, 1, NULL, 'Introducción al pensamiento social y político moderno', 'completado'),
(71, 'unam', 1, 2, NULL, 'Construcción histórica de México en el mundo I (1808-1946)', 'completado'),
(72, 'unam', 1, 3, NULL, 'Economía', 'completado'),
(73, 'unam', 1, 4, NULL, 'Consulta de fuentes y lectura numérica del mundo', 'completado'),
(74, 'unam', 1, 5, NULL, 'Comprensión y expresión oral', 'completado'),
(75, 'unam', 1, 6, NULL, 'Lenguaje, cultura y poder', 'completado'),
(76, 'unam', 2, 1, NULL, 'Teorías de la Comunicación I', 'completado'),
(77, 'unam', 2, 2, NULL, 'Construcción histórica de México en el mundo II (a partir de 1947)', 'completado'),
(78, 'unam', 2, 3, NULL, 'Estado, Sociedad y Derecho', 'completado'),
(79, 'unam', 2, 4, NULL, 'Introducción a la investigación en ciencias sociales', 'completado'),
(80, 'unam', 2, 5, NULL, 'Argumentación y expresión escrita', 'completado'),
(81, 'unam', 2, 6, NULL, 'Teorías y análisis del Discurso', 'completado'),
(82, 'unam', 3, 1, NULL, 'Teorías de la Comunicación II', 'completado'),
(83, 'unam', 3, 2, NULL, 'Procesos y medios de comunicación en la historia de México (1320-1876)', 'completado'),
(84, 'unam', 3, 3, NULL, 'Análisis de las organizaciones públicas', 'completado'),
(85, 'unam', 3, 4, NULL, 'Estadística aplicada a las ciencias sociales', 'completado'),
(86, 'unam', 3, 5, NULL, 'Géneros periodísticos informativos', 'completado'),
(87, 'unam', 3, 6, NULL, 'Teorías de la significación', 'completado'),
(88, 'unam', 4, 1, NULL, 'Teorías de la Comunicación III', 'cursando'),
(89, 'unam', 4, 2, NULL, 'Procesos y medios de comunicación en la historia de México (1877-2015)', 'cursando'),
(90, 'unam', 4, 3, NULL, 'Opinión pública y propaganda', 'completado'),
(91, 'unam', 4, 4, NULL, 'Investigación en comunicación', 'cursando'),
(92, 'unam', 4, 5, NULL, 'Géneros periodísticos interpretativos', 'cursando'),
(93, 'unam', 4, 6, NULL, 'Comunicación publicitaria / Imagen y discurso audiovisual', 'cursando'),
(94, 'unam', 5, 1, NULL, 'Géneros periodísticos de opinión', 'desbloqueada'),
(95, 'unam', 5, 2, NULL, 'Corrección de originales', 'desbloqueada'),
(96, 'unam', 5, 3, NULL, 'Metodología de la investigación periodística', 'desbloqueada'),
(97, 'unam', 5, 4, NULL, 'Periodismo, ética y derechos humanos', 'desbloqueada'),
(98, 'unam', 5, 5, NULL, 'Optativa de elección - Psicología de la comunicación', 'cursando'),
(99, 'unam', 6, 1, NULL, 'Periodismo especializado', 'desbloqueada'),
(100, 'unam', 6, 2, NULL, 'Planeación y gestión de empresas editoriales', 'desbloqueada'),
(101, 'unam', 6, 3, NULL, 'Periodismo y lenguaje narrativo', 'desbloqueada'),
(102, 'unam', 6, 4, NULL, 'Optativa elección - El cine como cultura audiovisual', 'desbloqueada'),
(103, 'unam', 6, 5, NULL, 'Optativa - Animación Digital', 'cursando'),
(104, 'unam', 7, 1, NULL, 'Periodismo multimedia', 'desbloqueada'),
(105, 'unam', 7, 2, NULL, 'Diseño y creación editorial de soportes impresos y digitales', 'desbloqueada'),
(106, 'unam', 7, 3, NULL, 'Diseño y desarrollo de proyectos profesionales', 'desbloqueada'),
(107, 'unam', 7, 4, NULL, 'Optativa - Diseño y producción de videojuegos', 'desbloqueada'),
(108, 'unam', 7, 5, NULL, 'Optativa - Lenguaje Cinematográfico como Cultura Audiovisual', 'desbloqueada'),
(109, 'unam', 8, 1, NULL, 'Optativa - Arte y comunicación', 'desbloqueada'),
(110, 'unam', 8, 2, NULL, 'Optativa - Creatividad publicitaria', 'desbloqueada'),
(111, 'unam', 8, 3, NULL, 'Optativa - Periodismo en internet', 'desbloqueada'),
(112, 'unam', 8, 4, NULL, 'Optativa - Análisis Semiótico', 'desbloqueada'),
(113, 'unam', 8, 5, NULL, 'Optativa - Nuevos escenarios tecnológicos en producción audiovisual', 'desbloqueada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudas`
--

CREATE TABLE `deudas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `monto` decimal(12,2) NOT NULL DEFAULT 0.00,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deudas`
--

INSERT INTO `deudas` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Deuda', 47500.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gym_dias`
--

CREATE TABLE `gym_dias` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `asistio` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `gym_dias`
--

INSERT INTO `gym_dias` (`id`, `fecha`, `asistio`) VALUES
(2, '2026-01-01', 0),
(3, '2026-01-02', 1),
(4, '2026-01-03', 1),
(5, '2026-01-04', 0),
(6, '2026-01-05', 0),
(7, '2026-01-07', 1),
(8, '2026-01-06', 1),
(9, '2026-01-08', 1),
(11, '2026-01-09', 0),
(12, '2026-01-10', 0),
(13, '2026-01-11', 0),
(14, '2026-01-12', 0),
(15, '2026-01-13', 0),
(16, '2026-01-14', 1),
(17, '2026-01-15', 0),
(18, '2026-01-16', 0),
(19, '2026-01-17', 0),
(20, '2026-01-18', 0),
(21, '2026-01-19', 0),
(22, '2026-01-20', 0),
(23, '2026-01-21', 0),
(24, '2026-01-22', 0),
(25, '2026-01-23', 0),
(26, '2026-01-24', 0),
(27, '2026-01-25', 1),
(28, '2026-01-26', 0),
(29, '2026-01-27', 0),
(30, '2026-01-28', 0),
(31, '2026-01-29', 0),
(32, '2026-01-30', 0),
(33, '2026-01-31', 0),
(34, '2026-02-01', 1),
(35, '2026-02-02', 1),
(36, '2026-02-07', 1),
(37, '2026-02-12', 1),
(38, '2026-02-25', 1),
(39, '2026-02-27', 1),
(40, '2026-02-03', 0),
(41, '2026-02-04', 0),
(42, '2026-02-05', 0),
(43, '2026-02-06', 0),
(44, '2026-02-08', 0),
(45, '2026-02-09', 0),
(46, '2026-02-10', 0),
(47, '2026-02-11', 0),
(48, '2026-02-13', 0),
(49, '2026-02-14', 0),
(50, '2026-02-15', 0),
(51, '2026-02-16', 0),
(52, '2026-02-17', 0),
(53, '2026-02-18', 0),
(54, '2026-02-19', 0),
(55, '2026-02-20', 0),
(56, '2026-02-21', 0),
(57, '2026-02-22', 0),
(58, '2026-02-23', 0),
(59, '2026-02-24', 0),
(60, '2026-02-26', 0),
(61, '2026-02-28', 0),
(62, '2026-03-07', 1),
(63, '2026-03-14', 1),
(64, '2026-03-11', 1),
(65, '2026-03-25', 1),
(66, '2026-03-28', 1),
(67, '2026-03-01', 0),
(68, '2026-03-02', 0),
(69, '2026-03-03', 0),
(70, '2026-03-04', 0),
(71, '2026-03-05', 0),
(72, '2026-03-06', 0),
(73, '2026-03-08', 0),
(74, '2026-03-09', 0),
(75, '2026-03-10', 0),
(76, '2026-03-12', 0),
(77, '2026-03-13', 0),
(78, '2026-03-15', 0),
(79, '2026-03-16', 0),
(80, '2026-03-17', 0),
(81, '2026-03-18', 0),
(82, '2026-03-19', 0),
(83, '2026-03-20', 0),
(84, '2026-03-21', 0),
(85, '2026-03-22', 0),
(86, '2026-03-23', 0),
(87, '2026-03-24', 0),
(88, '2026-03-26', 0),
(89, '2026-03-27', 0),
(90, '2026-03-29', 0),
(91, '2026-03-30', 0),
(92, '2026-03-31', 0),
(93, '2026-04-01', 1),
(94, '2026-04-03', 1),
(95, '2026-04-04', 1),
(96, '2026-04-06', 1),
(97, '2026-04-30', 1),
(98, '2026-04-02', 0),
(99, '2026-04-05', 0),
(100, '2026-04-07', 0),
(101, '2026-04-08', 0),
(102, '2026-04-09', 0),
(103, '2026-04-10', 0),
(104, '2026-04-11', 0),
(105, '2026-04-12', 0),
(106, '2026-04-13', 0),
(107, '2026-04-14', 0),
(108, '2026-04-15', 0),
(109, '2026-04-16', 0),
(110, '2026-04-17', 0),
(111, '2026-04-18', 0),
(112, '2026-04-25', 0),
(113, '2026-04-24', 0),
(114, '2026-04-23', 0),
(115, '2026-04-22', 0),
(116, '2026-04-21', 0),
(117, '2026-04-20', 0),
(118, '2026-04-19', 0),
(119, '2026-04-26', 0),
(120, '2026-04-27', 0),
(121, '2026-04-28', 0),
(122, '2026-04-29', 0),
(123, '2026-05-07', 1),
(124, '2026-05-14', 1),
(125, '2026-05-19', 1),
(126, '2026-05-20', 1),
(127, '2026-05-25', 1),
(128, '2026-05-26', 1),
(129, '2026-05-28', 1),
(130, '2026-05-01', 0),
(131, '2026-05-29', 1),
(132, '2026-05-02', 0),
(133, '2026-05-04', 0),
(134, '2026-05-03', 0),
(135, '2026-05-05', 0),
(136, '2026-05-06', 0),
(137, '2026-05-08', 0),
(138, '2026-05-09', 0),
(139, '2026-05-10', 0),
(140, '2026-05-11', 0),
(141, '2026-05-12', 0),
(142, '2026-05-13', 0),
(143, '2026-05-15', 0),
(144, '2026-05-16', 0),
(145, '2026-05-17', 0),
(146, '2026-05-18', 0),
(147, '2026-05-21', 0),
(148, '2026-05-23', 0),
(149, '2026-05-22', 0),
(150, '2026-05-24', 0),
(151, '2026-05-27', 0),
(152, '2026-05-30', 0),
(153, '2026-05-31', 0),
(154, '2026-06-02', 1),
(155, '2026-06-05', 1),
(156, '2026-06-06', 1),
(157, '2026-06-08', 1),
(158, '2026-06-11', 1),
(159, '2026-06-19', 1),
(160, '2026-06-25', 1),
(161, '2026-06-26', 1),
(162, '2026-06-27', 1),
(163, '2026-06-30', 1),
(164, '2026-06-29', 1),
(165, '2026-06-01', 0),
(166, '2026-06-03', 0),
(167, '2026-06-04', 0),
(168, '2026-06-07', 0),
(169, '2026-06-09', 0),
(170, '2026-06-10', 0),
(171, '2026-06-12', 0),
(172, '2026-06-13', 0),
(173, '2026-06-14', 0),
(174, '2026-06-15', 0),
(175, '2026-06-16', 0),
(176, '2026-06-17', 0),
(177, '2026-06-18', 0),
(178, '2026-06-20', 0),
(179, '2026-06-21', 0),
(180, '2026-06-22', 0),
(181, '2026-06-23', 0),
(182, '2026-06-24', 0),
(183, '2026-06-28', 0),
(184, '2026-07-02', 1),
(185, '2026-07-03', 1),
(186, '2026-07-06', 0),
(187, '2026-07-07', 1),
(188, '2026-07-08', 1),
(189, '2026-07-09', 1),
(190, '2026-07-14', 1),
(191, '2026-07-16', 1),
(192, '2026-07-01', 0),
(193, '2026-07-04', 0),
(194, '2026-07-05', 0),
(195, '2026-07-10', 0),
(196, '2026-07-11', 0),
(197, '2026-07-12', 0),
(198, '2026-07-13', 0),
(199, '2026-07-15', 0),
(200, '2026-07-17', 0),
(201, '2026-07-18', 0),
(202, '2026-07-19', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_bloques`
--

CREATE TABLE `horario_bloques` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `dia` enum('lun','mar','mie','jue','vie') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horario_bloques`
--

INSERT INTO `horario_bloques` (`id`, `materia_id`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 'mar', '10:00:00', '11:30:00'),
(2, 1, 'jue', '10:00:00', '11:30:00'),
(3, 2, 'mar', '11:30:00', '13:00:00'),
(4, 2, 'jue', '11:30:00', '13:00:00'),
(5, 3, 'mar', '16:00:00', '17:30:00'),
(6, 3, 'mie', '16:00:00', '17:30:00'),
(7, 3, 'jue', '16:00:00', '17:30:00'),
(8, 4, 'mar', '17:30:00', '19:00:00'),
(9, 4, 'jue', '17:30:00', '19:00:00'),
(12, 6, 'mie', '19:00:00', '20:30:00'),
(13, 6, 'jue', '19:00:00', '20:30:00'),
(14, 5, 'mie', '20:30:00', '22:00:00'),
(15, 5, 'jue', '20:30:00', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(160) NOT NULL,
  `autor` varchar(120) NOT NULL,
  `estado` enum('pendiente','leido') NOT NULL DEFAULT 'pendiente',
  `completado` tinyint(1) NOT NULL DEFAULT 0,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `estrellas` decimal(2,1) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_leido` date DEFAULT NULL,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor`, `estado`, `completado`, `posicion`, `estrellas`, `comentario`, `creado`) VALUES
(1, 'Pasado virtual', 'Alberto Venegas Ramos', 'leido', 1, 1, NULL, NULL, '2026-07-18 15:06:30'),
(2, 'El perfecto cerebro imperfecto', 'Eduardo Calixto', 'leido', 1, 2, NULL, NULL, '2026-07-18 15:06:50'),
(3, 'Momo', 'Michael Ende', 'leido', 1, 3, NULL, NULL, '2026-07-18 15:07:14'),
(4, 'Un mundo feliz', 'Aldous Huxley', 'leido', 1, 4, NULL, NULL, '2026-07-18 15:07:45'),
(5, 'Mythos', 'Stephen Fry', 'leido', 1, 5, NULL, NULL, '2026-07-18 15:08:30'),
(6, 'Kim Jiyoung nacida en 1982', 'Cho Nam Joo', 'leido', 1, 6, NULL, NULL, '2026-07-18 15:09:18'),
(7, 'Pep Guardiola: La Metamorfosis', 'Martí Perarnau', 'leido', 1, 7, NULL, NULL, '2026-07-18 15:09:51'),
(8, 'El inversionista de enfrente', 'Moris Dieck', 'leido', 1, 8, NULL, NULL, '2026-07-18 15:10:05'),
(9, 'Palalmas', 'Farid Dieck', 'leido', 1, 9, NULL, NULL, '2026-07-18 15:10:57'),
(10, 'Futuralgia', 'Farid Dieck', 'leido', 1, 10, NULL, NULL, '2026-07-18 15:11:10'),
(11, 'Mis chistes, mi filosofía', 'Slavoj Zizek', 'leido', 1, 11, NULL, NULL, '2026-07-18 15:11:36'),
(12, 'Juan Salvador Gaviota', 'Richard Bach', 'leido', 1, 12, NULL, NULL, '2026-07-18 15:11:56'),
(13, 'Una película para cada año de tu vida', 'Alejandro G Calvo', 'leido', 1, 13, NULL, NULL, '2026-07-18 15:12:16'),
(14, 'Dime qué sientes', 'Jesús Martín Fernández', 'leido', 1, 14, NULL, NULL, '2026-07-18 15:12:48'),
(15, 'El lado oscuro de la mente humana', 'Maryfer Centeno', 'leido', 1, 15, NULL, NULL, '2026-07-18 15:13:11'),
(16, 'Sócrates', 'Beatrice Collina', 'leido', 1, 16, NULL, NULL, '2026-07-18 15:13:34'),
(17, 'Cómo aprender la excelencia', 'Eric Potterat', 'leido', 1, 17, NULL, NULL, '2026-07-18 15:14:09'),
(18, 'Tómatelo con Estoicismo', 'Jaime Moreno', 'leido', 1, 18, NULL, NULL, '2026-07-18 15:16:07'),
(19, 'Llámame por tu nombre', 'André Aciman', 'leido', 1, 19, NULL, NULL, '2026-07-18 15:16:30'),
(20, 'Gastrosofía', 'Eduardo Infante', 'leido', 1, 20, NULL, NULL, '2026-07-18 15:16:46'),
(21, 'Mecagüen', 'Sergio Parra', 'pendiente', 0, 21, NULL, NULL, '2026-07-18 15:17:03'),
(22, 'Cultiva tu memesfera', 'Sergio Parra', 'pendiente', 0, 22, NULL, NULL, '2026-07-18 15:18:29'),
(23, 'El escape de la robot salvaje', 'Peter Brown', 'pendiente', 0, 23, NULL, NULL, '2026-07-18 15:18:47'),
(24, 'El kybalion', 'Hermes Trismegisto', 'pendiente', 0, 24, NULL, NULL, '2026-07-18 15:19:08'),
(25, 'Ética en la calle', 'Eduardo Infante', 'pendiente', 0, 25, NULL, NULL, '2026-07-18 15:19:28'),
(26, 'País sin techo', 'Carla Escoffié', 'pendiente', 0, 26, NULL, NULL, '2026-07-18 15:21:29'),
(27, 'Lo que los libros de historia del arte no quieren que sepas', 'Blanca Guilera', 'pendiente', 0, 27, NULL, NULL, '2026-07-18 15:22:00'),
(28, 'Carta de una desconocida', 'Stefan Zweig', 'pendiente', 0, 28, NULL, NULL, '2026-07-18 15:22:37'),
(29, 'Siddharta', 'Herman Hesse', 'pendiente', 0, 29, NULL, NULL, '2026-07-18 15:23:52'),
(30, 'El hombre en búsqueda del sentido', 'Víctor Frankl', 'pendiente', 0, 30, NULL, NULL, '2026-07-18 15:24:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `profesor` varchar(160) DEFAULT NULL,
  `nrc` varchar(20) DEFAULT NULL,
  `creditos` decimal(3,1) NOT NULL DEFAULT 0.0,
  `color` varchar(9) NOT NULL DEFAULT '#4267AC',
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `profesor`, `nrc`, `creditos`, `color`, `orden`) VALUES
(1, 'Blockchain', 'José de Jesús Angel Angel', '11662', 4.5, '#4267AC', 1),
(2, 'Big Data', 'Flavio Lucio Pontecorvo', '11665', 4.5, '#8AC926', 2),
(3, 'Programación Dispositivos Móviles', 'Héctor Julián Selley Rojas', '11659', 6.0, '#E51022', 3),
(4, 'IA Aplicada Ciencias Sociales', 'Profesor', '16642', 6.0, '#F5B400', 4),
(5, 'Cómputo en la Nube', 'Alejandro Goldberg Fridman', '11667', 4.5, '#EA075A', 0),
(6, 'Internet de las Cosas', 'Alejandro Goldberg Fridman', '11666', 4.5, '#AA2296', 6),
(7, 'Practicum I', 'Emma María Teresa Zárate Inestrillas', '14006', 6.0, '#FC6722', 7),
(8, 'Responsabilidad Social', 'Profesor', '0', 6.0, '#3A86FF', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_criterios`
--

CREATE TABLE `materia_criterios` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL DEFAULT '',
  `peso` decimal(5,2) NOT NULL DEFAULT 0.00,
  `calificacion` decimal(4,2) NOT NULL DEFAULT 0.00,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patrimonio_snapshots`
--

CREATE TABLE `patrimonio_snapshots` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `neto` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `patrimonio_snapshots`
--

INSERT INTO `patrimonio_snapshots` (`id`, `fecha`, `neto`) VALUES
(1, '2026-07-01', 87100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_series`
--

CREATE TABLE `peliculas_series` (
  `id` int(11) NOT NULL,
  `categoria` varchar(60) DEFAULT NULL,
  `titulo` varchar(160) NOT NULL,
  `autor` varchar(120) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `nota` decimal(3,1) NOT NULL,
  `fecha_vista` date DEFAULT NULL,
  `poster` varchar(160) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `slug` varchar(180) DEFAULT NULL,
  `anio` varchar(10) DEFAULT NULL,
  `img` varchar(160) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_imagenes`
--

CREATE TABLE `proyecto_imagenes` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `img` varchar(160) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pys_categorias`
--

CREATE TABLE `pys_categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pys_categorias`
--

INSERT INTO `pys_categorias` (`id`, `nombre`) VALUES
(3, 'Cortometraje'),
(4, 'Documental'),
(1, 'Película'),
(5, 'Reality'),
(2, 'Serie'),
(6, 'Stand Up');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `num` varchar(4) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `descripcion` text NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `num`, `titulo`, `descripcion`, `tags`, `orden`) VALUES
(1, '01', 'Desarrollo de software', 'HTML, CSS y JavaScript. Llevo el diseño hasta el producto vivo y funcional, del prototipo al código en producción.', 'Front-end,Responsive,Animación', 1),
(2, '02', 'UX/UI Design', 'Interfaces claras, jerárquicas y accesibles. Diseño pensado en personas reales, no en suposiciones.', 'Design Systems,Accesibilidad,Figma', 2),
(3, '03', 'Estrategia digital', 'Contenido, posicionamiento y decisiones de producto con visión de negocio y comunicación.', 'Contenido,Marca,Producto', 3),
(4, '04', 'Automatizaciones', 'Flujos que ahorran horas: integro herramientas y proceso tareas repetitivas para que el trabajo se haga solo.', 'Workflows,Integraciones,APIs', 4),
(5, '05', 'SEO', 'Posicionamiento orgánico con base técnica: estructura, contenido y rendimiento para que te encuentren.', 'SEO técnico,Contenido,Analítica', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `confirmado` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `email`, `password`, `admin`, `confirmado`, `token`, `creado`) VALUES
(1, 'alex', 'Alexander', 'Oliva', 'alexcayd@gmail.com', '$2y$12$BILzYC15G.oP1RPDlbzErutMfczwhvCEfYjAGn17UsVI3AIsU8Rd6', 1, 1, NULL, '2026-07-17 20:22:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuegos`
--

CREATE TABLE `videojuegos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `horas_iniciales` decimal(6,1) NOT NULL DEFAULT 0.0,
  `horas_totales` decimal(6,1) DEFAULT NULL,
  `portada` varchar(160) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`id`, `nombre`, `horas_iniciales`, `horas_totales`, `portada`, `orden`, `creado`) VALUES
(1, 'Papa\'s Freezeria', 25.6, 27.5, 'vj-1784476766-ddc651.webp', 1, '2026-07-19 15:59:26'),
(2, 'Two Point Museum', 1.3, NULL, 'vj-1784477181-a8c0de.jpg', 2, '2026-07-19 16:06:21'),
(3, 'Peak', 1.7, NULL, 'vj-1784477210-a7ea67.jpg', 3, '2026-07-19 16:06:50'),
(4, 'Supermarket Simulator', 79.0, NULL, 'vj-1784477231-05acd5.jpg', 4, '2026-07-19 16:07:11'),
(5, 'Spiderman: Miles Morales', 1.7, 12.8, 'vj-1784477256-ab61de.jpg', 5, '2026-07-19 16:07:36'),
(6, 'Forza Horizon 5', 1.0, NULL, 'vj-1784477275-e626c8.jpg', 6, '2026-07-19 16:07:55'),
(7, 'Spiderman 2', 0.0, NULL, 'vj-1784477295-894b6d.jpg', 7, '2026-07-19 16:08:15'),
(8, 'Arc Raiders', 0.0, NULL, 'vj-1784477304-603c38.avif', 8, '2026-07-19 16:08:24'),
(9, 'Schedule I', 0.0, NULL, 'vj-1784477312-8b0dfd.jpg', 9, '2026-07-19 16:08:32'),
(10, 'Librarian', 0.0, 7.1, 'vj-1784477321-dfb497.webp', 10, '2026-07-19 16:08:41'),
(11, 'Good Pizza, Great Pizza', 0.0, NULL, 'vj-1784477336-d73e18.jpg', 11, '2026-07-19 16:08:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visitas`
--

INSERT INTO `visitas` (`id`, `fecha`, `total`) VALUES
(1, '2026-07-17', 4),
(5, '2026-07-18', 34),
(39, '2026-07-19', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_pagina`
--

CREATE TABLE `visitas_pagina` (
  `id` int(11) NOT NULL,
  `ruta` varchar(191) NOT NULL,
  `titulo` varchar(200) NOT NULL DEFAULT '',
  `total` int(11) NOT NULL DEFAULT 0,
  `actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `visitas_pagina`
--

INSERT INTO `visitas_pagina` (`id`, `ruta`, `titulo`, `total`, `actualizado`) VALUES
(1, '/', 'Inicio', 56, '2026-07-19 23:40:10'),
(12, '/tekhne', 'Tékhne', 6, '2026-07-18 13:02:35'),
(15, '/tekhne/categoria/cultura', 'Cultura — Tékhne', 3, '2026-07-18 13:02:35'),
(18, '/tekhne/categoria/cuentos', 'Cuentos — Tékhne', 3, '2026-07-18 13:02:35'),
(22, '/tekhne/categoria/actualidad', 'Actualidad — Tékhne', 3, '2026-07-18 13:02:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activos`
--
ALTER TABLE `activos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `blog_categorias`
--
ALTER TABLE `blog_categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentas_por_cobrar`
--
ALTER TABLE `cuentas_por_cobrar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curriculum_materias`
--
ALTER TABLE `curriculum_materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deudas`
--
ALTER TABLE `deudas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gym_dias`
--
ALTER TABLE `gym_dias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- Indices de la tabla `horario_bloques`
--
ALTER TABLE `horario_bloques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bloque_materia` (`materia_id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia_criterios`
--
ALTER TABLE `materia_criterios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_criterio_materia` (`materia_id`);

--
-- Indices de la tabla `patrimonio_snapshots`
--
ALTER TABLE `patrimonio_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- Indices de la tabla `peliculas_series`
--
ALTER TABLE `peliculas_series`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pimg_proyecto` (`proyecto_id`);

--
-- Indices de la tabla `pys_categorias`
--
ALTER TABLE `pys_categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- Indices de la tabla `visitas_pagina`
--
ALTER TABLE `visitas_pagina`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruta` (`ruta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activos`
--
ALTER TABLE `activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blog_categorias`
--
ALTER TABLE `blog_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas_por_cobrar`
--
ALTER TABLE `cuentas_por_cobrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `curriculum_materias`
--
ALTER TABLE `curriculum_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `deudas`
--
ALTER TABLE `deudas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gym_dias`
--
ALTER TABLE `gym_dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT de la tabla `horario_bloques`
--
ALTER TABLE `horario_bloques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `materia_criterios`
--
ALTER TABLE `materia_criterios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patrimonio_snapshots`
--
ALTER TABLE `patrimonio_snapshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `peliculas_series`
--
ALTER TABLE `peliculas_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pys_categorias`
--
ALTER TABLE `pys_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `visitas_pagina`
--
ALTER TABLE `visitas_pagina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horario_bloques`
--
ALTER TABLE `horario_bloques`
  ADD CONSTRAINT `fk_bloque_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materia_criterios`
--
ALTER TABLE `materia_criterios`
  ADD CONSTRAINT `fk_criterio_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  ADD CONSTRAINT `fk_pimg_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
