<?php
// Inclure votre fichier de connexion MongoDB existant
require_once __DIR__ . '/mongo.php';

// Fonction pour détecter les bots
function isBot() {
    // Liste d'agents utilisateurs de bots courants
    $botSignatures = [
        'bot', 'crawl', 'spider', 'slurp', 'baiduspider', 
        'yandex', 'googlebot', 'bingbot', 'semrushbot'
    ];
    
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    
    // Vérifier si l'agent utilisateur contient une signature de bot
    foreach ($botSignatures as $signature) {
        if (strpos($userAgent, $signature) !== false) {
            return true;
        }
    }
    
    // Vérification des en-têtes suspects
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        return true;
    }
    
    return false;
}

// Fonction pour limiter les comptages multiples par IP
function shouldCountVisit($mongodb) {
    // Récupérer l'adresse IP du visiteur
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Récupérer la collection des IPs
    $ipCollection = $mongodb->ip_visits;
    
    // Vérifier si cette IP a été vue récemment (dernières 24h)
    $result = $ipCollection->findOne([
        'ip' => $ip,
        'timestamp' => ['$gt' => time() - 24 * 3600]
    ]);
    
    if ($result) {
        return false; // IP déjà vue récemment, ne pas compter
    }
    
    // Enregistrer cette visite pour l'IP
    $ipCollection->insertOne([
        'ip' => $ip,
        'timestamp' => time(),
        'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'date' => date('Y-m-d H:i:s')
    ]);
    
    return true;
}

// Fonction de récupération du compteur avec mise en cache par fichier
function getVisitCount() {
    global $mongodb;
    
    $cacheFile = __DIR__ . '/cache/visit_count.txt';
    $cacheTTL = 300; // 5 minutes
    
    // Vérifier si le fichier de cache existe et est récent
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTTL)) {
        return (int)file_get_contents($cacheFile);
    }
    
    try {
        $visitsCollection = $mongodb->visits;
        $counter = $visitsCollection->findOne(['_id' => 'site_counter']);
        $count = $counter ? $counter['count'] : 0;
        
        // S'assurer que le répertoire de cache existe
        if (!is_dir(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0755, true);
        }
        
        // Mettre en cache
        file_put_contents($cacheFile, $count);
        
        return $count;
    } catch (Exception $e) {
        error_log("Erreur compteur visites: " . $e->getMessage());
        return 0;
    }
}

// Fonction modifiée pour incrémenter le compteur avec protection
function incrementVisitCounter() {
    global $mongodb;
    
    // Ne pas compter les bots
    if (isBot()) {
        return getVisitCount();
    }
    
    // Vérifier si on doit compter cette visite (limitation par IP)
    if (!shouldCountVisit($mongodb)) {
        return getVisitCount();
    }
    
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
            
            $newCount = $counter['count'] + 1;
        } else {
            // Créer un nouveau compteur s'il n'existe pas
            $visitsCollection->insertOne([
                '_id' => 'site_counter',
                'count' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $newCount = 1;
        }
        
        // Mettre à jour le cache fichier
        $cacheFile = __DIR__ . '/cache/visit_count.txt';
        
        // S'assurer que le répertoire de cache existe
        if (!is_dir(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0755, true);
        }
        
        // Mettre en cache
        file_put_contents($cacheFile, $newCount);
        
        return $newCount;
    } catch (Exception $e) {
        error_log("Erreur compteur visites: " . $e->getMessage());
        return 0; // Retourner 0 en cas d'erreur
    }
}