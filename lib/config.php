<?php
function loadEnv($file) {
    if (!file_exists($file)) {
        throw new Exception("Fichier .env introuvable.");
    }
    
    $env = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignorer les commentaires
        if (strpos($line, '=') === false) continue; // Ignorer les lignes sans '='
        list($key, $value) = explode('=', $line, 2);
        $env[$key] = trim($value);
    }
    
    return $env;
}

// Charger les variables d'environnement
$env = loadEnv(__DIR__ . '/../.env');

$config = [
    'db' => [
        'host' => $env['DB_HOST'] ?? 'localhost',
        'name' => $env['DB_NAME'] ?? '',
        'user' => $env['DB_USER'] ?? '',
        'pass' => $env['DB_PASS'] ?? '',
        'charset' => $env['DB_CHARSET'] ?? 'utf8mb4'
    ],
    'smtp' => [
        'host' => $env['SMTP_HOST'] ?? '',
        'user' => $env['SMTP_USER'] ?? '',
        'pass' => $env['SMTP_PASS'] ?? ''
    ],
    'recaptcha' => [
        'site_key' => '6LdAc-kqAAAAANs2nj1AU5JIpr6l8o2uTaS-X2Y5',
        'secret_key' => '6LdAc-kqAAAAAFX0eAY41GE59Jj5zzeVwPDGuvSb'
    ],
    'debug' => filter_var($env['DEBUG'] ?? 'false', FILTER_VALIDATE_BOOLEAN)
];

return $config;
?>