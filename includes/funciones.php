<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html = '') : string {
    return htmlspecialchars($html ?? '');
}

// Ruta absoluta dentro de public/build (para subidas)
function rutaBuild(string $rel = '') : string {
    return dirname(__DIR__) . '/public/build/' . ltrim($rel, '/\\');
}

// Enlace de WhatsApp con mensaje opcional (México +52)
function waLink(string $mensaje = '') : string {
    $base = 'https://wa.me/525637185620';
    return $mensaje !== '' ? $base . '?text=' . rawurlencode($mensaje) : $base;
}

// Genera un slug URL-amigable a partir de un texto
function generarSlug(string $texto) : string {
    $texto = strtolower(trim($texto));
    $texto = strtr($texto, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ñ'=>'n','ü'=>'u']);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    return trim($texto, '-') ?: 'articulo';
}

/**
 * Sube un archivo de $_FILES[$campo] a $dirDestino con nombre único.
 * Devuelve el nombre de archivo guardado, o null si no hubo archivo/falló.
 */
function subirArchivo(string $campo, string $dirDestino, string $prefijo, array $extensiones, int $maxMB = 8) : ?string {
    if (empty($_FILES[$campo]) || ($_FILES[$campo]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $extensiones, true)) return null;
    if ($_FILES[$campo]['size'] > $maxMB * 1024 * 1024) return null;

    if (!is_dir($dirDestino)) mkdir($dirDestino, 0775, true);
    $filename = $prefijo . '-' . time() . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
    $destino  = rtrim($dirDestino, '/\\') . DIRECTORY_SEPARATOR . $filename;

    return move_uploaded_file($_FILES[$campo]['tmp_name'], $destino) ? $filename : null;
}

// Inicia la sesión una sola vez
function iniciarSesion() : void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// ¿Hay un usuario autenticado?
function estaAutenticado() : bool {
    iniciarSesion();
    return !empty($_SESSION['id']);
}

// ¿El usuario autenticado es administrador?
function esAdmin() : bool {
    iniciarSesion();
    return !empty($_SESSION['admin']);
}

// Saneado básico de HTML del editor (contenido solo de admin): permite un
// conjunto de etiquetas y elimina atributos de evento y URLs peligrosas.
function sanitizarHtml(string $html) : string {
    $permitidas = '<h2><h3><p><br><strong><b><em><i><u><ul><ol><li><a><img><blockquote><hr><code><pre>';
    $html = strip_tags($html, $permitidas);
    // Quita atributos on* (onclick, onerror, …)
    $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    // Neutraliza javascript: en href/src
    $html = preg_replace('/(href|src)\s*=\s*("|\')\s*javascript:[^"\']*(\2)/i', '$1=$2#$2', $html);
    return trim($html);
}

// Notificación flash (se muestra como toast tras un redirect POST→GET)
function flash(string $mensaje, string $tipo = 'ok') : void {
    iniciarSesion();
    $_SESSION['_flash'][] = ['tipo' => $tipo, 'msg' => $mensaje];
}

// Devuelve y limpia las notificaciones flash pendientes
function obtenerFlash() : array {
    iniciarSesion();
    $f = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $f;
}

// Guarda para rutas del panel: redirige a /login si no es admin
function protegerAdmin() : void {
    if (!esAdmin()) {
        header('Location: /login');
        exit;
    }
}

// Iconos SVG inline (estilo línea) usados en el panel
function icono(string $n) : string {
    $p = [
        'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        'proyectos' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
        'servicios' => '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>',
        'credenciales' => '<circle cx="12" cy="8" r="6"/><path d="M8.2 13.9L7 22l5-3 5 3-1.2-8.1"/>',
        'blog' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>',
        'cv' => '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
        'libros' => '<path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>',
        'peliculas' => '<rect x="2" y="2" width="20" height="20" rx="2"/><path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"/>',
        'videojuegos' => '<rect x="2" y="6" width="20" height="12" rx="6"/><line x1="6" y1="12" x2="10" y2="12"/><line x1="8" y1="10" x2="8" y2="14"/><line x1="15" y1="13" x2="15.01" y2="13"/><line x1="18" y1="11" x2="18.01" y2="11"/>',
        'gym' => '<path d="M6.5 6.5l11 11M21 21l-1-1M3 3l1 1M18 22l4-4M2 6l4-4M7 17l-2.5 2.5M17 7l2.5-2.5"/>',
        'finanzas' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>',
        'horario' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'mapa' => '<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1 2.7 3 6 3s6-2 6-3v-5"/>',
        'logout' => '<path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'menu' => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'film' => '<rect x="2" y="2" width="20" height="20" rx="2"/><path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"/>',
        'cuenta' => '<circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/>',
        'editar' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>',
        'eliminar' => '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>',
        'ok' => '<path d="M20 6L9 17l-5-5"/>',
        'estrella' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'externo' => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
        'trash' => '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>',
        'descargar' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
        'documento' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/>',
    ];
    $inner = $p[$n] ?? '';
    return '<svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
}
