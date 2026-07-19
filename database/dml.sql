INSERT INTO usuarios (usuario, nombre, apellido, email, password, admin, confirmado) VALUES
('alex', 'Alexander', 'Oliva', 'alexcayd@gmail.com',
 '$2y$12$BILzYC15G.oP1RPDlbzErutMfczwhvCEfYjAGn17UsVI3AIsU8Rd6', 1, 1);

-- ---------------------------------------------------------------------
--  Proyectos — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Servicios
-- ---------------------------------------------------------------------
INSERT INTO servicios (num, titulo, descripcion, tags, orden) VALUES
('01', 'Desarrollo de software', 'HTML, CSS y JavaScript. Llevo el diseño hasta el producto vivo y funcional, del prototipo al código en producción.', 'Front-end,Responsive,Animación', 1),
('02', 'UX/UI Design', 'Interfaces claras, jerárquicas y accesibles. Diseño pensado en personas reales, no en suposiciones.', 'Design Systems,Accesibilidad,Figma', 2),
('03', 'Estrategia digital', 'Contenido, posicionamiento y decisiones de producto con visión de negocio y comunicación.', 'Contenido,Marca,Producto', 3),
('04', 'Automatizaciones', 'Flujos que ahorran horas: integro herramientas y proceso tareas repetitivas para que el trabajo se haga solo.', 'Workflows,Integraciones,APIs', 4),
('05', 'SEO', 'Posicionamiento orgánico con base técnica: estructura, contenido y rendimiento para que te encuentren.', 'SEO técnico,Contenido,Analítica', 5);

-- ---------------------------------------------------------------------
--  Credenciales — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Tékhne (blog) — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Visitas del sitio — sin datos de ejemplo.
--  Se registran solas: total diario (visitas) y por página (visitas_pagina).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Libros — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Categorías de Películas y Series
-- ---------------------------------------------------------------------
INSERT INTO pys_categorias (nombre) VALUES
('Película'), ('Serie'), ('Cortometraje'), ('Documental'), ('Reality'), ('Stand Up');

-- ---------------------------------------------------------------------
--  Películas y Series — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Videojuegos — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Finanzas — sin datos de ejemplo (el módulo se llena desde el panel).
--  El snapshot del patrimonio neto se registra solo al entrar a /admin/finanzas.
-- ---------------------------------------------------------------------

-- Categorías del blog
INSERT INTO blog_categorias (nombre) VALUES
('Tecnología'), ('Cultura'), ('Actualidad'), ('Cuentos');

-- ---------------------------------------------------------------------
--  Horario (materias + bloques) — sin datos de ejemplo (se cargan desde el panel).
-- ---------------------------------------------------------------------

