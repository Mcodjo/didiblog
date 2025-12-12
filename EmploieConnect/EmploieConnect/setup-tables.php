<?php
require_once 'config/config.php';
require_once 'core/functions.php';

try {
    $pdo = getDatabase();
    
    echo "<h2>Création des nouvelles tables...</h2>";
    
    // Table des commentaires
    $sql_comments = "
    CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        article_id INT NOT NULL,
        user_id INT NULL,
        author_name VARCHAR(100) NOT NULL,
        author_email VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
        INDEX idx_article (article_id),
        INDEX idx_status (status),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql_comments);
    echo "✅ Table 'comments' créée avec succès<br>";
    
    // Table des partages sociaux
    $sql_social_shares = "
    CREATE TABLE IF NOT EXISTS social_shares (
        id INT AUTO_INCREMENT PRIMARY KEY,
        article_id INT NOT NULL,
        platform VARCHAR(50) NOT NULL,
        share_count INT DEFAULT 0,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
        UNIQUE KEY unique_article_platform (article_id, platform),
        INDEX idx_article (article_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $pdo->exec($sql_social_shares);
    echo "✅ Table 'social_shares' créée avec succès<br>";
    
    // Ajouter des index FULLTEXT pour la recherche (si pas déjà présents)
    try {
        $pdo->exec("ALTER TABLE articles ADD FULLTEXT(titre, extrait)");
        echo "✅ Index FULLTEXT ajouté sur articles<br>";
    } catch (Exception $e) {
        echo "ℹ️ Index FULLTEXT déjà présent ou erreur: " . $e->getMessage() . "<br>";
    }
    
    // Insérer quelques commentaires de test
    $test_comments = [
        [
            'article_id' => 1,
            'author_name' => 'Marie Dupont',
            'author_email' => 'marie@example.com',
            'content' => 'Excellent article ! Ces conseils m\'ont vraiment aidée dans ma recherche d\'emploi.',
            'status' => 'approved'
        ],
        [
            'article_id' => 1,
            'author_name' => 'Pierre Martin',
            'author_email' => 'pierre@example.com',
            'content' => 'Merci pour ces astuces pratiques. J\'ai hâte de les mettre en application.',
            'status' => 'pending'
        ],
        [
            'article_id' => 2,
            'author_name' => 'Sophie Laurent',
            'author_email' => 'sophie@example.com',
            'content' => 'Très instructif ! Pourriez-vous faire un article sur les entretiens vidéo ?',
            'status' => 'approved'
        ]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO comments (article_id, author_name, author_email, content, status, created_at) 
        VALUES (:article_id, :author_name, :author_email, :content, :status, NOW())
    ");
    
    foreach ($test_comments as $comment) {
        try {
            $stmt->execute($comment);
        } catch (Exception $e) {
            // Ignorer si déjà inséré
        }
    }
    echo "✅ Commentaires de test ajoutés<br>";
    
    // Insérer quelques partages de test
    $test_shares = [
        ['article_id' => 1, 'platform' => 'facebook', 'share_count' => 15],
        ['article_id' => 1, 'platform' => 'twitter', 'share_count' => 8],
        ['article_id' => 1, 'platform' => 'linkedin', 'share_count' => 12],
        ['article_id' => 2, 'platform' => 'facebook', 'share_count' => 7],
        ['article_id' => 2, 'platform' => 'linkedin', 'share_count' => 5]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO social_shares (article_id, platform, share_count) 
        VALUES (:article_id, :platform, :share_count)
        ON DUPLICATE KEY UPDATE share_count = VALUES(share_count)
    ");
    
    foreach ($test_shares as $share) {
        $stmt->execute($share);
    }
    echo "✅ Données de partage de test ajoutées<br>";
    
    echo "<br><h3>🎉 Toutes les tables ont été créées avec succès !</h3>";
    echo "<p>Vous pouvez maintenant:</p>";
    echo "<ul>";
    echo "<li>✅ Voir les commentaires sur les articles</li>";
    echo "<li>✅ Modérer les commentaires dans l'admin</li>";
    echo "<li>✅ Suivre les partages sociaux avec compteurs</li>";
    echo "<li>✅ Bénéficier des recommandations intelligentes</li>";
    echo "</ul>";
    
    echo "<p><a href='admin/comments.php' style='color: #f97316; font-weight: bold;'>→ Aller à la gestion des commentaires</a></p>";
    echo "<p><a href='blog.php' style='color: #f97316; font-weight: bold;'>→ Voir le blog avec les nouvelles fonctionnalités</a></p>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Erreur lors de la création des tables:</h3>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
}
?>
