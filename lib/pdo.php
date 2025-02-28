<?php
// Inclure le fichier de configuration
require_once __DIR__ . '/config.php';  // Si config.php est dans le même dossier que pdo.php





class Database {
    private $pdo;

    public function __construct($config) {
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset={$config['db']['charset']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage()); // Log de l'erreur
            die("Une erreur est survenue, veuillez réessayer plus tard."); // Message générique
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}

// Instancier la base de données
$database = new Database($config);
$pdo = $database->getConnection();
?>
