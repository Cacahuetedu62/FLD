<?php
session_start();
// Détruire la session
$_SESSION = array();
session_destroy();
// Redirection vers la page de connexion
header('Location: login.php');
exit;