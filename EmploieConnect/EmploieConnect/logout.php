<?php
require_once 'config/config.php';
require_once 'core/functions.php';

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil avec un message
setFlashMessage('success', 'Vous avez été déconnecté avec succès.');
redirect(SITE_URL);
?>
