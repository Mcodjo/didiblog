<?php
// Script d'installation rapide de la base de données
require_once 'config/config.php';

try {
    // Connexion sans spécifier la base de données
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de données '" . DB_NAME . "' créée ou existe déjà<br>";
    
    // Sélectionner la base de données
    $pdo->exec("USE " . DB_NAME);
    
    // Lire et exécuter le fichier SQL
    $sqlFile = __DIR__ . '/database/schema.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        
        // Diviser en requêtes individuelles
        $queries = explode(';', $sql);
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query)) {
                $pdo->exec($query);
            }
        }
        
        echo "✅ Tables créées et données insérées avec succès<br>";
        echo "🎉 Installation terminée ! Vous pouvez maintenant utiliser le site.<br>";
        echo "<br><strong>Liens utiles :</strong><br>";
        echo "• <a href='" . SITE_URL . "'>Accueil du site</a><br>";
        echo "• <a href='" . SITE_URL . "/login.php'>Connexion admin</a> (admin / admin123)<br>";
        echo "• <a href='" . SITE_URL . "/blog.php'>Blog</a><br>";
        
    } else {
        echo "❌ Fichier schema.sql introuvable";
    }
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
