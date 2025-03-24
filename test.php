<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $host = 'db';
    $dbname = 'u301331392_fld_agencement';
    $user = 'root';
    $pass = 'root';
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vérifier la structure de la table projets
    echo "Structure de la table projets:<br>";
    $stmt = $pdo->query("DESCRIBE projets");
    echo "<pre>";
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo "</pre>";
    
    // Tester une requête simple sans ORDER BY
    echo "Test d'une requête simple:<br>";
    $stmt = $pdo->query("SELECT * FROM projets");
    $projets = $stmt->fetchAll();
    echo "Nombre de résultats: " . count($projets) . "<br>";
    
    if (count($projets) > 0) {
        echo "Premier projet:<br>";
        echo "<pre>";
        print_r($projets[0]);
        echo "</pre>";
    }
} catch (PDOException $e) {
    echo "Erreur PDO: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur générale: " . $e->getMessage();
}
?>