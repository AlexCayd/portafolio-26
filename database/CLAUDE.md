# CLAUDE.md — Base de datos

En esta carpeta solo deben existir **tres archivos de SQL**. Nada más.

| Archivo | Qué es | Quién lo escribe |
|---|---|---|
| `local.sql` | **Esquema + datos de este proyecto.** Es lo que se importa para trabajar en local y la referencia del esquema que espera el código. | A mano |
| `u277274915_a_oliva.sql` | Volcado de producción: estructura y datos de **las tablas del portafolio**. Es el **respaldo** y el origen de los datos. | Se descarga de producción y se recorta a las tablas del portafolio; los datos **no se editan** |
| `drops.sql` | **Solo `DROP TABLE IF EXISTS`** de las tablas del portafolio. Deja la base limpia sin cargar datos. | A mano |

**En esta carpeta solo hay tablas y datos del portafolio.** Las tablas del portafolio son exactamente las que crea `local.sql`; ningún archivo de aquí contiene otras.

## Montar la base local

Con un solo archivo basta. `local.sql` empieza tirando sus propias tablas, así que se puede reimportar cuantas veces haga falta:

```bash
mysql -u root -p <base> < database/local.sql
```

La base y las credenciales salen de `includes/.env`. Quedan los datos reales de producción, usuario del panel incluido: se entra con el mismo usuario y PIN que en el sitio.

`drops.sql` no hace falta para esto; sirve para vaciar la base sin volver a cargar datos, o antes de importar el volcado crudo, que trae `CREATE TABLE` sin `DROP` y falla si las tablas ya existen.

**No hay que tocar producción para trabajar en local.** El esquema que el código espera vive en `local.sql`, no en el servidor.

## Cambios de esquema

Se hacen **en `local.sql`**: se edita el `CREATE TABLE` afectado y se ajustan los `INSERT` de esa tabla, fila por fila, para que el archivo quede coherente por sí solo. Después se reimporta en local y se ajusta el modelo de `models/`: su `$columnasDB` tiene que coincidir **exactamente** con las columnas de la tabla.

Si la tabla es nueva, se le añade también su `DROP TABLE IF EXISTS` en `drops.sql`.

Reglas del archivo: toda tabla lleva `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci`; las tablas van en **orden de dependencia** (primero las referenciadas) y los `INSERT` con los `id` explícitos, para no romper las claves foráneas.

**Nada de migraciones**: ni `migracion-*.sql`, ni `alter-*.sql`, ni `patch-*.sql`, ni carpetas de versiones. El esquema es el que diga `local.sql` hoy.

## Cuando se descarga un volcado nuevo

1. Reemplazar `u277274915_a_oliva.sql` entero. No se guardan copias con fecha, ni `-old`, ni `-v2`: el historial lo lleva git.
2. **Recortarlo a las tablas del portafolio.** La base del hosting no es exclusiva del portafolio, así que phpMyAdmin exporta también tablas que no le pertenecen: se quitan su `CREATE TABLE`, sus `INSERT`, sus índices, sus `AUTO_INCREMENT` y sus claves foráneas. En el archivo solo queda lo de las tablas que crea `local.sql`.
3. Pasar a `local.sql` los datos nuevos, conservando el esquema que espera el código.

Conviene descargarlo seguido: es el único respaldo de producción. Entre una descarga y la siguiente, lo que se haya cargado desde el panel vive solo en el servidor.

Hoy el esquema de `local.sql` va **por delante** de producción: `pelicula_personas`, `proyecto_secciones`, `visitas_pagina_dia` y las columnas nuevas de `proyectos` (`resumen`, `contexto`, `enlace`) todavía no existen en el servidor, y ahí siguen vivas `proyectos.rol_titulo`, `proyectos.rol` y `proyectos.descripcion`, que aquí ya no están. El volcado trae el esquema viejo, así que **importarlo tal cual deja el sitio roto**; para local se usa `local.sql`.

## Desplegar el esquema en producción

`local.sql` es también el script de despliegue: se importa en phpMyAdmin con la base seleccionada (no lleva `CREATE DATABASE` ni `USE`) y solo toca las tablas del portafolio. Lleva los mismos `SET SQL_MODE`/`SET time_zone` que el volcado para que ids y `TIMESTAMP` entren tal cual.

**Tira y recrea cada tabla con los datos del archivo**, salvo `visitas_pagina_dia`, que se crea con `IF NOT EXISTS` y conserva lo que ya haya registrado el servidor (el relleno de `/` usa `INSERT IGNORE`). Lo que se haya cargado en producción después del último volcado se pierde, así que antes de correrlo: descargar un volcado fresco, pasar sus datos nuevos a `local.sql` y comprobar que los conteos de filas por tabla coinciden entre los dos archivos. Después se sube el código.

## Notas del esquema

- `visitas` y `visitas_pagina` se llenan solas al navegar el sitio; `visitas_pagina_dia` guarda el desglose por fecha que alimenta los periodos del dashboard. `visitas` solo se incrementa en la portada, así que es el histórico diario de `/`: `local.sql` lo copia a `visitas_pagina_dia` con un `INSERT … SELECT`. El resto de rutas solo tiene desglose desde el despliegue.
- `blog.ref_tipo` y `blog.ref_id` son **legado**: los recursos asociados a una entrada de Tékhne viven en `blog_recursos` (varios por entrada). Las columnas siguen en la tabla pero no se leen ni se escriben.
- La ficha de un proyecto se arma siempre igual: `proyectos.contexto`, la galería de `proyecto_imagenes` y después las filas de `proyecto_secciones` (título y cuerpo libres, en su `orden`). Ya no hay columnas `rol_titulo`/`rol` ni tabla `proyecto_stack`: el rol y el stack son secciones como cualquier otra. El `cuerpo` de una sección es siempre prosa: una línea en blanco separa párrafos y no hay otro formato (nada de tarjetas), para que todas las fichas se vean igual.
- Los directores de una película viven en `pelicula_personas` (varios por título, `orden` 1 = principal). La antigua columna `peliculas_series.autor` ya no existe.
- `peliculas_series.duracion` guarda **minutos totales**; el formulario los captura como horas + minutos. Las series no llevan duración.
- **Formato serie** (`Pelicula::esSerie()`): la categoría `Serie` siempre lo es. Las categorías con `pys_categorias.admite_serie = 1` (Documental, Reality, Stand Up) pueden ser serie marcando `peliculas_series.es_serie`; las demás (Película, Cortometraje) no. Una serie no lleva duración, su persona es «Creador» y se muestra como «Documental · Serie» (`categoriaTexto()`). Las estadísticas por categoría siguen usando solo `categoria`.
- **Puede haber títulos repetidos** (remakes, película y serie homónimas). Guardar sin `id` siempre crea un registro nuevo; el formulario pregunta antes «¿Te estás refiriendo a…?» con los homónimos (`Pelicula::porTituloTodos()`).
- `peliculas_series.seleccion` es un flag **manual** (1 = aparece en «Selección del Autor»). No se deduce de la nota.
- Las columnas de imagen (`cover_img`, `poster`, `portada`, `logo`, `img`) guardan **solo el nombre del archivo**; la ruta la arma `urlSubida()` contra `public/uploads/`. Si el archivo no está en local, la vista cae en su placeholder.
