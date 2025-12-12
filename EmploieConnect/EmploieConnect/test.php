<?php
echo "✅ PHP fonctionne !<br>";
echo "📅 Date : " . date('Y-m-d H:i:s') . "<br>";
echo "🌐 Serveur : " . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "<br>";
echo "📁 Chemin : " . __DIR__ . "<br>";

// Test de connexion à la base de données
try {
    require_once 'config/database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    
    if ($pdo) {
        echo "✅ Connexion base de données réussie !<br>";
        
        // Test simple
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM articles");
        $result = $stmt->fetch();
        echo "📊 Nombre d'articles : " . $result['count'] . "<br>";
    } else {
        echo "❌ Erreur de connexion à la base de données<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "<br>";
}
?>
