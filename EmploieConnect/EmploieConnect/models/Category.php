<?php
/**
 * Modèle pour les catégories
 */

class Category {
    private $pdo;
    
    public function __construct($database) {
        $this->pdo = $database;
    }
    
    /**
     * Récupérer toutes les catégories
     */
    public function getAll() {
        $sql = "SELECT c.*, COUNT(a.id) as article_count 
                FROM categories c 
                LEFT JOIN articles a ON c.id = a.categorie_id AND a.actif = 1 
                WHERE c.actif = 1 
                GROUP BY c.id 
                ORDER BY c.ordre ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer une catégorie par son slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = :slug AND actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Récupérer une catégorie par son ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id AND actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Compter le nombre total de catégories
     */
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM categories WHERE actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Créer une nouvelle catégorie
     */
    public function create($data) {
        $sql = "INSERT INTO categories (nom, slug, description, couleur, icone, actif, ordre, date_creation) 
                VALUES (:nom, :slug, :description, :couleur, :icone, 1, 0, NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':couleur', $data['couleur']);
        $stmt->bindValue(':icone', $data['icone']);
        
        return $stmt->execute();
    }
    
    /**
     * Mettre à jour une catégorie
     */
    public function update($id, $data) {
        $sql = "UPDATE categories 
                SET nom = :nom, slug = :slug, description = :description, 
                    couleur = :couleur, icone = :icone 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':couleur', $data['couleur']);
        $stmt->bindValue(':icone', $data['icone']);
        
        return $stmt->execute();
    }
    
    /**
     * Supprimer une catégorie (soft delete)
     */
    public function delete($id) {
        $sql = "UPDATE categories SET actif = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
