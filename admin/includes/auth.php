<?php
// Sécuriser la session
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', 
    'secure' => true,  // Uniquement en HTTPS
    'httponly' => true, // Empêche l'accès JavaScript
    'samesite' => 'Strict' // Protège contre les attaques CSRF
]);
session_start();

if (!isset($_SESSION['fingerprint'])) {
    $_SESSION['fingerprint'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
} elseif ($_SESSION['fingerprint'] !== hash('sha256', $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}


// Générer et vérifier les tokens CSRF
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Générer un token CSRF pour cette session
$csrf_token = generateCSRFToken();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Vérifier si l'utilisateur a le rôle d'administrateur
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}