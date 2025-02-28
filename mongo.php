<?php
// Charger l'autoloader de Composer si vous utilisez Composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}


$configPath = '';
$possiblePaths = [
    __DIR__ . '/config.php',
    __DIR__ . '/lib/config.php',
    __DIR__ . '/../lib/config.php'
];

foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $configPath = $path;
        break;
    }
}

if (empty($configPath)) {
    die("Le fichier config.php est introuvable. Vérifiez l'emplacement du fichier.");
}

// Inclure le fichier de configuration
$config = require_once $configPath;

// Reste du code...

class MongoDBConnection {
    private $client;
    private $database;

    public function __construct($config) {
        try {
            // Création de la connexion MongoDB
            $mongoUri = "mongodb://{$config['mongodb']['host']}:{$config['mongodb']['port']}";
            $this->client = new MongoDB\Client($mongoUri);
            
            // Sélection de la base de données
            $this->database = $this->client->{$config['mongodb']['db']};
            
            if ($config['debug']) {
                echo "<!-- Connexion MongoDB réussie -->";
            }
        } catch (Exception $e) {
            error_log("Erreur de connexion MongoDB: " . $e->getMessage());
            if ($config['debug']) {
                echo "<!-- Erreur MongoDB: " . $e->getMessage() . " -->";
            }
        }
    }

    public function getDatabase() {
        return $this->database;
    }
}

// Assurez-vous d'avoir l'extension MongoDB PHP installée
if (!extension_loaded('mongodb')) {
    error_log("L'extension MongoDB PHP n'est pas installée");
    echo "L'extension MongoDB PHP n'est pas installée. Veuillez l'installer pour utiliser le compteur de visites.";
}

// Instancier la connexion MongoDB
$mongoConnection = new MongoDBConnection($config);
$mongodb = $mongoConnection->getDatabase();