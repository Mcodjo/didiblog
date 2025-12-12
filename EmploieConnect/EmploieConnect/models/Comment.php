<?php

class Comment {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getByArticleId($articleId, $limit = 50, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.username, u.prenom, u.nom 
            FROM comments c 
            LEFT JOIN users u ON c.user_id = u.id 
            WHERE c.article_id = :article_id AND c.status = 'approved'
            ORDER BY c.created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAll($limit = 50, $offset = 0, $status = null) {
        $whereClause = '';
        $params = [];
        
        if ($status) {
            $whereClause = 'WHERE c.status = :status';
            $params[':status'] = $status;
        }
        
        $stmt = $this->pdo->prepare("
            SELECT c.*, a.titre as article_title, u.username, u.prenom, u.nom 
            FROM comments c 
            LEFT JOIN articles a ON c.article_id = a.id 
            LEFT JOIN users u ON c.user_id = u.id 
            {$whereClause}
            ORDER BY c.created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if ($status) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO comments (article_id, user_id, author_name, author_email, content, status, created_at) 
            VALUES (:article_id, :user_id, :author_name, :author_email, :content, :status, NOW())
        ");
        
        return $stmt->execute([
            ':article_id' => $data['article_id'],
            ':user_id' => $data['user_id'] ?? null,
            ':author_name' => $data['author_name'],
            ':author_email' => $data['author_email'],
            ':content' => $data['content'],
            ':status' => $data['status'] ?? 'pending'
        ]);
    }
    
    public function getCount($articleId) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM comments 
            WHERE article_id = :article_id AND status = 'approved'
        ");
        $stmt->execute([':article_id' => $articleId]);
        return $stmt->fetchColumn();
    }
    
    public function getPending($limit = 20, $offset = 0) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, a.titre as article_title 
            FROM comments c 
            LEFT JOIN articles a ON c.article_id = a.id 
            WHERE c.status = 'pending'
            ORDER BY c.created_at DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("
            UPDATE comments SET status = :status WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    public function getStats() {
        $stmt = $this->pdo->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today
            FROM comments
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
