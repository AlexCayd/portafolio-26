<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $titulo ?? 'Alexander Oliva'; ?> - Alexander Oliva</title>
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0a0a0b">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('/build/img/favicon-32.png'); ?>">
<link rel="icon" type="image/png" sizes="512x512" href="<?php echo asset('/build/img/favicon-512.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('/build/img/favicon-180.png'); ?>">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo asset('/build/css/admin.css'); ?>">
</head>
<body class="auth-body">
    <?php echo $contenido; ?>
</body>
</html>
