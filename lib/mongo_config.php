<?php
// lib/mongo_config.php

function getMongoConnection() {
    // Identifiants fixes comme demandé
    $mongoUser = 'ADMIN';
    $mongoPass = 'TESTMONGO';
    $mongoHost = 'cluster0.4zzliga.mongodb.net';
    $mongoDb = 'fld_agencement';
    
    // URI de connexion MongoDB Atlas
    $uri = "mongodb+srv://{$mongoUser}:{$mongoPass}@{$mongoHost}/{$mongoDb}?retryWrites=true&w=majority";
    
    try {
        // Créer une nouvelle instance du client MongoDB
        $client = new MongoDB\Client($uri);
        return $client->selectDatabase($mongoDb);
    } catch (Exception $e) {
        error_log('Erreur de connexion MongoDB: ' . $e->getMessage());
        return null;
    }
}
?>