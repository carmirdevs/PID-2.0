<?php
/** Copiar como config.local.php únicamente en el servidor; no subir secretos a GitHub. */
return [
    'host' => 'localhost',
    'database' => 'NOMBRE_BASE_DE_DATOS',
    'username' => 'USUARIO_BASE_DE_DATOS',
    'password' => 'CAMBIAR_CONTRASENA',
    'base_url' => 'https://ejemplo.org/validacion/public',
    'rate_secret' => 'REEMPLAZAR_POR_UN_SECRETO_ALEATORIO_DE_AL_MENOS_32_CARACTERES',
];
