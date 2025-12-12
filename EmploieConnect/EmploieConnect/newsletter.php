<?php
require_once 'config/config.php';
require_once 'core/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');
    $source = cleanInput($_POST['source'] ?? 'unknown');
    
    if (empty($email)) {
        setFlashMessage('error', 'Veuillez entrer votre adresse email.');
        redirect($_SERVER['HTTP_REFERER'] ?? SITE_URL);
    }
    
    if (!isValidEmail($email)) {
        setFlashMessage('error', 'Veuillez entrer une adresse email valide.');
        redirect($_SERVER['HTTP_REFERER'] ?? SITE_URL);
    }
    
    try {
        $pdo = getDatabase();
        
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM newsletter WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        if ($stmt->fetch()) {
            setFlashMessage('info', 'Cette adresse email est déjà inscrite à notre newsletter.');
        } else {
            // Insérer le nouvel abonné
            $stmt = $pdo->prepare("INSERT INTO newsletter (email, source) VALUES (:email, :source)");
            $stmt->execute([
                ':email' => $email,
                ':source' => $source
            ]);
            
            setFlashMessage('success', 'Merci ! Vous êtes maintenant inscrit(e) à notre newsletter.');
            
            // Envoyer un email de bienvenue
            $subject = 'Bienvenue dans la communauté Emploi Connect !';
            $message = "
            <h2>Bienvenue dans la communauté Emploi Connect !</h2>
            <p>Merci de t'être inscrit(e) à notre newsletter. Tu vas maintenant recevoir nos meilleurs conseils pour décrocher l'emploi de tes rêves directement dans ta boîte mail.</p>
            <p>En attendant, voici quelques ressources pour commencer :</p>
            <ul>
                <li><a href='" . SITE_URL . "/guide-gratuit.php'>Télécharge ton guide gratuit</a></li>
                <li><a href='" . SITE_URL . "/blog.php'>Explore nos articles</a></li>
                <li><a href='" . SITE_URL . "/formations.php'>Découvre nos formations</a></li>
            </ul>
            <p>À très bientôt,<br>Coach Didi</p>
            ";
            
            sendEmail($email, $subject, $message);
        }
    } catch (Exception $e) {
        setFlashMessage('error', 'Une erreur est survenue. Veuillez réessayer.');
    }
} else {
    setFlashMessage('error', 'Méthode non autorisée.');
}

redirect($_SERVER['HTTP_REFERER'] ?? SITE_URL);
?>
