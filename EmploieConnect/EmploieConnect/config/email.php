<?php
/**
 * Configuration email pour PHPMailer
 */

// Configuration SMTP - Modifiez ces valeurs selon votre fournisseur
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'lagoyehans@gmail.com'); // Remplacez par votre email
define('SMTP_PASSWORD', 'dbjyxqainjurgaxj'); // Remplacez par votre mot de passe d'application
define('SMTP_ENCRYPTION', 'tls'); // 'tls' ou 'ssl'

// Informations de l'expéditeur
define('FROM_EMAIL', 'coachdidi15@gmail.com');
define('FROM_NAME', 'Emploi Connect');

/**
 * Instructions pour configurer Gmail:
 * 
 * 1. Activez l'authentification à 2 facteurs sur votre compte Google
 * 2. Générez un mot de passe d'application:
 *    - Allez dans Paramètres Google > Sécurité > Mots de passe d'application
 *    - Sélectionnez "Autre" et nommez-le "Emploi Connect"
 *    - Utilisez ce mot de passe généré dans SMTP_PASSWORD
 * 
 * 3. Remplacez SMTP_USERNAME par votre adresse Gmail
 * 
 * Pour d'autres fournisseurs (OVH, Outlook, etc.), modifiez:
 * - SMTP_HOST (ex: ssl0.ovh.net pour OVH)
 * - SMTP_PORT (ex: 465 pour SSL, 587 pour TLS)
 * - SMTP_ENCRYPTION ('ssl' ou 'tls')
 */
?>
