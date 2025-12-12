<?php
/**
 * Modèle pour les utilisateurs
 */

class User {
    private $pdo;
    
    public function __construct($database) {
        $this->pdo = $database;
    }
    
    /**
     * Récupérer tous les utilisateurs
     */
    public function getAll($limit = null, $offset = 0, $role = null) {
        $sql = "SELECT id, username, email, role, nom, prenom, last_login, actif, created_at 
                FROM users WHERE 1=1";
        
        $params = [];
        
        if ($role) {
            $sql .= " AND role = :role";
            $params[':role'] = $role;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            if ($key === ':limit' || $key === ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Récupérer un utilisateur par son ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Récupérer un utilisateur par son email
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Récupérer un utilisateur par son username
     */
    public function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, role, nom, prenom, actif) 
                VALUES (:username, :email, :password, :role, :nom, :prenom, :actif)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':role' => $data['role'] ?? 'user',
            ':nom' => $data['nom'] ?? null,
            ':prenom' => $data['prenom'] ?? null,
            ':actif' => $data['actif'] ?? true
        ]);
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];
        
        $allowedFields = ['username', 'email', 'password', 'role', 'nom', 'prenom', 'actif'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Désactiver un utilisateur
     */
    public function deactivate($id) {
        return $this->update($id, ['actif' => false]);
    }
    
    /**
     * Activer un utilisateur
     */
    public function activate($id) {
        return $this->update($id, ['actif' => true]);
    }
    
    /**
     * Mettre à jour la dernière connexion
     */
    public function updateLastLogin($id) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    /**
     * Compter le nombre total d'utilisateurs
     */
    public function count($role = null) {
        $sql = "SELECT COUNT(*) as total FROM users WHERE 1=1";
        $params = [];
        
        if ($role) {
            $sql .= " AND role = :role";
            $params[':role'] = $role;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['total'];
    }
    
    /**
     * Rechercher des utilisateurs
     */
    public function search($query, $limit = 20) {
        $sql = "SELECT id, username, email, role, nom, prenom, actif, created_at 
                FROM users 
                WHERE username LIKE :query 
                   OR email LIKE :query 
                   OR nom LIKE :query 
                   OR prenom LIKE :query 
                ORDER BY created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':query', "%$query%");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Obtenir les statistiques des utilisateurs
     */
    public function getStats() {
        $stats = [];
        
        // Total utilisateurs
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM users");
        $stats['total'] = $stmt->fetch()['total'];
        
        // Utilisateurs actifs
        $stmt = $this->pdo->query("SELECT COUNT(*) as actifs FROM users WHERE actif = 1");
        $stats['actifs'] = $stmt->fetch()['actifs'];
        
        // Nouveaux utilisateurs ce mois
        $stmt = $this->pdo->query("SELECT COUNT(*) as nouveaux FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $stats['nouveaux'] = $stmt->fetch()['nouveaux'];
        
        // Administrateurs
        $stmt = $this->pdo->query("SELECT COUNT(*) as admins FROM users WHERE role = 'admin'");
        $stats['admins'] = $stmt->fetch()['admins'];
        
        // Utilisateurs connectés récemment (7 derniers jours)
        $stmt = $this->pdo->query("SELECT COUNT(*) as recents FROM users WHERE last_login >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stats['recents'] = $stmt->fetch()['recents'];
        
        return $stats;
    }
    
    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $params = [':email' => $email];
        
        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
    
    /**
     * Vérifier si un username existe déjà
     */
    public function usernameExists($username, $excludeId = null) {
        $sql = "SELECT id FROM users WHERE username = :username";
        $params = [':username' => $username];
        
        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
}
?>
