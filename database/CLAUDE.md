# CLAUDE.md — Base de datos

En esta carpeta **solo deben existir tres archivos**. Nada más.

| Archivo | Qué es | Quién lo escribe |
|---|---|---|
| `ddl.sql` | El **esquema**: `DROP TABLE` + `CREATE TABLE` de **todas** las tablas. Es el único archivo que crea estructura y la fuente de verdad. | A mano |
| `deploy.sql` | **Solo `INSERT`** con los datos reales de producción. Se importa después de `ddl.sql` para replicar el sitio tal cual está. | Exportado de producción (solo la parte de datos) |
| `development.sql` | **Solo `INSERT`** con datos semilla para local: usuario admin, categorías y unos registros de prueba. Se importa después de `ddl.sql`. | A mano |

**Ni `deploy.sql` ni `development.sql` llevan `CREATE TABLE`, `ALTER TABLE`, `DROP`, índices ni `AUTO_INCREMENT`.** Si un volcado de phpMyAdmin trae todo eso, se recorta y solo se conservan los `INSERT`.

## Nada de migraciones y **nada de `ALTER TABLE`**

**No se crean archivos de migración.** Ni `migracion-*.sql`, ni `alter-*.sql`, ni `patch-*.sql`, ni carpetas de versiones. Este proyecto no lleva historial de cambios de esquema: el esquema es lo que diga `ddl.sql` hoy.

**Tampoco se escribe `ALTER TABLE` en ningún archivo, ni se sugiere ejecutarlo suelto en la consola o en phpMyAdmin.** Un cambio de esquema siempre se hace igual: se edita el `CREATE TABLE` de `ddl.sql` y se ajustan los `INSERT` de `deploy.sql` y `development.sql`. Lo mismo aplica a `DROP COLUMN`, `ADD INDEX`, `MODIFY`, `RENAME`, etc.

Cuando cambie la base de datos:

1. **`ddl.sql`** — se edita el `CREATE TABLE` afectado (columna nueva, tabla nueva, índice, FK…). Toda tabla lleva `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci`.
2. **`deploy.sql`** — la columna nueva entra en la **lista de columnas del `INSERT`** y **cada fila recibe su valor**. No se deja caer en el valor por defecto ni se arregla después con un `UPDATE` al final: el archivo tiene que quedar coherente por sí solo, fila por fila. Las tablas van en **orden de dependencia** (primero las referenciadas) y con los `id` explícitos, para no romper las claves foráneas.
3. **`development.sql`** — se ajustan sus `INSERT` igual, para que el entorno local refleje lo mismo que producción.

Un cambio de esquema no está terminado hasta que los tres archivos son consistentes entre sí.

## Aplicar los cambios

La base se **recrea** siempre en dos pasos: estructura y luego datos.

```bash
# Local, desde cero (esquema + semilla)
mysql -u root -p <base> < database/ddl.sql
mysql -u root -p <base> < database/development.sql

# Réplica de producción (mismo esquema, datos reales)
mysql -u root -p <base> < database/ddl.sql
mysql -u root -p <base> < database/deploy.sql
```

**En producción el cambio de esquema también se aplica recreando, no parcheando:**

1. Exportar los datos actuales de producción y volcarlos en los `INSERT` de `deploy.sql`.
2. Ajustar el `CREATE TABLE` en `ddl.sql` y los `INSERT` de los otros dos archivos (columna nueva incluida, valor por fila).
3. Importar en el servidor `ddl.sql` y luego `deploy.sql`.

Por eso `deploy.sql` tiene que estar siempre al día: es el respaldo con el que se reconstruye. Si el paso 1 se salta, se pierden los datos que hayan entrado desde el último volcado.

## Notas del esquema

- `visitas` y `visitas_pagina` se llenan solas al navegar el sitio; nunca llevan datos semilla.
- `blog.ref_tipo` y `blog.ref_id` son **legado**: los recursos asociados a una entrada de Tékhne viven en `blog_recursos` (varios por entrada). Las columnas siguen en la tabla pero no se leen ni se escriben.
- `peliculas_series.duracion` guarda **minutos totales**; el formulario los captura como horas + minutos. Las series no llevan duración.
- `peliculas_series.seleccion` es un flag **manual** (1 = aparece en «Selección del Autor»). No se deduce de la nota. En `deploy.sql` viene en 1 solo para los títulos con nota 10, que era el criterio anterior.