-- ---------------------------------------------------------------------
--  Mapa curricular — ANÁHUAC (Ing. en Sistemas y Tec. de la Información)
--  Estado inicial: sem 1-8 completado, sem 9 cursando (Prácticum II bloqueada)
-- ---------------------------------------------------------------------
INSERT INTO curriculum_materias (mapa, semestre, fila, codigo, nombre, estado) VALUES
('anahuac',1,1,'MAT1402','Cálculo Diferencial','desbloqueada'),
('anahuac',1,2,'MAT1401','Fundamentos de Matemáticas','desbloqueada'),
('anahuac',1,3,'FIS1401','Física','desbloqueada'),
('anahuac',1,4,'CMP1403','Introducción a la Computación','desbloqueada'),
('anahuac',1,5,'CUL1411','Formación Universitaria A','desbloqueada'),
('anahuac',1,6,'HUM1401','Ser Universitario','desbloqueada'),
('anahuac',1,7,NULL,'Taller o Actividad Electiva','desbloqueada'),
('anahuac',1,8,NULL,'Taller o Actividad Electiva','desbloqueada'),
('anahuac',2,1,'MAT1403','Cálculo Integral','desbloqueada'),
('anahuac',2,2,'MAT1404','Álgebra Lineal','desbloqueada'),
('anahuac',2,3,'IELC1401','Circuitos Eléctricos','desbloqueada'),
('anahuac',2,4,'MAT2403','Probabilidad y Estadística','desbloqueada'),
('anahuac',2,5,'SIS1401','Algoritmos y Programación','desbloqueada'),
('anahuac',2,6,'HUM1402','Antropología Fundamental','desbloqueada'),
('anahuac',2,7,NULL,'Taller o Actividad Electiva','desbloqueada'),
('anahuac',3,1,'MAT2401','Cálculo Multivariado','desbloqueada'),
('anahuac',3,2,'MAT2410','Álgebra Lineal Avanzada','desbloqueada'),
('anahuac',3,3,'SIS2401','Redes de Computadoras','desbloqueada'),
('anahuac',3,4,'SIS2403','Bases de Datos','desbloqueada'),
('anahuac',3,5,'SIS2402','Programación con Microcontroladores','desbloqueada'),
('anahuac',3,6,'HUM1404','Ética','desbloqueada'),
('anahuac',3,7,'LDR1401','Liderazgo y Desarrollo Personal','desbloqueada'),
('anahuac',4,1,'MAT2402','Ecuaciones Diferenciales','desbloqueada'),
('anahuac',4,2,'MAT1411','Matemáticas Discretas','desbloqueada'),
('anahuac',4,3,'CMP2405','Arquitectura de Computadoras','desbloqueada'),
('anahuac',4,4,'SIS2404','Bases de Datos Avanzadas','desbloqueada'),
('anahuac',4,5,'SIS1402','Lenguajes Orientados a Objetos','desbloqueada'),
('anahuac',4,6,'MAT2404','Estadística Inferencial','desbloqueada'),
('anahuac',4,7,'HUM1405','Humanismo Clásico y Contemporáneo','desbloqueada'),
('anahuac',4,8,'EMPI1401','Habilidades para el Emprendimiento','desbloqueada'),
('anahuac',5,1,'SIS3401','Sistemas Operativos','desbloqueada'),
('anahuac',5,2,'FIS2402','Física Moderna','desbloqueada'),
('anahuac',5,3,'SIS3404','Implementación de Sistemas Integrados','desbloqueada'),
('anahuac',5,4,'SIS3405','Estructuras de Datos','desbloqueada'),
('anahuac',5,5,'SIS3406','Ingeniería de Software','desbloqueada'),
('anahuac',5,6,'HUM1403','Persona y Trascendencia','desbloqueada'),
('anahuac',5,7,'EMP1402','Emprendimiento e Innovación','desbloqueada'),
('anahuac',5,8,NULL,'Asignatura Electiva Interdisciplinaria','desbloqueada'),
('anahuac',6,1,'SIS3412','Desarrollo de Tecnologías de Internet','desbloqueada'),
('anahuac',6,2,'MAT3402','Métodos Numéricos','desbloqueada'),
('anahuac',6,3,'SIS3402','Redes Avanzadas','desbloqueada'),
('anahuac',6,4,'SIS3409','Inteligencia de Negocios','desbloqueada'),
('anahuac',6,5,'SIS3411','Desarrollo de Software','desbloqueada'),
('anahuac',6,6,NULL,'MINOR 1','desbloqueada'),
('anahuac',6,7,'LDR2401','Liderazgo y Equipos de Alto Desempeño','desbloqueada'),
('anahuac',6,8,NULL,'Asignatura Electiva Interdisciplinaria','desbloqueada'),
('anahuac',7,1,'CMP4402','Cómputo en la Nube','desbloqueada'),
('anahuac',7,2,'SIS4403','Seguridad Informática y Redes Forenses','desbloqueada'),
('anahuac',7,3,'SIS3410','Programación para Internet','desbloqueada'),
('anahuac',7,4,'SIS3403','Programación para Dispositivos Móviles','desbloqueada'),
('anahuac',7,5,'SIS4401','Inteligencia Artificial','desbloqueada'),
('anahuac',7,6,NULL,'MINOR 2','desbloqueada'),
('anahuac',7,7,'SIS4402','Calidad de Software','desbloqueada'),
('anahuac',7,8,NULL,'Asignatura Electiva Anáhuac','desbloqueada'),
('anahuac',8,1,'INT4409','Prácticum I: Ingeniería de Proyectos','desbloqueada'),
('anahuac',8,2,'SIS4414','Algoritmos de Optimización','desbloqueada'),
('anahuac',8,3,'SIS4406','Gestión Estratégica de TI','desbloqueada'),
('anahuac',8,4,'SIS4408','Machine Learning','desbloqueada'),
('anahuac',8,5,'CON2402','Contabilidad y Costos para Ingeniería','desbloqueada'),
('anahuac',8,6,'CUL1412','Formación Universitaria B','desbloqueada'),
('anahuac',8,7,NULL,'MINOR 3','desbloqueada'),
('anahuac',8,8,NULL,'Asignatura Electiva Interdisciplinaria','desbloqueada'),
('anahuac',9,1,'INT4410','Prácticum II: Administración de Proyectos','desbloqueada'),
('anahuac',9,2,'SIS4413','Blockchain','desbloqueada'),
('anahuac',9,3,'CMP4404','Internet de las Cosas','desbloqueada'),
('anahuac',9,4,'SIS4412','Big Data','desbloqueada'),
('anahuac',9,5,'ING4401','Innovación Tecnológica','desbloqueada'),
('anahuac',9,6,NULL,'MINOR 4','desbloqueada'),
('anahuac',9,7,'SOC3401','Responsabilidad Social y Responsabilidad','desbloqueada');

