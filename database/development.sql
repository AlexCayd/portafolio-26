-- =====================================================================
--  DATOS SEMILLA PARA LOCAL — alexanderoliva.com
--  SOLO INSERT: la estructura vive en ddl.sql, que se importa antes.
--
--    mysql -u root -p <base> < database/ddl.sql
--    mysql -u root -p <base> < database/development.sql
--
--  Construido a partir de deploy.sql: mismas tablas y mismas listas de
--  columnas, con los datos recortados a una muestra. Las imágenes apuntan
--  a archivos que SÍ existen en public/uploads dentro del repo, para que
--  el entorno local se vea completo sin descargar nada del servidor.
-- =====================================================================

SET NAMES utf8mb4;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- ---------------------------------------------------------------------
--  Usuario del panel (alex / PIN 000000)
-- ---------------------------------------------------------------------
INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `email`, `password`, `admin`, `confirmado`, `token`, `creado`) VALUES
(1, 'alex', 'Alexander', 'Oliva', 'alexcayd@gmail.com', '$2y$12$BILzYC15G.oP1RPDlbzErutMfczwhvCEfYjAGn17UsVI3AIsU8Rd6', 1, 1, NULL, '2026-07-17 20:22:15');

-- ---------------------------------------------------------------------
--  Servicios (landing)
-- ---------------------------------------------------------------------
INSERT INTO `servicios` (`id`, `num`, `titulo`, `descripcion`, `tags`, `orden`) VALUES
(1, '01', 'Desarrollo de software', 'HTML, CSS y JavaScript. Llevo el diseño hasta el producto vivo y funcional, del prototipo al código en producción.', 'Front-end,Responsive,Animación', 1),
(2, '02', 'UX/UI Design', 'Interfaces claras, jerárquicas y accesibles. Diseño pensado en personas reales, no en suposiciones.', 'Design Systems,Accesibilidad,Figma', 2),
(3, '03', 'Estrategia digital', 'Contenido, posicionamiento y decisiones de producto con visión de negocio y comunicación.', 'Contenido,Marca,Producto', 3),
(4, '04', 'Automatizaciones', 'Flujos que ahorran horas: integro herramientas y proceso tareas repetitivas para que el trabajo se haga solo.', 'Workflows,Integraciones,APIs', 4),
(5, '05', 'SEO', 'Posicionamiento orgánico con base técnica: estructura, contenido y rendimiento para que te encuentren.', 'SEO técnico,Contenido,Analítica', 5);

-- ---------------------------------------------------------------------
--  Credenciales (landing) — logos incluidos en el repo
-- ---------------------------------------------------------------------
INSERT INTO `credenciales` (`id`, `logo`, `alt`, `anio`, `titulo`, `institucion`, `orden`) VALUES
(1, 'google.png', 'Google', 2022, 'IT Support', 'Google', 1),
(2, 'mindshop.png', 'Mindshop', 2023, 'Ancient Greek Philosophy', 'Mindshop', 2),
(3, 'IBM.png', 'IBM', 2024, 'Generative AI Fundamentals', 'IBM', 3),
(4, 'universityoflondon.png', 'University of London', 2025, 'Responsive Web Design', 'University of London', 4),
(5, 'politecnico.png', 'Politecnico di Milano', 2025, 'Ethics of Artificial Intelligence', 'Politecnico di Milano', 5),
(6, 'meta.jpg', 'Meta', 2025, 'Principles of UX/UI Design', 'Meta', 6),
(7, 'upenn.jpg', 'University of Pennsylvania', 2025, 'Filosofía de la ciencia', 'University of Pennsylvania', 7),
(8, 'adobe.jpg', 'Adobe', 2025, 'Fundamentos del diseño con IA', 'Adobe', 8),
(9, 'stanford.jpg', 'Stanford University', 2025, 'The AI Awakening: Implications for the Economy and Society', 'Stanford University', 9);

-- ---------------------------------------------------------------------
--  Proyectos y galería — portadas incluidas en el repo
-- ---------------------------------------------------------------------
INSERT INTO `proyectos` (`id`, `titulo`, `slug`, `anio`, `img`, `descripcion`, `orden`, `creado`) VALUES
(1, 'Corazón de Tierra', 'corazon-de-tierra', '2025', 'casa-bistro-bosque.png', 'Proyecto sobre la desigualdad en el sector agrícola. Primer lugar nacional en Map the System 2025.', 1, '2026-07-20 18:00:00'),
(2, 'Casa Pestalozzi', 'casa-pestalozzi', '2025', 'casa-pestalozzi.png', 'Sitio institucional y sistema de reservaciones para el restaurante.', 2, '2026-07-20 18:05:00'),
(3, 'Colegio Bilbao', 'colegio-bilbao', '2024', 'colegio-bilbao.png', 'Rediseño del sitio y del proceso de admisiones.', 3, '2026-07-20 18:10:00'),
(4, 'Silver Society', 'silver-society', '2024', 'silver-society.png', 'Identidad y landing para la agencia.', 4, '2026-07-20 18:15:00');

