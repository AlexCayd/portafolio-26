-- =====================================================================
--  LIMPIEZA — alexanderoliva.com
--
--  SOLO `DROP TABLE IF EXISTS` de las tablas del portafolio. No crea
--  nada ni inserta nada, y si la base está vacía no hace nada ni da
--  error.
--
--    mysql -u root -p <base> < database/drops.sql
--
--  Para montar la base local NO hace falta: `local.sql` ya trae sus
--  propios DROP. Esto sirve para dejar la base limpia sin volver a
--  cargar datos, o antes de importar el volcado de producción, que trae
--  `CREATE TABLE` sin `DROP` y falla si las tablas ya existen.
-- =====================================================================

-- Se desactivan las claves foráneas para no depender del orden ni chocar
-- con el error #1451 al tirar una tabla referenciada por otra.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
--  Tékhne
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS blog_recursos;
DROP TABLE IF EXISTS blog;
DROP TABLE IF EXISTS blog_categorias;

-- ---------------------------------------------------------------------
--  Proyectos
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS proyecto_secciones;
DROP TABLE IF EXISTS proyecto_stack;   -- retirada: el stack es una sección más
DROP TABLE IF EXISTS proyecto_imagenes;
DROP TABLE IF EXISTS proyectos;

-- ---------------------------------------------------------------------
--  Películas, libros, videojuegos y gym
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS pelicula_personas;
DROP TABLE IF EXISTS peliculas_series;
DROP TABLE IF EXISTS pys_categorias;
DROP TABLE IF EXISTS libros;
DROP TABLE IF EXISTS videojuegos;
DROP TABLE IF EXISTS gym_dias;

-- ---------------------------------------------------------------------
--  Finanzas
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS activos;
DROP TABLE IF EXISTS deudas;
DROP TABLE IF EXISTS cuentas_por_cobrar;
DROP TABLE IF EXISTS cuentas_por_pagar;
DROP TABLE IF EXISTS patrimonio_snapshots;

-- ---------------------------------------------------------------------
--  Horario y mapas curriculares
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS horario_bloques;
DROP TABLE IF EXISTS materia_criterios;
DROP TABLE IF EXISTS materias;
DROP TABLE IF EXISTS curriculum_materias;

-- ---------------------------------------------------------------------
--  Landing, panel y visitas
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS credenciales;
DROP TABLE IF EXISTS servicios;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS visitas_pagina_dia;
DROP TABLE IF EXISTS visitas_pagina;
DROP TABLE IF EXISTS visitas;

-- Se reactiva la comprobación de claves foráneas.
SET FOREIGN_KEY_CHECKS = 1;
