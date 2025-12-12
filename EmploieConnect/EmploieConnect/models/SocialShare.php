<?php

class SocialShare {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getShareCounts($articleId) {
        $stmt = $this->pdo->prepare("
            SELECT platform, share_count 
            FROM social_shares 
            WHERE article_id = :article_id
        ");
        $stmt->execute([':article_id' => $articleId]);
        $shares = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        // Retourner avec valeurs par défaut
        return [
            'facebook' => $shares['facebook'] ?? 0,
            'twitter' => $shares['twitter'] ?? 0,
            'linkedin' => $shares['linkedin'] ?? 0,
            'whatsapp' => $shares['whatsapp'] ?? 0
        ];
    }
    
    public function incrementShare($articleId, $platform) {
        $stmt = $this->pdo->prepare("
            INSERT INTO social_shares (article_id, platform, share_count) 
            VALUES (:article_id, :platform, 1)
            ON DUPLICATE KEY UPDATE share_count = share_count + 1
        ");
        
        return $stmt->execute([
            ':article_id' => $articleId,
            ':platform' => $platform
        ]);
    }
    
    public function getTotalShares($articleId) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(share_count) as total 
            FROM social_shares 
            WHERE article_id = :article_id
        ");
        $stmt->execute([':article_id' => $articleId]);
        return $stmt->fetchColumn() ?: 0;
    }
    
    public function getTopSharedArticles($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT a.id, a.titre, a.slug, SUM(s.share_count) as total_shares
            FROM articles a
            LEFT JOIN social_shares s ON a.id = s.article_id
            WHERE a.actif = 1
            GROUP BY a.id
            ORDER BY total_shares DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