INSERT INTO `proyecto_imagenes` (`id`, `proyecto_id`, `img`, `orden`) VALUES
(1, 1, 'gal-1783827921-054166.png', 1),
(2, 1, 'gal-1783827921-0c5d16.png', 2),
(3, 1, 'gal-1783827921-3b1220.png', 3),
(4, 2, 'gal-1783871678-041531.png', 1),
(5, 2, 'gal-1783871678-0e85cf.png', 2),
(6, 2, 'gal-1783871678-c8084c.png', 3);

-- ---------------------------------------------------------------------
--  Tékhne: categorías y una entrada de ejemplo
-- ---------------------------------------------------------------------
INSERT INTO `blog_categorias` (`id`, `nombre`) VALUES
(3, 'Actualidad'),
(4, 'Cuentos'),
(2, 'Cultura'),
(1, 'Tecnología');

-- El cuerpo va recortado a dos capítulos: en local no hace falta el texto completo.
INSERT INTO `blog` (`id`, `titulo`, `slug`, `estado`, `categoria`, `fecha_pub`, `descripcion`, `contenido`, `cover_img`, `ref_tipo`, `ref_id`, `visitas`, `orden`, `creado`) VALUES
(1, 'El roble que se volvió eterno', 'el-roble-que-se-volvio-eterno', 'publicado', 'Cuentos', '2023-06-01', 'Un cuento sobre un roble que escucha a las criaturas del bosque.', '<h2>Capítulo 1: Los susurros del Bosque de las Sombras Eternas</h2>El otoño, con sus hojas doradas cayendo lentamente de los árboles, es la estación perfecta del año para la reflexión. Estas hojas que danzan en el viento nos recuerdan la capacidad de cambiar con el tiempo, pero también la efímera naturaleza de nuestra existencia.<br>En el corazón de este enigmático bosque se erguía Ginkgo, el árbol más antiguo del claro. Este venerable madero, que había visto pasar las estaciones innumerables veces, había dejado de ser simplemente un árbol para convertirse en una especie de monumento viviente.<br><h2>Capítulo 2: Ziczac, el nómada enamorado</h2>Tiempo después, apareció Ziczac, un mapache con un espíritu libre, profundamente enamorado de una joven compañera de su especie. Ginkgo, el sabio roble, prestó una escucha atenta a la situación que afligía al mapache.<br>«El amor hacia alguien conlleva una responsabilidad intrínseca, pero no debe ser visto como una carga», así respondió Ginkgo.<br>', NULL, NULL, NULL, 3, 0, '2026-07-28 22:43:39');

-- Recursos asociados a la entrada (libros / películas de la reseña)
INSERT INTO `blog_recursos` (`id`, `blog_id`, `ref_tipo`, `ref_id`, `orden`) VALUES
(1, 1, 'libro', 1, 1),
(2, 1, 'pelicula', 3, 2);

-- ---------------------------------------------------------------------
--  Libros — muestra: leídos con reseña, leídos sin reseña y pendientes
-- ---------------------------------------------------------------------
INSERT INTO `libros` (`id`, `titulo`, `autor`, `estado`, `completado`, `posicion`, `estrellas`, `comentario`, `fecha_leido`, `creado`) VALUES
(1, 'Sobrevivir a internet', 'Dominique Wolton', 'leido', 1, 1, 3.0, 'Una defensa de la comunicación humana frente al ruido de la red.', '2022-11-17', '2026-07-21 03:35:11'),
(2, 'Orgullo Prieto', 'Tenoch Huerta', 'leido', 1, 2, 5.0, 'Incómodo en el mejor sentido: te obliga a mirar de frente el racismo cotidiano.', '2022-12-06', '2026-07-21 03:35:46'),
(3, 'El arte de la guerra', 'Sun Tzu', 'leido', 1, 3, 3.0, '', '2022-09-12', '2026-07-21 03:36:07'),
(4, 'Piénsalo otra vez', 'Adam Grant', 'leido', 1, 4, 4.5, 'Repensar como hábito, no como derrota.', '2026-07-20', '2026-07-21 03:39:35'),
(5, 'Sapiens. De animales a dioses', 'Yuval Noah Harari', 'leido', 1, 5, NULL, NULL, '2026-07-20', '2026-07-21 03:48:34'),
(6, 'Farenheit 451', 'Ray Bradbury', 'leido', 1, 6, NULL, NULL, '2026-07-20', '2026-07-21 03:49:17'),
(7, 'El principito', 'Antoine de Saint-Exupéry', 'leido', 1, 7, NULL, NULL, '2026-07-20', '2026-07-21 03:42:51'),
(8, 'Siddartha', 'Hermann Hesse', 'pendiente', 1, 8, NULL, NULL, NULL, '2026-07-21 04:31:01'),
(9, 'La sociedad del cansancio', 'Byung Chul Han', 'pendiente', 1, 9, NULL, NULL, NULL, '2026-07-21 04:29:21'),
(10, 'El mito de Sísifo', 'Albert Camus', 'pendiente', 0, 10, NULL, NULL, NULL, '2026-07-21 04:32:35'),
(11, '1984', 'George Orwell', 'pendiente', 0, 11, NULL, NULL, NULL, '2026-07-21 04:37:32'),
(12, 'Pedro Páramo', 'Juan Rulfo', 'pendiente', 0, 12, NULL, NULL, NULL, '2026-07-21 04:48:21'),
(13, 'El infinito en un junco', 'Irene Vallejo', 'pendiente', 0, 13, NULL, NULL, NULL, '2026-07-21 04:49:59'),
(14, 'Meditaciones', 'Marco Aurelio', 'pendiente', 0, 14, NULL, NULL, NULL, '2026-07-21 04:37:08');

