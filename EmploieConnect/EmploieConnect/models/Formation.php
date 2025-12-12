<?php
/**
 * Modèle pour les formations
 */

class Formation {
    private $pdo;
    
    public function __construct($database) {
        $this->pdo = $database;
    }
    
    /**
     * Récupérer toutes les formations
     */
    public function getAll() {
        $sql = "SELECT * FROM formations WHERE actif = 1 ORDER BY ordre ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer une formation par son slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM formations WHERE slug = :slug AND actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Récupérer une formation par son ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM formations WHERE id = :id AND actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Compter le nombre total de formations
     */
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM formations WHERE actif = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Créer une nouvelle formation
     */
    public function create($data) {
        $sql = "INSERT INTO formations (nom, slug, description, prix, prix_promo, duree, niveau, image_url, contenu, objectifs, prerequis, note, nb_etudiants, statut, featured, badge, date_creation, actif, ordre) 
                VALUES (:nom, :slug, :description, :prix, :prix_promo, :duree, :niveau, :image_url, :contenu, :objectifs, :prerequis, :note, :nb_etudiants, :statut, :featured, :badge, :date_creation, 1, 0)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':prix', $data['prix']);
        $stmt->bindValue(':prix_promo', $data['prix_promo']);
        $stmt->bindValue(':duree', $data['duree']);
        $stmt->bindValue(':niveau', $data['niveau']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':contenu', $data['contenu']);
        $stmt->bindValue(':objectifs', $data['objectifs']);
        $stmt->bindValue(':prerequis', $data['prerequis']);
        $stmt->bindValue(':note', $data['note']);
        $stmt->bindValue(':nb_etudiants', $data['nb_etudiants']);
        $stmt->bindValue(':statut', $data['statut']);
        $stmt->bindValue(':featured', $data['featured']);
        $stmt->bindValue(':badge', $data['badge']);
        $stmt->bindValue(':date_creation', $data['date_creation']);
        
        return $stmt->execute();
    }
    
    /**
     * Mettre à jour une formation
     */
    public function update($id, $data) {
        $sql = "UPDATE formations 
                SET nom = :nom, slug = :slug, description = :description, prix = :prix, 
                    prix_promo = :prix_promo, duree = :duree, niveau = :niveau, 
                    image_url = :image_url, contenu = :contenu, objectifs = :objectifs, 
                    prerequis = :prerequis, note = :note, nb_etudiants = :nb_etudiants, 
                    statut = :statut, featured = :featured, badge = :badge 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':prix', $data['prix']);
        $stmt->bindValue(':prix_promo', $data['prix_promo']);
        $stmt->bindValue(':duree', $data['duree']);
        $stmt->bindValue(':niveau', $data['niveau']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':contenu', $data['contenu']);
        $stmt->bindValue(':objectifs', $data['objectifs']);
        $stmt->bindValue(':prerequis', $data['prerequis']);
        $stmt->bindValue(':note', $data['note']);
        $stmt->bindValue(':nb_etudiants', $data['nb_etudiants']);
        $stmt->bindValue(':statut', $data['statut']);
        $stmt->bindValue(':featured', $data['featured']);
        $stmt->bindValue(':badge', $data['badge']);
        
        return $stmt->execute();
    }
    
    /**
     * Supprimer une formation (soft delete)
     */
    public function delete($id) {
        $sql = "UPDATE formations SET actif = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
