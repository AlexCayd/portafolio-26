-- ---------------------------------------------------------------------
--  Usuarios (autenticación del panel /admin)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario     VARCHAR(60)  NOT NULL UNIQUE,
    nombre      VARCHAR(60)  NULL,
    apellido    VARCHAR(60)  NULL,
    email       VARCHAR(120) NULL,
    password    VARCHAR(255) NOT NULL,
    admin       TINYINT(1)   NOT NULL DEFAULT 0,
    confirmado  TINYINT(1)   NOT NULL DEFAULT 0,
    token       VARCHAR(255) NULL,
    creado      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Proyectos (slider del portafolio) — img = archivo con extensión
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS proyecto_imagenes;
DROP TABLE IF EXISTS proyectos;
CREATE TABLE proyectos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(120) NOT NULL,
    slug        VARCHAR(180) NULL,
    anio        VARCHAR(10)  NULL,
    img         VARCHAR(160) NOT NULL,
    descripcion TEXT         NULL,
    orden       INT          NOT NULL DEFAULT 0,
    creado      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Galería de imágenes por proyecto (página interna)
CREATE TABLE proyecto_imagenes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT          NOT NULL,
    img         VARCHAR(160) NOT NULL,
    orden       INT          NOT NULL DEFAULT 0,
    CONSTRAINT fk_pimg_proyecto FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Servicios (sección "Del problema al producto")
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS servicios;
CREATE TABLE servicios (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    num         VARCHAR(4)   NOT NULL,
    titulo      VARCHAR(120) NOT NULL,
    descripcion TEXT         NOT NULL,
    tags        VARCHAR(255) NULL,
    orden       INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Credenciales (sección "La curiosidad, certificada")
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS credenciales;
CREATE TABLE credenciales (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    logo        VARCHAR(160) NOT NULL,
    alt         VARCHAR(120) NULL,
    anio        INT          NULL,
    titulo      VARCHAR(160) NOT NULL,
    institucion VARCHAR(120) NULL,
    orden       INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Blog (sección "Ideas en voz alta") — artículo con cuerpo e imágenes
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS blog;
CREATE TABLE blog (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(180) NOT NULL,
    slug        VARCHAR(180) NULL,               -- URL amigable (SEO)
    estado      ENUM('borrador','publicado') NOT NULL DEFAULT 'publicado',
    categoria   VARCHAR(60)  NULL,
    fecha_pub   DATE         NULL,
    descripcion TEXT         NULL,               -- extracto (tarjeta)
    contenido   MEDIUMTEXT   NULL,               -- cuerpo del artículo (texto + <img>)
    cover_img   VARCHAR(160) NULL,
    ref_tipo    VARCHAR(20)  NULL,               -- 'libro' | 'pelicula'
    ref_id      INT          NULL,
    visitas     INT          NOT NULL DEFAULT 0, -- contador de lecturas
    orden       INT          NOT NULL DEFAULT 0,
    creado      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Categorías del blog (extensible desde el admin)
DROP TABLE IF EXISTS blog_categorias;
CREATE TABLE blog_categorias (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Libros (/admin/libros: pendientes y leídos)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS libros;
CREATE TABLE libros (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(160) NOT NULL,
    autor       VARCHAR(120) NOT NULL,
    estado      ENUM('pendiente','leido') NOT NULL DEFAULT 'pendiente',
    completado  TINYINT(1)   NOT NULL DEFAULT 0,
    posicion    INT          NOT NULL DEFAULT 0,
    estrellas   DECIMAL(2,1) NULL,
    comentario  TEXT         NULL,
    creado      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Categorías de Películas y Series (extensible)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS pys_categorias;
CREATE TABLE pys_categorias (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Películas y Series (solo admin) — autor = director/creador
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS peliculas_series;
CREATE TABLE peliculas_series (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    categoria   VARCHAR(60)  NULL,
    titulo      VARCHAR(160) NOT NULL,
    autor       VARCHAR(120) NULL,
    anio        INT          NULL,
    duracion    INT          NULL,
    nota        DECIMAL(3,1) NOT NULL,
    fecha_vista DATE         NULL,
    poster      VARCHAR(160) NULL,
    comentario  TEXT         NULL,
    creado      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Visitas del sitio (una fila por día, contador)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS visitas;
CREATE TABLE visitas (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL UNIQUE,
    total INT  NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Visitas por página (analítica del dashboard) — contador por ruta
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS visitas_pagina;
CREATE TABLE visitas_pagina (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    ruta        VARCHAR(191) NOT NULL UNIQUE,
    titulo      VARCHAR(200) NOT NULL DEFAULT '',
    total       INT          NOT NULL DEFAULT 0,
    actualizado TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Videojuegos — horas_2026 se calcula (totales - iniciales)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS videojuegos;
CREATE TABLE videojuegos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(160)  NOT NULL,
    horas_iniciales DECIMAL(6,1)  NOT NULL DEFAULT 0,
    horas_totales   DECIMAL(6,1)  NULL,
    portada         VARCHAR(160)  NULL,
    orden           INT           NOT NULL DEFAULT 0,
    creado          TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Gym — un registro por día: asistio 1=Sí, 0=No
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS gym_dias;
CREATE TABLE gym_dias (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    fecha   DATE       NOT NULL UNIQUE,
    asistio TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Finanzas: activos, deudas, cuentas por cobrar (activo) + historial neto
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS activos;
CREATE TABLE activos (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120)   NOT NULL,
    monto  DECIMAL(12,2)  NOT NULL DEFAULT 0,
    orden  INT            NOT NULL DEFAULT 0
) ENGINE=InnoDB;

DROP TABLE IF EXISTS deudas;
CREATE TABLE deudas (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120)   NOT NULL,
    monto  DECIMAL(12,2)  NOT NULL DEFAULT 0,
    orden  INT            NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- Cuentas por cobrar: dinero que me deben (se cuenta como activo)
DROP TABLE IF EXISTS cuentas_por_cobrar;
CREATE TABLE cuentas_por_cobrar (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120)   NOT NULL,
    monto  DECIMAL(12,2)  NOT NULL DEFAULT 0,
    orden  INT            NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- Snapshot mensual del patrimonio neto (para la gráfica histórica)
DROP TABLE IF EXISTS patrimonio_snapshots;
CREATE TABLE patrimonio_snapshots (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE          NOT NULL UNIQUE,   -- primer día del mes
    neto  DECIMAL(12,2) NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Horario: materias + bloques (cuadrícula semanal)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS horario_bloques;
DROP TABLE IF EXISTS materias;
CREATE TABLE materias (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    nombre   VARCHAR(160) NOT NULL,
    profesor VARCHAR(160) NULL,
    nrc      VARCHAR(20)  NULL,
    creditos DECIMAL(3,1) NOT NULL DEFAULT 0,
    color    VARCHAR(9)   NOT NULL DEFAULT '#4267AC',
    orden    INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE horario_bloques (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    materia_id  INT NOT NULL,
    dia         ENUM('lun','mar','mie','jue','vie') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin    TIME NOT NULL,
    CONSTRAINT fk_bloque_materia FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
--  Mapas curriculares (Anáhuac / UNAM)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS curriculum_materias;
CREATE TABLE curriculum_materias (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    mapa     ENUM('anahuac','unam') NOT NULL,
    semestre INT          NOT NULL,
    fila     INT          NOT NULL DEFAULT 0,
    codigo   VARCHAR(20)  NULL,
    nombre   VARCHAR(160) NOT NULL,
    estado   ENUM('completado','cursando','desbloqueada','bloqueada') NOT NULL DEFAULT 'bloqueada'
) ENGINE=InnoDB;
