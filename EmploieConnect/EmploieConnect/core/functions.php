<?php
/**
 * Fonctions utilitaires pour le blog
 */

require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/database.php';
require_once __DIR__ . '/../config/email.php';

// PHPMailer imports
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Obtenir une connexion à la base de données
 */
function getDatabase() {
    $database = new Database();
    return $database->getConnection();
}

/**
 * Échapper les données pour l'affichage HTML
 */
function escape($data) {
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Générer un slug à partir d'un titre
 */
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Formater une date en français
 */
function formatDate($date, $format = 'd F Y') {
    $months = [
        'January' => 'janvier', 'February' => 'février', 'March' => 'mars',
        'April' => 'avril', 'May' => 'mai', 'June' => 'juin',
        'July' => 'juillet', 'August' => 'août', 'September' => 'septembre',
        'October' => 'octobre', 'November' => 'novembre', 'December' => 'décembre'
    ];
    
    $formatted = date($format, strtotime($date));
    return str_replace(array_keys($months), array_values($months), $formatted);
}

/**
 * Calculer le temps de lecture estimé
 */
function calculateReadingTime($content) {
    $wordCount = str_word_count(strip_tags($content));
    $minutes = ceil($wordCount / 200); // 200 mots par minute
    return $minutes . ' min';
}

/**
 * Tronquer un texte
 */
function truncateText($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Vérifier si l'utilisateur est un administrateur
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Rediriger vers une page
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Afficher un message flash
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Récupérer et supprimer un message flash
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Générer le breadcrumb
 */
function generateBreadcrumb($items) {
    $breadcrumb = '<nav aria-label="breadcrumb" class="mb-6">';
    $breadcrumb .= '<ol class="flex space-x-2 text-sm text-gray-600 dark:text-gray-400">';
    
    foreach ($items as $index => $item) {
        $isLast = $index === count($items) - 1;
        
        if ($isLast) {
            $breadcrumb .= '<li class="text-orange-600 font-medium">' . escape($item['title']) . '</li>';
        } else {
            $breadcrumb .= '<li><a href="' . escape($item['url']) . '" class="hover:text-orange-600">' . escape($item['title']) . '</a></li>';
            $breadcrumb .= '<li class="text-gray-400">/</li>';
        }
    }
    
    $breadcrumb .= '</ol></nav>';
    return $breadcrumb;
}

/**
 * Générer les meta tags SEO
 */
function generateMetaTags($title, $description, $image = null, $url = null) {
    $siteName = SITE_NAME;
    $siteUrl = SITE_URL;
    
    if ($url) {
        $fullUrl = $siteUrl . $url;
    } else {
        $fullUrl = $siteUrl . $_SERVER['REQUEST_URI'];
    }
    
    $meta = "
    <title>" . escape($title) . " | " . escape($siteName) . "</title>
    <meta name=\"description\" content=\"" . escape($description) . "\">
    <meta property=\"og:title\" content=\"" . escape($title) . "\">
    <meta property=\"og:description\" content=\"" . escape($description) . "\">
    <meta property=\"og:url\" content=\"" . escape($fullUrl) . "\">
    <meta property=\"og:type\" content=\"website\">
    <meta property=\"og:site_name\" content=\"" . escape($siteName) . "\">
    <meta name=\"twitter:card\" content=\"summary_large_image\">
    <meta name=\"twitter:title\" content=\"" . escape($title) . "\">
    <meta name=\"twitter:description\" content=\"" . escape($description) . "\">";
    
    if ($image) {
        $meta .= "
    <meta property=\"og:image\" content=\"" . escape($image) . "\">
    <meta name=\"twitter:image\" content=\"" . escape($image) . "\">";
    }
    
    return $meta;
}

/**
 * Envoyer un email avec PHPMailer
 * Compatible avec hébergement gratuit (InfinityFree) - emails désactivables
 */
function sendEmail($to, $subject, $message, $from = null) {
    // Vérifier si l'envoi d'emails est activé via la base de données
    try {
        $pdo = getDatabase();
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'email_enabled'");
        $stmt->execute();
        $result = $stmt->fetch();
        $emailEnabled = $result ? $result['setting_value'] === '1' : false;
    } catch (Exception $e) {
        // Si erreur DB, utiliser la constante par défaut
        $emailEnabled = defined('EMAIL_ENABLED') ? EMAIL_ENABLED : false;
    }
    
    if (!$emailEnabled) {
        // Mode désactivé : simuler l'envoi et logger
        error_log("EMAIL SIMULÉ - À: $to, Sujet: $subject");
        return true; // Retourner true pour ne pas casser le flux
    }
    
    if (!$from) {
        $from = FROM_EMAIL;
    }
    
    $mail = new PHPMailer(true);
    
    try {
        // Configuration SMTP depuis le fichier de config
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';
        
        // Expéditeur et destinataire
        $mail->setFrom($from, FROM_NAME);
        $mail->addAddress($to);
        
        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'email: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Valider une adresse email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Nettoyer les données d'entrée
 */
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    // Ne pas encoder les caractères spéciaux ici - sera fait à l'affichage avec escape()
    return $data;
}

/**
 * Générer un token CSRF
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifier un token CSRF
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