-- ---------------------------------------------------------------------
--  Películas y series — poster NULL: los archivos reales viven en el servidor
-- ---------------------------------------------------------------------
INSERT INTO `pys_categorias` (`id`, `nombre`) VALUES
(3, 'Cortometraje'),
(4, 'Documental'),
(1, 'Película'),
(5, 'Reality'),
(2, 'Serie'),
(6, 'Stand Up');

INSERT INTO `peliculas_series` (`id`, `categoria`, `titulo`, `autor`, `anio`, `duracion`, `nota`, `fecha_vista`, `poster`, `comentario`, `seleccion`, `creado`) VALUES
(1, 'Serie', 'El inocente', 'Oriol Paulo', 2021, NULL, 7.0, '2021-08-14', NULL, '', 0, '2026-07-24 00:10:50'),
(2, 'Película', 'Ready Player One', 'Steven Spielberg', 2018, 140, 7.0, '2021-08-18', NULL, '', 0, '2026-07-24 00:12:10'),
(3, 'Película', 'A Star Is Born', 'Bradley Cooper', 2018, 136, 9.0, '2021-08-27', NULL, '', 0, '2026-07-28 21:30:23'),
(4, 'Serie', 'The I-Land', 'Anthony Salter', 2019, NULL, 2.0, '2021-08-27', NULL, '', 0, '2026-07-28 21:31:14'),
(5, 'Serie', 'Game of Thrones', 'David Benioff', 2011, NULL, 9.0, '2021-08-30', NULL, '', 0, '2026-07-28 21:32:43'),
(6, 'Película', 'Wonder Woman 1984', 'Patty Jenkins', 2020, 151, 4.0, '2021-09-02', NULL, '', 0, '2026-07-28 21:39:20'),
(7, 'Película', 'Space Jam: A New Legacy', 'Malcolm D. Lee', 2021, 105, 4.0, '2021-09-02', NULL, '', 0, '2026-07-28 21:40:02'),
(8, 'Película', 'Spider-Man: Homecoming', 'Jon Watts', 2017, 133, 8.0, '2021-09-04', NULL, '', 0, '2026-07-28 21:40:57'),
(9, 'Película', 'The Hunger Games: Mockingjay - Part 1', 'Francis Lawrence', 2014, 123, 6.0, '2021-09-07', NULL, '', 0, '2026-07-28 21:42:08'),
(10, 'Película', 'Shang-Chi and the Legend of the Ten Rings', 'Destin Daniel Cretton', 2021, 132, 7.0, '2021-09-11', NULL, '', 0, '2026-07-28 21:43:42');

-- ---------------------------------------------------------------------
--  Videojuegos — portada NULL por la misma razón
-- ---------------------------------------------------------------------
INSERT INTO `videojuegos` (`id`, `nombre`, `horas_iniciales`, `horas_totales`, `portada`, `orden`, `creado`) VALUES
(1, 'Papa\'s Freezeria', 25.6, 27.5, NULL, 1, '2026-07-19 15:59:26'),
(2, 'Two Point Museum', 1.3, NULL, NULL, 2, '2026-07-19 16:06:21'),
(3, 'Peak', 1.7, NULL, NULL, 3, '2026-07-19 16:06:50'),
(4, 'Supermarket Simulator', 79.0, NULL, NULL, 4, '2026-07-19 16:07:11'),
(5, 'Spiderman: Miles Morales', 1.7, 12.8, NULL, 5, '2026-07-19 16:07:36'),
(6, 'Forza Horizon 5', 1.0, NULL, NULL, 6, '2026-07-19 16:07:55');

