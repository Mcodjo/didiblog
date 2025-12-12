<?php
/**
 * Modèle pour les articles
 */

class Article {
    private $pdo;
    
    public function __construct($database) {
        $this->pdo = $database;
    }
    
    /**
     * Récupérer tous les articles
     */
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur 
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE a.actif = 1 
                ORDER BY a.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer un article par son slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, c.icone as categorie_icone, c.slug as categorie_slug
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE a.slug = :slug AND a.actif = 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Récupérer les articles par catégorie
     */
    public function getByCategory($categoryId, $limit = null) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur 
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE a.categorie_id = :category_id AND a.actif = 1 
                ORDER BY a.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        
        if ($limit) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer les articles vedettes
     */
    public function getFeatured($limit = 1) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur 
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE a.vedette = 1 AND a.actif = 1 
                ORDER BY a.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $limit === 1 ? $stmt->fetch() : $stmt->fetchAll();
    }
    
    /**
     * Rechercher des articles
     */
    public function search($query, $limit = 10) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur 
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE (a.titre LIKE :query OR a.extrait LIKE :query OR a.contenu LIKE :query) 
                AND a.actif = 1 
                ORDER BY a.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Compter le nombre total d'articles
     */
    public function count() {
        $sql = "SELECT COUNT(*) FROM articles WHERE actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    /**
     * Incrémenter le nombre de vues
     */
    public function incrementViews($id) {
        $sql = "UPDATE articles SET vues = vues + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Créer un nouvel article
     */
    public function create($data) {
        $sql = "INSERT INTO articles (titre, slug, extrait, contenu, image_url, categorie_id, auteur, temps_lecture, vedette, meta_title, meta_description) 
                VALUES (:titre, :slug, :extrait, :contenu, :image_url, :categorie_id, :auteur, :temps_lecture, :vedette, :meta_title, :meta_description)";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':titre' => $data['titre'],
            ':slug' => $data['slug'],
            ':extrait' => $data['extrait'],
            ':contenu' => $data['contenu'],
            ':image_url' => $data['image_url'],
            ':categorie_id' => $data['categorie_id'],
            ':auteur' => $data['auteur'] ?? 'Cadnel DOSSOU (Coach Didi)',
            ':temps_lecture' => $data['temps_lecture'] ?? '5 min',
            ':vedette' => $data['vedette'] ?? 0,
            ':meta_title' => $data['meta_title'] ?? $data['titre'],
            ':meta_description' => $data['meta_description'] ?? $data['extrait']
        ]);
    }
    
    /**
     * Mettre à jour un article
     */
    public function update($id, $data) {
        $sql = "UPDATE articles SET 
                titre = :titre, slug = :slug, extrait = :extrait, contenu = :contenu, 
                image_url = :image_url, categorie_id = :categorie_id, auteur = :auteur, 
                temps_lecture = :temps_lecture, vedette = :vedette, meta_title = :meta_title, 
                meta_description = :meta_description, updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':titre' => $data['titre'],
            ':slug' => $data['slug'],
            ':extrait' => $data['extrait'],
            ':contenu' => $data['contenu'],
            ':image_url' => $data['image_url'],
            ':categorie_id' => $data['categorie_id'],
            ':auteur' => $data['auteur'],
            ':temps_lecture' => $data['temps_lecture'],
            ':vedette' => $data['vedette'],
            ':meta_title' => $data['meta_title'],
            ':meta_description' => $data['meta_description']
        ]);
    }
    
    /**
     * Récupérer un article par son ID
     */
    public function getById($id) {
        $sql = "SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur 
                FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                WHERE a.id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Supprimer un article
     */
    public function delete($id) {
        $sql = "UPDATE articles SET actif = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
