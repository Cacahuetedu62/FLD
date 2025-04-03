<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Ajouter si nécessaire pour des requêtes cross-origin
require_once __DIR__ . '/lib/visit_counter.php';

$count = getVisitCount();
echo json_encode(['count' => $count]);
?>