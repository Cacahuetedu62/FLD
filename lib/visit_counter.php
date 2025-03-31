<?php
require_once __DIR__ . '/../vendor/autoload.php'; 
require_once __DIR__ . '/mongo_config.php';

function incrementVisitCounter() {
    $database = getMongoConnection();
    
    if (!$database) {
        return false;
    }
    
    $statsCollection = $database->stats;
    
    // Utiliser la date actuelle comme identifiant pour les statistiques journalières
    $today = date('Y-m-d');
    
    // Mise à jour du compteur avec upsert (insertion si n'existe pas)
    $result = $statsCollection->updateOne(
        ['_id' => 'visitor_counter'],
        ['$inc' => ['total' => 1, "daily.{$today}" => 1]],
        ['upsert' => true]
    );
    
    // Récupérer le total
    $stats = $statsCollection->findOne(['_id' => 'visitor_counter']);
    
    return $stats ? $stats->total : 0;
}

function getVisitCount() {
    $database = getMongoConnection();
    
    if (!$database) {
        return 0;
    }
    
    $statsCollection = $database->stats;
    $stats = $statsCollection->findOne(['_id' => 'visitor_counter']);
    
    return $stats ? $stats->total : 0;
}
?>