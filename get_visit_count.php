<?php
header('Content-Type: application/json');
require_once __DIR__ . '/lib/visit_counter.php';

$count = getVisitCount();
echo json_encode(['count' => $count]);
?>