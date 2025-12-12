-- Base de données pour Blog Emploi Connect
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog_emploi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blog_emploi;

-- Table des catégories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icone VARCHAR(50),
    couleur VARCHAR(7) DEFAULT '#f97316',
    ordre INT DEFAULT 0,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    extrait TEXT,
    contenu LONGTEXT,
    image_url VARCHAR(500),
    categorie_id INT,
    auteur VARCHAR(100) DEFAULT 'Cadnel DOSSOU (Coach Didi)',
    temps_lecture VARCHAR(20) DEFAULT '5 min',
    vedette BOOLEAN DEFAULT FALSE,
    actif BOOLEAN DEFAULT TRUE,
    vues INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_categorie (categorie_id),
    INDEX idx_vedette (vedette),
    INDEX idx_actif (actif)
);

-- Table des commentaires
CREATE TABLE comments (
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
);

-- Table des partages sociaux
CREATE TABLE social_shares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    platform VARCHAR(50) NOT NULL,
    share_count INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_article_platform (article_id, platform),
    INDEX idx_article (article_id)
);

-- Table des formations
CREATE TABLE formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    contenu LONGTEXT,
    image_url VARCHAR(500),
    prix DECIMAL(10,2),
    prix_barre DECIMAL(10,2),
    duree VARCHAR(50),
    niveau VARCHAR(50),
    badge VARCHAR(100),
    couleur_badge VARCHAR(7) DEFAULT '#10b981',
    etudiants INT DEFAULT 0,
    note DECIMAL(2,1) DEFAULT 5.0,
    actif BOOLEAN DEFAULT TRUE,
    ordre INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_actif (actif)
);

-- Table des témoignages
CREATE TABLE temoignages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    poste VARCHAR(150),
    entreprise VARCHAR(150),
    photo_url VARCHAR(500),
    contenu TEXT NOT NULL,
    note INT DEFAULT 5,
    formation_id INT NULL,
    actif BOOLEAN DEFAULT TRUE,
    ordre INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE SET NULL,
    INDEX idx_actif (actif),
    INDEX idx_formation (formation_id)
);

-- Table des contacts
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(100) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    statut VARCHAR(50),
    besoin VARCHAR(100),
    message TEXT NOT NULL,
    traite BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_traite (traite),
    INDEX idx_email (email)
);

-- Table des inscriptions newsletter
CREATE TABLE newsletter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    source VARCHAR(100) DEFAULT 'Site web',
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_actif (actif)
);

-- Table des guides téléchargeables
CREATE TABLE guides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NOT NULL,
    downloads INT DEFAULT 0,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_actif (actif),
    INDEX idx_created (created_at)
);

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    phone VARCHAR(20),
    bio TEXT,
    avatar_url VARCHAR(500),
    email_verified BOOLEAN DEFAULT FALSE,
    last_login TIMESTAMP NULL,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_actif (actif)
);

-- Table des pages statiques
CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    contenu LONGTEXT,
    meta_title VARCHAR(255),
    meta_description TEXT,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_actif (actif)
);

-- Table des statistiques
CREATE TABLE statistiques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    valeur VARCHAR(50) NOT NULL,
    icone VARCHAR(50),
    couleur VARCHAR(7) DEFAULT '#f97316',
    description VARCHAR(255),
    ordre INT DEFAULT 0,
    actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user',
    actif BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table pour la réinitialisation des mots de passe
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_expires (expires_at)
);

-- Insertion des données initiales

-- Catégories
INSERT INTO categories (nom, slug, description, icone, couleur, ordre) VALUES
('CV et Lettres', 'cv-lettres', 'Conseils pour optimiser votre CV et lettres de motivation', 'fas fa-file-alt', '#f97316', 1),
('Entretiens', 'entretiens', 'Techniques pour réussir vos entretiens d\'embauche', 'fas fa-handshake', '#3b82f6', 2),
('LinkedIn et Réseautage', 'linkedin-reseautage', 'Optimisation LinkedIn et stratégies de networking', 'fab fa-linkedin', '#0077b5', 3),
('Recherche d\'emploi', 'recherche-emploi', 'Méthodes et stratégies de recherche d\'emploi', 'fas fa-search', '#10b981', 4),
('Formations', 'formations', 'Formations et développement professionnel', 'fas fa-graduation-cap', '#8b5cf6', 5);