-- ---------------------------------------------------------------------
--  Gym — julio de 2026 (el resto se genera al usar el módulo)
-- ---------------------------------------------------------------------
INSERT INTO `gym_dias` (`id`, `fecha`, `asistio`) VALUES
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
(202, '2026-07-19', 0),
(203, '2026-07-20', 0),
(204, '2026-07-21', 0),
(205, '2026-07-22', 0),
(208, '2026-07-23', 1),
(210, '2026-07-24', 1),
(211, '2026-07-25', 0),
(212, '2026-07-26', 0),
(213, '2026-07-27', 1),
(214, '2026-07-28', 1),
(215, '2026-07-29', 0),
(216, '2026-07-30', 0);

-- ---------------------------------------------------------------------
--  Finanzas
-- ---------------------------------------------------------------------
INSERT INTO `activos` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Revolut', 25000.00, 1),
(3, 'Nu', 25000.00, 2),
(4, 'Yotepresto', 2000.00, 3),
(5, 'Briq', 1000.00, 4),
(6, 'Monific', 1000.00, 5);

INSERT INTO `deudas` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Deuda', 55600.00, 1);

INSERT INTO `cuentas_por_cobrar` (`id`, `nombre`, `monto`, `orden`) VALUES
(1, 'Maye', 55600.00, 1),
(2, 'Julio', 33400.00, 2);

INSERT INTO `patrimonio_snapshots` (`id`, `fecha`, `neto`) VALUES
(2, '2026-07-31', 87400.00);

-- ---------------------------------------------------------------------
--  Horario: materias, bloques y criterios de evaluación
-- ---------------------------------------------------------------------
INSERT INTO `materias` (`id`, `nombre`, `profesor`, `nrc`, `creditos`, `color`, `orden`) VALUES
(1, 'Blockchain', 'José de Jesús Angel Angel', '11662', 4.5, '#4267AC', 1),
(2, 'Big Data', 'Flavio Lucio Pontecorvo', '11665', 4.5, '#8AC926', 2),
(3, 'Programación Dispositivos Móviles', 'Héctor Julián Selley Rojas', '11659', 6.0, '#E51022', 3),
(4, 'IA Aplicada Ciencias Sociales', 'Profesor', '16642', 6.0, '#F5B400', 4),
(5, 'Cómputo en la Nube', 'Alejandro Goldberg Fridman', '11667', 4.5, '#EA075A', 0),
(6, 'Internet de las Cosas', 'Alejandro Goldberg Fridman', '11666', 4.5, '#AA2296', 6),
(7, 'Practicum I', 'Emma María Teresa Zárate Inestrillas', '14006', 6.0, '#FC6722', 7),
(8, 'Responsabilidad Social', 'Profesor', '0', 6.0, '#3A86FF', 8),
(9, 'Dilemas Éticos', '', '', 3.0, '#3A86FF', 9);

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
(15, 5, 'jue', '20:30:00', '22:00:00'),
(16, 9, 'mar', '14:30:00', '16:00:00'),
(17, 9, 'jue', '14:30:00', '16:00:00');

-- Criterios de ejemplo para probar el simulador de calificaciones
INSERT INTO `materia_criterios` (`id`, `materia_id`, `nombre`, `peso`, `calificacion`, `orden`) VALUES
(1, 1, 'Examen Escrito 1', 5.00, 10.00, 1),
(2, 1, 'Tareas y Lecturas', 15.00, 9.60, 2),
(3, 1, 'Examen Escrito 2', 20.00, 10.00, 3),
(4, 1, 'Examen Escrito 3', 20.00, 10.00, 4),
(5, 1, 'Examen Escrito Final', 40.00, 7.00, 5),
(6, 2, 'Examen Escrito 1', 3.00, 9.10, 1),
(7, 2, 'Examen Escrito 2', 4.00, 6.90, 2),
(8, 2, 'Proyecto Final', 53.00, 9.00, 3),
(9, 2, 'Participación', 40.00, 8.50, 4),
(10, 3, 'Prácticas', 40.00, 9.50, 1),
(11, 3, 'Proyecto Final', 60.00, 8.80, 2);

-- ---------------------------------------------------------------------
--  Mapas curriculares (Anáhuac / UNAM)
-- ---------------------------------------------------------------------
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
(15, 'anahuac', 2, 7, NULL, 'Taller o Actividad Electiva', 'cursando'),
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

-- ---------------------------------------------------------------------
--  Visitas — sin datos semilla: `visitas` y `visitas_pagina` se llenan solas
--  al navegar el sitio.
-- ---------------------------------------------------------------------

COMMIT;
