<?php
function loadEnv($file) {
    if (!file_exists($file)) {
        throw new Exception("Fichier .env introuvable.");
    }

    $env = [];
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignorer les commentaires
        list($key, $value) = explode('=', $line, 2);
        $env[$key] = trim($value);
    }

    return $env;
}

// Charger les variables d'environnement
$env = loadEnv(__DIR__ . '/../.env');

$config = [
    'db' => [
        'host' => $env['DB_HOST'],
        'name' => $env['DB_NAME'],
        'user' => $env['DB_USER'],
        'pass' => $env['DB_PASS'],
        'charset' => $env['DB_CHARSET']
    ],
    'mongodb' => [
        'host' => $env['MONGO_HOST'],
        'port' => $env['MONGO_PORT'],
        'db'   => $env['MONGO_DB']
    ],
    'smtp' => [
        'host' => $env['SMTP_HOST'],
        'user' => $env['SMTP_USER'],
        'pass' => $env['SMTP_PASS']
    ],
    'recaptcha' => [
        'site_key' => $env['RECAPTCHA_SITE_KEY'],
        'secret_key' => $env['RECAPTCHA_SECRET_KEY']
    ],
    'debug' => filter_var($env['DEBUG'], FILTER_VALIDATE_BOOLEAN)
];

return $config; // Ne pas oublier de retourner la variable $config
?>
