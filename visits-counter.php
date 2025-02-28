<?php
require_once __DIR__ . '/mongo.php';

function incrementVisitCounter() {
    global $mongodb;
    
    try {
        $visitsCollection = $mongodb->visits;
        
        // Récupérer le document de compteur ou en créer un s'il n'existe pas
        $counter = $visitsCollection->findOne(['_id' => 'site_counter']);
        
        if ($counter) {
            // Incrémenter le compteur existant
            $visitsCollection->updateOne(
                ['_id' => 'site_counter'],
                ['$inc' => ['count' => 1]]
            );
            
            return $counter['count'] + 1;
        } else {
            // Créer un nouveau compteur s'il n'existe pas
            $visitsCollection->insertOne([
                '_id' => 'site_counter',
                'count' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return 1;
        }
    } catch (Exception $e) {
        error_log("Erreur compteur visites: " . $e->getMessage());
        return 0; // Retourner 0 en cas d'erreur
    }
}

function getVisitCount() {
    global $mongodb;
    
    try {
        $visitsCollection = $mongodb->visits;
        $counter = $visitsCollection->findOne(['_id' => 'site_counter']);
        
        return $counter ? $counter['count'] : 0;
    } catch (Exception $e) {
        error_log("Erreur compteur visites: " . $e->getMessage());
        return 0;
    }
}