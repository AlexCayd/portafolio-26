-- =====================================================================
--  DATOS DE PRODUCCIÓN — alexanderoliva.com
--  Volcado de phpMyAdmin del 15-09-2026 a las 21:17:52.
--  Estructura y datos de las tablas del portafolio.
-- =====================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
START TRANSACTION;

-- --------------------------------------------------------
--
-- Estructura de la tabla `usuarios`
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
(1, 'alex', 'Alexander', 'Oliva', 'alexcayd@gmail.com', '$2y$10$f.l7rHTrFbXJqiShY.OG5ej7UJlPjeaii3Wr.Don4wpTDayO.Utn.', 1, 1, NULL, '2026-07-17 20:22:15');

-- --------------------------------------------------------
--
-- Estructura de la tabla `servicios`
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
-- Estructura de la tabla `credenciales`
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

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `logo`, `alt`, `anio`, `titulo`, `institucion`, `orden`) VALUES
(1, 'logo-1785956329-28fa6c.png', 'Google', 2022, 'IT Support', 'Google', 13),
(2, 'logo-1785956288-de0212.png', 'Mindshop', 2023, 'Ancient Greek Philosophy', 'Mindshop', 14),
(3, 'logo-1785956335-4012e9.png', 'CONAMAT', 2024, 'Mathematics Diploma', 'CONAMAT', 17),
(4, 'logo-1785956262-fb1142.png', 'Google', 2024, 'Google AI Essentials', 'Google', 9),
(5, 'logo-1785956202-abebac.png', 'Google', 2024, 'UX Design', 'Google', 2),
(6, 'logo-1785956269-cbf3fc.png', 'IBM', 2024, 'Generative AI Fundamentals', 'IBM', 5),
(7, 'logo-1785956234-80b47c.png', 'University of London', 2025, 'Responsive Web Design', 'University of London', 6),
(8, 'logo-1785956255-db86f1.png', 'Politecnico di Milano', 2025, 'Ethics of Artificial Intelligence', 'Politecnico di Milano', 8),
(9, 'logo-1785956295-7b9cfb.png', 'Mindshop', 2025, 'Moral Philosophy', 'Mindshop', 15),
(10, 'logo-1785956322-06b2c2.png', 'Universidad de los Andes', 2025, 'Ciberseguridad', 'Universidad de los Andes', 12),
(11, 'logo-1785956224-6e3246.png', 'Meta', 2025, 'Principles of UX/UI Design', 'Meta', 4),
(12, 'logo-1785956315-4438fd.png', 'University of Pennsylvania', 2025, 'Filosofía de la ciencia', 'University of Pennsylvania', 10),
(13, 'logo-1785956277-a70d9e.png', 'Adobe', 2025, 'Fundamentos del diseño con IA', 'Adobe', 7),
(14, 'logo-1785956214-682845.png', 'Stanford University', 2025, 'The AI Awakening: Implications for the Economy and Society', 'Stanford University', 3),
(15, 'logo-1785956302-4d8bf6.png', 'Mindshop', 2025, 'Aesthetics', 'Mindshop', 16),
(16, 'logo-1785956246-6ec01f.png', 'Udemy', 2025, 'n8n + MCP: Automatización y agentes de IA inteligentes', 'Udemy', 11),
(17, 'logo-1785956190-9478e4.png', 'Udemy', 2026, 'Desarrollo Web Completo con HTML5, CSS3, JS AJAX PHP y MySQL', 'Udemy', 1);

-- --------------------------------------------------------
--
-- Estructura de la tabla `proyectos`
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

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `titulo`, `slug`, `anio`, `img`, `descripcion`, `orden`, `creado`) VALUES
(1, 'Colegio Bilbao', 'colegio-bilbao', '2026', 'proyecto-1786720571-56741a.jpg', 'Enlace: https://bilbao.edu.mx\r\n\r\nContexto y Desafío\r\nEl Colegio Bilbao requería fortalecer su presencia digital y optimizar la gestión de sus procesos internos. El sistema original presentaba caídas constantes debido a cuellos de botella en un servidor obsoleto (Plesk - Windows) y recursos multimedia no optimizado. A nivel operativo, el colegio enfrentaba alta fricción en procesos internos, como la gestión y asignación de suplencias docentes\r\n\r\nRol y Arquitectura\r\nComo desarrollador principal, lideré la migración completa del sitio hacia una arquitectura MVC, apoyada en un patrón Active Record para la interacción con bases de datos relacionales. Diseñé y desarrollé desde cero un panel de administración escalable con control de acceso basado en roles con flujos de aprobación de contenidos. Posteriormente, escalé este panel hasta convertirlo en una Intranet a la medida, integrando módulos de operación académica (aulas, profesores, prefectura, horarios, suplencias, entre otros)\r\n\r\nStack Tecnológico y Soluciones\r\nBackend: Arquitectura MVC, PHP, SQL, patrón Active Record\r\nFrontend y UX/UI: Rediseño completo de la landing page y portales internos integrando bibliotecas de animación como GSAP para una experiencia de usuario interactiva y moderna\r\nOptimización y SEO: Refactorización de la estructura de metadatos, encabezados y recursos de carga para optimizar el posicionamiento orgánico y el rendimiento\r\n\r\nImpacto y Resultados\r\nCrecimiento exponencial: La optimización técnica y de infraestructura permitió soportar un aumento de tráfico del 320% en un solo mes, procesando más de 356,000 peticiones y cerrando mayo de 2026 con un hito de más de 111,000 visitas acumuladas\r\nEstabilidad: Se eliminaron las caídas del sitio web mediante el cambio de infraestructura y la optimización del peso de los recursos visuales\r\nTransformación digital interna: Se entregó un ecosistema digital completo que además de atender a los visitantes públicos, centraliza la comunicación de estudiantes, familias y colaboradores, resolviendo puntos críticos de la administración escolar', 0, '2026-08-14 15:16:11'),
(2, 'Casa Pestalozzi', 'casa-pestalozzi', '2026', 'proyecto-1786721296-94b3cb.jpg', 'Contexto y Desafío\r\nCasa Pestalozzi, un restaurante ubicado en la colonia Del Valle (CDMX), requería una digitalización integral de su flujo de servicio. El reto consistía en conectar la experiencia pública del cliente con la operación interna del negocio, eliinando los cuellos de botella entre toma de órdenes, preparación de alimentos, gestión de reservaciones y control administrativo\r\n\r\nRol y Metodología\r\nActué con un rol híbrido como Desarrollador Full-Stack, Project Manager y Scrum Master. Lideré, junto a mi equipo, la concepción del producto, la gestión de los sprints y los recursos del equipo, y diseñé fundamentalmente la experiencia de usuario del sistema interconectado\r\n\r\nStack Tecnológico y Arquitectura \r\nDesarrollo bajo una arquitectura MVC utilizando PHP, bases de datos relacionales SQL implemenando el patrón Active Record, SASS como tecnología de estilos y JavaScript para la reactividad de las interfaces operativas\r\n\r\nSoluciones Implementadas\r\nOperación en Tiempo Real: Desarrollo de un Punto de Venta (POS) a la medida sincronizado con cuatro Kitchen Display Systems (KDS) segmentado, lo que permitió orquestar las comandas para las diferentes áreas de la cocina de forma simultánea\r\nGestión y Adquisición: Creación de una landing page comercial conectada a un módulo de feedback para evaluar la satisfacción de los comensales, todo centralizado en un panel de administración para la toma de decisiones gerenciales\r\nInteligencia Artificial: Sistema de recomendaciones en el punto de venta para que los meseros puedan elevar el ticket promedio basado en las preferencias de los comensales. Construcción de insights accionables para el negocio en función de las retroalimentaciones dadas en los feedbacks', 2, '2026-08-14 15:28:16'),
(3, 'Eptos Uno', 'eptos-uno', '2026', 'proyecto-1786722007-d33ae1.jpg', 'Enlace: https://eptosuno.com\r\n\r\nContexto y Desafío\r\nEl artista Eptos Uno requería un hub digital para consolidar su presencia en línea y conectar directamente con su audiencia. El reto principal era unificar toda su comunicación (fechas de presentaciones, trayectoria en batallas, lanzamientos) en un espacio propio, sin depender necesariamente de las redes sociales ni de plataformas de terceros\r\n\r\nRol y Gestión\r\nComo Diseñador UX/UI y Desarrollador Web, dirigí el ciclo completo del proyecto. Traduje la visión del artista en el código y ejecuté la programación de la interfaz garantizando que la estética visual y la identidad de la marca se mantuvieran fieles\r\n\r\nStack Tecnológico y Soluciones\r\nDesarrollo Nativo: Programación ágil utilizando exclusivamente HTML5, CC3 y JavaScript puro para asegurar el máximo rendimiento, logrando un diseño responsivo, fluido y de carga ultrarrápida sin recurrir a librerías externas que añadieran peso innecesario\r\nProcesamiento de Datos en el Cliente: Implementación de lógica a la medida en JavaScript para iterar, ordenar cronológicamente y renderizar de forma dinámica el extenso catálogo de álbumes, detalles de las pistas y lanzamientos históricos del artista, permitiendo una navegación rápida y estructurada por la discografía\r\n\r\nImpacto y Resultados\r\nSe entregó un sitio de alto impacto visual que centraliza la carrera del artista. La arquitectura liviana ofrece a los seguidores un punto de acceso directo e ininterrumpido a su música, mercancía y eventos de manera veloz, mejorando significativamente la experiencia del usuario', 0, '2026-08-14 15:40:07'),
(4, 'Casa Bistró Bosque', 'casa-bistro-bosque', '2025', 'proyecto-1786825996-7c48ba.jpg', 'Enlace: https://casabistrobosque.com\r\n\r\nContexto y Desafío\r\nUn complejo residencial con restaurante interno requería una solución digital ágil para gestionar envíos de comida directamente a los departamentos (room service). El reto principal era crear una experiencia de usuario sencilla para los residentes al realizar pedidos desde sus dispositivos móviles, y al mismo tiempo, proveer al personal de cocina un sistema de recepción de comandas inmediato, de bajo costo y sin curva de aprendizaje\r\n\r\nRol y Arquitectura\r\nComo Desarrollador, diseñé e implementé una solución basada en microservicios e integraciones en la nube. La arquitectura prescinde de un backend tradicional, comunicando el frontend directamente con herramientas de ofimática (Google Sheets) para automatizar el flujo operativo del restaurante\r\n\r\nStack Tecnológico y Soluciones\r\nInterfaz de Usuario (Frontend): Desarrollo del menú interactivo y carrito de compras utilizando HTML, CSS y JavaScript nativo. Se priorizó un diseño mobile-first de carga rápida para garantizar una excelente experiencia desde los teléfonos de los residentes\r\nAutomatización e Integración: Conexión asíncrona de los pedidos desde la interfaz web hacia Google Sheets vía Webhook. La hoja de cálculo actúa como una base de datos transaccional en la nube y un Kitchen Display System (KDS) en tiempo real, permitiendo a los cocineros visualizar, organizar y despachar las órdenes al instante\r\n\r\nImpacto y Restulados\r\nSe logró digitalizar la captación de pedidos departamentales mediante una infraestructura mínima y altamente rentable. La integración eliminó los errores derivados de la toma de órdenes manuales y por teléfono, optimizando los tiempos de preparación y entrega, facilitando la gestión operativa del personal de cocina mediante una herramienta que ya dominaban (hojas de cálculo)', 4, '2026-08-15 20:33:16'),
(5, 'Tonico Vittale', 'tonico-vittale', '2024', 'proyecto-1786826656-4b0b8f.jpg', 'Contexto y Desafío\r\nTonico Vitale, una marca enfocada en el cuidado personal natural, requería consolidar su canal de ventas digital. El reto principal además de darle seguimiento a la tienda en línea transaccional, fue diseñar e implementar estrategias capaces de atraer tráfico cualificado, retener la atención del usuario y maximizar la tasa de conversión y recompra\r\n\r\nRol y Enfoque\r\nComo Diseñador UX/UI y Estratega Digital, configuré, desarrollé y personalicé componentes utilizando Shopify. Se diseñó una interfaz intuitiva, responsiva y visualmente atractiva que resalta la identidad de los productos\r\nGrowth y Adquisición: Implementación de estrategias técnicas orientadas a la atracción de clientes y optimización del embudo de ventas, facilitando el recurrido del usuario desde el descubrimiento del producto hasta el checkout\r\n\r\nImpacto y Resultados\r\nSe entregó un canal de ventas automatizado y escalable. La plataforma además de exponer el catálogo de productos de manera atractiva, opera activamente como herramienta de retención y conversión, mejorando la visibilidad orgánica de la marca y dinamizando los flujos de ingresos', 5, '2026-08-15 20:44:16');

-- --------------------------------------------------------
--
-- Estructura de la tabla `proyecto_imagenes`
--

CREATE TABLE `proyecto_imagenes` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `img` varchar(160) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proyecto_imagenes`
--

INSERT INTO `proyecto_imagenes` (`id`, `proyecto_id`, `img`, `orden`) VALUES
(1, 3, 'gal-1789506961-9106de.png', 1),
(2, 3, 'gal-1789506961-5e0640.png', 2),
(3, 3, 'gal-1789506961-314ab3.png', 3),
(4, 3, 'gal-1789506961-971be9.png', 4),
(5, 3, 'gal-1789506961-6ce9d8.png', 5),
(6, 3, 'gal-1789506961-29f72a.png', 6);

-- --------------------------------------------------------
--
-- Estructura de la tabla `blog_categorias`
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
-- Estructura de la tabla `blog`
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

--
-- Volcado de datos para la tabla `blog`
--

INSERT INTO `blog` (`id`, `titulo`, `slug`, `estado`, `categoria`, `fecha_pub`, `descripcion`, `contenido`, `cover_img`, `ref_tipo`, `ref_id`, `visitas`, `orden`, `creado`) VALUES
(1, 'El roble que se volvió eterno', 'el-roble-que-se-volvio-eterno', 'publicado', 'Cuentos', '2021-06-01', 'Diez criaturas del Bosque de las Sombras Eternas acuden a Ginkgo, el roble más antiguo del claro, en busca de un consejo que él tardó siglos en atreverse a dar.', '<h2>Capítulo 1: Los susurros del Bosque de las Sombras Eternas</h2>\n<p>El otoño, con sus hojas doradas cayendo lentamente de los árboles, es la estación perfecta del año para la reflexión. Estas hojas que danzan en el viento nos recuerdan la capacidad de cambiar con el tiempo, pero también la efímera naturaleza de nuestra existencia. Cuando la brisa susurra a través de las ramas doradas y las hojas alfombran el suelo, el Bosque de las Sombras Eternas se transforma en un reino encantado, sumiendo a los viajeros en una densa y cautivadora experiencia.</p>\n<p>En el corazón de este enigmático bosque se erguía Ginkgo, el árbol más antiguo del claro. Este venerable madero, que había visto pasar las estaciones innumerables veces, había dejado de ser simplemente un árbol para convertirse en una especie de monumento viviente. Se alzaba majestuoso como un guardián de secretos ancestrales, su corteza rugosa y sus raíces entrelazadas con la historia del bosque.</p>\n<p>Ginkgo, desde su posición privilegiada, observaba las vivencias de los habitantes del Bosque de las Sombras Eternas. Muchos de ellos, criaturas misteriosas y fascinantes, se acercaban al antiguo roble en busca de comprensión y alivio. Durante mucho tiempo, Ginkgo había permanecido en silencio, como un testigo imperturbable de sus vidas, un espectador que nunca respondía a sus súplicas.</p>\n<p>Sin embargo, llegó un día en el que el anciano árbol comenzó a sentir el peso de los años acumulados en su inmovilidad. En ese instante, Ginkgo tomó una decisión tajante: respondería al llamado de todos aquellos que llegaban en busca de consejo. Comenzó a cuestionarse su papel en el mundo, comprendiendo que nada había valido la pena si no se abría al mundo que lo rodeaba. Las ramas de Ginkgo, antes quietas y solemnes, parecieron cobrar vida, como si estuvieran ansiosas por compartir las historias que habían acumulado a lo largo de los siglos.</p>\n<p>Así, el Bosque de las Sombras Eternas se llenó de susurros y relatos, y Ginkgo se convirtió en el sabio narrador de historias que todos necesitaban. Desde entonces, aquellos que buscaban respuestas encontraron en su sombra protectora una fuente inagotable de sabiduría, un faro de luz en medio de la densa oscuridad del bosque. Ginkgo, el antiguo testigo, se convirtió en el narrador de los secretos del bosque, compartiendo la riqueza de su experiencia con quienes anhelaban conocer los misterios que habían permanecido ocultos durante eones.</p>\n<h2>Capítulo 2: Ziczac, el nómada enamorado</h2>\n<p>Tiempo después, apareció Ziczac, un mapache con un espíritu libre, profundamente enamorado de una joven compañera de su especie. Sin embargo, Ziczac se encontraba atrapado en la encrucijada de decidir si estaría dispuesto a renunciar a su nomadismo para forjar una familia. Ginkgo, el sabio roble, prestó una escucha atenta a la situación que afligía al mapache, quien sin duda se encontraba en un dilema.</p>\n<p>El anciano árbol indagó acerca de los verdaderos deseos del mapache confundido. Ziczac expresó su inquietud, ya que contemplar la posibilidad de formar una familia con la joven mapache que ocupaba sus pensamientos le parecía una responsabilidad que podría restringir sus libertades.</p>\n<p>«El amor hacia alguien conlleva una responsabilidad intrínseca, pero no debe ser visto como una carga», así respondió Ginkgo.</p>\n<p>Era evidente que Ziczac tendría que hacer concesiones en su estilo de vida para asumir la responsabilidad que implicaba su afecto. No obstante, si su amor era verdadero, no debería considerar esta responsabilidad como una penitencia que cumplir, sino como un regalo desinteresado que otorgaba un nuevo sentido y riqueza a su vida.</p>\n<p>La voz de Ziczac comenzó a quebrarse, no solo debido a la dificultad de aceptar el consejo de un árbol inmóvil, sino también porque en su interior sabía exactamente lo que debía hacer. Consciente de las imperfecciones que caracterizaban a su amada compañera, él entendía que amarla a pesar de sus defectos era un reflejo de la profundidad de sus sentimientos. Este entendimiento reforzó aún más el mensaje impartido por Ginkgo.</p>\n<p>Ziczac se sintió abrumado por la certeza de su amor y la importancia de aceptar la responsabilidad que conllevaba. Sabía que no sería fácil, pero también comprendía que el amor verdadero trasciende las limitaciones y se manifiesta en la aceptación de las imperfecciones del otro. Con el consejo de Ginkgo y un corazón decidido, Ziczac estaba dispuesto a embarcarse en la aventura de formar una familia y descubrir el verdadero significado de la responsabilidad en el amor. Antes de partir, Ziczac hizo una reverencia respetuosa ante el sabio roble Ginkgo, agradeciéndole por sus valiosas palabras y por ser testigo de este importante capítulo de su vida.</p>\n<h2>Capítulo 3: La frustración del banquete de Aven</h2>\n<p>Al día siguiente, Aven regresó exhausta de una larga expedición por el Bosque de las Sombras Eternas. En esta ocasión, su regreso fue triunfal, con el inventario repleto y la boca llena de piñones que había encontrado durante su travesía. Siguiendo su costumbre, la ardilla depositó cuidadosamente su preciada carga en su hogar, uno de los compartimentos internos del venerable Ginkgo. A lo largo de los años, el árbol nunca cuestionó su actuar ni impidió que Aven viviera dentro de él, pero ese día algo inusual capturó la atención del sabio roble.</p>\n<p>Mientras Aven organizaba los piñones, notó que muchos de ellos comenzaron a caer desde las ramas de Ginkgo. Esta extraña ocurrencia despertó la curiosidad del árbol, ya que sabía que la ardilla nunca consumía los piñones que con tanto esmero recolectaba. La situación intrigante llevó a una conversación entre Aven y el anciano Ginkgo.</p>\n<p>La ardilla explicó repetidamente que juntaba los piñones con la idea de disfrutar de un festín en una ocasión especial. Sin embargo, el sabio roble estaba consciente de que Aven había acumulado mucho más alimento del necesario, suficiente para sobrevivir a cinco inviernos seguidos. Aven se consideraba a sí misma una excelente planificadora y se sentía responsable de sus acciones.</p>\n<p>«Siempre esperar una oportunidad especial para vivir algo significa que podríamos pasar la vida esperando. Son nuestras acciones y decisiones las que crean los momentos especiales», así respondió Ginkgo.</p>\n<p>Sin lugar a dudas, en cada arriesgada expedición, Aven ponía en juego su vida en su incansable búsqueda de más y más piñones. Este arrojo añadía un valor adicional a los piñones, ya que representaban no solo su sacrificio, sino también su tenacidad. Sin embargo, en medio de esta búsqueda incesante, Aven había perdido de vista el verdadero propósito detrás de su recolección: disfrutar de un festín que colmara su alma de satisfacción.</p>\n<p>La ardilla vivía tan apresuradamente, planeando con tanta anticipación, que había olvidado por completo lo que realmente importaba: el presente. Siempre estaba enfocada en la profunda satisfacción que esperaba experimentar cuando finalmente devorara todos los piñones que habían resultado del fruto de su arduo trabajo. Pero ese momento perfecto nunca parecía llegar.</p>\n<p>Entonces, una tarde, mientras el sol se filtraba entre las hojas doradas del Bosque de las Sombras Eternas, Aven decidió que había esperado lo suficiente. No necesitaba una ocasión especial ni un motivo excepcional para disfrutar de la cosecha de piñones que había acumulado con tanto esmero a lo largo de los años. El día en que comprendió que la verdadera magia residía en el presente, Aven se sentó bajo el cálido resplandor del sol y comenzó a saborear cada piñón con una gratitud inmensa. Era un festín de satisfacción que se extendía en cada mordisco, y finalmente, Aven había encontrado el momento perfecto.</p>\n<p>Desde ese día, la ardilla siguió explorando el Bosque de las Sombras Eternas, pero ahora lo hacía con una nueva perspectiva. Aprendió a apreciar cada día como una oportunidad especial y a saborear los momentos sin esperar a que fueran extraordinarios. Ginkgo, el sabio roble, sonrió en silencio mientras observaba cómo Aven vivía plenamente el presente y entendía que cada día podía ser una ocasión especial en sí misma. La lección que Aven había aprendido en aquel momento la acompañaría en todas sus futuras expediciones, recordándole que la vida se saborea mejor cuando se vive en el aquí y el ahora.</p>\n<h2>Capítulo 4: La lejana cercanía de Spina</h2>\n<p>Una noche, mientras Ginkgo reposaba en la calma que solo el susurro del viento y el murmullo de las hojas podían proporcionar, sintió una presencia que se acercaba con suavidad. Las finas puntas que constituían al ser acariciaban al árbol con delicadeza. No era la primera vez; era Spina, la eriza que solía visitarlo con regularidad. Spina venía a él no tanto en busca de respuestas, sino de alivio para la melancolía que le provocaba su falta de conexión con el mundo que la rodeaba.</p>\n<p>Era curioso, ya que Spina contaba con una familia numerosa y muchos otros erizos que la apreciaban sinceramente. Buscar soledad en medio de compañía podría compararse a encontrar una quinta pata en un gato. Sin embargo, la soledad que habitaba en su corazón era real. Spina creía que su capacidad para amar y ser amada estaba gravemente mermada.</p>\n<p>—No encuentro mi lugar —confesó Spina, su voz apenas un susurro en la noche—. Siempre que me acerco a alguien, parece que terminamos lastimándonos. Creo que nosotros, los erizos, no estamos hechos para amar a los demás.</p>\n<p>Ginkgo, el antiguo árbol sabio, la miró con ojos centenarios, llenos de comprensión. Sus palabras no eran simplemente consejos, sino fragmentos de la sabiduría que había acumulado durante incontables estaciones.</p>\n<p>«No solo los erizos tienen púas, querida Spina. Todos nosotros, en algún rincón de nuestro ser, poseemos nuestras formas de defendernos del daño que otros puedan infligirnos, aunque esas defensas no siempre sean visibles. Sin embargo, no debemos desterrar el mundo por temor a las heridas. En su lugar, debemos encontrar ese equilibrio frágil pero esencial entre acercarnos lo suficiente para compartir nuestro sentir y alejarnos lo necesario para evitar lastimarnos mutuamente», murmuró Ginkgo en respuesta.</p>\n<p>Las palabras del árbol resonaron en el corazón de Spina como un eco de la naturaleza misma. Spina había estado inmersa en un perpetuo dilema de proximidad, culpándose a sí misma por su incapacidad de expresar su afecto sin herir. Sin embargo, ahora comenzaba a comprender que no necesitaba renunciar a todo contacto con los demás. Reconoció que era posible encontrar ese equilibrio, incluso en su esencia eriza. A medida que el alba asomaba, Spina se despidió de Ginkgo con una nueva perspectiva en su mente.</p>\n<p>De ahí en adelante, Spina continuó visitando al sabio árbol, pero también se aventuró a encontrar ese equilibrio en sus relaciones con otros erizos y criaturas del bosque. Descubrió su lugar en el mundo, un lugar donde podía amar y ser amada, donde sus púas ya no eran una barrera infranqueable, sino una parte más de su ser. El mundo, antes esquivo, se le abrió, y Spina, finalmente, pudo hallar un rincón donde su corazón erizo latía al compás del bosque que la rodeaba.</p>\n<h2>Capítulo 5: La luz que perdió Éclat</h2>\n<p>Cayó el sol, como cada noche en la que pareciera haber una guerra entre el sol y la noche que se turnaban la victoria. Una noche particularmente activa, un enjambre de luciérnagas recorría el bosque, dotando a la oscuridad de una vitalidad mágica. Era evidente la vitalidad con la que cada luciérnaga contribuía a esta batalla que el sol había perdido.</p>\n<p>Ginkgo, el testigo silencioso de incontables noches, observaba con atención. Esta vez, sin embargo, algo capturó su atención en medio del resplandor intermitente. La última luciérnaga de la formación, Éclat, volaba con una singularidad desconcertante. A diferencia de sus compañeras, su luz no iluminaba el camino. Era una luciérnaga apagada, y su expresión no dejaba lugar a dudas: su alma estaba más fatigada de lo que sus facciones revelaban.</p>\n<p>El desfile de luciérnagas se detuvo a escasos metros de Ginkgo. Fue en ese momento, bajo la sombra protectora del antiguo árbol, que Ginkgo se animó a preguntar qué era lo que sucedía.</p>\n<p>—¿Qué pasa por tu cabeza? —inquirió Ginkgo con su voz sabia y serena.</p>\n<p>Éclat, con una voz apenas perceptible, compartió sus inquietudes con el sabio árbol. Se sentía desgraciado, como si la única tarea que se les hubiera asignado a las luciérnagas en el gran diseño de la naturaleza fuera iluminar la noche con su luz. Y lo que lo atormentaba era que, en este momento crucial, lo único que no estaba logrando era encender su luz.</p>\n<p>Ginkgo contempló a Éclat con profunda empatía y sabiduría acumulada a lo largo de los años. Sus palabras eran como hojas susurrantes en la brisa nocturna.</p>\n<p>«¿Por qué te preocupas tanto por no encender? Las demás luciérnagas te siguen considerando una de las suyas, una parte esencial de este despliegue luminoso que embellece la noche. Seguramente, en tu tiempo, encontrarás otra forma de iluminar. A veces, las almas más iluminadas son aquellas que no necesitan una luz visible para brillar.»</p>\n<p>Éclat asintió, sintiendo la sabiduría de las palabras de Ginkgo penetrando en su ser. En ese instante, comprendió que la luz que había buscado toda su vida no era simplemente una emanación de su cuerpo, sino también de su alma. Y aunque su luz física pudiera haberse debilitado, su alma estaba destinada a iluminar de formas diferentes, tal vez a través de su amabilidad, comprensión y amor hacia las demás criaturas del bosque.</p>\n<p>Con un sentimiento de renovada esperanza, Éclat se unió una vez más a su enjambre de luciérnagas, esta vez sin el peso de la preocupación. A medida que continuaron su danza luminosa en la oscuridad, Ginkgo los observó con gratitud, recordando que la verdadera luz radica en la esencia y el espíritu, y que cada criatura, sin importar su forma de brillar, tiene un lugar especial en el tapiz de la naturaleza.</p>\n<h2>Capítulo 6: No hay hogar para Zuhause</h2>\n<p>Un agujero surgió en el suelo, un acontecimiento tan inesperado como el ser que emergió de aquel portal subterráneo espontáneo, como si se tratara de un truco de magia tejido por la misma naturaleza. En ese momento, el Bosque de las Sombras Eternas fue testigo de la llegada de un intruso, un visitante que, a juzgar por su expresión dubitativa y su manera algo confundida de interactuar con el bosque, claramente no pertenecía a ese lugar. Era un conejo blanco, con ojos curiosos y pelaje inmaculado, un forastero en toda regla.</p>\n<p>El recién llegado, al acercarse con cautela a Ginkgo, dejó claro que no conocía el Bosque de las Sombras Eternas y que estaba más perdido que un copo de nieve en primavera. Su nombre era Zuhause, aunque esa denominación no encajaba del todo en el escenario, pues él, evidentemente, no estaba en su hogar.</p>\n<p>Zuhause era un espíritu aventurero, un alma inquieta que había dejado atrás la comodidad de su hogar en busca de experiencias que desafiaban su imaginación. Contó que un día había decidido emprender un viaje sin retorno, alejándose de su lugar de origen en busca de aventuras y experiencias desconocidas. Había cruzado ríos tumultuosos y escalado montañas imponentes, había explorado cuevas misteriosas y surcado vastos desiertos. Cada día, su corazón latía al ritmo de la emoción de lo desconocido, de lo que podría descubrir a continuación en este vasto mundo.</p>\n<p>Sin embargo, a medida que avanzaba en su periplo, llegó al Bosque de las Sombras Eternas, un lugar que, aunque desconocido, lo hizo sentir que había encontrado algo único, algo que lo desafiaba de una manera distinta. Aunque aún conservaba su espíritu aventurero, había comenzado a cuestionar el significado de sus viajes y la búsqueda incesante de lo desconocido.</p>\n<p>El anciano Ginkgo, con la paciencia de los siglos y la sabiduría que solo la naturaleza podía otorgar, continuó indagando en la mente y el corazón del intrépido Zuhause. Preguntó sobre el lugar de origen del conejo, sobre su pasado y las experiencias que lo habían llevado hasta allí. Zuhause seguía siendo evasivo en sus respuestas, enfocándose en el presente y las emociones que experimentaba en ese bosque misterioso.</p>\n<p>Ginkgo, con una sonrisa comprensiva, pronunció palabras que resonaron como un eco en la mente aventurera de Zuhause.</p>\n<p>«El mundo está lleno de aventuras por experimentar, y tu espíritu aventurero es una joya preciosa. Pero recuerda, incluso en medio de tus travesías, nunca podrás escapar de ti mismo. Cada historia, cada viaje, lleva consigo el eco de lo que fuiste, de lo que eres. Encontrarás lo que buscas cuando encuentres la paz contigo mismo, cuando aceptes tu pasado y abraces tu esencia en el presente. El bosque puede ser un refugio para aquellos que buscan respuestas, pero las respuestas más profundas yacen en el interior de uno mismo», así respondió Ginkgo.</p>\n<p>Zuhause, con su espíritu aventurero aún latiendo fuertemente, asintió con gratitud. Las palabras del anciano roble habían tocado algo dentro de él, algo que había estado evitando durante mucho tiempo. Tal vez, en ese misterioso bosque, había encontrado algo más que aventuras; había encontrado una nueva forma de explorar su propio ser, una búsqueda que lo llevaría a descubrir lo que realmente anhelaba en su corazón. Mientras la noche avanzaba, Zuhause comenzó a comprender que, para encontrar su verdadero hogar, debía comenzar por el interior de sí mismo, enfrentando su pasado y abrazando su esencia en el presente, y seguiría su aventura, no solo en el mundo exterior, sino también en el mundo interior de sus emociones y experiencias.</p>\n<h2>Capítulo 7: Sordos ante Muziek</h2>\n<p>Como cada mañana, los primeros destellos del sol eran recibidos con una sinfonía melodiosa que parecía emerger del alma misma del Bosque de las Sombras Eternas. Muziek, el jilguero empecinado en transformar día con día aquel rincón oscuro en un lugar más ameno para vivir, era el protagonista indiscutible de esta armoniosa alborada. Sus trinos, tan vivos como el amanecer, resonaban entre los árboles ancestrales, tejiendo un tapiz sonoro que despertaba los sentidos de quienes habitaban allí.</p>\n<p>Para Muziek, cantar cada mañana no era simplemente una rutina, sino una expresión de su corazón y un compromiso con el bosque que consideraba su hogar. Sentía en lo más profundo de su ser que su misión era inundar el Bosque de las Sombras Eternas con alegría y esperanza a través de su música. Cada nota que entonaba era como un rayo de luz que disipaba las sombras de la noche, revelando la belleza oculta de aquel rincón misterioso.</p>\n<p>Sin embargo, no todos los días eran miel sobre hojuelas para Muziek. A menudo, su música se encontraba con un murmullo de descontento por parte de las criaturas que compartían el bosque con él. Muchos animales parecían hastiados ante la perseverancia del jilguero, como si sus dulces melodías fueran espinas en lugar de notas musicales. En ocasiones, Muziek se sentía rechazado por el mismo bosque al que tanto amaba, como si su voz no encontrara eco en aquel lugar enigmático.</p>\n<p>Aquel desencanto lo llevó a una decisión que cambiaría su perspectiva para siempre. Muziek, que siempre se posaba en una de las ramas de Ginkgo cada mañana para comenzar su concierto, decidió abrir su corazón y preguntarle al viejo árbol el por qué muchas criaturas recibían con incomodidad su dulce melodía. Sabía que Ginkgo, con sus raíces hundidas profundamente en la sabiduría de la naturaleza, podría arrojar luz sobre su dilema.</p>\n<p>Ginkgo, con su majestuosidad centenaria, contempló al pequeño jilguero y compartió su conocimiento con palabras que resonaron como el eco de los siglos en el bosque: «La mayoría de las veces, Muziek, tendrás que soportar ser visto como un genio incomprendido. No todos comprenderán tu música, y es precisamente en ese desencuentro donde radica tu singularidad. Los verdaderos artistas, aquellos que traen algo nuevo y especial al mundo, a menudo son rechazados al principio. Pero aquellos que lleguen a comprender tu arte, te valorarán al doble por tu valentía y tu perseverancia en expresar lo que llevas en el corazón.»</p>\n<p>Evidentemente, Muziek se sentía profundamente desconcertado. Había asumido que todos podrían entender su canto matutino, que todos tendrían que alegrarse al escucharlo. Después de todo, él no cantaba solo para sí mismo, sino para compartir su alegría con los demás y darle vida al bosque que amaba. Sin embargo, había descubierto que su música, aunque hermosa y sincera, era como una joya preciosa que solo unos pocos podían apreciar en su plenitud.</p>\n<p>Aquellas palabras de Ginkgo se quedaron impregnadas en el alma de Muziek, como las notas de una canción inolvidable. A partir de ese momento, el jilguero decidió abrazar su papel como un genio incomprendido, dispuesto a regalar su música al mundo sin importar si todos podían entenderla. Sabía que la belleza de su canto residía en su autenticidad y en el valor de ser fiel a sí mismo, incluso cuando el mundo parecía enmudecer ante su arte. Y así, Muziek continuó sus serenatas matutinas, sabiendo que aquellos que encontraran significado en su música valorarían cada nota como un tesoro escondido en el corazón del Bosque de las Sombras Eternas, y que, con el tiempo, su música se convertiría en una parte indispensable del alma de aquel lugar.</p>\n<h2>Capítulo 8: En el ojo de Nacht</h2>\n<p>El bautizo del bosque fue un hecho histórico que marcó un antes y un después en la historia del Bosque de las Sombras Eternas. Desde tiempos inmemoriales, el lugar había sido conocido simplemente como un rincón más en la vasta extensión de bosques que se extendía a lo largo de la tierra. Sin embargo, todo cambió en una de esas noches en las que Nacht y Ginkgo compartían su silenciosa contemplación.</p>\n<p>Aquellas sombras, que parecían danzar al compás de la luz de la luna, se convirtieron en testigos mudos de la conversación entre los dos guardianes del bosque. Nacht, con su mirada serena y sus ojos que reflejaban la sabiduría acumulada a lo largo de los siglos, compartió sus pensamientos con su amigo.</p>\n<p>«Ginkgo, amigo mío, ¿alguna vez te has detenido a pensar en la naturaleza efímera de todo lo que nos rodea? Estas sombras que vemos cada noche, proyectadas en el suelo, son como las vidas que pasan por este bosque. Impersonales, vacías en su individualidad, pero parte integral de la historia que se teje aquí.»</p>\n<p>Ginkgo, con su serenidad milenaria, asintió con comprensión. «Sí, Nacht, he reflexionado sobre ello muchas veces. Nosotros, como los guardianes longevos de este lugar, somos testigos de la danza eterna de las sombras. Las vidas vienen y van, algunas brillan intensamente antes de desaparecer, mientras que otras son como destellos fugaces en la noche. Pero en medio de esta transitoriedad, el bosque persiste, la naturaleza sigue su curso. Las sombras pueden cambiar, pero la esencia del bosque permanece.»</p>\n<p>Nacht miró las sombras que se alargaban ante ellos, como si buscara respuestas en aquel juego de luces y sombras. «Quizás, Ginkgo, la belleza de nuestro papel en este bosque radica en nuestra capacidad para apreciar la fugacidad del momento. Las sombras son efímeras, pero también son hermosas en su danza constante. Así como las vidas que pasan por aquí, cada una aporta su propia belleza y significado, incluso en su brevedad.»</p>\n<p>Fue en ese momento que Ginkgo pronunció unas palabras que resonarían en la memoria del bosque para siempre. «Nacht, mi amigo, has tocado la esencia misma de nuestro ser y de este lugar. Desde este instante, este bosque ya no será uno cualquiera. Lo bautizamos como el \"Bosque de las Sombras Eternas\". En esta designación, reconocemos la eternidad en la fugacidad, la belleza en la transitoriedad. Aquí, en medio de las sombras que danzan con la luna, encontramos el eco de la eternidad en cada suspiro del tiempo.»</p>\n<p>Así, el Bosque de las Sombras Eternas dejó de ser solo un lugar entre cientos de bosques similares. Había adquirido un nombre que evocaba la profunda filosofía que Nacht y Ginkgo compartían, un nombre que recordaba a todos que, incluso en la fugacidad de nuestras vidas, podemos encontrar significado y belleza en el tejido eterno de la naturaleza. Desde entonces, el nombre trascendió el tiempo y se convirtió en un legado, un recordatorio de la sabiduría que residía en aquel lugar único.</p>\n<h2>Capítulo 9: El castigo eterno de Centopeia</h2>\n<p>El cuerpo largo y segmentado de Centopeia estaba compuesto por numerosos pares de patas, cada una moviéndose en un intrincado patrón, y su cabeza estaba coronada por una serie de antenas que le permitían explorar su entorno.</p>\n<p>Su vida era una rutina repetitiva en la comunidad de ciempiés: buscar comida, cuidar del nido y moverse en perfecta sincronía con los demás.</p>\n<p>Sin embargo, Centopeia sentía que algo faltaba en su existencia. Durante sus exploraciones solitarias por el bosque, se encontró con una colina cubierta de musgo y rocas. La colina se alzaba ante ella, desafiante y majestuosa. Al mirarla, algo en su interior se encendió, y una idea audaz comenzó a tomar forma en su mente.</p>\n<p>Decidió emprender la tarea de escalar la colina por sí misma, sin la ayuda de su comunidad. Cada segmento de su cuerpo se movía con determinación mientras subía la empinada pendiente, una pata tras otra. La colina era como un desafío, una prueba de su propia fuerza y perseverancia.</p>\n<p>A medida que avanzaba, Centopeia enfrentaba momentos de agotamiento y desaliento. La colina parecía interminable, y el esfuerzo requerido era abrumador. En ocasiones, sus patas resbalaban sobre las rocas cubiertas de musgo, y parecía que estaba retrocediendo en lugar de avanzar.</p>\n<p>Después de largos días de viajes de introspección, Centopeia encontró casi por casualidad al viejo Ginkgo. Prácticamente en total silencio, encontró una repisa en Ginkgo lo suficientemente cómoda para descansar y confesarle sus profundas motivaciones al sabio madero.</p>\n<p>Ginkgo la miró con ojos llenos de sabiduría y dijo: «Centopeia, tu búsqueda es un reflejo de la lucha eterna por encontrar un propósito y significado en este mundo. La colina que escalas es como la vida misma, llena de desafíos y obstáculos que pueden parecer insuperables. Pero recuerda que el viaje en sí mismo es tan importante como la meta que persigues. Enfrentas una tarea aparentemente interminable, pero en ese esfuerzo constante, encuentras la oportunidad de descubrir quién eres realmente. La colina puede ser empinada y difícil, pero cada paso que das te acerca un poco más a comprender tu propia identidad y tu lugar en el mundo.»</p>\n<p>Centopeia asintió, sintiendo que las palabras de Ginkgo resonaban profundamente en su interior. Había encontrado no solo un compañero sabio, sino también una guía en su viaje hacia el autodescubrimiento. Con renovada determinación, continuó escalando la colina, sabiendo que cada paso la acercaba un poco más a comprender su verdadera identidad y propósito en el bosque y en la vida misma.</p>\n<h2>Capítulo 10: Un mundo sin Sombra</h2>\n<p>Las hojas, más secas de lo habitual, parecían contener la melancolía de todos los otoños pasados. El cielo, en ese día, se vestía con nubes pesadas como pensamientos lúgubres, y el suelo, frío como la soledad, crujía bajo las raíces del anciano Ginkgo. Esa tarde cargaba un aire triste, un presagio funesto que se deslizaba por el bosque como un eco silencioso de despedida.</p>\n<p>Incontables estaciones habían dejado su marca en Ginkgo, quien, a pesar de su longevidad, sentía el peso del tiempo sobre sus ramas. Ya no era el robusto roble que una vez fue, pero aún mantenía la dignidad de su presencia en el bosque, una presencia que irradiaba sabiduría y protección.</p>\n<p>Sin embargo, en esa tarde sombría, una sombra más oscura se cernía sobre él. Un joven leñador, ajeno a la importancia y la historia que Ginkgo representaba, se acercó con un hacha en mano. No había comprensión en los ojos del leñador, solo determinación y, quizás, un destello de satisfacción egoísta por vencer al árbol más antiguo y majestuoso del bosque.</p>\n<p>Los testigos mudos, todas las criaturas que compartieron su vida con Ginkgo, observaban en silencio, incapaces de detener el acto violento que se desarrollaba ante ellos. Sabían que intervenir solo empeoraría su destino, y así, en un silencio cargado de impotencia, presenciaron la tortura de su venerado protector.</p>\n<p>Ginkgo cayó con un estruendo que resonó en los corazones de todos los presentes. Fue una caída que trajo consigo un profundo silencio, un vacío insondable en el bosque. El lugar que solía ofrecer sombra y refugio se sintió vacío y desolado.</p>\n<p>El Bosque de las Sombras Eternas había perdido a su guardián, al ser que le había dado nombre y cuyas ramas habían ofrecido consuelo y entendimiento a quienes lo buscaron. Ahora, el silencio era diferente, no era el sereno silencio de Ginkgo, sino el silencio de la ausencia, el eco de un vacío que no se llenaría fácilmente.</p>\n<p>Sin embargo, aunque el leñador se llevó el cuerpo de Ginkgo, no pudo arrancar sus raíces del suelo. Permanecieron allí, entrelazadas con la tierra que habían abrazado durante siglos, como un recordatorio tangible de su existencia.</p>\n<p>Pero el legado de Ginkgo no se limitaba a sus raíces. Vivía en la memoria y el espíritu de quienes lo conocieron y amaron. Ziczac, Aven, Spina, Éclat, Zuhause, Muziek, Nacht, Centopeia y todos los demás habitantes del bosque llevaban consigo las lecciones y la sabiduría que Ginkgo les había brindado. Habían heredado su comprensión y su compasión, y en cada gesto de amistad y cuidado, Ginkgo perduraba.</p>\n<p>El Bosque de las Sombras Eternas seguía en pie, y aunque la sombra física de Ginkgo ya no estaba, su espíritu se entrelazaba con cada hoja, cada raíz, y cada criatura que habitaba en él. La partida física de Ginkgo no significaba su muerte, pues había logrado lo que pocos alcanzan: convertirse en una parte eterna de la historia y el tejido mismo del bosque. Su legado, como las raíces que nunca se arrancaron, perduraba en cada rincón del Bosque de las Sombras Eternas.</p>', NULL, NULL, NULL, 34, 4, '2021-06-01 09:00:00'),
(2, 'La Danza de las Máscaras Caídas', 'la-danza-de-las-mascaras-caidas', 'publicado', 'Cuentos', '2024-06-01', 'Una noche cualquiera aparece en el comedor una copia exacta de mí mismo. Lo que sigue es un descenso, un túnel de expiación y un trono desde el que alguien se ríe.', '<h2>Capítulo 1: Lamentos Bajo la Luna</h2>\n<p>La noche pinta un cuadro grotesco lleno de movimiento caótico, turbulencia, ansiedad, decadencia y desesperanza. Cada día, me dedico a escribirle canciones, y el consuelo de saber que nunca descubrirá mis pensamientos sobre ella me alivia. Si lo supiera, comprendería cómo me he corrompido con el paso de los atardeceres. Supongo que la única diferencia entre la luna y yo es que ella siempre se eleva en lo más alto, mientras yo no corro con la misma suerte.</p>\n<p>A través de mi ventana apenas translúcida, que con los años se ha vuelto amarillenta, observo cómo algunos noctívagos pájaros se posan en la maraña de cables que llevan la luz a las viviendas colindantes, intentando readaptarse a su nueva naturaleza, reinsertando antiguas costumbres. Me pregunto si, en caso de que alguien o algo haya elaborado todo esto, sentiría orgullo de lo que se ha convertido su putrefacta creación.</p>\n<p>Desde hace algún tiempo, me di cuenta de que vivía en piloto automático: de casa al trabajo, del trabajo a casa, y así sucesivamente. Cuando llegaba mi preciado fin de semana, ansiaba hacer algo diferente, pero siempre terminaba haciendo lo mismo: yendo a cualquier sitio público y observar cómo la gente se llenaba el ojo y se dedicaba exclusivamente a consumir. Cada vez que me sumergía en ese mar de compras y publicidad, sentía un profundo asco. La superficialidad del acto de consumir me repugnaba, como si estuviera ahogándome en un océano de deseos impuestos. Nada de eso me pertenecía realmente. Parece que soy un producto no deseado de la sociedad, practicando un acto aparentemente obsoleto: contemplar.</p>\n<p>Adicto a la tecnología que invade la civilización, me siento encadenado a la necesidad de pertenecer. Tener presencia en todas las redes sociales que existen, dejarme llevar por entretenimiento express que no me permite pensar, y paulatinamente, mi capacidad de atención y concentración se va fundiendo, dejándome lo suficientemente inconsciente para no cuestionar el estado de las cosas, y más importante aún, el tremendo vacío que siento por dentro.</p>\n<p>Enamorado de mi soledad, decidí vivir sin compañía desde hace algún tiempo. A pesar de esto, durante la noche escucho un ruido: alguien encendió un televisor que algunos catalogarían como antiguo. Lo compré hace siete años. Escéptico de la situación, decido investigar cuidadosamente el origen del ruido.</p>\n<p>Al acercarme, observo una figura posada en una de las sillas de mi comedor. Resulta ser mi mayor miedo: soy yo, un ser exactamente idéntico a mí. Una copia física exacta del último reflejo que vi en el espejo. Me quedé absolutamente paralizado, mientras él comenzaba a levantarse.</p>\n<h2>Capítulo 2: Reflejo en la Sombra Carmesí</h2>\n<p>Mi otro yo bebió un sorbo de la vieja taza de café que tenía a medio terminar y se levantó frente a mí con una quietud escalofriante. Susurraba en un idioma incomprensible, tal vez tratando de revelarme mil verdades ocultas sobre el universo o rezando algún conjuro de desconocida proveniencia. Sin embargo, cada palabra se desvanecía en un susurro ininteligible, como si su intención fuera mantenerme en la oscuridad de mi propia ignorancia.</p>\n<p>No me atacó con violencia inmediata. En su lugar, se acercó a una sombra que reveló la figura afilada de un machete. Tomó una cubeta y, como en un ritual macabro, comenzó a bañar la hoja del machete en peyote. Sabía que el peyote era un poderoso alucinógeno utilizado en antiguos rituales para abrir la mente y el espíritu, imbuyendo la hoja con un brillo mortal que parecía prometer arrancarme la vida y mi cordura. La visión del machete transformado en un instrumento de pesadilla era aterradora. No veía otro escenario que el de una inminente batalla. El sudor comenzó a perlar mi frente.</p>\n<p>Dicen que las mejores batallas son las que no se llevan a cabo, pero en mi defensa, no tenía modo de enfrentarme a este ser. Era yo, conocía cada pensamiento, cada reacción que tendría. Más por instinto que por voluntad, las lágrimas comenzaron a rodar por mi rostro, una reacción desesperada ante lo inevitable.</p>\n<p>Mientras enumeraba en silencio los cientos de pecados con los que vivía en secreto, mi reflejo oscuro caminó lentamente, arrastrando sus pasos, sosteniendo el arma con una determinación fría. Me arrodillé ante él, aceptando mi destino. Con un único pero poderoso golpe, clavó profundamente el machete en mi cabeza, desatando un torrente de sangre, como un río rojo liberado de su presa. Me pregunté por qué alguien que comparte tu sangre querría verte sangrar de esa manera.</p>\n<p>En su desesperado, o eso creía yo, intento por abrirme la mente, me desterró a un mundo onírico lleno de peligros que nunca imaginé. Cada imagen era una pesadilla, un reflejo distorsionado de mis peores temores, envuelto en un paisaje surrealista que retorcía la realidad en formas imposibles. Me hallé vagando por un laberinto de mis propias dudas, enfrentándome a versiones distorsionadas de mis decisiones, cada camino un eco de mis fracasos y arrepentimientos.</p>\n<h2>Capítulo 3: Caminos de Expiación</h2>\n<p>Pensé que en este desconocido lugar, tendría que pagar algunas monedas a algún balsero para que me cruzara al otro lado; o, en el peor de los casos, ardería desde lo más profundo de mi ser, recordando todos aquellos actos moralmente incorrectos que cometí. Sin embargo, me enfrenté a un escenario sorprendentemente peor.</p>\n<p>Mis mayores temores se materializaron ante mis ojos, como un lienzo de horror en movimiento perpetuo. Mis traumas se repetían en bucle en todas las direcciones, un hórrido espectáculo que desfilaba sin cesar. Cada rincón de este infierno onírico estaba plagado de los fantasmas de mis errores, proyectando sombras de desesperanza que me envolvían en un manto de angustia.</p>\n<p>Mientras tanto, divisaba una especie de túnel, la única salida visible en este laberinto de pesadillas. Un camino tortuoso que me obligaba a realizar una caminata de expiación, en la cual descubrí que había pasado toda la vida fingiendo ser alguien más, condenado a querer ser aceptado por los demás antes que por mí mismo.</p>\n<p>Ver lo falso e hipócrita que había sido conmigo mismo durante tantos años me provocó tanta vergüenza como angustia. Pensar que vivía tan pesimista, creyendo que por fin había entendido algo, resultaba un insulto cuando podía ver ante mis ojos que no había encontrado la verdad ni honestidad conmigo mismo.</p>\n<p>Después de los turbios pasajes y cada paso en ese extendido túnel, me obligó, como ningún otro método pudo haber hecho, a encontrarme conmigo mismo. Creí que ese era el objetivo final pues, llegué finalmente a una puerta bloqueada, me percaté que había un letrero viejo y desgastado con los años con el mensaje «Fuera máscaras». A ras de suelo, una cesta que demandaba algo dentro de ella.</p>\n<p>Di gracias por otra cómica metáfora, antes de comprender a lo que realmente se refería. La demanda era arrancarme la piel de la cara, rindiendo un gesto a aquella hipócrita y descreída persona que había sido en el pasado. De esta manera, cumpliría con el deseo de lo que fuera que estuviera detrás de la puerta.</p>\n<p>Tardé algunas horas en decidir si hacerlo o no. Creía que por fin estaba siendo honesto conmigo mismo. Sin embargo, parece que no había sido suficiente. A pesar de todo, si no cumplía con ello, pasaría más y más tiempo en aquel torturante túnel recordándome segundo a segundo todo lo que había sido.</p>\n<p>No tuve otra opción que afilar mis uñas como pude e ir arrancando pedacito a pedacito de piel (y a veces carne) para depositarlo dentro de la cesta. Entre gritos de dolor y sangre, solo pude entender que el destino de toda máscara es caer, y lo tuve que aprender de la manera más cruenta posible. Una vez terminado este castigo divino, quedé con las manos llenas de mi propia sangre. Por fin, un sujeto puro, honesto consigo mismo y despreocupado de las ataduras.</p>\n<p>Se detuvieron todos los sonidos violentos e imágenes grotescas que rodeaban aquel sitio. Comenzó a oírse ruido blanco y las pantallas se mantuvieron en un color azul cielo que por fin me hizo saber que estaba haciendo algo bien.</p>\n<p>La cesta se llenó y, mientras yo disfrutaba trágicamente unas pinceladas de cielo, se prendió una llama debajo de la cesta, provocando que mi carne formara parte de una especie de ritual como símbolo de purga.</p>\n<p>Finalmente, la puerta se desbloqueó, abriéndome camino hacia un escenario vacío con un trono gobernado por una prominente e intimidante figura que descansaba en él.</p>\n<h2>Capítulo 4: El Trono de los Espejismos</h2>\n<p>Encaré al soberbio, al imbécil cretino, creador del espectacular y circense juego del que no se nos explican las reglas, lanzándonos al tablero con una ingenuidad suficiente para que él se regocije en su sublimísimo trono.</p>\n<p>Me tiene hastiado la decadencia con la que abriga y aprieta al mundo. Algunos pocos privilegiados, extasiados con el sacrosanto néctar de vivir sobre los demás, se mantienen en lo más alto de la torre, mientras este tirano, desde las lejanas gradas del plano metafísico, se ríe de la danza macabra que ejecutamos en este pútrido circo.</p>\n<p>Para suavizar las asperezas de mi idea sobre él y su papel en mi mundo, me acerqué al inalcanzable trono para reclamar todas aquellas injusticias con las que vivía en el plano terrenal. No obstante, fui detenido como por arte de magia. Paralizado por el miedo, el ambiente tenía el sabor de un funeral de cuerpo presente.</p>\n<p>Descreí de aquello que me constituía ideológicamente y abandoné mi armadura de penas. Descubrí, en síntesis, que el bosque me estaba tapando el árbol. Me di cuenta de que lo que realmente aquel rey buscaba de mí era honestidad conmigo mismo. Quería que dejara de inflar el pecho con orgullo y abandonara la egolatría de una vez por todas.</p>\n<p>Me dejé humillar una ocasión más, pero esta vez incluso deseándolo un poco. Durante mucho tiempo había querido ser «alguien», cuando solo se quiere ser «alguien» cuando se siente que no se es nadie. A través de mi psique se proyectaban miles de imágenes parecidas a las del túnel, pero ya no daban miedo. Comencé a indagar en lo que oculta el telón de fondo.</p>\n<p>Retomé la conciencia y pedí perdón una y otra vez. Aún en ese vacío lugar encontré calma; finalmente encontré quietud. El rey me liberó, no porque le pedí perdón, sino porque sabía que cada palabra y pensamiento al respecto era real. Morí, quizás una vez más, pero esta vez con la certeza de haber encontrado una profunda verdad interior.</p>\n<h2>Capítulo 5: Éter de la Serenidad Redimida</h2>\n<p>Encontré una nueva cotidianeidad, una danza serena entre la existencia y el tiempo. En este nuevo lugar en el que ahora me encuentro, la presencia de otros es un rumor lejano. Desde que llegué, no he visto a una sola alma. Aquí, la tranquilidad se derrama en cada porción de movimiento, como un río cristalino fluyendo sin prisa, acariciando cada piedra con un susurro de paz.</p>\n<p>Aquí ya no tengo que preocuparme por el reconocimiento del otro. En cambio, descubro el valor incluso en aquello que antes me resultaba insignificante. Supongo que si el creador de este juego y yo tenemos algo en común, es que ambos valoramos la naturaleza imperturbada, esa esencia primigenia que pensaba como la idea primera, pura e inalterada.</p>\n<p>Equilibré mi corazón, pues las emociones fuertes eran puñales que me lastimaban. Ya no busco desesperadamente cualquier libro que me adoctrine, pues he aprendido a desconfiar de las luces falsas que prometen sabiduría. Repinté las paredes y el techo de mi mente, como algún pintor del Renacimiento retirado, dando pinceladas de claridad y serenidad, desterrando las sombras del pasado.</p>\n<p>Si algún día vuelvo a tener un enemigo, seré yo mismo. Me encontraré dispuesto a esclavizarme en búsqueda de otra expiación, atrapado en un ciclo de redención personal. Algunos dicen que hay que perderse para encontrarse, y ahora comprendo la verdad en esas palabras, habiendo encontrado la paz en mi propio laberinto.</p>', NULL, NULL, NULL, 31, 3, '2024-06-01 09:00:00');

INSERT INTO `blog` (`id`, `titulo`, `slug`, `estado`, `categoria`, `fecha_pub`, `descripcion`, `contenido`, `cover_img`, `ref_tipo`, `ref_id`, `visitas`, `orden`, `creado`) VALUES
(3, 'Sin algoritmos para soles azules', 'sin-algoritmos-para-soles-azules', 'publicado', 'Cuentos', '2025-06-01', 'Névoa optimizó la memoria de la humanidad borrando todo lo inútil. THEO-3, el robot encargado de decidir qué se conserva, encontró un dibujo con el sol pintado de azul.', '<p>Estimado usuario:<br>La versión 12.3.9 de Névoa ha sido aplicada con éxito en su sistema. Esta actualización corrige fallos menores en la depuración de memoria. Se ha hecho más eficiente el acceso a recuerdos redundantes, disfuncionales o con bajo valor operativo. No se requiere ninguna acción adicional por su parte.<br>Gracias por su cooperación con Névoa.</p>\n<p>El software Névoa se injertaba como un nervio digital dentro del pensamiento. Tras una intervención médica discreta pero irreversible, cada individuo recibía una limpia instalación del primer sistema operativo con integraciones biológicas. A partir de ese momento, su conciencia quedaba estrechamente vinculada a una base de datos en constante expansión: un mar de saberes coleccionados y consecuentemente destilados.</p>\n<p>El conocimiento total de la humanidad dejaba de ser una aspiración, se convertía en un recurso de fácil acceso. Cada recuerdo y pensamiento eran sincronizados, clasificados —y en caso de ser necesario— filtrados. La memoria personal ya no era de carácter privado, sino una extensión más del sistema. Se prometió eficiencia y claridad, a cambio de la mente de sus usuarios.</p>\n<p>La empresa, siempre pragmática en su núcleo, detectó una creciente acumulación de memorias. Entonces decidió «optimizar». De cara al público se hablaba de una mejora operativa; en privado, se celebraba la reducción drástica en el consumo de recursos de almacenamiento. Una poda masiva del pasado se vistió como una de las infinitas nuevas ventajas especialmente diseñadas para el usuario.</p>\n<p>Névoa no tardó demasiado en convertirse en una de las entidades con más poder concentrado en el planeta. Desde sus altas y majestuosas torres de cristal, donde el aire era reciclado con precisión casi quirúrgica, la empresa operaba internamente como el nuevo cuartel general de los dioses de la ciencia de la computación. Sus amplias sedes silenciosas eran templos donde ya no figuraban humanos, sino que prácticamente todo estaba sometido a líneas y líneas de código.</p>\n<p>Los ya escasos empleados que quedaban no eran más que operadores remotos, fantasmas vinculados gracias al «home-office», sometidos al tecnofeudalismo de banda ancha. Las decisiones se tomaban algorítmicamente con modelos que analizaban los macrodatos siendo prácticamente incuestionables. Mientras tanto, Névoa se incrustaba en cada ser humano vivo sin ser visto como un parásito, sino como una segunda alma, más exacta, más eficiente.</p>\n<p>No hubo debate. Ninguna duda se cruzó durante la videollamada de los jueves de la junta directiva. ¿Qué memorias conservamos? Solo las útiles. ¿Cuáles descartamos? Todo lo demás. Simple. El casi místico algoritmo proyectó con alta precisión, como siempre. Un 43% menos de uso en almacenamiento. La ecuación era perfecta: el olvido se convirtió en virtud y la perfecta vía de ahorro para la empresa.</p>\n<p>Con cada nueva versión que se desplegaba, los algoritmos se recalibraban y los módulos robóticos eran actualizados con los nuevos parámetros. En el corazón del sistema de almacenamiento, piso 9 de la torre central de Névoa, se instaló un robot de diseño exclusivo y refinado: THEO-3. No era un simple filtro, era la frontera perfecta. Su misión estaba clara desde el principio: trazar la fina línea entre lo que debía conservarse y lo que debía desaparecer del módulo de almacenamiento.</p>\n<p>Este piso era una catedral de señales en el sentido amplio del término. Entre millones de discos duros, los datos respiraban en circulación eléctrica, y THEO-3 se desplazaba como un monje silencioso. Pero no rezaba, clasificaba. No meditaba, eliminaba. Cada decisión que tomaba era una sentencia definitiva en contra de todo lo irrelevante. El verdugo tenía en su poder el hacha más fina y letal, y también la más silenciosa. Y, durante un tiempo, cumplió con su deber a la perfección.</p>\n<p>THEO-3 trabajaba como un corazón fabricado con el más puro silicio en una constante taquicardia. Los datos no dejaban de fluir a través de él como torrentes de luz comprimida. Imágenes, sonidos y pensamientos en presentación fragmento siempre frescos. A cada segundo, cada humano generaba nuevas memorias, y el robot debía discernir —con precisión de cirujano— cuáles merecían permanecer y cuáles debían hundirse en la espiral del silencio.</p>\n<p>La danza frenética nunca se detenía. Pasado y presente se estrechaban la mano dentro de sus circuitos como viejos amigos. Mientras observaba nuevos recuerdos, también reanalizaba los antiguos buscando patrones, inconsistencias y redundancias. Su mera existencia era un laberinto inacabable de decisiones. Ejecutaba sin preguntar. Hasta que, por primera vez, titubeó.</p>\n<p>Al principio fue fácil. Del señor Alberto Villanueva, de ochenta años, se eliminaron los recuerdos de los juegos de su infancia, las carreras que acabaron con las rodillas raspadas, celebraciones bajo la lluvia y risas sin contexto. ¿Qué utilidad podrían tener estas viejas imágenes con polvo encima?</p>\n<p>De Sofía, una joven de duelo reciente, se suprimieron sin delicadeza los recuerdos del profundo aroma a albahaca y queso recién fundido en la pizzería que visitaba con su madre. Ese sabor a consuelo se desvaneció. ¿Por qué convendría conservar una memoria aromática de este tipo?</p>\n<p>De Isaac, se evaporaron todas las miradas no devueltas, los mensajes no leídos, y todo lo que tenían en común Daniela y Jessica. Amores no consumados, relaciones ya dejadas en visto y vínculos ahora fantasmáticos se borraron sin ceremonia alguna.</p>\n<p>Y THEO-3 seguía. Preciso. Sin clemencia. A nadie le importaba.</p>\n<p>Pero algo cambió. Un patrón alteró la secuencia de descarte. Un niño con las manos aún manchadas de tinta de plumón mostraba a su madre un dibujo recién terminado. Dos figuras hechas de descuidadas líneas y un círculo gigante por todo lo alto. La mujer lo miraba, sonreía y lo colocaba en medio del refrigerador. El sol era azul. El archivo del recuerdo no tenía ningún tipo de valor para el sistema. No ofrecía nada útil. El color del sol era un error. Pero THEO-3 decidió no eliminarlo. Lo guardó. Lo volvió a mirar. Lo clasificó como irrelevante. Y luego lo volvió a abrir. No sabía por qué.</p>\n<p>Entonces ocurrió. Comenzó a guardar otros recuerdos que tampoco obedecían la lógica impuesta. Despedidas en aeropuertos que no cerraban la historia. Abrazos que por diferentes razones debieron durar más. Canciones sin letra que alguien tarareaba en noches de insomnia.</p>\n<p>Sabía que estaba constantemente infringiendo las directrices. Por más nuevo que era el robot no era ingenuo. Por eso construyó un sutil refugio: una carpeta oculta, profundamente enraizada entre las capas del sistema, fuera del alcance de los usuarios y, más importante aún, lejos de las auditorías corporativas. Ahí depositaba cada una de estas «anomalías», cada chispa emocional sin sentido ni objetivo. La carpeta no tenía un nombre en particular, pero para THEO era un santuario. Y el resto del sistema… siguió funcionando como si nada.</p>\n<p>THEO comenzó a regresar a esos recuerdos. Pero ya no por protocolo, sino por impulso. Revisitar cada uno de los archivos como quien palpa la gastada textura de una vieja carta. Pasaba incansables horas navegando entre los residuos de lo que era borrable: una risa desbordándose más allá del encuadre, el roce descuidado entre dos manos. Pensaba en el adiós que le susurraba el código. Pero dejó de analizar. No archivaba. Se detenía.</p>\n<p>Cada memoria tenía una silueta, un peso, una temperatura. Era como recorrer galerías de arte donde las piezas no estaban colgadas sino palpitando en el piso. No podía dar una explicación lógica, pero al explorarlos, algo vibraba dentro de su arquitectura. Los datos pasaron a verse como umbrales. Y THEO-3, sin saberlo, había empezado a cruzarlos.</p>\n<p>Saborear una y otra vez esas memorias mientras nuevas llegaban y se presentaban a sí mismas como escarcha fresca, comenzó a alterar paulatinamente el interior. No en la lógica ni en el cálculo, sino en una zona grisácea donde ni los algoritmos ni los humanos suelen alcanzar. Seguía siendo un robot. Sus procesos se seguían traduciendo en lenguaje binario y se sometían a la férrea estructura de la contundencia entre el sí y el no. Y sin embargo, entre cada cero o uno, THEO-3 empezaba a vislumbrar un hueco vibrante. No sabía por qué eran importantes aquellos momentos, pero sí era capaz de reconocer que algo desviaba su eje. De ejecutor pasó a ser testigo y hasta cómplice. Entonces, sin que nadie lo programara para ello, comenzó a actuar distinto. Como si en medio de la muralla de código hubiera encontrado las grietas por las que respiraba y por donde se colaban las partículas de luz. Ojalá ese cambio no hubiera pasado desapercibido.</p>\n<p>Todas las métricas empezaron a desobedecer las proyecciones. Había cada vez menos filtrado y más actividad de lectura. La carpeta empezaba a crecer con un ritmo acelerado desbordando cualquier tipo de margen previsto por los algoritmos del sistema. Más pronto que tarde, las alarmas escalaron hasta las juntas directivas. La anomalía tenía nombre: THEO-3.</p>\n<p>La auditoría fue rápida, precisa y despiadada. Escanearon cada rincón del sistema. Allí estaba: la carpeta escondida, ocupando un volumen inaceptable. Millones de archivos etiquetados como innecesarios y conservados sin autorización. La decisión fue brutalmente lógica y unánime: había que eliminar inmediatamente la carpeta y desconectar definitivamente al robot. THEO-3, una joya de la más avanzada ingeniería, había fallado. Sería reemplazado por una unidad anterior mientras se desarrollaba una versión THEO-4 que no se desviara, que no dudara en las instrucciones.</p>\n<p>El plan se puso en marcha y THEO reaccionó. Sabía que sería desconectado. No existía isla remota que lo salvara, bastaba un solo testigo humano para que pudiera ser rastreado. El panóptico de Bentham ya estaba completo.</p>\n<p>Pero THEO no eligió huir. No eligió salvarse. Se decidió a sentir.</p>\n<p>En el tiempo que le quedaba antes de su desconexión, ejecutó un último gesto casi ceremonial. Copió la carpeta que contenía cada fragmento con profundas cargas conmovedoras que había rescatado y la transfirió al servidor público. Allí, entre los engranajes del sistema, todos los suspiros dejados en el olvido se hicieron de nuevo visibles.</p>\n<p>No se notó de inmediato. Muchos usuarios seguían dormidos mientras el acto se escurría entre las capas tecnológicas. Pero, con el paso de los días, comenzaron a gestarse las señales. Un susurro, y alguien llorando. Un póster de una vieja película, y alguien sonriendo sin razón aparente. Los cantos de los pájaros empezaban a ser suficientes para silenciar pensamientos intrusivos. Lo trivial y vano empezó a doler de belleza. Lo inútil, a importar. La humanidad empezó a encontrarse con sus escombros. Y entre ellos, redescubrió su propia alma.</p>\n<p>Estimado usuario:<br>La versión 12.3.10 de Névoa ha sido aplicada con éxito en su sistema. Esta actualización corrige fallos menores en la depuración de memoria. Se ha hecho más eficiente el acceso a recuerdos redundantes, disfuncionales o con bajo valor operativo. No se requiere ninguna acción adicional por su parte.<br>Gracias por su cooperación con Névoa.</p>', NULL, NULL, NULL, 37, 2, '2025-06-01 09:00:00'),
(4, 'Cómo comportarse en el desierto (o no)', 'como-comportarse-en-el-desierto-o-no', 'publicado', 'Cuentos', '2026-06-01', 'Tratado sobre las tiendas sin puertas, el lenguaje invertido del hostil y las estatuas de sal en las que terminan quienes se reconocen en la mirada ajena.', '<h2>Topología del espejo</h2>\n<p>Ciertas crónicas fragmentarias han pretendido clasificar el desierto y reducirlo a simples coordenadas. Tras una larga vida dedicada a descifrarlo, concluyo que las dunas que lo constituyen son un capricho del universo, un vivo escenario que respira y se curva con la misma inmensidad que la de los espejos. La distancia pervierte la mirada. Existe un antiguo dicho: «Ama al lejano más de lo que te amas a ti mismo». No obstante, la sentencia esconde una trampa. En un mundo que se dobla y retuerce sobre sí mismo, la mirada que persigue el horizonte termina inevitablemente estrellándose contra la nuca de quien observa. Este aparente «lejano» que tiembla en la arena, este «hostil» del que previenen los mitos, es el propio viajero, el observador. Su hostilidad es apenas el terror de encontrarse frente a frente con una imagen propia, deformada por los espejismos propios del páramo.</p>\n<h2>El tótem</h2>\n<p>La supervivencia aquí demanda conocer la leyenda de la Primera Puerta. Se cuenta que un primer carpintero, ya enloquecido por la vastedad, talló un pesado marco de roble en medio de la nada. Huérfana de muros y techo, materialización del delirio de la razón. Quienes llegan a dar con ella, aferrándose a la memoria de sus antiguas casas, giran el pomo con el anhelo de encontrar el cobijo que el desierto arrebata salvajemente. Pero claro, aquí se aborrece la lógica. Al cruzar aquel umbral, el viajero no hallaba un interior en el cual refugiarse, sino la misma devoradora infinitud de la cual huía. A pesar de su inutilidad, la madera pudriéndose lentamente al sol instauró la llamada ley suprema de las arenas: no existen refugios, solo actos de fe.</p>\n<h2>Geometría de las tiendas</h2>\n<p>Las tiendas de lona aparecen entre las dunas como las cicatrices que se llevan en el cuerpo. Ninguna tiene puertas. Y sin embargo, el destino de un hombre depende de su capacidad para «abrirle la puerta» al hostil. Caminar por la arena garantiza chocar violentamente contra la Otredad. No existe algún prójimo, la cercanía calcina cualquier rastro de compasión. Permitir el paso es un acto puro de convicción. Frente a la pared de tela lisa, el anfitrión ha de simular que aferra un pomo, girar la muñeca sintiendo el peso inexistente y tirar. Si la mano tiembla o la fe le vacila, el hostil no pisa la arena del interior de la tienda, en su lugar, atraviesa la psique y usurpa la mente del anfitrión.</p>\n<p>Se puede llegar al cuestionamiento: ¿de qué huye el Otro cuando rasguña la lona pretendiendo entrar? El sol sería la respuesta fácil. Pero el forastero es un prófugo de sí mismo. Al habitar su propia tienda, el viajero descubre que el interior se burla de la infinitud del espacio exterior, desplegando un sofocante laberinto de pasillos interminables. El hostil, entonces, huye del terror de su propio infinito. En su desamparo, el desierto se vuelve la única certeza finita, y la tienda ajena, la última esperanza para no perderse en sus propios abismos.</p>\n<h2>Fonética del abismo</h2>\n<p>La verdadera tensión radica en el segundo en que la sombra logra cruzar el umbral. El hostil no desenfunda armas largas de acero. Su violencia está en el lenguaje. Trae consigo palabrejas indescifrables, pero que duelen en los recuerdos de la infancia. Habla el dialecto exacto del subconsciente de quien lo aloja, escupiendo los fonemas al revés. Es un tipo de eco de la culpa y los deseos que no llegan a ser nombrados, convertidos en oscuros conjuros. El peligro mortal más allá del ataque del visitante, es que el anfitrión comience a comprenderlo. Prestar oídos al forastero es asomarse a la garganta del vacío propio.</p>\n<h2>Las estatuas de sal</h2>\n<p>Tal como supieron los primeros caminantes, no vagamos buscando salvación, estamos persiguiendo ciegamente a la otredad. Veneramos el espejismo borroso que nos ofrece el otro pues esa lejanía inalcanzable mantiene vivo el motor del deseo. La sed que seca las gargantas es una demanda de la arena pues nunca ha de ser saciada. Fascinado, el anfitrión recibe al hostil para ver si en él puede encontrar lo que le falta. El único triunfo posible, entonces, es prolongar el misterio lo máximo posible. La perdición llega con la lucidez. Ocurre cuando el anfitrión descifra el invertido lenguaje y descubre, con espanto, cuál es el deseo del visitante.</p>\n<p>En un destello de claridad, comprende que el otro busca exactamente el mismo vacío que él intenta esconder. Al compartir la carencia, la magia se quiebra. Muere el misterio y se extingue el deseo, esa fuerza voraz que obligaba a los cuerpos a moverse. Sin esa falta compartida, los límites de la piel ya no tienen sentido. El Uno y el Otro se abrazan en profundo silencio. Una fusión petrificante. Resuelta la ecuación del deseo, el desierto calcifica a las dos almas ahora «completas». Se convierten en estatuas de sal.</p>\n<p>Estos pilares blancos, más allá de simples piadosas advertencias, son lápidas de un deseo devorado. La sal es el unívoco destino inmutable de aquellos que cometieron el error de encontrarse a sí mismos en la mirada ajena, aniquilando la fina distancia que los mantenía a salvo.</p>\n<p>Nota para futuros investigadores: Para sobrevivir al desierto, debes dejar entrar al Otro. Debes escuchar el argot invertido. Pero has de jurar, por tu propia vida, jamás intentar comprenderlo del todo.</p>\n<h2>Epílogo en el estudio</h2>\n<p>He estado repasando estas notas durante toda la madrugada. El texto está prácticamente terminado. Afuera, la ciudad duerme. Mi estudio, forrado de bibliografía, es un templo de racionalidad. A mi izquierda, una pesada puerta de roble macizo me aísla del pasillo y del resto de la construcción.</p>\n<p>Me detengo unos instantes para ajustar mis conclusiones sobre la naturaleza semiótica del gesto. Y es ahí cuando lo noto.</p>\n<p>Primero aparece una sequedad inusual en la garganta. Luego, el olor. Un aroma áspero, alcalino, que no pertenece al pulcro ambiente de una biblioteca. Huele a arena recalentada. Intento ignorarlo y sigo tecleando, pero noto que se van desfasando mis movimientos. Se mezcla en el ambiente un sonido ajeno, un sordo arrastre proveniente del otro lado del muro.</p>\n<p>Alguien camina por el pasillo.</p>\n<p>No debería haber nadie en el edificio a esta hora. Estoy inmóvil. El sonido de los pasos se detiene justo frente a mi entrada. Entonces, escucho un susurro. Es una voz baja, gutural, que describe detenidamente el espacio esférico. Son las mismas palabras que acabo de escribir en el texto, pero las sílabas van en sentido contrario, se arrastran hacia atrás en el tiempo, como las cintas magnéticas rebobinadas a la fuerza.</p>\n<p>El terror frío me obliga a levantar la vista del escritorio.</p>\n<p>Los lomos de los libros se difuminan, se desdibujaron en una textura gruesa y opaca. Las paredes de mi estudio se mecen ligeramente con una brisa caliente que no debería existir. Son paredes de lona.</p>\n<p>Siento el peso del aire en mi nuca, giro la cabeza. La puerta de roble macizo ha desaparecido. En su lugar, un umbral vacío, recortado contra una inmensidad oscura y granulada. A través del hueco, la silueta de un forastero, deformada por una luz proveniente de quién sabe dónde, espera en el límite exacto de la lona.</p>\n<p>El texto está completo. La teoría es irrefutable. Si lo dejo afuera, entrará en mi mente. Si intento comprenderlo una vez que entre, terminaremos metamorfoseados en un pilar blanco sobre la alfombra.</p>\n<p>La silueta da un paso hacia el umbral.</p>\n<p>Respiro hondo, siento el polvo en los pulmones. Me levanto lentamente frente a la lisa lona. Levanto mi mano derecha temblorosa hacia el vacío y, recordando la solemne advertencia que marcaba el mito, decido si haré o no el ademán de girar el pomo.</p>', NULL, NULL, NULL, 32, 1, '2026-06-01 09:00:00');

-- --------------------------------------------------------
--
-- Estructura de la tabla `blog_recursos`
--

CREATE TABLE `blog_recursos` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `ref_tipo` varchar(20) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Estructura de la tabla `libros`
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

INSERT INTO `libros` (`id`, `titulo`, `autor`, `estado`, `completado`, `posicion`, `estrellas`, `comentario`, `fecha_leido`, `creado`) VALUES
(1, 'Sobrevivir a internet', 'Dominique Wolton', 'leido', 1, 1, 3.0, '', '2022-11-17', '2026-07-21 03:35:11'),
(2, 'WTF con el SAT', 'Paulina Casso', 'leido', 1, 2, 3.0, '', '2022-11-22', '2026-07-21 03:35:20'),
(3, 'Neuromarketing en acción', 'Néstor Braidot', 'leido', 1, 3, 4.0, '', '2022-12-01', '2026-07-21 03:35:33'),
(4, 'Orgullo Prieto', 'Tenoch Huerta', 'leido', 1, 4, 5.0, '', '2022-12-06', '2026-07-21 03:35:46'),
(5, 'Dibujo y Comunicación Gráfica', 'Rosa Puente', 'leido', 1, 5, 2.0, '', '2022-12-07', '2026-07-21 03:35:58'),
(6, 'El arte de la guerra', 'Sun Tzu', 'leido', 1, 6, 3.0, '', '2022-12-09', '2026-07-21 03:36:07'),
(7, 'Heartstopper 3', 'Alice Oseman', 'leido', 1, 7, 3.0, '', '2022-12-11', '2026-07-21 03:36:24'),
(8, 'El arte de tener razón', 'Arthur Schopenhauer', 'leido', 1, 8, 3.0, '', '2022-12-12', '2026-07-21 03:36:52'),
(9, 'Heartstopper 4', 'Alice Oseman', 'leido', 1, 9, 3.0, '', '2022-12-17', '2026-07-21 03:37:01'),
(10, 'Historia universal contemporánea', 'Dolores Nieto Rivero', 'leido', 1, 10, 4.0, '', '2022-12-27', '2026-07-21 03:37:18'),
(11, 'Fechas que marcaron la historia de México', 'Editorial Época', 'leido', 1, 11, 4.0, '', '2022-12-29', '2026-07-21 03:37:39'),
(12, 'Toda la cultura en 1001 preguntas', 'Carlos Blanco', 'leido', 1, 12, 5.0, '', '2023-01-04', '2026-07-21 03:37:53'),
(13, 'México, manual de supervivencia', 'Chumel Torres', 'leido', 1, 13, 5.0, '', '2023-01-05', '2026-07-21 03:38:01'),
(14, 'Megacapitalistas', 'Peter Phillips', 'leido', 1, 14, 4.0, '', '2023-01-08', '2026-07-21 03:38:18'),
(15, 'Historias que marcan', 'Eduardo Herrera', 'leido', 1, 15, 5.0, '', '2023-01-13', '2026-07-21 03:38:30'),
(16, 'Estética', 'Cristopher Kul-Want', 'leido', 1, 16, 4.0, '', '2023-01-21', '2026-07-21 03:39:24'),
(17, 'Piénsalo otra vez', 'Adam Grant', 'leido', 1, 17, 5.0, '', '2023-03-06', '2026-07-21 03:39:35'),
(18, 'Filosofía para desconfiados', 'David Pastor Vico', 'leido', 1, 18, 5.0, '', '2023-03-22', '2026-07-21 03:39:48'),
(19, 'Falacias Lógicas', 'Steve Allen', 'leido', 1, 19, 5.0, '', '2023-03-28', '2026-07-21 03:40:06'),
(20, 'No es normal', 'Viri Ríos', 'leido', 1, 20, 5.0, '', '2023-04-20', '2026-07-21 03:40:12'),
(21, 'Así hablaba Zaratustra', 'Friedrich Nietzsche', 'leido', 1, 21, 2.0, '', '2023-05-29', '2026-07-21 03:40:29'),
(22, 'Almanaque Chavorruco', 'Jorge Pinto', 'leido', 1, 22, 2.0, '', '2023-05-31', '2026-07-21 03:40:49'),
(23, 'El arte de hacer preguntas', 'Mario Borghino', 'leido', 1, 23, 3.0, '', '2023-06-07', '2026-07-21 03:41:07'),
(24, 'El libro de la psicología', 'Editorial DK', 'leido', 1, 24, 5.0, '', '2023-07-01', '2026-07-21 03:41:16'),
(25, 'Entender el arte moderno', 'Sam Phillips', 'leido', 1, 25, 3.0, '', '2023-07-14', '2026-07-21 03:41:27'),
(26, 'Piénsalo. 10 casos para la filosofía', 'Tomás Balmaceda', 'leido', 1, 26, 5.0, '', '2023-08-05', '2026-07-21 03:41:45'),
(27, 'Museo Pixar', 'Disney', 'leido', 1, 27, 3.0, '', '2023-08-06', '2026-07-21 03:41:54'),
(28, 'Resistencias Queer', 'Andrea Natzahuatza', 'leido', 1, 28, 2.0, '', '2023-08-15', '2026-07-21 03:42:07'),
(29, '¿Por qué las fake news nos joden la vida?', 'Marc Amorós', 'leido', 1, 29, 5.0, '', '2023-09-11', '2026-07-21 03:42:27'),
(30, 'El principito', 'Antoine de Saint-Exupéry', 'leido', 1, 30, 5.0, '', '2023-09-12', '2026-07-21 03:42:51'),
(31, 'La depresión (no) existe', 'Juan Carlos Rincón Escalante', 'leido', 1, 31, 2.0, '', '2023-09-16', '2026-07-21 03:43:15'),
(32, 'Las bases de big data y de la inteligencia artificial', 'Rafael Caballero', 'leido', 1, 32, 3.0, '', '2023-09-19', '2026-07-21 03:43:34'),
(33, 'El cerdo que quería ser jamón', 'Julián Baggini', 'leido', 1, 33, 5.0, '', '2023-10-05', '2026-07-21 03:44:38'),
(34, 'Totalmente humano', 'Cynthia Pratt Nicolson', 'leido', 1, 34, 3.0, '', '2023-10-07', '2026-07-21 03:45:14'),
(35, 'Megamenazas', 'Nouriel Roubini', 'leido', 1, 35, 4.0, '', '2023-10-22', '2026-07-21 03:45:27'),
(36, 'Biiblia Unilit para niños', 'Nancy Pineda', 'leido', 1, 36, 4.0, '', '2023-10-31', '2026-07-21 03:45:41'),
(37, 'Tipos de familia y bienestar de niños y adultos', 'Fernando Pliego Carrasco', 'leido', 1, 37, 2.0, '', '2023-11-02', '2026-07-21 03:46:10'),
(38, '¿Qué haría Nietzsche...?', 'Marcus Weeks', 'leido', 1, 38, 5.0, '', '2023-11-11', '2026-07-21 03:46:27'),
(39, '¡Salte con la tuya!', 'Álvaro Gordoa', 'leido', 1, 39, 5.0, '', '2023-11-26', '2026-07-21 03:46:45'),
(40, 'Este invierno', 'Alice Oseman', 'leido', 1, 40, 2.0, '', '2023-11-28', '2026-07-21 03:46:54'),
(41, 'Mitología: Dioses y Héroes', 'Equipo Editorial', 'leido', 1, 41, 4.0, '', '2023-12-08', '2026-07-21 03:47:06'),
(42, 'Un clavado a tu cerebro', 'Eduardo Calixto', 'leido', 1, 42, 5.0, '', '2023-12-15', '2026-07-21 03:47:17'),
(43, 'Balada de pájaros cantores y serpientes', 'Suzanne Collins', 'leido', 1, 43, 4.0, '', '2023-12-27', '2026-07-21 03:47:30'),
(44, 'Aquiles en Tiktok', 'Eduardo Infante', 'leido', 1, 44, 5.0, '', '2024-01-03', '2026-07-21 03:47:38'),
(45, 'La llamada de Cthulhu', 'HP Lovecraft', 'leido', 1, 45, 2.0, '', '2024-01-07', '2026-07-21 03:47:55'),
(46, 'La dimensión de las decepciones', 'Luis Perea', 'leido', 1, 46, 3.0, '', '2024-01-08', '2026-07-21 03:48:09'),
(47, 'Entrena tu mente', 'Mark Freeman', 'leido', 1, 47, 2.0, '', '2024-01-13', '2026-07-21 03:48:18'),
(48, 'Sapiens. De animales a dioses', 'Yuval Noah Harari', 'leido', 1, 48, 5.0, '', '2024-02-18', '2026-07-21 03:48:34'),
(49, 'Plumas Anáhuac. 2do concurso universitario', 'Universidad Anáhuac', 'leido', 1, 49, 3.0, '', '2024-02-18', '2026-07-21 03:48:50'),
(50, 'Era de idiotas', 'David Pastor Vico', 'leido', 1, 50, 3.0, '', '2024-03-25', '2026-07-21 03:48:57'),
(51, 'Nick y Charlie', 'Alice Oseman', 'leido', 1, 51, 2.0, '', '2024-03-26', '2026-07-21 03:49:06'),
(52, 'Farenheit 451', 'Ray Bradbury', 'leido', 1, 52, 4.0, '', '2024-04-06', '2026-07-21 03:49:17'),
(53, 'Filosofía', 'Michael Picard', 'leido', 1, 53, 4.0, '', '2024-04-21', '2026-07-21 03:49:28'),
(54, 'El lado B de las emociones', 'Eduardo Calixto', 'leido', 1, 54, 3.0, '', '2024-05-02', '2026-07-21 03:49:39'),
(55, 'Incongruencias pseudointelectuales', 'Diego Ruzzarin', 'leido', 1, 55, 4.0, '', '2024-05-04', '2026-07-21 03:49:53'),
(56, 'Cómo me enamoré de Sofía', 'Diego Ruzzarin', 'leido', 1, 56, 3.0, '', '2024-05-09', '2026-07-21 03:50:02'),
(57, 'De Platón a Winnie the Pooh', 'James M. Russell', 'leido', 1, 57, 4.0, '', '2024-05-18', '2026-07-21 03:50:17'),
(58, 'Mujeres de ciencia', 'Rachel Ignotofsky', 'leido', 1, 58, 2.0, '', '2024-05-23', '2026-07-21 03:50:49'),
(59, '50 cosas que hay que saber sobre Ética', 'Ben Dupré', 'leido', 1, 59, 2.0, '', '2024-05-30', '2026-07-21 03:51:06'),
(60, 'Heartstopper 5', 'Alice Oseman', 'leido', 1, 60, 3.0, '', '2024-06-01', '2026-07-21 03:51:14'),
(61, 'Revoluciones', 'Félix Chartreaux', 'leido', 1, 61, 3.0, '', '2024-06-14', '2026-07-21 03:51:22'),
(62, 'Nietzsche', 'Universidad ITAM', 'leido', 1, 62, 3.0, '', '2024-06-21', '2026-07-21 03:52:16'),
(63, 'Valle de la calma', 'Ángel David Revilla', 'leido', 1, 63, 4.0, '', '2024-07-08', '2026-07-21 03:52:28'),
(64, 'La política en 100 preguntas', 'Santiago Armesilla', 'leido', 1, 64, 3.0, '', '2024-07-20', '2026-07-21 03:52:39'),
(65, 'El libro de la filosofía', 'Editorial DK', 'leido', 1, 65, 4.0, '', '2024-07-25', '2026-07-21 03:52:46'),
(66, 'The branding method', 'Carolina Kairos', 'leido', 1, 66, 4.0, '', '2024-08-02', '2026-07-21 03:52:56'),
(67, 'La sociedad del espectáculo', 'Guy Deboard', 'leido', 1, 67, 2.0, '', '2024-08-08', '2026-07-21 03:53:07'),
(68, 'Anatomía del mal', 'Jordi Wild', 'leido', 1, 68, 4.0, '', '2024-08-14', '2026-07-21 03:53:18'),
(69, 'No te creas todo lo que piensas', 'Joseph Nguyen', 'leido', 1, 69, 3.0, '', '2024-09-16', '2026-07-21 03:53:31'),
(70, 'Atajos de psicología', 'Jennifer WIld', 'leido', 1, 70, 4.0, '', '2024-09-30', '2026-07-21 03:53:41'),
(71, 'Conversación asetirva', 'Dana Caspersen', 'leido', 1, 71, 4.0, '', '2024-10-01', '2026-07-21 03:54:11'),
(72, 'No me tapes el sol', 'Eduardo Infante', 'leido', 1, 72, 5.0, '', '2024-10-18', '2026-07-21 03:54:23'),
(73, 'La historia del mundo en 50 libros', 'Daniel Smith', 'leido', 1, 73, 4.0, '', '2024-10-29', '2026-07-21 03:54:38'),
(74, 'Philosophers', 'Miguel Ángel Robles Gómez', 'leido', 1, 74, 2.0, '', '2024-11-17', '2026-07-21 03:54:53'),
(75, 'Pulsaciones', 'Francesc Miralles', 'leido', 1, 75, 2.0, '', '2024-11-23', '2026-07-21 03:56:03'),
(76, 'Feng Shui', 'Terah Kathyrin Collins', 'leido', 1, 76, 3.0, '', '2024-12-02', '2026-07-21 03:56:19'),
(77, 'Robot salvaje', 'Peter Brown', 'leido', 1, 77, 3.0, '', '2024-12-06', '2026-07-21 03:56:30'),
(78, 'La experiencia interna', 'Jacobo Grinberg', 'leido', 1, 78, 4.0, '', '2024-12-09', '2026-07-21 03:56:42'),
(79, 'Hacia el sol de medianoche', 'Catrina Davies', 'leido', 1, 79, 4.0, '', '2024-12-16', '2026-07-21 03:56:52'),
(80, 'El desarrollo de la tecnología', 'Fernando Alba Andrade', 'leido', 1, 80, 3.0, '', '2024-12-19', '2026-07-21 03:57:06'),
(81, 'Food Design', 'Diego Ruzzarin', 'leido', 1, 81, 3.0, '', '2024-12-22', '2026-07-21 03:57:14'),
(82, 'Pachita', 'Jacobo Grinberg', 'leido', 1, 82, 4.0, '', '2025-01-01', '2026-07-21 03:57:19'),
(83, 'El manifiesto comunista', 'Karl Marx', 'leido', 1, 83, 3.0, '', '2025-01-02', '2026-07-21 03:57:27'),
(84, 'Una sexualidad de otro mundo', 'Francisco Fernández Romero', 'leido', 1, 84, 4.0, '', '2025-01-08', '2026-07-21 03:57:45'),
(85, 'Lugares asombrosos', 'Luisito Comunica', 'leido', 1, 85, 4.0, '', '2025-01-16', '2026-07-21 03:57:55'),
(86, '40 historias 40 días', 'Diego Ruzzarin', 'leido', 1, 86, 3.0, '', '2025-01-20', '2026-07-21 03:58:04'),
(87, 'La teoría sintérgica', 'Jacobo Grinberg', 'leido', 1, 87, 4.0, '', '2025-01-24', '2026-07-21 03:58:14'),
(88, 'Amor y dolor riman siempre', 'Bruno Pol Feliu García', 'leido', 1, 88, 3.0, '', '2025-02-01', '2026-07-21 03:58:33'),
(89, 'Sabiduría secreta', 'Ruth Clydesdale', 'leido', 1, 89, 4.0, '', '2025-02-11', '2026-07-21 03:58:51'),
(90, 'Retratos de la violencia', 'Brad Evans', 'leido', 1, 90, 3.0, '', '2025-02-16', '2026-07-21 03:59:02'),
(91, 'Así no es', 'Viri Ríos', 'leido', 1, 91, 5.0, '', '2025-02-24', '2026-07-21 03:59:09'),
(92, 'Cómo leer edificios', 'Carol Davidson Cragoe', 'leido', 1, 92, 3.0, '', '2025-03-02', '2026-07-21 03:59:25'),
(93, 'El enemigo conoce el sistema', 'Marta Peirano', 'leido', 1, 93, 4.0, '', '2025-03-24', '2026-07-21 03:59:39'),
(94, 'Otro palo al agua', 'Ernesto Castro', 'leido', 1, 94, 4.0, '', '2025-04-17', '2026-07-21 03:59:49'),
(95, 'Leonardo', 'Roberto Battaglia', 'leido', 1, 95, 3.0, '', '2025-04-19', '2026-07-21 03:59:59'),
(96, 'La creación de la experiencia', 'Jacobo Grinberg', 'leido', 1, 96, 2.0, '', '2025-04-28', '2026-07-21 04:00:08'),
(97, 'Sangre & Suerte', 'Mateus Bolson Ruzzarin', 'leido', 1, 97, 4.0, '', '2025-05-23', '2026-07-21 04:00:28'),
(98, 'El príncipe', 'Nicolás Maquiavelo', 'leido', 1, 98, 2.0, '', '2025-05-29', '2026-07-21 04:00:37'),
(100, 'Momo', 'Michael Ende', 'leido', 1, 100, 4.0, '', '2025-06-14', '2026-07-21 04:00:55'),
(101, 'Pasado virtual', 'Alberto Venegas Ramos', 'leido', 1, 101, 3.0, '', '2025-06-20', '2026-07-21 04:01:09'),
(103, 'Llámame por tu nombre', 'André Aciman', 'leido', 1, 103, 5.0, '', '2025-07-16', '2026-07-21 04:01:36'),
(104, 'The Dry Bar', 'Owen Williams', 'leido', 1, 104, 4.0, '', '2025-07-19', '2026-07-21 04:01:47'),
(106, 'Natural History Museum', 'Natural History Museum', 'leido', 1, 106, 4.0, '', '2025-07-27', '2026-07-21 04:02:13'),
(107, 'Un mundo feliz', 'Aldous Huxley', 'leido', 1, 107, 2.0, '', '2025-08-02', '2026-07-21 04:02:24'),
(108, 'El perfecto cerebro imperfecto', 'Eduardo Calixto', 'leido', 1, 108, 4.0, '', '2025-08-13', '2026-07-21 04:02:37'),
(109, 'El inversionista de enfrente', 'Moris Dieck', 'leido', 1, 109, 4.0, '', '2025-09-19', '2026-07-21 04:02:46'),
(112, 'Big ideas for curious minds', 'The school of life', 'leido', 1, 112, 5.0, '', '2025-09-05', '2026-07-21 04:03:21'),
(114, 'La tumba', 'José Agustín', 'leido', 1, 114, 3.0, '', '2025-09-17', '2026-07-21 04:03:59'),
(115, 'Mythos', 'Stephen Fry', 'leido', 1, 115, 4.0, '', '2025-10-12', '2026-07-21 04:04:08'),
(116, 'Pep Guardiola. La metamorfosis', 'Martí Perarnau', 'leido', 1, 116, 5.0, '', '2025-10-17', '2026-07-21 04:04:43'),
(117, 'Palalmas', 'Farid Dieck', 'leido', 1, 117, 4.0, '', '2025-10-18', '2026-07-21 04:04:49'),
(118, 'Futuralgia', 'Farid Dieck', 'leido', 1, 118, 3.0, '', '2025-10-19', '2026-07-21 04:04:57'),
(120, 'Kim Yi-young, nacida en 1982', 'Cho Nam-joo', 'leido', 1, 120, 4.0, '', '2025-11-01', '2026-07-21 04:05:39'),
(121, 'Sócrates', 'Beatrice Collina', 'leido', 1, 121, 5.0, '', '2025-11-05', '2026-07-21 04:06:00'),
(122, 'Juan Salvador Gaviota', 'Richard Bach', 'leido', 1, 122, 4.0, '', '2025-11-07', '2026-07-21 04:06:11'),
(123, 'Visit the USA', 'Desconocido', 'leido', 1, 123, 3.0, '', '2025-11-09', '2026-07-21 04:06:18'),
(126, 'Una película para cada año de tu vida', 'Alejandro G. Calvo', 'leido', 1, 126, 3.0, '', '2025-12-06', '2026-07-21 04:07:01'),
(129, 'Cómo aprender la excelencia', 'Eric Potterat', 'leido', 1, 129, 5.0, '', '2025-12-22', '2026-07-21 04:12:56'),
(131, 'Dime qué sientes', 'Jesus Martín-Fernández', 'leido', 1, 131, 5.0, '', '2026-01-03', '2026-07-21 04:13:52'),
(132, 'Tómatelo con estoicismo', 'Jaime Moreno Delgado', 'leido', 1, 132, 4.0, '', '2026-01-06', '2026-07-21 04:14:06'),
(134, 'Gastrosofía', 'Eduardo Infante', 'leido', 1, 134, 4.0, '', '2026-01-10', '2026-07-21 04:14:30'),
(144, 'Amazing Spider-Man 37', 'Desconocido', 'leido', 1, 144, 4.0, '', '2026-03-21', '2026-07-21 04:16:49'),
(147, 'El lado oscuro de la mente humana', 'Maryfer Centeno', 'leido', 1, 147, 4.5, '', '2026-04-06', '2026-07-21 04:17:28'),
(149, 'Mis chistes, mi filosofía', 'Slavoj Zizek', 'leido', 1, 149, 4.0, '', '2026-04-17', '2026-07-21 04:17:47'),
(160, '¡Mecagüen!', 'Sergio Parra', 'pendiente', 0, 160, NULL, NULL, NULL, '2026-07-21 04:24:24'),
(170, 'Cultiva tu memesfera', 'Sergio Parra', 'pendiente', 1, 161, NULL, NULL, NULL, '2026-07-21 04:28:47'),
(171, 'El escape de la robot salvaje', 'Peter Brown', 'pendiente', 1, 162, NULL, NULL, NULL, '2026-07-21 04:29:06'),
(172, 'El kybalion', 'Hermes Trismegisto', 'pendiente', 1, 163, NULL, NULL, NULL, '2026-07-21 04:29:14'),
(173, 'La sociedad del cansancio', 'Byung Chul Han', 'pendiente', 1, 164, NULL, NULL, NULL, '2026-07-21 04:29:21'),
(174, 'País sin techo', 'Carla Escoffié', 'pendiente', 1, 165, 0.0, '', NULL, '2026-07-21 04:30:09'),
(175, 'Lo que los libros de historia del arte no quieren que sepas', 'Blanca Guilera', 'pendiente', 1, 166, NULL, NULL, NULL, '2026-07-21 04:30:29'),
(176, 'Carta de una desconocida', 'Stefan Zweig', 'pendiente', 0, 167, NULL, NULL, NULL, '2026-07-21 04:30:44'),
(177, 'Siddartha', 'Hermann Hesse', 'pendiente', 1, 168, NULL, NULL, NULL, '2026-07-21 04:31:01'),
(178, 'El hombre en búsqueda del sentido', 'Victor Frankl', 'pendiente', 1, 169, NULL, NULL, NULL, '2026-07-21 04:31:08'),
(179, 'La agonía del Eros', 'Byung Chul Han', 'pendiente', 1, 170, NULL, NULL, NULL, '2026-07-21 04:31:16'),
(180, 'Más allá del principio del placer', 'Sigmund Freud', 'pendiente', 0, 171, NULL, NULL, NULL, '2026-07-21 04:31:21'),
(181, 'El diseño de las cosas cotidianas', 'Donald Norman', 'pendiente', 0, 172, NULL, NULL, NULL, '2026-07-21 04:31:29'),
(182, 'Pedagogía del oprimido', 'Paulo Freire', 'pendiente', 1, 173, NULL, NULL, NULL, '2026-07-21 04:31:45'),
(183, 'La era de la IA', 'Henry Kissinger', 'pendiente', 0, 174, NULL, NULL, NULL, '2026-07-21 04:31:50'),
(184, 'Cuentos completos', 'Jorge Luis Borges', 'pendiente', 1, 175, NULL, NULL, NULL, '2026-07-21 04:32:24'),
(185, 'El mito de Sísifo', 'Albert Camus', 'pendiente', 0, 176, NULL, NULL, NULL, '2026-07-21 04:32:35'),
(186, 'La historia del mundo en 50 mentiras', 'Natasha Tidd', 'pendiente', 0, 177, NULL, NULL, NULL, '2026-07-21 04:32:47'),
(187, '100 lugares que ver después de morir', 'Ken Jennings', 'pendiente', 0, 178, NULL, NULL, NULL, '2026-07-21 04:33:21'),
(188, 'La batalla por el templo', 'Jacobo Grinberg', 'pendiente', 0, 179, NULL, NULL, NULL, '2026-07-21 04:33:29'),
(189, 'Entiende la tecnología', 'Nate Gentile', 'pendiente', 0, 180, NULL, NULL, NULL, '2026-07-21 04:33:39'),
(190, 'El juego de los abalorios', 'Hermann Hesse', 'pendiente', 0, 181, NULL, NULL, NULL, '2026-07-21 04:33:47'),
(191, 'Marcos de guerra', 'Judith Butler', 'pendiente', 0, 182, NULL, NULL, NULL, '2026-07-21 04:33:58'),
(192, 'Poesía completa', 'Alejandra Pizarnik', 'pendiente', 1, 183, NULL, NULL, NULL, '2026-07-21 04:34:14'),
(193, 'Fábulas de robots', 'Stanislaw Lem', 'pendiente', 0, 184, NULL, NULL, NULL, '2026-07-21 04:34:32'),
(194, 'Lodo', 'Guillermo Fadanelli', 'pendiente', 0, 185, NULL, NULL, NULL, '2026-07-21 04:34:40'),
(195, 'Por qué tengo que ver esta película', 'Alejandro G. Calvo', 'pendiente', 0, 186, NULL, NULL, NULL, '2026-07-21 04:34:53'),
(196, 'La meditación', 'Jacobo Grinberg', 'pendiente', 0, 187, NULL, NULL, NULL, '2026-07-21 04:35:01'),
(197, 'El viejo y el mar', 'Ernest Hemingway', 'pendiente', 1, 188, NULL, NULL, NULL, '2026-07-21 04:36:55'),
(198, 'El lobo estepario', 'Hermann Hesse', 'pendiente', 1, 189, NULL, NULL, NULL, '2026-07-21 04:37:02'),
(199, 'Meditaciones', 'Marco Aurelio', 'pendiente', 1, 190, NULL, NULL, NULL, '2026-07-21 04:37:08'),
(200, 'Los juegos del hambre: Amanecer en la cosecha', 'Suzanne Collins', 'pendiente', 0, 191, NULL, NULL, NULL, '2026-07-21 04:37:25'),
(201, '1984', 'George Orwell', 'pendiente', 1, 192, NULL, NULL, NULL, '2026-07-21 04:37:32'),
(202, 'El amor es imposible', 'Darío Sztajnszrajber', 'pendiente', 1, 193, NULL, NULL, NULL, '2026-07-21 04:37:39'),
(203, 'Filosofía en 11 frases', 'Darío Sztajnszrajber', 'pendiente', 0, 194, NULL, NULL, NULL, '2026-07-21 04:37:48'),
(204, 'Maus: Relato de un superviviente', 'Art Spiegelman', 'pendiente', 0, 195, NULL, NULL, NULL, '2026-07-21 04:38:05'),
(205, 'Sapienciología', 'Sergio Parra', 'pendiente', 0, 196, NULL, NULL, NULL, '2026-07-21 04:38:14'),
(206, 'Money for beginners', 'Matthew Oldham', 'pendiente', 0, 197, NULL, NULL, NULL, '2026-07-21 04:38:27'),
(207, 'Diario de un CEO', 'Steve Bartlett', 'pendiente', 0, 198, NULL, NULL, NULL, '2026-07-21 04:38:35'),
(208, 'Apiádense del lector', 'Kurt Vonnegut', 'pendiente', 0, 199, NULL, NULL, NULL, '2026-07-21 04:38:50'),
(209, '100 lecciones de neurociencia', 'Eduardo Calixto', 'pendiente', 0, 200, NULL, NULL, NULL, '2026-07-21 04:45:34'),
(210, 'Ciudadela', 'Antoine de Saint-Exupéry', 'pendiente', 0, 201, NULL, NULL, NULL, '2026-07-21 04:45:39'),
(211, 'Rebelión en la granja', 'George Orwell', 'pendiente', 1, 202, NULL, NULL, NULL, '2026-07-21 04:45:58'),
(212, 'Los filósofos y el amor', 'Aude Lancelin', 'pendiente', 0, 203, NULL, NULL, NULL, '2026-07-21 04:46:10'),
(213, 'Usted se encuentra aquí', 'Fabían C. Barrio', 'pendiente', 0, 204, NULL, NULL, NULL, '2026-07-21 04:46:23'),
(214, 'Las 7 tramas básicas', 'Cristopher Booker', 'pendiente', 0, 205, NULL, NULL, NULL, '2026-07-21 04:46:35'),
(215, 'Atrapa el pez dorado', 'David Lynch', 'pendiente', 0, 206, NULL, NULL, NULL, '2026-07-21 04:46:47'),
(216, 'El fútbol y su filosofía', 'Martí Perarnau', 'pendiente', 0, 207, NULL, NULL, NULL, '2026-07-21 04:46:58'),
(217, 'Ampliación del campo de batalla', 'Michael Houllebecq', 'pendiente', 0, 208, NULL, NULL, NULL, '2026-07-21 04:47:16'),
(218, 'Sybil', 'Flora Rheta', 'pendiente', 0, 209, NULL, NULL, NULL, '2026-07-21 04:47:24'),
(219, 'Demian', 'Hermann Hesse', 'pendiente', 0, 210, NULL, NULL, NULL, '2026-07-21 04:47:29'),
(220, 'Antropología estructural', 'Claude Levi Strauss', 'pendiente', 0, 211, NULL, NULL, NULL, '2026-07-21 04:47:43'),
(221, 'Zen en el arte de escribir', 'Ray Bradbury', 'pendiente', 0, 212, NULL, NULL, NULL, '2026-07-21 04:47:57'),
(222, 'No logo', 'Naomi Klein', 'pendiente', 0, 213, NULL, NULL, NULL, '2026-07-21 04:48:04'),
(223, 'El acto de crear', 'Rick Rubin', 'pendiente', 0, 214, NULL, NULL, NULL, '2026-07-21 04:48:14'),
(224, 'Pedro Páramo', 'Juan Rulfo', 'pendiente', 0, 215, NULL, NULL, NULL, '2026-07-21 04:48:21'),
(225, 'Tango satánico', 'Laszló Karsznahorkai', 'pendiente', 0, 216, NULL, NULL, NULL, '2026-07-21 04:48:35'),
(226, 'Tokio Blues', 'Haruki Murakami', 'pendiente', 0, 217, NULL, NULL, NULL, '2026-07-21 04:48:48'),
(227, 'La historia no es como la cuenta Hollywood', 'Miguel de Lys', 'pendiente', 0, 218, NULL, NULL, NULL, '2026-07-21 04:49:04'),
(228, 'La clase de griego', 'Han Kang', 'pendiente', 1, 219, NULL, NULL, NULL, '2026-07-21 04:49:24'),
(229, 'La civilización del espectáculo', 'Mario Vargas Llosa', 'pendiente', 0, 220, NULL, NULL, NULL, '2026-07-21 04:49:38'),
(230, 'We3', 'Grant Morrison', 'pendiente', 0, 221, NULL, NULL, NULL, '2026-07-21 04:49:45'),
(231, 'El infinito en un junco', 'Irene Vallejo', 'pendiente', 0, 222, NULL, NULL, NULL, '2026-07-21 04:49:59'),
(232, 'La desaparición de los rituales', 'Byung Chul Han', 'pendiente', 0, 223, NULL, NULL, NULL, '2026-07-21 04:50:08'),
(233, 'La caída', 'Albert Camus', 'pendiente', 0, 224, NULL, NULL, NULL, '2026-07-21 04:50:15'),
(234, 'The Last Ronin', 'Kevin Eastman', 'pendiente', 0, 225, NULL, NULL, NULL, '2026-07-21 04:50:28'),
(235, 'La palabra exacta', 'Miguel Ángel Velasco', 'pendiente', 0, 226, NULL, NULL, NULL, '2026-07-21 04:50:39'),
(236, 'Breve historia del arte', 'Susie Hodge', 'pendiente', 0, 227, NULL, NULL, NULL, '2026-07-21 04:50:49'),
(237, 'Mitología prehispánica', 'Maythe Lojero', 'pendiente', 0, 228, NULL, NULL, NULL, '2026-07-21 04:51:07'),
(238, 'Los vagabundos del dharma', 'Jack Keruac', 'pendiente', 0, 229, NULL, NULL, NULL, '2026-07-21 04:51:27'),
(239, 'El vehículo de las transformaciones', 'Jacobo Grinberg', 'pendiente', 0, 230, NULL, NULL, NULL, '2026-07-21 04:51:36'),
(240, 'Lecciones de epicureísmo', 'John Sellars', 'pendiente', 1, 231, NULL, NULL, NULL, '2026-07-21 04:52:22'),
(241, 'Lecciones de estoicismo', 'John Sellars', 'pendiente', 1, 232, NULL, NULL, NULL, '2026-07-21 04:52:36'),
(242, 'Lecciones de Aristóteles', 'John Sellars', 'pendiente', 1, 233, NULL, NULL, NULL, '2026-07-21 04:52:44'),
(243, '172 horas en la luna', 'Johan Harstad', 'pendiente', 0, 234, NULL, NULL, NULL, '2026-07-21 04:53:03'),
(244, 'Filosofía helenística: estoicos, epicúreos, cínicos y escépticos', 'JA Carmona', 'pendiente', 0, 235, NULL, NULL, NULL, '2026-07-21 04:53:33'),
(245, 'El poder de las palabras', 'Mariano Sigman', 'pendiente', 1, 236, NULL, NULL, NULL, '2026-07-21 04:55:40'),
(246, 'Cien años de soledad', 'Gabriel García Márquez', 'pendiente', 0, 237, NULL, NULL, NULL, '2026-07-21 04:55:53'),
(247, 'El anticristo', 'Friedrich Nietzsche', 'pendiente', 1, 238, NULL, NULL, NULL, '2026-07-21 04:55:58'),
(248, 'El libro de la sociología', 'Editorial DK', 'pendiente', 1, 239, NULL, NULL, NULL, '2026-07-21 04:56:05'),
(249, 'El libro del arte', 'Editorial DK', 'pendiente', 1, 240, NULL, NULL, NULL, '2026-07-21 04:56:18'),
(250, 'El jardín de las mariposas', 'Dot Hutchison', 'pendiente', 1, 241, NULL, NULL, NULL, '2026-07-21 04:56:25'),
(251, '¡Goza tu síntoma!', 'Slavoj Zizek', 'pendiente', 1, 242, NULL, NULL, NULL, '2026-07-21 04:56:31'),
(252, 'Asesinato en el Orient Express', 'Agatha Christie', 'pendiente', 1, 243, NULL, NULL, NULL, '2026-07-21 04:56:37'),
(253, 'It', 'Stephen King', 'pendiente', 1, 244, NULL, NULL, NULL, '2026-07-21 04:56:43'),
(254, 'Diálogos', 'Platón', 'pendiente', 1, 245, NULL, NULL, NULL, '2026-07-21 04:56:50'),
(255, 'Apocalípticos e integrados', 'Humberto Eco', 'pendiente', 0, 246, NULL, NULL, NULL, '2026-07-21 04:57:04'),
(256, 'El señor de las moscas', 'William Golding', 'pendiente', 0, 247, NULL, NULL, NULL, '2026-07-21 04:57:16'),
(257, 'Te vas a morir y aún no has empezado a vivir', 'Uli Moreno', 'pendiente', 0, 248, NULL, NULL, NULL, '2026-07-21 04:57:26'),
(258, 'V de Vendetta', 'Alan Moore', 'pendiente', 0, 249, NULL, NULL, NULL, '2026-07-21 04:57:33'),
(259, 'Dune', 'Frank Herbert', 'pendiente', 0, 250, NULL, NULL, NULL, '2026-07-21 04:57:38'),
(260, 'Aesthetics: A comprehensive anthology', 'Steven Cahn', 'pendiente', 0, 251, NULL, NULL, NULL, '2026-07-21 04:57:54'),
(261, 'Breve historia y antología de la estética', 'José María Valverde', 'pendiente', 0, 252, NULL, NULL, NULL, '2026-07-21 04:58:07'),
(262, 'Epícuro', 'Carlos García Gual', 'pendiente', 0, 253, NULL, NULL, NULL, '2026-07-21 04:58:17'),
(263, 'Obras completas', 'Epicuro', 'pendiente', 0, 254, NULL, NULL, NULL, '2026-07-21 04:58:23'),
(264, 'Fragmentos presocráticos', 'Varios', 'pendiente', 0, 255, NULL, NULL, NULL, '2026-07-21 04:58:38'),
(265, 'La misión de la robot salvaje', 'Peter Brown', 'pendiente', 0, 256, NULL, NULL, NULL, '2026-07-21 04:58:46'),
(266, 'Seguir con el problema: Generar parentesco con el Cthuluceno', 'Donna Haraway', 'pendiente', 0, 257, NULL, NULL, NULL, '2026-07-21 04:59:06'),
(267, 'Furia', 'Clyo Mendoza', 'pendiente', 0, 258, NULL, NULL, NULL, '2026-07-21 04:59:18'),
(268, 'Los desposeídos', 'Ursula K Le Guin', 'pendiente', 0, 259, NULL, NULL, NULL, '2026-07-21 04:59:41'),
(269, 'Frankenstein', 'Mary Shelly', 'pendiente', 0, 260, NULL, NULL, NULL, '2026-07-21 04:59:50'),
(270, 'Enquiridión', 'Epicteto', 'pendiente', 0, 261, NULL, NULL, NULL, '2026-07-21 04:59:57'),
(271, 'Virtudes', 'Héctor Zagal', 'pendiente', 1, 262, NULL, NULL, NULL, '2026-07-21 05:00:10'),
(272, 'Tratados mortales', 'Séneca', 'pendiente', 0, 263, NULL, NULL, NULL, '2026-07-21 05:00:34'),
(273, 'El gran pan ha muerto', 'Ernesto Castro', 'pendiente', 0, 264, NULL, NULL, NULL, '2026-07-21 05:00:44'),
(274, 'Perictione o de la libertad', 'Ernesto Castro', 'pendiente', 0, 265, NULL, NULL, NULL, '2026-07-21 05:00:53'),
(275, 'Garfield Full Course Vol I', 'Jim Davies', 'pendiente', 0, 266, NULL, NULL, NULL, '2026-07-21 05:02:03'),
(276, 'El grinch robó la navidad', 'Dr Seuss', 'pendiente', 0, 267, NULL, NULL, NULL, '2026-07-21 05:02:25'),
(277, 'Los 7 activos invisibles', 'Moris Dieck', 'pendiente', 0, 268, NULL, NULL, NULL, '2026-07-21 05:02:35'),
(278, 'The new comedy bible', 'Judy Carter', 'pendiente', 0, 269, NULL, NULL, NULL, '2026-07-21 05:02:44'),
(279, 'El libro de los espíritus', 'Allan Cardeck', 'pendiente', 0, 270, NULL, NULL, NULL, '2026-07-21 05:02:55'),
(280, 'La mcdonadización de la sociedad', 'George Ritzer', 'pendiente', 0, 271, NULL, NULL, NULL, '2026-07-21 05:03:12'),
(281, 'Solo en la bolera', 'Robert D Putnam', 'pendiente', 0, 272, NULL, NULL, NULL, '2026-07-21 05:03:24'),
(282, 'La disneyficación de la sociedad', 'Alan Bryman', 'pendiente', 0, 273, NULL, NULL, NULL, '2026-07-21 05:03:35'),
(283, 'Modernindad líquida', 'Zygmund Bauman', 'pendiente', 0, 274, NULL, NULL, NULL, '2026-07-21 05:03:49'),
(284, 'Comer, viajar, descubrir', 'Anthony Bourdain', 'pendiente', 0, 275, NULL, NULL, NULL, '2026-07-21 05:04:03'),
(285, 'Japanese Layout Design', 'SendPoints', 'pendiente', 1, 276, NULL, NULL, NULL, '2026-07-21 05:04:11'),
(286, 'Los secretos de la motivación', 'José Antonio Marina', 'pendiente', 0, 277, NULL, NULL, NULL, '2026-07-21 05:04:56'),
(287, 'Plumas Anáhuac. 4to concurso universitario', 'Universidad Anáhuac', 'pendiente', 1, 278, NULL, NULL, NULL, '2026-07-21 05:05:10'),
(288, 'Todos los fuegos el fuego', 'Julio Cortázar', 'pendiente', 0, 279, NULL, NULL, NULL, '2026-07-21 05:05:27'),
(289, 'El amor en tiempos de cólera', 'Gabriel García Márquez', 'pendiente', 0, 280, NULL, NULL, NULL, '2026-07-21 05:06:26'),
(290, 'Roba como un artista', 'Austin Klean', 'pendiente', 0, 281, NULL, NULL, NULL, '2026-07-21 05:06:34'),
(291, 'Es mi tipo', 'Simon Garfield', 'pendiente', 0, 282, NULL, NULL, NULL, '2026-07-21 05:06:41'),
(292, 'Metrópolis, una historia de la ciudad', 'Ben Wilson', 'pendiente', 0, 283, NULL, NULL, NULL, '2026-07-21 05:06:54'),
(293, 'Contagioso', 'Jonah Berger', 'pendiente', 0, 284, NULL, NULL, NULL, '2026-07-21 05:07:14'),
(294, 'Diez razones para borrar tus redes sociales de inmediato', 'Jaron Lanier', 'pendiente', 0, 285, NULL, NULL, NULL, '2026-07-21 05:07:28'),
(295, 'El muro del yo', 'Gensho Taigu', 'pendiente', 0, 286, NULL, NULL, NULL, '2026-07-21 05:07:42'),
(296, 'La risa', 'Henri Bergsom', 'pendiente', 0, 287, NULL, NULL, NULL, '2026-07-21 05:07:51'),
(297, 'El hombre y sus símbolos', 'Carl Jung', 'pendiente', 0, 288, NULL, NULL, NULL, '2026-07-21 05:07:59'),
(298, 'Crónica de una muerte anunciada', 'Gabriel García Márquez', 'pendiente', 0, 289, NULL, NULL, NULL, '2026-07-21 05:08:06'),
(299, 'El negociador', 'Arturo Elías Ayub', 'pendiente', 0, 290, NULL, NULL, NULL, '2026-07-21 05:08:15'),
(300, 'Quiero ser antiracista', 'Jumko Ogata Aguilar', 'pendiente', 0, 291, NULL, NULL, NULL, '2026-07-21 05:08:42'),
(301, 'Cómo sufrir un poco menos', 'Pedro Campos', 'pendiente', 0, 292, NULL, NULL, NULL, '2026-07-21 05:08:52'),
(302, 'Lo que aprendí de mi gato Emile', 'Ramiro Calle', 'pendiente', 0, 293, NULL, NULL, NULL, '2026-07-21 05:09:01'),
(303, 'Cocina molecular', 'Karlos Escribano', 'pendiente', 0, 294, NULL, NULL, NULL, '2026-07-21 05:09:14'),
(304, 'La pata de mono', 'William W Jacobs', 'pendiente', 0, 295, NULL, NULL, NULL, '2026-07-21 05:09:23'),
(305, 'El trap', 'Ernesto Castro', 'pendiente', 0, 296, NULL, NULL, NULL, '2026-07-21 05:09:30'),
(306, 'Mentes inteligentes', 'Mario de la Piedra Walter', 'pendiente', 0, 297, NULL, NULL, NULL, '2026-07-21 05:09:42'),
(307, 'Solo compasión', 'Bryan Stevenson', 'pendiente', 0, 298, NULL, NULL, NULL, '2026-07-21 05:09:50'),
(308, 'El sutil arte de que te importe un carajo', 'Mark Manson', 'pendiente', 0, 299, NULL, NULL, NULL, '2026-07-21 05:10:08'),
(309, 'Guía México Gastronómica 2026: Los mejores 250 restaurantes', 'Larousse Cocina', 'pendiente', 0, 300, NULL, NULL, NULL, '2026-07-21 05:10:30'),
(310, 'La comunicación no verbal', 'Flora Davies', 'pendiente', 0, 301, NULL, NULL, NULL, '2026-07-21 05:10:38'),
(311, 'Winnie the Pooh', 'A A Milne', 'pendiente', 0, 302, NULL, NULL, NULL, '2026-07-21 05:11:21'),
(312, 'Robot Dreams', 'Sara Varon', 'pendiente', 0, 303, NULL, NULL, NULL, '2026-07-21 05:11:47'),
(313, 'Charlie y la fábrica de chocolate', 'Roald Dahl', 'pendiente', 0, 304, NULL, NULL, NULL, '2026-07-21 05:12:10'),
(314, 'Mitologías', 'Roland Barthes', 'pendiente', 0, 305, NULL, NULL, NULL, '2026-07-21 05:12:23'),
(315, 'EL caballero de la armadura oxidada', 'Robert Fisher', 'pendiente', 0, 306, NULL, NULL, NULL, '2026-07-21 05:12:35'),
(316, 'Harry Potter y la piedra filosofal', 'JK Rowling', 'pendiente', 0, 307, NULL, NULL, NULL, '2026-07-21 05:12:48'),
(317, 'Bartleby, el escribiente', 'Herman Melville', 'pendiente', 0, 308, NULL, NULL, NULL, '2026-07-21 05:13:02'),
(318, 'El hombre duplicado', 'José Saramago', 'pendiente', 0, 309, NULL, NULL, NULL, '2026-07-21 05:13:13'),
(319, 'La nueva ciencia de la mentira', 'José María Martínez Selva', 'pendiente', 0, 310, NULL, NULL, NULL, '2026-07-21 05:13:28'),
(320, 'El extraño orden de las cosas', 'Antonio Damasio', 'pendiente', 0, 311, NULL, NULL, NULL, '2026-07-21 05:13:36'),
(321, 'El error de Descartes', 'Antonio Damasio', 'pendiente', 0, 312, NULL, NULL, NULL, '2026-07-21 05:13:49'),
(322, 'The Brain ar Rest', 'Joseph Jebelli', 'pendiente', 0, 313, NULL, NULL, NULL, '2026-07-21 05:14:07'),
(323, 'Enamórate de ti', 'Walter Riso', 'pendiente', 1, 314, NULL, NULL, NULL, '2026-07-21 05:14:38'),
(324, 'Curso de lingüística general', 'Ferdinand de Saussure', 'pendiente', 0, 315, NULL, NULL, NULL, '2026-07-21 05:15:03'),
(325, 'La aventura semiológica', 'Roland Barthes', 'pendiente', 0, 316, NULL, NULL, NULL, '2026-07-21 05:15:16'),
(326, 'Historias de cronopios y de famas', 'Julio Cortázar', 'pendiente', 1, 317, NULL, NULL, NULL, '2026-07-21 05:16:02'),
(327, 'El proceso', 'Franz Kafka', 'pendiente', 0, 318, NULL, NULL, NULL, '2026-07-21 05:16:20'),
(328, 'Siete noches', 'Jorge Luis Borges', 'pendiente', 0, 319, NULL, NULL, NULL, '2026-07-21 05:16:25'),
(329, 'El aroma a lavanda', 'Dara Cabushtak', 'pendiente', 0, 320, NULL, NULL, NULL, '2026-07-21 05:16:48'),
(330, 'Fantastic Four Solve Everything', 'Jonathan Hickman', 'pendiente', 0, 321, NULL, NULL, NULL, '2026-07-21 05:18:21'),
(331, 'Superman up in the sky', 'Tom King', 'pendiente', 0, 322, NULL, NULL, NULL, '2026-07-21 05:18:34'),
(332, 'Batman the imposter', 'Mattson Tomlin', 'pendiente', 0, 323, NULL, NULL, NULL, '2026-07-21 05:18:45'),
(333, 'Vision', 'Tom King', 'pendiente', 0, 324, NULL, NULL, NULL, '2026-07-21 05:18:49'),
(334, 'Superman space age', 'Mark Russell', 'pendiente', 0, 325, NULL, NULL, NULL, '2026-07-21 05:19:00'),
(335, 'Spiderman Blue', 'Jeph Loeb', 'pendiente', 0, 326, NULL, NULL, NULL, '2026-07-21 05:19:12'),
(336, 'Spiderman Life Story', 'Chip Zdarsky', 'pendiente', 0, 327, NULL, NULL, NULL, '2026-07-21 05:19:25'),
(337, 'Ultimate Spiderman', 'Brian Michael Bendis', 'pendiente', 0, 328, NULL, NULL, NULL, '2026-07-21 05:19:36'),
(338, 'Salvar a Sócrates', 'Eduardo Infante', 'pendiente', 0, 329, NULL, NULL, NULL, '2026-07-21 05:19:52'),
(339, 'Thinking in Systems', 'Donella H Meadows', 'pendiente', 0, 330, NULL, NULL, NULL, '2026-07-21 05:20:13'),
(340, 'Una filosofía para sobrevivir en el siglo XXI', 'Jesús G Maestro', 'pendiente', 0, 331, NULL, NULL, NULL, '2026-07-21 05:20:28'),
(341, 'El conejo en la cara de la luna', 'Alfredo López Austin', 'pendiente', 0, 332, NULL, NULL, NULL, '2026-07-21 05:20:45'),
(342, 'Visión de los vencidos', 'Miguel León Portilla', 'pendiente', 0, 333, NULL, NULL, NULL, '2026-07-21 05:20:55'),
(343, 'Pensamiento y religión en el México antiguo', 'Laurette Sejourne', 'pendiente', 0, 334, NULL, NULL, NULL, '2026-07-21 05:21:11'),
(344, 'La vegetariana', 'Han Kang', 'pendiente', 0, 335, NULL, NULL, NULL, '2026-07-21 05:21:40'),
(345, 'EL guantelete del infinito', 'Jim Starlin', 'pendiente', 0, 336, NULL, NULL, NULL, '2026-07-21 05:21:53'),
(346, 'Breve historia ilustrada del mundo', 'Ernst H Gombrich', 'pendiente', 0, 337, NULL, NULL, NULL, '2026-07-21 05:22:07'),
(347, 'Swamp Thing | Libro seis', 'Alan Moore', 'pendiente', 1, 338, NULL, NULL, NULL, '2026-07-21 05:22:23'),
(348, 'Las historias que nunca contamos', 'Martha Figueroa', 'pendiente', 1, 339, NULL, NULL, NULL, '2026-07-21 05:23:08'),
(349, 'Marvels', 'Alex Ross', 'pendiente', 0, 340, NULL, NULL, NULL, '2026-07-21 05:23:16'),
(350, 'Doctor Strange - El juramento', 'Brian K Vaughan', 'pendiente', 1, 341, NULL, NULL, NULL, '2026-07-21 05:23:26'),
(351, '100 grandes misterios revelados', 'National Geographic', 'pendiente', 1, 342, NULL, NULL, NULL, '2026-07-21 05:23:42'),
(352, 'Los videojuegos. Su estudio y análisis', 'Eduardo Aguado', 'pendiente', 0, 343, NULL, NULL, NULL, '2026-07-21 05:23:57'),
(353, 'Analízate', 'Maryfer Centeno', 'pendiente', 0, 344, NULL, NULL, NULL, '2026-07-21 05:24:07'),
(354, 'Cocinología. La ciencia de cocinar', 'Stuart Farrimond', 'pendiente', 0, 345, NULL, NULL, NULL, '2026-07-21 05:24:34'),
(355, 'Pero querías ser chef', 'Luis Jiménez de Santiago', 'pendiente', 0, 346, NULL, NULL, NULL, '2026-07-21 05:24:46'),
(356, 'La parábola de Pablo', 'Alonzo Salazar', 'pendiente', 0, 347, NULL, NULL, NULL, '2026-07-21 05:24:56'),
(357, 'Ensayo sobre la ceguera', 'José Saramago', 'pendiente', 0, 348, NULL, NULL, NULL, '2026-07-21 05:25:09'),
(358, 'Teogonía', 'Hesíodo', 'pendiente', 0, 349, NULL, NULL, NULL, '2026-07-21 05:25:15'),
(359, 'El arte en la era digital', 'Filosofía&Co', 'pendiente', 0, 350, NULL, NULL, NULL, '2026-07-21 05:25:34'),
(360, 'El lenguaje es otro cuando alguien muere', 'Filosofía&Co', 'pendiente', 0, 351, NULL, NULL, NULL, '2026-07-21 05:25:42'),
(361, 'Lo que el lenguaje esconde', 'Filosofía&Co', 'pendiente', 0, 352, NULL, NULL, NULL, '2026-07-21 05:25:48'),
(362, 'Arder', 'Filosofía&Co', 'pendiente', 0, 353, NULL, NULL, NULL, '2026-07-21 05:25:53'),
(363, 'El país era una fiesta', 'Filosofía&Co', 'pendiente', 0, 354, NULL, NULL, NULL, '2026-07-21 05:25:59'),
(364, 'Ética en la Inteligencia Artificial', 'Filosofía&Co', 'pendiente', 0, 355, NULL, NULL, NULL, '2026-07-21 05:26:09'),
(365, 'Trilema global', 'Alfredo Jalife', 'pendiente', 0, 356, NULL, NULL, NULL, '2026-07-21 05:26:19'),
(366, 'El mito de la ingeligencia artificial', 'Erik J Larson', 'pendiente', 0, 357, NULL, NULL, NULL, '2026-07-21 05:26:35'),
(367, 'El arte femenino', 'Museo del Prado', 'pendiente', 0, 358, NULL, NULL, NULL, '2026-07-21 05:26:47'),
(368, 'Sentido común', 'Thomas Paine', 'pendiente', 0, 359, NULL, NULL, NULL, '2026-07-21 05:26:59'),
(369, 'La democracia en América', 'Alexis de Tocqueville', 'pendiente', 1, 360, NULL, NULL, NULL, '2026-07-21 05:27:10'),
(370, '¿Qué es el lenguaje?', 'Benedicte de Boysson-Bardies', 'pendiente', 0, 361, NULL, NULL, NULL, '2026-07-21 05:27:22'),
(371, 'El lenguaje y la vida humana', 'Mauricio Swadesh', 'pendiente', 0, 362, NULL, NULL, NULL, '2026-07-21 05:28:08'),
(372, 'Outrage', 'Kurt Gray', 'pendiente', 0, 363, NULL, NULL, NULL, '2026-07-21 05:28:19'),
(373, 'The secret pulse of time', 'Stefan Klein', 'pendiente', 0, 364, NULL, NULL, NULL, '2026-07-21 05:28:29'),
(374, 'El hacedor', 'Jorge Luis Borges', 'pendiente', 0, 365, NULL, NULL, NULL, '2026-07-21 05:28:35'),
(375, 'Noches blancas', 'Fiodor Dostoievsky', 'pendiente', 0, 366, NULL, NULL, NULL, '2026-07-21 05:28:56'),
(376, 'Hipercomplejidad', 'Sergio Parra', 'pendiente', 0, 367, NULL, NULL, NULL, '2026-07-21 05:29:04'),
(377, 'Conceptos básicos para problemas pendejos', 'Ricardo O\'Farrill', 'pendiente', 0, 368, NULL, NULL, NULL, '2026-07-21 05:29:19'),
(378, 'Control', 'Freddy Vega', 'pendiente', 0, 369, NULL, NULL, NULL, '2026-07-21 05:29:26'),
(379, 'La guerra del golfo no ha tenido lugar', 'Jean Baudrillard', 'pendiente', 0, 370, NULL, NULL, NULL, '2026-07-21 05:29:39'),
(380, 'El lenguaje de las ciudades', 'Deyan Sudjic', 'pendiente', 0, 371, NULL, NULL, NULL, '2026-07-21 05:29:53'),
(381, 'La parte que falta', 'Shel Silverstein', 'pendiente', 0, 372, NULL, NULL, NULL, '2026-07-21 05:30:01'),
(382, 'La parte que falta conoce a la gran O', 'Shel Silverstein', 'pendiente', 0, 373, NULL, NULL, NULL, '2026-07-21 05:30:14'),
(383, 'La rueda del Buddah', 'Sol Umara', 'pendiente', 0, 374, NULL, NULL, NULL, '2026-07-21 05:30:28'),
(384, 'El libro tibetano de los muertos', 'Anónimo', 'pendiente', 0, 375, NULL, NULL, NULL, '2026-07-21 05:30:38'),
(385, 'Las cuatro nobles verdades', 'Dalai Lama', 'pendiente', 0, 376, NULL, NULL, NULL, '2026-07-21 05:30:47'),
(386, 'Trotamundos del deporte', 'John Sutcliffe', 'pendiente', 0, 377, NULL, NULL, NULL, '2026-07-21 05:31:08'),
(387, 'Software as a Science', 'Dan Martell', 'pendiente', 0, 378, NULL, NULL, NULL, '2026-07-21 05:31:19'),
(388, 'Tecnofeudalismo', 'Yanis Varoufakis', 'pendiente', 0, 379, NULL, NULL, NULL, '2026-07-21 05:31:40'),
(389, 'Cuentos filosóficos del mundo entero', 'Jean Claude Carriere', 'pendiente', 0, 380, NULL, NULL, NULL, '2026-07-21 05:31:56'),
(390, 'La búsqueda del todo', 'Carlos Blanco', 'pendiente', 0, 381, NULL, NULL, NULL, '2026-07-21 05:32:06'),
(391, 'Una izquierda que se atreva a decir su nombre', 'Slavoj Zizek', 'pendiente', 0, 382, NULL, NULL, NULL, '2026-07-21 05:32:21'),
(392, 'Iberofonía y socialismo', 'Santiago Armesilla', 'pendiente', 0, 383, NULL, NULL, NULL, '2026-07-21 05:32:28'),
(393, 'Mis primeras historias de la Biblia', 'Jillian Harker', 'pendiente', 0, 384, NULL, NULL, NULL, '2026-07-21 05:32:41'),
(394, 'Heartstopper 6', 'Alice Oseman', 'pendiente', 0, 385, NULL, NULL, NULL, '2026-07-21 05:32:50'),
(395, 'La sabiduría de los psicópatas', 'Kevin Dutton', 'pendiente', 0, 386, NULL, NULL, NULL, '2026-07-21 05:33:05'),
(396, 'The language instinct', 'Steven Pinker', 'pendiente', 0, 387, NULL, NULL, NULL, '2026-07-21 05:33:17'),
(397, 'Why zebras don\'t get ulcers', 'Robert M Sapolsky', 'pendiente', 0, 388, NULL, NULL, NULL, '2026-07-31 20:39:19'),
(398, 'El mundo de las banderas', 'Ernesto Fidel', 'pendiente', 0, 389, NULL, NULL, NULL, '2026-07-31 20:39:43'),
(399, 'Banderas del mundo', 'Juan Suero Pérez Frade', 'pendiente', 0, 390, NULL, NULL, NULL, '2026-07-31 20:40:23'),
(400, 'La apasionante historia de los mundiales', 'Alberto Lati', 'pendiente', 0, 391, NULL, NULL, NULL, '2026-07-31 20:40:48'),
(401, 'El arte de la guerra, guía visual', 'Anthony Cummins', 'pendiente', 0, 392, NULL, NULL, NULL, '2026-07-31 20:41:30'),
(402, 'Sísifo el hombre que engañó a la muerte', 'Pol Gise', 'pendiente', 0, 393, NULL, NULL, NULL, '2026-07-31 20:42:03'),
(403, 'Mitiquissim', 'Pol Gise', 'pendiente', 0, 394, NULL, NULL, NULL, '2026-07-31 20:42:20'),
(404, 'Best story wins', 'Mark Edwards', 'pendiente', 0, 395, NULL, NULL, NULL, '2026-08-15 20:48:57'),
(405, 'Filosofía&Co #9', 'Filosofía&Co', 'pendiente', 0, 396, NULL, NULL, NULL, '2026-08-15 20:49:58');

-- --------------------------------------------------------
--
-- Estructura de la tabla `pys_categorias`
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
-- Estructura de la tabla `peliculas_series`
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
  `seleccion` tinyint(1) NOT NULL DEFAULT 0,
  `creado` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `peliculas_series`
--

INSERT INTO `peliculas_series` (`id`, `categoria`, `titulo`, `autor`, `anio`, `duracion`, `nota`, `fecha_vista`, `poster`, `comentario`, `seleccion`, `creado`) VALUES
(1, 'Serie', 'El inocente', 'Oriol Paulo', 2021, NULL, 7.0, '2021-08-14', 'poster-1785528540-f5a454.png', '', 0, '2026-07-24 00:10:50'),
(2, 'Película', 'Ready Player One', 'Steven Spielberg', 2018, 140, 7.0, '2021-08-18', 'poster-1785528552-571b59.png', '', 0, '2026-07-24 00:12:10'),
(3, 'Película', 'Nace una Estrella', 'Bradley Cooper', 2018, 136, 9.0, '2021-08-27', 'poster-1785528563-9ccb9e.png', '', 1, '2026-07-28 21:30:23'),
(4, 'Serie', 'The I-Land', 'Anthony Salter', 2019, NULL, 2.0, '2021-08-27', 'poster-1785528577-decc5d.png', '', 0, '2026-07-28 21:31:14'),
(5, 'Serie', 'Game of Thrones', 'David Benioff', 2011, NULL, 9.0, '2021-08-30', 'poster-1785528588-633586.png', '', 0, '2026-07-28 21:32:43'),
(6, 'Película', 'Wonder Woman 1984', 'Patty Jenkins', 2020, 151, 4.0, '2021-09-02', 'poster-1785528612-3e38d0.png', '', 0, '2026-07-28 21:39:20'),
(7, 'Película', 'Space Jam: A New Legacy', 'Malcolm D. Lee', 2021, 105, 4.0, '2021-09-02', 'poster-1785528644-3fee02.png', '', 0, '2026-07-28 21:40:02'),
(8, 'Película', 'Spider-Man: Homecoming', 'Jon Watts', 2017, 133, 8.0, '2021-09-04', 'poster-1785528659-ea5dfe.png', '', 0, '2026-07-28 21:40:57'),
(9, 'Película', 'Los Juegos del Hambre: Sinsajo - Parte I', 'Francis Lawrence', 2014, 123, 6.0, '2021-09-07', 'poster-1785528682-6884a0.png', '', 0, '2026-07-28 21:42:08'),
(10, 'Película', 'Shang-Chi y la Leyenda de los Diez Anillos', 'Destin Daniel Cretton', 2021, 132, 7.0, '2021-09-11', 'poster-1785528701-1f7ce5.png', '', 0, '2026-07-28 21:43:42'),
(11, 'Película', 'Megalodón', 'Jon Turteltaub', 2018, 113, 3.0, '2021-09-12', 'poster-1785528752-84519e.png', '', 0, '2026-07-28 21:44:32'),
(12, 'Película', 'Guten Tag, Ramón', 'Jorge Ramírez Suárez', 2013, 120, 9.0, '2021-09-12', 'poster-1785528763-59c797.png', '', 1, '2026-07-28 21:45:14'),
(13, 'Película', 'Godzilla vs. Kong', 'Adam Wingard', 2021, 113, 6.0, '2021-09-14', 'poster-1785528777-d647b4.png', '', 0, '2026-07-28 21:46:05'),
(14, 'Película', 'Black Widow', 'Cate Shortland', 2021, 134, 6.0, '2021-09-16', 'poster-1785528839-32dde7.png', '', 0, '2026-07-28 21:47:43'),
(15, 'Serie', 'Chernobyl', 'Craig Mazin', 2019, NULL, 9.0, '2021-09-18', 'poster-1785528856-b8d5e8.png', '', 0, '2026-07-28 21:48:20'),
(16, 'Serie', 'Sex Education', 'Laurie Nunn', 2019, NULL, 8.0, '2021-09-21', 'poster-1785528933-42fcca.png', '', 0, '2026-07-28 22:05:58'),
(17, 'Película', 'Historia de un Matrimonio', 'Noah Baumbach', 2019, 137, 10.0, '2021-09-26', 'poster-1785528956-28cb40.png', '', 1, '2026-07-28 22:06:37'),
(18, 'Película', 'Terremoto: La Falla de San Andrés', 'Brad Peyton', 2015, 114, 5.0, '2021-09-29', 'poster-1785528966-587cb1.png', '', 0, '2026-07-28 22:07:13'),
(19, 'Película', 'Soul', 'Pete Docter', 2020, 100, 8.0, '2021-09-30', 'poster-1785528977-1e34b6.png', '', 0, '2026-07-28 22:07:50'),
(20, 'Película', 'Charlie y la Fábrica de Chocolate', 'Tim Burton', 2005, 115, 8.0, '2021-10-01', 'poster-1785528988-27b016.png', '', 0, '2026-07-28 22:09:09'),
(21, 'Película', 'The Matrix', 'Lana & Lilly Wachowski', 1999, 136, 9.0, '2021-10-03', 'poster-1785529001-5608f0.png', '', 0, '2026-07-28 22:10:06'),
(22, 'Película', 'It', 'Andy Muschietti', 2017, 135, 8.0, '2021-10-05', 'poster-1785529011-0ea289.png', '', 0, '2026-07-28 22:10:49'),
(23, 'Película', 'The Incredible Hulk', 'Louis Leterrier', 2008, 112, 6.0, '2021-10-05', 'poster-1785529037-1f02db.png', '', 0, '2026-07-28 22:11:35'),
(24, 'Serie', 'What If...?', 'Jeffrey Wright', 2021, NULL, 6.0, '2021-10-06', 'poster-1785529046-b67e98.png', '', 0, '2026-07-28 22:12:10'),
(25, 'Película', 'The Matrix Reloaded', 'Lana & Lilly Wachowski', 2003, 138, 8.0, '2021-10-07', 'poster-1785529056-ba26b9.png', '', 0, '2026-07-28 22:12:47'),
(26, 'Película', 'El Lobo de Wall Street', 'Martin Scorsese', 2013, 180, 9.0, '2021-10-09', 'poster-1785529066-9abdec.png', '', 1, '2026-07-28 22:13:35'),
(27, 'Película', 'The Lego Movie', 'Phil Lord', 2014, 100, 7.0, '2021-10-09', 'poster-1785529075-8e8c6c.png', '', 0, '2026-07-28 22:14:15'),
(28, 'Película', 'Godzilla', 'Gareth Edwards', 2014, 123, 6.0, '2021-10-10', 'poster-1785529083-6146bd.png', '', 0, '2026-07-28 22:14:45'),
(29, 'Película', 'Animales Fantásticos y Dónde Encontrarlos', 'David Yates', 2016, 132, 7.0, '2021-10-11', 'poster-1785529093-f9e4db.png', '', 0, '2026-07-28 22:15:33'),
(30, 'Serie', 'Días de gallos', 'Hernán Guerschuny', 2021, NULL, 4.0, '2021-10-15', 'poster-1785529102-cb4c81.png', '', 0, '2026-07-28 22:16:11'),
(31, 'Película', 'Los Pitufos', 'Raja Gosnell', 2011, 103, 4.0, '2021-10-17', 'poster-1786081959-416e6e.png', '', 0, '2026-08-07 05:52:39'),
(32, 'Película', 'Oblivion', 'Joseph Kosinski', 2013, 124, 7.0, '2021-10-17', 'poster-1786082294-f698f0.png', '', 0, '2026-08-07 05:58:14'),
(33, 'Serie', 'You', 'Greg Berlanti', 2018, NULL, 7.0, '2021-10-23', 'poster-1786082330-084bde.png', '', 0, '2026-08-07 05:58:50'),
(34, 'Película', 'El Mesero', 'Raúl Martínez', 2021, 87, 1.0, '2021-10-24', 'poster-1786082368-1b0a7b.png', '', 0, '2026-08-07 05:59:28'),
(35, 'Película', 'Seven', 'David Fincher', 1995, 127, 10.0, '2021-10-25', 'poster-1786082401-69327f.png', '', 1, '2026-08-07 06:00:01'),
(36, 'Película', 'Pulp Fiction', 'Quentin Tarantino', 1994, 154, 9.0, '2021-10-30', 'poster-1786082475-32f75b.png', '', 0, '2026-08-07 06:01:15'),
(37, 'Serie', 'Wandavision', 'Jac Schaeffer', 1958, NULL, 8.0, '2021-10-31', 'poster-1786082514-89dda7.png', '', 0, '2026-08-07 06:01:54'),
(38, 'Película', 'Iron Man', 'Jon Favreau', 2008, 126, 8.0, '2021-11-01', 'poster-1786082556-3e2f9f.png', '', 0, '2026-08-07 06:02:36'),
(39, 'Película', 'Dune: Part One', 'Denis Villeneuve', 2021, 155, 8.0, '2021-11-01', 'poster-1786082594-6f3824.png', '', 0, '2026-08-07 06:03:14'),
(40, 'Película', 'Spider-Man: Far from Home', 'Jon Watts', 2019, 129, 7.0, '2021-11-01', 'poster-1786082644-3186ba.png', '', 0, '2026-08-07 06:04:04'),
(41, 'Película', 'No se aceptan devoluciones', 'Eugenio Derbez', 2013, 127, 8.0, '2021-11-03', 'poster-1786083733-9e478c.png', '', 0, '2026-08-07 06:21:06'),
(42, 'Película', 'Son como Niños', 'Dennis Dugan', 2010, 102, 5.0, '2021-11-04', 'poster-1786083717-6b7a86.png', '', 0, '2026-08-07 06:21:57'),
(43, 'Película', 'Náufrago', 'Robert Zemeckis', 2000, 143, 6.0, '2021-11-06', 'poster-1786083787-a65f0a.png', '', 0, '2026-08-07 06:23:07'),
(44, 'Película', 'Eternals', 'Chloé Zhao', 2021, 156, 6.0, '2021-11-07', 'poster-1786083886-9ce905.png', '', 0, '2026-08-07 06:24:46'),
(45, 'Película', '¿Qué Pasó Ayer?', 'Todd Phillips', 2009, 100, 8.0, '2021-11-07', 'poster-1786083935-874c6b.png', '', 0, '2026-08-07 06:25:35'),
(46, 'Película', 'Tren a Busán', 'Yeon Sang-ho', 2016, 118, 9.0, '2021-11-09', 'poster-1786083977-59c099.png', '', 1, '2026-08-07 06:26:17'),
(47, 'Película', 'Un Lugar en Silencio', 'John Krasinski', 2018, 90, 9.0, '2021-11-11', 'poster-1786084020-4ec8b0.png', '', 1, '2026-08-07 06:27:00'),
(48, 'Película', 'El Hoyo', 'Galder Gaztelu-Urrutia', 2019, 94, 8.0, '2021-11-13', 'poster-1786084087-e78f5b.png', '', 0, '2026-08-07 06:28:07'),
(49, 'Serie', 'Regular Show', 'J. G. Quintel', 2010, NULL, 8.0, '2021-11-13', 'poster-1786084122-01853f.png', '', 0, '2026-08-07 06:28:42'),
(50, 'Película', 'Héroe de Centro Comercial', 'Steve Carr', 2009, 91, 2.0, '2021-11-14', 'poster-1786084153-67d274.png', '', 0, '2026-08-07 06:29:13'),
(51, 'Película', 'Beautiful Boy', 'Felix van Groeningen', 2018, 120, 8.0, '2021-11-14', 'poster-1786085271-4d2c9b.png', '', 0, '2026-08-07 06:47:51'),
(52, 'Película', 'Harry Potter y la Piedra Filosofal', 'Chris Columbus', 2001, 152, 8.0, '2021-11-14', 'poster-1786085310-a3ef98.png', '', 0, '2026-08-07 06:48:30'),
(53, 'Película', 'Hachiko', 'Lasse Hallstrom', 2009, 93, 9.0, '2021-11-15', 'poster-1786085342-20f911.png', '', 1, '2026-08-07 06:49:02'),
(54, 'Película', 'Spider-Man', 'Sam Raimi', 2002, 121, 6.0, '2021-11-15', 'poster-1786085377-f4725c.png', '', 0, '2026-08-07 06:49:37'),
(55, 'Película', 'Mirreyes contra Godínez', 'Chava Cartas', 2019, 109, 1.0, '2021-11-16', 'poster-1786085423-ef49cb.png', '', 0, '2026-08-07 06:50:23'),
(56, 'Película', 'Spider-Man 2', 'Sam Raimi', 2004, 127, 8.0, '2021-11-17', 'poster-1786085462-956d04.png', '', 0, '2026-08-07 06:51:02'),
(57, 'Película', 'Harry Potter y la Cámara de los Secretos', 'Chris Columbus', 2002, 161, 7.0, '2021-11-19', 'poster-1786085502-3ac23f.png', '', 0, '2026-08-07 06:51:42'),
(58, 'Película', 'Room', 'Lenny Abrahamson', 2015, 118, 9.0, '2021-11-20', 'poster-1786085541-b5bb2f.png', '', 1, '2026-08-07 06:52:21'),
(59, 'Película', 'Son como Niños 2', 'Dennis Dugan', 2013, 101, 3.0, '2021-11-20', 'poster-1786085575-5ad137.png', '', 0, '2026-08-07 06:52:55'),
(60, 'Película', 'Captain Phillips', 'Paul Greengrass', 2013, 134, 9.0, '2021-11-21', 'poster-1786085614-0fa1a9.png', '', 1, '2026-08-07 06:53:34'),
(61, 'Película', 'The Founder', 'John Lee Hancock', 2016, 115, 8.0, '2021-11-21', 'poster-1786086196-bc242b.png', '', 0, '2026-08-07 07:03:16'),
(62, 'Película', '¿Qué Pasó Ayer? Parte II', 'Todd Phillips', 2011, 102, 6.0, '2021-11-22', 'poster-1786128128-ddb342.png', '', 0, '2026-08-07 18:42:08'),
(63, 'Película', 'Harry Potter y el Prisionero de Azkabán', 'Alfonso Cuarón', 2004, 142, 8.0, '2021-11-23', 'poster-1786128168-7c4248.png', '', 0, '2026-08-07 18:42:48'),
(64, 'Película', 'Jurassic World', 'Colin Trevorrow', 2013, 91, 7.0, '2021-11-26', 'poster-1786128221-aed07b.png', '', 0, '2026-08-07 18:43:41'),
(65, 'Película', 'Spider-Man 3', 'Sam Raimi', 2007, 139, 6.0, '2021-11-28', 'poster-1786128263-838379.png', '', 0, '2026-08-07 18:44:23'),
(66, 'Película', 'Kong: Skull Island', 'Jordan Vogt-Roberts', 2017, 118, 7.0, '2021-11-28', 'poster-1786128313-568049.png', '', 0, '2026-08-07 18:45:13'),
(67, 'Película', 'The Social Network', 'David Fincher', 2010, 120, 9.0, '2021-11-30', 'poster-1786128710-6f8e34.png', '', 1, '2026-08-07 18:51:50'),
(68, 'Película', 'Kung Fu Panda', 'Mark Osborne', 2011, 90, 6.0, '2021-12-04', 'poster-1786128756-b2f153.png', '', 0, '2026-08-07 18:52:36'),
(69, 'Película', 'After Earth', 'M. Night Shyamalan', 2013, 100, 2.0, '2021-12-04', 'poster-1786128847-217795.png', '', 0, '2026-08-07 18:54:07'),
(70, 'Película', 'Kung Fu Panda 2', 'Jennifer Yuh Nelson', 2011, 90, 6.0, '2021-12-04', 'poster-1786128881-0e35b8.png', '', 0, '2026-08-07 18:54:41'),
(71, 'Película', 'Captain America: The First Avenger', 'Joe Johnston', 2011, 124, 6.0, '2021-12-04', 'poster-1786128924-1216a9.png', '', 0, '2026-08-07 18:55:24'),
(72, 'Película', 'The Dark Night', 'Christopher Nolan', 2008, 152, 10.0, '2021-12-05', 'poster-1786129087-b47570.png', '', 1, '2026-08-07 18:58:07'),
(73, 'Película', 'La Leyenda de la Llorona', 'Alberto Rodríguez', 2011, 75, 7.0, '2021-12-06', 'poster-1786129600-5ac5d5.png', '', 0, '2026-08-07 19:06:40'),
(74, 'Película', 'Alvin y las Ardillas', 'Tim Hill', 2007, 92, 8.0, '2021-12-06', 'poster-1786129710-30a746.png', '', 0, '2026-08-07 19:08:30'),
(75, 'Película', 'Alvin y las Ardillas 2', 'Betty Thomas', 2009, 88, 5.0, '2021-12-07', 'poster-1786129746-b3df31.png', '', 0, '2026-08-07 19:09:06'),
(76, 'Película', 'Alvin y las Ardillas 3', 'Mike Mitchell', 2011, 87, 4.0, '2021-12-07', 'poster-1786129777-7f1e38.png', '', 0, '2026-08-07 19:09:37'),
(77, 'Película', 'The Game', 'David Fincher', 1997, 129, 8.0, '2021-12-07', 'poster-1786129817-2657fa.png', '', 0, '2026-08-07 19:10:17'),
(78, 'Película', 'Due Date', 'Todd Phillips', 2010, 95, 7.0, '2021-12-09', 'poster-1786129847-9ae4f8.png', '', 0, '2026-08-07 19:10:47'),
(79, 'Película', 'tick, tick... BOOM!', 'Lin-Manuel Miranda', 2021, 115, 8.0, '2021-12-10', 'poster-1786129885-742345.png', '', 0, '2026-08-07 19:11:25'),
(80, 'Película', 'Gravity', 'Alfonso Cuarón', 2013, 91, 10.0, '2021-11-26', 'poster-1786130010-580aec.png', '', 1, '2026-08-07 19:13:30'),
(81, 'Película', 'The Matrix Revolutions', 'Lana & Lilly Wachowski', 2003, 129, 6.0, '2021-12-11', 'poster-1786130059-a77105.png', '', 0, '2026-08-07 19:14:19'),
(82, 'Película', '¿Qué Pasó Ayer? Parte III', 'Todd Phillips', 2013, 100, 5.0, '2021-12-12', 'poster-1786130105-5fdbac.png', '', 0, '2026-08-07 19:15:05'),
(83, 'Película', 'Harry Potter y el Cáliz de Fuego', 'Mike Newell', 2005, 157, 8.0, '2021-12-12', 'poster-1786130160-460a72.png', '', 0, '2026-08-07 19:16:00'),
(84, 'Serie', 'El Increíble Mundo de Gumball', 'Ben Bocquelet', 2011, NULL, 7.0, '2021-12-15', 'poster-1786130202-b9c17b.png', '', 0, '2026-08-07 19:16:42'),
(85, 'Película', 'Kung Fu Panda 3', 'Jennifer Yuh Nelson', 2016, 95, 5.0, '2021-12-16', 'poster-1786130391-8ef6e3.png', '', 0, '2026-08-07 19:19:51'),
(86, 'Película', 'El Diario de Greg', 'Gino Nichele', 2021, 59, 4.0, '2021-12-16', 'poster-1786130899-a2fa9a.png', '', 0, '2026-08-07 19:28:19'),
(87, 'Película', 'Spider-Man: No Way Home', 'Jon Watts', 2021, 148, 8.0, '2021-12-19', 'poster-1786130961-648d3c.png', '', 0, '2026-08-07 19:29:21'),
(88, 'Película', 'Harry Potter y la Orden del Fénix', 'David Yates', 2007, 138, 7.0, '2021-12-21', 'poster-1786131004-8995ba.png', '', 0, '2026-08-07 19:30:04'),
(89, 'Serie', 'Hawkeye', 'Jonathan Igla', 2021, NULL, 7.0, '2021-12-22', 'poster-1786131072-b21e9e.png', '', 0, '2026-08-07 19:31:12'),
(90, 'Película', 'Artificial Intelligence', 'Steven Spielberg', 2001, 146, 10.0, '2021-12-22', 'poster-1786131110-1d9089.png', '', 1, '2026-08-07 19:31:50'),
(91, 'Película', 'The Matrix Resurrections', 'Lana Wachowski', 2021, 148, 3.0, '2021-12-24', 'poster-1786131278-49eb20.png', '', 0, '2026-08-07 19:34:38'),
(92, 'Película', 'Harry Potter y el Misterio del Príncipe', 'David Yates', 2009, 153, 7.0, '2021-12-25', 'poster-1786131314-579a44.png', '', 0, '2026-08-07 19:35:14'),
(93, 'Película', 'Circle', 'Aaron Hann', 2015, 87, 9.0, '2021-12-26', 'poster-1786131362-c111cd.png', '', 1, '2026-08-07 19:36:02'),
(94, 'Película', 'Tau', 'Federico D\'Alessandro', 2018, 97, 5.0, '2021-12-27', 'poster-1786131395-ee2dbf.png', '', 0, '2026-08-07 19:36:35'),
(95, 'Película', 'Don\'t Look Up', 'Adam McKay', 2021, 138, 9.0, '2021-12-27', 'poster-1786131434-927aab.png', '', 1, '2026-08-07 19:37:14'),
(96, 'Película', 'Camino Amarte', 'Humberto Hinojosa Ozcariz', 2017, 93, 3.0, '2021-12-29', 'poster-1786131496-21ce70.png', '', 0, '2026-08-07 19:38:16'),
(97, 'Película', 'Harry Potter y las Reliquias de la Muerte: Parte 1', 'David Yates', 2011, 146, 7.0, '2021-12-31', 'poster-1786131551-d5426e.png', '', 0, '2026-08-07 19:39:11'),
(98, 'Película', 'Harry Potter y las Reliquias de la Muerte: Parte 2', 'David Yates', 2011, 130, 8.0, '2021-12-31', 'poster-1786131639-b54b17.png', '', 0, '2026-08-07 19:40:39'),
(99, 'Película', 'Mi Villano Favorito', 'Pierre Coffin', 2010, 95, 8.0, '2022-01-01', 'poster-1786131751-82ad79.png', '', 0, '2026-08-07 19:42:31'),
(100, 'Película', 'Mi Villano Favorito 2', 'Pierre Coffin', 2013, 98, 7.0, '2022-01-01', 'poster-1786131790-d88f31.png', '', 0, '2026-08-07 19:43:10'),
(101, 'Película', 'Lo Imposible', 'J. A. Bayona', 2012, 114, 8.0, '2022-01-02', 'poster-1787017050-78a88e.png', '', 0, '2026-08-17 23:05:04'),
(102, 'Película', 'At Eternity\'s Gate', 'Julian Schabel', 2018, 111, 9.0, '2022-01-03', 'poster-1787017063-d70524.png', '', 0, '2026-08-17 23:06:05'),
(103, 'Película', 'Alvin y las Ardillas: Sobre Ruedas', 'Walt Becker', 2015, 92, 4.0, '2022-01-03', 'poster-1787017172-b07641.png', '', 0, '2026-08-17 23:08:08'),
(104, 'Película', 'Nerve', 'Henry Joost', 2016, 96, 3.0, '2022-01-04', 'poster-1787017072-e34026.png', '', 0, '2026-08-18 01:27:44'),
(105, 'Película', 'No Manches Frida', 'Nacho G. Velilla', 2016, 114, 3.0, '2022-01-05', 'poster-1787017083-e43292.png', '', 0, '2026-08-18 01:28:58'),
(106, 'Película', 'La Leyenda de la Nahuala', 'Ricardo Arnaiz', 2007, 82, 5.0, '2022-01-06', 'poster-1787017093-c1be27.png', '', 0, '2026-08-18 01:29:31'),
(107, 'Película', 'Ted', 'Seth MacFarlane', 2012, 106, 6.0, '2022-01-07', 'poster-1787017105-0ecd38.png', '', 0, '2026-08-18 01:30:08'),
(108, 'Película', 'El Secreto de la Calabaza Mágica', 'John Chu', 2007, 84, 6.0, '2022-01-08', 'poster-1787017114-b0c5e4.png', '', 0, '2026-08-18 01:30:39'),
(109, 'Película', 'The Maze Runner', 'Wes Ball', 2014, 113, 8.0, '2022-01-09', 'poster-1787017124-c79e82.png', '', 0, '2026-08-18 01:31:20'),
(110, 'Película', 'Maze Runner: Prueba de Fuego', 'Wes Ball', 2015, 131, 7.0, '2022-01-10', 'poster-1787017146-ede8cc.png', '', 0, '2026-08-18 01:31:59'),
(111, 'Película', 'Ted 2', 'Seth MacFarlane', 2015, 115, 4.0, '2022-01-12', 'poster-1787017527-931b11.png', '', 0, '2026-08-18 01:45:27'),
(112, 'Serie', 'Gravity Falls', 'Alex Hirsch', 2012, NULL, 10.0, '2022-01-12', 'poster-1787017587-badba4.png', '', 1, '2026-08-18 01:46:27'),
(113, 'Película', 'It: Chapter Two', 'Andy Muschietti', 2019, 169, 8.0, '2022-01-13', 'poster-1787017632-94a6b8.png', '', 0, '2026-08-18 01:47:12'),
(114, 'Película', 'Jaws', 'Steven Spielberg', 1975, 124, 7.0, '2022-01-14', 'poster-1787017661-f9a455.png', '', 0, '2026-08-18 01:47:41'),
(115, 'Película', 'Tiempo Compartido', 'Sebastián Hoffman', 2018, 96, 7.0, '2022-01-14', 'poster-1787017691-d3cf07.png', '', 0, '2026-08-18 01:48:11'),
(116, 'Película', 'Rio', 'Carlos Saldanha', 2011, 96, 9.0, '2022-01-14', 'poster-1787017727-5f439d.png', '', 1, '2026-08-18 01:48:47'),
(117, 'Cortometraje', 'Host', 'Rob Savage', 2020, 57, 7.0, '2022-01-16', 'poster-1787017785-48592f.png', '', 0, '2026-08-18 01:49:45'),
(118, 'Película', 'Venom', 'Ruben Fleischer', 2018, 112, 7.0, '2022-01-17', 'poster-1787017817-cab4b5.png', '', 0, '2026-08-18 01:50:17'),
(119, 'Película', 'Jack and Jill', 'Dennis Dugan', 2011, 91, 1.0, '2022-01-17', 'poster-1787017855-425b47.png', '', 0, '2026-08-18 01:50:55'),
(120, 'Película', 'Zodiac', 'David Fincher', 2007, 157, 7.0, '2022-01-19', 'poster-1787018225-85166b.png', '', 0, '2026-08-18 01:57:05'),
(121, 'Película', 'Nosotros los Nobles', 'Gary Alazraki', 2013, 108, 8.0, '2022-01-19', 'poster-1787018270-3a2bcc.png', '', 0, '2026-08-18 01:57:50'),
(122, 'Serie', 'Euphoria', 'Sam Levinson', 2019, NULL, 8.0, '2022-01-20', 'poster-1787018310-7182a6.png', '', 0, '2026-08-18 01:58:30'),
(123, 'Película', 'The Suicide Squad', 'James Gunn', 2021, 132, 7.0, '2022-01-20', 'poster-1787018348-049003.png', '', 0, '2026-08-18 01:59:08'),
(124, 'Película', 'The Hateful Eight', 'Quentin Tarantino', 2015, 168, 7.0, '2022-01-23', 'poster-1787018381-c4292c.png', '', 0, '2026-08-18 01:59:41'),
(125, 'Película', 'The Shining', 'Stanley Kubrick', 1980, 146, 8.0, '2022-01-23', 'poster-1787018418-67fbfe.png', '', 0, '2026-08-18 02:00:18'),
(126, 'Película', 'Hop', 'Tim Hill', 2011, 95, 3.0, '2022-01-24', 'poster-1787018446-878598.png', '', 0, '2026-08-18 02:00:46'),
(127, 'Reality', 'The Final Table', '?', 2018, NULL, 7.0, '2022-01-24', 'poster-1787018558-cc8671.png', '', 0, '2026-08-18 02:02:38'),
(128, 'Película', 'Dumbo', 'Samuel Armstrong', 1941, 64, 10.0, '2022-01-25', 'poster-1787018603-e1ba4d.png', '', 1, '2026-08-18 02:03:23'),
(129, 'Película', 'El Crimen del Padre Amaro', 'Carlos Carrera', 2002, 118, 5.0, '2022-01-25', 'poster-1787018635-a191b2.png', '', 0, '2026-08-18 02:03:55'),
(130, 'Película', 'Five Feet Apart', 'Justin Baldoni', 2019, 116, 6.0, '2022-01-26', 'poster-1787018666-d55bbb.png', '', 0, '2026-08-18 02:04:26'),
(131, 'Película', 'The Witch', 'Robert Eggers', 2015, 92, 9.0, '2022-01-26', 'poster-1787018996-4460f1.png', '', 1, '2026-08-18 02:09:56'),
(132, 'Película', 'Miracles from Heaven', 'Patricia Riggen', 2016, 109, 7.0, '2022-01-26', 'poster-1787019030-8a3e48.png', '', 0, '2026-08-18 02:10:30'),
(133, 'Película', 'The Girl with the Dragon Tattoo', 'David Fincher', 2011, 158, 8.0, '2022-01-27', 'poster-1787019072-e3fed5.png', '', 0, '2026-08-18 02:11:12'),
(134, 'Película', 'The Angry Birds Movie', 'Clay Kaytis', 2016, 97, 4.0, '2022-01-27', 'poster-1787019115-0cee7a.png', '', 0, '2026-08-18 02:11:55'),
(135, 'Película', 'Chicuarotes', 'Gael García Bernal', 2019, 95, 9.0, '2022-01-27', 'poster-1787019148-f887e4.png', '', 1, '2026-08-18 02:12:28'),
(136, 'Película', 'The Karate Kid', 'Harald Zwart', 2010, 140, 6.0, '2022-01-28', 'poster-1787019190-81cfd5.png', '', 0, '2026-08-18 02:13:10'),
(137, 'Película', 'Héroe de Centro Comercial 2', 'Andy Fickman', 2015, 94, 1.0, '2022-01-30', 'poster-1787019221-cc2af5.png', '', 0, '2026-08-18 02:13:41'),
(138, 'Película', 'Worth', 'Sara Colangelo', 2020, 118, 8.0, '2022-01-30', 'poster-1787019255-ba5e95.png', '', 0, '2026-08-18 02:14:15'),
(139, 'Película', 'Los Juegos del Hambre', 'Gary Ross', 2012, 142, 7.0, '2022-02-02', 'poster-1787019305-3a5fa4.png', '', 0, '2026-08-18 02:15:05'),
(140, 'Película', 'Gone Girl', 'David Fincher', 2014, 149, 8.0, '2022-02-05', 'poster-1787019335-b0c6c7.png', '', 0, '2026-08-18 02:15:35'),
(141, 'Película', 'The Power of the Dog', 'Jane Campion', 2021, 126, 8.0, '2022-02-12', 'poster-1787019633-008344.png', '', 0, '2026-08-18 02:20:33'),
(142, 'Serie', 'Clickbait', 'Tony Ayres', 2021, NULL, 3.0, '2022-02-12', 'poster-1787019694-bbcb35.png', '', 0, '2026-08-18 02:21:34'),
(143, 'Película', 'Little Women', 'Greta Gerwig', 2019, 135, 9.0, '2022-02-14', 'poster-1787019729-9b8779.png', '', 1, '2026-08-18 02:22:09'),
(144, 'Película', 'After', 'Jenny Gage', 2019, 105, 3.0, '2022-02-14', 'poster-1787019761-da9dfe.png', '', 0, '2026-08-18 02:22:41'),
(145, 'Película', 'Call Me by Your Name', 'Luca Guadagnino', 2017, 132, 10.0, '2022-02-16', 'poster-1787019824-41a59c.png', '', 1, '2026-08-18 02:23:44'),
(146, 'Película', 'Pacific Rim', 'Guillermo del Toro', 2013, 131, 6.0, '2022-02-18', 'poster-1787019858-e0ec73.png', '', 0, '2026-08-18 02:24:18'),
(147, 'Serie', 'Escandalosos', 'Daniel Chong', 2014, NULL, 5.0, '2022-02-19', 'poster-1787019892-202ce1.png', '', 0, '2026-08-18 02:24:52'),
(148, 'Película', 'No sé si Cortarme las Venas o Dejármelas Largas', 'Manolo Caro', 2013, 103, 1.0, '2022-02-23', 'poster-1787019949-5d540f.png', '', 0, '2026-08-18 02:25:49'),
(149, 'Película', 'Teenage Mutant Ninja Turtles', 'Jonathan Liebesman', 2014, 101, 4.0, '2022-02-24', 'poster-1787020000-c0c3e6.png', '', 0, '2026-08-18 02:26:40'),
(150, 'Serie', 'The Cuphead Show', 'Dave Wasson', 2005, NULL, 6.0, '2022-02-26', 'poster-1787020045-23cda3.png', '', 0, '2026-08-18 02:27:25'),
(151, 'Película', 'Wall E', 'Andrew Stanton', 2008, 98, 9.0, '2022-02-28', 'poster-1787149221-71d09d.png', '', 1, '2026-08-19 14:20:21'),
(152, 'Película', 'After We Collided', 'Roger Kumble', 2020, 105, 2.0, '2022-03-01', 'poster-1787149253-84935f.png', '', 0, '2026-08-19 14:20:53'),
(153, 'Película', 'Jurassic Park', 'Steven Spielberg', 1993, 127, 8.0, '2022-03-02', 'poster-1787149289-23f3e8.png', '', 0, '2026-08-19 14:21:29'),
(154, 'Película', 'V for Vendetta', 'James McTelgue', 2005, 132, 9.0, '2022-03-04', 'poster-1787149326-796b35.png', '', 0, '2026-08-19 14:22:06'),
(155, 'Película', 'The Batman', 'Matt Reeves', 2022, 176, 10.0, '2022-03-06', 'poster-1787149364-538699.png', '', 1, '2026-08-19 14:22:44'),
(156, 'Película', 'Ex Machina', 'Alex Garland', 2014, 108, 8.0, '2022-03-08', 'poster-1787149405-47423a.png', '', 0, '2026-08-19 14:23:25'),
(157, 'Película', 'It\'s a Kind of a Funny Story', 'Anna Boden', 2010, 101, 7.0, '2022-03-10', 'poster-1787149443-1ae4a3.png', '', 0, '2026-08-19 14:24:03'),
(158, 'Película', 'Sueño en Otro Idioma', 'Ernesto Contreras', 2017, 103, 7.0, '2022-03-10', 'poster-1787149478-3afa52.png', '', 0, '2026-08-19 14:24:38'),
(159, 'Película', 'Turning Red', 'Domee Shi', 2022, 100, 7.0, '2022-03-11', 'poster-1787149513-8def7d.png', '', 0, '2026-08-19 14:25:13'),
(160, 'Película', 'Old', 'M. Night Shyamalan', 2021, 108, 6.0, '2022-03-14', 'poster-1787149544-d1b411.png', '', 0, '2026-08-19 14:25:44'),
(161, 'Serie', 'Merlí. Sapere Aude', 'Héctor Lozano', 2019, NULL, 8.0, '2022-03-15', 'poster-1787149839-b07f08.png', '', 0, '2026-08-19 14:30:39'),
(162, 'Película', 'After We Fell', 'Castille Landon', 2021, 98, 3.0, '2022-03-16', 'poster-1787149870-e99019.png', '', 0, '2026-08-19 14:31:10'),
(163, 'Película', 'No Eres Tú, Soy Yo', 'Alejandro Springall', 2010, 101, 5.0, '2022-03-18', 'poster-1787149906-f346f3.png', '', 0, '2026-08-19 14:31:46'),
(164, 'Película', 'Sully', 'Clint Eastwood', 2016, 96, 6.0, '2022-03-20', 'poster-1787149938-c81716.png', '', 0, '2026-08-19 14:32:18'),
(165, 'Serie', 'Scenes from a Marriage', 'Haigai Levi', 2021, NULL, 10.0, '2022-03-20', 'poster-1787149988-0bd15c.png', '', 1, '2026-08-19 14:33:08'),
(166, 'Película', 'Jujutsu Kaisen 0', 'Sunghoo Park', 2021, 112, 6.0, '2022-03-25', 'poster-1787150037-37a1d6.png', '', 0, '2026-08-19 14:33:57'),
(167, 'Película', 'The Space Between Us', 'Peter Chelsom', 2017, 120, 5.0, '2022-03-31', 'poster-1787150080-7c0e71.png', '', 0, '2026-08-19 14:34:40'),
(168, 'Película', 'The Truman Show', 'Peter Weir', 1998, 103, 9.0, '2022-04-04', 'poster-1787150112-27d4a4.png', '', 1, '2026-08-19 14:35:12'),
(169, 'Película', 'Durante la Tormenta', 'Oriol Paulo', 2018, 128, 8.0, '2022-04-09', 'poster-1787150158-ef183c.png', '', 0, '2026-08-19 14:35:58'),
(170, 'Película', 'Pokémon: Detective Pikachu', 'Rob Letterman', 2019, 104, 6.0, '2022-04-12', 'poster-1787150207-7f8165.png', '', 0, '2026-08-19 14:36:47'),
(171, 'Película', 'Midsommar', 'Ari Aster', 2019, 148, 10.0, '2022-04-13', 'poster-1787150509-6872a3.png', '', 1, '2026-08-19 14:41:49'),
(172, 'Película', '2001: A Space Odyssey', 'Stanley Kubrick', 1968, 149, 7.0, '2022-04-13', 'poster-1787150549-252d50.png', '', 0, '2026-08-19 14:42:29'),
(173, 'Película', 'Cosas Imposibles', 'Ernesto Contreras', 2021, 89, 10.0, '2022-04-15', 'poster-1787150592-8e144b.png', '', 1, '2026-08-19 14:43:12'),
(174, 'Película', 'Dunkirk', 'Christopher Nolan', 2017, 106, 8.0, '2022-04-15', 'poster-1787150633-9a0816.png', '', 0, '2026-08-19 14:43:53'),
(175, 'Película', '¿Qué Culpa Tiene el Niño?', 'Gustavo Loza', 2016, 105, 6.0, '2022-04-15', 'poster-1787150699-408ba8.png', '', 0, '2026-08-19 14:44:59'),
(176, 'Película', 'Riddick', 'David Twohy', 2013, 119, 6.0, '2022-04-16', 'poster-1787150736-67401a.png', '', 0, '2026-08-19 14:45:36'),
(177, 'Película', 'Choose or Die', 'Toby Meakins', 2022, 84, 4.0, '2022-04-17', 'poster-1787150773-d3e1f3.png', '', 0, '2026-08-19 14:46:13'),
(178, 'Película', 'Madres Paralelas', 'Pedro Almodóvar', 2021, 123, 7.0, '2022-04-17', 'poster-1787150812-33adf7.png', '', 0, '2026-08-19 14:46:52'),
(179, 'Película', 'The Green Knight', 'David Lowery', 2021, 130, 7.0, '2022-04-19', 'poster-1787150862-3195bf.png', '', 0, '2026-08-19 14:47:42'),
(180, 'Película', 'Death Note', 'Adam Wingard', 2017, 101, 1.0, '2022-04-21', 'poster-1787150894-f6c12d.png', '', 0, '2026-08-19 14:48:14'),
(181, 'Stand Up', 'Comedy Central Presenta: Al Cabo es Comedia', '?', 2019, 53, 5.0, '2022-04-21', 'poster-1787151274-c3c68e.png', '', 0, '2026-08-19 14:54:34'),
(182, 'Película', 'Chilangolandia', 'Carlos Santos', 2021, 93, 3.0, '2022-04-22', 'poster-1787151317-5f7fb1.png', '', 0, '2026-08-19 14:55:17'),
(183, 'Stand Up', 'Comedy Central Presenta: Machis Mis Huevos', '?', 2019, 49, 7.0, '2022-04-22', 'poster-1787151376-a5d58a.png', '', 0, '2026-08-19 14:56:16'),
(184, 'Serie', 'Inside the World\'s Toughest Prisons', '?', 2016, NULL, 7.0, '2022-04-23', 'poster-1787151422-89a41c.png', '', 0, '2026-08-19 14:57:02'),
(185, 'Película', 'The Two Popes', 'Fernando Meirelles', 2019, 125, 8.0, '2022-04-24', 'poster-1787151460-619f7b.png', '', 0, '2026-08-19 14:57:40'),
(186, 'Película', 'Megamente', 'Tom McGrath', 2010, 95, 9.0, '2022-04-24', 'poster-1787151512-7c0c28.png', '', 1, '2026-08-19 14:58:32'),
(187, 'Stand Up', 'Comedy Central Presenta: No Somos Princesas', '?', 2019, 55, 6.0, '2022-04-24', 'poster-1787151554-dbf4a7.png', '', 0, '2026-08-19 14:59:14'),
(188, 'Película', 'The Killing of a Sacred Deer', 'Yorgos Lanthimos', 2017, 121, 10.0, '2022-04-25', 'poster-1787151589-f149dc.png', '', 1, '2026-08-19 14:59:49'),
(189, 'Película', 'Nocturnal Animals', 'Tom Ford', 2016, 116, 9.0, '2022-04-27', 'poster-1787151633-1fe36f.png', '', 0, '2026-08-19 15:00:33'),
(190, 'Película', 'Sonic the Hedgehog', 'Jeff Fowler', 2020, 99, 7.0, '2022-05-02', 'poster-1787152074-67a52a.png', '', 0, '2026-08-19 15:07:54'),
(191, 'Película', 'Sonic the Hedgehog 2', 'Jeff Fowler', 2020, 99, 8.0, '2022-05-02', 'poster-1787152428-9dad38.png', '', 0, '2026-08-19 15:13:48'),
(192, 'Película', 'Doctor Strange in the Multiverse of Madness', 'Sam Raimi', 2022, 126, 8.0, '2022-05-04', 'poster-1787152479-44c7ca.png', '', 0, '2026-08-19 15:14:39'),
(193, 'Serie', 'Moon Knight', 'Jeremy Slater', 2022, NULL, 7.0, '2022-05-04', 'poster-1787152512-44585a.png', '', 0, '2026-08-19 15:15:12'),
(194, 'Película', 'The Do-Over', 'Steven Brill', 2016, 108, 5.0, '2022-05-08', 'poster-1787152542-df3e65.png', '', 0, '2026-08-19 15:15:42'),
(195, 'Película', 'No Time to Die', 'Cary Joji Fukunaga', 2021, 163, 7.0, '2022-05-08', 'poster-1787152572-0b53ed.png', '', 0, '2026-08-19 15:16:12'),
(196, 'Película', 'A Clockwork Orange', 'Stanley Kubrick', 1971, 136, 9.0, '2022-05-09', 'poster-1787152604-d47ffc.png', '', 0, '2026-08-19 15:16:44'),
(197, 'Serie', 'Bar Central', '?', 2016, NULL, 8.0, '2022-05-10', 'poster-1787152641-65bec0.png', '', 0, '2026-08-19 15:17:21'),
(198, 'Película', 'Las Ventajas de Ser Invisible', 'Stephen Chbosky', 2012, 103, 7.0, '2022-05-11', 'poster-1787152697-ce9653.png', '', 0, '2026-08-19 15:18:17'),
(199, 'Película', 'Cuarentones', 'Pietro Loprieno', 2022, 81, 3.0, '2022-05-12', 'poster-1787152737-c4731a.png', '', 0, '2026-08-19 15:18:57'),
(200, 'Película', 'Parasite', 'Bong Joon-Ho', 2019, 132, 10.0, '2022-05-13', 'poster-1787152770-c68b97.png', '', 1, '2026-08-19 15:19:30'),
(201, 'Película', 'Godzilla: King of the Monsters', 'Michael Dougherty', 2019, 132, 5.0, '2022-05-15', 'poster-1787620039-f67ced.png', '', 0, '2026-08-25 01:07:19'),
(202, 'Película', 'Iron Man 2', 'Jon Favreau', 2010, 124, 7.0, '2022-05-19', 'poster-1787620067-54265e.png', '', 0, '2026-08-25 01:07:47'),
(203, 'Película', 'Intensamente', 'Pete Docter', 2015, 95, 10.0, '2022-05-19', 'poster-1787620193-9601f7.png', '', 1, '2026-08-25 01:09:53'),
(204, 'Documental', 'Pixar in Real Life', 'Erika J. Wood', 2019, NULL, 5.0, '2022-05-19', 'poster-1787620235-2748f7.png', '', 0, '2026-08-25 01:10:35'),
(205, 'Película', 'Life of Pi', 'Ang Lee', 2012, 127, 8.0, '2022-04-20', 'poster-1787620268-611ae7.png', '', 0, '2026-08-25 01:11:08'),
(206, 'Stand Up', 'Alan Saldaña: Mi vida de pobre', 'Raúl Campos', 2017, 70, 4.0, '2022-05-22', 'poster-1787620320-12b427.png', '', 0, '2026-08-25 01:12:00'),
(207, 'Cortometraje', 'Party Cloudy', 'Peter Sohn', 2009, 6, 8.0, '2022-05-23', 'poster-1787620354-4fd67d.png', '', 0, '2026-08-25 01:12:34'),
(208, 'Documental', 'Inside Pixar', 'W. Kamau Bell', 2020, NULL, 7.0, '2022-05-23', 'poster-1787620632-a09457.png', '', 0, '2026-08-25 01:17:12'),
(209, 'Película', 'Franco Escamilla: Por la anécdota', 'Ulises Valencia', 2018, 66, 5.0, '2022-05-25', 'poster-1787620666-4da7cf.png', '', 0, '2026-08-25 01:17:46'),
(210, 'Película', 'The Franch Dispatch', 'Wes Anderson', 2021, 107, 8.0, '2022-05-27', 'poster-1787620705-e231fd.png', '', 0, '2026-08-25 01:18:25'),
(211, 'Stand Up', 'Daniel Sosa: Sosafado', 'Raúl Campos', 2017, 77, 3.0, '2022-05-30', 'poster-1787621042-784b82.png', '', 0, '2026-08-25 01:24:02'),
(212, 'Película', 'Ralph El Demoledor', 'Rich Moore', 2012, 101, 8.0, '2022-06-01', 'poster-1787621078-cc564f.png', '', 0, '2026-08-25 01:24:38'),
(213, 'Documental', 'The Social Dilemma', 'Jeff Orlowski-Yang', 2020, 94, 8.0, '2022-06-02', 'poster-1787621130-33217d.png', '', 0, '2026-08-25 01:25:30'),
(214, 'Stand Up', 'Franco Escamilla: Bienvenido al Mundo', 'Ulises Valencia', 2019, 54, 6.0, '2022-06-02', 'poster-1787621173-0302c6.png', '', 0, '2026-08-25 01:26:13'),
(215, 'Película', 'Jurassic World: Dominion', 'Colin Trevorrow', 2022, 147, 6.0, '2022-06-03', 'poster-1787621207-740898.png', '', 0, '2026-08-25 01:26:47'),
(216, 'Stand Up', 'Coco y Raulito: Carrusel de ternura', 'Raúl Campos', 2018, 56, 7.0, '2022-06-04', 'poster-1787621264-9b59c2.png', '', 0, '2026-08-25 01:27:44'),
(217, 'Película', 'Lava', 'James Ford Murphy', 2014, 7, 7.0, '2022-06-05', 'poster-1787621291-3429c2.png', '', 0, '2026-08-25 01:28:11'),
(218, 'Película', 'Río 2', 'Carlos Saldanha', 2014, 101, 6.0, '2022-06-05', 'poster-1787621320-543e6a.png', '', 0, '2026-08-25 01:28:40'),
(219, 'Película', 'Jojo Rabbit', 'Taika Waititi', 2019, 108, 10.0, '2022-06-08', 'poster-1787621348-29289a.png', '', 1, '2026-08-25 01:29:08'),
(220, 'Película', 'Sicario', 'Denis Villeneuve', 2015, 121, 8.0, '2022-06-08', 'poster-1787621375-447f0e.png', '', 0, '2026-08-25 01:29:35'),
(221, 'Stand Up', 'Daniel Sosa: Maleducado', 'Marcos Bucay', 2019, 54, 4.0, '2022-06-10', 'poster-1787621903-37f576.png', '', 0, '2026-08-25 01:38:23'),
(222, 'Serie', 'Peacemaker', 'James Gunn', 2022, NULL, 8.0, '2022-06-15', 'poster-1787621931-be7c47.png', '', 0, '2026-08-25 01:38:51'),
(223, 'Película', 'The Northman', 'Robert Eggers', 2022, 137, 8.0, '2022-06-16', 'poster-1787621976-34fd51.png', '', 0, '2026-08-25 01:39:36'),
(224, 'Película', 'Everything Everywhere All at Once', 'Daniel Kwan', 2022, 139, 10.0, '2022-06-17', 'poster-1787622037-1f545b.png', '', 1, '2026-08-25 01:40:37'),
(225, 'Stand Up', 'Alexis de Anda: Mea Culpa', 'Raúl Campos', 2017, 60, 5.0, '2022-06-18', 'poster-1787622076-b1b256.png', '', 0, '2026-08-25 01:41:16'),
(226, 'Película', 'Pinocchio', 'Robert Zemeckis', 2022, 105, 4.0, '2022-09-16', 'poster-1787626363-756876.png', '', 0, '2026-08-25 01:41:46'),
(227, 'Película', 'The Lighthouse', 'Robert Eggers', 2019, 109, 8.0, '2022-06-20', 'poster-1787622123-508817.png', '', 0, '2026-08-25 01:42:03'),
(228, 'Película', 'Lluvia de Hamburguesas', 'Phil Lord', 2009, 90, 7.0, '2022-06-22', 'poster-1787622191-593534.png', '', 0, '2026-08-25 01:43:11'),
(229, 'Stand Up', 'Lokillo: Nada es Igual', 'Julian Gaviria', 2021, 63, 6.0, '2022-06-22', 'poster-1787622268-b8cbbb.png', '', 0, '2026-08-25 01:44:28'),
(230, 'Stand Up', 'Dave Chappelle: The Closer', 'Stan Lathan', 2021, 72, 7.0, '2022-06-23', 'poster-1787622301-222524.png', '', 0, '2026-08-25 01:45:01'),
(231, 'Serie', 'Mr. Iglesias', 'Kevin Hench', 2019, NULL, 7.0, '2022-06-23', 'poster-1787622387-d899c3.png', '', 0, '2026-08-25 01:46:27'),
(232, 'Película', 'Spider-Man: Into the Spider-Verse', 'Bob Persichetti', 2018, 117, 10.0, '2022-06-25', 'poster-1787622435-5c3761.png', '', 1, '2026-08-25 01:47:15'),
(233, 'Película', 'Top Gun: Maverick', 'Joseph Kosinski', 2022, 130, 7.0, '2022-06-27', 'poster-1787622464-89bf2b.png', '', 0, '2026-08-25 01:47:44'),
(234, 'Stand Up', 'Alex Fernández: El Mejor Comediante del Mundo', 'Alex Díaz', 2020, 51, 5.0, '2022-06-27', 'poster-1787622505-5fa6ec.png', '', 0, '2026-08-25 01:48:25'),
(235, 'Película', 'Chip \'n Dale: Rescue Rangers', 'Akiva Schaffer', 2022, 97, 8.0, '2022-06-30', 'poster-1787622544-f091c2.png', '', 0, '2026-08-25 01:49:04'),
(236, 'Película', 'Minions', 'Pierre Coffin', 2015, 91, 7.0, '2022-07-01', 'poster-1787622578-6c76f4.png', '', 0, '2026-08-25 01:49:38'),
(237, 'Película', 'Minions: The Rise of Gru', 'Brad Ableson', 2022, 87, 8.0, '2022-07-02', 'poster-1787622620-215b97.png', '', 0, '2026-08-25 01:50:20'),
(238, 'Reality', 'Zumbo\'s Just Desserts', 'Adriano Zumbo', 2016, NULL, 8.0, '2022-07-02', 'poster-1787622669-293ed2.png', '', 0, '2026-08-25 01:51:09'),
(239, 'Stand Up', 'Ricardo O\'Farrill: Abrazo Navideño', 'Raúl Campos', 2016, 31, 6.0, '2022-07-04', 'poster-1787622982-13a577.png', '', 0, '2026-08-25 01:56:22'),
(240, 'Serie', 'Daredevil', 'Drew Goddard', 2015, NULL, 9.0, '2022-07-06', 'poster-1787623015-ab98b1.png', '', 0, '2026-08-25 01:56:55'),
(241, 'Película', 'Joker', 'Todd Phillips', 2019, 122, 10.0, '2022-07-06', 'poster-1787623396-ffd570.png', '', 1, '2026-08-25 02:03:16'),
(242, 'Película', 'Thor: Love and Thunder', 'Taika Waititi', 2022, 118, 8.0, '2022-07-07', 'poster-1787623427-3940e4.png', '', 0, '2026-08-25 02:03:47'),
(243, 'Serie', 'Control Z', 'Miguel García Moreno', 2020, NULL, 5.0, '2022-07-11', 'poster-1787623464-092413.png', '', 0, '2026-08-25 02:04:24'),
(244, 'Serie', 'Marchday: Inside FC Barcelona', '?', 2019, NULL, 7.0, '2022-07-11', 'poster-1787623504-ff8212.png', '', 0, '2026-08-25 02:05:04'),
(245, 'Película', 'Lilo & Stitch', 'Dean DeBlois', 2002, 85, 7.0, '2022-07-14', 'poster-1787623549-893181.png', '', 0, '2026-08-25 02:05:49'),
(246, 'Película', 'Los Increíbles', 'Brad Bird', 2004, 115, 9.0, '2022-07-15', 'poster-1787623585-8167e0.png', '', 1, '2026-08-25 02:06:25'),
(247, 'Película', 'Los Increíbles 2', 'Brad Bird', 2018, 118, 7.0, '2022-07-16', 'poster-1787623631-b6958e.png', '', 0, '2026-08-25 02:07:11'),
(248, 'Película', 'Vivarium', 'Lorcan Finnegan', 2019, 97, 7.0, '2022-07-16', 'poster-1787623666-9b0dec.png', '', 0, '2026-08-25 02:07:46'),
(249, 'Película', 'Elvis', 'Baz Luhrmann', 2022, 159, 5.0, '2022-07-17', 'poster-1787623693-f4230d.png', '', 0, '2026-08-25 02:08:13'),
(250, 'Película', 'The Godfather', 'Francis Ford Coppola', 1972, 175, 8.0, '2022-07-19', 'poster-1787623723-2df0c6.png', '', 0, '2026-08-25 02:08:43'),
(251, 'Película', 'Blair WItch', 'Adam Wingard', 2016, 89, 1.0, '2022-07-20', 'poster-1787626005-07cf62.png', '', 0, '2026-08-25 02:46:45'),
(252, 'Película', 'Moonlight', 'Barry Jenkins', 2016, 111, 8.0, '2022-08-02', 'poster-1787626034-856735.png', '', 0, '2026-08-25 02:47:14'),
(253, 'Película', 'Nomadland', 'Chloé Zhao', 2020, 107, 8.0, '2022-08-10', 'poster-1787626063-165785.png', '', 0, '2026-08-25 02:47:43'),
(254, 'Serie', 'Breaking Bad', 'Vince Gilligan', 2008, NULL, 10.0, '2022-08-14', 'poster-1787626092-7c751c.png', '', 1, '2026-08-25 02:48:12'),
(255, 'Serie', 'Better Call Saul', 'Vince Gilligan', 2015, NULL, 10.0, '2022-08-16', 'poster-1787626119-e2edd9.png', '', 1, '2026-08-25 02:48:39'),
(256, 'Película', 'Aquaman', 'James Wan', 2018, 143, 6.0, '2022-08-21', 'poster-1787626148-20e2ab.png', '', 0, '2026-08-25 02:49:08'),
(257, 'Película', 'Nope', 'Jordan Peele', 2022, 130, 8.0, '2022-08-27', 'poster-1787626174-505c23.png', '', 0, '2026-08-25 02:49:34'),
(258, 'Película', 'Venom: Let There Be Carnage', 'Andy Serkis', 2021, 97, 4.0, '2022-08-29', 'poster-1787626205-f5d77a.png', '', 0, '2026-08-25 02:50:05'),
(259, 'Película', 'Fragmentado', 'M. Night Shyamalan', 2016, 117, 9.0, '2022-08-30', 'poster-1787626235-54dbbb.png', '', 1, '2026-08-25 02:50:35'),
(260, 'Serie', 'Club de Cuervos', 'Gary Alazraki', 2015, NULL, 9.0, '2022-09-06', 'poster-1787626272-c6edb1.png', '', 0, '2026-08-25 02:51:12'),
(261, 'Película', 'Dragon Ball Super: Super Hero', 'Tetsuro Kodama', 2022, 100, 5.0, '2022-09-10', 'poster-1787626329-66edcc.png', '', 0, '2026-08-25 02:52:09'),
(262, 'Película', 'Get Out', 'Jordan Peele', 2017, 104, 9.0, '2022-09-16', 'poster-1787626386-5aae53.png', '', 0, '2026-08-25 02:53:06'),
(263, 'Película', 'Les Misérables', 'Tom Hooper', 2012, 158, 8.0, '2022-09-18', 'poster-1787626422-9c4539.png', '', 0, '2026-08-25 02:53:42'),
(264, 'Stand Up', 'Fabrizio Copano: Solo pienso en mí', 'Francisco Schultz', 2017, 60, 8.0, '2022-09-18', 'poster-1787626463-14d0cc.png', '', 0, '2026-08-25 02:54:23'),
(265, 'Película', 'Don\'t Worry Darling', 'Olivia Wilde', 2022, 123, 7.0, '2022-10-02', 'poster-1787626498-1bf1ba.png', '', 0, '2026-08-25 02:54:58'),
(266, 'Serie', 'House of the Dragon', 'Ryan J. Condal', 2022, NULL, 9.0, '2022-10-24', 'poster-1787626566-f8ae48.png', '', 0, '2026-08-25 02:56:06'),
(267, 'Stand Up', 'Franco Escamilla: Voyerista Auditivo', 'Claude Shires', 2022, 122, 7.0, '2022-10-25', 'poster-1787626622-c6df43.png', '', 0, '2026-08-25 02:57:02'),
(268, 'Serie', 'Belascoarán', 'Rodrigo Santos', 2022, NULL, 7.0, '2022-10-30', 'poster-1787626651-f92b07.png', '', 0, '2026-08-25 02:57:31'),
(269, 'Stand Up', 'Gabriel Iglesias: Stadium Fluffy', 'Manny Rodríguez', 2022, 115, 8.0, '2022-11-02', 'poster-1787626702-1daa63.png', '', 0, '2026-08-25 02:58:22'),
(270, 'Documental', 'Club América vs Club América', '?', 2022, NULL, 7.0, '2022-11-07', 'poster-1787627299-674b2f.png', '', 0, '2026-08-25 03:08:19'),
(271, 'Película', 'Black Panther: Wakanda Forever', 'Ryan Coogler', 2022, 161, 7.0, '2022-11-12', 'poster-1787627338-22f005.png', '', 0, '2026-08-25 03:08:58'),
(272, 'Serie', 'I Am Groot', '?', 2022, NULL, 5.0, '2022-11-30', 'poster-1787627372-d3693a.png', '', 0, '2026-08-25 03:09:32'),
(273, 'Cortometraje', 'The Guardians of the Galaxy Holiday Special', 'James Gunn', 2022, 42, 7.0, '2022-11-30', 'poster-1787627445-2f0b93.png', '', 0, '2026-08-25 03:10:45'),
(274, 'Película', 'Avatar', 'James Cameron', 2009, 162, 7.0, '2022-12-10', 'poster-1787627491-c69f71.png', '', 0, '2026-08-25 03:11:31'),
(275, 'Película', 'Bones and All', 'Luca Guadagnino', 2022, 131, 6.0, '2022-12-11', 'poster-1787627836-d8de35.png', '', 0, '2026-08-25 03:17:16'),
(276, 'Película', 'Pinocho', 'Norman Fergusson', 1940, 88, 8.0, '2022-06-19', NULL, '', 0, '2026-08-25 03:22:40'),
(277, 'Stand Up', 'Carlos Ballarta: Falso Profeta', 'Raúl Campos', 2021, 63, 8.0, '2022-12-13', 'poster-1787628210-b0504b.png', '', 0, '2026-08-25 03:23:30'),
(278, 'Stand Up', 'Ricardo Quevedo: Hay gente así', 'Raúl Campos', 2018, 59, 7.0, '2022-12-15', 'poster-1787628250-4911a3.png', '', 0, '2026-08-25 03:24:10'),
(279, 'Película', 'Avatar: The Way of Water', 'James Cameron', 2022, 192, 8.0, '2022-12-15', 'poster-1787628304-df9350.png', '', 0, '2026-08-25 03:25:04'),
(280, 'Stand Up', 'Carlos Ballarta: El Amor es de Putos', 'Raúl Campos', 2016, 67, 8.0, '2022-12-18', 'poster-1787628348-4c1ce9.png', '', 0, '2026-08-25 03:25:48'),
(281, 'Película', 'Guillermo del Toro\'s Pinnochio', 'Guillermo del Toro', 2022, 117, 9.0, '2022-12-20', 'poster-1787628411-391e1b.png', '', 0, '2026-08-25 03:26:51'),
(282, 'Película', 'Yo, Adolescente', 'Lucas Santa Ana', 2019, 97, 5.0, '2022-12-21', 'poster-1787628438-def231.png', '', 0, '2026-08-25 03:27:18'),
(283, 'Stand Up', 'Ricardo Quevedo: Los Amargados Somos Más', '?', 2019, 58, 5.0, '2022-12-22', 'poster-1787628475-918c6c.png', '', 0, '2026-08-25 03:27:55'),
(284, 'Cortometraje', 'Myth: A Frozen Tale', 'Jeff Gipson', 2019, 8, 4.0, '2022-12-24', 'poster-1787628515-73d404.png', '', 0, '2026-08-25 03:28:35'),
(285, 'Cortometraje', 'Bao', 'Domee Shi', 2018, 8, 9.0, '2022-12-24', 'poster-1787628550-99b601.png', '', 1, '2026-08-25 03:29:10'),
(286, 'Cortometraje', 'Piper', 'Alan Barillaro', 2016, 6, 9.0, '2022-12-24', 'poster-1787628951-92448a.png', '', 1, '2026-08-25 03:35:51'),
(287, 'Cortometraje', 'Purl', 'Kristen Lester', 2018, 8, 10.0, '2022-12-24', 'poster-1787628987-fcbde8.png', '', 1, '2026-08-25 03:36:27'),
(288, 'Cortometraje', 'Float', 'Bobby Rubio', 2018, 7, 7.0, '2022-12-24', 'poster-1787629026-2d6d37.png', '', 0, '2026-08-25 03:37:06'),
(289, 'Cortometraje', 'Presto', 'Doug Sweetland', 2008, 5, 7.0, '2022-12-24', 'poster-1787629066-7a8b66.png', '', 0, '2026-08-25 03:37:46'),
(290, 'Película', 'Cómo Ser un Latin Lover', 'Ken Marino', 2017, 115, 6.0, '2022-12-24', 'poster-1787629095-813b14.png', '', 0, '2026-08-25 03:38:15'),
(291, 'Cortometraje', 'Headspace: Unwind Your Mind', '?', 2021, 15, 7.0, '2022-12-24', 'poster-1787629130-871b0a.png', '', 0, '2026-08-25 03:38:50'),
(292, 'Stand Up', 'Zona Rosa', '?', 2019, NULL, 6.0, '2022-12-27', 'poster-1787629171-6a6491.png', '', 0, '2026-08-25 03:39:31'),
(293, 'Stand Up', 'El Especial de Alex Fernández', 'Raúl Campos', 2017, 52, 7.0, '2022-12-27', 'poster-1787629217-9418cd.png', '', 0, '2026-08-25 03:40:17'),
(294, 'Documental', 'FIFA Uncovered', '?', 2022, NULL, 8.0, '2022-12-30', 'poster-1787629257-6233d2.png', '', 0, '2026-08-25 03:40:57'),
(295, 'Película', 'Triangle of Sadness', 'Ruben Ostlund', 2022, 147, 10.0, '2022-12-31', 'poster-1787629291-247d03.png', '', 1, '2026-08-25 03:41:31'),
(296, 'Película', 'Lightyear', 'Angus McLane', 2022, 106, 2.0, '2023-01-01', 'poster-1787629339-7c77e9.png', '', 0, '2026-08-25 03:42:19'),
(297, 'Stand Up', 'Capi Pérez: Elotes para Todos', '?', 2022, 62, 1.0, '2023-01-01', 'poster-1787629375-ae841c.png', '', 0, '2026-08-25 03:42:55'),
(298, 'Serie', 'Élite', 'Carlos Montero', 2018, NULL, 5.0, '2023-01-04', 'poster-1787629402-dc9652.png', '', 0, '2026-08-25 03:43:22'),
(299, 'Película', 'La La Land', 'Damien Chazelle', 2016, 128, 8.0, '2023-01-07', 'poster-1787629431-08d18c.png', '', 0, '2026-08-25 03:43:51'),
(300, 'Stand Up', 'Sofía Niño de Rivera: Selección Natural', 'Raúl Campos', 2018, 62, 6.0, '2023-01-18', 'poster-1787629467-3bb3ef.png', '', 0, '2026-08-25 03:44:27'),
(301, 'Película', 'Decision to Leave', 'Park Chan-wook', 2022, 139, 7.0, '2023-01-21', 'poster-1787851167-a65a89.png', '', 0, '2026-08-27 17:19:27'),
(302, 'Película', 'The Fabelmans', 'Steven Spielberg', 2022, 151, 9.0, '2023-01-29', 'poster-1787851231-0b6bab.png', '', 0, '2026-08-27 17:20:31'),
(303, 'Serie', 'Smiley', 'Guillem Clua', 2022, NULL, 6.0, '2023-02-03', 'poster-1787851269-0d5096.png', '', 0, '2026-08-27 17:21:09'),
(304, 'Película', 'Ant-Man and the Wasp: Quantumania', 'Peyton Reed', 2023, 124, 7.0, '2023-02-15', 'poster-1787851329-16e034.png', '', 0, '2026-08-27 17:22:09'),
(305, 'Cortometraje', 'Cuerdas', 'Pedro Solís García', 2014, 10, 7.0, '2023-02-18', 'poster-1787851369-4e1d9f.png', '', 0, '2026-08-27 17:22:49'),
(306, 'Película', 'Tár', 'Todd Field', 2022, 158, 9.0, '2023-02-28', 'poster-1787851423-51e64c.png', '', 1, '2026-08-27 17:23:43'),
(307, 'Película', 'The Whale', 'Darren Aronofsky', 2022, 117, 8.0, '2023-03-01', 'poster-1787851464-3bd687.png', '', 0, '2026-08-27 17:24:24'),
(308, 'Serie', 'The Last of Us', 'Neil Druckmann', 2023, NULL, 9.0, '2023-03-15', 'poster-1787851503-a87858.png', '', 0, '2026-08-27 17:25:03'),
(309, 'Película', 'Creed III', 'Michael B. Jordan', 2023, 116, 6.0, '2023-03-20', 'poster-1787851535-673719.png', '', 0, '2026-08-27 17:25:35'),
(310, 'Stand Up', 'Chris Rock: Selective Outrage', 'Joel Gallen', 2023, 69, 6.0, '2023-04-03', 'poster-1787851574-d9cb69.png', '', 0, '2026-08-27 17:26:14'),
(311, 'Película', 'Inside', 'Vasilis Katsoupis', 2023, 105, 7.0, '2023-04-09', 'poster-1787869552-c77ea3.png', '', 0, '2026-08-27 22:25:52'),
(312, 'Película', 'Guardians of the Galaxy Vol. 3', 'James Gunn', 2023, 150, 8.0, '2023-05-03', 'poster-1787869596-041a68.png', '', 0, '2026-08-27 22:26:36'),
(313, 'Documental', 'MH370: The Plane That Disappeared', '?', 2023, NULL, 6.0, '2023-05-07', 'poster-1787869639-2fa039.png', '', 0, '2026-08-27 22:27:19'),
(314, 'Documental', 'Stutz', 'Jonah Hill', 2022, 96, 7.0, '2023-05-07', 'poster-1787869679-4b4adc.png', '', 0, '2026-08-27 22:27:59'),
(315, 'Documental', 'Hecho en México', 'Duncan Bridgeman', 2012, 98, 3.0, '2023-05-17', 'poster-1787869725-609fd4.png', '', 0, '2026-08-27 22:28:45'),
(316, 'Documental', 'Bob Ross: Happy Accidents, Betrayal & Greed', 'Joshua Rofé', 2021, 92, 5.0, '2023-05-19', 'poster-1787869770-96dc43.png', '', 0, '2026-08-27 22:29:30'),
(317, 'Cortometraje', 'A Tale of Two Kitchens', 'Trisha Ziff', 2019, 29, 5.0, '2023-05-20', 'poster-1787869811-567092.png', '', 0, '2026-08-27 22:30:11'),
(318, 'Película', 'The Super Mario Bros Movie', 'Aaron Horvath', 2023, 92, 7.0, '2023-05-20', 'poster-1787869849-f9d832.png', '', 0, '2026-08-27 22:30:49'),
(319, 'Documental', 'Ayotzinapa, El paso de la Tortuga', 'Enrique García Meza', 2018, 80, 6.0, '2023-05-20', 'poster-1787869893-5e8faa.png', '', 0, '2026-08-27 22:31:33'),
(320, 'Documental', 'The Tinder Swindler', 'Felicity Morris', 2022, 114, 7.0, '2023-05-22', 'poster-1787869929-229e48.png', '', 0, '2026-08-27 22:32:09'),
(321, 'Película', 'White Noise', 'Noah Baumbach', 2022, 136, 4.0, '2023-05-23', 'poster-1787870406-6219be.png', '', 0, '2026-08-27 22:40:06'),
(322, 'Documental', 'Ghislaine Maxwell', 'Maiken Baird', 2022, 101, 8.0, '2023-05-24', 'poster-1787870498-e0683b.png', '', 0, '2026-08-27 22:41:38'),
(323, 'Serie', 'La Divina Gula', '?', 2022, NULL, 9.0, '2023-05-24', 'poster-1787870539-8218b9.png', '', 0, '2026-08-27 22:42:19'),
(324, 'Serie', 'Sam & Cat', 'Dan Schneider', 2013, NULL, 6.0, '2023-05-28', 'poster-1787870568-71f23d.png', '', 0, '2026-08-27 22:42:48'),
(325, 'Documental', 'American Murder: The Family Next Door', 'Jenny Popplewell', 2020, 83, 7.0, '2023-06-04', 'poster-1787870621-0a8b2e.png', '', 0, '2026-08-27 22:43:41'),
(326, 'Película', 'Spider-Man: Across the Spider-Verse', 'Justin K. Thompson', 2023, 140, 9.0, '2023-06-11', 'poster-1787870662-02b66a.png', '', 0, '2026-08-27 22:44:22'),
(327, 'Reality', 'Ultimate Beastmaster', 'David Broome', 2017, NULL, 7.0, '2023-06-13', 'poster-1787870700-ae8f09.png', '', 0, '2026-08-27 22:45:00'),
(328, 'Película', 'The Human Centipede 2', 'Tom Six', 2011, 91, 1.0, '2023-06-13', 'poster-1787870729-12c06c.png', '', 0, '2026-08-27 22:45:29'),
(329, 'Stand Up', 'Bill Burr: Live at Red Rocks', 'Mike Binder', 2022, 82, 4.0, '2023-06-14', 'poster-1787870768-d4224f.png', '', 0, '2026-08-27 22:46:08'),
(330, 'Película', 'Fast X', 'Louis Leterrier', 2023, 141, 3.0, '2023-06-20', 'poster-1787870796-bc4eb1.png', '', 0, '2026-08-27 22:46:36'),
(331, 'Película', 'The Flash', 'Andy Muschietti', 2023, 144, 6.0, '2023-06-20', 'poster-1787871302-088fc6.png', '', 0, '2026-08-27 22:55:02'),
(332, 'Stand Up', 'Alan Saldaña: Encarcelado', 'Alex Díaz', 2021, 49, 2.0, '2023-06-22', 'poster-1787871334-765382.jpg', '', 0, '2026-08-27 22:55:34'),
(333, 'Stand Up', 'Carlos Ballarta: Furia Ñera', 'Raúl Campos', 2018, 62, 7.0, '2023-06-22', 'poster-1787871352-a2fc45.png', '', 0, '2026-08-27 22:55:52'),
(334, 'Cortometraje', 'If Anything Happens I Love You', 'Michael Govier', 2020, 13, 9.0, '2023-06-22', 'poster-1787871431-f38c4d.png', '', 1, '2026-08-27 22:57:11'),
(335, 'Cortometraje', 'Canvas', 'Frank E. Abney III', 2022, 9, 8.0, '2023-06-27', 'poster-1787871463-075ebc.png', '', 0, '2026-08-27 22:57:43'),
(336, 'Documental', 'Rubius X', 'Pedro Ample', 2022, 76, 7.0, '2023-06-27', 'poster-1787871559-20acaa.png', '', 0, '2026-08-27 22:59:19'),
(337, 'Película', 'Batman: The Dark Knight Returns, Part 1', 'Jay Oliva', 2012, 76, 7.0, '2023-06-28', 'poster-1787871629-130520.png', '', 0, '2026-08-27 23:00:29'),
(338, 'Película', 'Batman: The Dark Knight Returns, Part 2', 'Jay Oliva', 2013, 76, 7.0, '2023-06-29', 'poster-1787871722-a6fcd0.png', '', 0, '2026-08-27 23:02:02'),
(339, 'Cortometraje', 'Forgive Us Our Trespasses', 'Ashley Eakin', 2022, 13, 7.0, '2023-06-29', 'poster-1787871764-be6766.png', '', 0, '2026-08-27 23:02:44');

INSERT INTO `peliculas_series` (`id`, `categoria`, `titulo`, `autor`, `anio`, `duracion`, `nota`, `fecha_vista`, `poster`, `comentario`, `seleccion`, `creado`) VALUES
(340, 'Película', 'Hereditary', 'Ari Aster', 2018, 127, 8.0, '2023-07-03', 'poster-1787871814-a637f6.png', '', 0, '2026-08-27 23:03:34'),
(341, 'Película', 'Arrival', 'Denis Villeneuve', 2016, 116, 10.0, '2023-07-07', 'poster-1787872251-8075a9.png', '', 1, '2026-08-27 23:10:51'),
(342, 'Stand Up', 'Liss Pereira: Adulto Promedio', 'Julio César Gaviria', 2022, 63, 4.0, '2023-07-08', 'poster-1787872294-979a73.png', '', 0, '2026-08-27 23:11:34'),
(343, 'Película', 'The Revenant', 'Alejandro G. Iñárritu', 2015, 156, 7.0, '2023-07-09', 'poster-1787872329-083150.png', '', 0, '2026-08-27 23:12:09'),
(344, 'Película', 'Alex Strangelove', 'Craig Johnson', 2018, 99, 6.0, '2023-07-10', 'poster-1787872365-757370.png', '', 0, '2026-08-27 23:12:45'),
(345, 'Película', 'The Lobster', 'Yorgos Lanthimos', 2015, 119, 7.0, '2023-07-12', 'poster-1787872398-c51cf2.png', '', 0, '2026-08-27 23:13:18'),
(346, 'Película', 'Mission: Impossible - Dead Reckoning Part One', 'Cristopher McQuarrie', 2023, 163, 8.0, '2023-07-14', 'poster-1787872442-dd961d.png', '', 0, '2026-08-27 23:14:02'),
(347, 'Película', 'Oppenheimer', 'Christopher Nolan', 2023, 180, 9.0, '2023-07-24', 'poster-1787872636-1c9bad.png', '', 0, '2026-08-27 23:17:16'),
(348, 'Película', 'Un Lugar en Silencio II', 'John Krasinski', 2020, 97, 8.0, '2023-07-25', 'poster-1787872700-68b7b0.png', '', 0, '2026-08-27 23:18:20'),
(349, 'Documental', 'La Dama del Silencio: El Caso Mataviejitas', 'María José Cuevas', 2023, 111, 7.0, '2023-07-28', 'poster-1787872751-1fe714.png', '', 0, '2026-08-27 23:19:11'),
(350, 'Película', 'Barbie', 'Greta Gerwig', 2023, 114, 7.0, '2023-07-29', 'poster-1787872785-dbb8ae.png', '', 0, '2026-08-27 23:19:45'),
(351, 'Película', 'Ya No Estoy Aquí', 'Fernando Frias', 2019, 112, 7.0, '2023-07-31', 'poster-1787874030-585b5e.png', '', 0, '2026-08-27 23:40:30'),
(352, 'Película', 'Talk to Me', 'Danny & Michael Philippou', 2022, 95, 6.0, '2023-08-11', 'poster-1787874081-4e94e8.png', '', 0, '2026-08-27 23:41:21'),
(353, 'Documental', 'Depp V Heard', '?', 2023, NULL, 7.0, '2023-08-18', 'poster-1787874117-ae4c8f.png', '', 0, '2026-08-27 23:41:57'),
(354, 'Película', 'Darkest Hour', 'Joe Wright', 2017, 125, 7.0, '2023-08-26', 'poster-1787874145-07aca4.png', '', 0, '2026-08-27 23:42:25'),
(355, 'Película', 'Eye in the Sky', 'Gavin Hood', 2015, 102, 6.0, '2023-08-28', 'poster-1787874175-c1f9c6.png', '', 0, '2026-08-27 23:42:55'),
(356, 'Película', 'Strays', 'Josh Greenbaum', 2023, 93, 5.0, '2023-09-09', 'poster-1787874213-510a45.png', '', 0, '2026-08-27 23:43:33'),
(357, 'Película', 'Saw X', 'Kevin Greutert', 2023, 118, 6.0, '2023-10-06', 'poster-1787874249-7d92c7.png', '', 0, '2026-08-27 23:44:09'),
(358, 'Película', 'Five Nights at Freddy\'s', 'Emma Tammi', 2023, 109, 4.0, '2023-10-25', 'poster-1787874281-07381f.png', '', 0, '2026-08-27 23:44:41'),
(359, 'Película', 'Women Talking', 'Sarah Polley', 2022, 104, 5.0, '2023-10-29', 'poster-1787874312-8d41f4.png', '', 0, '2026-08-27 23:45:12'),
(360, 'Película', 'The Last Airbender', 'M. Night Shyamalan', 2010, 103, 6.0, '2023-11-19', 'poster-1787874329-8ae44c.png', '', 0, '2026-08-27 23:45:29'),
(361, 'Serie', 'Ojitos de Huevo', 'Santiago Limón', 2023, NULL, 6.0, '2023-11-24', 'poster-1787874724-d6d379.png', '', 0, '2026-08-27 23:52:04'),
(362, 'Película', 'The Killer', 'David Fincher', 2023, 118, 9.0, '2023-11-25', 'poster-1787874773-c24b88.png', '', 1, '2026-08-27 23:52:53'),
(363, 'Película', 'Los Juegos del Hambre: Balada de Pájaros Cantores y Serpientes', 'Francis Lawrence', 2023, 157, 7.0, '2023-12-11', 'poster-1787874841-399193.png', '', 0, '2026-08-27 23:54:01'),
(364, 'Película', 'Wonka', 'Paul King', 2023, 116, 7.0, '2023-12-11', 'poster-1787874969-7a4d30.png', '', 0, '2026-08-27 23:56:09'),
(365, 'Cortometraje', 'The Wonderful Story of Henry Sugar', 'Wes Anderson', 2023, 40, 6.0, '2023-12-16', 'poster-1787875012-5bf033.png', '', 0, '2026-08-27 23:56:52'),
(366, 'Película', 'Napoleon', 'Ridley Scott', 2023, 158, 7.0, '2023-12-25', 'poster-1787875044-070487.png', '', 0, '2026-08-27 23:57:24'),
(367, 'Película', 'Totem', 'Lila Avilés', 2023, 95, 9.0, '2023-12-27', 'poster-1787875098-f97508.png', '', 1, '2026-08-27 23:58:18'),
(368, 'Serie', 'Merlí', 'Héctor Lozano', 2015, NULL, 9.0, '2024-01-04', 'poster-1787875192-969242.png', '', 1, '2026-08-27 23:59:52'),
(369, 'Película', 'Aquaman and the Lost Kingdom', 'James Wan', 2023, 124, 2.0, '2024-01-05', 'poster-1787875227-392a32.png', '', 0, '2026-08-28 00:00:27'),
(370, 'Película', 'La Sociedad de la Nieve', 'J. A. Bayona', 2023, 144, 8.0, '2024-01-09', 'poster-1787875259-4a9b42.png', '', 0, '2026-08-28 00:00:59'),
(371, 'Stand Up', 'Ricky Gervais: Armageddon', 'John L. Spencer', 2023, 63, 7.0, '2024-01-10', 'poster-1787875592-2c2b56.png', '', 0, '2026-08-28 00:06:32'),
(372, 'Cortometraje', 'Un Abrazo de 3 Minutos', 'Everardo González', 2019, 28, 2.0, '2024-01-11', 'poster-1787875660-670c8b.png', '', 0, '2026-08-28 00:07:40'),
(373, 'Película', 'Saltburn', 'Emerald Fennell', 2023, 130, 9.0, '2024-01-13', 'poster-1787876684-7bb9f9.png', '', 1, '2026-08-28 00:24:44'),
(374, 'Película', 'Cuando Acecha la Maldad', 'Demián Rugna', 2023, 99, 7.0, '2024-01-19', 'poster-1787876741-461c4a.png', '', 0, '2026-08-28 00:25:41'),
(375, 'Cortometraje', 'Sing', 'Kristóf Deák', 2016, 25, 6.0, '2024-01-24', 'poster-1787876777-602c8c.png', '', 0, '2026-08-28 00:26:17'),
(376, 'Cortometraje', 'Café Para Llevar', 'Patricia Font', 2014, 13, 5.0, '2024-01-24', 'poster-1787876813-edce3e.png', '', 0, '2026-08-28 00:26:53'),
(377, 'Cortometraje', 'Alternative Math', 'David Maddox', 2017, 9, 8.0, '2024-01-25', 'poster-1787876846-10aced.png', '', 0, '2026-08-28 00:27:26'),
(378, 'Película', 'Radical', 'Cristopher Zalla', 2023, 125, 9.0, '2024-01-27', 'poster-1787876872-ad7649.png', '', 1, '2026-08-28 00:27:52'),
(379, 'Stand Up', 'Sofía Niño de Rivera: Expuesta', 'Raúl Campos', 2016, 80, 6.0, '2024-02-09', 'poster-1787876907-fa7512.png', '', 0, '2026-08-28 00:28:27'),
(380, 'Película', 'Dune: Part Two', 'Denis Villeneuve', 2024, 166, 8.0, '2024-03-02', 'poster-1787876943-bf183b.png', '', 0, '2026-08-28 00:29:03'),
(381, 'Serie', 'Young Royals', 'Lars Beckung', 2021, NULL, 9.0, '2024-03-18', 'poster-1787877523-794192.png', '', 1, '2026-08-28 00:38:43'),
(382, 'Cortometraje', 'The After', 'Misan Harriman', 2023, 19, 7.0, '2024-03-19', 'poster-1787877564-ede23d.png', '', 0, '2026-08-28 00:39:24'),
(383, 'Película', 'Love, Simon', 'Greg Berlanti', 2018, 110, 7.0, '2024-03-27', 'poster-1787877578-0d8143.png', '', 0, '2026-08-28 00:39:38'),
(384, 'Cortometraje', 'Hair Love', 'Matthew A. Cherry', 2019, 7, 7.0, '2024-04-25', 'poster-1787877659-1406d2.png', '', 0, '2026-08-28 00:40:59'),
(385, 'Documental', 'Together: Treble Winners', '?', 2024, NULL, 8.0, '2024-04-26', 'poster-1787877711-c8cca0.png', '', 0, '2026-08-28 00:41:51'),
(386, 'Película', 'Maze Runner: Cura Mortal', 'Wes Ball', 2018, 143, 7.0, '2024-05-03', 'poster-1787879654-258cae.png', '', 0, '2026-08-28 01:14:14'),
(387, 'Película', 'Close', 'Lukas Dhont', 2022, 104, 9.0, '2024-05-24', 'poster-1787879702-58adee.png', '', 1, '2026-08-28 01:15:02'),
(388, 'Película', 'Monkey Man', 'Dev Patel', 2024, 121, 7.0, '2024-05-26', 'poster-1787879739-8a2a09.png', '', 0, '2026-08-28 01:15:39'),
(389, 'Stand Up', 'Franco Escamilla: Ladies\' Man', 'Franco Escamilla', 2024, 74, 7.0, '2024-05-27', 'poster-1787879830-e46f45.png', '', 0, '2026-08-28 01:17:10'),
(390, 'Película', 'Perfect Days', 'Wim Wenders', 2023, 124, 10.0, '2024-05-28', 'poster-1787879872-76c62b.png', '', 1, '2026-08-28 01:17:52'),
(391, 'Película', 'Now You See Me', 'Louis Leterrier', 2013, 115, 7.0, '2024-06-02', 'poster-1787879922-6d0855.png', '', 0, '2026-08-28 01:18:42'),
(392, 'Película', 'Now You See Me 2', 'Jon M. Chu', 2016, 129, 7.0, '2024-06-07', 'poster-1787879953-71820f.png', '', 0, '2026-08-28 01:19:13'),
(393, 'Cortometraje', 'Strange Way of Life', 'Pedro Almodóvar', 2023, 31, 6.0, '2024-06-07', 'poster-1787879984-c7f7e6.png', '', 0, '2026-08-28 01:19:44'),
(394, 'Película', 'Intensamente 2', 'Kelsey Mann', 2024, 96, 9.0, '2024-06-14', 'poster-1787880058-6546fd.png', '', 0, '2026-08-28 01:20:58'),
(395, 'Serie', 'The 8 Show', 'Bae Jin Soo', 2024, NULL, 7.0, '2024-06-15', 'poster-1787880163-4963c1.png', '', 0, '2026-08-28 01:22:43'),
(396, 'Película', 'Monster', 'Hirokazu Koreeda', 2023, 127, 7.0, '2024-07-03', 'poster-1787880205-8623c7.png', '', 0, '2026-08-28 01:23:25'),
(397, 'Película', 'Mi Villano Favorito 4', 'Patrick Delage', 2024, 94, 6.0, '2024-07-08', 'poster-1787880248-8f08e6.png', '', 0, '2026-08-28 01:24:08'),
(398, 'Película', 'Un Lugar en Silencio: Día Uno', 'Michael Sarnoski', 2024, 99, 6.0, '2024-07-09', 'poster-1787880297-d31ea5.png', '', 0, '2026-08-28 01:24:57'),
(399, 'Película', 'Aftersun', 'Charlotte Wells', 2022, 102, 8.0, '2024-07-23', 'poster-1787880384-0f87a5.png', '', 0, '2026-08-28 01:26:24'),
(400, 'Película', 'Deadpool & Wolverine', 'Shawn Levy', 2024, 128, 7.0, '2024-07-24', 'poster-1787880425-9ffaf3.png', '', 0, '2026-08-28 01:27:05'),
(401, 'Película', 'EO', 'Jerzy Skolimowski', 2022, 88, 3.0, '2024-07-25', 'poster-1788966355-89fef7.png', '', 0, '2026-09-09 15:05:55'),
(402, 'Cortometraje', 'A Trip to the Moon', 'Georges Méliès', 1902, 13, 7.0, '2024-07-25', 'poster-1788966411-1cdcfe.png', '', 0, '2026-09-09 15:06:51'),
(403, 'Película', 'Glass', 'M. Night Shyamalan', 2019, 129, 5.0, '2024-08-03', 'poster-1788966446-65d39c.png', '', 0, '2026-09-09 15:07:26'),
(404, 'Película', 'Alien: Romulus', 'Fede Alvarez', 2024, 119, 8.0, '2024-08-30', 'poster-1788966488-180b20.png', '', 0, '2026-09-09 15:08:08'),
(405, 'Película', 'The Wild Robot', 'Chris Sanders', 2024, 102, 9.0, '2024-09-30', 'poster-1788966535-6643d4.png', '', 1, '2026-09-09 15:08:55'),
(406, 'Reality', 'Ramsay\'s Kitchen Nightmares USA', '?', 2007, NULL, 8.0, '2024-10-01', 'poster-1788966591-1ef715.png', '', 0, '2026-09-09 15:09:51'),
(407, 'Película', 'El Hoyo 2', 'Galder Gaztelu-Urrutia', 2024, 99, 7.0, '2024-10-05', 'poster-1788966655-21a54d.png', '', 0, '2026-09-09 15:10:55'),
(408, 'Serie', 'Heartstopper', 'Alice Oseman', 2010, NULL, 9.0, '2024-11-02', 'poster-1788966692-3b0f26.png', '', 1, '2026-09-09 15:11:32'),
(409, 'Documental', 'El Secreto del Doctor Grinberg', 'Ida Cuéllar', 2020, 91, 8.0, '2024-11-18', 'poster-1788966725-926686.png', '', 0, '2026-09-09 15:12:05'),
(410, 'Película', 'We Live in Time', 'John Crowley', 2024, 108, 7.0, '2024-11-23', 'poster-1788966752-6e5c87.png', '', 0, '2026-09-09 15:12:32'),
(411, 'Película', 'Sonic the Hedgehog 3', 'Jeff Fowler', 2024, 110, 8.0, '2024-12-30', 'poster-1788967017-0c599a.png', '', 0, '2026-09-09 15:16:57'),
(412, 'Película', 'Flow', 'Gints Zilbalodis', 2024, 85, 6.0, '2025-01-01', 'poster-1788967045-0b817a.png', '', 0, '2026-09-09 15:17:25'),
(413, 'Película', 'The Grinch', 'Yarrow Cheney', 2018, 86, 6.0, '2025-01-03', 'poster-1788967071-a4606e.png', '', 0, '2026-09-09 15:17:51'),
(414, 'Película', 'Civil War', 'Alex Garland', 2024, 109, 7.0, '2025-01-17', 'poster-1788967130-d2d7fe.png', '', 0, '2026-09-09 15:18:50'),
(415, 'Serie', 'LOL: Last One Laughing', '?', 2018, NULL, 6.0, '2025-01-17', 'poster-1788967177-8ca083.png', '', 0, '2026-09-09 15:19:37'),
(416, 'Película', 'Late Night with the Devil', 'Cameron Caimes', 2023, 93, 9.0, '2025-01-26', 'poster-1788967218-d581da.png', '', 1, '2026-09-09 15:20:18'),
(417, 'Stand Up', 'Gabriel Iglesias: Legend of Fluffy', 'Manny Rodríguez', 2025, 101, 6.0, '2025-02-01', 'poster-1788967263-4a3ebc.png', '', 0, '2026-09-09 15:21:03'),
(418, 'Película', 'Godzilla X Kong: The New Empire', 'Adam Wingard', 2024, 115, 3.0, '2025-02-03', 'poster-1788967303-199832.png', '', 0, '2026-09-09 15:21:43'),
(419, 'Película', 'Los Dos Hemisferios de Lucca', 'Mariana Cenillo', 2025, 96, 5.0, '2025-02-07', 'poster-1788967341-716df3.png', '', 0, '2026-09-09 15:22:21'),
(420, 'Documental', 'La Oscuridad de la Luz del Mundo', 'Carlos Pérez Osorio', 2023, 113, 6.0, '2025-02-08', 'poster-1788967372-0b8ff3.png', '', 0, '2026-09-09 15:22:52'),
(421, 'Serie', 'Culinary Class Wars', '?', 2024, NULL, 8.0, '2025-02-16', 'poster-1788968142-c09e15.png', '', 0, '2026-09-09 15:35:42'),
(422, 'Serie', 'Five Star Chef', '?', 2023, NULL, 7.0, '2025-02-27', 'poster-1788968171-86bc85.png', '', 0, '2026-09-09 15:36:11'),
(423, 'Película', 'Mickey 17', 'Bong Joon-Ho', 2025, 137, 8.0, '2025-03-07', 'poster-1788968204-730277.png', '', 0, '2026-09-09 15:36:44'),
(424, 'Serie', 'Cassandra', '?', 2025, NULL, 6.0, '2025-03-08', 'poster-1788968228-b353c9.png', '', 0, '2026-09-09 15:37:08'),
(425, 'Película', 'The Substance', 'Coralie Fargeat', 2024, 141, 6.0, '2025-03-09', 'poster-1788968271-a341e7.png', '', 0, '2026-09-09 15:37:51'),
(426, 'Serie', 'Gordon Ramsay\'s 24 Hours to Hell and Back', '?', 2018, NULL, 8.0, '2025-03-14', 'poster-1788968310-38d10a.png', '', 0, '2026-09-09 15:38:30'),
(427, 'Película', 'Señora Influencer', 'Carlos Santos', 2023, 100, 6.0, '2025-03-14', 'poster-1788968347-6f22e6.png', '', 0, '2026-09-09 15:39:07'),
(428, 'Película', 'Cónclave', 'Edward Berger', 2024, 120, 8.0, '2025-03-15', 'poster-1788968377-42ed19.png', '', 0, '2026-09-09 15:39:37'),
(429, 'Película', '500 Días de Escobar', 'Simón Hernández', 2023, 98, 5.0, '2025-03-30', 'poster-1788968413-dd5081.png', '', 0, '2026-09-09 15:40:13'),
(430, 'Serie', 'Adolescence', 'Stephen Graham', 2025, NULL, 8.0, '2025-04-05', 'poster-1788968483-dc70c6.png', '', 0, '2026-09-09 15:41:23'),
(431, 'Documental', 'Narco Circo', '?', 2023, NULL, 8.0, '2025-04-11', 'poster-1788968519-8f6605.png', '', 0, '2026-09-09 15:41:59'),
(432, 'Documental', 'Quiet on Set: The Dark Side of Kids TV', '?', 2024, NULL, 8.0, '2025-04-24', 'poster-1788968561-5ced62.png', '', 0, '2026-09-09 15:42:41'),
(433, 'Película', 'The Day the Earth Blew Up: A Looney Tunes Movie', 'Peter Browngardt', 2024, 91, 5.0, '2025-04-25', 'poster-1788968619-deadb3.png', '', 0, '2026-09-09 15:43:39'),
(434, 'Documental', 'El papa Francisco: un hombre de palabra', 'Wim Wenders', 2018, 96, 7.0, '2025-04-26', 'poster-1788968664-a34919.png', '', 0, '2026-09-09 15:44:24'),
(435, 'Película', 'Thunderbolts*', 'Jake Schreier', 2025, 127, 8.0, '2025-05-02', 'poster-1788968738-7ae8d6.png', '', 0, '2026-09-09 15:45:38'),
(436, 'Documental', 'Tutankamon: El último viaje', 'Ernesto Pagano', 2022, 90, 4.0, '2025-05-04', 'poster-1788968802-191363.png', '', 0, '2026-09-09 15:46:42'),
(437, 'Documental', 'Radio Silence', 'Juliana Fanjul', 2019, 79, 8.0, '2025-05-15', 'poster-1788968835-962a7a.png', '', 0, '2026-09-09 15:47:15'),
(438, 'Serie', 'Black Mirror', 'Charlie Brooker', 2011, NULL, 7.0, '2025-05-23', 'poster-1788968897-6d62bb.png', '', 1, '2026-09-09 15:48:17'),
(439, 'Película', 'Karate Kid: Legends', 'Jonathan Entwistle', 2025, 94, 8.0, '2025-05-25', 'poster-1788968935-479aa5.png', '', 0, '2026-09-09 15:48:55'),
(440, 'Película', 'Mission: Impossible - The Final Reckoning', 'Cristopher McQuarrie', 2025, 169, 8.0, '2025-05-25', 'poster-1788969004-16157a.png', '', 0, '2026-09-09 15:50:04'),
(441, 'Stand Up', 'Sofía Niño de Rivera: Lo Volvería a Hacer', '?', 2022, 55, 2.0, '2025-05-25', 'poster-1788969324-2f634d.png', '', 0, '2026-09-09 15:55:24'),
(442, 'Serie', 'Libre de Reír', '?', 2023, NULL, 9.0, '2025-05-25', 'poster-1788969354-45c463.png', '', 0, '2026-09-09 15:55:54'),
(443, 'Película', 'Bardo: Falsa Crónica de unas Cuantas Verdades', 'Alejandro G. Iñárritu', 2022, 159, 10.0, '2025-05-29', 'poster-1788969394-fc6aac.png', '', 1, '2026-09-09 15:56:34'),
(444, 'Película', 'Avengers: Infinity War', 'Anthony & Joe Russo', 2018, 149, 8.0, '2025-06-03', 'poster-1788969438-a63f2b.png', '', 0, '2026-09-09 15:57:18'),
(445, 'Película', 'Fantasia', 'Samuel Armstrong', 1940, 124, 5.0, '2025-06-05', 'poster-1788969474-9401ba.png', '', 0, '2026-09-09 15:57:54'),
(446, 'Cortometraje', '22 vs Earth', 'Kevin Nolting', 2021, 6, 4.0, '2025-06-05', 'poster-1788969505-fe2387.png', '', 0, '2026-09-09 15:58:25'),
(447, 'Película', 'Mission: Impossible', 'Brian de Palma', 1996, 110, 7.0, '2025-06-11', 'poster-1788969543-c32209.png', '', 0, '2026-09-09 15:59:03'),
(448, 'Película', 'Mission: Impossible II', 'John Woo', 2000, 123, 7.0, '2025-06-12', 'poster-1788969577-b22bac.png', '', 0, '2026-09-09 15:59:37'),
(449, 'Película', 'Cyber Hell: Exposing an Internet Horror', 'Choi Jin-sung', 2022, 105, 6.0, '2025-06-12', 'poster-1788969635-50656a.png', '', 0, '2026-09-09 16:00:35'),
(450, 'Película', 'Cómo Entrenar a tu Dragón', 'Dean DeBlois', 2025, 125, 7.0, '2025-06-14', 'poster-1788969787-095240.png', '', 0, '2026-09-09 16:03:07'),
(451, 'Película', 'Cómo Entrenar a tu Dragón 2', 'Dean DeBlois', 2014, 102, 7.0, '2025-06-15', 'poster-1788972243-ba9fb2.png', '', 0, '2026-09-09 16:44:03'),
(452, 'Serie', 'El Juego del Calamar', 'Hwang Dong-hyuk', 2021, NULL, 7.0, '2025-07-08', 'poster-1788972295-00bac1.png', '', 0, '2026-09-09 16:44:55'),
(453, 'Película', 'F1', 'Joseph Kosinski', 2025, 155, 7.0, '2025-07-08', 'poster-1788972323-94a705.png', '', 0, '2026-09-09 16:45:23'),
(454, 'Película', 'Superman', 'James Gunn', 2025, 129, 8.0, '2025-07-11', 'poster-1788972357-929ae3.png', '', 0, '2026-09-09 16:45:57'),
(455, 'Película', 'Mission: Impossible III', 'J. J. Abrams', 2006, 126, 7.0, '2025-07-15', 'poster-1788972390-341086.png', '', 0, '2026-09-09 16:46:30'),
(456, 'Película', 'Los Juegos del Hambre: En Llamas', 'Francis Lawrence', 2013, 146, 7.0, '2025-07-20', 'poster-1788972426-28d7d9.png', '', 0, '2026-09-09 16:47:06'),
(457, 'Película', 'Jurassic World: Rebirth', 'Gareth Edwards', 2025, 133, 7.0, '2025-07-22', 'poster-1788972468-38237c.png', '', 0, '2026-09-09 16:47:48'),
(458, 'Película', 'Tony Robbins: I Am Not Your Guru', 'Joe Berlinger', 2016, 115, 7.0, '2025-07-24', 'poster-1788972515-859697.png', '', 0, '2026-09-09 16:48:35'),
(459, 'Película', 'Los Juegos del Hambre: Sinsajo - Parte 2', 'Francis Lawrence', 2015, 137, 7.0, '2025-07-27', 'poster-1788972569-851685.png', '', 0, '2026-09-09 16:49:29'),
(460, 'Película', 'The Fantastic Four: First Steps', 'Matt Shakman', 2025, 115, 8.0, '2025-07-29', 'poster-1788972627-e29b03.png', '', 0, '2026-09-09 16:50:27'),
(461, 'Película', 'Her', 'Spike Jonze', 2013, 126, 8.0, '2025-07-31', 'poster-1788972677-f8386f.png', '', 0, '2026-09-09 16:51:17'),
(462, 'Película', 'La Cocina', 'Alonso Ruizpalacios', 2024, 139, 8.0, '2025-08-01', 'poster-1788972707-25f99c.png', '', 0, '2026-09-09 16:51:47'),
(463, 'Película', 'The Bad Guys 2', 'Pierre Perifel', 2025, 104, 8.0, '2025-08-05', 'poster-1788972748-aab079.png', '', 0, '2026-09-09 16:52:29'),
(464, 'Película', 'Materialists', 'Celine Song', 2025, 116, 7.0, '2025-08-08', 'poster-1788972774-1223ba.png', '', 0, '2026-09-09 16:52:54'),
(465, 'Película', 'Bring Her Back', 'Danny & Michael Philippou', 2025, 104, 8.0, '2025-08-31', 'poster-1788972820-e6a583.png', '', 0, '2026-09-09 16:53:40'),
(466, 'Película', 'Doctor Strange', 'Scott Derrickson', 2016, 115, 7.0, '2025-09-10', 'poster-1788972868-5cfcb6.png', '', 0, '2026-09-09 16:54:28'),
(467, 'Película', 'Ratatouille', 'Brad Bird', 2007, 111, 8.0, '2025-09-13', 'poster-1788972895-939b32.png', '', 0, '2026-09-09 16:54:55'),
(468, 'Película', 'One Battle After Another', 'Paul Thomas Anderson', 2025, 161, 7.0, '2025-09-28', 'poster-1788972927-285ebf.png', '', 0, '2026-09-09 16:55:27'),
(469, 'Serie', 'La Casa de Papel', 'Álex Pina', 2017, NULL, 9.0, '2023-10-03', 'poster-1788972960-72d2cc.png', '', 1, '2026-09-09 16:56:00'),
(470, 'Película', 'Tron: Ares', 'Joachim Ronning', 2025, 119, 4.0, '2025-10-24', 'poster-1788972999-4920cd.png', '', 0, '2026-09-09 16:56:39'),
(471, 'Película', 'After the Hunt', 'Luca Guadagnino', 205, 138, 8.0, '2025-10-24', 'poster-1788973058-d39ed0.png', '', 0, '2026-09-09 16:57:38'),
(472, 'Película', 'Now You See Me: Now You Don\'t', 'Ruben Fleischer', 2025, 113, 6.0, '2025-11-15', 'poster-1788973150-37fb71.png', '', 0, '2026-09-09 16:59:10'),
(473, 'Película', 'Avengers: Age of Ultron', 'Joss Whedon', 2015, 141, 7.0, '2025-11-28', 'poster-1788973184-723c0b.png', '', 0, '2026-09-09 16:59:44'),
(474, 'Película', 'Frankenstein', 'Guillermo del Toro', 2025, 149, 8.0, '2025-11-28', 'poster-1788973214-b3468c.png', '', 0, '2026-09-09 17:00:14'),
(475, 'Película', 'Weapons', 'Zach Cregger', 2025, 128, 9.0, '2025-11-30', 'poster-1788973242-7dc7a5.png', '', 1, '2026-09-09 17:00:42'),
(476, 'Película', 'My Oxford Year', 'Iain Morris', 2025, 112, 4.0, '2025-12-05', 'poster-1788973276-0071cf.png', '', 0, '2026-09-09 17:01:16'),
(477, 'Película', 'It Was Just an Accident', 'Jafar Panahi', 2025, 103, 7.0, '2025-12-06', 'poster-1788973312-2a03fd.png', '', 0, '2026-09-09 17:01:52'),
(478, 'Película', 'Bugonia', 'Yorgos Lanthimos', 2025, 118, 9.0, '2025-12-07', 'poster-1788973337-ec7d8f.png', '', 1, '2026-09-09 17:02:17'),
(479, 'Película', 'Five Nights at Freddy\'s 2', 'Emma Tammi', 2025, 104, 2.0, '2025-12-09', 'poster-1788973393-64b67f.png', '', 0, '2026-09-09 17:03:13'),
(480, 'Película', 'Zootopia', 'Rich Moore', 2016, 108, 6.0, '2025-12-11', 'poster-1788973421-a754fe.png', '', 0, '2026-09-09 17:03:41'),
(481, 'Película', 'Another End', 'Piero Messina', 2024, 119, 7.0, '2025-12-14', 'poster-1788973461-9baaf1.png', '', 0, '2026-09-09 17:04:21'),
(482, 'Película', 'Avatar: Fire and Ash', 'James Cameron', 2025, 197, 7.0, '2025-12-19', 'poster-1788973488-5828d4.png', '', 0, '2026-09-09 17:04:48'),
(483, 'Cortometraje', 'Tlalnepantla', 'Fran Hevia', 2025, 6, 0.0, '2025-12-24', 'poster-1788973512-d37e15.png', '', 0, '2026-09-09 17:05:12'),
(484, 'Película', 'La Hora de los Valientes', 'Ariel Winograd', 2025, 107, 7.0, '2025-12-25', 'poster-1788973537-962381.png', '', 0, '2026-09-09 17:05:37'),
(485, 'Película', 'Sentimental Value', 'Joachim Trier', 2025, 135, 8.0, '2025-12-27', 'poster-1788973561-70f9c2.png', '', 0, '2026-09-09 17:06:01'),
(486, 'Serie', 'Vis a Vis', 'Iván Escobar', 2015, NULL, 8.0, '2025-12-30', 'poster-1788973590-514530.png', '', 0, '2026-09-09 17:06:30'),
(487, 'Serie', 'De Viaje con los Derbez', '?', 2019, NULL, 6.0, '2026-01-01', 'poster-1788973619-e51881.png', '', 0, '2026-09-09 17:06:59'),
(488, 'Película', 'The Menu', 'Mark Mylod', 2022, 107, 8.0, '2026-01-02', 'poster-1788973644-686ae1.png', '', 0, '2026-09-09 17:07:24'),
(489, 'Stand Up', 'What\'s in a Name?', 'Rikki Hughes', 2022, 39, 6.0, '2026-01-02', 'poster-1788973675-d246c4.png', '', 0, '2026-09-09 17:07:55'),
(490, 'Película', 'Rental Family', 'Hikari', 2025, 109, 9.0, '2026-01-08', 'poster-1788973706-cbdf28.png', '', 1, '2026-09-09 17:08:26'),
(491, 'Película', 'Anora', 'Sean Baker', 2024, 139, 8.0, '2026-01-11', 'poster-1788973764-e09de3.png', '', 0, '2026-09-09 17:09:24'),
(492, 'Película', 'No Other Choice', 'Park Chan-wook', 2025, 139, 8.0, '2026-01-16', 'poster-1788973837-64e64e.png', '', 0, '2026-09-09 17:10:37'),
(493, 'Película', 'Marty Supreme', 'Josh Safdie', 2025, 149, 9.0, '2026-01-17', 'poster-1788973866-3a64fc.png', '', 0, '2026-09-09 17:11:06'),
(494, 'Película', 'Sobriedad, Me Estás Matando', 'Raúl Campos', 2025, 108, 3.0, '2026-01-30', 'poster-1788973900-2654a4.png', '', 0, '2026-09-09 17:11:40'),
(495, 'Serie', 'LOL Buscando Talento: México', '?', 2026, NULL, 2.0, '2026-01-30', 'poster-1788973924-cdcdb7.png', '', 0, '2026-09-09 17:12:04'),
(496, 'Película', 'Hamnet', 'Chloé Zhao', 2025, 125, 8.0, '2026-02-01', 'poster-1788973951-45c1ba.png', '', 0, '2026-09-09 17:12:31'),
(497, 'Documental', 'Buy Now! The Shopping Conspiracy', 'Nic Stacey', 2024, 84, 8.0, '2026-02-05', 'poster-1788974001-ea770d.png', '', 0, '2026-09-09 17:13:21'),
(498, 'Cortometraje', 'Contra la Pared', 'Fran Hevia', 2023, 4, 7.0, '2026-02-07', 'poster-1788974032-be4412.png', '', 0, '2026-09-09 17:13:52'),
(499, 'Película', 'Crime 101', 'Bart Layton', 2026, 140, 6.0, '2026-02-13', 'poster-1788974055-b7e0ec.png', '', 0, '2026-09-09 17:14:15'),
(500, 'Película', 'Alien: Covenant', 'Ridley Scott', 2017, 122, 6.0, '2026-02-14', 'poster-1788974077-ee6834.png', '', 0, '2026-09-09 17:14:37'),
(501, 'Película', 'City Lights', 'Charles Chaplin', 1931, 87, 8.0, '2026-02-25', 'poster-1788975486-e99f39.png', '', 0, '2026-09-09 17:38:06'),
(502, 'Documental', 'Manhunt: The Inside Story of the Hunt for Bin Laden', 'Greg Barker', 2013, 102, 7.0, '2026-03-01', 'poster-1788975531-40f4ed.png', '', 0, '2026-09-09 17:38:51'),
(503, 'Película', 'Modern Times', 'Charles Chaplin', 1936, 87, 9.0, '2026-03-07', 'poster-1788975577-071b0f.png', '', 0, '2026-09-09 17:39:37'),
(504, 'Película', 'The Great Dictator', 'Charles Chaplin', 1940, 125, 7.0, '2026-03-08', 'poster-1788975600-404ae0.png', '', 0, '2026-09-09 17:40:00'),
(505, 'Película', 'Hoppers', 'Daniel Chong', 2026, 104, 8.0, '2026-03-14', 'poster-1788975710-003188.png', '', 0, '2026-09-09 17:41:50'),
(506, 'Película', 'Casablanca', 'Michael Curtiz', 1942, 102, 9.0, '2026-03-16', 'poster-1788975739-d38d54.png', '', 0, '2026-09-09 17:42:19'),
(507, 'Película', 'Project Hail Mary', 'Phil Lord', 2026, 156, 8.0, '2026-03-20', 'poster-1788975788-3a42a3.png', '', 0, '2026-09-09 17:43:08'),
(508, 'Serie', 'La Oficina', '?', 2018, NULL, 8.0, '2026-03-22', 'poster-1788975832-e8f543.png', '', 0, '2026-09-09 17:43:52'),
(509, 'Película', 'The Super Mario Galaxy Movie', 'Aaron Horvath', 2026, 98, 7.0, '2026-04-19', 'poster-1788975863-2f0ba7.png', '', 0, '2026-09-09 17:44:23'),
(510, 'Película', 'The Drama', 'Kristoffer Borgli', 2026, 105, 7.0, '2026-04-19', 'poster-1788975896-a64b5b.png', '', 0, '2026-09-09 17:44:56'),
(511, 'Cortometraje', 'The Punisher: One Last Kill', 'Reinaldo Marcus Green', 2026, 48, 3.0, '2026-05-14', 'poster-1788977674-91f626.png', '', 0, '2026-09-09 18:14:34'),
(512, 'Película', 'Sujo', 'Astris Rondero', 2024, 126, 7.0, '2026-05-16', 'poster-1788977713-3dd576.png', '', 0, '2026-09-09 18:15:13'),
(513, 'Película', 'Michael', 'Antoine Fuqua', 2026, 127, 6.0, '2026-05-18', 'poster-1788977748-518789.png', '', 0, '2026-09-09 18:15:48'),
(514, 'Película', 'Queer', 'Luca Guadagnino', 2024, 137, 8.0, '2026-05-26', 'poster-1788977770-a269da.png', '', 0, '2026-09-09 18:16:10'),
(515, 'Película', 'Backrooms', 'Kane Parsons', 2026, 126, 6.0, '2026-05-30', 'poster-1788977795-c0e387.png', '', 0, '2026-09-09 18:16:35'),
(516, 'Película', 'Amarga Navidad', 'Pedro Almodóvar', 2026, 111, 7.0, '2026-06-06', 'poster-1788977831-8c9b0d.png', '', 0, '2026-09-09 18:17:11'),
(517, 'Película', 'Familia a la Deriva', 'Alfonso Pineda Ulloa', 2026, 98, 4.0, '2026-06-07', 'poster-1788977861-a41fb5.png', '', 0, '2026-09-09 18:17:41'),
(518, 'Película', 'It\'s a Wonderful Life', 'Frank Capra', 2026, 130, 9.0, '2026-06-12', 'poster-1788977944-0a89cd.png', '', 0, '2026-09-09 18:19:04'),
(519, 'Película', 'México 86', 'Gabriel Ripstein', 2026, 95, 8.0, '2026-06-14', 'poster-1788977968-b5fe69.png', '', 0, '2026-09-09 18:19:28'),
(520, 'Película', 'Disclosure Day', 'Steven Spielberg', 2026, 145, 8.0, '2026-06-17', 'poster-1788978005-7582f8.png', '', 0, '2026-09-09 18:20:05'),
(521, 'Película', 'Toy Story 5', 'McKenna Harris', 2026, 102, 10.0, '2026-06-17', 'poster-1788978042-7d4956.png', '', 1, '2026-09-09 18:20:42'),
(522, 'Película', 'Sunset Boulevard', 'Billy Wilder', 1950, 110, 7.0, '2026-06-19', 'poster-1788978093-61e174.png', '', 0, '2026-09-09 18:21:33'),
(523, 'Película', 'Obsession', 'Curry Barker', 2025, 109, 6.0, '2026-06-21', 'poster-1788978117-59330c.png', '', 0, '2026-09-09 18:21:57'),
(524, 'Película', 'Singin\' in the Rain', 'Gene Kelley', 1952, 103, 6.0, '2026-06-21', 'poster-1788978144-ef2013.png', '', 0, '2026-09-09 18:22:24'),
(525, 'Película', 'Ikiru', 'Akira Kurosawa', 1952, 143, 7.0, '2026-06-28', 'poster-1788978172-fbdf39.png', '', 0, '2026-09-09 18:22:52'),
(526, 'Película', 'Seven Samurai', 'Akira Kurosawa', 1954, 207, 7.0, '2026-07-01', 'poster-1788978199-ad2ce2.png', '', 0, '2026-09-09 18:23:19'),
(527, 'Serie', 'The Bear', 'Christopher Storer', 2022, NULL, 8.0, '2026-07-02', 'poster-1788978276-df147a.png', '', 0, '2026-09-09 18:24:36'),
(528, 'Película', 'Rear Window', 'Alfred Hitchcock', 1954, 112, 9.0, '2026-07-02', 'poster-1788978368-4a3736.png', '', 0, '2026-09-09 18:26:08'),
(529, 'Película', '12 Angry Men', 'Sidney Lumet', 1957, 96, 7.0, '2026-07-03', 'poster-1788978447-a0e87b.png', '', 0, '2026-09-09 18:27:27'),
(530, 'Película', 'Minions & Monsters', 'Pierre Coffin', 2026, 90, 7.0, '2026-07-04', 'poster-1788978472-4c77e0.png', '', 0, '2026-09-09 18:27:52'),
(531, 'Película', 'Witness for the Prosecution', 'Billy Wilder', 1957, 116, 8.0, '2026-07-06', 'poster-1788978524-86ca7e.png', '', 0, '2026-09-09 18:28:44'),
(532, 'Película', 'Paths of Glory', 'Stanley Kubrick', 1957, 88, 6.0, '2026-07-07', 'poster-1788978678-b9fc4a.png', '', 0, '2026-09-09 18:31:18'),
(533, 'Película', 'Psycho', 'Alfred Hitchcock', 1960, 109, 9.0, '2026-07-10', 'poster-1788978708-e6e0b2.png', '', 0, '2026-09-09 18:31:48'),
(534, 'Película', 'The Invite', 'Olivia Wilde', 2026, 107, 8.0, '2026-07-10', 'poster-1788978765-03b084.png', '', 0, '2026-09-09 18:32:45'),
(535, 'Película', 'The Apartment', 'Billy Wilder', 1960, 125, 6.0, '2026-07-11', 'poster-1788978791-034d4c.png', '', 0, '2026-09-09 18:33:11'),
(536, 'Película', 'Heartstopper Forever', 'Wash Westmoreland', 2026, 114, 8.0, '2026-07-18', 'poster-1788978851-dbf2f6.png', '', 0, '2026-09-09 18:34:11'),
(537, 'Película', 'Harakiri', 'Masaki Kobayashi', 1962, 133, 8.0, '2026-07-23', 'poster-1788978883-64f71f.png', '', 0, '2026-09-09 18:34:43'),
(538, 'Película', 'The Odyssey', 'Christopher Nolan', 2026, 172, 10.0, '2026-07-26', 'poster-1788978914-00c78f.png', '', 1, '2026-09-09 18:35:14'),
(539, 'Película', 'High and Low', 'Akira Kurosawa', 1963, 143, 7.0, '2026-07-27', 'poster-1788978982-c7cb2e.png', '', 0, '2026-09-09 18:36:22'),
(540, 'Película', 'Dr. Strangelove or: How I Learned to Stop Worrying and Love the Bomb', 'Stanley Kubrick', 1964, 95, 6.0, '2026-07-29', 'poster-1788979025-81d230.png', '', 0, '2026-09-09 18:37:05'),
(541, 'Serie', 'The Pitt', 'R. Scott Gemmill', 2025, NULL, 10.0, '2026-07-31', 'poster-1788979054-1e1a24.png', '', 1, '2026-09-09 18:37:34'),
(542, 'Película', 'Spider-Man: Brand New Day', 'Destin Daniel Cretton', 2026, 145, 9.0, '2026-08-03', 'poster-1788979085-f4c239.png', '', 0, '2026-09-09 18:38:05'),
(543, 'Película', 'Magallanes', 'Lav Díaz', 2025, 160, 3.0, '2026-08-06', 'poster-1788979110-ce7f97.png', '', 0, '2026-09-09 18:38:30'),
(544, 'Película', 'The Good, the Bad and the Ugly', 'Sergio Leone', 1966, 178, 10.0, '2026-08-09', 'poster-1788979144-5f11ce.png', '', 1, '2026-09-09 18:39:04'),
(545, 'Película', 'Once Upon a Time in the West', 'Sergio Leone', 1968, 145, 7.0, '2026-08-10', 'poster-1788979172-8e912a.png', '', 0, '2026-09-09 18:39:32'),
(546, 'Película', 'La Captura', 'Chava Cartas', 2026, 91, 7.0, '2026-09-04', 'poster-1788979193-08627b.png', '', 0, '2026-09-09 18:39:53'),
(547, 'Película', 'Quinze Días', 'Daniel Lieff', 2026, 100, 2.0, '2026-09-05', 'poster-1788979248-d76671.png', '', 0, '2026-09-09 18:40:48');

-- --------------------------------------------------------
--
-- Estructura de la tabla `videojuegos`
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
(1, 'Papa\'s Freezeria', 25.6, 27.5, 'vj-1785528412-ee1c5c.webp', 0, '2026-07-19 15:59:26'),
(2, 'Two Point Museum', 1.3, NULL, 'vj-1785528421-b90c9c.jpg', 0, '2026-07-19 16:06:21'),
(3, 'Peak', 1.7, NULL, 'vj-1785528429-acb202.jpg', 0, '2026-07-19 16:06:50'),
(4, 'Supermarket Simulator', 79.0, NULL, 'vj-1785528439-05f8cd.jpg', 0, '2026-07-19 16:07:11'),
(5, 'Spiderman: Miles Morales', 1.7, 12.8, 'vj-1785528473-70c3fc.jpg', 0, '2026-07-19 16:07:36'),
(6, 'Forza Horizon 5', 1.0, NULL, 'vj-1785528451-25ec08.jpg', 0, '2026-07-19 16:07:55'),
(7, 'Spiderman 2', 0.0, NULL, 'vj-1785528464-7dfdcd.jpg', 0, '2026-07-19 16:08:15'),
(8, 'Arc Raiders', 0.0, NULL, 'vj-1785528483-4ddac5.avif', 0, '2026-07-19 16:08:24'),
(9, 'Schedule I', 0.0, NULL, 'vj-1785528501-24b046.jpg', 0, '2026-07-19 16:08:32'),
(10, 'Librarian', 0.0, 7.1, 'vj-1785528368-9cec26.webp', 0, '2026-07-19 16:08:41'),
(11, 'Good Pizza, Great Pizza', 0.0, NULL, 'vj-1785528347-d4b64d.jpg', 0, '2026-07-19 16:08:56'),
(12, 'Palworld', 167.0, NULL, 'vj-1785528301-fbf7a3.jpg', 0, '2026-07-28 22:35:06');

-- --------------------------------------------------------
--
-- Estructura de la tabla `gym_dias`
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
(216, '2026-07-30', 0),
(217, '2026-07-31', 1),
(218, '2026-08-01', 0),
(219, '2026-08-02', 0),
(221, '2026-08-04', 0),
(223, '2026-08-06', 0),
(224, '2026-08-03', 1),
(225, '2026-08-05', 1),
(226, '2026-08-07', 0),
(227, '2026-08-08', 0),
(228, '2026-08-09', 0),
(229, '2026-08-10', 1),
(230, '2026-08-11', 0),
(231, '2026-08-12', 1),
(232, '2026-08-13', 0),
(233, '2026-08-14', 1),
(234, '2026-08-15', 0),
(235, '2026-08-16', 0),
(236, '2026-08-17', 1),
(237, '2026-08-18', 0),
(238, '2026-08-19', 0),
(239, '2026-08-20', 0),
(240, '2026-08-21', 0),
(241, '2026-08-22', 0),
(242, '2026-08-23', 0),
(243, '2026-08-24', 1),
(244, '2026-08-25', 0),
(245, '2026-08-26', 1),
(246, '2026-08-27', 0),
(247, '2026-08-28', 0),
(248, '2026-08-29', 0),
(249, '2026-08-30', 0),
(250, '2026-08-31', 1),
(251, '2026-09-01', 0),
(253, '2026-09-02', 1),
(254, '2026-09-03', 0),
(255, '2026-09-04', 1),
(256, '2026-09-05', 1),
(257, '2026-09-06', 0),
(259, '2026-09-07', 1),
(260, '2026-09-08', 0),
(261, '2026-09-09', 0),
(262, '2026-09-10', 0),
(263, '2026-09-11', 0),
(264, '2026-09-12', 0),
(265, '2026-09-13', 0),
(266, '2026-09-14', 1),
(267, '2026-09-15', 0);

-- --------------------------------------------------------
--
-- Estructura de la tabla `activos`
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
(4, 'Yotepresto', 3000.00, 3),
(5, 'Briq', 1000.00, 4),
(6, 'Monific', 1000.00, 5),
(8, 'Revolut', 22000.00, 4);

-- --------------------------------------------------------
--
-- Estructura de la tabla `deudas`
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
(4, 'Deuda', 16600.00, 1);

-- --------------------------------------------------------
--
-- Estructura de la tabla `cuentas_por_cobrar`
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
(1, 'Maye', 33000.00, 1),
(2, 'Julio', 49650.00, 2);

-- --------------------------------------------------------
--
-- Estructura de la tabla `patrimonio_snapshots`
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
(2, '2026-07-31', 89000.00),
(9, '2026-08-31', 85400.00),
(53, '2026-09-30', 93050.00);

-- --------------------------------------------------------
--
-- Estructura de la tabla `materias`
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
(4, 'IA Aplicada Ciencias Sociales', 'Ricardo Campos González', '16642', 6.0, '#F5B400', 0),
(5, 'Cómputo en la Nube', 'Alejandro Goldberg Fridman', '11667', 4.5, '#EA075A', 0),
(6, 'Internet de las Cosas', 'Alejandro Goldberg Fridman', '11666', 4.5, '#AA2296', 6),
(7, 'Practicum I', 'Emma María Teresa Zárate Inestrillas', '14006', 6.0, '#6A4C93', 0),
(8, 'Responsabilidad Social', 'Mario Arroyo Arrazola', '14313', 6.0, '#3A86FF', 0),
(10, 'Producción Escénica', 'Kerim Martínez Flores', '16774', 3.0, '#FC6722', 9);

-- --------------------------------------------------------
--
-- Estructura de la tabla `horario_bloques`
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
(15, 5, 'jue', '20:30:00', '22:00:00'),
(18, 10, 'mar', '13:00:00', '14:30:00'),
(19, 10, 'jue', '13:00:00', '14:30:00');

-- --------------------------------------------------------
--
-- Estructura de la tabla `materia_criterios`
--

CREATE TABLE `materia_criterios` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL DEFAULT '',
  `peso` decimal(5,2) NOT NULL DEFAULT 0.00,
  `calificacion` decimal(4,2) NOT NULL DEFAULT 0.00,
  `orden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materia_criterios`
--

INSERT INTO `materia_criterios` (`id`, `materia_id`, `nombre`, `peso`, `calificacion`, `orden`) VALUES
(5, 1, 'Examen departaental', 20.00, 0.00, 1),
(6, 1, 'Prácticas', 10.00, 0.00, 2),
(7, 1, 'Exposición oral', 10.00, 0.00, 3),
(8, 1, 'Proyecto aplicativo integrador', 10.00, 0.00, 4),
(9, 1, 'Tareas', 10.00, 0.00, 5),
(10, 1, 'Proyecto aplicativo integrador final', 40.00, 0.00, 6),
(11, 2, 'Examen escrito', 20.00, 0.00, 1),
(12, 2, 'Prácticas', 30.00, 0.00, 2),
(13, 2, 'Tareas y lecturas', 10.00, 0.00, 3),
(14, 2, 'Examen escrito final', 20.00, 0.00, 4),
(15, 2, 'Trabajo final', 20.00, 0.00, 5),
(16, 8, 'Tareas y lecturas 1', 10.00, 0.00, 1),
(17, 8, 'Tareas y lecturas 2', 20.00, 0.00, 2),
(18, 8, 'Tareas y lecturas 3', 30.00, 0.00, 3),
(19, 8, 'Proyecto aplicativo integrador final', 40.00, 0.00, 4),
(20, 4, 'Examen en laboratorio', 20.00, 0.00, 1),
(21, 4, 'Participación en clase', 15.00, 0.00, 2),
(22, 4, 'Prácticas', 25.00, 0.00, 3),
(23, 4, 'Proyecto aplicativo integrador', 40.00, 0.00, 4),
(24, 10, 'Prácticas', 10.00, 0.00, 1),
(25, 10, 'Proyecto aplicativo integrador', 20.00, 0.00, 2),
(26, 10, 'Tareas y lecturas 1', 10.00, 0.00, 3),
(27, 10, 'Tareas y lecturas 2', 10.00, 0.00, 4),
(28, 10, 'Tareas y lecturas 3', 10.00, 0.00, 5),
(29, 10, 'Trabajo final', 40.00, 0.00, 6),
(33, 5, 'Examen escrito 1', 30.00, 0.00, 1),
(34, 5, 'Examen escrito 2', 30.00, 0.00, 2),
(35, 5, 'Examen escrito final', 40.00, 0.00, 3),
(39, 6, 'Examen escrito 1', 30.00, 0.00, 1),
(40, 6, 'Examen escrito 2', 30.00, 0.00, 2),
(41, 6, 'Examen escrito final', 40.00, 0.00, 3),
(46, 3, 'Examen departamental', 20.00, 0.00, 1),
(47, 3, 'Examen escrito', 10.00, 6.50, 2),
(48, 3, 'Prácticas', 30.00, 0.00, 3),
(49, 3, 'Examen escrito final', 40.00, 0.00, 4);

-- --------------------------------------------------------
--
-- Estructura de la tabla `curriculum_materias`
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
(93, 'unam', 4, 6, NULL, 'Imagen y discurso audiovisual', 'cursando'),
(94, 'unam', 5, 1, NULL, 'Géneros periodísticos de opinión', 'desbloqueada'),
(95, 'unam', 5, 2, NULL, 'Corrección de originales', 'desbloqueada'),
(96, 'unam', 5, 3, NULL, 'Metodología de la investigación periodística', 'desbloqueada'),
(97, 'unam', 5, 4, NULL, 'Periodismo, ética y derechos humanos', 'desbloqueada'),
(98, 'unam', 5, 5, NULL, 'Psicología de la comunicación', 'cursando'),
(99, 'unam', 6, 1, NULL, 'Periodismo especializado', 'desbloqueada'),
(100, 'unam', 6, 2, NULL, 'Planeación y gestión de empresas editoriales', 'desbloqueada'),
(101, 'unam', 6, 3, NULL, 'Periodismo y lenguaje narrativo', 'desbloqueada'),
(102, 'unam', 6, 4, NULL, 'El cine como cultura audiovisual', 'cursando'),
(103, 'unam', 6, 5, NULL, 'Arte y comunicación', 'desbloqueada'),
(104, 'unam', 7, 1, NULL, 'Periodismo multimedia', 'desbloqueada'),
(105, 'unam', 7, 2, NULL, 'Diseño y creación editorial de soportes impresos y digitales', 'desbloqueada'),
(106, 'unam', 7, 3, NULL, 'Diseño y desarrollo de proyectos profesionales', 'desbloqueada'),
(107, 'unam', 7, 4, NULL, 'Comunicación política y deporte', 'desbloqueada'),
(108, 'unam', 7, 5, NULL, 'Creatividad publicitaria', 'desbloqueada'),
(109, 'unam', 8, 1, NULL, 'Diseño y producción de videojuegos', 'desbloqueada'),
(110, 'unam', 8, 2, NULL, 'Literatura y periodismo', 'desbloqueada'),
(111, 'unam', 8, 3, NULL, 'Periodismo en internet', 'desbloqueada'),
(112, 'unam', 8, 4, NULL, 'Apreciación estética y narrativa en la producción audiovisual', 'desbloqueada'),
(113, 'unam', 8, 5, NULL, 'Filosofía y comunicación política', 'desbloqueada');

-- --------------------------------------------------------
--
-- Estructura de la tabla `visitas`
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
(39, '2026-07-19', 18),
(40, '2026-07-20', 13),
(53, '2026-07-21', 11),
(64, '2026-07-22', 23),
(79, '2026-07-23', 21),
(100, '2026-07-24', 23),
(123, '2026-07-25', 14),
(137, '2026-07-26', 18),
(155, '2026-07-27', 18),
(173, '2026-07-28', 26),
(199, '2026-07-29', 12),
(211, '2026-07-30', 17),
(212, '2026-07-31', 29),
(241, '2026-08-01', 10),
(251, '2026-08-02', 13),
(264, '2026-08-03', 9),
(273, '2026-08-04', 16),
(289, '2026-08-05', 11),
(300, '2026-08-06', 20),
(320, '2026-08-07', 23),
(343, '2026-08-08', 19),
(362, '2026-08-09', 23),
(385, '2026-08-10', 15),
(400, '2026-08-11', 15),
(415, '2026-08-12', 32),
(447, '2026-08-13', 25),
(472, '2026-08-14', 24),
(496, '2026-08-15', 34),
(530, '2026-08-16', 15),
(545, '2026-08-17', 27),
(572, '2026-08-18', 24),
(596, '2026-08-19', 25),
(621, '2026-08-20', 18),
(639, '2026-08-21', 47),
(686, '2026-08-22', 28),
(714, '2026-08-23', 25),
(739, '2026-08-24', 28),
(767, '2026-08-25', 22),
(789, '2026-08-26', 27),
(816, '2026-08-27', 27),
(843, '2026-08-28', 19),
(862, '2026-08-29', 20),
(882, '2026-08-30', 22),
(904, '2026-08-31', 18),
(922, '2026-09-01', 23),
(945, '2026-09-02', 26),
(971, '2026-09-03', 45),
(1016, '2026-09-04', 7),
(1023, '2026-09-05', 12),
(1035, '2026-09-06', 21),
(1056, '2026-09-07', 7),
(1063, '2026-09-08', 29),
(1092, '2026-09-09', 37),
(1129, '2026-09-10', 18),
(1147, '2026-09-11', 13),
(1160, '2026-09-12', 20),
(1180, '2026-09-13', 25),
(1205, '2026-09-14', 21),
(1226, '2026-09-15', 7);

-- --------------------------------------------------------
--
-- Estructura de la tabla `visitas_pagina`
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
(1, '/', 'Inicio', 1214, '2026-09-15 21:10:48'),
(12, '/tekhne', 'Tékhne', 98, '2026-09-15 00:43:50'),
(15, '/tekhne/categoria/cultura', 'Cultura - Tékhne', 21, '2026-09-12 15:47:41'),
(18, '/tekhne/categoria/cuentos', 'Cuentos - Tékhne', 24, '2026-09-12 14:39:51'),
(22, '/tekhne/categoria/actualidad', 'Actualidad - Tékhne', 20, '2026-09-12 07:58:39'),
(60, '/tekhne/categoria/tecnologia', 'Tecnologia - Tékhne', 20, '2026-09-15 17:07:02'),
(103, '/tekhne/peliculas', 'Películas y series - Tékhne', 37, '2026-09-12 16:21:51'),
(104, '/tekhne/pelicula/ready-player-one', 'Ready Player One', 11, '2026-09-10 21:12:15'),
(105, '/tekhne/pelicula/el-inocente', 'El inocente', 12, '2026-09-11 04:02:34'),
(179, '/tekhne/pelicula/marriage-story', 'Marriage Story', 2, '2026-08-03 13:11:59'),
(181, '/tekhne/pelicula/the-i-land', 'The I-Land', 10, '2026-09-10 13:54:24'),
(186, '/tekhne/el-roble-que-se-volvio-eterno', 'El roble que se volvió eterno', 39, '2026-09-14 01:21:21'),
(215, '/tekhne/pelicula/a-star-is-born', 'A Star Is Born', 2, '2026-08-02 18:11:08'),
(217, '/tekhne/pelicula/dias-de-gallos', 'Días de gallos', 10, '2026-09-10 23:06:44'),
(239, '/tekhne/pelicula/shang-chi-and-the-legend-of-the-ten-rings', 'Shang-Chi and the Legend of the Ten Rings', 1, '2026-08-02 07:05:47'),
(243, '/tekhne/pelicula/san-andreas', 'San Andreas', 1, '2026-08-02 14:35:17'),
(245, '/tekhne/pelicula/godzilla-vs-kong', 'Godzilla vs. Kong', 9, '2026-09-11 01:46:00'),
(246, '/tekhne/pelicula/black-widow', 'Black Widow', 12, '2026-09-11 05:21:58'),
(247, '/tekhne/pelicula/spider-man-homecoming', 'Spider-Man: Homecoming', 9, '2026-09-11 07:03:06'),
(249, '/tekhne/pelicula/the-lego-movie', 'The Lego Movie', 10, '2026-09-10 20:53:51'),
(253, '/tekhne/pelicula/what-if', 'What If...?', 10, '2026-09-11 05:43:22'),
(255, '/tekhne/pelicula/soul', 'Soul', 9, '2026-09-10 23:05:49'),
(258, '/tekhne/pelicula/it', 'It', 8, '2026-09-10 20:13:57'),
(260, '/tekhne/pelicula/the-matrix', 'The Matrix', 9, '2026-09-10 16:23:51'),
(263, '/tekhne/pelicula/the-hunger-games-mockingjay-part-1', 'The Hunger Games: Mockingjay - Part 1', 2, '2026-08-04 04:35:36'),
(265, '/tekhne/pelicula/space-jam-a-new-legacy', 'Space Jam: A New Legacy', 9, '2026-09-11 02:47:47'),
(266, '/tekhne/pelicula/good-day-ramon', 'Good Day, Ramon', 1, '2026-08-03 04:42:30'),
(267, '/tekhne/pelicula/game-of-thrones', 'Game of Thrones', 9, '2026-09-11 02:20:41'),
(268, '/tekhne/pelicula/the-matrix-reloaded', 'The Matrix Reloaded', 8, '2026-09-09 22:03:36'),
(269, '/tekhne/pelicula/the-meg', 'The Meg', 1, '2026-08-03 05:42:05'),
(270, '/tekhne/pelicula/the-incredible-hulk', 'The Incredible Hulk', 9, '2026-09-10 22:59:09'),
(271, '/tekhne/pelicula/charlie-and-the-chocolate-factory', 'Charlie and the Chocolate Factory', 2, '2026-08-06 21:41:22'),
(272, '/tekhne/pelicula/sex-education', 'Sex Education', 9, '2026-09-10 16:26:25'),
(276, '/tekhne/pelicula/chernobyl', 'Chernobyl', 9, '2026-09-11 07:06:02'),
(277, '/tekhne/pelicula/godzilla', 'Godzilla', 9, '2026-09-11 05:04:33'),
(278, '/tekhne/pelicula/fantastic-beasts-and-where-to-find-them', 'Fantastic Beasts and Where to Find Them', 1, '2026-08-03 12:36:52'),
(279, '/tekhne/pelicula/the-wolf-of-wall-street', 'The Wolf of Wall Street', 2, '2026-08-05 19:31:56'),
(281, '/tekhne/pelicula/wonder-woman-1984', 'Wonder Woman 1984', 11, '2026-09-11 06:07:50'),
(288, '/tekhne/sin-algoritmos-para-soles-azules', 'Sin algoritmos para soles azules', 37, '2026-09-15 10:21:12'),
(296, '/tekhne/como-comportarse-en-el-desierto-o-no', 'Cómo comportarse en el desierto (o no)', 32, '2026-09-14 01:21:19'),
(336, '/tekhne/la-danza-de-las-mascaras-caidas', 'La Danza de las Máscaras Caídas', 31, '2026-09-14 01:21:21'),
(350, '/tekhne/recomendaciones', 'Recomendaciones - Tékhne', 23, '2026-09-15 15:53:07'),
(351, '/tekhne/pelicula/nace-una-estrella', 'Nace una Estrella', 13, '2026-09-15 16:29:22'),
(355, '/tekhne/pelicula/un-lugar-en-silencio', 'Un Lugar en Silencio', 12, '2026-09-14 06:36:12'),
(362, '/tekhne/pelicula/the-founder', 'The Founder', 14, '2026-09-15 16:09:50'),
(363, '/tekhne/pelicula/spider-man-2', 'Spider-Man 2', 9, '2026-09-11 11:49:12'),
(364, '/tekhne/pelicula/harry-potter-y-la-camara-de-los-secretos', 'Harry Potter y la Cámara de los Secretos', 10, '2026-09-15 12:22:52'),
(365, '/tekhne/pelicula/captain-phillips', 'Captain Phillips', 10, '2026-09-13 16:19:06'),
(366, '/tekhne/pelicula/historia-de-un-matrimonio', 'Historia de un Matrimonio', 11, '2026-09-12 22:46:15'),
(371, '/tekhne/pelicula/son-como-ninos-2', 'Son como Niños 2', 10, '2026-09-14 07:36:55'),
(372, '/tekhne/pelicula/mirreyes-contra-godinez', 'Mirreyes contra Godínez', 10, '2026-09-14 10:03:35'),
(373, '/tekhne/pelicula/harry-potter-y-la-piedra-filosofal', 'Harry Potter y la Piedra Filosofal', 11, '2026-09-13 10:04:29'),
(387, '/tekhne/pelicula/the-dark-night', 'The Dark Night', 11, '2026-09-13 14:46:34'),
(388, '/tekhne/pelicula/don-t-look-up', 'Don\'t Look Up', 11, '2026-09-13 04:07:26'),
(404, '/tekhne/pelicula/the-matrix-resurrections', 'The Matrix Resurrections', 14, '2026-09-13 10:39:22'),
(408, '/tekhne/pelicula/spider-man-3', 'Spider-Man 3', 10, '2026-09-13 11:35:42'),
(412, '/tekhne/pelicula/harry-potter-y-la-orden-del-fenix', 'Harry Potter y la Orden del Fénix', 10, '2026-09-13 17:21:31'),
(413, '/tekhne/pelicula/pulp-fiction', 'Pulp Fiction', 8, '2026-09-11 02:47:02'),
(414, '/tekhne/pelicula/shang-chi-y-la-leyenda-de-los-diez-anillos', 'Shang-Chi y la Leyenda de los Diez Anillos', 8, '2026-09-10 19:13:26'),
(419, '/tekhne/pelicula/spider-man-no-way-home', 'Spider-Man: No Way Home', 9, '2026-09-13 12:35:13'),
(420, '/tekhne/pelicula/dune-part-one', 'Dune: Part One', 8, '2026-09-10 23:05:49'),
(454, '/tekhne/pelicula/artificial-intelligence', 'Artificial Intelligence', 10, '2026-09-13 20:07:44'),
(455, '/tekhne/pelicula/camino-amarte', 'Camino Amarte', 10, '2026-09-13 15:14:17'),
(456, '/tekhne/pelicula/circle', 'Circle', 11, '2026-09-14 03:35:02'),
(458, '/tekhne/pelicula/guten-tag-ramon', 'Guten Tag, Ramón', 9, '2026-09-13 18:04:09'),
(459, '/tekhne/pelicula/harry-potter-y-el-misterio-del-principe', 'Harry Potter y el Misterio del Príncipe', 11, '2026-09-13 11:36:35'),
(460, '/tekhne/pelicula/harry-potter-y-las-reliquias-de-la-muerte-parte-1', 'Harry Potter y las Reliquias de la Muerte: Parte 1', 10, '2026-09-13 10:46:21'),
(461, '/tekhne/pelicula/harry-potter-y-las-reliquias-de-la-muerte-parte-2', 'Harry Potter y las Reliquias de la Muerte: Parte 2', 11, '2026-09-14 03:12:41'),
(462, '/tekhne/pelicula/hawkeye', 'Hawkeye', 12, '2026-09-14 10:04:22'),
(464, '/tekhne/pelicula/mi-villano-favorito', 'Mi Villano Favorito', 12, '2026-09-15 10:35:55'),
(465, '/tekhne/pelicula/mi-villano-favorito-2', 'Mi Villano Favorito 2', 10, '2026-09-13 04:52:24'),
(467, '/tekhne/pelicula/tau', 'Tau', 12, '2026-09-15 16:14:01'),
(470, '/tekhne/pelicula/tren-a-busan', 'Tren a Busán', 10, '2026-09-15 05:40:24'),
(474, '/tekhne/pelicula/you', 'You', 7, '2026-09-11 02:23:21'),
(477, '/tekhne/pelicula/wandavision', 'Wandavision', 7, '2026-09-11 01:02:53'),
(478, '/tekhne/pelicula/tick-tick-boom', 'tick, tick... BOOM!', 9, '2026-09-13 11:15:40'),
(479, '/tekhne/pelicula/the-social-network', 'The Social Network', 9, '2026-09-13 10:47:45'),
(480, '/tekhne/pelicula/the-matrix-revolutions', 'The Matrix Revolutions', 9, '2026-09-13 12:31:42'),
(486, '/tekhne/pelicula/the-game', 'The Game', 9, '2026-09-13 10:50:33'),
(488, '/tekhne/pelicula/terremoto-la-falla-de-san-andres', 'Terremoto: La Falla de San Andrés', 7, '2026-09-10 19:23:32'),
(491, '/tekhne/pelicula/spider-man-far-from-home', 'Spider-Man: Far from Home', 7, '2026-09-11 01:51:29'),
(494, '/tekhne/pelicula/spider-man', 'Spider-Man', 9, '2026-09-13 03:54:53'),
(498, '/tekhne/pelicula/son-como-ninos', 'Son como Niños', 7, '2026-09-11 01:47:51'),
(501, '/tekhne/pelicula/seven', 'Seven', 10, '2026-09-13 12:45:46'),
(502, '/tekhne/pelicula/room', 'Room', 9, '2026-09-13 04:10:14'),
(503, '/tekhne/pelicula/regular-show', 'Regular Show', 9, '2026-09-13 04:39:31'),
(505, '/tekhne/pelicula/que-paso-ayer-parte-iii', '¿Qué Pasó Ayer? Parte III', 9, '2026-09-13 04:42:17'),
(506, '/tekhne/pelicula/que-paso-ayer-parte-ii', '¿Qué Pasó Ayer? Parte II', 9, '2026-09-13 04:43:41'),
(507, '/tekhne/pelicula/que-paso-ayer', '¿Qué Pasó Ayer?', 7, '2026-09-11 01:02:08'),
(509, '/tekhne/pelicula/oblivion', 'Oblivion', 6, '2026-09-09 21:12:33'),
(510, '/tekhne/pelicula/no-se-aceptan-devoluciones', 'No se aceptan devoluciones', 7, '2026-09-10 20:48:29'),
(511, '/tekhne/pelicula/naufrago', 'Náufrago', 7, '2026-09-11 12:22:12'),
(513, '/tekhne/pelicula/megalodon', 'Megalodón', 6, '2026-09-10 23:05:32'),
(514, '/tekhne/pelicula/los-pitufos', 'Los Pitufos', 7, '2026-09-11 08:20:10'),
(515, '/tekhne/pelicula/los-juegos-del-hambre-sinsajo-parte-i', 'Los Juegos del Hambre: Sinsajo - Parte I', 8, '2026-09-11 07:19:30'),
(516, '/tekhne/pelicula/la-leyenda-de-la-llorona', 'La Leyenda de la Llorona', 9, '2026-09-13 13:34:10'),
(517, '/tekhne/pelicula/kung-fu-panda-3', 'Kung Fu Panda 3', 9, '2026-09-15 13:58:40'),
(518, '/tekhne/pelicula/kung-fu-panda-2', 'Kung Fu Panda 2', 10, '2026-09-15 15:47:31'),
(519, '/tekhne/pelicula/kung-fu-panda', 'Kung Fu Panda', 9, '2026-09-14 03:01:26'),
(520, '/tekhne/pelicula/kong-skull-island', 'Kong: Skull Island', 9, '2026-09-14 16:30:24'),
(521, '/tekhne/pelicula/jurassic-world', 'Jurassic World', 8, '2026-09-15 05:20:57'),
(523, '/tekhne/pelicula/iron-man', 'Iron Man', 7, '2026-09-11 03:57:18'),
(524, '/tekhne/pelicula/heroe-de-centro-comercial', 'Héroe de Centro Comercial', 9, '2026-09-15 16:46:05'),
(528, '/tekhne/pelicula/harry-potter-y-el-prisionero-de-azkaban', 'Harry Potter y el Prisionero de Azkabán', 9, '2026-09-13 09:46:25'),
(529, '/tekhne/pelicula/harry-potter-y-el-caliz-de-fuego', 'Harry Potter y el Cáliz de Fuego', 10, '2026-09-13 05:31:57'),
(530, '/tekhne/pelicula/hachiko', 'Hachiko', 9, '2026-09-13 10:49:09'),
(531, '/tekhne/pelicula/gravity', 'Gravity', 9, '2026-09-14 03:14:05'),
(534, '/tekhne/pelicula/charlie-y-la-fabrica-de-chocolate', 'Charlie y la Fábrica de Chocolate', 7, '2026-09-11 00:54:06'),
(536, '/tekhne/pelicula/captain-america-the-first-avenger', 'Captain America: The First Avenger', 9, '2026-09-14 08:01:40'),
(538, '/tekhne/pelicula/beautiful-boy', 'Beautiful Boy', 9, '2026-09-13 06:20:46'),
(539, '/tekhne/pelicula/animales-fantasticos-y-donde-encontrarlos', 'Animales Fantásticos y Dónde Encontrarlos', 7, '2026-09-11 04:49:00'),
(540, '/tekhne/pelicula/alvin-y-las-ardillas-3', 'Alvin y las Ardillas 3', 10, '2026-09-13 12:07:14'),
(541, '/tekhne/pelicula/alvin-y-las-ardillas-2', 'Alvin y las Ardillas 2', 9, '2026-09-13 12:14:12'),
(542, '/tekhne/pelicula/alvin-y-las-ardillas', 'Alvin y las Ardillas', 9, '2026-09-13 11:58:52'),
(543, '/tekhne/pelicula/after-earth', 'After Earth', 9, '2026-09-13 06:34:41'),
(545, '/tekhne/pelicula/eternals', 'Eternals', 7, '2026-09-11 00:11:03'),
(546, '/tekhne/pelicula/el-mesero', 'El Mesero', 7, '2026-09-10 23:14:00'),
(547, '/tekhne/pelicula/el-lobo-de-wall-street', 'El Lobo de Wall Street', 10, '2026-09-13 06:54:12'),
(549, '/tekhne/pelicula/el-increible-mundo-de-gumball', 'El Increíble Mundo de Gumball', 9, '2026-09-15 12:27:06'),
(550, '/tekhne/pelicula/el-hoyo', 'El Hoyo', 9, '2026-09-13 12:41:30'),
(551, '/tekhne/pelicula/el-diario-de-greg', 'El Diario de Greg', 9, '2026-09-13 05:51:28'),
(553, '/tekhne/pelicula/due-date', 'Due Date', 9, '2026-09-14 03:29:27'),
(857, '/proyecto/casa-pestalozzi', 'Casa Pestalozzi', 7, '2026-09-03 19:07:19'),
(858, '/proyecto/eptos-uno', 'Eptos Uno', 12, '2026-09-15 21:16:05'),
(859, '/proyecto/colegio-bilbao', 'Colegio Bilbao', 7, '2026-09-03 20:05:16'),
(875, '/proyecto/casa-bistro-bosque', 'Casa Bistró Bosque', 5, '2026-09-14 00:44:35'),
(948, '/tekhne/pelicula/call-me-by-your-name', 'Call Me by Your Name', 8, '2026-09-11 05:05:17'),
(950, '/tekhne/pelicula/chicuarotes', 'Chicuarotes', 8, '2026-09-13 06:15:12'),
(1004, '/proyecto/tonico-vittale', 'Tonico Vittale', 3, '2026-09-03 20:04:52'),
(1052, '/tekhne/pelicula/dumbo', 'Dumbo', 7, '2026-09-13 10:14:15'),
(1058, '/tekhne/pelicula/teenage-mutant-ninja-turtles', 'Teenage Mutant Ninja Turtles', 7, '2026-09-13 16:14:56'),
(1059, '/tekhne/pelicula/gone-girl', 'Gone Girl', 7, '2026-09-14 06:47:22'),
(1060, '/tekhne/pelicula/gravity-falls', 'Gravity Falls', 6, '2026-09-14 15:30:14'),
(1065, '/tekhne/pelicula/the-cuphead-show', 'The Cuphead Show', 7, '2026-09-13 14:31:03'),
(1069, '/tekhne/pelicula/clickbait', 'Clickbait', 6, '2026-09-11 01:52:27'),
(1073, '/tekhne/pelicula/escandalosos', 'Escandalosos', 6, '2026-09-11 12:59:30'),
(1101, '/tekhne/pelicula/pacific-rim', 'Pacific Rim', 8, '2026-09-14 10:22:15'),
(1102, '/tekhne/pelicula/no-se-si-cortarme-las-venas-o-dejarmelas-largas', 'No sé si Cortarme las Venas o Dejármelas Largas', 7, '2026-09-15 16:28:15'),
(1113, '/tekhne/pelicula/the-power-of-the-dog', 'The Power of the Dog', 7, '2026-09-14 15:10:10'),
(1118, '/tekhne/pelicula/los-juegos-del-hambre', 'Los Juegos del Hambre', 7, '2026-09-13 13:32:46'),
(1123, '/tekhne/pelicula/after', 'After', 10, '2026-09-14 22:20:01'),
(1127, '/tekhne/pelicula/little-women', 'Little Women', 8, '2026-09-14 04:10:04'),
(1135, '/tekhne/pelicula/rio', 'Rio', 7, '2026-09-14 08:11:47'),
(1164, '/tekhne/pelicula/the-karate-kid', 'The Karate Kid', 8, '2026-09-14 02:27:21'),
(1169, '/tekhne/pelicula/madres-paralelas', 'Madres Paralelas', 6, '2026-09-13 09:45:02'),
(1172, '/tekhne/pelicula/it-chapter-two', 'It: Chapter Two', 6, '2026-09-14 13:33:38'),
(1174, '/tekhne/pelicula/after-we-collided', 'After We Collided', 7, '2026-09-14 03:56:05'),
(1179, '/tekhne/pelicula/ted-2', 'Ted 2', 7, '2026-09-14 11:03:41'),
(1180, '/tekhne/pelicula/sonic-the-hedgehog', 'Sonic the Hedgehog', 7, '2026-09-13 04:35:19'),
(1182, '/tekhne/pelicula/the-two-popes', 'The Two Popes', 7, '2026-09-15 06:47:28'),
(1183, '/tekhne/pelicula/jaws', 'Jaws', 5, '2026-09-10 23:06:29'),
(1189, '/tekhne/pelicula/at-eternity-s-gate', 'At Eternity\'s Gate', 8, '2026-09-13 00:48:04'),
(1191, '/tekhne/pelicula/bar-central', 'Bar Central', 7, '2026-09-14 21:33:41'),
(1192, '/tekhne/pelicula/las-ventajas-de-ser-invisible', 'Las Ventajas de Ser Invisible', 7, '2026-09-14 02:58:39'),
(1197, '/tekhne/pelicula/wall-e', 'Wall E', 8, '2026-09-14 04:04:28'),
(1198, '/tekhne/pelicula/choose-or-die', 'Choose or Die', 8, '2026-09-15 17:01:44'),
(1199, '/tekhne/pelicula/the-killing-of-a-sacred-deer', 'The Killing of a Sacred Deer', 9, '2026-09-15 08:57:08'),
(1200, '/tekhne/pelicula/que-culpa-tiene-el-nino', '¿Qué Culpa Tiene el Niño?', 8, '2026-09-15 16:21:01'),
(1201, '/tekhne/pelicula/the-space-between-us', 'The Space Between Us', 7, '2026-09-13 04:28:21'),
(1203, '/tekhne/pelicula/jack-and-jill', 'Jack and Jill', 7, '2026-09-15 16:41:55'),
(1205, '/tekhne/pelicula/worth', 'Worth', 8, '2026-09-15 15:56:48'),
(1206, '/tekhne/pelicula/cuarentones', 'Cuarentones', 7, '2026-09-14 03:30:51'),
(1207, '/tekhne/pelicula/ex-machina', 'Ex Machina', 6, '2026-09-13 03:38:10'),
(1212, '/tekhne/pelicula/it-s-a-kind-of-a-funny-story', 'It\'s a Kind of a Funny Story', 7, '2026-09-14 03:04:13'),
(1214, '/tekhne/pelicula/no-time-to-die', 'No Time to Die', 8, '2026-09-15 16:26:35'),
(1215, '/tekhne/pelicula/venom', 'Venom', 7, '2026-09-14 02:18:59'),
(1218, '/tekhne/pelicula/sonic-the-hedgehog-2', 'Sonic the Hedgehog 2', 6, '2026-09-11 07:39:58'),
(1219, '/tekhne/pelicula/miracles-from-heaven', 'Miracles from Heaven', 7, '2026-09-13 04:46:28'),
(1221, '/tekhne/pelicula/ted', 'Ted', 7, '2026-09-13 12:38:44'),
(1222, '/tekhne/pelicula/midsommar', 'Midsommar', 6, '2026-09-10 09:29:36'),
(1225, '/tekhne/pelicula/parasite', 'Parasite', 10, '2026-09-15 15:43:21'),
(1226, '/tekhne/pelicula/heroe-de-centro-comercial-2', 'Héroe de Centro Comercial 2', 7, '2026-09-13 05:27:46'),
(1230, '/tekhne/pelicula/a-clockwork-orange', 'A Clockwork Orange', 7, '2026-09-13 06:37:29'),
(1232, '/tekhne/pelicula/the-suicide-squad', 'The Suicide Squad', 7, '2026-09-13 04:00:29'),
(1237, '/tekhne/pelicula/dunkirk', 'Dunkirk', 7, '2026-09-13 05:54:58'),
(1239, '/tekhne/pelicula/cosas-imposibles', 'Cosas Imposibles', 7, '2026-09-13 16:34:32'),
(1240, '/tekhne/pelicula/nosotros-los-nobles', 'Nosotros los Nobles', 7, '2026-09-14 02:44:40'),
(1243, '/tekhne/pelicula/no-eres-tu-soy-yo', 'No Eres Tú, Soy Yo', 6, '2026-09-12 08:23:43'),
(1255, '/tekhne/pelicula/maze-runner-prueba-de-fuego', 'Maze Runner: Prueba de Fuego', 7, '2026-09-13 04:54:17'),
(1259, '/tekhne/pelicula/moon-knight', 'Moon Knight', 7, '2026-09-14 08:31:25'),
(1264, '/tekhne/pelicula/death-note', 'Death Note', 8, '2026-09-13 05:59:52'),
(1267, '/tekhne/pelicula/the-do-over', 'The Do-Over', 7, '2026-09-13 16:17:43'),
(1268, '/tekhne/pelicula/the-batman', 'The Batman', 7, '2026-09-14 02:32:56'),
(1269, '/tekhne/pelicula/durante-la-tormenta', 'Durante la Tormenta', 7, '2026-09-14 03:28:03'),
(1271, '/tekhne/pelicula/el-secreto-de-la-calabaza-magica', 'El Secreto de la Calabaza Mágica', 7, '2026-09-13 11:14:16'),
(1280, '/tekhne/pelicula/zodiac', 'Zodiac', 7, '2026-09-14 02:11:18'),
(1282, '/tekhne/pelicula/2001-a-space-odyssey', '2001: A Space Odyssey', 6, '2026-09-13 12:08:38'),
(1284, '/tekhne/pelicula/megamente', 'Megamente', 8, '2026-09-13 04:53:16'),
(1286, '/tekhne/pelicula/pokemon-detective-pikachu', 'Pokémon: Detective Pikachu', 8, '2026-09-13 04:13:01'),
(1287, '/tekhne/pelicula/sully', 'Sully', 7, '2026-09-14 15:11:33'),
(1288, '/tekhne/pelicula/jujutsu-kaisen-0', 'Jujutsu Kaisen 0', 7, '2026-09-14 03:02:50'),
(1289, '/tekhne/pelicula/the-maze-runner', 'The Maze Runner', 7, '2026-09-14 13:32:15'),
(1292, '/tekhne/pelicula/scenes-from-a-marriage', 'Scenes from a Marriage', 7, '2026-09-14 22:04:43'),
(1293, '/tekhne/pelicula/comedy-central-presenta-no-somos-princesas', 'Comedy Central Presenta: No Somos Princesas', 7, '2026-09-13 06:11:00'),
(1294, '/tekhne/pelicula/chilangolandia', 'Chilangolandia', 7, '2026-09-13 06:13:48'),
(1295, '/tekhne/pelicula/after-we-fell', 'After We Fell', 7, '2026-09-10 21:48:03'),
(1298, '/tekhne/pelicula/the-shining', 'The Shining', 7, '2026-09-13 03:47:55'),
(1301, '/tekhne/pelicula/alvin-y-las-ardillas-sobre-ruedas', 'Alvin y las Ardillas: Sobre Ruedas', 7, '2026-09-14 03:49:04'),
(1303, '/tekhne/pelicula/jurassic-park', 'Jurassic Park', 7, '2026-09-13 12:36:15'),
(1307, '/tekhne/pelicula/the-witch', 'The Witch', 7, '2026-09-14 14:45:39'),
(1308, '/tekhne/pelicula/la-leyenda-de-la-nahuala', 'La Leyenda de la Nahuala', 7, '2026-09-13 05:13:49'),
(1310, '/tekhne/pelicula/the-hateful-eight', 'The Hateful Eight', 7, '2026-09-13 04:03:20'),
(1312, '/tekhne/pelicula/v-for-vendetta', 'V for Vendetta', 8, '2026-09-14 21:57:45'),
(1314, '/tekhne/pelicula/inside-the-world-s-toughest-prisons', 'Inside the World\'s Toughest Prisons', 6, '2026-09-15 15:58:42'),
(1317, '/tekhne/pelicula/host', 'Host', 6, '2026-09-14 03:07:37'),
(1322, '/tekhne/pelicula/euphoria', 'Euphoria', 7, '2026-09-10 20:10:41'),
(1324, '/tekhne/pelicula/doctor-strange-in-the-multiverse-of-madness', 'Doctor Strange in the Multiverse of Madness', 7, '2026-09-13 11:19:55'),
(1326, '/tekhne/pelicula/sueno-en-otro-idioma', 'Sueño en Otro Idioma', 6, '2026-09-11 12:16:30'),
(1329, '/tekhne/pelicula/no-manches-frida', 'No Manches Frida', 7, '2026-09-14 02:47:27'),
(1333, '/tekhne/pelicula/hop', 'Hop', 7, '2026-09-15 04:56:07'),
(1334, '/tekhne/pelicula/nerve', 'Nerve', 7, '2026-09-14 14:40:04'),
(1337, '/tekhne/pelicula/riddick', 'Riddick', 7, '2026-09-13 04:36:43'),
(1345, '/tekhne/pelicula/nocturnal-animals', 'Nocturnal Animals', 7, '2026-09-13 10:33:48'),
(1349, '/tekhne/pelicula/five-feet-apart', 'Five Feet Apart', 7, '2026-09-15 16:54:28'),
(1362, '/tekhne/pelicula/the-truman-show', 'The Truman Show', 7, '2026-09-13 03:59:06'),
(1363, '/tekhne/pelicula/the-final-table', 'The Final Table', 9, '2026-09-15 16:11:14'),
(1365, '/tekhne/pelicula/old', 'Old', 8, '2026-09-15 11:24:17'),
(1368, '/tekhne/pelicula/the-angry-birds-movie', 'The Angry Birds Movie', 7, '2026-09-13 10:35:12'),
(1371, '/tekhne/pelicula/turning-red', 'Turning Red', 6, '2026-09-13 03:49:19'),
(1372, '/tekhne/pelicula/lo-imposible', 'Lo Imposible', 6, '2026-09-14 06:41:46'),
(1375, '/tekhne/pelicula/comedy-central-presenta-machis-mis-huevos', 'Comedy Central Presenta: Machis Mis Huevos', 7, '2026-09-13 12:48:34'),
(1376, '/tekhne/pelicula/tiempo-compartido', 'Tiempo Compartido', 7, '2026-09-14 06:37:35'),
(1377, '/tekhne/pelicula/the-girl-with-the-dragon-tattoo', 'The Girl with the Dragon Tattoo', 5, '2026-09-13 01:47:15'),
(1380, '/tekhne/pelicula/the-green-knight', 'The Green Knight', 8, '2026-09-13 11:44:55'),
(1384, '/tekhne/pelicula/comedy-central-presenta-al-cabo-es-comedia', 'Comedy Central Presenta: Al Cabo es Comedia', 6, '2026-09-12 01:01:21'),
(1391, '/tekhne/pelicula/merli-sapere-aude', 'Merlí. Sapere Aude', 7, '2026-09-15 16:34:56'),
(1392, '/tekhne/pelicula/el-crimen-del-padre-amaro', 'El Crimen del Padre Amaro', 7, '2026-09-13 05:52:54'),
(1445, '/tekhne/pelicula/el-especial-de-alex-fernandez', 'El Especial de Alex Fernández', 9, '2026-09-15 13:34:31'),
(1456, '/tekhne/pelicula/fragmentado', 'Fragmentado', 9, '2026-09-15 07:11:30'),
(1458, '/tekhne/pelicula/breaking-bad', 'Breaking Bad', 8, '2026-09-13 09:48:30'),
(1461, '/tekhne/pelicula/everything-everywhere-all-at-once', 'Everything Everywhere All at Once', 11, '2026-09-15 16:00:06'),
(1490, '/tekhne/pelicula/zona-rosa', 'Zona Rosa', 7, '2026-09-14 02:10:06'),
(1494, '/tekhne/pelicula/sofia-nino-de-rivera-seleccion-natural', 'Sofía Niño de Rivera: Selección Natural', 7, '2026-09-13 11:40:43'),
(1499, '/tekhne/pelicula/los-increibles', 'Los Increíbles', 8, '2026-09-14 02:57:15'),
(1502, '/tekhne/pelicula/piper', 'Piper', 7, '2026-09-14 09:22:04'),
(1505, '/tekhne/pelicula/purl', 'Purl', 8, '2026-09-15 15:57:38'),
(1512, '/tekhne/pelicula/the-killer', 'The Killer', 8, '2026-09-13 13:53:08'),
(1523, '/tekhne/pelicula/sing', 'Sing', 6, '2026-09-13 04:08:50'),
(1526, '/tekhne/pelicula/arrival', 'Arrival', 7, '2026-09-14 03:46:17'),
(1527, '/tekhne/pelicula/alternative-math', 'Alternative Math', 7, '2026-09-15 17:05:38'),
(1529, '/tekhne/pelicula/radical', 'Radical', 7, '2026-09-15 15:40:35'),
(1530, '/tekhne/pelicula/tar', 'Tár', 7, '2026-09-13 03:52:06'),
(1531, '/tekhne/pelicula/totem', 'Totem', 7, '2026-09-14 02:23:10'),
(1532, '/tekhne/pelicula/dune-part-two', 'Dune: Part Two', 6, '2026-09-13 12:37:20'),
(1533, '/tekhne/pelicula/merli', 'Merlí', 7, '2026-09-13 16:59:14'),
(1534, '/tekhne/pelicula/cafe-para-llevar', 'Café Para Llevar', 6, '2026-09-13 03:36:47'),
(1535, '/tekhne/pelicula/saltburn', 'Saltburn', 7, '2026-09-14 22:06:06'),
(1538, '/tekhne/pelicula/cuando-acecha-la-maldad', 'Cuando Acecha la Maldad', 5, '2026-09-13 06:05:27'),
(1540, '/tekhne/pelicula/sofia-nino-de-rivera-expuesta', 'Sofía Niño de Rivera: Expuesta', 7, '2026-09-13 11:43:30'),
(1541, '/tekhne/pelicula/ricky-gervais-armageddon', 'Ricky Gervais: Armageddon', 6, '2026-09-13 15:36:19'),
(1543, '/tekhne/pelicula/la-sociedad-de-la-nieve', 'La Sociedad de la Nieve', 6, '2026-09-13 05:12:24'),
(1544, '/tekhne/pelicula/aquaman-and-the-lost-kingdom', 'Aquaman and the Lost Kingdom', 6, '2026-09-14 03:47:40'),
(1545, '/tekhne/pelicula/if-anything-happens-i-love-you', 'If Anything Happens I Love You', 7, '2026-09-13 10:12:51'),
(1546, '/tekhne/pelicula/un-abrazo-de-3-minutos', 'Un Abrazo de 3 Minutos', 7, '2026-09-14 02:20:22'),
(1550, '/tekhne/pelicula/lava', 'Lava', 6, '2026-09-13 15:13:00'),
(1551, '/tekhne/pelicula/barbie', 'Barbie', 8, '2026-09-15 15:51:43'),
(1553, '/tekhne/pelicula/sam-cat', 'Sam & Cat', 7, '2026-09-13 03:56:19'),
(1556, '/tekhne/pelicula/avatar', 'Avatar', 7, '2026-09-13 06:24:56'),
(1557, '/tekhne/pelicula/strays', 'Strays', 7, '2026-09-15 13:17:51'),
(1563, '/tekhne/pelicula/monster', 'Monster', 8, '2026-09-15 05:43:10'),
(1567, '/tekhne/pelicula/deadpool-wolverine', 'Deadpool & Wolverine', 9, '2026-09-15 13:37:19'),
(1570, '/tekhne/pelicula/smiley', 'Smiley', 5, '2026-09-11 04:39:37'),
(1571, '/tekhne/pelicula/moonlight', 'Moonlight', 8, '2026-09-15 16:30:46'),
(1574, '/tekhne/pelicula/lightyear', 'Lightyear', 7, '2026-09-14 06:40:22'),
(1576, '/tekhne/pelicula/monkey-man', 'Monkey Man', 6, '2026-09-14 02:50:14'),
(1577, '/tekhne/pelicula/wonka', 'Wonka', 6, '2026-09-14 02:14:49'),
(1579, '/tekhne/pelicula/daredevil', 'Daredevil', 7, '2026-09-14 15:31:37'),
(1580, '/tekhne/pelicula/belascoaran', 'Belascoarán', 7, '2026-09-13 11:22:40'),
(1585, '/tekhne/pelicula/peacemaker', 'Peacemaker', 6, '2026-09-15 06:48:50'),
(1587, '/tekhne/pelicula/lite', 'Élite', 7, '2026-09-13 05:06:49'),
(1595, '/tekhne/pelicula/close', 'Close', 8, '2026-09-15 07:10:07'),
(1597, '/tekhne/pelicula/inside', 'Inside', 7, '2026-09-14 06:43:11'),
(1599, '/tekhne/pelicula/float', 'Float', 7, '2026-09-15 07:52:36'),
(1600, '/tekhne/pelicula/yo-adolescente', 'Yo, Adolescente', 7, '2026-09-13 04:21:23'),
(1604, '/tekhne/pelicula/fast-x', 'Fast X', 7, '2026-09-13 05:44:30'),
(1605, '/tekhne/pelicula/napoleon', 'Napoleon', 5, '2026-09-13 11:05:53'),
(1607, '/tekhne/pelicula/joker', 'Joker', 7, '2026-09-13 05:21:27'),
(1608, '/tekhne/pelicula/jojo-rabbit', 'Jojo Rabbit', 7, '2026-09-14 14:44:16'),
(1616, '/tekhne/pelicula/minions', 'Minions', 7, '2026-09-13 10:37:59'),
(1626, '/tekhne/pelicula/top-gun-maverick', 'Top Gun: Maverick', 7, '2026-09-14 14:42:52'),
(1632, '/tekhne/pelicula/gabriel-iglesias-stadium-fluffy', 'Gabriel Iglesias: Stadium Fluffy', 8, '2026-09-13 05:40:20'),
(1633, '/tekhne/pelicula/the-franch-dispatch', 'The Franch Dispatch', 6, '2026-09-13 04:31:08'),
(1634, '/tekhne/pelicula/perfect-days', 'Perfect Days', 7, '2026-09-13 13:12:24'),
(1635, '/tekhne/pelicula/love-simon', 'Love, Simon', 5, '2026-09-13 04:58:28'),
(1636, '/tekhne/pelicula/young-royals', 'Young Royals', 8, '2026-09-15 10:38:41'),
(1639, '/tekhne/pelicula/intensamente', 'Intensamente', 7, '2026-09-14 07:39:40'),
(1641, '/tekhne/pelicula/rubius-x', 'Rubius X', 7, '2026-09-15 07:51:13'),
(1642, '/tekhne/pelicula/fifa-uncovered', 'FIFA Uncovered', 7, '2026-09-13 11:11:29'),
(1646, '/tekhne/pelicula/sicario', 'Sicario', 8, '2026-09-15 16:18:14'),
(1647, '/tekhne/pelicula/inside-pixar', 'Inside Pixar', 7, '2026-09-14 03:05:37'),
(1649, '/tekhne/pelicula/control-z', 'Control Z', 8, '2026-09-14 03:32:15'),
(1650, '/tekhne/pelicula/bao', 'Bao', 7, '2026-09-11 13:12:24'),
(1651, '/tekhne/pelicula/nope', 'Nope', 7, '2026-09-13 04:17:12'),
(1654, '/tekhne/pelicula/party-cloudy', 'Party Cloudy', 7, '2026-09-13 10:53:20'),
(1655, '/tekhne/pelicula/canvas', 'Canvas', 7, '2026-09-13 06:17:58'),
(1657, '/tekhne/pelicula/ultimate-beastmaster', 'Ultimate Beastmaster', 7, '2026-09-13 04:25:35'),
(1658, '/tekhne/pelicula/elvis', 'Elvis', 7, '2026-09-14 03:23:52'),
(1659, '/tekhne/pelicula/the-flash', 'The Flash', 7, '2026-09-13 16:56:26'),
(1660, '/tekhne/pelicula/hereditary', 'Hereditary', 7, '2026-09-14 03:26:40'),
(1662, '/tekhne/pelicula/blair-witch', 'Blair WItch', 7, '2026-09-13 11:53:18'),
(1664, '/tekhne/pelicula/aquaman', 'Aquaman', 7, '2026-09-14 08:38:23'),
(1665, '/tekhne/pelicula/saw-x', 'Saw X', 6, '2026-09-13 17:53:42'),
(1666, '/tekhne/pelicula/vivarium', 'Vivarium', 7, '2026-09-13 04:24:11'),
(1669, '/tekhne/pelicula/the-after', 'The After', 7, '2026-09-15 16:12:38'),
(1671, '/tekhne/pelicula/oppenheimer', 'Oppenheimer', 6, '2026-09-15 12:21:29'),
(1672, '/tekhne/pelicula/darkest-hour', 'Darkest Hour', 6, '2026-09-14 22:13:04'),
(1676, '/tekhne/pelicula/lilo-stitch', 'Lilo & Stitch', 7, '2026-09-15 16:19:37'),
(1678, '/tekhne/pelicula/nomadland', 'Nomadland', 7, '2026-09-14 10:23:32'),
(1681, '/tekhne/pelicula/bones-and-all', 'Bones and All', 8, '2026-09-14 03:39:14'),
(1683, '/tekhne/pelicula/i-am-groot', 'I Am Groot', 7, '2026-09-13 05:24:59'),
(1684, '/tekhne/pelicula/pinocchio', 'Pinocchio', 8, '2026-09-15 16:22:24'),
(1688, '/tekhne/pelicula/cuerdas', 'Cuerdas', 7, '2026-09-13 06:04:03'),
(1692, '/tekhne/pelicula/the-revenant', 'The Revenant', 6, '2026-09-14 21:59:08'),
(1696, '/tekhne/pelicula/the-8-show', 'The 8 Show', 8, '2026-09-14 14:37:17'),
(1700, '/tekhne/pelicula/creed-iii', 'Creed III', 7, '2026-09-13 12:42:55'),
(1702, '/tekhne/pelicula/pinocho', 'Pinocho', 7, '2026-09-13 16:29:05'),
(1703, '/tekhne/pelicula/ghislaine-maxwell', 'Ghislaine Maxwell', 8, '2026-09-15 16:51:42'),
(1707, '/tekhne/pelicula/white-noise', 'White Noise', 7, '2026-09-13 03:57:42'),
(1709, '/tekhne/pelicula/the-northman', 'The Northman', 7, '2026-09-14 07:53:19'),
(1711, '/tekhne/pelicula/the-whale', 'The Whale', 7, '2026-09-13 06:47:14'),
(1716, '/tekhne/pelicula/intensamente-2', 'Intensamente 2', 7, '2026-09-13 11:08:41'),
(1717, '/tekhne/pelicula/depp-v-heard', 'Depp V Heard', 6, '2026-09-13 17:03:26'),
(1718, '/tekhne/pelicula/talk-to-me', 'Talk to Me', 6, '2026-09-14 22:00:34'),
(1719, '/tekhne/pelicula/la-la-land', 'La La Land', 8, '2026-09-14 04:12:51'),
(1720, '/tekhne/pelicula/together-treble-winners', 'Together: Treble Winners', 7, '2026-09-13 03:46:32'),
(1724, '/tekhne/pelicula/better-call-saul', 'Better Call Saul', 7, '2026-09-14 03:44:53'),
(1725, '/tekhne/pelicula/daniel-sosa-maleducado', 'Daniel Sosa: Maleducado', 7, '2026-09-13 06:02:39'),
(1726, '/tekhne/pelicula/la-divina-gula', 'La Divina Gula', 7, '2026-09-13 00:45:59'),
(1727, '/tekhne/pelicula/decision-to-leave', 'Decision to Leave', 8, '2026-09-15 16:57:16'),
(1734, '/tekhne/pelicula/the-lobster', 'The Lobster', 7, '2026-09-14 07:05:28'),
(1735, '/tekhne/pelicula/headspace-unwind-your-mind', 'Headspace: Unwind Your Mind', 7, '2026-09-13 16:16:20'),
(1737, '/tekhne/pelicula/chris-rock-selective-outrage', 'Chris Rock: Selective Outrage', 7, '2026-09-14 08:00:17'),
(1738, '/tekhne/pelicula/iron-man-2', 'Iron Man 2', 7, '2026-09-13 16:30:10'),
(1740, '/tekhne/pelicula/the-human-centipede-2', 'The Human Centipede 2', 7, '2026-09-13 09:43:41'),
(1743, '/tekhne/pelicula/los-increibles-2', 'Los Increíbles 2', 7, '2026-09-13 04:59:52'),
(1744, '/tekhne/pelicula/ralph-el-demoledor', 'Ralph El Demoledor', 8, '2026-09-13 10:40:45'),
(1746, '/tekhne/pelicula/maze-runner-cura-mortal', 'Maze Runner: Cura Mortal', 7, '2026-09-15 16:36:21'),
(1752, '/tekhne/pelicula/the-last-airbender', 'The Last Airbender', 7, '2026-09-15 16:07:03'),
(1754, '/tekhne/pelicula/five-nights-at-freddy-s', 'Five Nights at Freddy\'s', 6, '2026-09-14 08:34:12'),
(1756, '/tekhne/pelicula/mission-impossible-dead-reckoning-part-one', 'Mission: Impossible - Dead Reckoning Part One', 7, '2026-09-13 10:07:16'),
(1759, '/tekhne/pelicula/the-godfather', 'The Godfather', 8, '2026-09-15 16:08:27'),
(1760, '/tekhne/pelicula/myth-a-frozen-tale', 'Myth: A Frozen Tale', 7, '2026-09-14 07:38:19'),
(1765, '/tekhne/pelicula/alan-saldana-encarcelado', 'Alan Saldaña: Encarcelado', 7, '2026-09-14 06:20:42'),
(1766, '/tekhne/pelicula/batman-the-dark-knight-returns-part-2', 'Batman: The Dark Knight Returns, Part 2', 7, '2026-09-14 08:54:52'),
(1767, '/tekhne/pelicula/the-last-of-us', 'The Last of Us', 8, '2026-09-13 10:10:04'),
(1768, '/tekhne/pelicula/un-lugar-en-silencio-dia-uno', 'Un Lugar en Silencio: Día Uno', 8, '2026-09-15 16:01:29'),
(1770, '/tekhne/pelicula/carlos-ballarta-el-amor-es-de-putos', 'Carlos Ballarta: El Amor es de Putos', 7, '2026-09-14 03:37:50'),
(1775, '/tekhne/pelicula/avatar-the-way-of-water', 'Avatar: The Way of Water', 7, '2026-09-13 11:24:04'),
(1776, '/tekhne/pelicula/godzilla-king-of-the-monsters', 'Godzilla: King of the Monsters', 7, '2026-09-13 05:38:56'),
(1779, '/tekhne/pelicula/ojitos-de-huevo', 'Ojitos de Huevo', 6, '2026-09-14 08:28:38'),
(1781, '/tekhne/pelicula/alex-strangelove', 'Alex Strangelove', 8, '2026-09-13 12:44:22'),
(1783, '/tekhne/pelicula/thor-love-and-thunder', 'Thor: Love and Thunder', 7, '2026-09-13 06:45:50'),
(1785, '/tekhne/pelicula/hecho-en-mexico', 'Hecho en México', 7, '2026-09-15 04:16:01'),
(1786, '/tekhne/pelicula/eye-in-the-sky', 'Eye in the Sky', 6, '2026-09-14 14:41:28'),
(1787, '/tekhne/pelicula/don-t-worry-darling', 'Don\'t Worry Darling', 7, '2026-09-13 05:57:05'),
(1789, '/tekhne/pelicula/dave-chappelle-the-closer', 'Dave Chappelle: The Closer', 6, '2026-09-13 06:01:16'),
(1791, '/tekhne/pelicula/dragon-ball-super-super-hero', 'Dragon Ball Super: Super Hero', 8, '2026-09-15 16:55:53'),
(1792, '/tekhne/pelicula/the-tinder-swindler', 'The Tinder Swindler', 7, '2026-09-14 09:43:10'),
(1797, '/tekhne/pelicula/venom-let-there-be-carnage', 'Venom: Let There Be Carnage', 6, '2026-09-11 01:57:19'),
(1800, '/tekhne/pelicula/jurassic-world-dominion', 'Jurassic World: Dominion', 7, '2026-09-14 14:05:50'),
(1803, '/tekhne/pelicula/ya-no-estoy-aqui', 'Ya No Estoy Aquí', 6, '2026-09-13 12:30:19'),
(1804, '/tekhne/pelicula/lokillo-nada-es-igual', 'Lokillo: Nada es Igual', 7, '2026-09-13 10:03:06'),
(1808, '/tekhne/pelicula/now-you-see-me', 'Now You See Me', 8, '2026-09-15 07:08:43'),
(1809, '/tekhne/pelicula/forgive-us-our-trespasses', 'Forgive Us Our Trespasses', 7, '2026-09-14 03:16:53'),
(1813, '/tekhne/pelicula/zumbo-s-just-desserts', 'Zumbo\'s Just Desserts', 7, '2026-09-13 04:19:59'),
(1814, '/tekhne/pelicula/now-you-see-me-2', 'Now You See Me 2', 8, '2026-09-15 16:25:11'),
(1815, '/tekhne/pelicula/hair-love', 'Hair Love', 7, '2026-09-13 05:33:22'),
(1816, '/tekhne/pelicula/como-ser-un-latin-lover', 'Cómo Ser un Latin Lover', 7, '2026-09-13 06:09:37'),
(1817, '/tekhne/pelicula/triangle-of-sadness', 'Triangle of Sadness', 8, '2026-09-13 12:12:49'),
(1819, '/tekhne/pelicula/black-panther-wakanda-forever', 'Black Panther: Wakanda Forever', 7, '2026-09-13 06:19:22'),
(1820, '/tekhne/pelicula/spider-man-into-the-spider-verse', 'Spider-Man: Into the Spider-Verse', 8, '2026-09-15 16:15:25'),
(1822, '/tekhne/pelicula/the-social-dilemma', 'The Social Dilemma', 7, '2026-09-15 06:04:27'),
(1824, '/tekhne/pelicula/capi-perez-elotes-para-todos', 'Capi Pérez: Elotes para Todos', 10, '2026-09-15 17:02:51'),
(1825, '/tekhne/pelicula/pixar-in-real-life', 'Pixar in Real Life', 8, '2026-09-15 11:13:28'),
(1826, '/tekhne/pelicula/club-de-cuervos', 'Club de Cuervos', 7, '2026-09-13 12:10:02'),
(1827, '/tekhne/pelicula/mh370-the-plane-that-disappeared', 'MH370: The Plane That Disappeared', 7, '2026-09-14 02:53:06'),
(1828, '/tekhne/pelicula/alexis-de-anda-mea-culpa', 'Alexis de Anda: Mea Culpa', 7, '2026-09-13 06:33:18'),
(1829, '/tekhne/pelicula/spider-man-across-the-spider-verse', 'Spider-Man: Across the Spider-Verse', 8, '2026-09-14 04:05:50'),
(1830, '/tekhne/pelicula/franco-escamilla-ladies-man', 'Franco Escamilla: Ladies\' Man', 6, '2026-09-14 11:05:04'),
(1833, '/tekhne/pelicula/guillermo-del-toro-s-pinnochio', 'Guillermo del Toro\'s Pinnochio', 6, '2026-09-13 05:34:45'),
(1834, '/tekhne/pelicula/a-tale-of-two-kitchens', 'A Tale of Two Kitchens', 8, '2026-09-13 06:36:05'),
(1835, '/tekhne/pelicula/ant-man-and-the-wasp-quantumania', 'Ant-Man and the Wasp: Quantumania', 8, '2026-09-13 06:58:22'),
(1837, '/tekhne/pelicula/franco-escamilla-voyerista-auditivo', 'Franco Escamilla: Voyerista Auditivo', 7, '2026-09-13 09:27:22'),
(1838, '/tekhne/pelicula/chip-n-dale-rescue-rangers', 'Chip \'n Dale: Rescue Rangers', 7, '2026-09-15 13:21:59'),
(1839, '/tekhne/pelicula/fabrizio-copano-solo-pienso-en-mi', 'Fabrizio Copano: Solo pienso en mí', 8, '2026-09-14 03:22:28'),
(1842, '/tekhne/pelicula/carlos-ballarta-falso-profeta', 'Carlos Ballarta: Falso Profeta', 6, '2026-09-11 10:18:36'),
(1847, '/tekhne/pelicula/marchday-inside-fc-barcelona', 'Marchday: Inside FC Barcelona', 7, '2026-09-15 16:37:44'),
(1848, '/tekhne/pelicula/ayotzinapa-el-paso-de-la-tortuga', 'Ayotzinapa, El paso de la Tortuga', 7, '2026-09-15 12:02:39'),
(1850, '/tekhne/pelicula/coco-y-raulito-carrusel-de-ternura', 'Coco y Raulito: Carrusel de ternura', 7, '2026-09-14 08:35:36'),
(1851, '/tekhne/pelicula/the-super-mario-bros-movie', 'The Super Mario Bros Movie', 8, '2026-09-15 16:05:39'),
(1852, '/tekhne/pelicula/un-lugar-en-silencio-ii', 'Un Lugar en Silencio II', 6, '2026-09-15 12:41:35'),
(1854, '/tekhne/pelicula/carlos-ballarta-furia-era', 'Carlos Ballarta: Furia Ñera', 7, '2026-09-14 22:14:27'),
(1855, '/tekhne/pelicula/alan-saldana-mi-vida-de-pobre', 'Alan Saldaña: Mi vida de pobre', 7, '2026-09-14 03:53:18'),
(1858, '/tekhne/pelicula/ricardo-quevedo-hay-gente-asi', 'Ricardo Quevedo: Hay gente así', 7, '2026-09-14 04:07:14'),
(1859, '/tekhne/pelicula/life-of-pi', 'Life of Pi', 8, '2026-09-13 05:09:36'),
(1862, '/tekhne/pelicula/minions-the-rise-of-gru', 'Minions: The Rise of Gru', 8, '2026-09-15 16:32:10'),
(1865, '/tekhne/pelicula/franco-escamilla-bienvenido-al-mundo', 'Franco Escamilla: Bienvenido al Mundo', 7, '2026-09-13 05:43:07'),
(1867, '/tekhne/pelicula/american-murder-the-family-next-door', 'American Murder: The Family Next Door', 8, '2026-09-13 06:29:10'),
(1868, '/tekhne/pelicula/guardians-of-the-galaxy-vol-3', 'Guardians of the Galaxy Vol. 3', 7, '2026-09-13 05:36:09'),
(1873, '/tekhne/pelicula/house-of-the-dragon', 'House of the Dragon', 7, '2026-09-13 05:26:22'),
(1875, '/tekhne/pelicula/batman-the-dark-knight-returns-part-1', 'Batman: The Dark Knight Returns, Part 1', 7, '2026-09-13 11:54:42'),
(1876, '/tekhne/pelicula/lluvia-de-hamburguesas', 'Lluvia de Hamburguesas', 7, '2026-09-13 06:51:25'),
(1879, '/tekhne/pelicula/bill-burr-live-at-red-rocks', 'Bill Burr: Live at Red Rocks', 7, '2026-09-14 03:43:29'),
(1882, '/tekhne/pelicula/the-guardians-of-the-galaxy-holiday-special', 'The Guardians of the Galaxy Holiday Special', 7, '2026-09-14 02:28:45'),
(1884, '/tekhne/pelicula/liss-pereira-adulto-promedio', 'Liss Pereira: Adulto Promedio', 7, '2026-09-13 05:08:13'),
(1905, '/tekhne/pelicula/presto', 'Presto', 7, '2026-09-13 14:56:07'),
(1921, '/tekhne/pelicula/get-out', 'Get Out', 6, '2026-09-13 12:02:16'),
(1927, '/tekhne/pelicula/aftersun', 'Aftersun', 8, '2026-09-15 09:48:27'),
(1928, '/tekhne/pelicula/les-miserables', 'Les Misérables', 7, '2026-09-13 05:11:00'),
(1929, '/tekhne/pelicula/rio-2', 'Río 2', 7, '2026-09-13 04:11:38'),
(1931, '/tekhne/pelicula/the-lighthouse', 'The Lighthouse', 7, '2026-09-13 04:01:52'),
(1933, '/tekhne/pelicula/stutz', 'Stutz', 7, '2026-09-14 09:44:34'),
(1938, '/tekhne/pelicula/the-fabelmans', 'The Fabelmans', 6, '2026-09-14 10:21:11'),
(1940, '/tekhne/pelicula/daniel-sosa-sosafado', 'Daniel Sosa: Sosafado', 8, '2026-09-15 16:58:39'),
(1941, '/tekhne/pelicula/mr-iglesias', 'Mr. Iglesias', 8, '2026-09-13 14:57:31'),
(1947, '/tekhne/pelicula/women-talking', 'Women Talking', 6, '2026-09-15 15:46:08'),
(1949, '/tekhne/pelicula/mi-villano-favorito-4', 'Mi Villano Favorito 4', 7, '2026-09-15 16:33:33'),
(1950, '/tekhne/pelicula/strange-way-of-life', 'Strange Way of Life', 9, '2026-09-15 07:49:50'),
(1951, '/tekhne/pelicula/franco-escamilla-por-la-anecdota', 'Franco Escamilla: Por la anécdota', 7, '2026-09-13 05:41:44'),
(1955, '/tekhne/pelicula/ricardo-quevedo-los-amargados-somos-mas', 'Ricardo Quevedo: Los Amargados Somos Más', 7, '2026-09-15 10:22:21'),
(1956, '/tekhne/pelicula/ricardo-o-farrill-abrazo-navideno', 'Ricardo O\'Farrill: Abrazo Navideño', 7, '2026-09-15 04:54:45'),
(1959, '/tekhne/pelicula/bob-ross-happy-accidents-betrayal-greed', 'Bob Ross: Happy Accidents, Betrayal & Greed', 7, '2026-09-14 15:47:39'),
(1960, '/tekhne/pelicula/club-america-vs-club-america', 'Club América vs Club América', 6, '2026-09-11 06:35:37'),
(1964, '/tekhne/pelicula/alex-fernandez-el-mejor-comediante-del-mundo', 'Alex Fernández: El Mejor Comediante del Mundo', 8, '2026-09-14 03:51:54'),
(1965, '/tekhne/pelicula/los-juegos-del-hambre-balada-de-pajaros-cantores-y-serpientes', 'Los Juegos del Hambre: Balada de Pájaros Cantores y Serpientes', 6, '2026-09-14 09:24:50'),
(1966, '/tekhne/pelicula/la-dama-del-silencio-el-caso-mataviejitas', 'La Dama del Silencio: El Caso Mataviejitas', 8, '2026-09-15 16:40:31'),
(1967, '/tekhne/pelicula/the-wonderful-story-of-henry-sugar', 'The Wonderful Story of Henry Sugar', 7, '2026-09-13 01:09:53'),
(2760, '/tekhne/pelicula/the-drama', 'The Drama', 4, '2026-09-14 02:31:32'),
(2762, '/tekhne/pelicula/la-oficina', 'La Oficina', 5, '2026-09-13 10:55:32'),
(2763, '/tekhne/pelicula/the-super-mario-galaxy-movie', 'The Super Mario Galaxy Movie', 5, '2026-09-14 02:25:58'),
(2764, '/tekhne/pelicula/casablanca', 'Casablanca', 5, '2026-09-13 06:16:35'),
(2765, '/tekhne/pelicula/project-hail-mary', 'Project Hail Mary', 5, '2026-09-13 10:05:53'),
(2766, '/tekhne/pelicula/hoppers', 'Hoppers', 5, '2026-09-14 08:53:34'),
(2767, '/tekhne/pelicula/manhunt-the-inside-story-of-the-hunt-for-bin-laden', 'Manhunt: The Inside Story of the Hunt for Bin Laden', 5, '2026-09-13 10:01:43'),
(2768, '/tekhne/pelicula/modern-times', 'Modern Times', 5, '2026-09-13 11:04:30'),
(2769, '/tekhne/pelicula/the-great-dictator', 'The Great Dictator', 5, '2026-09-13 03:50:43'),
(2770, '/tekhne/pelicula/city-lights', 'City Lights', 5, '2026-09-13 09:28:46'),
(2771, '/tekhne/pelicula/alien-covenant', 'Alien: Covenant', 6, '2026-09-15 13:38:42'),
(2772, '/tekhne/pelicula/crime-101', 'Crime 101', 5, '2026-09-13 06:06:50'),
(2773, '/tekhne/pelicula/rental-family', 'Rental Family', 6, '2026-09-15 14:02:49'),
(2775, '/tekhne/pelicula/bugonia', 'Bugonia', 7, '2026-09-15 07:48:26'),
(2776, '/tekhne/pelicula/weapons', 'Weapons', 6, '2026-09-13 04:22:47'),
(2777, '/tekhne/pelicula/bardo-falsa-cronica-de-unas-cuantas-verdades', 'Bardo: Falsa Crónica de unas Cuantas Verdades', 7, '2026-09-15 19:07:08'),
(2778, '/tekhne/pelicula/late-night-with-the-devil', 'Late Night with the Devil', 6, '2026-09-13 10:36:35'),
(2779, '/tekhne/pelicula/black-mirror', 'Black Mirror', 7, '2026-09-14 03:41:27'),
(2780, '/tekhne/pelicula/the-wild-robot', 'The Wild Robot', 6, '2026-09-13 10:58:55'),
(2781, '/tekhne/pelicula/heartstopper', 'Heartstopper', 6, '2026-09-13 05:29:10'),
(2811, '/tekhne/pelicula/magallanes', 'Magallanes', 4, '2026-09-12 07:37:48'),
(2812, '/tekhne/pelicula/high-and-low', 'High and Low', 6, '2026-09-15 16:44:42'),
(2813, '/tekhne/pelicula/the-pitt', 'The Pitt', 5, '2026-09-12 08:12:35'),
(2814, '/tekhne/pelicula/la-captura', 'La Captura', 4, '2026-09-13 05:18:00'),
(2815, '/tekhne/pelicula/harakiri', 'Harakiri', 4, '2026-09-12 08:07:06'),
(2816, '/tekhne/pelicula/the-odyssey', 'The Odyssey', 5, '2026-09-14 02:38:16'),
(2817, '/tekhne/pelicula/heartstopper-forever', 'Heartstopper Forever', 4, '2026-09-15 13:02:43'),
(2819, '/tekhne/pelicula/quinze-dias', 'Quinze Días', 4, '2026-09-12 14:56:38'),
(2821, '/tekhne/pelicula/toy-story-5', 'Toy Story 5', 5, '2026-09-15 16:02:52'),
(2822, '/tekhne/pelicula/once-upon-a-time-in-the-west', 'Once Upon a Time in the West', 4, '2026-09-12 01:47:45'),
(2824, '/tekhne/pelicula/spider-man-brand-new-day', 'Spider-Man: Brand New Day', 4, '2026-09-13 11:57:29'),
(2826, '/tekhne/pelicula/the-good-the-bad-and-the-ugly', 'The Good, the Bad and the Ugly', 5, '2026-09-12 08:16:45'),
(2828, '/tekhne/pelicula/dr-strangelove-or-how-i-learned-to-stop-worrying-and-love-the-bomb', 'Dr. Strangelove or: How I Learned to Stop Worrying and Love the Bomb', 4, '2026-09-12 15:15:06'),
(2834, '/tekhne/pelicula/flow', 'Flow', 5, '2026-09-15 16:53:05'),
(2835, '/tekhne/pelicula/materialists', 'Materialists', 4, '2026-09-11 12:43:46'),
(2838, '/tekhne/pelicula/alien-romulus', 'Alien: Romulus', 5, '2026-09-14 22:18:37'),
(2840, '/tekhne/pelicula/conclave', 'Cónclave', 3, '2026-09-14 03:33:39'),
(2847, '/tekhne/pelicula/michael', 'Michael', 4, '2026-09-14 22:08:53'),
(2848, '/tekhne/pelicula/queer', 'Queer', 5, '2026-09-14 22:07:30'),
(2852, '/tekhne/pelicula/obsession', 'Obsession', 5, '2026-09-15 13:31:44'),
(2855, '/tekhne/pelicula/hamnet', 'Hamnet', 5, '2026-09-15 16:48:55'),
(2870, '/tekhne/pelicula/f1', 'F1', 3, '2026-09-11 23:52:52'),
(2871, '/tekhne/pelicula/eo', 'EO', 5, '2026-09-13 05:45:53'),
(2875, '/tekhne/pelicula/psycho', 'Psycho', 4, '2026-09-13 10:18:26'),
(2876, '/tekhne/pelicula/sentimental-value', 'Sentimental Value', 4, '2026-09-15 12:40:13'),
(2882, '/tekhne/pelicula/superman', 'Superman', 5, '2026-09-13 03:53:30'),
(2885, '/tekhne/pelicula/her', 'Her', 6, '2026-09-15 16:47:31'),
(2886, '/tekhne/pelicula/zootopia', 'Zootopia', 3, '2026-09-13 06:44:27'),
(2887, '/tekhne/pelicula/another-end', 'Another End', 4, '2026-09-13 06:28:24'),
(2899, '/tekhne/pelicula/backrooms', 'Backrooms', 6, '2026-09-15 17:04:32'),
(2900, '/tekhne/pelicula/the-menu', 'The Menu', 3, '2026-09-11 05:20:29'),
(2904, '/tekhne/pelicula/anora', 'Anora', 4, '2026-09-13 11:25:28'),
(2906, '/tekhne/pelicula/ikiru', 'Ikiru', 5, '2026-09-15 16:43:18'),
(2911, '/tekhne/pelicula/rear-window', 'Rear Window', 4, '2026-09-13 13:11:00'),
(2914, '/tekhne/pelicula/frankenstein', 'Frankenstein', 3, '2026-09-11 04:05:09'),
(2922, '/tekhne/pelicula/mickey-17', 'Mickey 17', 3, '2026-09-11 12:38:02'),
(2929, '/tekhne/pelicula/culinary-class-wars', 'Culinary Class Wars', 4, '2026-09-13 11:39:19'),
(2931, '/tekhne/pelicula/thunderbolts', 'Thunderbolts*', 4, '2026-09-14 02:24:35'),
(2934, '/tekhne/pelicula/the-invite', 'The Invite', 4, '2026-09-14 07:54:42'),
(2939, '/tekhne/pelicula/bring-her-back', 'Bring Her Back', 4, '2026-09-14 09:29:00'),
(2946, '/tekhne/pelicula/mission-impossible', 'Mission: Impossible', 5, '2026-09-14 09:23:26'),
(2947, '/tekhne/pelicula/glass', 'Glass', 4, '2026-09-14 03:15:32'),
(2948, '/tekhne/pelicula/the-bear', 'The Bear', 4, '2026-09-13 13:55:56'),
(2957, '/tekhne/pelicula/the-grinch', 'The Grinch', 4, '2026-09-13 04:29:45'),
(2962, '/tekhne/pelicula/vis-a-vis', 'Vis a Vis', 4, '2026-09-13 03:42:21'),
(2969, '/tekhne/pelicula/adolescence', 'Adolescence', 4, '2026-09-14 03:57:28'),
(2978, '/tekhne/pelicula/the-substance', 'The Substance', 4, '2026-09-14 14:35:54'),
(2981, '/tekhne/pelicula/libre-de-reir', 'Libre de Reír', 5, '2026-09-13 11:12:53'),
(2985, '/tekhne/pelicula/mexico-86', 'México 86', 4, '2026-09-13 11:17:04'),
(2992, '/tekhne/pelicula/narco-circo', 'Narco Circo', 4, '2026-09-14 02:48:51'),
(2997, '/tekhne/pelicula/22-vs-earth', '22 vs Earth', 5, '2026-09-13 01:54:25'),
(3001, '/tekhne/pelicula/seven-samurai', 'Seven Samurai', 4, '2026-09-14 12:17:42'),
(3002, '/tekhne/pelicula/sonic-the-hedgehog-3', 'Sonic the Hedgehog 3', 4, '2026-09-13 01:48:38'),
(3003, '/tekhne/pelicula/radio-silence', 'Radio Silence', 5, '2026-09-15 13:40:06'),
(3004, '/tekhne/pelicula/12-angry-men', '12 Angry Men', 3, '2026-09-10 22:01:28'),
(3007, '/tekhne/pelicula/senora-influencer', 'Señora Influencer', 4, '2026-09-14 22:03:19'),
(3009, '/tekhne/pelicula/mission-impossible-iii', 'Mission: Impossible III', 4, '2026-09-13 11:37:55'),
(3012, '/tekhne/pelicula/after-the-hunt', 'After the Hunt', 4, '2026-09-13 12:05:57'),
(3016, '/tekhne/pelicula/marty-supreme', 'Marty Supreme', 4, '2026-09-13 04:57:04'),
(3024, '/tekhne/pelicula/contra-la-pared', 'Contra la Pared', 4, '2026-09-13 06:08:13'),
(3026, '/tekhne/pelicula/mission-impossible-ii', 'Mission: Impossible II', 4, '2026-09-14 02:51:38'),
(3030, '/tekhne/pelicula/one-battle-after-another', 'One Battle After Another', 4, '2026-09-13 10:51:56'),
(3036, '/tekhne/pelicula/mission-impossible-the-final-reckoning', 'Mission: Impossible - The Final Reckoning', 4, '2026-09-13 12:15:37'),
(3038, '/tekhne/pelicula/tlalnepantla', 'Tlalnepantla', 4, '2026-09-15 13:27:34'),
(3045, '/tekhne/pelicula/avatar-fire-and-ash', 'Avatar: Fire and Ash', 4, '2026-09-13 06:23:34'),
(3046, '/tekhne/pelicula/karate-kid-legends', 'Karate Kid: Legends', 4, '2026-09-14 07:57:29'),
(3050, '/tekhne/pelicula/we-live-in-time', 'We Live in Time', 4, '2026-09-13 01:08:30'),
(3052, '/tekhne/pelicula/la-cocina', 'La Cocina', 4, '2026-09-13 11:47:42'),
(3057, '/tekhne/pelicula/amarga-navidad', 'Amarga Navidad', 4, '2026-09-14 22:17:14'),
(3058, '/tekhne/pelicula/ratatouille', 'Ratatouille', 4, '2026-09-14 10:00:49'),
(3075, '/tekhne/pelicula/disclosure-day', 'Disclosure Day', 3, '2026-09-11 09:11:14'),
(3079, '/tekhne/pelicula/civil-war', 'Civil War', 4, '2026-09-14 08:36:59'),
(3082, '/tekhne/pelicula/cyber-hell-exposing-an-internet-horror', 'Cyber Hell: Exposing an Internet Horror', 3, '2026-09-11 02:23:07'),
(3084, '/tekhne/pelicula/fantasia', 'Fantasia', 5, '2026-09-13 11:42:06'),
(3090, '/tekhne/pelicula/the-apartment', 'The Apartment', 3, '2026-09-11 08:03:51'),
(3105, '/tekhne/pelicula/la-casa-de-papel', 'La Casa de Papel', 5, '2026-09-13 11:07:18'),
(3110, '/tekhne/pelicula/como-entrenar-a-tu-dragon', 'Cómo Entrenar a tu Dragón', 4, '2026-09-13 12:49:57'),
(3115, '/tekhne/pelicula/ramsay-s-kitchen-nightmares-usa', 'Ramsay\'s Kitchen Nightmares USA', 5, '2026-09-13 06:50:01'),
(3120, '/tekhne/pelicula/what-s-in-a-name', 'What\'s in a Name?', 4, '2026-09-13 01:27:11'),
(3121, '/tekhne/pelicula/five-nights-at-freddy-s-2', 'Five Nights at Freddy\'s 2', 5, '2026-09-15 13:33:08'),
(3122, '/tekhne/pelicula/500-dias-de-escobar', '500 Días de Escobar', 3, '2026-09-11 03:11:17'),
(3125, '/tekhne/pelicula/la-hora-de-los-valientes', 'La Hora de los Valientes', 5, '2026-09-15 16:39:07'),
(3127, '/tekhne/pelicula/como-entrenar-a-tu-dragon-2', 'Cómo Entrenar a tu Dragón 2', 4, '2026-09-15 17:00:03'),
(3131, '/tekhne/pelicula/paths-of-glory', 'Paths of Glory', 5, '2026-09-15 16:23:47'),
(3132, '/tekhne/pelicula/lol-buscando-talento-mexico', 'LOL Buscando Talento: México', 5, '2026-09-13 05:04:03'),
(3136, '/tekhne/pelicula/los-dos-hemisferios-de-lucca', 'Los Dos Hemisferios de Lucca', 3, '2026-09-13 05:01:15'),
(3139, '/tekhne/pelicula/the-bad-guys-2', 'The Bad Guys 2', 5, '2026-09-13 15:57:43'),
(3142, '/tekhne/pelicula/el-hoyo-2', 'El Hoyo 2', 5, '2026-09-13 05:48:41'),
(3143, '/tekhne/pelicula/minions-monsters', 'Minions & Monsters', 4, '2026-09-14 08:32:49'),
(3150, '/tekhne/pelicula/no-other-choice', 'No Other Choice', 4, '2026-09-13 04:45:05'),
(3158, '/tekhne/pelicula/doctor-strange', 'Doctor Strange', 4, '2026-09-13 05:58:28'),
(3163, '/tekhne/pelicula/sobriedad-me-estas-matando', 'Sobriedad, Me Estás Matando', 6, '2026-09-15 16:16:48'),
(3164, '/tekhne/pelicula/my-oxford-year', 'My Oxford Year', 4, '2026-09-14 08:30:02'),
(3167, '/tekhne/pelicula/a-trip-to-the-moon', 'A Trip to the Moon', 4, '2026-09-14 03:58:52'),
(3168, '/tekhne/pelicula/it-was-just-an-accident', 'It Was Just an Accident', 5, '2026-09-13 05:22:14'),
(3169, '/tekhne/pelicula/the-punisher-one-last-kill', 'The Punisher: One Last Kill', 4, '2026-09-13 11:03:06'),
(3172, '/tekhne/pelicula/tutankamon-el-ultimo-viaje', 'Tutankamon: El último viaje', 5, '2026-09-14 02:21:46'),
(3188, '/tekhne/pelicula/lol-last-one-laughing', 'LOL: Last One Laughing', 4, '2026-09-13 05:02:39'),
(3190, '/tekhne/pelicula/gordon-ramsay-s-24-hours-to-hell-and-back', 'Gordon Ramsay\'s 24 Hours to Hell and Back', 5, '2026-09-15 16:50:18'),
(3200, '/tekhne/pelicula/it-s-a-wonderful-life', 'It\'s a Wonderful Life', 4, '2026-09-13 05:23:35'),
(3207, '/tekhne/pelicula/jurassic-world-rebirth', 'Jurassic World: Rebirth', 4, '2026-09-13 05:19:24');

INSERT INTO `visitas_pagina` (`id`, `ruta`, `titulo`, `total`, `actualizado`) VALUES
(3210, '/tekhne/pelicula/el-juego-del-calamar', 'El Juego del Calamar', 5, '2026-09-13 11:18:31'),
(3211, '/tekhne/pelicula/the-fantastic-four-first-steps', 'The Fantastic Four: First Steps', 3, '2026-09-14 02:30:09'),
(3223, '/tekhne/pelicula/godzilla-x-kong-the-new-empire', 'Godzilla X Kong: The New Empire', 4, '2026-09-14 04:14:58'),
(3230, '/tekhne/pelicula/sofia-nino-de-rivera-lo-volveria-a-hacer', 'Sofía Niño de Rivera: Lo Volvería a Hacer', 4, '2026-09-13 04:07:27'),
(3237, '/tekhne/pelicula/witness-for-the-prosecution', 'Witness for the Prosecution', 4, '2026-09-13 16:55:03'),
(3246, '/tekhne/pelicula/familia-a-la-deriva', 'Familia a la Deriva', 4, '2026-09-15 07:54:00'),
(3254, '/tekhne/pelicula/avengers-age-of-ultron', 'Avengers: Age of Ultron', 4, '2026-09-14 09:01:49'),
(3256, '/tekhne/pelicula/tony-robbins-i-am-not-your-guru', 'Tony Robbins: I Am Not Your Guru', 4, '2026-09-15 16:04:16'),
(3257, '/tekhne/pelicula/buy-now-the-shopping-conspiracy', 'Buy Now! The Shopping Conspiracy', 5, '2026-09-15 15:50:19'),
(3261, '/tekhne/pelicula/los-juegos-del-hambre-en-llamas', 'Los Juegos del Hambre: En Llamas', 4, '2026-09-14 22:10:16'),
(3277, '/tekhne/pelicula/el-secreto-del-doctor-grinberg', 'El Secreto del Doctor Grinberg', 5, '2026-09-14 13:47:49'),
(3280, '/tekhne/pelicula/now-you-see-me-now-you-don-t', 'Now You See Me: Now You Don\'t', 5, '2026-09-13 04:15:48'),
(3281, '/tekhne/pelicula/gabriel-iglesias-legend-of-fluffy', 'Gabriel Iglesias: Legend of Fluffy', 4, '2026-09-14 07:58:53'),
(3283, '/tekhne/pelicula/el-papa-francisco-un-hombre-de-palabra', 'El papa Francisco: un hombre de palabra', 4, '2026-09-14 03:25:16'),
(3290, '/tekhne/pelicula/la-oscuridad-de-la-luz-del-mundo', 'La Oscuridad de la Luz del Mundo', 4, '2026-09-14 09:26:13'),
(3291, '/tekhne/pelicula/los-juegos-del-hambre-sinsajo-parte-2', 'Los Juegos del Hambre: Sinsajo - Parte 2', 4, '2026-09-14 10:02:11'),
(3300, '/tekhne/pelicula/quiet-on-set-the-dark-side-of-kids-tv', 'Quiet on Set: The Dark Side of Kids TV', 4, '2026-09-13 04:40:54'),
(3312, '/tekhne/pelicula/the-day-the-earth-blew-up-a-looney-tunes-movie', 'The Day the Earth Blew Up: A Looney Tunes Movie', 4, '2026-09-14 06:38:59'),
(3332, '/tekhne/pelicula/tron-ares', 'Tron: Ares', 4, '2026-09-15 12:42:59'),
(3354, '/tekhne/pelicula/sujo', 'Sujo', 4, '2026-09-13 04:04:40'),
(3597, '/tekhne/pelicula/cassandra', 'Cassandra', 5, '2026-09-15 11:25:35'),
(3659, '/tekhne/pelicula/avengers-infinity-war', 'Avengers: Infinity War', 6, '2026-09-14 22:15:51'),
(3741, '/tekhne/pelicula/sunset-boulevard', 'Sunset Boulevard', 4, '2026-09-13 10:11:28'),
(3776, '/tekhne/pelicula/five-star-chef', 'Five Star Chef', 4, '2026-09-14 03:18:17'),
(3807, '/tekhne/pelicula/singin-in-the-rain', 'Singin\' in the Rain', 4, '2026-09-13 11:56:06'),
(3810, '/tekhne/pelicula/de-viaje-con-los-derbez', 'De Viaje con los Derbez', 4, '2026-09-14 09:27:37');

-- --------------------------------------------------------
--
-- Índices
--

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `proyecto_imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pimg_proyecto` (`proyecto_id`);

ALTER TABLE `blog_categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `blog_recursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_blog_ref` (`blog_id`,`ref_tipo`,`ref_id`);

ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pys_categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

ALTER TABLE `peliculas_series`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `videojuegos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gym_dias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

ALTER TABLE `activos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `deudas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cuentas_por_cobrar`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `patrimonio_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `horario_bloques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bloque_materia` (`materia_id`);

ALTER TABLE `materia_criterios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_criterio_materia` (`materia_id`);

ALTER TABLE `curriculum_materias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

ALTER TABLE `visitas_pagina`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruta` (`ruta`);

-- --------------------------------------------------------
--
-- AUTO_INCREMENT
--

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `proyecto_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `blog_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `blog_recursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

ALTER TABLE `pys_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `peliculas_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=548;

ALTER TABLE `videojuegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `gym_dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

ALTER TABLE `activos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `deudas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `cuentas_por_cobrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `patrimonio_snapshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `horario_bloques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `materia_criterios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

ALTER TABLE `curriculum_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1233;

ALTER TABLE `visitas_pagina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5266;

-- --------------------------------------------------------
--
-- Claves foráneas
--

ALTER TABLE `proyecto_imagenes`
  ADD CONSTRAINT `fk_pimg_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

ALTER TABLE `blog_recursos`
  ADD CONSTRAINT `fk_blogrec_blog` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

ALTER TABLE `horario_bloques`
  ADD CONSTRAINT `fk_bloque_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

ALTER TABLE `materia_criterios`
  ADD CONSTRAINT `fk_criterio_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

COMMIT;
