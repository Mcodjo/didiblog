<?php
require_once '../config/config.php';
require_once '../core/functions.php';

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();

$message = '';
$messageType = '';

// Gestion des paramètres du site
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'site_settings':
                try {
                    // Mise à jour des paramètres généraux du site
                    $settings = [
                        'site_title' => $_POST['site_title'],
                        'site_description' => $_POST['site_description'],
                        'contact_email' => $_POST['contact_email'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'facebook_url' => $_POST['facebook_url'],
                        'linkedin_url' => $_POST['linkedin_url'],
                        'instagram_url' => $_POST['instagram_url'],
                        'email_enabled' => isset($_POST['email_enabled']) ? '1' : '0'
                    ];
                    
                    foreach ($settings as $key => $value) {
                        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
                        $stmt->execute([$key, $value, $value]);
                    }
                    
                    $message = 'Paramètres du site mis à jour avec succès';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'Erreur lors de la mise à jour des paramètres';
                    $messageType = 'error';
                }
                break;
                
            case 'change_password':
                $currentPassword = $_POST['current_password'];
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];
                
                if ($newPassword !== $confirmPassword) {
                    $message = 'Les nouveaux mots de passe ne correspondent pas';
                    $messageType = 'error';
                } elseif (strlen($newPassword) < 6) {
                    $message = 'Le mot de passe doit contenir au moins 6 caractères';
                    $messageType = 'error';
                } else {
                    try {
                        $stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        $user = $stmt->fetch();
                        
                        if (password_verify($currentPassword, $user['mot_de_passe'])) {
                            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
                            $stmt->execute([$hashedPassword, $_SESSION['user_id']]);
                            
                            $message = 'Mot de passe modifié avec succès';
                            $messageType = 'success';
                        } else {
                            $message = 'Mot de passe actuel incorrect';
                            $messageType = 'error';
                        }
                    } catch (Exception $e) {
                        $message = 'Erreur lors de la modification du mot de passe';
                        $messageType = 'error';
                    }
                }
                break;
        }
    }
}

// Récupération des paramètres actuels
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) {
    $settings = [];
}

// Valeurs par défaut
$defaultSettings = [
    'site_title' => 'Emploi Connect',
    'site_description' => 'Votre partenaire pour réussir votre carrière professionnelle',
    'contact_email' => 'coachdidi15@gmail.com',
    'phone' => '+229 66 68 34 87',
    'address' => 'Bénin',
    'facebook_url' => '',
    'linkedin_url' => '',
    'instagram_url' => '',
    'email_enabled' => '0'
];

foreach ($defaultSettings as $key => $value) {
    if (!isset($settings[$key])) {
        $settings[$key] = $value;
    }
}

$pageTitle = 'Paramètres - Admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .admin-sidebar { min-height: 100vh; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 bg-gray-900 text-white fixed left-0 top-0 z-50">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Admin Panel</h1>
                        <p class="text-gray-400 text-sm">Emploi Connect</p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="<?= SITE_URL ?>/admin/" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-home mr-3"></i>
                        Dashboard
                    </a>
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-newspaper mr-3"></i>
                        Articles
                    </a>
                    <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-tags mr-3"></i>
                        Catégories
                    </a>
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Formations
                    </a>
                    <a href="<?= SITE_URL ?>/admin/newsletter.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-3"></i>
                        Newsletter
                    </a>
                    <a href="<?= SITE_URL ?>/admin/settings.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
                        <i class="fas fa-cog mr-3"></i>
                        Paramètres
                    </a>
                </nav>
                
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <a href="<?= SITE_URL ?>" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt mr-3"></i>
                        Voir le site
                    </a>
                    <a href="<?= SITE_URL ?>/logout.php" class="flex items-center px-4 py-3 text-red-400 hover:bg-red-900/20 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Paramètres</h1>
                        <p class="text-gray-600">Configurez votre site et votre compte</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' ?>">
                    <?= escape($message) ?>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Paramètres du Site -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-globe text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">Paramètres du Site</h3>
                                <p class="text-sm text-gray-600">Informations générales de votre site</p>
                            </div>
                        </div>
                        
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="action" value="site_settings">
                            
                            <div>
                                <label for="site_title" class="block text-sm font-medium text-gray-700 mb-2">Titre du site</label>
                                <input type="text" id="site_title" name="site_title" required
                                       value="<?= escape($settings['site_title']) ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div>
                                <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea id="site_description" name="site_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"><?= escape($settings['site_description']) ?></textarea>
                            </div>
                            
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email de contact</label>
                                <input type="email" id="contact_email" name="contact_email" required
                                       value="<?= escape($settings['contact_email']) ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="text" id="phone" name="phone"
                                       value="<?= escape($settings['phone']) ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input type="text" id="address" name="address"
                                       value="<?= escape($settings['address']) ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div class="border-t pt-4">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Réseaux Sociaux</h4>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                                        <input type="url" id="facebook_url" name="facebook_url"
                                               value="<?= escape($settings['facebook_url']) ?>"
                                               placeholder="https://facebook.com/votrepage"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    </div>
                                    
                                    <div>
                                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                                        <input type="url" id="linkedin_url" name="linkedin_url"
                                               value="<?= escape($settings['linkedin_url']) ?>"
                                               placeholder="https://linkedin.com/in/votrepage"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    </div>
                                    
                                    <div>
                                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                                        <input type="url" id="instagram_url" name="instagram_url"
                                               value="<?= escape($settings['instagram_url']) ?>"
                                               placeholder="https://instagram.com/votrepage"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t pt-4">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Configuration Email</h4>
                                <div class="flex items-center">
                                    <input type="checkbox" id="email_enabled" name="email_enabled" value="1" 
                                           <?= $settings['email_enabled'] === '1' ? 'checked' : '' ?>
                                           class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500">
                                    <label for="email_enabled" class="ml-2 text-sm text-gray-700">
                                        Activer l'envoi d'emails (désactiver pour hébergement gratuit)
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Décochez cette option si vous utilisez un hébergement gratuit comme InfinityFree
                                </p>
                            </div>
                            
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Sauvegarder les paramètres
                            </button>
                        </form>
                    </div>

                    <!-- Sécurité -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lock text-red-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">Sécurité</h3>
                                <p class="text-sm text-gray-600">Modifiez votre mot de passe</p>
                            </div>
                        </div>
                        
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="action" value="change_password">
                            
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password" id="new_password" name="new_password" required minlength="6"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <p class="text-xs text-gray-500 mt-1">Minimum 6 caractères</p>
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                                <input type="password" id="confirm_password" name="confirm_password" required minlength="6"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Modifier le mot de passe
                            </button>
                        </form>
                        
                        <!-- Informations système -->
                        <div class="mt-8 pt-6 border-t">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Informations Système</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Version PHP:</span>
                                    <span><?= phpversion() ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Serveur:</span>
                                    <span><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Base de données:</span>
                                    <span>MySQL</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Dernière connexion:</span>
                                    <span><?= date('d/m/Y H:i') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Validation du formulaire de mot de passe
        document.querySelector('form[action*="change_password"]').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas');
            }
        });
    </script>

</body>
</html>
