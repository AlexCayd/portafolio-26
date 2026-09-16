# CLAUDE.md — Base de datos

En esta carpeta **solo debe existir un archivo de SQL**: la última copia de producción.

| Archivo | Qué es | Quién lo escribe |
|---|---|---|
| `u277274915_a_oliva.sql` | Volcado completo de la base de producción (estructura + datos), tal como lo exporta phpMyAdmin. Es a la vez el **respaldo** y la **fuente de verdad del esquema**. | Se descarga de producción; **nunca se edita a mano** |

El nombre es el que pone phpMyAdmin (el de la base). Al descargar una copia nueva se **reemplaza el archivo entero**: no se guardan copias con fecha, ni `-old`, ni `-backup`, ni `-v2`. El historial lo lleva git.

## Ni migraciones ni archivos auxiliares

**No se crea ningún otro archivo aquí.** Ni `ddl.sql`, ni `deploy.sql`, ni `development.sql`, ni `migracion-*.sql`, ni `alter-*.sql`, ni `patch-*.sql`, ni carpetas de versiones, ni scripts que generen SQL a partir del volcado. Este proyecto no lleva historial de cambios de esquema: el esquema es el que traiga el volcado de hoy.

**El volcado no se edita.** No se le recortan tablas, no se le añaden `INSERT`, no se le cambian datos ni se le reordena nada. Si algo tiene que cambiar en la base, se cambia donde manda —el panel o producción— y después se descarga una copia nueva.

## Cambios de esquema

El esquema vive en producción, así que ahí se cambia: desde phpMyAdmin, o desde el panel cuando la aplicación ya sabe hacerlo. Después:

1. Descargar el volcado nuevo y reemplazar el archivo de esta carpeta.
2. Ajustar el modelo de `models/` afectado: su `$columnasDB` tiene que coincidir **exactamente** con las columnas que traiga la tabla en el volcado nuevo.
3. Reimportar en local para trabajar contra el mismo esquema que sirve el sitio.

Mientras el cambio no esté en producción, no está en ningún lado: el repo ya no guarda un esquema aparte. Un cambio de esquema hecho solo en local se pierde en cuanto se descarga el siguiente volcado.

Conviene descargar el volcado seguido, y siempre antes de tocar la base: es el único respaldo. Entre una descarga y la siguiente, lo que se haya cargado desde el panel vive únicamente en el servidor.

## Importar en local

El volcado trae `CREATE TABLE` sin `DROP TABLE`, así que la base **tiene que estar vacía**: se recrea, nunca se importa encima de otra.

```bash
mysql -u root -e "DROP DATABASE IF EXISTS alexander_oliva; CREATE DATABASE alexander_oliva CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root --default-character-set=utf8mb4 alexander_oliva < database/u277274915_a_oliva.sql
```

El nombre de la base y las credenciales salen de `includes/.env`. Al importar quedan en local **los datos reales de producción**, usuario del panel incluido: se entra con el mismo usuario y PIN que en el sitio. Para usar otro PIN en local se cambia desde `/admin/cuenta`, o se reemplaza el hash en la tabla `usuarios` de la base local — nunca en el archivo del volcado.

Las imágenes son otra cosa: la base guarda solo el nombre del archivo y los archivos viven en `public/uploads/` del servidor. Los que no estén en local hacen que la vista caiga en su placeholder; no es un error del volcado.

## Notas del esquema

- **El volcado trae tablas de otro proyecto**, porque comparten base en el hosting: `areas_produccion`, `categorias`, `dias_reservacion`, `feedback`, `feedback_tokens`, `horarios_reservacion`, `impresoras`, `menu`, `mesas`, `productos`, `reservaciones`, `reservacion_mesas`, `tickets`, `ticket_items` y `ticket_pagos`. Este sitio no las lee ni las escribe: se ignoran y **no se borran del archivo**.
- `visitas` y `visitas_pagina` se llenan solas al navegar el sitio.
- `blog.ref_tipo` y `blog.ref_id` son **legado**: los recursos asociados a una entrada de Tékhne viven en `blog_recursos` (varios por entrada). Las columnas siguen en la tabla pero no se leen ni se escriben.
- `peliculas_series.duracion` guarda **minutos totales**; el formulario los captura como horas + minutos. Las series no llevan duración.
- `peliculas_series.seleccion` es un flag **manual** (1 = aparece en «Selección del Autor»). No se deduce de la nota.
- Las columnas de imagen (`cover_img`, `poster`, `portada`, `logo`, `img`) guardan **solo el nombre del archivo**; la ruta la arma `urlSubida()` contra `public/uploads/`.
