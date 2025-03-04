<?php
session_start();

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