-- Articles
INSERT INTO articles (titre, slug, extrait, contenu, image_url, categorie_id, temps_lecture, vedette) VALUES
('Comment rédiger un CV qui décroche des entretiens ?', 'cv-qui-decroche-entretiens', 'Découvre les secrets d\'un CV efficace qui attire l\'attention des recruteurs et décroche des entretiens.', 
'<h2>Les fondamentaux d\'un CV efficace</h2><p>Un CV efficace doit avant tout être <strong>clair, concis et adapté</strong> au poste visé. Voici les éléments essentiels...</p><h3>1. Structure et mise en page</h3><p>La première impression compte énormément. Votre CV doit être visuellement attractif tout en restant professionnel.</p><h3>2. Contenu pertinent</h3><p>Chaque information doit apporter de la valeur et être en lien avec le poste recherché.</p>', 
'https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1, '8 min', TRUE),

('Réussir son entretien d\'embauche : les 7 questions clés', 'reussir-entretien-embauche', 'Prépare-toi aux questions les plus fréquentes en entretien et apprends à convaincre ton recruteur.', 
'<h2>Les 7 questions incontournables</h2><p>Chaque entretien comporte des questions récurrentes qu\'il faut absolument maîtriser...</p>', 
'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 2, '6 min', FALSE),

('Optimiser ton profil LinkedIn en 30 minutes', 'optimiser-profil-linkedin', 'Transforme ton profil LinkedIn en véritable aimant à opportunités avec ces conseils pratiques.', 
'<h2>L\'importance d\'un profil LinkedIn optimisé</h2><p>LinkedIn est devenu incontournable dans la recherche d\'emploi...</p>', 
'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 3, '7 min', FALSE),

('Les 5 étapes pour décrocher un stage rapidement', 'decrocher-stage-rapidement', 'Méthode éprouvée pour trouver et décrocher le stage de tes rêves en un temps record.', 
'<h2>Stratégie en 5 étapes</h2><p>Décrocher un stage demande une approche méthodique et stratégique...</p>', 
'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 4, '5 min', FALSE),

('Reconversion professionnelle : le guide complet', 'reconversion-professionnelle-guide', 'Tout ce qu\'il faut savoir pour réussir sa reconversion professionnelle étape par étape.', 
'<h2>Pourquoi se reconvertir ?</h2><p>La reconversion professionnelle est devenue courante dans nos carrières...</p>', 
'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 5, '12 min', FALSE);

-- Formations
INSERT INTO formations (nom, slug, description, contenu, image_url, prix, prix_barre, duree, niveau, badge, couleur_badge, etudiants, note, ordre) VALUES
('CV Gagnant : Décroche des Entretiens', 'cv-gagnant', 'Maîtrise l\'art du CV parfait avec mes techniques éprouvées. Modèles exclusifs, optimisation ATS et stratégies pour te démarquer.', 
'<h3>Ce que tu apprendras :</h3><ul><li>Les 7 sections indispensables d\'un CV moderne</li><li>Comment optimiser ton CV pour les systèmes ATS</li><li>5 modèles de CV exclusifs prêts à utiliser</li><li>Techniques pour quantifier tes réalisations</li></ul>', 
'https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 97.00, 147.00, '3h de contenu', 'Débutant', 'BESTSELLER', '#10b981', 2500, 4.9, 1),

('Entretien Champion : Convaincre à Coup Sûr', 'entretien-champion', 'Maîtrise tous les types d\'entretiens avec mes techniques avancées. Simulations réelles, préparation mentale et stratégies.', 
'<h3>Ce que tu apprendras :</h3><ul><li>Préparer et réussir 12 types d\'entretiens différents</li><li>Répondre aux 50 questions les plus fréquentes</li><li>Techniques de communication non-verbale</li><li>Négocier ton salaire avec confiance</li></ul>', 
'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 127.00, 197.00, '4h de contenu', 'Intermédiaire', 'NOUVEAU', '#3b82f6', 1800, 4.8, 2),

('Pack Emploi Total : De 0 à Embauché', 'pack-vip', 'Formation complète + coaching personnalisé + garantie emploi sous 90 jours ou remboursé !', 
'<h3>Contenu inclus :</h3><ul><li>Toutes les formations (CV + Entretien)</li><li>Formation LinkedIn Mastery (exclusive)</li><li>Kit de 50+ modèles prêts à utiliser</li><li>3 sessions de coaching 1-on-1</li><li>Support WhatsApp prioritaire</li></ul>', 
'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 397.00, 697.00, '10h+ contenu', 'Tous niveaux', 'PACK VIP', '#f59e0b', 850, 4.9, 3);

-- Témoignages
INSERT INTO temoignages (nom, poste, entreprise, photo_url, contenu, note, ordre) VALUES
('Sarah M.', 'Marketing Manager', 'TechCorp', 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80', 'Grâce à la formation CV de Coach Didi, j\'ai décroché 3 entretiens en une semaine ! Son approche est concrète et efficace. Embauchée après 2 semaines de recherche !', 5, 1),
('Alexandre L.', 'Développeur Full Stack', 'StartupTech', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80', 'La formation entretien m\'a donné une confiance incroyable ! J\'ai négocié un salaire 30% plus élevé que prévu. Merci Coach Didi pour ces techniques géniales !', 5, 2),
('Marie K.', 'Chef de Projet', 'ConsultingPro', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80', 'Le Pack VIP a changé ma vie ! Accompagnement personnalisé, résultats garantis. J\'ai trouvé mon CDI de rêve en 6 semaines. Investissement rentabilisé x10 !', 5, 3);

-- Statistiques
INSERT INTO statistiques (nom, valeur, icone, couleur, description, ordre) VALUES
('Étudiants accompagnés', '500+', 'fas fa-users', '#f97316', 'Jeunes diplômés et chercheurs d\'emploi', 1),
('Taux de réussite', '85%', 'fas fa-chart-line', '#3b82f6', 'Trouvent un emploi en moins de 3 mois', 2),
('Articles publiés', '150+', 'fas fa-book-open', '#10b981', 'Guides et conseils d\'experts', 3),
('Partenaires', '50+', 'fas fa-star', '#8b5cf6', 'Entreprises et organismes de formation', 4);

-- Table des paramètres du site
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
);

-- Paramètres par défaut
INSERT INTO settings (setting_key, setting_value) VALUES
('site_title', 'Emploi Connect'),
('site_description', 'Votre partenaire pour réussir votre carrière professionnelle'),
('contact_email', 'contact@emploiconnect.com'),
('phone', '+33 1 23 45 67 89'),
('address', 'Paris, France'),
('facebook_url', ''),
('linkedin_url', ''),
('instagram_url', '');

-- Utilisateur admin par défaut
INSERT INTO users (username, email, password, nom, prenom, role) VALUES
('admin', 'admin@emploiconnect.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'DOSSOU', 'Cadnel', 'admin');
