<?php
session_start();

// Sécuriser la destruction de session
if (isset($_SESSION)) {
    // Supprimer toutes les variables de session
    $_SESSION = [];
    
    // Supprimer le cookie de session si existant
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, 
            $params["path"], $params["domain"], 
            $params["secure"], $params["httponly"]
        );
    }
    
    // Détruire la session
    session_destroy();
}

// Redirection vers la page de connexion
header('Location: login.php');
exit;