-- ---------------------------------------------------------------------
--  Mapa curricular — UNAM (Ciencias de la Comunicación)
--  Estado inicial: sem 1-3 completado, sem 4-6 desbloqueada, sem 7-8 bloqueada
-- ---------------------------------------------------------------------
INSERT INTO curriculum_materias (mapa, semestre, fila, codigo, nombre, estado) VALUES
('unam',1,1,NULL,'Introducción al pensamiento social y político moderno','desbloqueada'),
('unam',1,2,NULL,'Construcción histórica de México en el mundo I (1808-1946)','desbloqueada'),
('unam',1,3,NULL,'Economía','desbloqueada'),
('unam',1,4,NULL,'Consulta de fuentes y lectura numérica del mundo','desbloqueada'),
('unam',1,5,NULL,'Comprensión y expresión oral','desbloqueada'),
('unam',1,6,NULL,'Lenguaje, cultura y poder','desbloqueada'),
('unam',2,1,NULL,'Teorías de la Comunicación I','desbloqueada'),
('unam',2,2,NULL,'Construcción histórica de México en el mundo II (a partir de 1947)','desbloqueada'),
('unam',2,3,NULL,'Estado, Sociedad y Derecho','desbloqueada'),
('unam',2,4,NULL,'Introducción a la investigación en ciencias sociales','desbloqueada'),
('unam',2,5,NULL,'Argumentación y expresión escrita','desbloqueada'),
('unam',2,6,NULL,'Teorías y análisis del Discurso','desbloqueada'),
('unam',3,1,NULL,'Teorías de la Comunicación II','desbloqueada'),
('unam',3,2,NULL,'Procesos y medios de comunicación en la historia de México (1320-1876)','desbloqueada'),
('unam',3,3,NULL,'Análisis de las organizaciones públicas','desbloqueada'),
('unam',3,4,NULL,'Estadística aplicada a las ciencias sociales','desbloqueada'),
('unam',3,5,NULL,'Géneros periodísticos informativos','desbloqueada'),
('unam',3,6,NULL,'Teorías de la significación','desbloqueada'),
('unam',4,1,NULL,'Teorías de la Comunicación III','desbloqueada'),
('unam',4,2,NULL,'Procesos y medios de comunicación en la historia de México (1877-2015)','desbloqueada'),
('unam',4,3,NULL,'Opinión pública y propaganda','desbloqueada'),
('unam',4,4,NULL,'Investigación en comunicación','desbloqueada'),
('unam',4,5,NULL,'Géneros periodísticos interpretativos','desbloqueada'),
('unam',4,6,NULL,'Comunicación publicitaria / Imagen y discurso audiovisual','desbloqueada'),
('unam',5,1,NULL,'Géneros periodísticos de opinión','desbloqueada'),
('unam',5,2,NULL,'Corrección de originales','desbloqueada'),
('unam',5,3,NULL,'Metodología de la investigación periodística','desbloqueada'),
('unam',5,4,NULL,'Periodismo, ética y derechos humanos','desbloqueada'),
('unam',5,5,NULL,'Optativa de elección - Psicología de la comunicación','desbloqueada'),
('unam',6,1,NULL,'Periodismo especializado','desbloqueada'),
('unam',6,2,NULL,'Planeación y gestión de empresas editoriales','desbloqueada'),
('unam',6,3,NULL,'Periodismo y lenguaje narrativo','desbloqueada'),
('unam',6,4,NULL,'Optativa elección - El cine como cultura audiovisual','desbloqueada'),
('unam',6,5,NULL,'Optativa - Animación Digital','desbloqueada'),
('unam',7,1,NULL,'Periodismo multimedia','desbloqueada'),
('unam',7,2,NULL,'Diseño y creación editorial de soportes impresos y digitales','desbloqueada'),
('unam',7,3,NULL,'Diseño y desarrollo de proyectos profesionales','desbloqueada'),
('unam',7,4,NULL,'Optativa - Diseño y producción de videojuegos','desbloqueada'),
('unam',7,5,NULL,'Optativa - Lenguaje Cinematográfico como Cultura Audiovisual','desbloqueada'),
('unam',8,1,NULL,'Optativa - Arte y comunicación','desbloqueada'),
('unam',8,2,NULL,'Optativa - Creatividad publicitaria','desbloqueada'),
('unam',8,3,NULL,'Optativa - Periodismo en internet','desbloqueada'),
('unam',8,4,NULL,'Optativa - Análisis Semiótico','desbloqueada'),
('unam',8,5,NULL,'Optativa - Nuevos escenarios tecnológicos en producción audiovisual','desbloqueada');
