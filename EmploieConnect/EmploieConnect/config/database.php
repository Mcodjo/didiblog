<?php
/**
 * Configuration de la base de données
 */

class Database {
    private $host = 'sql102.infinityfree.com';
    private $db_name = 'if0_39771821_blog_emploi';
    private $username = 'if0_39771821';
    private $password = 'coachdidi15';
    private $charset = 'utf8mb4';
    private $pdo;

    public function getConnection() {
        $this->pdo = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Erreur de connexion: " . $e->getMessage();
        }
        
        return $this->pdo;
    }
}
?>
