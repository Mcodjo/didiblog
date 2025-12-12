<?php
/**
 * Configuration générale de l'application
 */

// Configuration du site
define('SITE_NAME', 'Emploi Connect - Coach Didi');
define('SITE_URL', 'https://emploiconnect.free.nf'); // Remplacer par votre domaine InfinityFree
define('SITE_DESCRIPTION', 'Blog professionnel d\'employabilité et carrière par Coach Didi');

// Configuration des chemins
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('MODELS_PATH', ROOT_PATH . '/models');
define('CORE_PATH', ROOT_PATH . '/core');
define('ADMIN_PATH', ROOT_PATH . '/admin');

// Configuration de la base de données InfinityFree
define('DB_HOST', 'sql102.infinityfree.com'); // Serveur MySQL InfinityFree
define('DB_NAME', 'if0_39771821_blog_emploi'); // Nom de votre base de données
define('DB_USER', 'if0_39771821'); // Nom d'utilisateur MySQL
define('DB_PASS', 'coachdidi15'); // Mot de passe MySQL

// Configuration de sécurité
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', password_hash('admin123', PASSWORD_DEFAULT));

// Configuration des emails
define('CONTACT_EMAIL', 'coachdidi15@gmail.com');
define('ADMIN_EMAIL', 'coachdidi15@gmail.com');

// Configuration pour hébergement gratuit (InfinityFree)
// Désactiver l'envoi d'emails pour éviter les erreurs SMTP
define('EMAIL_ENABLED', false); // Mettre à true pour activer l'envoi d'emails

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fuseau horaire
date_default_timezone_set('Europe/Paris');

// Gestion des erreurs (désactiver en production)
error_reporting(0); // Désactiver pour InfinityFree
ini_set('display_errors', 0); // Désactiver pour InfinityFree
?>
